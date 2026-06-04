<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package parkone_bmmc
 */
$fixed_btns = get_field('fixed_btns', 'options');
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

	<!-- Google Tag Manager -20231027 -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-KPC6D8ZH');</script>
	<!-- End Google Tag Manager -->
	
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-QEWC85QPT3"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-QEWC85QPT3');
	</script>

	
<script>
window.addEventListener('load', function (event) {
document.querySelectorAll('[href*="https://www.instagram.com/parkonebmi"]').forEach(function (e) {
e.addEventListener('click', function () {
gtag('event', 'conversion', { 'send_to': 'AW-11293735805/instagram' });
});
});
});
</script>
	
</head>

<body <?php body_class(); ?>>

<!-- Google Tag Manager (noscript) 20231027 -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KPC6D8ZH"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	
<?php
// 正式站才顯示
$arr = array("bmi.parkonehealth.com", "www.bmi.parkonehealth.com");
if (in_array($_SERVER['HTTP_HOST'], $arr)):
?>

<!-- Messenger 洽談外掛程式 Code -->
<div id="fb-root"></div>

<!-- Your 洽談外掛程式 code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
  var chatbox = document.getElementById('fb-customer-chat');
  chatbox.setAttribute("page_id", "117449874555730");
  chatbox.setAttribute("attribution", "biz_inbox");
</script>

<!-- Your SDK code -->
<script>
  window.fbAsyncInit = function() {
	FB.init({
	  xfbml            : true,
	  version          : 'v15.0'
	});
  };

  (function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
	js = d.createElement(s); js.id = id;
	js.src = 'https://connect.facebook.net/zh_TW/sdk/xfbml.customerchat.js';
	fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));
</script>

<?php endif; ?>

<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'parkone_bmmc' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="container">
			<nav id="site-navigation" class="main-navigation fw-bold">
				<div class="w-100 d-flex align-center justify-between">
					<h1 class="site-branding">
						<?php
						the_custom_logo();
						$is_home = (is_front_page() && is_home());
					
						?>
					</h1><!-- .site-branding -->
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="css-icon-hbg"></span></button>
				</div>
				<div class="fixed-btns">
					<?php foreach($fixed_btns as $btn):
						if(in_array('sm_m', $btn['show_on'])):
						$reserve_class = $btn['link'] == '#reserve_wrap' ? 'modal-toggler':'' ;
					?>
						<a href="<?= $btn['link'] ?>" class="fixed-btn <?= $reserve_class ?>">
							<img src="<?= $btn['icon'] ?>" />
							<span><?= $btn['name'] ?></span>
						</a>
					<?php endif; endforeach; ?>
				</div>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
			</nav><!-- #site-navigation -->
		</div>
	</header><!-- #masthead -->
