<?php
/**
 * parkone_bmmc functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package parkone_bmmc
 */

date_default_timezone_set('Asia/Taipei');

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.4.6' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function parkone_bmmc_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on parkone_bmmc, use a find and replace
		* to change 'parkone_bmmc' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'parkone_bmmc', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'parkone_bmmc' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'parkone_bmmc_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'parkone_bmmc_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function parkone_bmmc_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'parkone_bmmc_content_width', 640 );
}
add_action( 'after_setup_theme', 'parkone_bmmc_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function parkone_bmmc_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'parkone_bmmc' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'parkone_bmmc' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'parkone_bmmc_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function parkone_bmmc_scripts() {
	wp_enqueue_style( 'home-animation', get_stylesheet_directory_uri(). '/css/home-animation.css', array(), _S_VERSION  );
	wp_enqueue_style( 'parkone_bmmc-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'parkone_bmmc-style', 'rtl', 'replace' );
	wp_enqueue_style( 'glightbox-css', get_stylesheet_directory_uri(). '/css/glightbox.min.css' );
	wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/swiper-bundle.min.css', array(), _S_VERSION );
	wp_enqueue_style( 'icomoon', get_template_directory_uri() . '/css/icomoon.css', array(), _S_VERSION );
	wp_enqueue_style( 'parkone_bmmc-main', get_template_directory_uri() . '/css/main.css', array(), _S_VERSION );
	wp_enqueue_style( 'parkone_bmmc-rwd', get_template_directory_uri() . '/css/rwd.css', array(), _S_VERSION );
	
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/js/swiper-bundle.min.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'glightbox', get_stylesheet_directory_uri() . '/js/glightbox.min.js', '', '', true );
	wp_enqueue_script( 'parkone_bmmc-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'parkone_bmmc-main', get_template_directory_uri() . '/js/main.js', array('swiper', 'masonry'), 202310111154, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'parkone_bmmc_scripts' );

add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
	wp_enqueue_style( 'parkone_bmmc-rwd', get_template_directory_uri() . '/css/admin.css', array(), _S_VERSION );
}

/**
 * Registers support for editor styles & Enqueue it.
 */
function custom_gutenberg_setup() {
	// Add support for editor styles.
	add_theme_support( 'editor-styles' );
  
	// Enqueue editor styles.
	add_editor_style( get_template_directory_uri() . '/css/admin.css' );
}
add_action( 'after_setup_theme', 'custom_gutenberg_setup' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load API file.
 */
require get_template_directory() . '/inc/api.php';

/**
 * glightbox to all img link
 */
add_filter('the_content', 'glightbox_class');
function glightbox_class ( $content ) {
	global $post;
	$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
	$replacement = '<a$1 class="glightbox" href=$2$3.$4$5$6>';
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}

/**
 * SVG allow
 */
// Allow SVG
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

	global $wp_version;
	if ( $wp_version !== '4.7.1' ) {
	   return $data;
	}
  
	$filetype = wp_check_filetype( $filename, $mimes );
  
	return [
		'ext'             => $filetype['ext'],
		'type'            => $filetype['type'],
		'proper_filename' => $data['proper_filename']
	];
  
  }, 10, 4 );
  
  function cc_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
  }
  add_filter( 'upload_mimes', 'cc_mime_types' );
  
  function fix_svg() {
	echo '<style type="text/css">
		  .attachment-266x266, .thumbnail img {
			   width: 100% !important;
			   height: auto !important;
		  }
		  </style>';
}
add_action( 'admin_head', 'fix_svg' );


/* ====================
* Register theme options page 
* ==================== */

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(
		array(
			'page_title' 	=> '全站設定',
			'menu_title'	=> '全站設定',
			'menu_slug'		=> 'website-setting-page',
			'icon_url'		=> 'dashicons-schedule',
			'capability' 	=> 'manage_options',
		)
	);
	
}

/**
 * add custom post type to archive search
 */
function tg_include_custom_post_types_in_archive_pages( $query ) {
    if ( $query->is_main_query() && ! is_admin() && ( is_archive() && !is_post_type_archive() && empty( $query->query_vars['suppress_filters'] ) ) ) {
        $query->set( 'post_type', array( 'post', 'column', 'report' ) );
    }
}
add_action( 'pre_get_posts', 'tg_include_custom_post_types_in_archive_pages' );

/**
 * get post years
 */
