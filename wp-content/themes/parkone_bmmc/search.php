<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package parkone_bmmc
 */

get_header();
get_template_part( 'template-parts/header', 'search' );
?>

	<main id="primary" class="site-main">
		<section class="page bg-white-60 bg-blur">
			<div class="container py-20">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					// printf( esc_html__( ': %s', 'parkone_bmmc' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->
			<div class="d-grid grid-2-columns border-between">
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', '' );

			endwhile;
			?>
			</div>
			<?php
			the_posts_navigation();
			
		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
			
			</div>
		</section>
	</main><!-- #main -->

<?php
get_footer();
