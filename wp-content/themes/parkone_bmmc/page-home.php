<?php
/**
 * 首頁
 */

get_header();

$home_setting = get_fields();
$home_animation = get_field('home_animation', 'options');
?>
	
	<main id="primary" class="site-main">
	<?php if($home_animation['is_active']):
		// 把動畫圖庫分一半
		$anime_images = array_chunk($home_animation['images'], ceil(count($home_animation['images']) / 2)); ?>
		<section id="sec_animation" class="home-anime d-none">
			<div id="anime_scene_1" class="anime-scene">
				<div class="anime-images anime-top">
					<?php foreach($anime_images[0] as $img){
						echo '<img src="'. $img .'" />';
					} ?>
				</div>
				<div class="anime-images anime-bottom">
					<?php foreach($anime_images[1] as $img){
						echo '<img src="'. $img .'" />';
					} ?>
				</div>
			</div>
			<div id="anime_scene_2" class="anime-scene">
				<div>
					<img src="<?= $home_animation['logo'] ?>" />
					<h2 class="mb-0 fw-normal pre"><?= $home_animation['slogan'] ?></h2>
				</div>
			</div>
		</section>
	<?php endif; ?>
		<div class="main-bg d-none d-md-block">
			<img src="<?= the_field('bg_img_lg') ?>"/>
		</div>

		<!-- Top Banners -->
		<section id="sec-top">
			<div class="swiper top-swiper">
				<div class="swiper-wrapper">
					<!-- Slides -->
					<?php foreach($home_setting['top_banners'] as $index => $banner): ?>
					<div class="swiper-slide top-banner" data-is-dark="<?= $banner['is_dark'] ?>">
						<div class="banner-wrap">
							<div>
								<img src="<?= $banner['img_lg'] ?>" class="d-none d-md-block"/>
								<img src="<?= $banner['img_sm'] ?>" class="d-md-none" />
							</div>
							<div class="banner-btns-wrap">
								<div class="banner-btns d-none d-md-block">
									<a href="#" class="collapse-btn btn-has-line btn-trans">
										案例介紹
										<span class="dec-line"></span>
									</a>
									<a href="#" class="btn-has-line btn-next">
										Next case.
										<span class="dec-line dec-next"></span>
										<span class="dec-line dec-next"></span>
									</a>
								</div>
							</div>
						</div>
						<div class="collapse-info bg-blur-3 d-flex justify-center align-center">
							<div class="w-100 max-w-400 d-flex flex-column gap-16 gap-sm-10">
								<h2 class="pre fs-xxxl fs-sm-xl my-0"><?= $banner['slogan'] ?></h2>
								<div class="text-hr-after text-gray fs-md">Case. <?= $index + 1 ?></div>
								<p class="pre text-gray fs-ml fs-sm-md my-0"><?= $banner['desc'] ?></p>
								<div class="d-flex flex-column flex-md-row align-start gap-10">
									<a href="<?= get_permalink($banner['link_case']) ?>" class="btn btn-light border-4">案例分享</a>
									<a href="#" class="btn-has-line btn-next">
										Next case.
										<span class="dec-line dec-next"></span>
										<span class="dec-line dec-next"></span>
									</a>
								</div>
								<div class="flex-fill position-relative d-none d-md-flex">
									<a href="#" class="collapse-btn btn p-6 btn-trans d-inline-flex align-center gap-4">
										<span class="icon-arrow-prev-short"></span>
										觀賞案例全圖
									</a>
								</div>
							</div>
						</div>
					</div>
					<?php endforeach ?>
				</div>
			</div>
		</section>

		<!-- Services -->
		<?php
			$sec_service = get_field('sec_service');
		?>
		<section id="sec-service" class="bg-white py-40 py-sm-20 pt-sm-0 position-relative">
			<div class="container services-bg-wrap fadein px-sm-0">
				<img class="box-shadow-1 d-none d-md-block" src="<?= $sec_service['bg']['img_lg'] ?>"/>
				<img src="<?= $sec_service['bg']['img_sm'] ?>" class="d-md-none" />
			</div>
			<div class="container bg-blur bg-white-95 services-wrap px-0 px-sm-2 pt-16 text-center">
				<h6 class="fadein"><?= $sec_service['title_en'] ?></h6>
				<h2 class="fs-xxl text-dark fadein"><?= $sec_service['title'] ?></h2>
				<div class="swiper services-swiper">
					<div class="swiper-wrapper">
						<?php foreach($sec_service['services'] as $index => $item):
							$url = $item['post'] ? get_permalink($item['post']): '#';
							?>
							<a href="<?= $url ?>" class="swiper-slide py-16 px-6 fadein" data-delay="<?= 100 * $index ?>">
								<div class="bg-primary-dark img-circle">
									<img src="<?= $item['icon'] ?>" />
								</div>
								<h3 class="mt-8"><?= $item['name'] ?></h3>
								<p><?= $item['desc'] ?></p>
							</a>
						<?php endforeach ?>
					</div>
					<button class="swiper-button-prev btn-circle d-md-none"><span class="icon-arrow-prev"></span></button>
					<button class="swiper-button-next btn-circle d-md-none"><span class="icon-arrow-next"></span></button>
				</div>
				
			</div>
		</section>

		<!-- Group -->
		<?php
			$sec_group = get_field('sec_group');
			$main_doctor = $sec_group['main_doctor'];

			$the_doctors = get_posts(array(
				'post_type' => 'team',
				'numberposts' => -1,
				'order'     => 'ASC'
			));

		?>
		<section id="sec_group" class="bg-gray-5-op-95 bg-blur-2 py-40 py-sm-20">
			<div class="container px-sm-0">
				<div class="d-md-flex gap-20">
					<div class="main-doctor fadein d-none d-lg-block">
						<a href="<?= home_url('about-us/group#page_group') ?>" class="d-block bg-blue-light max-w-400">
							<img class="box-shadow-2" src="<?= $main_doctor['img'] ?>" />
							<div class="p-10 pt-0">
								<h3><?= $main_doctor['name'] ?> 　 <?= $main_doctor['job_title'] ?></h3>
								<p class="fs-ml lh-xl"><?= $main_doctor['desc'] ?></p>
							</div>
						</a>
					</div>
					<div class="the-doctors pt-sm-10 px-sm-2">
						<h3 class="ps-8 fadein fadein-left"><?= $sec_group['title'] ?></h3>
						<p class="max-w-560 fs-md lh-xl ps-8 fadein fadein-left px-sm-8"><?= $sec_group['desc'] ?></p>
						<div class="doctors-swiper mt-10 fadein">
							<div class="swiper-wrapper">
							<?php foreach($the_doctors as $index => $doctor):
								// $doctor_name_str = explode(" ", $doctor->post_title);
							?>
								<a href="<?= home_url('about-us/group?doctor=') . $doctor->ID . '#page_group' ?>" class="swiper-slide home-doctor">
									<?= get_the_post_thumbnail($doctor->ID, [768, 1200]) ?>
									<h3 class="mt-10"><?= $doctor->post_title ?></h3>
									<h5><?= $doctor->doctor_data_type ?></h5>
								</a>
							<?php endforeach ?>
							</div>
							<button class="swiper-button-prev btn-circle"><span class="icon-arrow-prev"></span></button>
							<button class="swiper-button-next btn-circle"><span class="icon-arrow-next"></span></button>
						</div>
						<div class="text-hr-after text-hr-before text-hr-gray-1 px-8 mt-10">
							<a href="<?= home_url('/group') ?>" class="btn btn-primary-dark border-3">團隊介紹</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<!-- Expect -->
		<?php
			$sec_expert = get_field('sec_expert');
		?>
		<section id="sec_expect" class="bg-white py-40 py-sm-8">
			<div class="container position-relative fadein">
				<div class="expect-bg box-shadow-3 fadein d-none d-sm-block">
					<img src="<?= $sec_expert['bg']['img_lg'] ?>"/>
				</div>
				<div class="expect-card bg-blur-1 bg-white-75" delay="400">
					<h6><?= $sec_expert['title_en'] ?></h6>
					<h2 class="fs-xxl text-dark mb-6"><?= $sec_expert['title'] ?></h2>
					<p class="pre fs-md"><?= $sec_expert['desc'] ?></p>
					<div class="my-20 d-flex justify-md-between gap-10">
						<div>
							<h4>身高</h4>
							<input type="number" min="20" max="500" class="expect-input" size="1"/>
							<label class="fs-ml">CM</label>
						</div>
						<div>
							<h4>體重</h4>
							<input type="number" min="10" max="1000" class="expect-input" size="1" />
							<label class="fs-ml">Kg</label>
						</div>
					</div>
					<span class="expect-hint d-md-none"></span>
					<button class="btn btn-primary-dark expect-btn">馬上計算</button>
					<hr id="expect-hr" class="dot-hr my-20" />
					<form method="POST" action="<?= home_url('/case') ?>">
						<h3>預期成果</h3>
						<div class="expect-result-wrap d-flex gap-6 align-center justify-between">
							<div>
								<input type="number" name="weight[0]" class="me-2 fs-xxxl fs-sm-xl expect-result" readonly />
								<span class="fs-ml">Kg</span>
							</div>
							<hr class="bg-gray-1 flex-fill my-0"/>
							<div>
								<input type="number" name="weight[1]" class="me-2 fs-xxxl fs-sm-xl expect-result" readonly />
								<span class="fs-ml">Kg</span>
							</div>
						</div>
						<h3 class="expect-reduce mt-8 d-none"></h3>
						<button class="submit btn btn-light border-3 mt-6 d-inline-block d-md-none">了解相關案例</button>
					</form>
				</div>
				<?php
				$default_post = get_posts( array(
						'numberposts'=> 1,
						'post_type'  => 'case',
					)
				)[0];

				$default_category = '';
				foreach($default_post->category as $index => $cat_ID):
					$term = get_term_by('id', $cat_ID, 'treat_type');
					if($index > 0):
						$default_category .= '、';
					endif;
					$default_category .= $term->name;
				endforeach;
				?>
				<div class="expect-post d-none d-md-block">
					<header class="entry-header">
						<div class="entry-date entry-meta mb-4"><?= get_the_date('', $default_post) ?></div>
						<h3 class="entry-title mb-6"><?= str_replace(' ', '<br />',get_the_title($default_post)); ?></h3>
					</header><!-- .entry-header -->
					<div class="mb-10">
						<p class="fs-md">治療時間：<span class="meta-time"><?= $default_post->time ?></span></p>
						<p class="fs-md">治療方式：<span class="meta-category"><?= $default_category ?></span></p>
						<p class="fs-md">體重變化：
							<span class="meta-weight-before"><?= $default_post->body_data_weight_before ?></span> - 
							<span class="meta-weight-after"><?= $default_post->body_data_weight_after ?></span> KG
						</p>
					</div>
					<div class="d-flex flex-column flex-md-row align-center gap-10">
						<a href="<?= get_permalink($default_post) ?>" class="entry-link btn btn-dark border-4">案例分享</a>
						<a href="<?= home_url('/case') ?>" class="btn-has-line btn-next">
							更多案例
							<span class="dec-line dec-next"></span>
							<span class="dec-line dec-next"></span>
						</a>
					</div>
				</div>
			</div>
		</section>

		<!-- bottom sections (reserve, contact) -->
		<?php
			$sec_bottoms = get_field('sec_bottoms');
			foreach($sec_bottoms as $index => $sec_bottom):
				$flex_way = $sec_bottom['layout'] == 'left' ? 'justify-end':'justify-start';
				$shadow_way = $sec_bottom['layout'] == 'left' ? 'box-shadow-4':'box-shadow-3';
		?>
		<section id="sec_banner_<?= $index ?>" class="bg-white pt-20 pb-40 py-sm-20 pt-sm-0">
			<div class="banner-bg banner-bg-<?= $sec_bottom['layout'] ?>">
				<img class="d-none d-md-block <?= $shadow_way ?>" src="<?= $sec_bottom['bg']['img_lg'] ?>" />
				<img src="<?= $sec_bottom['bg']['img_sm'] ?>" class="d-md-none" />
			</div>
			<div class="container px-sm-0 d-flex align-center fadein <?= $flex_way ?>">
					<div class="w-100 max-w-500 p-16 px-sm-8 bg-blur-1 bg-white-75">
						<h6><?= $sec_bottom['title_en'] ?></h6>
						<h2 class="fs-xxl text-dark mb-6"><?= $sec_bottom['title'] ?></h2>
						<p class="pre fs-md"><?= $sec_bottom['desc'] ?></p>
						<div class="d-flex flex-wrap gap-10 mt-16">
						<?php foreach($sec_bottom['buttons'] as $btn):
							$padding = $btn['style'] == '' ? 'px-0':'' ;
						?>
							<a href="<?= $btn['link']['url'] ?>" target="<?= $btn['link']['target'] ?>" class="btn <?= $btn['style']. ' ' . $padding ?>"><?= $btn['link']['title'] ?></a>
						<?php endforeach ?>
						</div>
					</div>
			</div>
		</section>
		<?php endforeach ?>
	</main><!-- #main -->

<?php
get_footer();
?>