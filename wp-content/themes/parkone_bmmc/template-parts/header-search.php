<?php
$post_type = $_GET['post_type'];
$banner_top = get_field('about_top_banner', 'options');
?>
<section class="page-top-banner">
<div class="page-banner-bg">
        <img src="<?= $banner_top['bg']['img_lg'] ?>" />
    </div>
    <div class="container container-sm text-white d-flex flex-column align-center justify-center">
        <h6 class="mb-4 fadein fs-sm-xs" data-delay="400">Search result</h6>
        <h1 class="mb-0 fadein fs-sm-lg">搜尋結果</h1>
    </div>
</section>