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
$post_type = get_post_type();
$banner_top = get_field('post_type_top_banners', 'options')[$post_type];

// get treat type
$all_treat_type = get_terms( array(
    'taxonomy' => 'treat_type',
    'hide_empty' => false,
	'parent' => 0,
	'orderby' => 'slug',
) );

$search_treat_type = array();
if(isset($_POST['c_treat_type'])){
	$search_treat_type = explode(',', $_POST['c_treat_type']);

	// remove empty value
	if (($key = array_search('', $search_treat_type)) !== false) {
		unset($search_treat_type[$key]);
	}
}

$search_tax = array('relation' => 'AND');
if(sizeof($search_treat_type) > 0){
	$search_tax[1] = array(
		'taxonomy' => 'treat_type',
		'terms'    => $search_treat_type,
	);
}


// 動態更新
$all_latest_type = array(
	"0" => array(
		'name' => '最新更新',
		'value' => 'desc',
	),
	// "1" => array(
	// 	'name' => '顯示較舊',
	// 	'value' => 'asc',
	// )
);
$search_latest_type = array();
if(isset($_POST['c_latest'])){
	$search_latest_type = explode(',', $_POST['c_latest']);

	// remove empty value
	if (($key = array_search('', $search_latest_type)) !== false) {
		unset($search_latest_type[$key]);
	}
}
// $search_latest = array('relation' => 'AND');
// if(isset($_POST['c_latest']) == 'desc'){
// 	$search_latest[1] = array(
// 		'key' => 'post-operative-sterility',
// 		'value' => $_POST['c_latest'],
// 		'compare' => 'LIKE',
// 	);
// }


// get weight
$search_weight = array('relation' => 'AND');
if(isset($_POST['weight'][0])){
	$search_weight[1] = array(
		'key' => 'body_data_weight_after',
		'value' => $_POST['weight'][0],
		'compare' => '>=',
	);
	$search_weight[2] = array(
		'key' => 'body_data_weight_after',
		'value' => $_POST['weight'][1],
		'compare' => '<=',
	);
}

// get result post
global $wp_query;
$origin_query = $wp_query->query_vars;
$args = $origin_query;
if(sizeof($search_treat_type) > 0){
	$args = array_merge( $args, array(
			'tax_query' => $search_tax,
		)
	);
}
if(isset($_POST['weight'][0])){
	$args = array_merge( $args, array(
			'meta_query' => $search_weight,
			// 'meta_query' => array_merge($search_weight, $search_latest),
		)
	);
}
$wp_query = new WP_Query( $args );

// 沒有文章時找大於低標的第一個文章 (最小值)
// if ( !have_posts() ) {
// 	if(isset($_POST['weight'][0])){
// 		$search_weight[1] = array(
// 			'key' => 'body_data_weight_after',
// 			'value' => $_POST['weight'][0],
// 			'compare' => '>=',
// 		);
// 		$search_weight[2] = array();
// 	}
// 	$args = array_merge( $origin_query, array(
// 		'tax_query' => $search_tax,
// 		'meta_query' => $search_weight,
// 		'orderby'   => 'meta_value_num',
// 		'meta_key'  => 'body_data_weight_after',
// 		'order'     => 'ASC',
// 		)
// 	);
// 	$wp_query = new WP_Query( $args );
// }

