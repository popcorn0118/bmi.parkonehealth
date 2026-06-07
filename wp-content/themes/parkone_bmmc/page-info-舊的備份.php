<?php
/**
 * 看診資訊
 */
get_header();
get_template_part( 'template-parts/header', '' );

function  get_chinese_weekday ($datetime) {
    $ch_weekday =  $datetime->format('w');
    return  '星期' . [ '日', '一' , '二' , '三' , '四' , '五' , '六' ] [ $ch_weekday ] ;
}

$schedule_setting = get_field('schedule');

$weekday = array();
if(date('D', time()) === 'Mon'){
    for($i = 0; $i < 7; $i ++){
        $weekday[$i] = new DateTime("today");
        $weekday[$i]->modify('+'.$i.' day');
    }
}else {
    for($i = 0; $i < 7; $i ++){
        $weekday[$i] = new DateTime("last Monday");
        $weekday[$i]->modify('+'.$i.' day');
    }
}

$doctors = get_posts(array(
    'post_type' => 'team',
    'numberposts' => -1,
    'order'     => 'ASC'
));

$reservable_doctor_days = array();
foreach($doctors as $index => $doctor){
    $doctor_days = get_field('doctor_data_reservable', $doctor->ID);
    // 可掛號時段連結
    if(is_array($doctor_days)){
        foreach($doctor_days as $day){
            $day_index = $day['weekday']['value'] - 1;
            $time_zone = $day['time_zone']['value'];
            array_push($reservable_doctor_days, array(
                'day' => $day,
                'day_index' => $day_index,
                'time_zone' => $time_zone,
                'doctor' => $doctor,
            ));
        }
    }
}

function match_day_doctors ($reservable_doctor_days, $day_index, $time_zone) {
    foreach($reservable_doctor_days as $day){
        if($day_index == $day['day_index'] && $time_zone == $day['time_zone']){
            $reserve_data = get_reserve_data($day['doctor'], $day['day'], $day_index, $time_zone);
            $doctorName = explode(' ', $day['doctor']->post_title);
            $result_btn = '';
            $result_btn .= '<a href="'.$reserve_data['url'].'" class="schedule-reserve-btn" target="_blank" ';
            $result_btn .= 'data-timestamp="'.$reserve_data['timestamp'].'" data-weekday="'.($day_index + 1).'">';
            $result_btn .= $doctorName[0].'<br />'.$doctorName[1].'<span>掛號<hr />'.$doctorName[0].'</span>';
            $result_btn .= '</a>';
            return $result_btn;
        }
    }
}

function get_reserve_data($doctor, $day, $day_index, $time_zone){
    if(date('D', time()) === 'Mon'){
        $reserve_day = new DateTime("today");
    }else {
        $reserve_day = new DateTime("last Monday");
    }
    $fix_hours = 4;
    switch($time_zone){
        case 2:
            $fix_hours = 9;
            break;
        case 3:
            $fix_hours = 13;
            break;
    }

    $reserve_day->modify('+'.$day_index.' day '. $fix_hours .'hours');
    $view_date =  ($reserve_day->format('Y')-1911).$reserve_day->format('md');
    // echo $reserve_day->format('D M d Y H:i:s O');
    $reserve_array = array(
        'viewDate' => $view_date,
        'apn'      => $day['time_zone']['value'],
        'doctorNo' => $doctor->doctor_data_sys_number,
        'zone'     => 'A',
        'clinicNo' => $day['clinic']['value'],
        'doctorName' => explode(' ', $doctor->post_title)[0],
        'clinicName' => $day['clinic']['label'],
        'divNo'      => $day['div']['value'],
        'divName'    => $day['div']['label'],
    );

    $park_url = 'https://webreg.parkonehealth.com/#/regtan?';
    foreach($reserve_array as $key => $value):
        $park_url .= $key.'='.$value.'&';
    endforeach;

    return array(
        'url' => $park_url,
        'timestamp' => $reserve_day->getTimestamp().'000',
    );
}

