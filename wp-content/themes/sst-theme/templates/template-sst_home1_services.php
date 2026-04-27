<?php
/*
 * Template Name: SST Standard Page w/ Services
 */
get_header();
while ( have_posts() ):the_post(); ?>
    <!-- Page Header -->
	<?php
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
	?>
	<?php if ( is_array( $banners ) && $banners[0]['_qwl_banner_img_id'] != '' ): ?>
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
            <div class="slides slick-slider">
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
        </div><!-- Billboard Container -->
	<?php endif; ?>

	<?php
	$first_column_content  = get_post_meta( $post_id, '_qwl_four_columns1_column1_content', 1 );
	$second_column_content = get_post_meta( $post_id, '_qwl_four_columns1_column2_content', 1 );
	$third_column_content  = get_post_meta( $post_id, '_qwl_four_columns1_column3_content', 1 );
	$fourth_column_content = get_post_meta( $post_id, '_qwl_four_columns1_column4_content', 1 );
	$count                 = 0;
	$first_column_content != '' ? $count ++ : false;
	$second_column_content != '' ? $count ++ : false;
	$third_column_content != '' ? $count ++ : false;
	$fourth_column_content != '' ? $count ++ : false;
	if ( $first_column_content != '' || $second_column_content != '' || $third_column_content != '' || $fourth_column_content != '' ): ?>
        <div class="page-content fullwidth bg-bright col<?php echo $count; ?>-container aligncenter">
            <div class="holder">
				<?php for ( $i = 1; $i <= 4; $i ++ ):
					if ( '' != get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_content', 1 ) ): ?>
                        <article class="col">
                            <a href="<?php echo esc_url( get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_link', 1 ) ); ?>">
								<?php
								if ( '' != get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_img', 1 ) ) {
									$img_id = get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_img_id', 1 ); ?>
                                    <div class="icon-holder icon-target">
										<?php echo wp_get_attachment_image( $img_id, 'full' ); ?>
                                    </div>
									<?php
								} else if ( '' != get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_icon',
										1 ) && 'none' != get_post_meta( $post_id,
										'_qwl_four_columns1_column' . $i . '_icon', 1 )
								) {
									?>
                                    <div class="icon-holder icon-target">
                                        <img
                                                src="<?php echo get_post_meta( $post_id,
													'_qwl_four_columns1_column' . $i . '_icon', 1 ); ?>"
                                                alt="<?php echo get_post_meta( $post_id,
													'_qwl_four_columns1_column' . $i . '_icon_alt', 1 ); ?>">
                                    </div>
								<?php } ?>
								<?php if ( '' != get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_content',
										1 )
								): ?>
                                    <div class="detail">
										<?php echo do_shortcode( wpautop( get_post_meta( $post_id,
											'_qwl_four_columns1_column' . $i . '_content', 1 ) ) ); ?>
                                    </div>
								<?php endif; ?>
                            </a>
                        </article>
					<?php endif; endfor; ?>
            </div>
        </div>
	<?php endif; ?>
    <div class="page-content fullwidth">
        <div class="holder">
			<?php if ( '' != get_the_content() ): ?>
                <article class="main-container">
                    <div class="editor-content">
						<?php the_content(); ?>
                    </div>
                </article>
				<?php get_sidebar(); ?>
			<?php endif; ?>
        </div>
    </div>
	<?php
	if ( is_array( $sections ) && array_key_exists( '_ttm_section_content', $sections[0] ) ):
		foreach ( $sections as $section ):
			$section_layout = array_key_exists( '_ttm_section_layout', $section ) && '' != $section['_ttm_section_layout'] ? $section['_ttm_section_layout'] : '';
			$section_bg    = array_key_exists( '_ttm_section_bg', $section ) && '' != $section['_ttm_section_bg'] ? 'imagebg' : '';
			$section_class = array_key_exists( '_ttm_section_class', $section ) && '' != $section['_ttm_section_class'] ? $section['_ttm_section_class'] : '';
			?>
            <div class="section <?php echo $section_layout . ' ' . $section_bg . ' ' . $section_class; ?>"
				<?php echo ( array_key_exists( '_ttm_section_bg', $section ) && '' != $section['_ttm_section_bg'] ) ? 'style="background-image: url(' . $section['_ttm_section_bg'] . ')"' : ''; ?>>
                <div class="holder">
					<?php if ( array_key_exists( '_ttm_section_img', $section ) && 'imagebg' != $section['_ttm_section_layout'] && '' != $section['_ttm_section_img'] ): ?>
                        <div class="img-container">
							<?php echo wp_get_attachment_image( $section['_ttm_section_img_id'], 'full' ); ?>
                        </div>
					<?php endif; ?>

                    <div class="detail">
						<?php echo ( array_key_exists( '_ttm_section_content', $section ) && '' != $section['_ttm_section_content'] ) ? apply_filters( 'the_content', $section['_ttm_section_content'] ) : ''; ?>
                    </div>
                </div>
            </div> <!-- section ends -->
			<?php
		endforeach;
	endif; ?>
	<?php
	$first_column_content  = get_post_meta( $post_id, '_qwl_four_columns2_column1_content', 1 );
	$second_column_content = get_post_meta( $post_id, '_qwl_four_columns2_column2_content', 1 );
	$third_column_content  = get_post_meta( $post_id, '_qwl_four_columns2_column3_content', 1 );
	$fourth_column_content = get_post_meta( $post_id, '_qwl_four_columns2_column4_content', 1 );

	$count = 0;

	$first_column_content != '' ? $count ++ : false;
	$second_column_content != '' ? $count ++ : false;
	$third_column_content != '' ? $count ++ : false;
	$fourth_column_content != '' ? $count ++ : false;
	if ( $first_column_content != '' || $second_column_content != '' || $third_column_content != '' || $fourth_column_content != '' ): ?>
        <div class="page-content fullwidth bg-bright col<?php echo $count; ?>-container">
            <div class="holder">
				<?php for ( $i = 1; $i <= 4; $i ++ ): ?>
                    <article class="col">
                        <a href="<?php echo esc_url( get_post_meta( $post_id, '_qwl_four_columns2_column' . $i . '_link', 1 ) ); ?>">
							<?php
							if ( '' != get_post_meta( $post_id, '_qwl_four_columns2_column' . $i . '_img', 1 ) ) {
								$img_id = get_post_meta( $post_id, '_qwl_four_columns2_column' . $i . '_img_id', 1 );
								?>
                                <div class="icon-holder icon-target">
									<?php echo wp_get_attachment_image( $img_id, 'full' ); ?>
                                </div>
								<?php
							} else if ( '' != get_post_meta( $post_id, '_qwl_four_columns2_column' . $i . '_icon',
									1 ) && 'none' != get_post_meta( $post_id,
									'_qwl_four_columns2_column' . $i . '_icon', 1 )
							) {
								?>
                                <div class="icon-holder icon-target">
                                    <img
                                            src="<?php echo get_post_meta( $post_id,
												'_qwl_four_columns2_column' . $i . '_icon', 1 ); ?>"
                                            alt="<?php echo get_post_meta( $post_id,
												'_qwl_four_columns2_column' . $i . '_icon_alt', 1 ); ?>">
                                </div>
							<?php } ?>

							<?php if ( '' != get_post_meta( $post_id, '_qwl_four_columns2_column' . $i . '_content',
									1 )
							): ?>
                                <div class="detail">
									<?php echo do_shortcode( wpautop( get_post_meta( $post_id,
										'_qwl_four_columns2_column' . $i . '_content', 1 ) ) ); ?>
                                </div>
							<?php endif; ?>
                        </a>
                    </article>
				<?php endfor; ?>
            </div>
        </div>
	<?php endif; ?>
	<?php if ( '' != get_post_meta( $post_id, '_qwl_section8_content', 1 ) ): ?>
        <div class="page-content fullwidth bottom-content editor-content">
            <div class="holder">
				<?php echo apply_filters( 'the_content', get_post_meta( $post_id, '_qwl_section8_content', 1 ) ); ?>
            </div>
        </div>
        <!-- .footer bottom content ENDS -->
	<?php endif; ?>

	<?php echo do_shortcode( '[services]' ); ?>
<?php endwhile;
get_footer(); ?>