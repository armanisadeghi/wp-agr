<?php
/*
 * Template Name: SST Multi Block Feature
 */
get_header( 'home8' );
while ( have_posts() ):the_post(); ?>
	<!-- Page Header -->
	<?php
	$post_id       = get_the_ID();
	$guide_img     = get_post_meta( $post_id, '_qwl_guide_img', 1 );
	$guide_img_id  = get_post_meta( $post_id, '_qwl_guide_img_id', 1 );
	$guide_content = get_post_meta( $post_id, '_qwl_guide_content', 1 );
	$guide_btn_txt = esc_html( get_post_meta( $post_id, '_qwl_guide_btn_txt', 1 ) );
	$guide_url     = esc_url( get_post_meta( $post_id, '_qwl_guide_url', 1 ) );
	$guide_optin   = esc_html( get_post_meta( $post_id, '_qwl_guide_slug', 1 ) );

	//article section group
	$prefix   = '_ttm';
	$banners  = get_post_meta( $post_id, $prefix . '_home8_banner_group', 1 );
	$articles = get_post_meta( $post_id, $prefix . '_home8_articles_group', 1 );

	//Learn / Register Blocks
	$learn_title           = get_post_meta( $post_id, $prefix . '_home8_learn_title', 1 );
	$learn_confidential    = get_post_meta( $post_id, $prefix . '_home8_learn_confidential', 1 );
	$learn_button_label    = get_post_meta( $post_id, $prefix . '_home8_learn_button_label', 1 );
	$learn_button_url      = get_post_meta( $post_id, $prefix . '_home8_learn_button_url', 1 );
	$register_form        = get_post_meta( $post_id, $prefix . '_home8_register_form', 1 );
	//bottom section group
	$sections = get_post_meta( $post_id, '_ttm_section_group', 1 );
	?>
	<?php if ( is_array( $banners ) || is_object( $banners ) ): ?>
		<?php if ( '' != $banners[0]['_ttm_banner_image_id'] ): ?>
			<div id="billboard" class="billboard-fancy holder custom-holder">
				<div class="slides slick-slider">
					<?php foreach ( $banners as $banner ): ?>
						<?php if ( array_key_exists( '_ttm_banner_image_id', $banner ) && array_key_exists( '_ttm_banner_content', $banner ) ): ?>
							<div>
								<div class="holder custom-holder">
									<div class="billboard-main">
										<figure class="image-holder">
											<?php echo wp_get_attachment_image( $banner['_ttm_banner_image_id'], [
												1265,
												844
											] ); ?>
										</figure>
										<?php if ( '' != $banner['_ttm_banner_content'] ): ?>
											<div class="billboard-content">
												<div class="detail">
													<?php echo wpautop( $banner['_ttm_banner_content'] ); ?>
													<?php if ( '' != $banner['_ttm_button_label'] ): ?>
														<a href="<?php echo $banner['_ttm_button_url']; ?>"
														   class="button-eight"><?php echo $banner['_ttm_button_label']; ?></a>
													<?php endif; ?>
												</div>
											</div>
										<?php endif; ?>
									</div>
									<?php if ( '' != $banner['_ttm_blockquote'] ): ?>
										<div class="billboard-quote">
											<blockquote><?php echo $banner['_ttm_blockquote']; ?></blockquote>
											<ul class="quote-info">
												<li>
													<span
														class="quote-writer"><?php echo $banner['_ttm_author']; ?></span>
												</li>
												<li>
											<span
												class="writer-designation"><?php echo $banner['_ttm_designation']; ?></span>
												</li>
												<li>
												<span
													class="quote-address"><?php echo $banner['_ttm_address']; ?></span>
												</li>
											</ul>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</div><!-- Billboard Container -->
		<?php endif; ?>
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
		<div class="page-content fullwidth bg-bright col<?php echo $count; ?>-container aligncenter flex-bottom-holder">
			<div class="holder">
				<?php for ( $i = 1; $i <= 4; $i ++ ):
					$column_link = get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_link', 1 ) != '' ? esc_url( get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_link', 1 ) ) : 'javascript:void()';
					if ( '' != get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_content', 1 ) ): ?>
						<article class="col">
							<a href="<?php echo $column_link; ?>">
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
										<?php echo apply_filters( 'the_content', get_post_meta( $post_id, '_qwl_four_columns1_column' . $i . '_content', 1 ) ); ?>
										<div class="readmore-holder">
											<span class="read-more">read more</span>
										</div>
									</div>
								<?php endif; ?>
							</a>
						</article>
					<?php endif; endfor; ?>
			</div>
		</div>
	<?php endif; ?>
	<?php if ( ( '' != $guide_img ) || ( '' != $guide_content ) || ( '' != $guide_btn_txt ) || ( '' != $guide_url ) ): ?>
		<div class="guide-holder flex-holder">
			<div class="holder">
				<?php if ( '' != $guide_img ): ?>
					<div class="image-holder flex-first-col">
						<figure> <?php echo wp_get_attachment_image( $guide_img_id, 'full' ); ?></figure>
					</div>
				<?php endif; ?>
				<?php if ( '' != $guide_content ): ?>
					<div class="detail clearfix flex-center-col">
						<?php echo apply_filters( 'the_content', $guide_content ); ?>
					</div>
					<div class="guide-button-holder flex-last-col">
						<?php if ( $guide_optin != '' ): ?>
							<a href="<?php echo $guide_url; ?>"
							   class="button no-color manual-optin-trigger"
							   data-optin-slug="<?php echo $guide_optin ?>"><?php echo $guide_btn_txt; ?></a>
						<?php else: ?>
							<a href="<?php echo $guide_url; ?>"
							   class="button no-color"><?php echo $guide_btn_txt; ?></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
	<div class="two-cols-alter-group">
		<?php if ( '' != $learn_title || '' != $register_form ): ?>
			<div class="two-cols-alter lr-group">
				<div class="holder">
                        <div class="cols register-block">
                            <div class="detail">
                                <div class="innter-detail">
									<?php echo do_shortcode($register_form)?>
                                </div>
                            </div>
                        </div>
					<?php if ( '' != $learn_title ): ?>
						<div class="cols learn-block">
							<div class="detail">
								<div class="innter-detail">
									<h2><?php echo $learn_title; ?>
										<small><?php echo $learn_confidential; ?></small>
									</h2>
									<?php if ( '' != $learn_button_label ): ?>
										<a href="<?php echo $learn_button_url; ?>"
										   title="<?php echo $learn_button_label; ?>"
										   class="button-eight">
											<?php echo $learn_button_label; ?>
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if ( is_array( $articles ) || is_object( $articles ) ): ?>
			<?php foreach ( $articles as $article ): ?>
				<?php if ( array_key_exists( '_ttm_article_image_id', $article ) && array_key_exists( '_ttm_article_content', $article ) ) : ?>
					<article class="two-cols-alter basic">
						<div class="holder">
							<div class="cols">
								<div class="detail">
									<div class="innter-detail">
										<div class="tag-holder">
											<p><?php echo $article['_ttm_article_tag']; ?></p>
										</div>
										<h2>
											<a href="<?php echo $article['_ttm_read_more_url']; ?>"
											   title="<?php echo $article['_ttm_read_more_label']; ?>">
												<?php echo $article['_ttm_article_title']; ?>
											</a>
										</h2>
										<?php echo wpautop( $article['_ttm_article_content'] ); ?>

										<div class="readmore-holder">
											<a href="<?php echo $article['_ttm_read_more_url']; ?>"
											   title="<?php echo $article['_ttm_read_more_label']; ?>"
											   class="read-more"><?php echo $article['_ttm_read_more_label']; ?></a>
										</div>
									</div>
								</div>
							</div>
							<div class="cols">
								<div class="detail">
									<div class="innter-detail">
										<figure class="image-holder has-bg"
										        style="background-color: <?php echo $article['_ttm_section_background_color']; ?>">
									<span class="bg-color-holder"
									      style="background-color: <?php echo $article['_ttm_section_background_color']; ?>"></span>
											<a href="<?php echo $article['_ttm_read_more_url']; ?>"
											   title="<?php echo $article['_ttm_read_more_label']; ?>">
												<?php echo wp_get_attachment_image( $article['_ttm_article_image_id'], 'full' ); ?>
											</a>
										</figure>
									</div>
								</div>
							</div>
						</div>
					</article>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		<div class="two-cols-alter additional-section">
			<div class="holder">
				<div class="cols contact-block">
					<div class="detail">
						<div class="innter-detail">
							<?php if ( is_active_sidebar( 'location-widget' ) ): ?>
								<div class="contact-detail">
									<?php dynamic_sidebar( 'location-widget' ); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="cols search-block">
					<div class="detail">
						<div class="innter-detail">
							<?php if ( is_active_sidebar( 'location-search-widget' ) ): ?>
								<?php dynamic_sidebar( 'location-search-widget' ); ?>
								<hr/>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endwhile;
get_footer(); ?>