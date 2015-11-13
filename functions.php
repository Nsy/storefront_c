<?php
/*
** Styles load enqueue
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
** Storefront Homepage Hook
*/


/*
** Woocommerce Hook content-product.php remove
*/
/*remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10); 
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
*/
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
		if ( function_exists('has_post_thumbnail') && has_post_thumbnail($post->ID) ) {
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

/*
** HOOKS
*/

/*
**
*/
add_action( 'woocommerce_before_shop_loop_item_title_hover', 'new_product_defaults_wrap_open' , 20 ); // wrap open
add_action('woocommerce_before_shop_loop_item_title_hover', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action('woocommerce_shop_loop_item_title_hover', 'woocommerce_template_loop_product_title', 10);
add_action('woocommerce_after_shop_loop_item_title_hover', 'woocommerce_template_loop_price', 10);
add_action( 'woocommerce_after_shop_loop_item_title_hover', 'woocommerce_template_loop_add_to_cart', 30);
add_action( 'woocommerce_after_shop_loop_item_hover', 'show_title_after_hover', 5);
add_action( 'woocommerce_after_shop_loop_item_title_hover', 'new_product_defaults_wrap_close', 40); // wrap close

function new_product_defaults_wrap_open() {
  	echo '<div class="product-details">';
  		?><a href="<?php the_permalink(); ?>"><?php
}
function new_product_defaults_wrap_close() {
	echo '</a>';
	echo '</div><!--/.product-details-->';
}

function show_title_after_hover() {
?>
	<a href="<?php the_permalink(); ?>">
<?php
	echo "<h2>";
	the_title();
	echo "</h2>";
?>
</a>
<?php
}

/*
** Recent Product Hook (for homepage action)
** Custom Style Hover With Custom content-product-{hover}.php
*/
function noelie_recent_products() {
	wp_reset_query();

	if ( is_woocommerce_activated() ) {

			global $woocommerce_loop;
			$woocommerce_loop['columns'] = 5;
			ob_start();

			$args = array( 'post_type' => 'product',
				'posts_per_page' => $woocommerce_loop['columns'],
				'post_status' => 'publish',
				'orderby' =>'date',
				'order' => 'DESC' );
			$loop = new WP_Query( $args );

			echo '<section class="storefront-product-section storefront-recent-products">';

			echo '<h2 class="section-title">' . __( 'Recent Products', 'storefront' ) . '</h2>';
?>
			<div class="woocommerce columns-<?php echo $woocommerce_loop['columns']; ?>">
				<ul class="products">
<?php
			while ( $loop->have_posts() ) : $loop->the_post();
?>
                <?php wc_get_template_part( 'content', 'product-hover' ); ?>

				<?php endwhile; wp_reset_query();
?>
				</ul>
			</div>
<?php 
			echo '</section>';
		 	ob_get_contents();
		}
	}
add_action( 'homepage', 'noelie_recent_products', 70);

/*
** Remove all sidebar && use full-width template
*/
add_action( 'wp', 'woa_remove_sidebar_shop_page' );
function woa_remove_sidebar_shop_page() {

	if ( is_woocommerce_activated() ) {
    	if ( is_shop() || is_tax( 'product_cat' ) || get_post_type() == 'product'  ) {

			remove_action( 'storefront_sidebar', 'storefront_get_sidebar', 10 );
			add_filter( 'body_class', 'woa_remove_sidebar_class_body', 10 );
		}
	}
}

function woa_remove_sidebar_class_body( $wp_classes ) {

    $wp_classes[] = 'page-template-template-fullwidth-php';
    return $wp_classes;
}

?>