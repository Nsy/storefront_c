<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */
?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-full">

			<?php
			/**
			 * @hooked storefront_footer_widgets - 10
			 * @hooked storefront_credit - 20
			 */
			do_action( 'storefront_footer' ); ?>

		</div><!-- .col-full -->
	</footer><!-- #colophon -->

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

<script type='text/javascript' src='<?php echo esc_url(get_stylesheet_directory_uri()); ?>/js/jquery.waitforimages.js'></script>
<script type="text/javascript">
(function($) {
$(window).on('resize', function(){

	console.log("pageloaded");
    var x_featured = $('.storefront-featured-products .wp-post-image').height();
	$('.storefront-featured-products .product-details').css(
    	{'width': x_featured + 'px'}
	);
	$('.storefront-featured-products .product-details').css(
		{'height': x_featured + 'px'}
	);
    var x_recent = $('.storefront-recent-products .wp-post-image').height();
	$('.storefront-recent-products .product-details').css(
    	{'width': x_recent + 'px'}
	);
	$('.storefront-recent-products .product-details').css(
    	{'height': x_recent + 'px'}
	);

});
}(jQuery));

(function($) {
$('.products').waitForImages(function() {

	console.log("imageloaded");
    var x_featured = $('.storefront-featured-products .wp-post-image').height();
	$('.storefront-featured-products .product-details').css(
    	{'width': x_featured + 'px'}
	);
	$('.storefront-featured-products .product-details').css(
		{'height': x_featured + 'px'}
	);
    var x_recent = $('.storefront-recent-products .wp-post-image').height();
	$('.storefront-recent-products .product-details').css(
    	{'width': x_recent + 'px'}
	);
	$('.storefront-recent-products .product-details').css(
    	{'height': x_recent + 'px'}
	);

});
}(jQuery));

</script>
</body>
</html>
