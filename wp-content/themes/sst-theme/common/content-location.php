<?php
/**
 * The partials for displaying default location list based on theme options
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Partials
 * @version 1.6.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
$sst_option       = get_option( 'sst_option' );
$location_title   = is_array( $sst_option ) && array_key_exists( 'location-default-title', $sst_option ) ? $sst_option['location-default-title'] : 'Locations'; ?>
<div class="page-content fullpage">
	<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
	<div class="contact-container">
		<div class="holder">
			<h1><?php echo esc_html( $location_title ); ?></h1>
			<a href="/contact" class="button white">Contact us</a>
		</div>
	</div>
	<div class="holder">
		<aside class="not-widget widget-odd widget widget-locations">
			<h4 class="widget-title">Locations</h4>
			<div class="textwidget">
				<div class="widget-entry">
					<?php if ( have_posts() ): ?>
						<ul class="listing-location" data-hook="listing-location">
							<?php while ( have_posts() ): the_post();
								$post_id      = get_the_ID();
								$address      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address', 1 ) );
								$city         = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_city', 1 ) );
								$state        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_state', 1 ) );
								$zip          = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_zip', 1 ) );
								$main_phone   = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_main_phone', 1 ) );
								$full_address = [ $address, $city, $state, $zip ]; ?>
								<li><i class="fa fa-map-marker"></i>
									<a href="<?php the_permalink(); ?>">
										<h4><?php the_title(); ?></h4>
										<p><?php echo implode( ', ', $full_address ); ?>
											<?php echo $main_phone != '' ? '<br/><b>Phone:</b> ' . "(".substr($main_phone,0,3).") ".substr($main_phone,3,3)."-".substr($main_phone,6); : ''; ?></p>
									</a>
								</li>
							<?php endwhile; ?>
						</ul>
					<?php endif; ?>
				</div>
		</aside>

	</div>
</div>