function get_posts_years_array($post_type = 'post') {
    global $wpdb;
    $result = array();
    $years = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT YEAR(post_date) FROM {$wpdb->posts} WHERE post_status = 'publish' AND post_type = '$post_type' GROUP BY YEAR(post_date) DESC"
        ),
        ARRAY_N
    );
    if ( is_array( $years ) && count( $years ) > 0 ) {
        foreach ( $years as $year ) {
            $result[] = $year[0];
        }
    }
    return $result;
}

/* 紀錄廣告來源 */
function get_user_ip_address(){
	$ip = null;
	if (!empty($_SERVER["HTTP_CLIENT_IP"])){
		$ip = $_SERVER["HTTP_CLIENT_IP"];
	}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}else{
		$ip = $_SERVER["REMOTE_ADDR"];
	}
	return $ip;
}

add_action("init", function(){
	if(isset($_GET["ad_src"])){
		global $wpdb;
		$ad_info = [
			"device" => 3,
			"agent" => $_SERVER['HTTP_USER_AGENT'],
			"ip_address" => get_user_ip_address(),
			"ad_src" => $_GET["ad_src"],
			"swipe" => "0"
		];

		if(preg_match('/iPad|iPod|iPhone/', $_SERVER['HTTP_USER_AGENT'])){	//ios
			$ad_info["device"] = "1";
		} else if(strpos( $_SERVER['HTTP_USER_AGENT'], 'Android')){
			$ad_indo["device"] = "2";
		}

		if(isset($_GET["swipe"])){
			$ad_info["swipe"] = $_GET["swipe"];
		}

		//寫入資料庫
		$ret = $wpdb->insert(
			$wpdb->prefix."ad_src_static",
			$ad_info,
			['%d', '%s', '%s', '%s', '%d']
		);
	}

	if(isset($_GET["swipe"])){
		global $wpdb;
		$ad_info = [
			"device" => 3,
			"agent" => $_SERVER['HTTP_USER_AGENT'],
			"ip_address" => get_user_ip_address(),
			"swipe" => $_GET["swipe"]
		];

		if(preg_match('/iPad|iPod|iPhone/', $_SERVER['HTTP_USER_AGENT'])){	//ios
			$ad_info["device"] = "1";
		} else if(strpos( $_SERVER['HTTP_USER_AGENT'], 'Android')){
			$ad_indo["device"] = "2";
		}

		//寫入資料庫
		$ret = $wpdb->insert(
			$wpdb->prefix."swipe_static",
			$ad_info,
			['%d', '%s', '%s', '%d']
		);
	}
});

add_action("admin_menu", function(){
	add_menu_page('廣告相關', '廣告統計', 'edit_posts', 'parkone_ad', 'parkone_ad_function', 'dashicons-buddicons-buddypress-logo', 70);
	add_submenu_page( 'parkone_ad', '案例統計', '案例統計', 'edit_posts', 'parkone_swipe_static', 'parkone_swipe_static');
	add_submenu_page( 'parkone_ad', '廣告相關設定', '廣告相關設定', 'edit_posts', 'parkone_ad_setting', 'parkone_ad_setting');
	add_submenu_page( 'parkone_ad', '案例相關設定', '案例相關設定', 'edit_posts', 'parkone_swipe_setting', 'parkone_swipe_setting');
});

function parkone_ad_function(){
	if ( !current_user_can( 'edit_posts' ) )  {
		wp_die( __( '您沒有存取此頁面的權限.' ) );
	}

	global $wpdb;
	require_once("template-parts/admin/ad_static.php");
}

function parkone_ad_setting(){
	if ( !current_user_can( 'edit_posts' ) )  {
		wp_die( __( '您沒有存取此頁面的權限.' ) );
	}

	$page_url = admin_url("admin.php?page=parkone_ad_setting");
	require_once("template-parts/admin/ad_setting.php");
}

function parkone_swipe_static(){
	if ( !current_user_can( 'edit_posts' ) )  {
		wp_die( __( '您沒有存取此頁面的權限.' ) );
	}

	global $wpdb;
	$page_url = admin_url("admin.php?page=swipe_static");
	require_once("template-parts/admin/swipe_static.php");
}

function parkone_swipe_setting(){
	if ( !current_user_can( 'edit_posts' ) )  {
		wp_die( __( '您沒有存取此頁面的權限.' ) );
	}

	$page_url = admin_url("admin.php?page=parkone_swipe_setting");
	require_once("template-parts/admin/swipe_setting.php");
}

/* End of 紀錄廣告來源 */