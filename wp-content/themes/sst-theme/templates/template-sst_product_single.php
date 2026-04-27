<?php
/*
 * Template Name: SST Products 2
 * Template Post Type: product
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

<?php
do_action( 'mok_woo_breadcrumbs' );
/**
 * woocommerce_before_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action( 'woocommerce_before_main_content' );
?>

<?php while ( have_posts() ) : the_post(); ?>

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
				?>
				<dl class="product-accordion">
					<dt>Description</dt>
					<dd><?php the_content(); ?></dd>
					<?php
					$extra_info = carbon_get_the_post_meta( 'product_extra_info' );
					if ( count( $extra_info ) > 0 ):
						foreach ( $extra_info as $info ): ?>
							<?php if ( $info['_type'] == 'content' ): ?>
								<dt><?php echo esc_html( $info['content_title'] ); ?></dt>
								<dd><?php echo apply_filters( 'the_content', $info['content_desc'] ); ?></dd>
							<?php else: ?>
								<dt><?php echo esc_html( $info['video_title'] ); ?></dt>
								<dd>
									<?php
									$video_image_link = esc_url( wp_get_attachment_image_src( $info['video_image'], 'full' )[0] );
									$video_image_alt  = esc_html( get_post_meta( $info['video_image'], '_wp_attachment_image_alt', true ) );
									echo do_shortcode( '[vds vds_video_link="' . esc_url( $info['video_url'] ) . '" vds_image_title="' . $video_image_alt . '" vds_image_link="' . $video_image_link . '"]' ); ?>
								</dd>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</dl>
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

<?php endwhile; // end of the loop. ?>

<?php
/**
 * woocommerce_after_main_content hook.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );
?>

<?php get_footer(); ?>
