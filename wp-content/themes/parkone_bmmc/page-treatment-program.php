<?php
/**
 * 服務項目
 */

get_header();
get_template_part( 'template-parts/header', '' );

?>
	
	<main id="page_group" class="page bg-white-60 bg-blur">
    	<section class="pt-20 pb-30">
			<div class="container">
				<?php echo get_the_content(); ?>
			</div>
		</section>
	</main>

<?php
get_footer();
?>