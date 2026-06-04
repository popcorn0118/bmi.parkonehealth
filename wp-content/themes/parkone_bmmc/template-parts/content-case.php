<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package parkone_bmmc
 */
$post = get_post();	
$category = '';
foreach(wp_get_post_terms($post->ID, 'treat_type') as $index => $term):
	if($index > 0):
		$category .= '、';
	endif;
	$category .= $term->name;
endforeach;

$body_data = get_field('body_data');
$weight = $body_data['weight'];
$fat = $body_data['fat'];
$bmi = $body_data['bmi'];
$post_operative_sterility = get_field('post-operative-sterility'); //術後動態
$latest_query = isset($_POST['c_latest']) ? $_POST['c_latest']: '' ;

if ( is_singular() ) :
	if (!empty($post_operative_sterility)){
		function my_sort($a, $b) {
			if ($a['date'] == $b['date']) return 0;
			return ($a['date'] > $b['date']) ? -1 : 1;
		}
		usort($post_operative_sterility, "my_sort");
	}
?>
<section class="single-post bg-white-60 bg-blur">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="container container-sm pt-20 pb-30">
			<header class="entry-header">
				<div class="entry-meta fs-md fs-sm-sm mb-2"><?= get_the_date() ?></div>
				<h1 class="entry-title fs-sm-lg"><?= get_the_title() ?></h1>
			</header><!-- .entry-header -->
			<div class="case-data">
				<h4 class="dec-before mb-4 fs-sm-md"><?= $post->client_name ?></h4>
				<div class="d-md-flex fs-md">
					<div class="w-50 w-sm-100">
						<p>年紀：<?= $post->client_age ?>歲</p>
						<p>治療方式：<?= $category ?></p>
						<p>主治醫師：<?= $post->doctor ?></p>
					</div>
					<div class="w-50 w-sm-100">
						<p>體重：<?= $weight['before'] ?> <span class="icon-arrow-next"></span> <?= $weight['after'] ?> (kg)</p>
						<p>體脂：<?= $fat['before'] ?> <span class="icon-arrow-next"></span> <?= $fat['after'] ?> (%)</p>
						<p><span class="bmi-space">BMI</span>：<?= $bmi['before'] ?> <span class="icon-arrow-next"></span> <?= $bmi['after'] ?> (kg/m2)</p>
					</div>
				</div>
				<div class="d-flex flex-wrap gap-10 my-16">
					<div class="w-25 w-sm-50 max-w-240">
						<h4 class="mb-2 fs-sm-md">治療時間</h4>
						<h3 class="flex-fill fs-sm-ml mb-sm-2"><?= $post->time ?></h3>
					</div>
					<div class="w-25 w-sm-50 max-w-240">
						<h4 class="mb-2 fs-sm-md">體重下降</h4>
						<h3 class="flex-fill fs-sm-ml mb-sm-2"><?= $weight['before'] - $weight['after'] ?> kg</h3>
					</div>
					<div class="w-25 w-sm-50 max-w-240">
						<h4 class="mb-2 fs-sm-md">體脂下降</h4>
						<h3 class="flex-fill fs-sm-ml mb-sm-2"><?= $fat['before'] - $fat['after'] ?> %</h3>
					</div>
					<div class="w-25 w-sm-50 max-w-240">
						<h4 class="mb-2 fs-sm-md">BMI下降</h4>
						<h3 class="flex-fill fs-sm-ml mb-sm-2"><?= $bmi['before'] - $bmi['after'] ?> kg/m2</h3>
					</div>
				</div>
				<hr class="bg-gray-3 my-16"/>
			</div>
			<!-- 更新動態(術後動態) 日期列表 -->
			<?php if (!empty($post_operative_sterility)): ?>
				<div class="case-post-operative-sterility date-list">
					<h4 class="mb-4 fs-sm-md">更新動態</h4>
					<ul class="list">
						<?php 
							foreach($post_operative_sterility as $index => $item):
								$date = new DateTime($item['date']);
								$timestamp = $date->getTimestamp();
						?>
							<li class="item">
								<a href="#cposWarp_<?= $index ?>" date-idx="<?= $index ?>"><?= date("Y.m.d", $timestamp) ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
					<hr class="bg-gray-3 my-16"/>
				</div>
			<?php 
			
		  
		  
		  
		  
		// foreach($arr as $i => $a){
			
		// }
		endif; ?>
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

			<!-- 術後動態 -->
			<?php if (!empty($post_operative_sterility)): ?>
				<div class="case-post-operative-sterility detailed-info">
					<div class="py-10">
						<h6 class="mb-2 text-center"> Post-Operative Sterility</h6>
						<h2 class="mb-6 text-center">術後動態</h2>
						<div class="list container pt-20 pb-30 px-sm-4">
							<?php
								foreach($post_operative_sterility as $index => $item):
									$date = new DateTime($item['date']);
									$timestamp = $date->getTimestamp();
							?>
								<div class="item" id="cposWarp_<?= $index ?>">
									<div class="my-0">
										<a href="#cpos_<?= $index ?>" class="collapse-btn py-12 px-12 px-sm-4 d-flex align-center justify-between">
											<div class="d-flex flex-column">
												<h5 class="date"><?= date("Y.m.d", $timestamp) ?></h5>
												<h4 class="title mb-0"><?= $item['title'] ?></h4>
											</div>
											<span class="icon-arrow-expand"></span>
										</a>
									</div>
									<div id="cpos_<?= $index ?>" class="collapse-block">
										<hr class="dot-hr bg-gray-3 mt-0 mb-12" />
										<div class="fs-md pb-12 px-12 px-sm-4">
											<?= $item['desc'] ?>
										</div>
									</div>
								</div>
								<hr class="bg-gray-4 my-0" />
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			<?php endif; ?>
			
		</div>
		
	</article><!-- #post-<?php the_ID(); ?> -->
