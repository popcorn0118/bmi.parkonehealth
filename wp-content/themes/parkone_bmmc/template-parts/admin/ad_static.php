<?php

// echo $_SERVER["PHP_SELF"];
$page_url = admin_url( "admin.php?page=parkone_ad" );
$parkone_ad_qrcode_txt = json_decode(get_option("parkone_ad_qrcode_txt"), true);

class Parkone_Ad_Static_Table extends WP_List_Table {
    private $ad_data = array();

    function column_default( $item, $column_name ) {
        switch( $column_name ) {
            case 'date':
            case 'ad_src_txt':
            case 'count':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ;
        }
    }

    function get_columns(){
        $columns = array(
            'date' => '日期',
            'ad_src_txt' => '廣告來源',
            'count' => '次數',
        );
        return $columns;
    }

    function set_data($data){
        $this->ad_data = $data;
    }

    function prepare_items(){
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $this->ad_data;
    }
}

$sql = "SELECT COUNT(*) AS `count`, `ad_src`, DATE(`access_dt`) AS `date` FROM `wp_ad_src_static` ";

$start_dt = $end_dt = "";

// 處理搜尋參數
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])){
    $start_dt = $_POST['start_date'];
    $end_dt = $_POST['end_date'];
} else {
    $start_dt = date("Y-m-d", time()-(86400*7));
    $end_dt = date("Y-m-d", time());
}

$sql.= "WHERE `access_dt` BETWEEN '{$start_dt} 00:00:00' AND '{$end_dt} 23:59:59' ";

$sql .= "GROUP BY DATE(`access_dt`),`ad_src` ORDER BY DATE(`access_dt`) DESC;";

// echo "<p>",$sql,"</p>";

$ad_data = [];
$results = $wpdb->get_results($sql);
foreach($results as $result){
    $ad_data[] = ["date" => $result->date, "ad_src" => $result->ad_src, "ad_src_txt" => $parkone_ad_qrcode_txt[$result->ad_src], "count" => $result->count];
}

// 準備折線圖用的資料
$tmp_ad_data = array_reverse($ad_data);
$ad_total = [];
// echo "<pre>", var_dump($tmp_ad_data),"</pre>";
$ad_count = count($parkone_ad_qrcode_txt);
$ad_keys = array_flip(array_keys($parkone_ad_qrcode_txt));
$ad_values = array_values($parkone_ad_qrcode_txt);
array_unshift($ad_values , 'date');
// echo "<pre>", var_dump($ad_keys),"</pre>";
// echo "<pre>", var_dump($ad_values),"</pre>";
$ad_chart_data = [];
$f_ad_chart_data = [$ad_values];
$f_ad_chart_data_total = [['date', '總計']];
foreach($tmp_ad_data as $data){
    if(!isset($ad_chart_data[$data["date"]])){
        $ad_chart_data[$data["date"]][0] = $data["date"];
        for($i = 0; $i < $ad_count; $i++){
            $ad_chart_data[$data["date"]][$i+1] = 0;
        }        
    }
    if(!isset($ad_total[$data["date"]])){
        $ad_total[$data["date"]] = 0;
    }
    $ad_total[$data["date"]] += intval($data["count"]);
    $ad_chart_data[$data["date"]][$ad_keys[$data["ad_src"]]+1] = intval($data["count"]);
}

foreach($ad_chart_data as $data){
    $f_ad_chart_data[] = $data;
}

foreach($ad_total as $k => $v){
    $f_ad_chart_data_total[] = [$k, $v];
}

$f_ad_chart_data_json = json_encode($f_ad_chart_data,JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE);
$f_ad_chart_data_total_json = json_encode($f_ad_chart_data_total,JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE);

// echo "<pre>",var_dump($f_ad_chart_data_json),"</pre>";
// echo "<pre>",var_dump($ad_total),"</pre>";
?>

<form id="search" method="post" action="admin.php?page=parkone_ad">
    <div style="margin: 10px;">
        <button type="button" id="BtnSearchThisMonth">本月</button>
        <button type="button" id="BtnSearchLastMonth">上個月</button>
    </div>
    <div style="margin: 10px;">
        <label for="start_date">起始日期</label><input type="date" name="start_date" id="start_date" value=<?=$start_dt;?>>
        <label for="end_date">結束日期</label><input type="date" name="end_date" id="end_date" value=<?=$end_dt;?>>
    </div>
    <div>
        <input type="submit" id="BtnSearch" class="button" name="search" value="搜尋">
    </div>
</form>
<hr />

<div id="chart_div"></div>
<div id="chart_div_total"></div>

<?php

// echo "<pre>",var_dump($results),"</pre>";
$ad_table = new Parkone_Ad_Static_Table();
$ad_table->set_data($ad_data);
$ad_table->prepare_items();
$ad_table->Display();
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    jQuery("#BtnSearchThisMonth").on("click", function(){
        let first_day_this_month_dt = "<?=date("Y-m-01")?>";
        let last_day_this_month_dt = "<?=date("Y-m-t")?>";
        jQuery("#start_date").val(first_day_this_month_dt);
        jQuery("#end_date").val(last_day_this_month_dt);
        jQuery("#BtnSearch").click();
    });

    jQuery("#BtnSearchLastMonth").on("click", function(){
        let first_day_last_month_dt = "<?=date("Y-m-d", strtotime("first day of previous month"))?>";
        let last_day_last_month_dt = "<?=date("Y-m-d", strtotime("last day of previous month"))?>";
        jQuery("#start_date").val(first_day_last_month_dt);
        jQuery("#end_date").val(last_day_last_month_dt);
        jQuery("#BtnSearch").click();
    });

    google.charts.load('current', {packages: ['corechart', 'line']});
    google.charts.setOnLoadCallback(drawCurveTypes);
    function drawCurveTypes() {
        var data = google.visualization.arrayToDataTable(<?=$f_ad_chart_data_json?>);
        var options = {
          title: '廣告次數分布',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);

        var data_total = google.visualization.arrayToDataTable(<?=$f_ad_chart_data_total_json?>);
        var options_total = {
          title: '廣告次數總計',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart_total = new google.visualization.LineChart(document.getElementById('chart_div_total'));
        chart_total.draw(data_total, options_total);
    }
</script>