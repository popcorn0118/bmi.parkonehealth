<?php
/**
 * macy-gallery Block Template.
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
$class_name = 'social-links-block';
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
$social_medias = get_field('social_medias')

?>
<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>">
    <ul class="social-links">
        <?php foreach($social_medias as $item): ?>
        <li><a href="<?= $item['link'] ?>" target="_blank" class="btn-social-media" rel="noopener"><span class="icon-<?= $item['type'] ?>"></span></a></li>
        <?php endforeach ?>
    </ul>
</div>