<?php
/*
Plugin Name: Only One Category
Plugin URI: http://pressupinc.com/plugins/one-category-only
Description: Turn categories from checkboxes to radio buttons
Author: Press Up
Version: 0.1.3
Author URI: http://pressupinc.com
*/ 

if( strstr($_SERVER['REQUEST_URI'], 'wp-admin/post-new.php') 
	|| strstr($_SERVER['REQUEST_URI'], 'wp-admin/post.php') 
	|| strstr($_SERVER['REQUEST_URI'], 'wp-admin/edit.php') ) {
  ob_start('ooc_one_category_only');
}


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