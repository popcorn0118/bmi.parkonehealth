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
$class_name = 'macy-gallery-block';
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
$title_en = get_field( 'title_en' ) ? get_field( 'title_en' ) : 'Weight Loss Record';
$title = get_field( 'title' ) ? get_field( 'title' ) : '減重紀錄';
$images = get_field( 'images' ) ? get_field( 'images' ) : [295];

?>
<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?> mt-16">
    <div class="text-center py-10">
        <h6 class="mb-2"><?= $title_en ?></h6>
        <h2 class="mb-6"><?= $title ?></h2>
    </div>
    <div id="macy-container" class="macy-gallery-images">
        <?php foreach($images as $image): ?>
            <?php if($is_preview): ?>
                <?php echo wp_get_attachment_image( $image['id'], [240, 600] ); ?>
            <?php else: ?>
            <a class="glightbox"
                data-glightbox="title:<?= $image['title'] ?>" href="<?= $image['url'] ?>">
                <?php echo wp_get_attachment_image( $image['id'], [362, 800] ); ?>
            </a>
            <?php endif ?>
        <?php endforeach ?>
    </div>
</div>