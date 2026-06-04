<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package parkone_bmmc
 */

?>
<section class="no-results not-found">
	<div class="px-10">
		<h1>查無文章</h1>
		<h4>目前條件查無相關文章，請試試其他條件。</h4>
	</div>

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'parkone_bmmc' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		// elseif ( is_search() ) :
		
		// 	get_search_form();

		else :
			?>

			

			<?php
			// 	get_search_form();
		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
