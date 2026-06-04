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
$class_name = 'process-block';
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
$title_en = get_field( 'title_en' ) ? get_field( 'title_en' ) : 'Consultation Process';
$title = get_field( 'title' ) ? get_field( 'title' ) : '看診流程';
$bg_id = get_field( 'bg' ) ? get_field( 'bg' )['id'] : 295;
$steps = get_field( 'steps' );
?>
<div <?php echo $anchor; ?> class="<?php echo esc_attr( $class_name ); ?>">
    <div class="container">
        <div class="process-wrap">
            <div class="process-bg">
                <?php echo wp_get_attachment_image( $bg_id, [1200, 1200] ); ?>
            </div>
            <div class="process-card">
                <div class="process-header">
                    <h6><?= $title_en ?></h6>
                    <h2><?= $title ?></h2>
                </div>
                <ol class="process-list">
                    <?php if($steps): foreach($steps as $index => $step): ?>
                    <li>
                        <h4><?= $step['title'] ?></h4>
                        <p><?= $step['desc'] ?></p>
                    </li>
                    <?php endforeach; endif; ?>
                </ol>
            </div>
        </div>
    </div>
</div>