// 還是沒有文章時找小於低標的第一個文章 (最大值)
// if ( !have_posts() ) {
// 	if(isset($_POST['weight'][0])){
// 		$search_weight[1] = array(
// 			'key' => 'body_data_weight_after',
// 			'value' => $_POST['weight'][0],
// 			'compare' => '<=',
// 		);
// 		$search_weight[2] = array();
// 	}
// 	$args = array_merge( $origin_query, array(
// 		'tax_query' => $search_tax,
// 		'meta_query' => $search_weight,
// 		'orderby'   => 'meta_value_num',
// 		'meta_key'  => 'body_data_weight_after',
// 		'order'     => 'DESC',
// 		)
// 	);
// 	$wp_query = new WP_Query( $args );
// }
?>

	<main id="primary" class="site-main">
		<section class="page bg-white-60 bg-blur">
			<div class="container py-20">
				<!-- focus case swiper -->
				<div class="swiper focus-swiper">
					<div class="">
						<button class="swiper-button-prev"><span class="icon-arrow-prev"></span></button>
						<button class="swiper-button-next"><span class="icon-arrow-next"></span></button>
					</div>
					<div class="swiper-wrapper">
						<?php
						$focus_cases = get_field('post_type_top_banners_focus_cases', 'options');
						foreach($focus_cases as $index => $case):
							$post = $case['post'];
							$weight_change = $post->body_data_weight_before - $post->body_data_weight_after;
							$fat_change = $post->body_data_fat_before - $post->body_data_fat_after;
						?>
						<div class="swiper-slide focus-case">
							<div class="text-center mb-10">
								<p class="fs-ml mb-8">焦點案例-<?= sprintf('%02d', $index + 1); ?></p>
								<h3 class="pre fs-sm-ml"><?= $case['title'] ?></h3>
							</div>
							<div class="bg-white">
								<div class="focus-img">
									<img src="<?= $case['img'] ?>" />
								</div>
								<div class="focus-info bg-white-60 bg-blur">
									<div>
										<h3 class="mb-2 fs-sm-md">治療時間</h3>
										<p class="fs-xxl fs-sm-ml fw-bold mb-0"><?= $post->time ?></p>
									</div>
									<div>
										<h3 class="mb-2 fs-sm-md">體重下降</h3>
										<p class="fs-xxl fs-sm-ml fw-bold mb-0"><?= $weight_change ?> kg</p>
									</div>
									<div>
										<h3 class="mb-2 fs-sm-md">體脂減少</h3>
										<p class="fs-xxl fs-sm-ml fw-bold mb-0"><?= $fat_change ?> %</p>
									</div>
									<div>
										<a href="<?= get_permalink($post) ?>" class="btn btn-light border-3 fs-sm-sm px-sm-6">了解案例</a>
									</div>
								</div>
							</div>
						</div>
						<?php endforeach ?>
					</div>
				</div>

				<!-- post search -->
				<div class="post-search-bar ps-10 ps-sm-0 d-flex flex-wrap align-end justify-between position-relative">
					<div class="me-10">
						<h6 class="mb-2 text-primary-dark"><?= $banner_top['title_en'] ?></h6>
						<h2 class="on-search mb-4 fs-sm-lg d-flex align-center gap-2">
							<?= $banner_top['title'] ?>
							<?php
							if(sizeof($search_treat_type) > 0 || isset($_POST['weight'])){
								echo ' : ';
							}
							if(sizeof($search_treat_type) > 0){
								foreach ( $search_treat_type as $index => $treat_type ) {
									if ( $index > 0 && $treat_type != '') echo '、';
									if ( $treat_type > 0 ) echo get_term($treat_type)->name;
								}
							}
							if(isset($_POST['weight'][0]) && $_POST['weight'][0] != ''){
								if(sizeof($search_treat_type) > 1) echo '、';
								echo '<span class="fs-xxl fs-sm-xl"> ';
								echo $_POST['weight'][0] . ' - ' . $_POST['weight'][1] . 'kg';
								echo '</span>';
							}
							?>
						</h2>
					</div>
					<div class="flex-fill d-flex flex-column align-end">
						<a href="#search_wrap" class="search-wrap-toggler collapse-btn fs-md">
							<span><span class="icon-filter me-4"></span>專欄分類</span>
							<span class="icon-arrow-expand"></span>
						</a>
						
						<form id="search_wrap" class="search-wrap box-shadow-7" method="POST" action="">
							<a href="#search_wrap" class="collapse-close-btn collapse-btn fs-md">
								<span class="css-icon-close"></span>
							</a>
							<div>
								<div class="mb-10">
									<h4 class="dec-before dec-dark mb-6">治療項目</h4>
									<div class="search-select-wrap">
										<input type="hidden" name="c_treat_type" id="c_treat_type" value="<?= implode(',', $search_treat_type) ?>">
										<?php foreach($all_treat_type as $index => $treat_type ): ?>
										<a href="#c_treat_type" class="search-select <?= in_array($treat_type->term_id , $search_treat_type) ? 'active':'' ; ?>" data-value="<?= $treat_type->term_id ?>"><?= $treat_type->name ?></a>
										<?php endforeach; ?>
									</div>
								</div>
								<div class="mb-10">
									<h4 class="dec-before dec-dark mb-6">動態更新</h4>
									<div class="search-select-wrap">
										<input type="hidden" name="c_latest" id="c_latest" value="<?= implode(',', $search_latest_type) ?>">
										<?php foreach($all_latest_type as $index => $latest ): ?>
										<a href="#c_latest" class="search-select <?= in_array($latest['value'] , $search_latest_type) ? 'active':'' ; ?>" data-value="<?= $latest['value'] ?>"><?= $latest['name'] ?></a>
										<?php endforeach; ?>
									</div>
								</div>
								<!-- <div>
									<h4 class="dec-before dec-dark mb-0">預期成果相關案例</h4>
									<div class="expect-card px-8">
										<div class="my-10 gap-6 d-flex flex-wrap align-end justify-between">
											<div>
												<h4>身高</h4>
												<input type="number" min="20" max="500" class="me-6 expect-input" size="1"/>
												<label class="fs-ml">CM</label>
											</div>
											<div class="flex-fill max-w-42"></div>
											<div>
												<h4>體重</h4>
												<input type="number" min="10" max="1000" class="me-6 expect-input" size="1" />
												<label class="fs-ml">Kg</label>
											</div>
											<div class="flex-fill text-md-right mt-sm-6">
												<span class="expect-hint d-none"></span>
												<button class="btn btn-primary-dark expect-btn">馬上計算</button>
											</div>
										</div>
										<div>
											<h4>預期成果</h4>
											<div class="d-flex flex-wrap gap-6 align-center justify-between">
												<div>
													<input type="number" name="weight[0]" class="me-6 fs-xxl fs-sm-lg expect-result" readonly />
													<span class="fs-ml">Kg</span>
												</div>
												<hr class="bg-gray-1 flex-fill max-w-42 my-0"/>
												<div>
													<input type="number" name="weight[1]" class="me-6 fs-xxl fs-sm-lg expect-result" readonly />
													<span class="fs-ml">Kg</span>
												</div>
												<div class="flex-fill text-md-right mt-sm-6">
													<button class="submit btn btn-light border-3">了解相關案例</button>
												</div>
											</div>
											<h4 class="expect-reduce mt-8 d-none">減少約 <span></span>Kg</h4>
										</div>
									</div>
								</div> -->
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
				<div class="post-case-list">
				<?php if ( have_posts() ) : 

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
				<div>
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
