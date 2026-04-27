<?php
/*
 * Template Name: SST Landing Page 2
 */

//Fields
$post_id = get_the_ID();
$prefix  = '_ttm';

//Index Section
$index_image_id    = get_post_meta( $post_id, $prefix . '_landing_index_image_id', 1 );
$logo_image_id     = get_post_meta( $post_id, $prefix . '_logo_image_id', 1 );
$index_content     = get_post_meta( $post_id, $prefix . '_index_content', 1 );
$index_button_text = get_post_meta( $post_id, $prefix . '_button_text', 1 );
$index_button_url  = get_post_meta( $post_id, $prefix . '_button_url', 1 );
$slogan_text       = get_post_meta( $post_id, $prefix . '_slogan_text', 1 );

//Procedure Section
$procedure_title         = get_post_meta( $post_id, $prefix . '_landing_procedure_title', 1 );
$procedure_sub_title     = get_post_meta( $post_id, $prefix . '_landing_procedure_sub_title', 1 );
$procedure_main_image_id = get_post_meta( $post_id, $prefix . '_landing_procedure_image_id', 1 );
$procedure_steps         = get_post_meta( $post_id, $prefix . '_procedure_steps_group', 1 );

//Result Section
$result_title              = get_post_meta( $post_id, $prefix . '_landing_result_title', 1 );
$result_sub_title          = get_post_meta( $post_id, $prefix . '_landing_result_sub_title', 1 );
$result_content            = get_post_meta( $post_id, $prefix . '_landing_result_content', 1 );
$result_button_price_text  = get_post_meta( $post_id, $prefix . '_result_button_price_text', 1 );
$result_button_text        = get_post_meta( $post_id, $prefix . '_result_button_text', 1 );
$result_button_url         = get_post_meta( $post_id, $prefix . '_result_button_url', 1 );
$result_schedule_link_text = get_post_meta( $post_id, $prefix . '_result_schedule_link_text', 1 );
$result_schedule_link_url  = get_post_meta( $post_id, $prefix . '_result_schedule_link_url', 1 );
$results                   = get_post_meta( $post_id, $prefix . '_results_group', 1 );

//Testimonial Section
$testimonial_title     = get_post_meta( $post_id, $prefix . '_landing_testimonial_title', 1 );
$testimonial_sub_title = get_post_meta( $post_id, $prefix . '_landing_testimonial_sub_title', 1 );
$testimonial_content   = get_post_meta( $post_id, $prefix . '_landing_testimonial_content', 1 );
$testimonials          = get_post_meta( $post_id, $prefix . '_testimonials_group', 1 );

//About Section
$about_title       = get_post_meta( $post_id, $prefix . '_landing_about_title', 1 );
$about_sub_title   = get_post_meta( $post_id, $prefix . '_landing_about_sub_title', 1 );
$about_image_id    = get_post_meta( $post_id, $prefix . '_landing_about_image_id', 1 );
$about_video       = get_post_meta( $post_id, $prefix . '_landing_about_video', 1 );
$about_content     = get_post_meta( $post_id, $prefix . '_landing_about_content', 1 );
$about_button_text = get_post_meta( $post_id, $prefix . '_about_button_text', 1 );
$about_button_url  = get_post_meta( $post_id, $prefix . '_about_button_url', 1 );
$about_slogan_text = get_post_meta( $post_id, $prefix . '_about_slogan_text', 1 );
$about_logos       = get_post_meta( $post_id, $prefix . '_landing_logo_container', 1 );

