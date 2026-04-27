<?php
/*
 * Template Name: SST E-commerce 1
 */
get_header( 'home9' );
while ( have_posts() ):the_post(); ?>
    <!-- Page Header -->
	<?php
	$post_id                 = get_the_ID();
	$banners                 = get_post_meta( $post_id, '_qwl_banner_group', 1 );
	$guide_img               = get_post_meta( $post_id, '_qwl_guide_img', 1 );
	$guide_img_id            = get_post_meta( $post_id, '_qwl_guide_img_id', 1 );
	$guide_content           = get_post_meta( $post_id, '_qwl_guide_content', 1 );
	$guide_btn_txt           = esc_html( get_post_meta( $post_id, '_qwl_guide_btn_txt', 1 ) );
	$guide_url               = esc_url( get_post_meta( $post_id, '_qwl_guide_url', 1 ) );
	$guide_optin             = esc_html( get_post_meta( $post_id, '_qwl_guide_slug', 1 ) );
	$sections                = get_post_meta( $post_id, '_ttm_section_group', 1 );
	$mobile_banner_id        = (int) get_post_meta( $post_id, '_qwl_mobile_banner_image_id', 1 );
	$mobile_banner_content   = get_post_meta( $post_id, '_qwl_mobile_banner_content', 1 );
	$below_guide_bar_title   = carbon_get_post_meta( $post_id, 'below_guide_bar_title' );
	$below_guide_bar_content = carbon_get_post_meta( $post_id, 'below_guide_bar_content' );
	$block_products_list     = carbon_get_post_meta( $post_id, 'block_products_list' );
	$below_block_image       = carbon_get_post_meta( $post_id, 'below_block_image' );
	$below_block_content     = carbon_get_post_meta( $post_id, 'below_block_content' );
	$below_block_button_url  = carbon_get_post_meta( $post_id, 'below_block_button_url' );
	$below_block_button_name = carbon_get_post_meta( $post_id, 'below_block_button_name' );
	$founder_title           = carbon_get_post_meta( $post_id, 'founder_title' );
	$founder_content         = carbon_get_post_meta( $post_id, 'founder_content' );
	$founder_image           = carbon_get_post_meta( $post_id, 'founder_image' );
	$founder_profile_list    = carbon_get_post_meta( $post_id, 'founder_profile_list' ); ?>
	<?php if ( is_array( $banners ) && array_key_exists( '_qwl_banner_img_id', $banners[0] ) && $banners[0]['_qwl_banner_img_id'] != '' ): ?>
        <div id="billboard">
			<?php if ( '' != $mobile_banner_id && 0 != $mobile_banner_id ): ?>
                <div class="mobile-only">
					<?php echo wp_get_attachment_image( $mobile_banner_id, 'full' ); ?>
                    <div class="overlay">
						<?php echo apply_filters( 'the_content', $mobile_banner_content ); ?>
                    </div><!--end of .overlay-->
                </div><!--end of .mobile-banner-->
			<?php endif; ?>
			<?php echo '' != $mobile_banner_id && 0 != $mobile_banner_id ? '<div class="desktop-only">' : ''; ?>
            <div class="slides slider-with-arrow">
				<?php foreach ( $banners as $banner ): ?>
					<?php if ( array_key_exists( '_qwl_banner_img_id', $banner ) ) : ?>
                        <div>
                            <div class="image-container">
								<?php echo wp_get_attachment_image( $banner['_qwl_banner_img_id'], 'full' ); ?>
                            </div>
							<?php if ( array_key_exists( '_qwl_banner_heading', $banner ) && $banner['_qwl_banner_heading'] != ''
							           || array_key_exists( '_qwl_banner_para', $banner ) && $banner['_qwl_banner_para'] != ''
							           || array_key_exists( '_qwl_banner_btn_txt', $banner ) && $banner['_qwl_banner_btn_txt'] != ''
							           || array_key_exists( '_qwl_banner_btn_url', $banner ) && $banner['_qwl_banner_btn_url'] != ''
							): ?>
                                <div class="holder">
                                    <div
                                            class="billboard-content <?php echo array_key_exists( '_qwl_banner_content_alignment_class', $banner ) ? 'align' . $banner['_qwl_banner_content_alignment_class'] : 'aligncenter'; ?> <?php echo array_key_exists( '_qwl_banner_font_color_class', $banner ) ? $banner['_qwl_banner_font_color_class'] . '-font-color' : 'dark-font-color'; ?>">
										<?php echo array_key_exists( '_qwl_banner_heading', $banner ) ? apply_filters( 'the_content', $banner['_qwl_banner_heading'] ) : ''; ?>
										<?php echo array_key_exists( '_qwl_banner_para', $banner ) ? apply_filters( 'the_content', $banner['_qwl_banner_para'] ) : ''; ?>
										<?php if ( array_key_exists( '_qwl_banner_btn_txt', $banner ) || array_key_exists( '_qwl_banner_btn_url', $banner ) ): ?>
                                            <a href="<?php echo $banner['_qwl_banner_btn_url']; ?>"
                                               class="button color1 <?php echo ( '' != get_post_meta( $post_id, '_ttm_popup_content', 1 ) ) ? 'popup' : ''; ?>"><?php echo $banner['_qwl_banner_btn_txt']; ?></a>
										<?php endif; ?>
										<?php if ( '' != get_post_meta( $post_id, '_ttm_popup_content', 1 ) ): ?>
                                            <div id="popup-form" class="hide">
												<?php echo do_shortcode( get_post_meta( $post_id, '_ttm_popup_content', 1 ) ); ?>
                                            </div>
										<?php endif; ?>
                                    </div>

                                </div>
							<?php endif; ?>
                        </div>
					<?php endif; ?>
				<?php endforeach; ?>
            </div>
			<?php echo '' != $mobile_banner_id && 0 != $mobile_banner_id ? ' </div>' : ''; ?>
        </div><!-- Billboard Container -->
	<?php endif; ?>
	<?php if ( ( '' != $guide_img ) || ( '' != $guide_content ) || ( '' != $guide_btn_txt ) || ( '' != $guide_url ) ): ?>
        <div class="goodie-bar">
            <div class="holder">
				<?php if ( '' != $guide_img ): ?>
                    <div class="image-container">
						<?php echo wp_get_attachment_image( $guide_img_id, 'full' ); ?>
                    </div>
				<?php endif; ?>
				<?php if ( '' != $guide_content ): ?>
                    <div class="detail clearfix">
						<?php echo apply_filters( 'the_content', $guide_content ); ?>
						<?php if ( $guide_optin != '' ): ?>
                            <a href="<?php echo $guide_url; ?>"
                               class="button no-color manual-optin-trigger"
                               data-optin-slug="<?php echo $guide_optin ?>"><?php echo $guide_btn_txt; ?></a>
						<?php else: ?>
                            <a href="<?php echo $guide_url; ?>"
                               class="button no-color" target="_blank"><?php echo $guide_btn_txt; ?></a>
						<?php endif; ?>
                    </div>
				<?php endif; ?>
            </div>
        </div>
	<?php endif; ?>
    <div class="page-container">
        <div class="holder">
            <div class="intro-text aligncenter">
                <div class="section-title"><?php echo esc_html( $below_guide_bar_title ); ?></div>
				<?php echo apply_filters( 'the_content', $below_guide_bar_content ); ?>
            </div>
			<?php if ( is_array( $block_products_list ) && count( $block_products_list ) > 0 ): ?>
                <div class="featured-products">
					<?php foreach ( $block_products_list as $list ): ?>
						<?php if ( $list['_type'] == 'product' ): ?>
                            <div class="featured-product-container">
                                <div class="image-container">
									<?php echo wp_get_attachment_image( $list['image'], 'full' ); ?>
                                </div>
                                <div class="featured-product-detail">
									<?php echo apply_filters( 'the_content', $list['content'] ); ?>
                                    <div class="call-to-action">
                                        <a href="<?php echo esc_url( $list['button_url'] ); ?>"
                                           class="button"><?php echo esc_html( $list['button_name'] ); ?></a>
                                    </div>
                                </div>
                            </div>
						<?php else: ?>
                            <div class="featured-video">
								<?php
								$video_image_link = esc_url( wp_get_attachment_image_src( $list['video_image'], 'full' )[0] );
								$video_image_alt  = esc_html( get_post_meta( $list['video_image'], '_wp_attachment_image_alt', true ) );
								echo do_shortcode( '[vds vds_video_link="' . esc_url( $list['video_url'] ) . '" vds_image_title="' . $video_image_alt . '" vds_image_link="' . $video_image_link . '"]' ); ?>
                            </div>
						<?php endif; ?>
					<?php endforeach; ?>
                </div>
			<?php endif; ?>
            <!-- Featured Products -->
			<?php if ( $below_block_content != '' ): ?>
                <div class="extra-special-product">
                    <div class="image-container">
						<?php echo wp_get_attachment_image( $below_block_image, 'full' ); ?>
                    </div>
                    <div class="featured-product-detail">
						<?php echo apply_filters( 'the_content', $below_block_content ); ?>
                        <div class="call-to-action">
                            <a href="<?php echo esc_url( $below_block_button_url ); ?>"
                               class="button"><?php echo esc_html( $below_block_button_name ); ?></a>
                        </div>
                    </div>
                </div><!-- Extra Special Product -->
			<?php endif; ?>
        </div><!-- Holder -->
    </div><!-- Page Content -->
    <div class="executive-section">
        <div class="holder">
            <div class="intro-text aligncenter">
                <div class="section-title"><?php echo esc_html( $founder_title ); ?></div>
				<?php echo apply_filters( 'the_content', $founder_content ); ?>
                <div class="founder-image-container">
					<?php echo wp_get_attachment_image( $founder_image, 'full' ); ?>
					<?php $count = 1;
					if ( count( $founder_profile_list ) > 0 ):
						foreach ( $founder_profile_list as $profile_list ): ?>
                            <a href="<?php echo esc_url( $profile_list['profile_url'] ); ?>"
                               class="button founder-link<?php echo esc_attr( $count ); ?>">
								<?php echo esc_html( $profile_list['profile_name'] ); ?>
                            </a>
							<?php $count ++;
						endforeach;
					endif; ?>
                </div>
            </div>
        </div>
    </div>
	<?php if ( is_active_sidebar( 'e-commerce-widget' ) ): ?>
        <div class="media-section">
            <div class="holder">
				<?php dynamic_sidebar( 'e-commerce-widget' ); ?>
            </div>
        </div>
	<?php endif; ?>
    <div class="subscription-section">
        <div class="holder">
            <div class="logo-container">
                <img src="http://savvytravelers.titaniummarketing.com/wp-content/uploads/2017/05/logo-savvy-inverse.png"
                     alt="">
            </div>
            <h2>Don't Forget to <strong>Subscribe</strong></h2>
			<?php echo do_shortcode( '[mc4wp_form]' ); ?>
            <div class="disclaimer">
                <p>By subscribing you agreed to receiving all monthly offers & News </p>
            </div>
        </div>
    </div>
<?php endwhile;
get_footer(); ?>