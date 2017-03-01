<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Entrada
 */
if ( ! function_exists( 'entrada_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function entrada_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}
	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'entrada' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'entrada' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
}
endif;
if ( ! function_exists( 'entrada_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function entrada_entry_footer() {
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'entrada' ) );
		if ( $categories_list && entrada_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'entrada' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'entrada' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'entrada' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'entrada' ), esc_html__( '1 Comment', 'entrada' ), esc_html__( '% Comments', 'entrada' ) );
		echo '</span>';
	}
	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'entrada' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;
/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function entrada_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'entrada_categories' ) ) ) {
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			'number'     => 2,
		) );
		$all_the_cool_cats = count( $all_the_cool_cats );
		set_transient( 'entrada_categories', $all_the_cool_cats );
	}
	if ( $all_the_cool_cats > 1 ) {
		return true;
	} else {
		return false;
	}
}
/**
 * Flush out the transients used in entrada_categorized_blog.
 */
function entrada_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	delete_transient( 'entrada_categories' );
}
add_action( 'edit_category', 'entrada_category_transient_flusher' );
add_action( 'save_post',     'entrada_category_transient_flusher' );