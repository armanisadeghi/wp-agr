<?php
/*
 * Template Name: SST Landing Page 1
 */
get_header();

if ( have_posts() ):
	while ( have_posts() ):
		the_post();
		?>
        <!-- Page Header -->
		<?php
		$post_id = get_the_ID();

		//Field's Variables==============================
		//General_Fields
		$prefix                         = '_ttm';
		$result_title                   = get_post_meta( $post_id, $prefix . '_results_title', 1 );
		$banner_content                 = get_post_meta( $post_id, $prefix . '_landing_banner_content', 1 );
		$banner_image_id                = get_post_meta( $post_id, $prefix . '_landing_banner_image_id', 1 );
		$media_file                     = esc_url( get_post_meta( $post_id, $prefix . '_landing_media_file', 1 ) );
		$media_cover                    = get_post_meta( $post_id, $prefix . '_landing_video_cover_id', 1 );
		$media_content                  = get_post_meta( $post_id, $prefix . '_landing_media_content', 1 );
		$landing_contact_background_img = get_post_meta( $post_id, $prefix . '_landing_contact_background', 1 );
		$landing_contact                = get_post_meta( $post_id, $prefix . '_landing_contact_content', 1 );

		//Result_Section
		$results = get_post_meta( $post_id, $prefix . '_result_content_group', 1 );

		$bottom_content = get_post_meta( $post_id, $prefix . '_landing_bottom_content', 1 );
		?>
        <div class="landing-page-wrapper">
            <div id="billboard" class="shadow-top-left">
                <div class="image-container">
					<?php echo wp_get_attachment_image( $banner_image_id, 'full' ); ?>
                </div>
				<?php if ( '' != $banner_content ): ?>
                    <div class="holder">
                        <div class="billboard-content">
							<?php echo do_shortcode( wpautop( $banner_content ) ); ?>
                        </div>
                    </div>
				<?php endif; ?>
            </div><!-- Billboard Container -->
            <div class="page-content fullwidth bg-bright shadow-top-right editor-content">
                <div class="holder">
					<?php the_content(); ?>

                    <div class="two-cols">
						<?php if ( '' != $media_file ): ?>
                            <figure class="has-cover iframe-play">
								<?php echo do_shortcode( '[vds vds_video_link="' . $media_file . '" vds_image_title="" vds_image_link="' . wp_get_attachment_image_src( $media_cover, [
										632,
										436
									] )[0] . '"]' ); ?>

								<?php /*if ( '' != $media_cover ): */ ?><!--
									<div class="image-holder">
										<?php /*echo wp_get_attachment_image( $media_cover, [ 632, 436 ] ); */ ?>
									</div>
								<?php /*endif; */ ?>
								--><?php /*echo wp_oembed_get( $media_file ); */ ?>
                            </figure>
						<?php endif; ?>
						<?php if ( '' != $media_content ): ?>
                            <div>
								<?php echo do_shortcode( wpautop( $media_content ) ); ?>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="page-content fullwidth bg-bright shadow-top-left">
                <div class="holder">
                    <h3><?php echo $result_title; ?> Results</h3>

                    <div id="verticalTab" class="tab-wrapper">
                        <ul class="resp-tabs-list">
							<?php foreach ( $results as $result ): ?>
								<?php if ( '' != $result['_ttm_vertical_menu_text'] || '' != $result['_ttm_vertical_menu_icon'] ): ?>
                                    <li>
										<?php if ( '' != $result['_ttm_vertical_menu_icon_id'] ): ?>
                                            <span class="img-inner">
												<figure>
													<?php echo wp_get_attachment_image( $result['_ttm_vertical_menu_icon_id'], 'full' ); ?>
												</figure>
											</span>
										<?php endif; ?>
										<?php if ( '' != $result['_ttm_vertical_menu_text'] ): ?>
                                            <span class="text-title">
											<?php echo $result['_ttm_vertical_menu_text']; ?>
										</span>
										<?php endif; ?>
                                    </li>
								<?php endif; ?>
							<?php endforeach; ?>
                        </ul>
                        <div class="resp-tabs-container">
							<?php foreach ( $results as $result ): ?>
								<?php if ( '' != $result['_ttm_female_before_image_id'] ): ?>
                                    <a href="#" title="" class="button toggle-female active">Female</a>
								<?php endif; ?>
								<?php if ( '' != $result['_ttm_male_after_image_id'] ): ?>
                                    <a href="#" title="" class="button toggle-male">Male</a>
								<?php endif; ?>
                                <div>
                                    <div class="thumbs-group female">
                                        <div class="image-holder">
                                            <figure>
												<?php if ( '' != $result['_ttm_female_before_image_id'] ): ?>
													<?php echo wp_get_attachment_image( $result['_ttm_female_before_image_id'], 'full' ); ?>
												<?php else: ?>
                                                    <img
                                                            src="<?php echo get_template_directory_uri(); ?>/assets/images/female-thumbnail-avatar-image.png"
                                                            alt="" title="">
												<?php endif; ?>
                                            </figure>
                                            <p><strong>Before</strong></p>
                                        </div>

                                        <div class="image-holder">
                                            <figure>
												<?php if ( '' != $result['_ttm_female_after_image_id'] ): ?>
													<?php echo wp_get_attachment_image( $result['_ttm_female_after_image_id'], 'full' ) ?>
												<?php else: ?>
                                                    <img
                                                            src="<?php echo get_template_directory_uri(); ?>/assets/images/female-thumbnail-avatar-image.png"
                                                            alt="" title="">
												<?php endif; ?>
                                            </figure>
                                            <p>
                                                <strong>After </strong>
												<?php if ( array_key_exists( '_ttm_female_after_text', $result ) ): ?>
													<?php echo $result['_ttm_female_after_text']; ?>
												<?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="thumbs-group male">
                                        <div class="image-holder">
                                            <figure>
												<?php if ( '' != $result['_ttm_male_before_image_id'] ): ?>
													<?php echo wp_get_attachment_image( $result['_ttm_male_before_image_id'], 'full' ); ?>
												<?php else: ?>
                                                    <img
                                                            src="<?php echo get_template_directory_uri(); ?>/assets/images/male-thumbnail-avatar-image.png"
                                                            alt="" title="">
												<?php endif; ?>
                                            </figure>
                                            <p><strong>Before</strong></p>
                                        </div>
                                        <div class="image-holder">
                                            <figure>
												<?php if ( '' != $result['_ttm_male_after_image_id'] ): ?>
													<?php echo wp_get_attachment_image( $result['_ttm_male_after_image_id'], 'full' ) ?>
												<?php else: ?>
                                                    <img
                                                            src="<?php echo get_template_directory_uri(); ?>/assets/images/male-thumbnail-avatar-image.png"
                                                            alt="" title="">
												<?php endif; ?>
                                            </figure>
                                            <p>
                                                <strong>After</strong>
												<?php if ( array_key_exists( '_ttm_male_after_text', $result ) ): ?>
													<?php echo $result['_ttm_male_after_text']; ?>
												<?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
							<?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
			<?php if ( '' != $landing_contact ): ?>
                <div class="page-content fullwidth bg-bright shadow-top-right has-bg-image">
                    <div class="inner-content"
                         style="background-image: url('<?php if ( '' != $landing_contact_background_img ) {
						     echo $landing_contact_background_img;
					     } ?>')">
                        <div class="holder">
                            <div class="form-holder right">
								<?php echo do_shortcode( $landing_contact ); ?>
                            </div>

                        </div>
                    </div>
                </div>
			<?php endif; ?>
			<?php if ( '' != $bottom_content ): ?>
                <div class="page-content fullwidth bg-bright shadow-top-left">
                    <div class="holder">
						<?php echo wpautop( $bottom_content ); ?>
                    </div>
                </div>
			<?php endif; ?>
        </div>
		<?php

	endwhile;
endif;
get_footer(); ?>
