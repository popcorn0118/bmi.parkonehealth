<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package parkone_bmmc
 */
$post = get_post();	
$tags = '';
if(get_the_tags($post)):
	foreach(get_the_tags($post) as $index => $tag):
		if($index > 0):
			$tags .= '、';
		endif;
		$tags .= '<a href="' . home_url('tag/') . $tag->slug . '">' . $tag->name . '</a>';
	endforeach;
endif;

if ( is_singular() ) :
?>
<section class="single-post bg-white-60 bg-blur">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="container container-sm pt-20 pb-30">
			<header class="entry-header">
				<div class="entry-meta fs-md fs-sm-sm mb-2"><?= get_the_date() ?></div>
				<h1 class="entry-title fs-sm-lg mb-2"><?= get_the_title() ?></h1>
				<div class="entry-meta fs-md fs-sm-sm mb-2"><?= $tags ?></div>
			</header><!-- .entry-header -->
			
			<div class="entry-content fs-ml fs-sm-md lh-xxl">
				<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'parkone_bmmc' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					)
				);

				// wp_link_pages(
				// 	array(
				// 		'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'parkone_bmmc' ),
				// 		'after'  => '</div>',
				// 	)
				// );
				?>
			</div><!-- .entry-content -->
			<footer class="entry-footer">
				<?php parkone_bmmc_entry_footer(); ?>
			</footer><!-- .entry-footer -->
		</div>
		
	</article><!-- #post-<?php the_ID(); ?> -->
</section>
<?php else:
	$tags = '';
	if(get_the_tags($post)):
		foreach(get_the_tags($post) as $index => $tag):
			if($index > 0):
				$tags .= '、';
			endif;
			$tags .= '<span>'. $tag->name . '</span>';
		endforeach;
	endif;
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class('mb-10 post-report'); ?>>
		<a href="<?= esc_url( get_permalink() ) ?>">
			<div class="px-10 py-8 px-sm-0">
				<div class="entry-image mb-4">
					<?php
					if ( has_post_thumbnail() ):
						echo get_the_post_thumbnail(null, [520, 300]);
					else:
						echo '<img src="'. get_field('post_type_top_banners_post_default_img', 'options') .'" />';
					endif;
					?>
				</div>
				<header class="entry-header">
					<div class="entry-meta mb-2"><?= get_the_date() ?></div>
					<h4 class="entry-title mb-2 fs-sm-md"><?= get_the_title() ?></h4>
					<div class="entry-meta"><?= $tags ?></div>
				</header><!-- .entry-header -->
			</div>
		</a>
	</article><!-- #post-<?php the_ID(); ?> -->
<?php endif ?>