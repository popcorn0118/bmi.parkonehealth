<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $post_parkone_ad_qrcode_txt = [];
    $count = count($_POST["key"]);
    for($i = 0; $i < $count; $i++){
        if(!empty($_POST["key"][$i])){
            $post_parkone_ad_qrcode_txt[$_POST["key"][$i]] = $_POST["value"][$i];
        }
    }
    update_option("parkone_ad_qrcode_txt", json_encode($post_parkone_ad_qrcode_txt));
}
?>

<h1>廣告代碼設定</h1>
<button type=button id=btn_add_qrcode>新增廣告代碼</button>

<form method=post action=<?=$page_url?>>
<table>
    <thead>
        <tr><th>代碼</th><th>名稱</th></tr>
    </thead>
    <tbody>
<?php
$parkone_ad_qrcode_txt = json_decode(get_option("parkone_ad_qrcode_txt"), true);
// echo "<pre>", var_dump($parkone_ad_qrcode_txt),"</pre>";

if(is_array($parkone_ad_qrcode_txt)){
    foreach($parkone_ad_qrcode_txt as $key => $value):
        ?>
        <tr><td><input type=text name=key[] value=<?=$key?>></td><td><input type=text name=value[] value=<?=$value?>></td></tr>
        <?php
    endforeach;
}
?>
</tbody>
</table>
<button type=submit>儲存</button>
</form>

<script>
    jQuery("#btn_add_qrcode").on("click", function(){
        jQuery("tbody").append("<tr><td><input type=text name=key[] ></td><td><input type=text name=value[] ></td></tr>");
    });
</script>