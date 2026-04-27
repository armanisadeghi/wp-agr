<?php
/*
 * Template Name: SST Event Details
 */
get_header(); ?>
<div class="event-page-wrapper">
	<?php while ( have_posts() ):the_post(); ?>
		<!-- Page Header -->
		<?php
		$post_id = get_the_ID();
		$banners = get_post_meta( $post_id, '_qwl_banner_group', 1 );

		$guide_img     = get_post_meta( $post_id, '_qwl_guide_img', 1 );
		$guide_img_id  = get_post_meta( $post_id, '_qwl_guide_img_id', 1 );
		$guide_content = get_post_meta( $post_id, '_qwl_guide_content', 1 );
		$guide_btn_txt = esc_html( get_post_meta( $post_id, '_qwl_guide_btn_txt', 1 ) );
		$guide_url     = esc_url( get_post_meta( $post_id, '_qwl_guide_url', 1 ) );
		$guide_optin   = esc_html( get_post_meta( $post_id, '_qwl_guide_slug', 1 ) );
		?>
		<?php if ( '' !== $banners || $banners[0]['_qwl_banner_font_color_class'] != "dark" ): ?>
			<div id="billboard">
				<?php
				$mobile_banner_id      = get_post_meta( $post_id, '_qwl_mobile_banner_image_id', 1 );
				$mobile_banner_content = get_post_meta( $post_id, '_qwl_mobile_banner_content', 1 );
				if ( '' != $mobile_banner_id && 0 != $mobile_banner_id ): ?>
					<div class="mobile-only">
						<?php echo wp_get_attachment_image( $mobile_banner_id, 'full' ); ?>
						<div class="overlay">
							<?php echo $mobile_banner_content; ?>
						</div><!--end of .overlay-->
					</div><!--end of .mobile-banner-->
				<?php endif; ?>
				<?php if ( '' != $mobile_banner_id && 0 != $mobile_banner_id ) { ?>
				<div class="<?php echo "desktop-only"; ?>">
					<?php } ?>
					<div class="slides slick-slider">
						<?php foreach ( $banners as $banner ):
							$opt_in_slug = array_key_exists( '_qwl_banner_btn_optin', $banner ) && $banner['_qwl_banner_btn_optin'] != '' ? 'data-optin-slug="' . $banner['_qwl_banner_btn_optin'] . '"' : '';
							?>
							<?php if ( array_key_exists( '_qwl_banner_img_id', $banner ) ) : ?>
							<div>
								<div class="image-container <?php echo $opt_in_slug != '' ? 'sold-out' : ''; ?>">
									<?php echo wp_get_attachment_image( $banner['_qwl_banner_img_id'], 'full' ); ?>
								</div>
								<?php if ( array_key_exists( '_qwl_banner_heading', $banner ) && $banner['_qwl_banner_heading'] != ''
								           || array_key_exists( '_qwl_banner_para', $banner ) && $banner['_qwl_banner_para'] != ''
								           || array_key_exists( '_qwl_banner_btn_txt', $banner ) && $banner['_qwl_banner_btn_txt'] != ''
								           || array_key_exists( '_qwl_banner_btn_url', $banner ) && $banner['_qwl_banner_btn_url'] != ''
								):
									?>
									<div class="holder">
										<div
											class="billboard-content <?php echo array_key_exists( '_qwl_banner_content_alignment_class', $banner ) ? 'align' . $banner['_qwl_banner_content_alignment_class'] : 'aligncenter'; ?> <?php echo array_key_exists( '_qwl_banner_font_color_class', $banner ) ? $banner['_qwl_banner_font_color_class'] . '-font-color' : 'dark-font-color'; ?>">
											<h2><?php echo array_key_exists( '_qwl_banner_heading', $banner ) ? $banner['_qwl_banner_heading'] : ''; ?></h2>

											<div class="billboard-detail">
												<?php echo array_key_exists( '_qwl_banner_para', $banner ) ? apply_filters( 'the_content', $banner['_qwl_banner_para'] ) : ''; ?>
												<?php if ( array_key_exists( '_qwl_banner_btn_txt', $banner ) || array_key_exists( '_qwl_banner_btn_url', $banner ) ): ?>
													<a href="<?php echo esc_url( $banner['_qwl_banner_btn_url'] ); ?>"
													   class="button color <?php echo ( '' != get_post_meta( $post_id, '_ttm_popup_content', 1 ) ) ? 'popup' : ''; ?> <?php echo $opt_in_slug != '' ? 'manual-optin-trigger' : ''; ?>" <?php echo $opt_in_slug ?>><?php echo $banner['_qwl_banner_btn_txt']; ?>
													</a>
												<?php endif; ?>
												<?php if ( '' != get_post_meta( $post_id, '_ttm_popup_content', 1 ) ): ?>
													<div id="popup-form" class="hide">
														<?php echo apply_filters( 'the_content', get_post_meta( $post_id, '_ttm_popup_content', 1 ) ); ?>
													</div>
												<?php endif; ?>
											</div>
										</div>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						<?php endforeach; ?>
					</div>
					<?php if ( '' != $mobile_banner_id && 0 != $mobile_banner_id ) { ?>
				</div>
			<?php } ?>
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
                                           class="button color1 manual-optin-trigger"
                                           data-optin-slug="<?php echo $guide_optin ?>"><?php echo $guide_btn_txt; ?></a>
									<?php else: ?>
                                        <a href="<?php echo $guide_url; ?>"
                                           class="button color1" target="_blank"><?php echo $guide_btn_txt; ?></a>
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
		if ( $first_column_content != '' || $second_column_content != '' || $third_column_content != '' || $fourth_column_content != '' ):
			?>
			<div class="page-content fullwidth bg-bright col<?php echo $count; ?>-container aligncenter">
				<div class="holder">
					<?php for ( $i = 1; $i <= 4; $i ++ ):
						if ( '' != get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_content', 1 ) ):
							?>
							<article class="col">
								<a href="<?php echo esc_url( get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_link', 1 ) ); ?>">
									<?php
									if ( '' != get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_img', 1 ) ) {
										$img_id = get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_img_id', 1 );
										?>
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
		<div class="page-content fullwidth event-container">
			<div class="holder">
				<?php if ( '' != get_the_content() ): ?>
					<article class="main-container add-style">
						<div class="editor-content">
							<?php the_content(); ?>
						</div>
					</article>
					<aside class="sidebar">
						<?php
						$prefix = '_ttm';
						if ( get_post_meta( $post_id, $prefix . '_review_plan_content', 1 ) != '' ): ?>
							<div class="area-review-plan side-block">
								<?php echo apply_filters( 'the_content', get_post_meta( $post_id, $prefix . '_review_plan_content', 1 ) ); ?>
							</div>
						<?php endif; ?>
						<?php if ( get_post_meta( $post_id, $prefix . '_review_plan_bonus', 1 ) != '' ): ?>
							<div class="area-review-plan-bonus">
								<?php echo apply_filters( 'the_content', get_post_meta( $post_id, $prefix . '_review_plan_bonus', 1 ) ); ?>
							</div>
						<?php endif; ?>
						<?php if ( get_post_meta( $post_id, $prefix . '_vip_experience_content', 1 ) != '' ): ?>
							<div class="vip-exp-block">
								<?php echo apply_filters( 'the_content', get_post_meta( $post_id, $prefix . '_vip_experience_content', 1 ) ); ?>
							</div>
						<?php endif; ?>
					</aside>
				<?php endif; ?>
			</div>
			<?php
			if ( '' !== get_post_meta( $post_id, '_qwl_section4_content', 1 ) ):
				?>
				<div class="page-content fullwidth bg-dark-color">
					<div class="holder">
						<?php
						if ( '' !== get_post_meta( $post_id, '_qwl_section4_img', 1 ) ):
							$img_id = get_post_meta( $post_id, '_qwl_section4_img_id', 1 );
							?>
							<figure class="image-container alignright">
								<?php echo wp_get_attachment_image( $img_id, 'full' ); ?>
							</figure>
						<?php endif; ?>
						<?php if ( '' !== get_post_meta( $post_id, '_qwl_section4_content', 1 ) ): ?>
							<div class="detail">
								<?php echo do_shortcode( wpautop( get_post_meta( $post_id, '_qwl_section4_content',
									1 ) ) ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php
			if ( '' !== get_post_meta( $post_id, '_qwl_section5_content', 1 ) ):
				?>
				<div class="page-content fullwidth bg-bright podcast-section">
					<div class="holder">
						<?php
						if ( '' !== get_post_meta( $post_id, '_qwl_section5_img', 1 ) ):
							$img_id = get_post_meta( $post_id, '_qwl_section5_img_id', 1 );
							?>
							<figure class="image-container alignleft">
								<?php echo wp_get_attachment_image( $img_id, 'full' ); ?>
							</figure>
						<?php endif; ?>
						<?php if ( '' !== get_post_meta( $post_id, '_qwl_section5_content', 1 ) ): ?>
							<div class="detail">
								<?php echo do_shortcode( wpautop( get_post_meta( $post_id, '_qwl_section5_content',
									1 ) ) ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ( '' != get_post_meta( $post_id, '_qwl_section1_img', 1 )
			           || '' != get_post_meta( $post_id, '_qwl_section1_content', 1 )
			): ?>
				<div class="page-content fullwidth bg-dark-color business-bible keynot-speaker">
					<div class="holder">
						<?php
						$img_id = get_post_meta( $post_id, '_qwl_section1_img_id', 1 );
						if ( '' !== $img_id ): ?>
							<figure class="image-container alignleft">
								<?php echo wp_get_attachment_image( $img_id, 'full' ); ?>
							</figure>
						<?php endif; ?>
						<?php if ( '' !== get_post_meta( $post_id, '_qwl_section1_content', 1 ) ): ?>
							<div class="detail">
								<?php echo apply_filters( 'the_content', get_post_meta( $post_id, '_qwl_section1_content', 1 ) ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ( '' != get_post_meta( $post_id, '_qwl_section2_content', 1 ) ): ?>
				<div class="page-content fullwidth bg-theme-color col4-container aligncenter has-bg-image"
				     style="background: url('<?php echo get_post_meta( $post_id, '_qwl_section2_bg_image', 1 ); ?>')">
					<div class="holder">
						<?php if ( '' !== get_post_meta( $post_id, '_qwl_section2_content', 1 ) ): ?>
							<div class="detail">
								<?php echo apply_filters( 'the_content', get_post_meta( $post_id, '_qwl_section2_content', 1 ) ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<!-- titnaium life podcast section ends -->
			<?php endif; ?>
		</div>
	<?php endwhile; ?>
</div>
<?php get_footer(); ?>
