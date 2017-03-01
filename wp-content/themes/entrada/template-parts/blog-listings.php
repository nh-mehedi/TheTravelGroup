<?php
$full_length = get_theme_mod( 'blog_full_onoff' );
$posts_per_page = '';
$posts_per_page = (int)get_theme_mod( 'blog_per_page' );
if( empty( $posts_per_page ) ){
	$posts_per_page = (int)get_option( 'posts_per_page' );
}
$args = array(
			'post_type' 		=> 'post',
			'posts_per_page' 	=> $posts_per_page,
			'paged' 			=> 1,
		);
$blogpost = new WP_Query( $args );
if ( $blogpost->have_posts() ) { ?>
	<div class="blog-holder">
		<div class="blog-list">
	<?php
		while ( $blogpost->have_posts() ) : $blogpost->the_post();
			if( empty( $full_length ) ){
				$word = (int)get_theme_mod( 'blog_excerpt_word_length', 70 );
				$char = (int)get_theme_mod( 'blog_excerpt_char_length', 150 );
				$content = entrada_truncate( strip_tags( get_the_content( get_the_ID() ) ), $word, $char );
			}
			else{
				$content = get_the_content( get_the_ID() );
			}
			$average_rating =  entrada_post_average_rating(  get_the_ID() ); ?>
			<article class="article blog-article">
				<?php echo entrada_image_holder( get_the_ID() , array(870, 480) ); ?> 
				<div class="description">
					<header class="heading">
						<h3><a href="<?php the_permalink( get_the_ID()); ?>"><?php echo get_the_title( get_the_ID()); ?></a></h3>
						<time class="info-day" datetime="2011-01-12"><?php the_time('jS, M') ?></time>
					</header>
					<p><?php echo $content; ?></p>
					<footer class="meta">
						<div class="star-rating">
							<input class="product_rating" type="hidden" value="<?php echo $average_rating; ?>">
							<div class="product_rateYo"></div>
						</div>
						<div class="footer-sub">
							<div class="rate-info">
								Post by <a href="#"><?php the_author(); ?></a>
							</div>
							<div class="comment">
								<?php $count = entrada_post_total_reviews( get_the_ID(), true ); ?>
                        		<a href="<?php the_permalink( get_the_ID() ); ?>"><?php printf( esc_html( _n( '%d Comment', '%d Comments', $count, 'entrada'  ) ), $count ); ?></a>
							</div>
						</div>
						<ul class="ico-action">
							<?php echo entrada_sharethis_nav( get_the_ID()); ?>
							<li>
								<?php echo entrada_wishlist_html(  get_the_ID()); ?>
							</li>
						</ul>
					</footer>
					<div class="link-view">
						<a href="<?php the_permalink( get_the_ID()); ?>"><?php _e( 'VIEW POST', 'entrada' ); ?></a>
					</div>
				</div>
			</article>
	<?php 
		endwhile; 
		wp_reset_query(); ?>				
		</div>
	</div>
	<nav class="loadmore-wrap text-center">
		<input type="hidden" id="posts_per_page" name="posts_per_page" value="<?php echo $posts_per_page; ?>" />
		<input type="hidden" id="paged" name="paged" value="2" />
		<a href="javascript:void(null);" id="blog_load_more_post" class="btn btn-default"><?php _e( 'LOAD MORE', 'entrada' ); ?></a>
	</nav>
<?php
}
else { ?>
    <div class="blog-holder">
        <div class="blog-list">
        	<div class="pagination-wrap"><p><?php _e( 'No post found.', 'entrada' ); ?></p> </div>
        </div>
    </div>
<?php } ?>