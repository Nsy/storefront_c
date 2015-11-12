<?php
/*
** Styles load
*/

function theme_enqueue_styles() {

    $parent_style = 'parent-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

/*
** Hook content-product
*/
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10); 
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

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

function var_dump_thumbnail() {
		if ( function_exists('has_post_thumbnail') && has_post_thumbnail($post->ID) ) {
 		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), full);
 		var_dump($thumbnail);
 	}
 	echo "nope";
	}

/*function get_meta_woo() {
	$thumbnail_object = get_post(get_post_thumbnail_id($post->ID));
	var_dump($thumbnail_object);
}*/
?>