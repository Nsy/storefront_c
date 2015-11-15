<?php
/*
** Utils get thumbnail url
*/
if (!function_exists(ns_get_post_thumbnail_url)) {

	function ns_get_post_thumbnail_url() {
		if ( function_exists('has_post_thumbnail') && has_post_thumbnail($post->ID) ) {
 		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full);
		if (!$thumbnail[0] || $thumbnail[0] == "") {
			return wc_placeholder_img_src();
		}
		else {
			return $thumbnail[0];
			}
		}
		echo wc_placeholder_img_src();
	}
}

/*
** Debug var dump info thumbnail
*/
function var_dump_thumbnail() {
		if ( function_exists('has_post_thumbnail') && has_post_thumbnail($post->ID)) {
 		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full);
 		var_dump($thumbnail);
 	}
 	echo "nope";
}

/*
** Debug meta post
*/
/*function get_meta_woo() {
	$thumbnail_object = get_post(get_post_thumbnail_id($post->ID));
	var_dump($thumbnail_object);
}*/
?>