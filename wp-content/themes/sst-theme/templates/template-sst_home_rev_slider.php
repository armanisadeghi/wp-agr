<?php
/*
 * Template Name: SST Standard Page w/ Slider
 */
get_header();
while ( have_posts() ):the_post(); ?>
	<!-- Page Header -->
	<?php
	$post_id          = get_the_ID();
	$guide_img        = get_post_meta( $post_id, '_qwl_guide_img', 1 );
	$guide_img_id     = get_post_meta( $post_id, '_qwl_guide_img_id', 1 );
	$guide_content    = get_post_meta( $post_id, '_qwl_guide_content', 1 );
	$guide_btn_txt    = esc_html( get_post_meta( $post_id, '_qwl_guide_btn_txt', 1 ) );
	$guide_url        = esc_url( get_post_meta( $post_id, '_qwl_guide_url', 1 ) );
	$guide_optin      = esc_html( get_post_meta( $post_id, '_qwl_guide_slug', 1 ) );
	$slider_shortcode = get_post_meta( $post_id, '_qwl_revolutionary_banner_shortcode', 1 );
	if ( '' !== $slider_shortcode ): ?>
		<div id="billboard">
			<?php
			$mobile_banner_id      = get_post_meta( $post_id, '_qwl_mobile_banner_image_id', 1 );
			$mobile_banner_content = get_post_meta( $post_id, '_qwl_mobile_banner_content', 1 );
			if ( '' != $mobile_banner_id ):
				?>
				<div class="mobile-only">
					<?php echo wp_get_attachment_image( $mobile_banner_id, 'full' ); ?>
					<div class="overlay">
						<?php echo $mobile_banner_content; ?>
					</div><!--end of .overlay-->
				</div><!--end of .mobile-banner-->
				<?php
			endif;
			?>
			<div class="<?php echo '' != $mobile_banner_id ? 'desktop-only' : ''; ?>">
				<?php echo do_shortcode( $slider_shortcode ); ?>
			</div><!--end of .desktop-only-->

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
		<div class="page-content fullwidth bg-bright col<?php echo $count; ?>-container aligncenter">
			<div class="holder">
				<?php for ( $i = 1; $i <= 4; $i ++ ): ?>
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
									1 ) || 'none' != get_post_meta( $post_id,
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
				<?php endfor; ?>
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
			<?php endif; ?>
			<?php get_sidebar(); ?>
		</div>
	</div>
	<?php if ( '' != get_post_meta( $post_id, '_qwl_section1_img', 1 ) || '' != get_post_meta( $post_id,
			'_qwl_section1_content', 1 )
	): ?>
		<div class="page-content fullwidth bg-theme-color business-bible">
			<div class="holder">
				<?php
				if ( '' !== get_post_meta( $post_id, '_qwl_section1_img', 1 ) ):
					$img_id = get_post_meta( $post_id, '_qwl_section1_img_id', 1 );
					?>
					<figure class="image-container alignleft">
						<?php echo wp_get_attachment_image( $img_id, 'full' ); ?>
					</figure>
				<?php endif; ?>
				<?php if ( '' !== get_post_meta( $post_id, '_qwl_section1_content', 1 ) ): ?>
					<div class="detail">
						<?php echo do_shortcode( wpautop( get_post_meta( $post_id, '_qwl_section1_content',
							1 ) ) ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

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
	if ( $first_column_content != '' || $second_column_content != '' || $third_column_content != '' || $fourth_column_content != '' ):
		?>
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
	<?php if ( '' != get_post_meta( $post_id, '_qwl_section2_content', 1 ) ): ?>
		<div class="page-content fullwidth bg-theme-color col4-container">
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
	<?php if ( '' != get_post_meta( $post_id, '_qwl_section3_content', 1 ) ): ?>
		<div class="page-content fullwidth bg-bright">
			<div class="holder">
				<?php if ( '' !== get_post_meta( $post_id, '_qwl_section3_content', 1 ) ): ?>
					<div class="detail">
						<?php echo do_shortcode( wpautop( get_post_meta( $post_id, '_qwl_section3_content',
							1 ) ) ); ?>

					</div>
				<?php endif; ?>
			</div>
		</div><!-- speaker section ends -->
	<?php endif; ?>

	<?php
	if ( '' !== get_post_meta( $post_id, '_qwl_section4_content', 1 ) ):
		?>
		<div class="page-content fullwidth bg-theme-color speaker-section">
			<div class="holder">
				<?php
				if ( '' !== get_post_meta( $post_id, '_qwl_section4_img', 1 ) ):
					$img_id = get_post_meta( $post_id, '_qwl_section4_img_id', 1 );
					?>
					<figure class="image-container alignleft">
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
	if ( '' != get_post_meta( $post_id, '_qwl_section6_content', 1 ) ):
		?>
		<div
			class="page-content fullwidth aligncenter bg-light-color as-seen-on">
			<div class="holder">
				<?php echo apply_filters( 'the_content', get_post_meta( $post_id, '_qwl_section6_content', 1 ) ); ?>
			</div>
		</div>
		<!--    titanium live section ends -->
	<?php endif; ?>
	<?php
	if ( '' != get_post_meta( $post_id, '_qwl_section8_content', 1 ) ):
		?>
		<div class="page-content fullwidth bottom-content editor-content">
			<div class="holder">
				<?php echo do_shortcode( wpautop( get_post_meta( $post_id, '_qwl_section8_content', 1 ) ) ); ?>
			</div>
		</div>
		<!-- .footer bottom content ENDS -->
	<?php endif; ?>
	<!-- TESTIMONIALS SECTION STARTS -->
	<?php if ( '' != get_post_meta( $post_id, '_qwl_section7_content', 1 ) ): ?>
		<div class="page-content fullwidth bg-dark-color testimonial-block clearfix">
			<?php if ( '' != get_post_meta( $post_id, '_qwl_section7_content', 1 ) ): ?>
				<div class="content">
					<?php echo do_shortcode( wpautop( get_post_meta( $post_id, '_qwl_section7_content', 1 ) ) ); ?>
				</div>
			<?php endif; ?>
		</div> <!-- the testimonials section ends -->
	<?php endif; ?>
<?php endwhile;
get_footer(); ?>