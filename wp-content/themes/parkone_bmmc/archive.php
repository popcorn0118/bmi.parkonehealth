<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package parkone_bmmc
 */

get_header();
get_template_part( 'template-parts/header', 'archive' );

global $post_type;
$all_years = get_posts_years_array($post_type);
$search_years = array();
if(isset($_POST['c_year'])){
	$search_years = explode(',', $_POST['c_year']);
}

$search_args = array('relation' => 'OR');
foreach($search_years as $index => $year ){
	$search_args[$index + 1] = array('year' => intval($year));
}

global $wp_query;
$args = array_merge( $wp_query->query_vars, 
			array(
				'date_query' => $search_args,
			)
		);
query_posts( $args );
?>

	<main id="primary" class="site-main">
		<section class="page bg-white-60 bg-blur">
			<div class="container py-20">
				<div class="post-search-bar ps-10 ps-sm-0 d-flex flex-wrap align-center justify-between position-relative">
					<h2 class="on-search fw-medium mb-0">
						<?php
						if(!$search_years){
							echo '所有文章';
						} else {
							foreach ( $search_years as $index => $year ) {
								if ( $index > 0 && $year != '') echo '、';
								echo $year;
							}
						}
						?>
					</h2>
					<div class="flex-fill d-flex flex-column align-end">
						<a href="#search_wrap" class="search-wrap-toggler collapse-btn fs-md">
							<span><span class="icon-filter me-4"></span>專欄分類</span>
							<span class="icon-arrow-expand"></span>
						</a>
						<form id="search_wrap" class="search-wrap box-shadow-7" method="POST" action="">
							<div>
								<div>
									<h4 class="dec-before dec-dark mb-6">年份</h4>
									<div class="search-select-wrap">
										<input type="hidden" name="c_year" id="c_year" value="<?= implode(',', $search_years) ?>">
										<?php foreach($all_years as $index => $year): ?>
										<a href="#c_year" class="search-select <?= in_array($year, $search_years) ? 'active':'' ; ?>" data-value="<?= $year ?>"><?= $year ?></a>
										<?php endforeach; ?>
									</div>
								</div>
								<hr  class="my-12"/>
								<div class="text-center text-md-left">
									<button type="submit" class="submit btn btn-primary-dark mb-sm-6">提交分類</button>
									<a href="#" class="btn search-clear">取消所有分類</a>
								</div>
							</div>
						</form>
					</div>
				</div>
				<hr class="mt-0"/>
				<?php if ( have_posts() ) : ?>
					
					<div class="post-list d-md-grid grid-2-columns border-between">

					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						* Include the Post-Type-specific template for the content.
						* If you want to override this in a child theme, then include a file
						* called content-___.php (where ___ is the Post Type name) and that will be used instead.
						*/
						get_template_part( 'template-parts/content', get_post_type() );

					endwhile;
					?>
					</div>

					<?php
					the_posts_pagination();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
			</div>
		<section>
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
