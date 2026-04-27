<?php
/*
 * Template Name: SST Standard Page w/ Sub Buttons
 */

get_header( 'fancy' );
if ( have_posts() ):
	while ( have_posts() ):the_post();
		$post_id = get_the_ID(); ?>
		<?php $banners = get_post_meta( $post_id, '_qwl_banner_group', 1 );
		if ( '' != $banners || 'dark-font-color' != $banners[0]['_qwl_banner_font_color_class'] ): ?>
            <div class="banner-section">
                <div class="holder">
                    <div class="banner-slides">
						<?php foreach ( $banners as $banner ): ?>
                            <div class="slide-item">
								<?php if ( '' != $banner['_qwl_banner_img'] ): ?>
									<?php echo wp_get_attachment_image( $banner['_qwl_banner_img_id'], 'full' ); ?>
								<?php endif; ?>
                                <div class="banner-caption">
									<?php if ( '' != $banner['_qwl_banner_heading'] ): ?>
										<?php echo $banner['_qwl_banner_heading']; ?>

									<?php endif; ?>
									<?php if ( '' != $banner['_qwl_banner_para'] ): ?>
										<?php echo wpautop( nl2br( $banner['_qwl_banner_para'] ) ); ?>
									<?php endif; ?>
									<?php if ( '' != $banner['_qwl_banner_btn_txt'] || '' != $banner['_qwl_banner_btn_url'] ): ?>
                                        <a href="<?php echo $banner['_qwl_banner_btn_url']; ?>"
                                           class="button secondary rounded <?php echo ( '' != get_post_meta( $post_id, '_ttm_popup_content', 1 ) ) ? 'popup' : ''; ?>"><?php echo $banner['_qwl_banner_btn_txt']; ?></a>
									<?php endif; ?>

                                </div>
                            </div>
						<?php endforeach; ?>
                    </div>
                </div>
				<?php if ( '' != get_post_meta( $post_id, '_ttm_popup_content', 1 ) ): ?>
                    <div id="popup-form" class="hide">
						<?php echo do_shortcode( get_post_meta( $post_id, '_ttm_popup_content',
							1 ) ); ?>
                    </div>
				<?php endif; ?>
                <div class="guide-section section imagefloat white">
                    <div class="holder">
						<?php
						$guide_img     = get_post_meta( $post_id, '_qwl_guide_img', 1 );
						$guide_img_id  = get_post_meta( $post_id, '_qwl_guide_img_id', 1 );
						$guide_content = get_post_meta( $post_id, '_qwl_guide_content', 1 );
						$guide_btn_txt = get_post_meta( $post_id, '_qwl_guide_btn_txt', 1 );
						$guide_btn_url = get_post_meta( $post_id, '_qwl_guide_btn_url', 1 );
						$guide_optin   = esc_html( get_post_meta( $post_id, '_qwl_guide_slug', 1 ) );
						if ( '' != $guide_img ): ?>
                            <div class="image-container">
								<?php echo wp_get_attachment_image( $guide_img_id, 'full' ); ?>
                            </div>
						<?php endif; ?>
                        <div class="detail">
							<?php echo apply_filters( 'the_content', $guide_content ); ?>
                            <a href="#" class="button hollow primary rounded manual-optin-trigger"
                               data-optin-slug="<?php echo $guide_optin ?>"><?php echo $guide_btn_txt; ?></a>
                        </div>

                    </div>
                </div>
            </div>
		<?php endif; ?>

		<?php
		$first_column_content  = get_post_meta( $post_id, '_qwl_four_columns1_column1_content', 1 );
		$second_column_content = get_post_meta( $post_id, '_qwl_four_columns1_column2_content', 1 );
		$third_column_content  = get_post_meta( $post_id, '_qwl_four_columns1_column3_content', 1 );
		$fourth_column_content = get_post_meta( $post_id, '_qwl_four_columns1_column4_content', 1 );

		$count = 0;

		$first_column_content != '' ? $count ++ : false;
		$second_column_content != '' ? $count ++ : false;
		$third_column_content != '' ? $count ++ : false;
		$fourth_column_content != '' ? $count ++ : false;
		if ( $first_column_content != '' || $second_column_content != '' || $third_column_content != '' || $fourth_column_content != '' ):
			?>
            <div class="services-list grid-desktop-<?php echo $count; ?> collapse">
                <div class="holder">
					<?php for ( $i = 1; $i <= 4; $i ++ ): ?>
						<?php if ( '' != get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_content',
								1 ) || '' != get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_img', 1 ) ||
						           ( '' != get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_icon',
								           1 ) && 'none' != get_post_meta( $post_id,
								           '_qwl_four_columns1_column' . $i . '_icon', 1 )
						           )
						): ?>
                            <div class="column">
								<?php
								if ( '' != get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_img', 1 ) ) {
									$img_id = get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_img_id', 1 );
									?>
                                    <div class="img-container">
										<?php echo wp_get_attachment_image( $img_id, 'full' ); ?>
                                    </div>
									<?php
								} else if ( '' != get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_icon',
										1 ) && 'none' != get_post_meta( $post_id,
										'_qwl_four_columns1_column' . $i . '_icon', 1 )
								) {
									?>
                                    <div class="img-container">
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
                                        <span class="fa-arrow-thin-right"></span>
										<?php echo do_shortcode( wpautop( get_post_meta( $post_id,
											'_qwl_four_columns1_column' . $i . '_content', 1 ) ) ); ?>
                                    </div>
								<?php endif; ?>
                            </div>
						<?php endif; ?>
					<?php endfor; ?>
                </div>
            </div>
		<?php endif; ?>

        <div class="section main-content-wrapper">
            <div class="holder">
                <div class="main-content editor-content">
					<?php the_content(); ?>
                </div>
				<?php get_sidebar( 'fancy' ); ?>
            </div>
        </div>
		<?php
	endwhile;
endif;
get_footer( 'fancy' );