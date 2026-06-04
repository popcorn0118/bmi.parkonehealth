<?php

?>
<section class="page-top-banner">
    <div class="page-banner-bg">
        <?= get_the_post_thumbnail(null, [1920, 640]) ?>
    </div>
    <div class="container text-white d-flex flex-column align-center justify-center">
        <h6 class="mb-4 fadein fs-sm-xs" data-delay="400"><?= get_field('title_en') ?></h6>
        <h1 class="mb-0 fadein fs-sm-lg"><?= get_the_title() ?></h1>
    </div>
</section>