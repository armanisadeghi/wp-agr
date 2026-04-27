<?php
/*
 * Template Name: SST Franchise Opportunity
 */
get_header();
if ( have_posts() ):
	while ( have_posts() ):the_post();
		$post_id = get_the_ID();
		$banners = get_post_meta( $post_id, '_ttm_banner_slider_group', 1 );
		?>
		<div id="billboard" class="banner-holder">
			<?php
			$banner_bg_img  = get_post_meta( $post_id, '_ttm_banner_slider_bg_id', 1 );
			$banner_img     = get_post_meta( $post_id, '_ttm_banner_slider_img_id', 1 );
			$banner_content = get_post_meta( $post_id, '_ttm_banner_slider_content', 1 );

			if ( $banner_img != '' ): ?>
				<div class="billboard-inner">
					<figure>
						<?php echo wp_get_attachment_image( $banner_bg_img, 'full' ); ?>
					</figure>
					<div class="billboard-content overlay">
						<div class="holder">
							<figure>
								<?php echo wp_get_attachment_image( $banner_img, 'full' ); ?>
							</figure>
							<div class="detail">
								<?php echo $banner_content; ?>
							</div>
						</div>
					</div>
				</div>
			<?php else: ?>
				<div class="slides slick-slider">
					<?php foreach ( $banners as $banner ): ?>
						<?php if ( $banner['_ttm_banner_slider_img_id'] != "" ) : ?>
							<div>
								<div class="bg-container"
								     style="background-image: url(<?php echo $banner['_ttm_banner_slider_bg']; ?>)">
									<?php echo wp_get_attachment_image( $banner['_ttm_banner_slider_bg_id'], 'full' ); ?>
								</div>
								<?php if ( '' != $banner['_ttm_banner_slider_content'] || '' != $banner['_ttm_banner_slider_btn_txt'] || '' != $banner['_ttm_banner_slider_btn_url'] ): ?>
									<div class="holder">
										<figure>
											<?php echo wp_get_attachment_image( $banner['_ttm_banner_slider_img_id'], 'full' ); ?>
										</figure>
										<div class="billboard-content">
											<div class="detail">
												<p><?php echo $banner['_ttm_banner_slider_content']; ?></p>
												<?php if ( '' != $banner['_ttm_banner_slider_btn_txt'] || '' != $banner['_ttm_banner_slider_btn_url'] ): ?>
													<a href="<?php echo $banner['_ttm_banner_slider_btn_url']; ?>"
													   class="button color1"><?php echo $banner['_ttm_banner_slider_btn_txt']; ?></a>
												<?php endif; ?>
											</div>
										</div>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div><!-- Billboard Container -->
		<div class="welcome-section">
			<div class="holder">
				<?php the_content(); ?>
			</div>
		</div>
		<?php
		$about_lists = get_post_meta( $post_id, '_ttm_about_list_group', 1 );
		if ( $about_lists != '' || array_key_exists( '_ttm_about_item_image_id', $about_lists[0] ) ): ?>
			<div class="two-cols-list">
				<div class="holder">
					<ul class="franchise-about-list">
						<?php foreach ( $about_lists as $about_list ): ?>
							<li class="item">
								<figure>
									<?php echo wp_get_attachment_image( $about_list['_ttm_about_item_image_id'], 'full' ); ?>
								</figure>
								<div class="detail-holder">
									<div class="detail">
										<?php echo $about_list['_ttm_about_item_content']; ?>
									</div>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		<?php endif; ?>
		<?php
		$business_title     = get_post_meta( $post_id, '_ttm_business_title', 1 );
		$business_info_list = get_post_meta( $post_id, '_ttm_business_info_group', 1 );
		if ( is_array( $business_info_list ) && array_key_exists( '_ttm_business_info_title', $business_info_list[0] ) ): ?>
			<div class="business-info-section">
				<div class="holder">
					<?php if ( $business_title != '' ): ?>
						<h2><?php echo get_post_meta( $post_id, '_ttm_business_title', 1 ); ?></h2>
					<?php endif; ?>

					<ul class="business-info-list">
						<?php foreach ( $business_info_list as $business_info ): ?>
							<li class="item">
								<h3><?php echo $business_info['_ttm_business_info_title']; ?></h3>

								<p><?php echo $business_info['_ttm_business_info_content']; ?></p>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		<?php endif; ?>
		<?php echo do_shortcode( '[services]' ); ?>
		<?php
		$team = new WP_Query( [
			'post_type'      => 'team',
			'posts_per_page' => 2
		] );

		if ( $team->have_posts() ): ?>
			<div class="franchise-team-section col2-container team-wrapper">
				<div class="holder">
					<h2>Meet Our Team</h2>

					<div class="equal-height content-holder">
						<?php while ( $team->have_posts() ): $team->the_post();
							$team_id = get_the_ID(); ?>
							<div class="col item">
								<div class="col-inner clearfix">

									<div class="img-wrapper item">
										<a href="<?php the_permalink(); ?>">
											<?php if ( has_post_thumbnail() ) :
												the_post_thumbnail( [ 141, 141 ] );
											else:
												?>
												<img
													src="<?php echo get_template_directory_uri(); ?>/assets/images/avatar.png"
													alt="<?php bloginfo(); ?> default avatar image">
											<?php endif; ?>
										</a>
									</div>

									<div class="detail item">
										<?php echo apply_filters( 'the_content', wp_trim_words( get_the_content(), $num_words = 25, '[...]' ) ); ?>
										<div class="detail-footer">
											<h3>
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h3>
											<?php if ( '' != get_post_meta( $team_id, '_qwl_team_designation', 1 ) ): ?>
												<span class="team-designation">
													<?php echo get_post_meta( $team_id, '_qwl_team_designation', 1 ); ?>
												</span>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						<?php endwhile;
						wp_reset_postdata(); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?php
	endwhile;
endif;
get_footer();
