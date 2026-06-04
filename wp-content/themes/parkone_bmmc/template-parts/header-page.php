<?php
global $parent_post;
if($parent_post):
?>
<section class="page-top-banner">
    <div class="page-banner-bg">
        <?= get_the_post_thumbnail($parent_post, [2000, 700]) ?>
    </div>
    <div class="container text-white d-flex flex-column align-center justify-center">
        <h6 class="mb-4 fadein fs-sm-xs" data-delay="400"><?= $parent_post->title_en ?></h6>
        <h1 class="mb-0 fadein fs-sm-lg"><?= $parent_post->post_title ?></h1>
    </div>
</section>
<?php endif; ?>