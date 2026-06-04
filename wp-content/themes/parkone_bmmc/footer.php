<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package parkone_bmmc
 */

$footer_options = get_field('footer', 'options');
$copyright = str_replace("[year]", date('Y'), $footer_options['copyright']);
$fixed_btns = get_field('fixed_btns', 'options');
?>
	<div class="fixed-right fadein">
		<div class="d-flex flex-column gap-6">
			<?php foreach($fixed_btns as $btn):
				$reserve_class = $btn['link'] == '#reserve_wrap' ? 'modal-toggler':'' ;
				$hide_class = '' ;
				if (in_array('lg', $btn['show_on']) && !in_array('sm', $btn['show_on'])){
					$hide_class = ' d-none d-md-flex';
				}
				if (in_array('sm', $btn['show_on']) && !in_array('lg', $btn['show_on'])){
					$hide_class = ' d-flex d-md-none';
				}
				
				if (in_array('sm', $btn['show_on']) || in_array('lg', $btn['show_on'])):
			?>
				<a href="<?= $btn['link'] ?>" class="fixed-btn <?= $reserve_class . $hide_class ?> <?php echo $btn['class_name']; ?> ">
					<img src="<?= $btn['icon'] ?>" />
					<span class="d-none d-md-block"><?= $btn['name'] ?></span>
				</a>
			<?php endif; endforeach ?>
		</div>
	</div>
	<footer id="colophon" class="site-footer bg-primary-deep text-white fs-sm">
		<div class="container pt-12">
			<div class="d-flex flex-column flex-md-row justify-start align-center align-md-start gap-20 my-10">
				<div class="text-center flex-fill w-25 w-sm-100 max-w-200">
					<a href="<?= home_url() ?>"><img src="<?= $footer_options['logo'] ?>"></a>
					<h4 class="mt-6"><?= $footer_options['social_media']['title'] ?></h4>
					<ul class="w-100 clear-list d-flex justify-center gap-10">
						<?php foreach($footer_options['social_media']['items'] as $item):?>
						<li><a href="<?= $item['link'] ?>" target="_blank" class="btn-social-media"><span class="icon-<?= $item['name'] ?>"></span></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="site-content w-50 w-sm-100 max-w-640 lh-xl">
					<?= $footer_options['desc'] ?>
				</div>
				<div class="flex-fill w-25 w-sm-100 max-w-640 text-left text-sm-center text-md-left">
					<h4 class="mt-0">網頁地圖</h4>
					<?php
					wp_nav_menu(
						array(
							'menu'           => '4',
							'menu_id'        => 'footer-menu',
							'menu_class'     => 'clear-list',
							'depth'          => 1,
						)
					);
					?>
				</div>
			</div>
		</div>
		<hr class="bg-gray-4 my-0">
		<div class="container py-10 text-center"><?= $copyright ?></div>
	</footer><!-- #colophon -->

	<?php
	$doctors = get_posts(array(
		'post_type' => 'team',
		'numberposts' => -1,
		'order'     => 'ASC'
	));
	
	if(date('D', time()) === 'Mon'){
		$monday = new DateTime("today");
		$sunday = new DateTime("today");
		$sunday->modify('+6 day');
	}else {
		$monday = new DateTime("last Monday");
		$sunday = new DateTime("last Monday");
		$sunday->modify('+6 day');
	}

	?>
	<div id="reserve_wrap" class="modal-wrap">
		<div class="reserve-block modal-content bg-white w-100 max-w-500">
			<button class="modal-close btn btn-circle btn-sm"><span class="css-icon-close"></span></button>
			<div class="p-12 px-sm-6 py-sm-10">
				<h3 class="mb-2">網路掛號</h3>
				<p id="week_string" class="fs-ml mb-4"><?= ($monday->format('Y')-1911).$monday->format('/m/d') ?> - <?= ($sunday->format('Y')-1911).$sunday->format('/m/d') ?></p>
				<button id="btn_prev_week" class="btn btn-light border-3 me-6 me-sm-2">上一週</button>
				<button id="btn_next_week" class="btn btn-light border-3">下一週</button>
			</div>
			<ul class="reserve-menu clear-list fs-ml">
				<?php foreach($doctors as $index => $doctor): ?>
					<li>
						<a id="collapse_btn_<?= $doctor->ID ?>" href="#reserve_doctor_<?= $doctor->ID ?>"
							class="collapse-btn py-10 px-12 px-sm-6 d-flex align-center justify-between">
							<?= $doctor->post_title ?><span class="icon-arrow-expand"></span>
						</a>
						<ul id="reserve_doctor_<?= $doctor->ID ?>" class="collapse-block bg-light clear-list">
							<?php
							$reservable_days = get_field('doctor_data_reservable', $doctor->ID);
							// 可掛號時段連結
							if($reservable_days):
							foreach($reservable_days as $day):
								if(date('D', time()) === 'Mon'){
									$reserve_day = new DateTime("today");
								}else {
									$reserve_day = new DateTime("last Monday");
								}
								$weekday = $day['weekday']['value'] - 1;
								$time_zone = $day['time_zone']['value'];
								$fix_hours = 4;
								switch($time_zone){
									case 2:
										$fix_hours = 9;
										break;
									case 3:
										$fix_hours = 13;
										break;
								}

								$reserve_day->modify('+'.$weekday.' day '. $fix_hours .'hours');
								$view_date =  ($reserve_day->format('Y')-1911).$reserve_day->format('md');
								// echo $reserve_day->format('D M d Y H:i:s O');
								$reserve_array = array(
									'viewDate' => $view_date,
									'apn'      => $day['time_zone']['value'],
									'doctorNo' => $doctor->doctor_data_sys_number,
									'zone'     => 'A',
									'clinicNo' => $day['clinic']['value'],
									'doctorName' => explode(' ', $doctor->post_title)[0],
									'clinicName' => $day['clinic']['label'],
									'divNo'      => $day['div']['value'],
									'divName'    => $day['div']['label'],
								);

								$park_url = 'https://webreg.parkonehealth.com/#/regtan?';
								foreach($reserve_array as $key => $value):
									$park_url .= $key.'='.$value.'&';
								endforeach;

							?>
								<li>
									<a href="<?= $park_url ?>" target="_blank"
									data-timestamp="<?= $reserve_day->getTimestamp().'000' ?>"
									data-weekday="<?= $day['weekday']['value'] ?>"
									class="btn-reserve-date btn py-10 px-12 px-sm-6 d-flex align-center justify-between">
									<?= $day['weekday']['label'].$day['time_zone']['label'] ?>
									<span class="icon-arrow-expand"></span>
									</a>
								</li>
							<?php
							endforeach; endif;
							// 自訂其他看診方式
							if($doctor->doctor_data_custom_btns):
								$btns = get_field('doctor_data_custom_btns', $doctor->ID);
								foreach($btns as $btn):
							?>
								<li>
									<a href="<?= $btn['link']['url'] ?>" target="<?= $btn['link']['target'] ?>"
										class="btn py-10 px-12 px-sm-6 d-flex align-center justify-between">
									<?= $btn['desc'] ?><span class="icon-arrow-expand"></span>
									</a>
								</li>
							<?php endforeach; endif; ?>
								
						</ul>
					</li>
				<?php endforeach ?>
			</ul>
			<div class="p-12 px-sm-6 py-sm-10">
				<p class="fs-md lh-xl mb-8">若有疑問或是看診需求，<br />歡迎透過官方Line@與我們聯繫。</p>
				<div class="d-flex flex-wrap gap-10 mt-16">
				<?php foreach(get_field('reserve_modal_btns', 'options') as $btn):
					$padding = $btn['style'] == '' ? 'px-0 ps-':'' ;
				?>
					<a href="<?= $btn['link']['url'] ?>" target="<?= $btn['link']['target'] ?>" class="btn <?= $btn['style']. ' ' . $padding ?>"><?= $btn['link']['title'] ?></a>
				<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
