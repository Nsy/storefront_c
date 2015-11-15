<?php
/*
** Homepage
*/
function remove_homepage_hooks() {
	remove_action('homepage', 'storefront_homepage_content', 10);
	remove_action('homepage', 'storefront_product_categories', 20);
	remove_action('homepage', 'storefront_recent_products', 30);
	remove_action('homepage', 'storefront_featured_products', 40);
	remove_action('homepage', 'storefront_popular_products', 50);
	remove_action('homepage', 'storefront_on_sale_products', 60);
}
add_action('init', 'remove_homepage_hooks', 15);

/*
** Hover hooks for content-product-hover.php
*/
add_action('woocommerce_before_shop_loop_item_title_hover', 'hover_wrap_open' , 20); // wrap open
add_action('woocommerce_before_shop_loop_item_title_hover', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('woocommerce_shop_loop_item_title_hover', 'woocommerce_template_loop_product_title', 10);
add_action('woocommerce_after_shop_loop_item_title_hover', 'woocommerce_template_loop_price', 10);
add_action('woocommerce_after_shop_loop_item_title_hover', 'woocommerce_template_loop_add_to_cart', 30);
add_action('woocommerce_after_shop_loop_item_title_hover', 'hover_wrap_close', 40); // wrap close
add_action('woocommerce_after_shop_loop_item_hover', 'show_title_after_hover', 5);

function hover_wrap_open() {
  	echo '<div class="product-details">';
  		?><a href="<?php the_permalink(); ?>"><?php
}

function hover_wrap_close() {
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
?>