</section>
<?php else:
	$weight_change = $weight['before'] - $weight['after'];
	if (str_contains($latest_query, 'desc')):
		if (!empty($post_operative_sterility)): 
?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="container list-case bg-white py-16">
				<div class="case-img box-shadow-4">
					<?= get_the_post_thumbnail(null, [600, 600]) ?>
				</div>
				<div class="case-card bg-white-60 bg-blur p-10">
					<header class="entry-header">
						<div class="entry-meta mb-2">
							<span class="date"><?= get_the_date() ?></span>
							<?php 
							if (!empty($post_operative_sterility)): 
								//取得最大數的日期
								$dateArr = array_column($post_operative_sterility, 'date');
								$dateMax = max($dateArr);
								//日期格式轉換
								$date = new DateTime($dateMax);
								$timestamp = $date->getTimestamp();
							?>
								<span class="post-operative-sterility-date">最新動態 <?= date("Y 年 m 月 d 日", $timestamp); ?></span>
							<?php endif; ?>
						</div>
						<h3 class="entry-title mb-6"><a href="<?= get_the_permalink() ?>"><?= get_the_title() ?></a></h3>
					</header><!-- .entry-header -->
					<div class="mb-12">
						<p class="fs-md">治療時間：<?= $post->time ?></p>
						<p class="fs-md">治療方式：<?= $category ?></p>
						<p class="fs-md">體重變化：<?= $weight_change ?> KG</p>
					</div>
					<a href="<?= get_the_permalink() ?>" class="btn btn-light border-4">了解案例</a>
				</div>
			</div>
		</article><!-- #post-<?php the_ID(); ?> -->
		<hr class="bg-gray-4 my-0"/>
		<?php endif; ?>
	<?php else: ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="container list-case bg-white py-16">
				<div class="case-img box-shadow-4">
					<?= get_the_post_thumbnail(null, [600, 600]) ?>
				</div>
				<div class="case-card bg-white-60 bg-blur p-10">
					<header class="entry-header">
						<div class="entry-meta mb-2">
							<span class="date"><?= get_the_date() ?></span>
							<?php 
							if (!empty($post_operative_sterility)): 
								//取得最大數的日期
								$dateArr = array_column($post_operative_sterility, 'date');
								$dateMax = max($dateArr);
								//日期格式轉換
								$date = new DateTime($dateMax);
								$timestamp = $date->getTimestamp();
							?>
								<span class="post-operative-sterility-date">最新動態 <?= date("Y 年 m 月 d 日", $timestamp); ?></span>
							<?php endif; ?>
						</div>
						<h3 class="entry-title mb-6"><a href="<?= get_the_permalink() ?>"><?= get_the_title() ?></a></h3>
					</header><!-- .entry-header -->
					<div class="mb-12">
						<p class="fs-md">治療時間：<?= $post->time ?></p>
						<p class="fs-md">治療方式：<?= $category ?></p>
						<p class="fs-md">體重變化：<?= $weight_change ?> KG</p>
					</div>
					<a href="<?= get_the_permalink() ?>" class="btn btn-light border-4">了解案例</a>
				</div>
			</div>
		</article><!-- #post-<?php the_ID(); ?> -->
	<?php endif ?>
<?php endif ?>