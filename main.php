<?php
/*
Plugin Name: Only One Category
Plugin URI: http://pressupinc.com/wordpress-plugins/only-one-category/
Description: Limits a post to a single category by changing the checkboxes into radio buttons. Simple.
Author: Press Up
Version: 1.0.4
Author URI: http://pressupinc.com
*/

add_action( 'admin_init', 'ooc_admin_catcher' );
function ooc_admin_catcher() {
	if ( strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' )
		|| strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' )
		|| strstr( $_SERVER['REQUEST_URI'], 'wp-admin/edit.php' )) {
		ob_start( 'ooc_swap_out_checkboxes' );
		ob_flush();
	}
}

function ooc_swap_out_checkboxes($content) {
	$content = str_replace( 'type="checkbox" name="post_category', 'type="radio" name="post_category', $content );

	// for "Most Used" tab
	$categories = get_terms( 'category' );

	foreach ($categories as $i) {
		$content = str_replace( 'id="in-popular-category-'.$i->term_id.'" type="checkbox"', 'id="in-popular-category-'.$i->term_id.'" type="radio"', $content );
	}

	return $content;
}

/* load script in the footer */
if ( ! function_exists('ooc_admin_enqueue_scripts') ):
function ooc_admin_enqueue_scripts( $hook ) {

	if ( 'edit.php' === $hook ) {

		wp_enqueue_script( 'ooc_inline_edit_script', plugins_url('js/inline-edit.js', __FILE__),
			false, null, true );

	}

}
endif;
add_action( 'admin_enqueue_scripts', 'ooc_admin_enqueue_scripts' );
