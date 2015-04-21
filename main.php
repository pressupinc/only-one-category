<?php
/*
Plugin Name: Only One Category
Plugin URI: http://pressupinc.com/wordpress-plugins/only-one-category/
Description: Limits a post to a single category by changing the checkboxes into radio buttons. Simple.
Author: Press Up
Version: 1.0.0
Author URI: http://pressupinc.com
*/ 

add_action( 'admin_init', 'ooc_admin_catcher' );
function ooc_admin_catcher() {
	if ( strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) 
		|| strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' ) ) {
		ob_start( 'ooc_swap_out_checkboxes' );
		ob_flush();
	}
}

function ooc_swap_out_checkboxes($content) {
	$content = str_replace( 'type="checkbox" name="post_category', 'type="radio" name="post_category', $content );

	// for "Most Used" tab
	foreach (get_all_category_ids() as $i) { 
		$content = str_replace( 'id="in-popular-category-'.$i.'" type="checkbox"', 'id="in-popular-category-'.$i.'" type="radio"', $content );
	}

	return $content;
}