<?php
/*
 * Template Name: SST Ambassador
 */
get_header();
while ( have_posts() ): the_post();
	$post_id               = get_the_ID();
	$banners               = get_post_meta( $post_id, '_qwl_banner_group', 1 );
	$guide_img             = get_post_meta( $post_id, '_qwl_guide_img', 1 );
	$guide_img_id          = get_post_meta( $post_id, '_qwl_guide_img_id', 1 );
	$guide_content         = get_post_meta( $post_id, '_qwl_guide_content', 1 );
	$guide_btn_txt         = esc_html( get_post_meta( $post_id, '_qwl_guide_btn_txt', 1 ) );
	$guide_url             = esc_url( get_post_meta( $post_id, '_qwl_guide_url', 1 ) );
	$guide_optin           = esc_html( get_post_meta( $post_id, '_qwl_guide_slug', 1 ) );
	$sections              = get_post_meta( $post_id, '_ttm_section_group', 1 );
	$mobile_banner_id      = (int) get_post_meta( $post_id, '_qwl_mobile_banner_image_id', 1 );
	$mobile_banner_content = get_post_meta( $post_id, '_qwl_mobile_banner_content', 1 );
	$product_lists         = carbon_get_the_post_meta( 'ambassador_products_list' );
	$ad_image              = carbon_get_the_post_meta( 'ad_image' );
	$ad_content            = carbon_get_the_post_meta( 'ad_content' );
	$ad_btn_url            = carbon_get_the_post_meta( 'ad_btn_url' );
	$ad_btn_name           = carbon_get_the_post_meta( 'ad_btn_name' );
	$about_title           = carbon_get_the_post_meta( 'about_ambassador_title' );
	$about_lists           = carbon_get_the_post_meta( 'about_ambassador_list' );
	$video_title           = carbon_get_the_post_meta( 'video_ambassador_title' );
	$video_lists           = carbon_get_the_post_meta( 'video_ambassador_list' );
	$instagram_username    = carbon_get_the_post_meta( 'instagram_username' );
	$instagram_user_id     = carbon_get_the_post_meta( 'instagram_user_id' ); ?>

	<?php if ( is_array( $banners ) && array_key_exists( '_qwl_banner_img_id', $banners[0] ) && $banners[0]['_qwl_banner_img_id'] != '' ): ?>
        <div id="billboard">
			<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
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
                        <div class="billboard-slide-container">
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

	<?php if ( count( $product_lists ) > 0 ): ?>
        <div class="page-container">
            <div class="holder">
                <div class="featured-products">
					<?php foreach ( $product_lists as $list ): ?>
						<?php if ( $list['_type'] == 'product' ): ?>
                            <div class="featured-product-container">
                                <div class="image-container">
									<?php echo wp_get_attachment_image( $list['image'], 'full' ); ?>
                                </div>
                                <div class="featured-product-detail">
                                    <h3><?php echo wp_kses_post( $list['title'] ); ?></h3>
                                    <div class="discount">
										<?php echo esc_html( $list['off_price'] ); ?>
                                    </div>
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
            </div>
        </div>
	<?php endif; ?>

    <div class="push-sell-section"
         style="background-image: url(<?php echo wp_get_attachment_image_src( $ad_image, 'full' )[0]; ?>)">
        <div class="holder">
            <div class="text-container">
				<?php echo apply_filters( 'the_content', $ad_content ); ?>
                <a href="<?php echo esc_url( $ad_btn_url ); ?>"
                   class="button"><?php echo esc_html( $ad_btn_name ); ?></a>
            </div>
        </div>
    </div>

    <div class="about-ambassador-section">
        <div class="holder">
            <h2><?php echo esc_html( $about_title ); ?></h2>

			<?php
			if ( is_array( $about_lists ) && count( $about_lists ) > 0 ):
				foreach ( $about_lists as $list ):?>
                    <div class="story-container <?php echo sanitize_html_class( $list['image_align'] ); ?>">
						<?php if ( $list['image'] != '' ): ?>
                            <div class="image-container">
								<?php echo wp_get_attachment_image( $list['image'], 'full' ); ?>
                            </div>
						<?php endif; ?>
                        <div class="story-detail">
							<?php echo apply_filters( 'the_content', $list['content'] ); ?>
                        </div>
                    </div>
					<?php
				endforeach;
			endif; ?>
        </div>
    </div>
    <div class="video-display-section">
        <div class="holder">
            <h2><?php echo esc_html( $video_title ); ?></h2>
            <div class="video-container">
				<?php
				if ( is_array( $video_lists ) && count( $video_lists ) > 0 ):
					foreach ( $video_lists as $list ):
						$video_image_link = esc_url( wp_get_attachment_image_src( $list['video_image'], 'full' )[0] );
						$video_image_alt = esc_html( get_post_meta( $list['video_image'], '_wp_attachment_image_alt', true ) );
						?>
                        <div class="video-block">
							<?php echo do_shortcode( '[vds vds_video_link="' . esc_url( $list['video_url'] ) . '" vds_image_title="' . $video_image_alt . '" vds_image_link="' . $video_image_link . '"]' ); ?>
                        </div>
						<?php
					endforeach;
				endif; ?>

            </div>
        </div>
    </div>
	<?php
	if ( $instagram_username != '' && $instagram_user_id != '' ):?>
        <div class="instagram-feed-section">
        <div class="holder">
            <h2><?php echo esc_html( $instagram_username ); ?></h2>
            <div class="feed-container">
				<?php echo do_shortcode( '[instagram-feed id="' . $instagram_user_id . '" num=18 cols=6 width=100 widthunit=%]' ); ?>
            </div>
        </div>
	<?php endif;
endwhile; ?>
    <div class="subscription-section">
        <div class="holder">
            <div class="logo-container">
                <img src="/wp-content/uploads/2017/05/logo-savvy-inverse.png" alt="">
            </div>
            <h2>Don't Forget to <strong>Subscribe</strong></h2>
			<?php echo do_shortcode( '[mc4wp_form id="7679"]' ); ?>
            <div class="disclaimer">
                <p>By subscribing you agreed to receiving all monthly offers & News </p>
            </div>
        </div>
    </div>
<?php
get_footer();
