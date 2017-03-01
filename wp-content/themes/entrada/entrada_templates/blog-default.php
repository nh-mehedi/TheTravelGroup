<?php
/*
Template Name: Blog (Default)
*/
get_header();
while ( have_posts() ) : the_post();
	get_template_part( 'template-parts/banner', 'section' ); ?>
	<main id="main">
		<div class="content-with-sidebar common-spacing content-left">
			<div class="container">
				<div id="two-columns" class="row">
					<div id="content" class='col-sm-8 col-md-9'>
						<?php get_template_part( 'template-parts/blog', 'default' ); ?>
						<input type="hidden" class="blog_ajax_action" value="<?php echo esc_attr( 'entrada_blog_defaultview' ); ?>">
					</div>
					<?php get_sidebar(); ?>
				</div>
			</div>
		</div>
	</main> 
<?php endwhile;
get_footer(); ?>