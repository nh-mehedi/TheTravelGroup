<?php 
global $loop;
if ( $loop->have_posts() ) { ?>
	<div class="content-holder content-sub-holder">
		<div class="row db-3-col post-wrapper-block">
	<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
								
			<article class="col-md-6 col-lg-4 article has-hover-s1 thumb-full">
				<div class="thumbnail" itemscope itemtype="http://schema.org/Product">
				<?php 	  
					$entrada_social_media_share_img =  entrada_social_media_share_img(get_the_ID());
					echo entrada_product_resized_img(get_the_ID(), $resize = array(550, 358)); ?>
					<h3 class="small-space"><a href="<?php the_permalink(); ?>" itemprop="name"><?php the_title(); ?></a></h3>
					<span class="info"><?php entrada_product_categories(get_the_ID(), true); ?></span>
					<aside class="meta">
						<?php entrada_destinations_activities_count(get_the_ID(), true); ?>
					</aside>
					<p itemprop="description"><?php echo entrada_truncate(strip_tags(get_the_content()), 30, 110); ?></p>
					<a href="<?php the_permalink(); ?>" class="btn btn-default" itemprop="url"><?php echo get_theme_mod( 'square_button_text', 'explore' ); ?></a>
					<footer>
					<?php 
						/* Social Media Parameter ......*/
						$share_txt  = entrada_truncate(strip_tags(get_the_content()), 30, 110); ?>
						<ul class="social-networks">
							<?php echo entrada_social_media_share_btn( get_the_title(), get_permalink(), $share_txt, $entrada_social_media_share_img ); ?>
						</ul>
						<span class="price"> <?php _e( 'from', 'entrada' ); ?> <span <?php echo entrada_price_schema_micro_data_link(get_the_ID()); ?>><?php entrada_product_price(get_the_ID(), true); ?></span></span>
					</footer>
				</div>
			</article>     
	<?php endwhile; ?>
		</div>
	</div>
<?php } ?>