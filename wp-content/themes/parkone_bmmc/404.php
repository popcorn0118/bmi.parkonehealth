<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package parkone_bmmc
 */

get_header();

$the_slug = 'about-us';
$args = array(
  'name'        => $the_slug,
  'post_type'   => 'page',
  'post_status' => 'publish',
  'numberposts' => 1
);
$my_posts = get_posts($args);
$about_post = $my_posts[0];

?>

<section class="page-top-banner">
    <div class="page-banner-bg">
        <?= get_the_post_thumbnail($about_post, [2000, 700]) ?>
    </div>
    <div class="container container-sm text-white d-flex flex-column align-center justify-center">
        <div class="text-center text-md-left w-100">
            <a href="<?= home_url() ?>" class="fs-md fs-sm-sm d-inline-flex align-center gap-2">
                <span class="icon-arrow-prev fs-xs"></span> 返回首頁
            </a>
        </div>
    </div>
</section>
<main id="primary" class="site-main">

	<section class="page bg-white-60 bg-blur error-404 not-found py-20">
		<div class="container text-center">
			<h1 class="fs-120 mb-4">404</h1>
			<p class="fs-ml mb-8">查無此頁</p>
			<a href="<?= home_url() ?>" class="fs-md fs-sm-sm d-inline-flex align-center gap-2">
                <span class="icon-arrow-prev fs-xs"></span> 返回首頁
            </a>
		</div>
	</section><!-- .error-404 -->

</main><!-- #main -->

<?php
get_footer();
