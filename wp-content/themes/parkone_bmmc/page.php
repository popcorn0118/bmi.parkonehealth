<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package parkone_bmmc
 */

/**
 * parent redirect
 */
global $post;
$post_slug = $post->post_name;
if($post_slug === 'about-us'){
	wp_redirect(home_url('about-us/intro'));
}
if($post_slug === 'program'){
	wp_redirect(home_url('program/treat-01/'));
}

get_header();

if(have_posts()):

	/**
	 * get template by parent
	 */
	global $parent_post;
	$parent_id = wp_get_post_parent_id();
	if($parent_id){
		$parent_post = get_post($parent_id);
		get_template_part( 'template-parts/header', 'page' );
	}

	if($parent_post->post_name == 'about-us'):
	?>
		<main id="page_<?=$post_slug?>" class="page bg-white-60 bg-blur">
			<section class="pt-20 pb-30">
				<div class="container">
					<div class="text-center">
						<h6 class="mb-2"><?= get_field('title_en') ?></h6>
						<h2 class="mb-0"><?= get_the_title() ?></h2>
					</div>
					<div class="mt-16 pb-10 fs-md lh-xl entry-content">
						<?php the_content() ?>
					</div>
				</div>
			</section>
		</main>
	<?php
		get_template_part( 'template-parts/content', 'about' );
	endif;

	if($parent_post->post_name == 'program'):
	?>
		<main id="page_<?=$post_slug?>" class="page bg-white-60 bg-blur">
			<?php get_template_part( 'template-parts/header', 'program' ); ?>
			<section class="pt-16">
				<div class="container max-w-1200">
					<div class="fs-md lh-xl entry-content">
						<?php the_content() ?>
					</div>
				</div>
			</section>
			<section class="">
				<div class="">
					<?php
					$parent_content =  get_the_content(null, true, $parent_post);

					$parent_content = apply_filters( 'the_content', $parent_content );
					$parent_content = str_replace( ']]>', ']]&gt;', $parent_content );
					echo $parent_content;
					?>
				</div>
			</section>
		</main>

	<?php endif;
	
else:

	get_template_part( 'template-parts/header', '' );
?>

		<main id="primary" class="site-main">

			<?php

				get_template_part( 'template-parts/content', 'none' );
				
			?>

		</main><!-- #main -->

<?php
endif;

// get_sidebar();
get_footer();