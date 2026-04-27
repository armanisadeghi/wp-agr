<?php
/*
 * Template Name: SST Real Estate Home 2
 */
get_header();
while ( have_posts() ):the_post(); ?>
	<?php
	$post_id = get_the_ID();
	$banners = get_post_meta( $post_id, '_qwl_banner_group', 1 );

	$guide_img     = get_post_meta( $post_id, '_qwl_guide_img', 1 );
	$guide_content = get_post_meta( $post_id, '_qwl_guide_content', 1 );
	$guide_btn_txt = esc_html( get_post_meta( $post_id, '_qwl_guide_btn_txt', 1 ) );
	$guide_url     = esc_url( get_post_meta( $post_id, '_qwl_guide_url', 1 ) );
	$guide_optin   = esc_html( get_post_meta( $post_id, '_qwl_guide_slug', 1 ) );
	?>
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
        <div class="<?php
		if ( '' != $mobile_banner_id ) {
			echo "desktop-only";
		} ?>">
			<?php if ( '' !== $banners ) { ?>
                <div class="slides slick-slider">
					<?php foreach ( $banners as $banner ) { ?>
                        <div>
							<?php if ( '' !== $banner['_qwl_banner_img_id'] ) { ?>
                                <div class="image-container">
									<?php echo wp_get_attachment_image( $banner['_qwl_banner_img_id'], 'full' ); ?>
                                </div>
								<?php if ( array_key_exists( '_qwl_banner_heading', $banner ) && $banner['_qwl_banner_heading'] != ''
								           || array_key_exists( '_qwl_banner_btn_txt', $banner ) && $banner['_qwl_banner_btn_txt'] != ''
								           || array_key_exists( '_qwl_banner_btn_url', $banner ) && $banner['_qwl_banner_btn_url'] != ''
								) { ?>
                                    <div class="holder">
                                        <div class="billboard-content">
                                            <h1><?php echo $banner['_qwl_banner_heading']; ?></h1>

                                            <p><?php echo $banner['_qwl_banner_para']; ?></p>
											<?php if ( array_key_exists( '_qwl_banner_btn_txt', $banner ) || array_key_exists( '_qwl_banner_btn_url', $banner ) ) { ?>
                                                <a href="<?php echo $banner['_qwl_banner_btn_url']; ?>"
                                                   class="button color1 popup"><?php echo $banner['_qwl_banner_btn_txt']; ?></a>
											<?php } ?>
											<?php if ( '' != get_post_meta( $post_id, '_ttm_popup_content', 1 ) ): ?>
                                                <div id="evaluation-form" class="hide">
													<?php echo do_shortcode( get_post_meta( $post_id, '_ttm_popup_content',
														1 ) ); ?>
                                                </div>
											<?php endif; ?>
                                        </div>
                                    </div>
								<?php } ?>
							<?php } ?>
                        </div>
					<?php } ?>
                </div>
			<?php } ?>
        </div>

		<?php if ( '' != $guide_img || '' != $guide_content ): ?>
            <div class="goodie-bar">
                <div class="holder">
					<?php if ( '' != $guide_img ): ?>
                        <div class="image-container">
							<?php echo wp_get_attachment_image( get_post_meta( $post_id, '_qwl_guide_img_id', 1 ),
								'full' ); ?>
                        </div>
					<?php endif; ?>
					<?php if ( '' != $guide_content ): ?>
                        <div class="detail clearfix">
							<?php echo apply_filters( 'the_content', $guide_content ); ?>
							<?php if ( $guide_optin != '' ): ?>
                                <a href="<?php echo $guide_url; ?>"
                                   class="button outline manual-optin-trigger"
                                   data-optin-slug="<?php echo $guide_optin ?>"><?php echo $guide_btn_txt; ?></a>
							<?php else: ?>
                                <a href="<?php echo $guide_url; ?>"
                                   class="button outline" target="_blank"><?php echo $guide_btn_txt; ?></a>
							<?php endif; ?>
                        </div>
					<?php endif; ?>
                </div>
            </div>
		<?php endif; ?>
    </div>
    <!--ends of #billboard-->
	<?php
	$lists = get_post_meta( $post_id, '_homes_listing_group_id', 1 );
	if ( '' !== $lists ): ?>
        <div class="nav-carousel carousel-holder black">
            <div class="container holder">
                <div class="carousel-content">
					<?php foreach ( $lists as $list ) { ?>
                        <div>
							<?php
							if ( '' != $list['_homes_listing_name'] && '' != $list['_homes_listing_link'] ) {
								?>
                                <a href="<?php echo $list['_homes_listing_link']; ?>">
									<?php echo $list['_homes_listing_name']; ?>
                                </a>
								<?php
							} else {
								echo $list['_homes_listing_name'];
							}
							?>
                        </div>
						<?php
					}
					?>
                </div>

            </div>
            <!--ends of .container-->
        </div>
        <!--ends of .content-holder-->
	<?php endif; ?>

	<?php if ( '' != get_post_meta( $post_id, '_qwl_owner_intro_content', 1 ) || '' != get_post_meta( $post_id,
			'_qwl_owner_intro_img', 1 )
	): ?>
        <div class="section imageleft primary intro-section imagefloat">
            <div class="holder">
				<?php if ( '' !== get_post_meta( $post_id, '_qwl_owner_intro_img', 1 ) ): ?>
                    <figure class="img-container">
						<?php echo wp_get_attachment_image( get_post_meta( $post_id, '_qwl_owner_intro_img_id', 1 ),
							'full' ); ?>
                    </figure>
				<?php endif; ?>
                <div
                        class="detail">  <?php echo apply_filters( 'the_content',
						get_post_meta( $post_id, '_qwl_owner_intro_content', 1 ) ); ?></div>
            </div>
            <!--ends of .container-->
        </div>
        <!--ends of .intro-holder-->
	<?php endif; ?>
	<?php if ( '' != get_post_meta( $post_id, '_qwl_coa_content', 1 ) ): ?>
        <div class="page-content calltoaction-section aligncenter padding-5x">
            <div class="holder">
				<?php echo get_post_meta( $post_id, '_qwl_coa_content', 1 ); ?>
            </div>
        </div>
	<?php endif; ?>
    <!--ends of .btn-holder-->
    <div class="featured-listings">
        <div class="holder">
            <h4>Our Featured Listings</h4>
			<?php do_action( 'featured_listing' ); ?>
        </div>
    </div>
    <!--ends of .featured-listings-->
    <div class="recent-listings">
        <div class="holder">
            <h4>Local Listings</h4>
			<?php do_action( 'recent_listing' ); ?>
        </div>
    </div>
    <!--ends of .recent-listings-->
	<?php $topareas = get_post_meta( $post_id, '_top_areas_group_id', 1 );
	if ( '' !== $topareas ): ?>
        <div class="section top-areas">
            <div class="holder">
				<?php if ( '' !== get_post_meta( $post_id, '_top_areas_title', 1 ) ): ?>
                    <h3 class="heading2"><?php echo get_post_meta( $post_id, '_top_areas_title', 1 ); ?></h3>
				<?php endif; ?>
                <ul class="area-content">
					<?php foreach ( $topareas as $toparea ): ?>
                        <li>
							<?php if ( array_key_exists( '_top_area_link',
									$toparea ) && '' != $toparea['_top_area_link']
							): ?>
                                <a href="<?php echo $toparea['_top_area_link']; ?>"
                                   class="area-name"><?php echo $toparea['_top_area_name']; ?></a>
							<?php else: ?>
                                <span class="area-name"><?php echo $toparea['_top_area_name']; ?></span>
							<?php endif; ?>
							<?php if ( array_key_exists( '_top_area_number',
									$toparea ) && '' != $toparea['_top_area_number']
							): ?>
                                <span class="area-code"><?php echo $toparea['_top_area_number']; ?></span>
							<?php endif; ?>
                        </li>
					<?php endforeach; ?>
                </ul>
                <!--ends of .area-content-->
            </div>
            <!--ends of .container-->
        </div>
        <!--ends of .top-areas-->
	<?php endif; ?>
<?php endwhile;
get_footer(); ?>