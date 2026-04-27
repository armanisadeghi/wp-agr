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
  
<?php wp_footer(); ?>

<!-- ManyChat -->
<script src="//widget.manychat.com/5316.js" async="async"></script>
</body>
</html>