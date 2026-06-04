<?php
// 關於我們共用內容
global $parent_post;
$parent_id = wp_get_post_parent_id();
if($parent_id){
    $parent_post = get_post($parent_id);
}
$about_id = $parent_post->ID;
$environment = get_field('about_environment', $about_id);
$imgs = get_field('about_imgs', $about_id);
$info = get_field('about_info', $about_id);
?>
<section id="sec_env" class="bg-primary-deep text-light pt-30 pb-50 text-center fadein">
    <div class="container mb-16">
        <h6 class="fadein"><?= $environment['title_en'] ?></h6>
        <h2 class="fadein"><?= $environment['title'] ?></h2>
        <div class="env-swiper pt-16 fadein px-sm-2">
            <div class="py-6 py-sm-0 position-relative">
                <button class="swiper-button-prev btn-trans d-none d-md-flex"><span class="icon-arrow-prev fs-sm"></span></button>
                <p class="pre fs-md lh-xxl px-sm-8"><?= $environment['desc'] ?></p>
                <button class="swiper-button-next btn-trans d-none d-md-flex"><span class="icon-arrow-next fs-sm"></span></button>
            </div>
            <div class="swiper-wrapper pt-20 ps-8 pt-sm-10 ps-sm-0">
                <?php foreach($imgs as $img):?>
                <a class="glightbox swiper-slide env-slide"
                    data-glightbox="title:<?= $img['title'] ?>" href="<?= $img['url'] ?>">
                    <?= wp_get_attachment_image($img['id'], [768, 512], false, array( "class" => "box-shadow-5" ) ) ?>
                    <span class="fs-ml mt-6 d-block"><?= $img['title'] ?></span>
                </a>
                <?php endforeach ?>
            </div>
            <button class="swiper-button-prev btn-circle bg-white d-md-none"><span class="icon-arrow-prev fs-sm"></span></button>
            <button class="swiper-button-next btn-circle bg-white d-md-none"><span class="icon-arrow-next fs-sm"></span></button>
        </div>
    </div>
</section>
<section id="sec_traffic" class="bg-white-60 bg-blur fadein">
    <div class="container pt-20 pb-30 px-sm-4">
        <?php foreach($info as $index => $item):
            if($item['is_collapsable']):
        ?>
        <div>
            <h3 class="my-0">
                <a href="#trafic_<?= $index ?>" class="collapse-btn py-12 px-12 px-sm-4 d-flex align-center justify-between"><?= $item['title'] ?><span class="icon-arrow-expand"></span></a>
            </h3>
            <div id="trafic_<?= $index ?>" class="collapse-block">
                <hr class="dot-hr bg-gray-3 mt-0 mb-12" />
                <div class="fs-md pb-12 px-12 px-sm-4">
                    <?= $item['content'] ?>
                </div>
            </div>
        </div>
        <hr class="bg-gray-4 my-0" />
        <?php else: ?>
        <div>
            <h3 class="px-12 px-sm-4"><?= $item['title'] ?></h3>
            <div class="fs-md pb-12 px-12 px-sm-4">
                <?= $item['content'] ?>
            </div>
        </div>
        <hr class="bg-gray-4 my-0" />
        <?php endif; endforeach; ?>
    </div>
</section>