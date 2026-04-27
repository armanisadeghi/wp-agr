<?php
/**
 * The template for displaying location based on location type
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.5.3
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
get_header(); ?>
    <div class="page-content fullpage">
		<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
        <div class="contact-container">
            <div class="holder">
                <h1><?php echo single_cat_title(); ?></h1>
                <a href="/contact-us/" class="button white">Contact us</a>
            </div>
        </div>
        <div class="holder">
            <aside class="not-widget widget-odd widget widget-locations">
                <h4 class="widget-title">locations</h4>
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
												<?php echo $main_phone != '' ? '<br/><b>Phone:</b> ' . $main_phone : ''; ?></p>
                                        </a>
                                    </li>
								<?php endwhile; ?>
                            </ul>
						<?php endif; ?>
                    </div>
            </aside>

        </div>
    </div>
<?php get_footer(); ?>