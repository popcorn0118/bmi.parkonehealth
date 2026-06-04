<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package parkone_bmmc
 */

get_header();
get_template_part( 'template-parts/header', 'single' );
$post_type_obj;
$post_type_name = '文章';
$post_type = get_post_type();
if($post_type){
	$post_type_obj = get_post_type_object($post_type);
	$post_type_name = $post_type_obj->labels->singular_name;
}else {
}
?>

<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();
		
		get_template_part( 'template-parts/content', $post_type );


		echo '<section id="sec_post_nav" class="bg-light py-16"><div class="container container-sm position-relative">';
		the_post_navigation(
			array(
				'prev_text' => '<span class="icon-arrow-prev fs-xxs"></span> <span class="nav-subtitle">' . esc_html__( '上一篇'.$post_type_name, 'parkone_bmmc' ) . '</span><br>',
				'next_text' => '<span class="nav-subtitle">' . esc_html__( '下一篇'.$post_type_name, 'parkone_bmmc' ) . '</span> <span class="icon-arrow-next fs-xxs"></span><br>',
			)
		);
		echo '<a class="back-post-type" href="' . home_url('/' . $post_type) . '">返回'.$post_type_name.'列表</a>';
		
		// If comments are open or we have at least one comment, load up the comment template.
		// if ( comments_open() || get_comments_number() ) :
		// 	comments_template();
		// endif;
		echo '</div></section>';
	?>
	
	<section id="related_posts">
		<div class="container pt-20 pb-30">
			<h2 class="text-center">其他<?= $post_type_name ?></h2>
			<div class="wp-block-columns border-between mt-16 mb-0">
		<?php
		$related = get_posts(array(
			'post_type' => $post_type,
			'numberposts' => 3,
			'exclude' => [get_post()->ID]
		));
		if( $related ): foreach( $related as $post ):
			// $title = str_replace(' ', '<br />', $post->post_title);
		?>
			<div class="related-post wp-block-column px-10">
				<div class="entry-meta fs-md mb-2"><?= get_the_date('', $post->ID) ?></div>
				<h4>
					<a href="<?php the_permalink($post->ID) ?>" rel="bookmark" title="<?= $post->post_title ?>">
						<?= $post->post_title ?>
					</a>
				</h4>
			</div>   
		<?php endforeach; endif; ?>
			</div>
		</div>
	</section>
	
	<?php
	endwhile; // End of the loop.
	?>
	
</main><!-- #main -->

<?php
get_sidebar();
get_footer();
