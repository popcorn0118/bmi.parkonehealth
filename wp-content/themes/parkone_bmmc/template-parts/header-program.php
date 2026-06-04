<?php
global $post, $parent_post;
if($parent_post):

$c_args = array(
    'post_type'      => 'page',
    'post_status'    => 'published',
    'post_parent'    => $parent_post->ID,
    'orderby'        => 'name',
    'order'          => 'ASC'
);

$children_posts = get_posts( $c_args );
?>
<section class="pt-20">
    <div class="container">
        <div class="swiper program-swiper program-list">
            <div class="swiper-wrapper">
            <?php
            foreach($children_posts as $index => $c_post):
                $is_current = $post->ID === $c_post->ID ? 'current-item':'';
            ?>
                <div class="swiper-slide d-flex justify-center">
                    <a href="<?= get_permalink($c_post->ID) ?>" class="text-center program-item <?= $is_current ?>"
                    data-index="<?= $index ?>" data-slug="<?= $c_post->post_name ?>">
                        <div class="bg-primary-dark img-circle">
                            <?= get_the_post_thumbnail($c_post->ID) ?>
                        </div>
                        <h4 class="mt-8 mb-0"><?= $c_post->post_title ?></h4>
                    </a>
                </div>
            <?php endforeach ?>
            </div>
            <button class="swiper-button-prev btn-circle d-md-none"><span class="icon-arrow-prev"></span></button>
            <button class="swiper-button-next btn-circle d-md-none"><span class="icon-arrow-next"></span></button>
        </div>
    </div>
</section>
<?php endif; ?>