?>
<main id="page_info" class="page bg-white-60 bg-blur">
    <?php if ( have_posts() ) : ?>
    <section class="pt-16 pb-30 pb-sm-10">
        <div class="container max-w-1200">
            <div class="text-center mb-10">
                <h6 class="mb-2 fs-sm-xxs"><?= $schedule_setting['title_en'] ?></h6>
                <h2 class="mb-0 fs-sm-ml"><?= $schedule_setting['title'] ?></h2>
            </div>
            <?php if ( get_field('top_sec') ): ?>
            <div class="d-none d-md-block mb-16">
                <?= get_field('top_sec_content_lg') ?>
            </div>
            <div class="d-md-none mb-16">
                <?= get_field('top_sec_content_sm') ?>
            </div>
            <?php endif ?>
            <div id="info_schedule" class="schedule-wrap">
                <div class="d-flex align-center justify-between mb-10">
                    <button class="schedule-btn-prev"><span class="icon-arrow-prev"></span></button>
                    <div class="text-center">
                        <p class="fs-ml d-none d-md-block"><?= $schedule_setting['desc'] ?></p>
                        <h3 class="mb-0 schedule-weekday fs-sm-xs fw-normal"><?= ($weekday[0]->format('Y')-1911).$weekday[0]->format('/m/d') ?> - <?= ($weekday[6]->format('Y')-1911).$weekday[6]->format('/m/d') ?></h3>
                    </div>
                    <button class="schedule-btn-next"><span class="icon-arrow-next"></span></button>
                </div>
                <div class="pko-table-wrap">
                    <div class="pko-table-nav d-md-none">
                        <button class="pko-table-btn-prev"><span class="icon-arrow-prev"></span></button>
                        <button class="pko-table-btn-next"><span class="icon-arrow-next"></span></button>
                    </div>
                    <div class="schedule pko-table">
                        <div class="pko-thead">
                            <div class="pko-tr">
                                <div class="pko-th"></div>
                                <?php foreach($weekday as $day): ?>
                                <div class="pko-th"><span class="schedule-day"><?= $day->format('m/d') ?></span><br /><?= get_chinese_weekday($day) ?></div>
                                <?php endforeach ?>
                            </div>
                        </div>
                        <div class="pko-tbody">
                            <div class="pko-tr">
                                <div class="pko-th">08：30<br /> | <br />12：00</div>
                                <?php foreach($weekday as $day): ?>
                                <div class="pko-td">
                                    <?= match_day_doctors($reservable_doctor_days, $day->format('w') - 1, 1) ?>
                                </div>
                                <?php endforeach ?>
                            </div>
                            <div class="pko-tr">
                                <div class="pko-th">13：30<br /> | <br />17：00</div>
                                <?php foreach($weekday as $day): ?>
                                <div class="pko-td">
                                    <?= match_day_doctors($reservable_doctor_days, $day->format('w') - 1, 2) ?>
                                </div>
                                <?php endforeach ?>
                            </div>
                            <div class="pko-tr">
                                <div class="pko-th">18：00<br /> | <br />21：00</div>
                                <?php foreach($weekday as $day): ?>
                                <div class="pko-td">
                                    <?= match_day_doctors($reservable_doctor_days, $day->format('w') - 1, 3) ?>
                                </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="schedule-notice mt-10 fs-md lh-xl d-md-flex align-center justify-between">
                    <div class="">
                        <?= $schedule_setting['notice'] ?>
                    </div>
                    <div>
                        <a href="<?= home_url('/about-us/group/') ?>" class="btn btn-light border-3 fs-sm-sm px-sm-6">團隊介紹</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="sec_info_content" class="entry-content">
        <?php the_content() ?>
    </section>
    <?php
    else :
        get_template_part( 'template-parts/content', 'none' );
    endif
    ?>
</main>
<?php
get_footer();
?>