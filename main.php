<?php
/*
Plugin Name: Only One Category
Plugin URI: http://pressupinc.com/wordpress-plugins/only-one-category/
Description: Limits a post to a single category by changing the checkboxes into radio buttons. Simple.
Author: Press Up
Version: 0.2.0
Author URI: http://pressupinc.com
*/ 


function ooc_admin_catcher() {
	if( strstr($_SERVER['REQUEST_URI'], 'wp-admin/post-new.php') 
		|| strstr($_SERVER['REQUEST_URI'], 'wp-admin/post.php') 
		|| strstr($_SERVER['REQUEST_URI'], 'wp-admin/edit.php') ) {
	  ob_start('ooc_one_category_only');
	}
}
add_action( 'init', 'ooc_admin_catcher' );

function ooc_one_category_only($content) {
	return ooc_swap_out_checkboxes($content);
}


function ooc_swap_out_checkboxes($content) {
	$content = str_replace('type="checkbox" name="post_category', 'type="radio" name="post_category', $content);

	foreach (get_all_category_ids() as $i) { 
		$content = str_replace('id="in-popular-category-'.$i.'" type="checkbox"', 'id="in-popular-category-'.$i.'" type="radio"', $content);
	}

	return $content;
}