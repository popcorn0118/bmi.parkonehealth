<?php
/**
 * macy-gallery Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $pko_post_id The post ID the block is rendering content against.
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
$class_name = 'pko-post-card-block';
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
$pko_post = get_field('pko_post');
$img = get_field('img') ? wp_get_attachment_image(get_field('img'), [1120, 1658]) : get_the_post_thumbnail($pko_post, [1120, 640]);
$type = get_field('type');
$title = get_field('title') ? get_field('title') : get_the_title($pko_post);
$button_text = get_field('button_text');
?>
<div <?php echo $anchor; ?> class="<?php echo esc_attr( $class_name ); ?>">
    <div class="pko-post-wrap">
        <div class="pko-post-wrap">
            <div class="pko-post-wrap-img">
                <?= $img; ?>
            </div>
            <div class="pko-post-wrap-card">
                <div class="pko-post-wrap-title">
                    <h5><?= $type ?></h5>
                    <h3><?= $title ?></h3>
                </div>
                <a href="<?= get_permalink($pko_post) ?>" class="program-post-btn"><?= $button_text ?></a>
            </div>
        </div>
    </div>
</div>