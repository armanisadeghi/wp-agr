<?php
/**
 * The template for displaying single location
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.5.1
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
get_header();
while ( have_posts() ): the_post();
	$post_id        = get_the_ID();
	$is_closed      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_closed', 1 ) );
	$address        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address', 1 ) );
	$city           = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_city', 1 ) );
	$state          = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_state', 1 ) );
	$zip            = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_zip', 1 ) );
	$country        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_country', 1 ) );
	$main_phone     = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_main_phone', 1 ) );
	$second_phone   = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_second_phone', 1 ) );
	$fax            = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_fax', 1 ) );
	$email          = sanitize_email( get_post_meta( $post_id, '_ttm_business_email', 1 ) );
	$latitude       = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_latitude', 1 ) );
	$longitude      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_longitude', 1 ) );
	$opening_hours  = get_post_meta( $post_id, '_ttm_business_opening', 1 );
	$banner_title   = get_post_meta( $post_id, '_ttm_banner_title', 1 );
	$banner_buttons = get_post_meta( $post_id, '_ttm_banner_buttons', 1 ); 
	$embed_code = get_post_meta( $post_id, '_ttm_google_embed_code', 1 );  ?>
	<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
    <div class="page-content fullpage" itemscope itemtype="http://schema.org/Organization">
        <div class="contact-container" <?php echo get_post_thumbnail_id() != '' ? 'style="background-image: url(' . get_the_post_thumbnail_url( $post_id, 'full' ) . ');"' : '' ?>>
            <div class="holder">
				<?php
				if ( $banner_title != '' ):
					echo apply_filters( 'the_content', $banner_title );
				else:
					the_title( '<h1 itemprop="name">', '</h1>' );
				endif; ?>
				<?php if ( $is_closed == 0 ): ?>
                    <a href="javascript:void()" class="button white">Closed</a>
				<?php else: ?>
					<?php
					if ( is_array( $banner_buttons ) && array_key_exists( '_ttm_banner_button_label', $banner_buttons[0] ) ):
						foreach ( (array) $banner_buttons as $button ): ?>
                            <a href="<?php echo array_key_exists( '_ttm_banner_button_link', $button ) ? esc_url( $button['_ttm_banner_button_link'] ) : 'javascript:void()'; ?>"
                               class="button white"><?php echo array_key_exists( '_ttm_banner_button_label', $button ) ? $button['_ttm_banner_button_label'] : 'Button'; ?></a>
						<?php endforeach;
					endif; ?>
				<?php endif; ?>
            </div>
        </div>
        <div class="page-content fullpage col3-container meta-info">
            <div class="holder">
                <div class="col">
                    <i class="fa fa-map-marker"></i>
                    <div class="detail" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                        <span itemprop="streetAddress"><?php echo $address; ?></span><br/>
						<?php echo implode( ', ', [
							'<span itemprop="addressLocality">' . $city . '</span>',
							' <span itemprop="addressRegion">' . $state . '</span>',
							'<span itemprop="postalCode">' . $zip . '</span>',
							'<span itemprop="addressCountry">' . $country . '</span>'
						] ); ?>
                    </div>
                </div>
				<?php if ( $main_phone != '' || $second_phone != '' || $fax != '' || $email != '' ): ?>
                    <div class="col">
                        <i class="fa fa-phone"></i>
                        <div class="detail">
							<?php $contact_details = [];
							if ( $main_phone != '' ):
								$contact_details[] = '<a href="tel:' . $main_phone . '"><span itemprop="telephone">' . $main_phone . '</span></a>';
							endif;
							if ( $second_phone != '' ):
								$contact_details[] = '<a href="tel:' . $second_phone . '"><span itemprop="telephone">' . $second_phone . '</span></a>';
							endif;
							if ( $fax != '' ):
								$contact_details[] = '<span class="contact-meta-title">Fax: </span><span itemprop="faxNumber">' . $fax . '</span>';
							endif;
							if ( $email != '' ):
								$contact_details[] = '<span class="contact-meta-title">E-mail:  </span><span itemprop="email"><a href=mailto:"' . antispambot( $email ) . '">' . antispambot( $email ) . '</a></span>';
							endif;
							echo implode( ' ',$contact_details ); ?>
                        </div>
                    </div>
				<?php endif; ?>
				<?php if ( $opening_hours != '' ): ?>
                    <div class="col">
                        <i class="fa fa-clock-o"></i>
                        <div class="detail">
							<?php echo apply_filters( 'the_content', $opening_hours ); ?>
                        </div>
                    </div>
				<?php endif; ?>
            </div>
        </div>
        <div class="page-content fullpage editor-content">
            <div class="holder">
				<?php the_content(); ?>
            </div>
        </div>
       <div class="aligncenter">
		<?php if(!empty($embed_code)){
				echo $embed_code;
		} ?>
        </div>
        <div class="holder">
			<?php if ( is_active_sidebar( 'location-widget' ) ):
				dynamic_sidebar( 'location-widget' );
			endif; ?>
        </div>
    </div>
<?php endwhile;
get_footer(); ?>