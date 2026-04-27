<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     3.0.0
 */
global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php
/**
 * woocommerce_before_single_product hook.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form();

	return;
}
?>

<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="row clearfix">
		<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
		?>
        <div class="product-detail">
			<?php
			/**
			 * woocommerce_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			do_action( 'woocommerce_single_product_summary' );
			$extra_info = carbon_get_the_post_meta( 'product_extra_info' );
			?>
			<?php
			if ( count( $extra_info ) > 0 ):
				foreach ( $extra_info as $info ): ?>
					<?php if ( $info['_type'] != 'content' ): ?>
                        <div class="video-container">
							<?php
							if ( $info['video_title'] != '' ):
								echo '<h3>' . esc_html( $info['video_title'] ) . '</h3>';
							endif;
							$video_image_link = esc_url( wp_get_attachment_image_src( $info['video_image'], 'full' )[0] );
							$video_image_alt  = esc_html( get_post_meta( $info['video_image'], '_wp_attachment_image_alt', true ) );
							echo do_shortcode( '[vds vds_video_link="' . esc_url( $info['video_url'] ) . '" vds_image_title="' . $video_image_alt . '" vds_image_link="' . $video_image_link . '"]' ); ?>
                        </div>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
            <dl class="product-accordion">
                <dt class="active">Description</dt>
                <dd><?php the_content(); ?></dd>
				<?php
				if ( count( $extra_info ) > 0 ):
					foreach ( $extra_info as $info ): ?>
						<?php if ( $info['_type'] == 'content' ): ?>
                            <dt><?php echo esc_html( $info['content_title'] ); ?></dt>
                            <dd><?php echo apply_filters( 'the_content', $info['content_desc'] ); ?></dd>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
            </dl>
            <div class="disclaimer">
				<?php echo apply_filters( 'the_content', carbon_get_the_post_meta( 'below_product_extra_info' ) ); ?>
            </div>
        </div>
    </div>
	<?php
	/**
	 * woocommerce_after_single_product_summary hook.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>

    <meta itemprop="url" content="<?php the_permalink(); ?>"/>

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
