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
$class_name = 'program-block';
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
$desc_items = get_field('desc_items');
$related = get_field('related');
$embed = get_field('embed') !== NULL ? get_field('embed') : 'post';
?>
<div <?php echo $anchor; ?> class="<?php echo esc_attr( $class_name ); ?>">
    <div class="program-wrap <?= $embed != '' ? 'program-has-post':'' ; ?>">
        <div class="program-content">
            <?php foreach($desc_items as $item): ?>
                <div>
                    <h3><?= $item['title'] ?></h3>
                    <div><?= $item['content'] ?></div>
                </div>
            <?php endforeach ?>
        </div>
        <?php if($embed != ''):?>
        <div class="program-post">
        <?php
            if($embed == 'post' && $related['post']):
                $type = $related['type'] ? $related['type'] : '案例分享';
                $title = $related['title'] ? $related['title'] : get_the_title($related['post']);
        ?>
            <div class="program-post-img">
                <?= $related['img'] ? wp_get_attachment_image($related['img'], [1120, 640]) : get_the_post_thumbnail($related['post'], [1120, 640]) ; ?>
            </div>
            <div class="program-post-card">
                <div class="program-post-title">
                    <h5><?= $type ?></h5>
                    <h3><?= $title ?></h3>
                </div>
                <?php if($related['button_text'] != ''):?>
                <a href="<?= get_permalink($related['post']) ?>" class="program-post-btn"><?= $related['button_text'] ?></a>
                <?php endif ?>
            </div>
            <?php elseif($embed == 'video'):
                $video = get_field('video');
                $code = explode('=', $video)[1];
            ?>
            <div class="program-post-video">
                <iframe src="https://www.youtube.com/embed/<?= $code ?>"
                    title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>
            <?php endif ?>
        </div>
        <?php endif ?>
    </div>
</div>