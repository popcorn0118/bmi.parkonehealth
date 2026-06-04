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
$class_name = 'pko-img-card-block';
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
$img = get_field('img');
$text = get_field('text');
$link = get_field('link');
?>
<div <?php echo $anchor; ?> class="<?php echo esc_attr( $class_name ); ?>">
    <div class="pko-img-wrap">
        <div class="pko-img-wrap">
            <div class="pko-img-wrap-img">
                <?= wp_get_attachment_image($img, [1120, 640]); ?>
            </div>
            <div class="pko-img-wrap-card <?= $link ? 'has-btn':''; ?>">
                <div class="pko-img-wrap-title">
                    <h4><?= $text ?></h4>
                </div>
                <?php if($link): ?>
                <a href="<?= $link['url'] ?>" target="<?= $link['target'] ?>" class="pko-img-wrap-btn"><?= $link['title'] ?></a>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>