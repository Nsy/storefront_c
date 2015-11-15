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

/*
** Recent Product Hook (for homepage action)
** Custom Style Hover With Custom content-product-{hover}.php
*/
function noelie_recent_products() {
	if ( is_woocommerce_activated() ) {
		wp_reset_query();
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
** Product Category (for homepage action)
** Using default style content-product_cat.php
*/
function noelie_product_categories() {
	if (is_woocommerce_activated()) {
		global $woocommerce_loop;
		$woosave_loop = $woocommerce_loop;
		$woocommerce_loop['columns'] = 3;
		ob_start();
		$args = array(
         'taxonomy'     => 'product_cat',
         'orderby'      => 'name',
         'show_count'   => 0,
         'pad_counts'   => 0,
         'hierarchical' => 1,
         'title_li'     => '',
         'hide_empty'   => 0
  		);
 		$all_categories = get_categories($args);
 		$nbrr = count($all_categories);
 		echo '<section class="storefront-product-section storefront-product-categories">';
 		echo '<h2 class="section-title">' . __('Product Categories', 'storefront') . '</h2>';
?>
		<div class="woocommerce columns-<?php echo $woocommerce_loop['columns']; ?>">
 		<ul class="products">
<?php
		$nbr = 1;
 		foreach ($all_categories as $cat) {
 			if ($cat->category_parent == 0 && $nb < $woocommerce_loop['columns']) {
 				$category_id = $cat->term_id;
 				wc_get_template('content-product_cat.php', array(
					'category' => $cat
				) );       
        		++$nb;
        		/*get_term_link($cat->slug, 'product_cat')*/
 			}
 		}
		ob_get_contents();
		$woocommerce_loop = $woosave_loop;
	}
}
add_action('homepage', 'noelie_product_categories', 80);

/*
** Featured Product Hook (for homepage action)
** Using hover style with custom added css (storefront-featured-products class)
*/
function noelie_featured_products() {
	if ( is_woocommerce_activated() ) {
		wp_reset_query();
		global $woocommerce_loop;
		$woocommerce_loop['columns'] = 4;
		ob_start();

		$meta_query   = WC()->query->get_meta_query();
		$meta_query[] = array(
    	'key'   => '_featured',
    	'value' => 'yes'
		);
		$args = array(
    	'post_type'   =>  'product',
    	'stock'		  =>  1,
    	'showposts'   =>  6,
    	'orderby'     =>  'date',
    	'order'       =>  'DESC',
    	'meta_query'  =>  $meta_query
		);
		$loop = new WP_Query( $args );

		echo '<section class="storefront-product-section storefront-featured-products">';

		echo '<h2 class="section-title">' . __('Featured Products', 'storefront') . '</h2>';
?>
		<div class="woocommerce columns-<?php echo $woocommerce_loop['columns']; ?>">
			<ul class="products">
<?php
		while ( $loop->have_posts() ) : $loop->the_post();
?>
			<?php wc_get_template_part('content', 'product-hover'); ?>

			<?php endwhile; wp_reset_query();
?>
			</ul>
		</div>
<?php 
		echo '</section>';
		 ob_get_contents();
	}
}
add_action('homepage', 'noelie_featured_products', 90);

/*
** Popular Product Hook (for homepage action)
** Using default style
*/
function noelie_popular_products() {
	if ( is_woocommerce_activated() ) {
		global $woocommerce_loop;
		$woocommerce_loop['columns'] = 4;
		ob_start();
		$query_args = array(
			'posts_per_page' => $woocommerce_loop['columns'],
			'no_found_rows' => 1,
			'post_status' => 'publish',
			'post_type' => 'product');
		add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
		$query_args['meta_query'] = WC()->query->get_meta_query();
		$loop = new WP_Query($query_args);
		echo '<section class="storefront-product-section storefront-popular-products">';

		echo '<h2 class="section-title">' . __('Top Rated Products', 'storefront') . '</h2>';
?>
		<div class="woocommerce columns-<?php echo $woocommerce_loop['columns']; ?>">
			<ul class="products">
<?php
		while ( $loop->have_posts() ) : $loop->the_post();
?>
		<?php wc_get_template_part('content', 'product'); ?>

		<?php endwhile;
		wp_reset_query();
		remove_filter('posts_clauses', array( WC()->query, 'order_by_rating_post_clauses')); ?>
			</ul>
		</div>
<?php	echo '</section>';
		ob_get_contents();
	}
}
add_action('homepage', 'noelie_popular_products', 100);

/*
** Sale Product Hook (for homepage action)
** Using default style
*/
function noelie_on_sale_products() {
	if ( is_woocommerce_activated() ) {
		global $woocommerce_loop;
		$woocommerce_loop['columns'] = 4;
		ob_start();

		$args = array(
			'post_type' 	=> 'product',
			'posts_per_page'=> $woocommerce_loop['columns'],
			'post_status' 	=> 'publish',
			'orderby' 		=>'date',
			'order' 		=> 'ASC',
			'meta_query'	=> array(
				array(
            		'key'           => '_sale_price',
            		'value'         => 0,
            		'compare'       => '>',
            		'type'          => 'numeric'
        		)
        	)
			);
		$loop = new WP_Query( $args );

		echo '<section class="storefront-product-section storefront-on-sale-products">';

		echo '<h2 class="section-title">' . __('On Sale', 'storefront') . '</h2>';
?>
		<div class="woocommerce columns-<?php echo $woocommerce_loop['columns']; ?>">
			<ul class="products">
<?php
		while ( $loop->have_posts() ) : $loop->the_post();
?>
            <?php wc_get_template_part('content', 'product'); ?>

			<?php endwhile; wp_reset_query();
?>
			</ul>
		</div>
<?php 
		echo '</section>';
		 ob_get_contents();
	}
}
add_action( 'homepage', 'noelie_on_sale_products', 110);

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