//Contact Section
$contact_title    = get_post_meta( $post_id, $prefix . '_landing_contact_title', 1 );
$contact_form_title  = get_post_meta( $post_id, $prefix . '_landing_contact_form_title', 1 );
$contact_image_id = get_post_meta( $post_id, $prefix . '_landing_contact_image_id', 1 );
$contact_content  = get_post_meta( $post_id, $prefix . '_landing_contact_content', 1 );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=no">
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class() ?>>
<header id="page-header" class="section-group" itemscope itemtype="http://schema.org/Organization">
    <div class="row">
		<?php if ( '' != get_theme_mod( 'custom_logo' ) ):
			the_custom_logo();
		endif;
		do_action( 'mok_phone_number' );
		$menu = wp_nav_menu( [
			'theme_location'  => 'main-nav',
			'fallback_cb'     => false,
			'menu_class'      => 'slimmenu',
			'menu_id'         => 'main-nav',
			'container'       => false,
			'container_class' => false,
			'echo'            => false,
		] ); ?>
        <nav class="alignright page-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
			<?php if ( $menu ) {
				echo $menu;
			} ?>
            <div class="site-search">
                <span class="icon-search">
                    O\
                </span>

                <form class="search-box" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input type="text" id="s" class="text-box" placeholder="Search Keyword" name="s" tabindex="1">
                </form>
            </div>
        </nav>
    </div>
