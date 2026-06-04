<?php
/**
 * 醫療團隊
 */
get_header();
get_template_part( 'template-parts/header', 'about' );

$doctors = get_posts(array(
    'post_type' => 'team',
    'numberposts' => -1,
    'order'     => 'ASC'
));

?>
<main id="page_group" class="page bg-white-60 bg-blur">
    <?php if ( have_posts() ) : ?>
    <section class="pt-20 pb-30">
        <div class="container">
            <div class="text-center">
                <h6 class="mb-2"><?= get_field('title_en') ?></h6>
                <h2 class="mb-0"><?= get_the_title() ?></h2>
            </div>
            <div class="mt-16 pb-10 entry-content">
                <?php the_content() ?>
            </div>
        </div>
        <div class="container sticky bg-white px-sm-0">
            <div class="d-md-flex gap-20 align-center justify-between">
                <div class="custom-selects">
                    <button class="custom-selects-toggler">選擇醫師<span class="icon-arrow-expand"></span></button>
                    <div class="custom-selects-wrap tab-selects">
                    <?php foreach($doctors as $index => $doctor): ?>
                        <button id="doctor_select_<?= $doctor->ID ?>" class="custom-select tab-select doctor-select <?= $index == 0 ? 'active':'' ; ?>"
                            data-tab="#doctor_<?= $doctor->ID ?>"
                            data-type="<?= $doctor->doctor_data_type ?>">
                            <?= $doctor->post_title ?>
                        </button>
                    <?php endforeach ?>
                    </div>
                </div>
                <h3 class="doctor-name mb-0 flex-fill text-md-center px-8 py-sm-6 fs-sm-md">阮蘭婷 副院長</h3>
                <h4 class="doctor-type flex-fill text-right mb-0 d-none d-md-block">肥胖治療專科醫師</h4>
            </div>
            <hr class="bg-gray-4 mt-0 mb-16 mt-sm-0 mb-sm-6"/>
        </div>
        <div class="container">
            <div class="doctor-list tab-list">
                <?php foreach($doctors as $index => $doctor): ?>
                <div id="doctor_<?= $doctor->ID ?>" class="doctor tab <?= $index == 0 ? 'active':'' ; ?>">
                    <div class="d-md-flex gap-20">
                        <div class="max-w-400">
                            <div class="doctor-img max-w-400 mb-6">
                                <?= get_the_post_thumbnail($doctor) ?>
                            </div>
                            <div class="mb-sm-6">
                                <?php if($doctor->doctor_data_desc): ?>
                                <p class="mt-10 mb-8 fs-ml"><?= $doctor->doctor_data_desc ?></p>
                                <?php endif ?>
                                <h3>門診時間</h3>

                                    <?php
                                    $reservable_days = get_field('doctor_data_reservable', $doctor->ID);
                                    $reservable_days_array = array();
                                    foreach($reservable_days as $day){
                                        array_push($reservable_days_array, $day['weekday']['label'].$day['time_zone']['label']);
                                    }
                                    // 可掛號日 & 額外說明
                                    if(sizeof($reservable_days_array) > 0): ?>
                                    <div class="d-md-flex align-end justify-between gap-10">
                                        <p class="pre lh-xl mb-0 fs-md max-w-190 mb-sm-6"><?= implode('、', $reservable_days_array) ?></p>
                                        <a href="#reserve_wrap" data-doctor="<?= $doctor->ID ?>" class="btn btn-light border-3 modal-toggler">掛號</a>
                                    </div>
                                    <?php endif ?>

                                    <?php
                                    if($doctor->doctor_data_custom_btns):
                                        $btns = get_field('doctor_data_custom_btns', $doctor->ID);
                                        foreach($btns as $btn):
                                    ?>
                                    <div class="">
                                        <p class="pre lh-xl fs-md"><?=$btn['desc']?></p>
                                        <a href="<?= $btn['link']['url'] ?>" data-doctor="<?= $doctor->ID ?>"
                                        target="<?= $btn['link']['target'] ?>" class="btn btn-light border-3">
                                            <?= $btn['link']['title'] ?>
                                        </a>
                                    </div>
                                    <?php endforeach; endif; ?>
                                <?php if($doctor->doctor_data_social_medias): ?>
                                    <hr class="bg-gray-4 my-10" />
                                    <?php foreach(get_field('doctor_data_social_medias', $doctor->ID) as $media): ?>
                                    <a class="d-flex align-center fs-md" href="<?= $media['link'] ?>" target="_blank"><span class="icon-<?= $media['type'] ?> fs-xxl me-6"></span><?= $media['name'] ?></a>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>
                        <div class="flex-fill">
                            <div class="doctor-info fs-md">
                                <?= $doctor->post_content ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>
    <?php
    else :
        get_template_part( 'template-parts/content', 'none' );
    endif
    ?>
</main>
<?php
get_template_part( 'template-parts/content', 'about' );
get_footer();
?>