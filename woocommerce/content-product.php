<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
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
$classes[] = 'img-list';
?>
<li <?php post_class( $classes ); ?>>

<!-- woocommerce_before_shop_loop_item_title -->
	<div class="img-list">
		<div class="li-mask">


			<a href="<?php the_permalink(); ?>">
				<img class="img-circle" src="<?php echo ns_get_post_thumbnail_url(); ?>"> 
				<div class="text-content">
					<h3><?php the_title(); ?></h3>
					<p><?php echo "Text Extra" ?></p>
					<span><?php echo $product->get_price_html(); ?></span>
				</div>
			</a>
			<h3><?php the_title(); ?></h3>

<!-- woocommerce_after_shop_loop_item_title -->

		</div>
	</div>

</li>