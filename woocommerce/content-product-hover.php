<?php
/**
 * The template for displaying product content within loops.
 *
 * Custom template with custom hooks created from copy of content-product.php
 *
 * @author  Noelie
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}


/*echo "columns: " . $woocommerce_loop['columns'];*/
?>
<li <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item_hover' ); ?>

	<a href="<?php the_permalink(); ?>">

		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 * @hooked hover_wrap_open 20
			 */
			do_action( 'woocommerce_before_shop_loop_item_title_hover' );

			/**
			 * woocommerce_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			do_action( 'woocommerce_shop_loop_item_title_hover' );

			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_price - 10
			 * @hooked woocommerce_template_loop_add_to_cart 30
			 * @hooked hover_wrap_close 40
			 */
			do_action( 'woocommerce_after_shop_loop_item_title_hover' );
		?>

	</a>

	<?php

		/**
		 * woocommerce_after_shop_loop_item hook
		 *
		 * @hooked show_title_after_hover - 5
		 */
		do_action( 'woocommerce_after_shop_loop_item_hover' );

	?>

</li>
