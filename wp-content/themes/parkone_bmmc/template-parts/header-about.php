<?php
$the_slug = 'about-us';
$args = array(
  'name'        => $the_slug,
  'post_type'   => 'page',
  'post_status' => 'publish',
  'numberposts' => 1
);
$my_posts = get_posts($args);
global $about_post;
if( $my_posts ) :
  $about_post = $my_posts[0];
?>
<section class="page-top-banner">
    <div class="page-banner-bg">
        <?= get_the_post_thumbnail($about_post, [2000, 700]) ?>
    </div>
    <div class="container text-white d-flex flex-column align-center justify-center">
        <h6 class="mb-4 fadein fs-sm-xs" data-delay="400"><?= $about_post->title_en ?></h6>
        <h1 class="mb-0 fadein fs-sm-lg"><?= $about_post->post_title ?></h1>
    </div>
</section>
<?php endif; ?>