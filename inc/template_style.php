<?php
/*
** Remove all sidebar && use full-width template of storefront
*/
add_action( 'wp', 'woa_remove_sidebar_shop_page' );
function woa_remove_sidebar_shop_page() {

	if (is_woocommerce_activated()) {
    	if (is_shop() || is_tax( 'product_cat' ) || get_post_type() == 'product') {

			remove_action('storefront_sidebar', 'storefront_get_sidebar', 10);
			add_filter('body_class', 'woa_remove_sidebar_class_body', 10);
		}
	}
}
function woa_remove_sidebar_class_body( $wp_classes ) {

    $wp_classes[] = 'page-template-template-fullwidth-php';
    return $wp_classes;
}
?>