<?php
/*
Plugin Name: EOS Blocks
Description: 依賴 ACF PRO 製作的擴充 Gutengberg Blocks
Author: EOS Creative Ltd.
Author URI: https://eoscreative.co/
Version: 1.0
*/

// 使用個別 blocks 需安裝 ACF PRO 及 複製關聯的ACF欄位

// Register a custom block.
add_action( 'init', 'register_acf_blocks' );
function register_acf_blocks() {

    register_block_type( __DIR__ . '/blocks/social-links' );
    register_block_type( __DIR__ . '/blocks/img-text' );
    register_block_type( __DIR__ . '/blocks/video-text' );
    register_block_type( __DIR__ . '/blocks/masonry-gallery' );
    register_block_type( __DIR__ . '/blocks/process' );
    register_block_type( __DIR__ . '/blocks/banner-card' );
    register_block_type( __DIR__ . '/blocks/program' );
    register_block_type( __DIR__ . '/blocks/img-card' );
    register_block_type( __DIR__ . '/blocks/post-card' );

    include_once( __DIR__ . '/blocks/social-links/acf.php' );
    include_once( __DIR__ . '/blocks/img-text/acf.php' );
    include_once( __DIR__ . '/blocks/video-text/acf.php' );
    include_once( __DIR__ . '/blocks/masonry-gallery/acf.php' );
    include_once( __DIR__ . '/blocks/process/acf.php' );
    include_once( __DIR__ . '/blocks/banner-card/acf.php' );
    include_once( __DIR__ . '/blocks/program/acf.php' );
    include_once( __DIR__ . '/blocks/img-card/acf.php' );
    include_once( __DIR__ . '/blocks/post-card/acf.php' );

}
?>