<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Entrada
 */
$entrada_avg_rate = entrada_post_average_rating( get_the_ID() );
if( !empty( $entrada_avg_rate ) ){
	$average_rating =  entrada_post_average_rating( get_the_ID() );
}
else {
	$average_rating = 0;	
}
echo entrada_image_holder(  get_the_ID() , array(870, 480) );  ?>
<div class="description">
	<h1 class="content-main-heading"><?php the_title(); ?></h1>
	<?php the_content(); ?>
	<footer class="meta-article">
		<div class="star-rating">
			<input class="single_blog_rating" type="hidden" value="<?php echo $average_rating; ?>">
			<div class="single_blog_rateYo"></div>
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
			<li><?php echo entrada_wishlist_html( get_the_ID() ); ?></li>
		</ul>
	</footer>
</div>
<?php entrada_page_nav(); ?>