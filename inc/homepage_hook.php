<?php

/*
** Hook List
*/
add_action('homepage', 'noelie_homepage_content', 65);
add_action('homepage', 'noelie_recent_products', 70);
add_action('homepage', 'noelie_product_categories', 80);
add_action('homepage', 'noelie_featured_products', 90);
add_action('homepage', 'noelie_popular_products', 100);
add_action('homepage', 'noelie_on_sale_products', 110);

/*
** Homepage Content
*/
function noelie_homepage_content() {
	while ( have_posts() ) : the_post();
		get_template_part( 'content', 'page' );
	endwhile;
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
?>