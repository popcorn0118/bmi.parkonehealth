<?php
/**
 * 醫療團隊
 */
get_header();
get_template_part( 'template-parts/header', 'about' );

?>
<main id="page_contact" class="page bg-white-60 bg-blur">
    <?php if ( have_posts() ) : ?>
    <section class="pt-20 pb-30">
        <div class="container">
            <div class="text-center">
                <h6 class="mb-2"><?= get_field('title_en') ?></h6>
                <h2 class="mb-0"><?= get_the_title() ?></h2>
            </div>
            <div class="mt-16 pb-10 fs-md lh-xl entry-content">
                <?= get_the_content() ?>
            </div>
        </div>
    </section>
    <?php
    else :
        get_template_part( 'template-parts/content', 'none' );
    endif
    ?>
</main>
<?php
get_template_part( 'template-parts/content', 'about' );
get_footer();
?>