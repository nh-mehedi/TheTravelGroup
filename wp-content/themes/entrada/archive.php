<?php
/**
 * The template for displaying archive pages.
 *
 *
 * @package Entrada
 */
get_header(); ?>
<main id="main">
	<div class="content-with-sidebar common-spacing content-left">
		<div class="container">
			<div id="two-columns" class="row">
				<div id="content" class="col-sm-8 col-md-9">
					<div class="blog-holder">
						<div class="blog-list list-view" >
					<?php
						the_archive_title( '<h2 class="page-title">', '</h2>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/content', get_post_format() );
						endwhile; ?>
						<input type="hidden" class="blog_ajax_action" value="entrada_blog_defaultview">
						</div>
					</div>
					<nav class="loadmore-wrap text-center">
						<input type="hidden" id="posts_per_page" name="posts_per_page" value="<?php echo $posts_per_page; ?>" />
						<input type="hidden" id="paged" name="paged" value="2" />
						<a href="javascript:void(null);" onClick="loadmore_post();" id="blog_load_more_post" class="btn btn-default"><?php _e( 'LOAD MORE', 'entrada' ); ?></a>
					</nav>
				</div>
				<?php get_sidebar();?>
			</div>
		</div>
	</div>
</main>
<?php get_footer(); ?>