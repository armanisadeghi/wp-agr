<?php
/*
 * Template Name: SST Services Home
 */
get_header();
while ( have_posts() ):the_post();
	$post_id       = get_the_ID();
	$banners       = get_post_meta( $post_id, '_ttm_banner_slider_group', 1 );
	$service_title = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_service_title', 1 ) );
	$services      = get_post_meta( $post_id, '_ttm_thank_you_services_group', 1 ); ?>
	<?php if ( is_array( $banners ) && array_key_exists( '_ttm_banner_slider_img_id', $banners[0] ) ): ?>
        <div id="billboard" class="banner-holder">
            <div class="slides slick-slider">
				<?php foreach ( $banners as $banner ): ?>
					<?php if ( $banner['_ttm_banner_slider_img_id'] != "" ) : ?>
                        <div style="background-image: url(<?php echo wp_get_attachment_image_url( $banner['_ttm_banner_slider_bg_id'], 'full' ); ?>)">
                            <div class="bg-container">
								<?php echo wp_get_attachment_image( $banner['_ttm_banner_slider_bg_id'], 'full' ); ?>
                            </div>
							<?php if ( '' != $banner['_ttm_banner_slider_content'] || '' != $banner['_ttm_banner_slider_btn_txt'] || '' != $banner['_ttm_banner_slider_btn_url'] ): ?>
                                <div class="holder">
                                    <figure>
										<?php echo wp_get_attachment_image( $banner['_ttm_banner_slider_img_id'], 'full' ); ?>
                                    </figure>
                                    <div class="billboard-content">
                                        <div class="detail">
											<?php echo apply_filters( 'the_content', $banner['_ttm_banner_slider_content'] ); ?>
											<?php if ( '' != $banner['_ttm_banner_slider_btn_txt'] || '' != $banner['_ttm_banner_slider_btn_url'] ): ?>
                                                <br/>
                                                <a href="<?php echo esc_url( $banner['_ttm_banner_slider_btn_url'] ); ?>"
                                                   class="button color1"><?php echo wp_strip_all_tags( $banner['_ttm_banner_slider_btn_txt'] ); ?></a>
											<?php endif; ?>
                                        </div>
                                    </div>
                                </div>
							<?php endif; ?>
                        </div>
					<?php endif; ?>
				<?php endforeach; ?>
            </div>
        </div><!-- Billboard Container -->
	<?php endif; ?>
    <div class="services-content editor-content">
        <div class="holder">
			<?php the_content(); ?>
        </div>
    </div>
    <div class="wrapper services-container">
        <div class="holder">
            <h2 class="services-title"><?php echo $service_title; ?></h2>

            <div class="services-list">
				<?php
				$count = 1;
				if ( is_array( $services ) && array_key_exists( '_ttm_thank_you_service_title', $services[0] ) ):
					foreach ( $services as $service ):
						echo $count % 2 == 1 ? '<div class="service-row">' : ''; ?>
                        <div class="item">
                            <figure>
                                <a href="<?php echo $service['_ttm_thank_you_service_link_url']; ?>">
									<?php echo wp_get_attachment_image( $service['_ttm_thank_you_service_img_id'], [
										315,
										185
									] ); ?>
                                </a>
                            </figure>
                            <div class="content">
                                <div class="detail">
                                    <h3>
                                        <a href="<?php echo esc_url( $service['_ttm_thank_you_service_link_url'] ); ?>"><?php echo $service['_ttm_thank_you_service_title']; ?></a>
                                    </h3>
                                    <a href="<?php echo esc_url( $service['_ttm_thank_you_service_link_url'] ); ?>">
										<?php echo wp_strip_all_tags( $service['_ttm_thank_you_service_link_txt'] ); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
						<?php echo $count % 2 == 0 ? '</div>' : ''; ?>
						<?php $count ++;
					endforeach;
				endif; ?>
            </div>
        </div>
    </div>
<?php endwhile;
get_footer();
