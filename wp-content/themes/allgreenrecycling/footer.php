<?php
/**
 * The template for displaying footer on every page
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.5.4
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
if ( ! is_page_template( [ 'templates/template-sst_home1.php' ] ) && is_page() ):
	do_action( 'mok_bottom_content' );
endif; ?>
<footer id="page-footer">
    <div class="holder">
        <div class="quick-links">
            <?php if ( is_active_sidebar( 'footer-qwl' ) ):
                dynamic_sidebar( 'footer-qwl' );
            endif; ?>
        </div>
        <!-- Quick Links -->
        <div class="alignright footer-connections">
            <?php if ( is_active_sidebar( 'footer-lower-right' ) ) : ?>
                <?php dynamic_sidebar( 'footer-lower-right' ); ?>
            <?php endif; ?>
        </div>
        <!-- Footer Connection -->
    </div>
    <?php if ( is_active_sidebar( 'footer-bottom' ) ) : ?>
    <div class="copyright-section">
        <div class="holder">
            <?php dynamic_sidebar( 'footer-bottom' ); ?>
        </div>
    </div>
    <!-- Copyright Section -->
    <?php endif; ?>
</footer>
<!-- Page Footer -->
</div> <!-- #pg_wrapper ends -->
<!-- Gp Multi step code -->
<?php
function show_step(){
	$url = $_SERVER['REQUEST_URI'];
	$parts = parse_url($url);
	parse_str($parts['query'], $query);
	$step = $query['step'];
		if($step == 2)
		{
			//echo "<style>#gform_page_11_1{display:none;}#gform_page_11_2{display:block !important;}</style>";
			?>
			<script>
				jQuery(window).load(function() {
						
						//jQuery(".gform_next_button").trigger('click');
						//jQuery("#gform_11").trigger("submit"); 
	
				});
			</script>
			<style>#gform_previous_button_11{display:none;}</style>
<?php			
		}
}
add_action( 'wp_footer', 'show_step');
 wp_footer();
 ?>
 <script type="text/javascript">
 	jQuery(function() {
        jQuery("input[type=text]").on("keyup", function(event) {
            var value = jQuery(this).val();
            jQuery(this).val(value.replace(/[^a-z 0-9]/gi,''));
        });
        jQuery("textarea").on("keyup", function(event) {
            var value = jQuery(this).val();
            jQuery(this).val(value.replace('?>','').replace('<','').replace('>',''));
        });

      // var $reqd = jQuery('form[id^="gform_11"]').find('.gfield_contains_required.gfield_visibility_visible').filter(function (i, c) {
      //   return []
      //     .concat(jQuery(c).find('input[type="text"], textarea').filter(function (i, fl) { return jQuery(fl).val().length == 0; }).get())
      //     .concat(jQuery(c).find('input[type="checkbox"]').not(':checked').get())
      //     .length;
      // });
      // if ($reqd.length) {
      //   jQuery('form[id^="gform_11"]').find('input[type="button"]').addClass('disabled button-disabled').attr('disabled', 'disabled');
      // } else {
      //   jQuery('form[id^="gform_11"]').find('input[type="button"]').removeClass('disabled button-disabled').removeAttr('disabled');
      // }

    });
 </script>
<!-- ManyChat -->
<script src="//widget.manychat.com/5316.js" async="async"></script>
</body>
</html>