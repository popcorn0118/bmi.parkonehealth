<?php
$post_type = get_post_type();
if($post_type){
	$banner_top = get_field('post_type_top_banners', 'options')[$post_type];
	// $post_type_obj = get_post_type_object($post_type);
}else {
	$banner_top = get_field('about_top_banner', 'options');
}
?>
<section class="page-top-banner">
    <div class="page-banner-bg">
        <img src="<?= $banner_top['bg']['img_lg'] ?>" />
    </div>
    <div class="container container-sm text-white d-flex flex-column align-center justify-center">
        <div class="text-center text-md-left w-100">
            <a href="<?= home_url('/' . $post_type) ?>" class="fs-md fs-sm-sm d-inline-flex align-center gap-2">
                <span class="icon-arrow-prev fs-xs"></span> 返回<?= $banner_top['title'] ?>
            </a>
        </div>
    </div>
</section>