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
var x = $('.wp-post-image').height();
$('.product-details').css(
    {'width': x + 'px'}
);
$('.product-details').css(
    {'height': x + 'px'}
);
});
}(jQuery));

(function($) {
$('.products').waitForImages(function() {
	console.log("imageloaded");
    var x = $('.wp-post-image').height();
$('.product-details').css(
    {'width': x + 'px'}
);
$('.product-details').css(
    {'height': x + 'px'}
);
});
}(jQuery));

</script>
</body>
</html>