</header>
<div id="fluidHeightSections" class="section-group">
	<?php if ( $index_image_id != '' || $index_content != '' ): ?>
        <section class="section landing-section" id="billboard">
            <div class="row">
                <div class="section-large-column bg-color-image">
                    <div class="content-holder overlay-top">
						<?php if ( $logo_image_id != '' ): ?>
                            <div class="logo-holder">
                                <figure>
									<?php echo wp_get_attachment_image( $logo_image_id, 'full' ); ?>
                                </figure>
                            </div>
						<?php endif; ?>
						<?php if ( $index_content != '' ): ?>
                            <div class="content-detail">
								<?php echo $index_content; ?><br/>
								<?php if ( $index_button_text != '' ): ?>
                                    <a href="<?php echo $index_button_url; ?>" class="btn btn-white"
                                       title="<?php echo $index_button_text; ?>"><?php echo $index_button_text; ?></a>
								<?php endif; ?>

								<?php if ( $slogan_text != '' ): ?>
                                    <p class="slogan"><?php echo $slogan_text; ?></p>
								<?php endif; ?>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
				<?php if ( $index_image_id != '' ): ?>
                    <div class="section-small-column">
                        <figure class="banner-image">
							<?php echo wp_get_attachment_image( $index_image_id, 'full' ); ?>
                        </figure>
                    </div>
				<?php endif; ?>
                <a href="#" title="Indicator" class="icon-landing-indicator" onclick="event.preventDefault();">Landing
                    Indicator</a>
            </div>
        </section> <!-- .section1 Ends Here -->
	<?php endif; ?>
	<?php if ( $procedure_title != '' || $procedure_main_image_id != '' ): ?>
        <section class="section bg-light-cyan procedure-section">
            <div class="row">
				<?php if ( $procedure_title != '' || $procedure_sub_title != '' ): ?>
                    <div class="section-title">
                        <h2>
							<?php if ( $procedure_title != '' ): ?>
                                <small><?php echo $procedure_title; ?></small>
							<?php endif; ?>
							<?php echo $procedure_sub_title; ?>
                        </h2>
                    </div>
				<?php endif; ?>
				<?php if ( $procedure_main_image_id != '' ): ?>
                    <figure class="overlay-bottom mobile-static">
						<?php echo wp_get_attachment_image( $procedure_main_image_id, 'full' ); ?>
                    </figure>
				<?php endif; ?>
                <div class="content-holder overlay-block mobile-static">
                    <ul class="detailed-list">
						<?php if ( is_array( $procedure_steps ) || is_object( $procedure_steps ) ): ?>
							<?php foreach ( $procedure_steps as $step ): ?>
                                <li>
									<?php if ( $step['_ttm_image_id'] != '' ): ?>
                                        <figure>
											<?php echo wp_get_attachment_image( $step['_ttm_image_id'], 'full' ); ?>
                                        </figure>
									<?php endif; ?>
                                    <div class="content-detail">
										<?php if ( array_key_exists( '_ttm_title', $step ) ): ?>
                                            <h4><?php echo $step['_ttm_title']; ?></h4>
										<?php endif; ?>
										<?php if ( array_key_exists( '_ttm_description', $step ) ): ?>
                                            <p><?php echo $step['_ttm_description']; ?></p>
										<?php endif; ?>
                                    </div>
                                </li>
							<?php endforeach; ?>
						<?php endif; ?>
                    </ul>
                </div>
            </div>
        </section> <!-- .section2 Ends Here -->
	<?php endif; ?>
    <section class="section results-section">
        <div class="row">
			<?php if ( $result_title != '' || $result_sub_title != '' ): ?>
                <div class="section-title">
                    <h2>
						<?php if ( $result_title != '' ): ?>
                            <small><?php echo $result_title; ?></small>
						<?php endif; ?>
						<?php echo $result_sub_title; ?>
                    </h2>
                </div>
			<?php endif; ?>
            <div class="content-holder two-cols">
                <div class="col">
                    <div class="tab-container has-additional-tab">
                        <div class="toggle-group">
                            <a href="#" title="" class="button toggle-male">Male</a>
                            <a href="#" title="" class="button toggle-female active">Female</a>
                        </div>
                        <div class="resp-tabs-container">
							<?php if ( is_array( $results ) || is_object( $results ) ): ?>
								<?php foreach ( $results as $result ): ?>
                                    <div>
                                        <div class="thumbs-group female">
											<?php $bg_color_class_female_before = ( $result['_ttm_female_before_image_id'] != '' ) ? '' : 'bg-white'; ?>
                                            <div class="image-holder <?php echo $bg_color_class_female_before; ?>">
                                                <figure>
													<?php if ( $result['_ttm_female_before_image_id'] != '' ): ?>
														<?php echo wp_get_attachment_image( $result['_ttm_female_before_image_id'], 'full' ); ?>
													<?php else: ?>
                                                        <img
                                                                src="<?php echo get_template_directory_uri(); ?>/assets/images/female-thumbnail-avatar-canvas-image.png"
                                                                alt="" title="">
													<?php endif; ?>
                                                </figure>
                                                <p><strong>Before</strong></p>
                                            </div>
											<?php $bg_color_class_female_after = ( $result['_ttm_female_after_image_id'] != '' ) ? '' : 'bg-white'; ?>
                                            <div class="image-holder <?php echo $bg_color_class_female_after; ?>">
                                                <figure>
													<?php if ( $result['_ttm_female_after_image_id'] != '' ): ?>
														<?php echo wp_get_attachment_image( $result['_ttm_female_after_image_id'], 'full' ); ?>
													<?php else: ?>
                                                        <img
                                                                src="<?php echo get_template_directory_uri(); ?>/assets/images/female-thumbnail-avatar-canvas-image.png"
                                                                alt="" title="">
													<?php endif; ?>
                                                </figure>
                                                <p>
													<?php if ( array_key_exists( '_ttm_female_after_text', $result ) ): ?>
                                                        <span
                                                                class="duration-text"><?php echo $result['_ttm_female_after_text'] ?>
                                                        </span><?php endif; ?>
                                                    <strong>After </strong></p>
                                            </div>
                                        </div>
                                        <div class="thumbs-group male">
											<?php $bg_color_class_male_before = ( $result['_ttm_male_before_image_id'] != '' ) ? '' : 'bg-white'; ?>

                                            <div class="image-holder <?php echo $bg_color_class_male_before; ?>">
                                                <figure>
													<?php if ( $result['_ttm_male_before_image_id'] != '' ): ?>
														<?php echo wp_get_attachment_image( $result['_ttm_male_before_image_id'], 'full' ); ?>
													<?php else: ?>
                                                        <img
                                                                src="<?php echo get_template_directory_uri(); ?>/assets/images/male-thumbnail-avatar-canvas-image.png"
                                                                alt="" title="">
													<?php endif; ?>
                                                </figure>
                                                <p><strong>Before</strong></p>
                                            </div>
											<?php $bg_color_class_male_after = ( $result['_ttm_male_after_image_id'] != '' ) ? '' : 'bg-white'; ?>
                                            <div class="image-holder <?php echo $bg_color_class_male_after; ?>">
                                                <figure>
													<?php if ( $result['_ttm_male_after_image_id'] != '' ): ?>
														<?php echo wp_get_attachment_image( $result['_ttm_male_after_image_id'], 'full' ); ?>
													<?php else: ?>
                                                        <img
                                                                src="<?php echo get_template_directory_uri(); ?>/assets/images/male-thumbnail-avatar-canvas-image.png"
                                                                alt="" title="">
													<?php endif; ?>
                                                </figure>
                                                <p><?php if ( array_key_exists( '_ttm_male_after_text', $result ) ): ?>
                                                        <span
                                                                class="duration-text"><?php echo $result['_ttm_male_after_text'] ?></span>
													<?php endif; ?>
                                                    <strong>After</strong></p>
                                            </div>
                                        </div>
                                    </div>
								<?php endforeach; ?>
							<?php endif; ?>
                        </div>
                        <ul class="resp-tabs-list">
							<?php if ( is_array( $results ) || is_object( $results ) ): ?>
								<?php foreach ( $results as $result ): ?>
                                    <li>
                                        <div class="icon-image">
                                            <figure>
												<?php echo wp_get_attachment_image( $result['_ttm_menu_icon_image_id'], 'full' ); ?>
                                            </figure>
                                        </div>
                                        <p><?php echo $result['_ttm_menu_text'] ?></p>
                                    </li>
								<?php endforeach; ?>
							<?php endif; ?>
                        </ul>
                    </div>
                </div>
				<?php if ( $result_content != '' || $result_button_text != '' ): ?>
                    <div class="col custom-padding">
                        <div class="content-detail">
							<?php echo $result_content; ?>
							<?php if ( $result_button_text != '' || $result_button_price_text != '' || $result_button_url != '' ): ?>
                                <a href="<?php echo $result_button_url; ?>" class="btn btn-gradient">
                                    <span class="price-holder"><?php echo $result_button_price_text; ?></span>
                                    <span class="text-holder"><?php echo $result_button_text; ?></span>
                                </a>
							<?php endif; ?>
							<?php if ( $result_schedule_link_text != '' || $result_schedule_link_url != '' ): ?>
                                <p>
                                    <a href="<?php echo $result_schedule_link_url; ?>" title=""
                                       class="text-link"><?php echo $result_schedule_link_text; ?></a>
                                </p>
							<?php endif; ?>
                        </div>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </section> <!-- .section3 Ends Here -->
    <section class="section bg-blue fancy-section">
        <div class="inner-wrapper">
            <div class="row">
                <div class="section-title">
					<?php if ( $testimonial_title != '' || $testimonial_sub_title != '' ): ?>
                        <h2>
							<?php if ( $testimonial_title != '' ): ?>
                                <small><?php echo $testimonial_title; ?></small>
							<?php endif; ?>
							<?php echo $testimonial_sub_title; ?>
                        </h2>
					<?php endif; ?>
                </div>
            </div>
            <div class="fancy-content two-cols-custom">
                <div class="col">
                    <div class="slider-holder clearfix">
                        <div class="fancy-carousel current-right">
							<?php if ( is_array( $testimonials ) || is_object( $testimonials ) ): ?>
								<?php foreach ( $testimonials as $testimonial ): ?>
                                    <div>
                                        <div class="content video-content">
											<?php if ( $testimonial['_ttm_testimonial_image_id'] != '' ): ?>
                                                <figure class="toggle-video">
													<?php echo wp_get_attachment_image( $testimonial['_ttm_testimonial_image_id'], 'full' ); ?>
													<?php echo wp_oembed_get( $testimonial['_ttm_testimonial_video'] ); ?>
                                                </figure>
											<?php endif; ?>
											<?php if ( array_key_exists( '_ttm_testimonial_content', $testimonial ) ): ?>
                                                <div class="detail">
													<?php echo $testimonial['_ttm_testimonial_content']; ?>
                                                </div>
											<?php endif; ?>
											<?php if ( array_key_exists( '_ttm_testimonial_time', $testimonial ) ): ?>
                                                <span
                                                        class="time-holder"><?php echo $testimonial['_ttm_testimonial_time']; ?></span>
											<?php endif; ?>
                                        </div>
                                    </div>
								<?php endforeach; ?>
							<?php endif; ?>
                        </div>
                    </div>
                </div>
				<?php if ( $testimonial_content != '' ): ?>
                    <div class="col">
                        <div class="row overlay two-cols">
                            <div class="col"></div>
                            <div class="col">
                                <div class="content-holder">
									<?php echo $testimonial_content; ?>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </section> <!-- .section4 Ends Here -->
    <section class="section medical-section">
        <div class="row">
			<?php if ( $about_title != '' || $about_sub_title != '' ): ?>
                <div class="section-title">
                    <h2>
                        <small><?php echo $about_title; ?></small>
						<?php echo $about_sub_title; ?>
                    </h2>
                </div>
			<?php endif; ?>
            <div class="content-holder direction-row">
				<?php if ( $about_content != '' ): ?>
                    <div class="content-detail">
                        <div class="detail-inner">
							<?php echo $about_content; ?>
                        </div>
                    </div>
				<?php endif; ?>
				<?php if ( $about_image_id != '' ): ?>
                    <div class="image-holder">
                        <?php echo do_shortcode('[vds vds_video_link="'.$about_video.'" vds_image_title="" vds_image_link="'.wp_get_attachment_image_src( $about_image_id, [ 470, 450 ] )[0].'"]'); ?>

						<?php if ( '' != $about_video ): ?>
						<?php else: ?>
                            <figure class="custom-height-450">
								<?php echo wp_get_attachment_image( $about_image_id, 'full' ); ?>
                            </figure>
						<?php endif; ?>
                    </div>
				<?php endif; ?>
                <div class="additional-content">
                    <div class="detail-inner">
						<?php if ( $about_button_text != '' || $about_button_url != '' ): ?>
                            <a href="<?php echo $about_button_url; ?>" title=""
                               class="btn btn-primary"><?php echo $about_button_text; ?></a>
						<?php endif; ?>
						<?php if ( $about_slogan_text != '' ): ?>
                            <p class="slogan"><?php echo $about_slogan_text; ?></p>
						<?php endif; ?>
						<?php if ( $about_logos != '' ): ?>
                            <div class="logo-container">
								<?php echo do_shortcode( $about_logos ); ?>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- .section5 Ends Here -->

    <section class="section bg-light-cyan bottom-section">
        <div class="section-inner">
			<?php if ( $contact_content != '' || $contact_image_id != '' ): ?>
                <div class="row">
                    <div class="section-title">
                        <h2>
							<?php if ( $contact_title != '' ): ?>
                                <small><?php echo $contact_title; ?></small>
							<?php endif; ?>
                        </h2>
                    </div>
                    <div class="content-holder two-cols overlay-bottom">
						<?php if ( $contact_image_id != '' ): ?>
                            <div class="col">
                                <figure>
									<?php echo wp_get_attachment_image( $contact_image_id, 'full' ); ?>
                                </figure>
                            </div>
						<?php endif; ?>
						<?php if ( $contact_content != '' ): ?>
                            <div class="col custom-padding content-inner">
                                <div class="content-detail">
								<?php if ( $contact_form_title != '' ): ?>
								<h3 class="gform_title" style="margin-bottom: 0px !important;padding-bottom: 0px !important"><?php echo $contact_form_title; ?></h3>
									<?php endif; ?>
									<?php echo do_shortcode( $contact_content ); ?>
                                </div>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
			<?php endif; ?>
            <div class="footer">
                <div class="row two-cols">
                    <div class="col">
						<?php dynamic_sidebar( 'footer-bottom' ); ?>
                    </div>
                    <div class="col">
                        <div class="social-links">
							<?php dynamic_sidebar( 'footer-bottom-social-media' ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> <!-- .section6 Ends Here -->
</div>
<?php wp_footer(); ?>
</body>
</html>