<?php
/**
 * 看診資訊
 */
get_header();
get_template_part( 'template-parts/header', '' );

$days = [
    'monday'    => '星期一',
    'tuesday'   => '星期二',
    'wednesday' => '星期三',
    'thursday'  => '星期四',
    'friday'    => '星期五',
    'saturday'  => '星期六',
    'sunday'    => '星期日',
];

?>
<main id="page_info" class="page bg-white-60 bg-blur">
    <?php if ( have_posts() ) : ?>
    <!-- 幫我從這裡開始改 -->
    <section class="pt-20 pb-20 pb-sm-10">
        <div class="container max-w-1200">
            <div class="text-center mb-10">
                <h6 class="mb-2 fs-sm-xxs"><?= get_field('title_en') ?></h6>
                <h2 class="mb-0 fs-sm-ml"><?= get_field('title') ?></h2>
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
                            <?php foreach ( $days as $day_label ) : ?>
                            <div class="pko-th"><?= $day_label ?></div>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="pko-tbody">
                        <?php
                        $schedule_table = get_field('schedule_table');
                        if ( $schedule_table ) :
                            foreach ( $schedule_table as $row ) :
                        ?>
                        <div class="pko-tr">
                            <div class="pko-th fw-bold fs-ml"><?= esc_html( $row['time'] ) ?></div>
                            <?php foreach ( array_keys( $days ) as $day_key ) :
                                $cell = $row[ $day_key ] ?? [];
                            ?>
                            <div class="pko-td">
                                <?php if ( ! empty( $cell['doctor_Name'] ) ) : ?>
                                <span class="d-block fw-bold fs-ml mb-2"><?= esc_html( $cell['doctor_Name'] ) ?></span>
                                <span class="d-block fs-sm"><?= esc_html( $cell['category'] ) ?></span>
                                <?php endif ?>
                            </div>
                            <?php endforeach ?>
                        </div>
                        <?php endforeach; endif ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- 幫我從這裡開始改 end -->
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
