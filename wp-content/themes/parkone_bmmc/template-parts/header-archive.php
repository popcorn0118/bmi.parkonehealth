<?php
$post_type = get_post_type();
if (is_post_type_archive() && $post_type){
    $banner_top = get_field('post_type_top_banners', 'options')[$post_type];
    $title = $banner_top['title'];
    $title_en = $banner_top['title_en'];
} else {
    $banner_top = get_field('about_top_banner', 'options');
    $title_en = 'Archive';
    $title = get_the_archive_title();
}
?>
<section class="page-top-banner">
    <div class="page-banner-bg">
        <img src="<?= $banner_top['bg']['img_lg'] ?>" />
    </div>
    <div class="container container-sm text-white d-flex flex-column align-center justify-center">
        <h6 class="mb-4 fadein fs-sm-xs" data-delay="400"><?= $banner_top['title_en'] ?></h6>
        <h1 class="mb-0 fadein fs-sm-lg"><?= $banner_top['title'] ?></h1>
    </div>
</section>