<?php
/*
 * Template Name: SST Real Estate Home
 */
get_header();
while ( have_posts() ): the_post(); ?>
    <div id="main">
		<?php
		$post_id            = get_the_ID();
		$banner_img         = get_post_meta( $post_id, '_qwl_estate_banner_img', 1 );
		$banner_content     = get_post_meta( $post_id, '_qwl_estate_banner_content', 1 );
		$banner_button_text = esc_html( get_post_meta( $post_id, '_qwl_estate_banner_btn_txt', 1 ) );
		$banner_button_url  = esc_url( get_post_meta( $post_id, '_qwl_estate_banner_btn_url', 1 ) );

		$guide_img     = get_post_meta( $post_id, '_qwl_guide_img', 1 );
		$guide_content = get_post_meta( $post_id, '_qwl_guide_content', 1 );
		$guide_btn_txt = esc_html( get_post_meta( $post_id, '_qwl_guide_btn_txt', 1 ) );
		$guide_url     = esc_url( get_post_meta( $post_id, '_qwl_guide_url', 1 ) );
		$guide_optin   = esc_html( get_post_meta( $post_id, '_qwl_guide_slug', 1 ) );
		?>
        <div class="billboard">
			<?php if ( '' !== $banner_img ): ?>
                <div class="img-container">
                    <img width="1280" height="465" src="<?php echo $banner_img; ?>"
                         class="attachment-full" alt=""/>
                </div>

				<?php if ( '' !== $banner_content || '' !== $banner_button_text || '' !== $banner_button_url ): ?>
                    <div class="billboard-txt">
						<?php echo wpautop( $banner_content ); ?>
                        <a href="<?php echo $banner_button_url; ?>"
                           class="button primary"><?php echo $banner_button_text; ?></a>
                    </div>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ( '' != $guide_img || '' != $guide_content ): ?>
                <div class="billboard-overlay">
                    <div class="container">
                        <div class="overlay-content">
                            <div class="container holder">
								<?php if ( '' != $guide_img ): ?>
                                    <figure class="sell-thumbnail">
										<?php echo wp_get_attachment_image( get_post_meta( $post_id, '_qwl_guide_img_id', 1 ), 'full' ); ?>
                                    </figure>
								<?php endif; ?>
								<?php if ( '' != $guide_content ): ?>
                                    <div class="detail col-sm-9 col-md-8">
										<?php echo wpautop( $guide_content ); ?>
                                    </div>
								<?php endif; ?>
								<?php if ( '' != $guide_btn_txt ): ?>
									<?php if ( $guide_optin != '' ): ?>
                                        <a href="<?php echo $guide_url; ?>"
                                           class="button outline manual-optin-trigger"
                                           data-optin-slug="<?php echo $guide_optin ?>"><?php echo $guide_btn_txt; ?></a>
									<?php else: ?>
                                        <a href="<?php echo $guide_url; ?>"
                                           class="button outline" target="_blank"><?php echo $guide_btn_txt; ?></a>
									<?php endif; ?>
								<?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!--ends of .container-->
                </div>
                <!--ends of .billboard-overlay-->
			<?php endif; ?>
        </div>
        <!--ends of #billboard-->
		<?php if ( '' !== get_post_meta( $post_id, '_qwl_homes_listing_content', 1 ) ): ?>
            <div class="nav-carousel carousel-holder">
                <div class="container holder">
					<?php echo get_post_meta( $post_id, '_qwl_homes_listing_content', 1 ); ?>
                </div>
                <!--ends of .container-->
            </div>
            <!--ends of .content-holder-->
		<?php endif; ?>

		<?php
		$lists = get_post_meta( $post_id, '_homes_listing_group_id', 1 );
		if ( '' !== $lists ): ?>
            <div class="nav-carousel carousel-holder">
                <div class="container holder">
                    <div class="carousel-content">
						<?php foreach ( $lists as $list ): ?>
                            <div>
								<?php if ( '' != $list['_homes_listing_name'] && '' != $list['_homes_listing_link'] ): ?>
                                    <a href="<?php echo $list['_homes_listing_link']; ?>">
										<?php echo $list['_homes_listing_name']; ?>
                                    </a>
								<?php else:
									echo $list['_homes_listing_name'];
								endif; ?>
                            </div>
						<?php endforeach; ?>
                    </div>

                </div>
                <!--ends of .container-->
            </div>
            <!--ends of .content-holder-->
		<?php endif; ?>

		<?php if ( '' != get_post_meta( $post_id, '_qwl_owner_intro_content', 1 ) || '' != get_post_meta( $post_id,
				'_qwl_owner_intro_img', 1 )
		): ?>
            <div class="page-content dark-theme intro-holder owner-intro bordered-title padding-6x">
                <div class="holder">
					<?php if ( '' !== get_post_meta( $post_id, '_qwl_owner_intro_img', 1 ) ): ?>
                        <figure class="custom-width">
							<?php echo wp_get_attachment_image( get_post_meta( $post_id, '_qwl_owner_intro_img_id',
								1 ), 'full' ); ?>
                        </figure>
					<?php endif; ?>
                    <div class="detail">
                        <?php echo apply_filters( 'the_content', get_post_meta( $post_id, '_qwl_owner_intro_content', 1 ) ); ?>
                    </div>
                </div>
                <!--ends of .container-->
            </div>
            <!--ends of .intro-holder-->
		<?php endif; ?>
		<?php if ( '' != get_post_meta( $post_id, '_qwl_coa_content', 1 ) ): ?>
            <div class="page-content calltoaction-section text-center padding-5x">
                <div class="holder">
					<?php echo get_post_meta( $post_id, '_qwl_coa_content', 1 ); ?>
                </div>
            </div>
		<?php endif; ?>
        <!--ends of .btn-holder-->


        <div class="featured-listings">
            <div class="holder">
                <h3>Our Featured Listings</h3>
				<?php do_action( 'featured_listing' ); ?>
            </div>
        </div>
        <!--ends of .featured-listings-->
        <div class="recent-listings">
            <div class="holder">
                <h3>Local Listings</h3>
				<?php do_action( 'recent_listing' ); ?>
            </div>
        </div>
        <!--ends of .recent-listings-->

		<?php $topareas = get_post_meta( $post_id, '_top_areas_group_id', 1 );
		if ( '' !== $topareas ): ?>
            <div class="page-content grey-theme top-areas bordered-title">
                <div class="container holder">
                    <div class="content">
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
											$topareas ) || '' != $toparea['_top_area_number']
									): ?>
                                        <span class="area-code"><?php echo $toparea['_top_area_number']; ?></span>
									<?php endif; ?>
                                </li>
							<?php endforeach; ?>
                        </ul>
                        <!--ends of .area-content-->
                    </div>
                    <!--ends of .content-->
                </div>
                <!--ends of .container-->
            </div>
            <!--ends of .top-areas-->
		<?php endif; ?>
		<?php if ( '' != get_post_meta( $post_id, '_qwl_section5_content', 1 ) || '' != get_post_meta( $post_id,
				'_qwl_section5_img', 1 )
		): ?>
            <div class="page-content primary-theme van-ad-section">
                <div class="holder">
					<?php if ( '' != get_post_meta( $post_id, '_qwl_section5_img', 1 ) ): ?>
                        <figure class="left">
							<?php echo wp_get_attachment_image( get_post_meta( $post_id, '_qwl_section5_img_id', 1 ),
								'full' ); ?>
                        </figure>
					<?php endif; ?>
					<?php if ( '' != get_post_meta( $post_id, '_qwl_section5_content', 1 ) ): ?>
                        <div class="detail">
							<?php echo apply_filters( 'the_content',
								get_post_meta( $post_id, '_qwl_section5_content', 1 ) ); ?>
                        </div>
					<?php endif; ?>
                </div>
                <!--ends of .container-->
            </div>
            <!--ends of .strip-para-->
		<?php endif; ?>


        <div class="page-content light-theme padding-5x col3-section text-center equal-height">
            <div class="holder">
				<?php for ( $i = 1; $i <= 3; $i ++ ): ?>
                    <div class="item">
						<?php if ( '' !== get_post_meta( $post_id, '_qwl_three_column1_column' . $i . '_img', 1 ) ): ?>
                            <figure>
								<?php echo wp_get_attachment_image( get_post_meta( $post_id,
									'_qwl_three_column1_column' . $i . '_img_id', 1 ), [ 65, 65 ] ); ?>
                            </figure>
						<?php endif; ?>
						<?php if ( '' !== get_post_meta( $post_id, '_qwl_three_column1_column' . $i . '_content',
								1 )
						): ?>
                            <div class="detail">
								<?php echo apply_filters( 'the_content',
									get_post_meta( $post_id, '_qwl_three_column1_column' . $i . '_content', 1 ) ); ?>
                            </div>
						<?php endif; ?>
                    </div>
				<?php endfor; ?>
            </div>
        </div>
        <!--ends of .col3-section -->
		<?php if ( '' != get_post_meta( $post_id, '_qwl_section6_content', 1 ) ): ?>
            <div class="page-content padding-4x grey-theme bordered-title trusted-agent">
                <div class="holder">
					<?php echo apply_filters( 'the_content', get_post_meta( $post_id, '_qwl_section6_content', 1 ) ); ?>
                </div>
            </div>
		<?php endif; ?>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>