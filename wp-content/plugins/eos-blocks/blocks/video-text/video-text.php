<?php
/**
 * video-text Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'video-text-block';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}
if( $is_preview ) {
    $class_name .= ' is-admin';
}
// Load values and assign defaults.
$title_en = get_field( 'title_en' ) ? get_field( 'title_en' ) : 'Mental Journey';
$title = get_field( 'title' ) ? get_field( 'title' ) : '心路歷程紀錄片';
$videos = get_field( 'videos' ) ? get_field( 'videos' ) : ['https://www.youtube.com/embed/CSkLRrC1d1M'];

?>
<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?> mt-16">
    <div class="text-center py-10">
        <h6 class="mb-2"><?= $title_en ?></h6>
        <h2 class="mb-6"><?= $title ?></h2>
    </div>
    <div class="eos-video-wrap">
    <?php foreach($videos as $video):
        $url = $video['url'];
        $code = explode('=', $url)[1]
    ?>
        <iframe src="https://www.youtube.com/embed/<?= $code ?>"
            title="YouTube video player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
        </iframe>
    <?php endforeach ?>
    </div>
</div>