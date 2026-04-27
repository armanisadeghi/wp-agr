<?php
/**
 * The template for displaying footer for showcase template only
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.5.4
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
?>
<footer id="page-footer">
    <div class="row">
		<?php if ( is_active_sidebar( 'showcase-footer' ) ) : ?>
			<?php dynamic_sidebar( 'showcase-footer' ); ?>
		<?php endif; ?>
    </div>
	<?php if ( is_active_sidebar( 'footer-bottom' ) ) : ?>
        <div class="copyright-section">
            <div class="row">
				<?php dynamic_sidebar( 'footer-bottom' ); ?>
            </div>
        </div>
        <!-- Copyright Section -->
	<?php endif; ?>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>