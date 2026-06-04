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
$class_name = 'pko-banner-block';
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
$title_en = get_field( 'title_en' ) ? get_field( 'title_en' ) : 'Contact us';
$title = get_field( 'title' ) ? get_field( 'title' ) : '聯絡我們';
$desc = get_field('desc') ? get_field('desc') : '';
$bg_lg = get_field( 'bg_img_lg' ) ? get_field( 'bg_img_lg' ) : wp_get_attachment_image_url(295, [2000, 700]);
$bg_sm = get_field( 'bg_img_sm' ) ? get_field( 'bg_img_sm' ) : get_field( 'bg_img_lg' );
$layout = get_field('layout') ? get_field('layout') : 'left';
$buttons = get_field('buttons');
?>
<div <?php echo $anchor; ?> class="<?php echo esc_attr( $class_name ); ?>">
    <div class="pko-banner-bg pko-banner-bg-<?= $layout ?>">
        <img src="<?= $bg_lg ?>" class="pko-banner-img-lg" />
        <img src="<?= $bg_sm ?>" class="pko-banner-img-sm" />
    </div>
    <div class="pko-banner-container fadein">
        <div class="pko-banner-card">
            <h6><?= $title_en ?></h6>
            <h2><?= $title ?></h2>
            <p><?= $desc ?></p>
            <div class="pko-banner-btns">
            <?php if($buttons): foreach($buttons as $btn):
                $padding = $btn['style'] == '' ? 'px-0':'' ;
            ?>
                <a href="<?= $btn['link']['url'] ?>" target="<?= $btn['link']['target'] ?>" class="btn <?= $btn['style']. ' ' . $padding ?>"><?= $btn['link']['title'] ?></a>
            <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
</div>