<?php
/**
 * This template file to used to show the destinations
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header();
$cate = get_queried_object();
$t_id = $cate->term_id;
$term = get_term_by( 'id', $t_id, 'product_cat' );
$term_meta = get_option( "taxonomy_$t_id" );
$banner_img_src = '';
if( array_key_exists('product_cat_banner_img_id', $term_meta ) && $term_meta['product_cat_banner_img_id']  != ''){
	$banner_img_src = wp_get_attachment_url( $term_meta['product_cat_banner_img_id'] ); ?>
	<section class="banner banner-inner parallax" data-stellar-background-ratio="0.5" style="background-image:url(<?php echo $banner_img_src;?>)">
		<div class="banner-text">
			<div class="center-text text-center">
				<div class="container">
				<?php
					if(isset($term_meta['prod_cat_heading'] ) && $term_meta['prod_cat_heading']  != ''){
						echo '<h1>'.$term_meta['prod_cat_heading'].'</h1>';
					}
					if(isset($term_meta['prod_cat_sub_heading'] ) && $term_meta['prod_cat_sub_heading']  != ''){
						echo '<strong class="subtitle">'.$term_meta['prod_cat_sub_heading'].'</strong>';
					} ?>
					<!-- breadcrumb -->
					<nav class="breadcrumbs">
						<?php entrada_custom_breadcrumbs(); ?>
					</nav>
				</div>
			</div>
		</div>
	</section>
<?php } ?>
	<!-- main container -->
	<main id="main">
		<div class="content-intro">
			<div class="container">
				<div class="row">
					<div class="col-sm-8 col-md-9 text-holder">
						<h2 class="title-heading"><?php echo $term_meta['prod_cat_sub_title']; ?></h2>
						<?php echo wpautop (do_shortcode($term->description) );?>
					</div>
					<div class="col-sm-4 col-md-3 map-col">
						<div class="holder">
						<?php
							if( array_key_exists('product_cat_map_img_id', $term_meta ) && $term_meta['product_cat_map_img_id']  != ''){
								$map_img_src = wp_get_attachment_url( $term_meta['product_cat_map_img_id'] );
								echo '<div class="map-holder"><img src="'.$map_img_src.'" height="300" width="200" alt="image description"></div>';
							} ?>
							<div class="info">
							<?php
								if(isset($term_meta['prod_cat_best_season'] ) && $term_meta['prod_cat_best_season']  != ''){
									echo '<div class="slot"><strong>'. __("Best Season", "entrada") .':</strong><span class="sub">'.$term_meta['prod_cat_best_season'].'</span></div>';
								}
								if(isset($term_meta['prod_cat_popular_location'] ) && $term_meta['prod_cat_popular_location']  != ''){
									echo '<div class="slot">
												<strong>'. __("Popular Location", "entrada") .':</strong>
												<span class="sub">'.$term_meta['prod_cat_popular_location'].'</span>
										  </div>';
								} ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- content block with boxed article -->
		<article class="content-block article-boxed">
			<div class="container">
				<header class="content-heading">
				<?php
					if(isset($term_meta['prod_cat_listing_title'] ) && $term_meta['prod_cat_listing_title']  != ''){		
						echo '<h2 class="main-heading">'.$term_meta['prod_cat_listing_title'].'</h2>';
					}
					if(isset($term_meta['prod_cat_listing_sub_title'] ) && $term_meta['prod_cat_listing_sub_title']  != ''){
						echo '<span class="main-subtitle">'.$term_meta['prod_cat_listing_sub_title'].'</span>';
					} ?>					
					<div class="seperator"></div>
				</header>
			<?php
				$args = array(
						'posts_per_page' 	=> -1,
						'post_type' 		=> 'product',
						'tax_query'     	=> array(
												array(
													'taxonomy'  => 'destination',
													'field'     => 'id',
													'terms'     => array($t_id)
												)
											)
					);
				$loop = new WP_Query( $args );
				if ( $loop->have_posts() ) { ?>
					<div class="content-holder content-boxed">
						<div class="row db-3-col">
						<?php
							while ( $loop->have_posts() ) : $loop->the_post();
							$entrada_social_media_share_img = '';
							$share_txt = entrada_truncate(strip_tags(get_the_content()), 30, 120); 
							$average_rating =  entrada_post_average_rating(get_the_ID()); ?>
							<article class="col-sm-6 col-md-4 article has-hover-s1">
								<div class="thumbnail" itemscope itemtype="http://schema.org/Product">
								<?php
									$entrada_social_media_share_img =  entrada_social_media_share_img(get_the_ID());
									echo entrada_product_resized_img(get_the_ID(), $resize = array(550, 358)); ?>
									<h3 class="small-space"><a href="<?php the_permalink(); ?>" itemprop="name"><?php the_title(); ?></a></h3>
									<span class="info"><?php entrada_product_categories(get_the_ID(), true); ?></span>
									<aside class="meta">
										<?php entrada_destinations_activities_count(get_the_ID(), true); ?>
									</aside>
									<p itemprop="description"><?php echo entrada_truncate(strip_tags(get_the_content()), 30, 120); ?></p>
									<a href="<?php the_permalink(); ?>" class="btn btn-default" itemprop="url"><?php echo get_theme_mod( 'square_button_text', 'Explore' ); ?></a>
									<footer>
										<ul class="social-networks"><?php echo entrada_social_media_share_btn(get_the_title($loop->ID), get_permalink($loop->ID), $share_txt, $entrada_social_media_share_img ); ?>
										</ul>
										<span class="price"> <?php _e('from', 'entrada'); ?> <span <?php echo entrada_price_schema_micro_data_link(get_the_ID()); ?>><?php entrada_product_price(get_the_ID(), true); ?></span></span>
									</footer>
								</div>
							</article>
						  <?php endwhile; ?>
						</div>
					</div>
		<?php 	} ?>
			</div>
		</article>
		<!-- recent block -->
		<?php get_template_part( 'template-parts/similar', 'tours' ); ?>
	</main>
<?php get_footer(); ?>