<?php
/*
 * Template Name: SST Location Detail
 */
get_header(); ?>
<?php while ( have_posts() ): the_post();
	$post_id                 = get_the_ID();
	$location_map            = get_post_meta( $post_id, '_ttm_location_banner_map', 1 );
	$location_banner_content = get_post_meta( $post_id, '_ttm_location_banner_content', 1 );
	$location_address        = get_post_meta( $post_id, '_ttm_location_address', 1 );
	$location_phone          = get_post_meta( $post_id, '_ttm_location_phone', 1 );
	$location_time           = get_post_meta( $post_id, '_ttm_location_time', 1 ); ?>
    <div id="main" class="location-wrapper">
        <div class="page-content fullpage main-wrapper">
			<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
			<?php if ( $location_banner_content != '' || $location_map != '' ): ?>
                <div class="billboard">
                    <div class="holder">
                        <div class="billboard-content">
                            <div class="detail">
                                <h1><?php the_title(); ?></h1>
								<?php if ( $location_address != '' || $location_phone != '' || $location_time != '' ): ?>
                                    <ul class="location-detail">
                                        <li class="address"><?php echo nl2br( $location_address ); ?></li>
                                        <li class="phone"><?php echo nl2br( $location_phone ); ?></li>
                                        <li class="time"><?php echo nl2br( $location_time ); ?></li>
                                    </ul>
								<?php endif; ?>
                            </div>
                        </div>
						<?php if ( $location_map != '' ): ?>
                            <div class="map-holder">
								<?php echo $location_map; ?>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
			<?php endif; ?>
            <!-- Billboard Container -->
            <div class="page-content full-width inner-wrapper">
                <div class="holder">
					<?php if ( get_the_content() != '' ): ?>
                        <div class="content">
							<?php the_content(); ?>
                        </div>
					<?php endif; ?>
                    <div class="locations-holder limit-locations">
						<?php if ( is_active_sidebar( 'location-widget' ) ):
							dynamic_sidebar( 'location-widget' );
						endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>