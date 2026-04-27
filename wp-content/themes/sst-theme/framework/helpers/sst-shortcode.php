<?php
/**
 * List of all custom shortcodes used
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Framework
 * @version 2.0.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

if ( ! function_exists( 'mok_content_slide' ) ) {
	/**
	 * Returns content slide show fields
	 * @return string
	 */
	function mok_content_slide() {
		$slide_id    = get_the_ID();
		$image_id    = (int) get_post_meta( $slide_id, '_qwl_info_slide_image_id', 1 );
		$image_path  = wp_get_attachment_image( $image_id, 'medium' );
		$button_name = esc_html( get_post_meta( $slide_id, '_qwl_info_slide_title', 1 ) );
		$slide_path  = esc_url( get_post_meta( $slide_id, '_qwl_info_slide_link', 1 ) );
		$shortcode   = trim( get_post_meta( $slide_id, '_qwl_slideshare_shortcode', 1 ) );
		$path        = wp_oembed_get( $slide_path, [ 'width' => 700, 'height' => 550 ] );
		$content     = '';
		if ( $shortcode != '' ):
			$slider  = do_shortcode( $shortcode );
			$content .= <<<SLIDE
<div class="assets-container">
    <a href="#slideshow" class="popup">{$image_path}
        <div class="overlay-content">
            <div class="detail">
                <span class="icon-popup"></span>
                <span>{$button_name}</span>
            </div>
        </div>
    </a>
</div>
<div id="slideshow" style="display: none;width:1400px;max-width: 100%;height: auto;">$slider</div>
SLIDE;
		else:
			$content .= <<<SLIDE
<div class="assets-container">
    <a href="#slideshow" class="popup">{$image_path}
        <div class="overlay-content">
            <div class="detail">
                <span class="icon-popup"></span>
                <span>{$button_name}</span>
            </div>
        </div>
    </a>
</div>
<div id="slideshow" style="display: none;">{$path}</div>
SLIDE;
		endif;

		return $content;
	}
}
add_shortcode( 'slide', 'mok_content_slide' );

if ( ! function_exists( 'mok_content_infographics' ) ) {
	/**
	 * Returns content from infographics field
	 * @return string
	 */
	function mok_content_infographics() {
		$image_id             = (int) get_post_meta( get_the_ID(), '_qwl_info_graphic_image_id', 1 );
		$path                 = esc_url( get_post_meta( get_the_ID(), '_qwl_info_graphic_image', 1 ) );
		$button_name          = esc_html( get_post_meta( get_the_ID(), '_qwl_info_graphic_title', 1 ) );
		$image_list           = get_post_meta( get_the_ID(), '_qwl_info_graphic_image_list', 1 );
		$info_image_list      = '';
		$revolutionary_slider = get_post_meta( get_the_ID(), '_qwl_info_graphic_revolutionary_slider_short_code', 1 );
		if ( is_page_template( 'templates/template-sst_home_fancy.php' ) ) {
			$image_path = wp_get_attachment_image( $image_id, 'full' );
		} else {
			$image_path = wp_get_attachment_image( $image_id, 'medium' );
		}
		$is_revolution_slider = 0;
		if ( strlen( $revolutionary_slider ) > 0 ) {
			$is_revolution_slider = 1;
		} else {
			if ( $image_list != '' ) {
				foreach ( $image_list as $info_image_id => $info_image_url ) {
					$info_image_list .= wp_get_attachment_image( $info_image_id, 'full' );
				}
			}
		}
		if ( is_page_template( [
				'templates/template-sst_home1.php',
				'templates/template-sst_home.php',
				'templates/template-sst_home_je.php',
				'templates/template-sst_home_fancy-2.php'
			] ) && $is_revolution_slider == 1
		) {
			$rev_slider = do_shortcode( $revolutionary_slider );
			$content    = <<<INFOGRAPHICS
<div class="assets-container">
	<a class="popup" href="#infograph-list">
        {$image_path}
        <div class="overlay-content">
            <div class="detail">
                <span class="icon-popup"></span>
                <span>View Infographic</span>
            </div>
        </div>
    </a>
    <div id="infograph-list" style="width:1400px;max-width: 100%;height: auto;">
        {$rev_slider}
    </div>
</div>
INFOGRAPHICS;

		} elseif ( ( is_page_template( [
					'templates/template-sst_home.php',
					'templates/template-sst_home_rev_slider.php',
					'templates/template-sst_home1.php'
				] ) && $is_revolution_slider == 0 ) || is_singular( 'podcast' )
		) {
			$content = <<<INFOGRAPHICS
<div class="assets-container">
    <a class="popup" href="#infograph-list">
        {$image_path}
        <div class="overlay-content">
            <div class="detail">
                <span class="icon-popup"></span>
                <span>{$button_name}</span>
            </div>
        </div>
    </a>
    <div id="infograph-list">
    {$info_image_list}
    </div>
</div>
INFOGRAPHICS;
		} else {
			$content = <<<INFOGRAPHICS
<div class="assets-container">
    <a class="popup" href="{$path}">
        {$image_path}
        <div class="overlay-content">
            <div class="detail">
                <span class="icon-popup"></span>
                <span>{$button_name}</span>
            </div>
        </div>
    </a>
</div>
INFOGRAPHICS;
		}

		return $content;
	}
}
add_shortcode( 'infographic', 'mok_content_infographics' );

if ( ! function_exists( 'mok_google_map' ) ) {
	/**
	 * Returns iframe for google map
	 * @return string
	 */
	function mok_google_map() {
		global $post;
		ob_start();
		if ( '' != get_post_meta( $post->ID, '_qwl_contact_map', 1 ) ): ?>
            <div class="google-map-box">
                <iframe src="<?php echo get_post_meta( $post->ID, '_qwl_contact_map', 1 ); ?>" frameborder="0"
                        width="100%" height="350"></iframe>
            </div>
		<?php endif;

		return ob_get_clean();
	}
}
add_shortcode( 'google-map', 'mok_google_map' );

if ( ! function_exists( 'mok_contact_info' ) ) {
	/**
	 * Returns contact information
	 * @return string
	 */
	function mok_contact_info() {
		global $post;
		ob_start(); ?>
        <div class="contact-info">
			<?php for ( $i = 1; $i <= 3; $i ++ ): ?>
                <div class="contact-box">
                    <div class="title">
						<?php if ( '' != get_post_meta( $post->ID, '_qwl_contact_info' . $i . '_icon', 1 ) ): ?>
							<?php echo wp_get_attachment_image( get_post_meta( $post->ID,
								'_qwl_contact_info' . $i . '_icon_id', 1 ) ); ?>
						<?php endif; ?>
						<?php if ( '' != get_post_meta( $post->ID, '_qwl_contact_info' . $i . '_title', 1 ) ): ?>
                            <h3><?php echo get_post_meta( $post->ID, '_qwl_contact_info' . $i . '_title', 1 ); ?></h3>
						<?php endif; ?>
                    </div>
                    <p><?php echo nl2br( get_post_meta( $post->ID, '_qwl_contact_info' . $i . '_content', 1 ) ); ?></p>
                </div>
                <!-- /.contact-box -->
			<?php endfor; ?>
        </div>
		<?php return ob_get_clean();
	}
}
add_shortcode( 'contact-info', 'mok_contact_info' );

if ( ! function_exists( 'mok_button_fancy' ) ) {
	/**
	 * Returns fancy button for HTML link
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	function mok_button_fancy( $atts ) {
		$atts = shortcode_atts(
			[
				'href'            => '#',
				'title'           => '',
				'class'           => '',
				'data-optin-slug' => '',
				'content'         => 'Read More'
			], $atts, 'fbtn' );

		return '<a href="' . $atts['href'] . '"' . 'title="' . $atts['title'] . '" class="fancy-button ' . $atts['class'] . '" data-optin-slug="' . $atts['data-optin-slug'] . '"> ' . '<i></i>' . $atts['content'] . '</a > ';
	}
}
add_shortcode( 'fancybutton', 'mok_button_fancy' );

if ( ! function_exists( 'mok_services_lists' ) ) {
	/**
	 * Returns content for service list
	 * @return string
	 */
	function mok_services_lists() {
		ob_start();
		$page              = get_page_by_path( 'services' );
		$services_page_id  = $page->ID;
		if ( $page->post_status == 'publish' ):
			$services = get_post_meta( $services_page_id, '_ttm_thank_you_services_group', 1 );
			$service_title = wp_strip_all_tags( get_post_meta( $services_page_id, '_ttm_service_title', 1 ) );
			if ( $services != '' && is_array( $services ) && array_key_exists( '_ttm_thank_you_service_title', $services[0] ) ): ?>
                <div class="wrapper services-container">
                    <div class="holder">
						<?php if ( $service_title != '' ): ?>
                            <h2 class="services-title"><?php echo $service_title; ?></h2>
						<?php endif; ?>
                        <div class="services-list">
							<?php
							$count = 1;
							foreach ( $services as $service ): ?>
								<?php if ( $count % 2 == 1 ) : ?>
                                    <div class="service-row">
								<?php endif; ?>
                                <div class="item">
                                    <figure>
                                        <a href="<?php echo $service['_ttm_thank_you_service_link_url']; ?>">
											<?php echo wp_get_attachment_image( $service['_ttm_thank_you_service_img_id'], [
												315,
												185
											] ); ?>
                                        </a>
                                    </figure>
                                    <div class="content">
                                        <div class="detail">
                                            <h3>
                                                <a href="<?php echo $service['_ttm_thank_you_service_link_url']; ?>">
													<?php echo $service['_ttm_thank_you_service_title']; ?>
                                                </a>
                                            </h3>
                                            <a href="<?php echo $service['_ttm_thank_you_service_link_url']; ?>">
												<?php echo $service['_ttm_thank_you_service_link_txt']; ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
								<?php if ( $count % 2 == 0 ): ?>
                                    </div>
								<?php endif; ?>
								<?php $count ++; endforeach; ?>
                        </div>
                    </div>
                </div>
				<?php
			endif;
		endif;
		$content = ob_get_clean();

		return $content;
	}
}
add_shortcode( 'services', 'mok_services_lists' );

if ( ! function_exists( 'mok_slideshare_shortcode' ) ) {
	/**
	 * Returns content for slideshare
	 *
	 * @param $atts
	 *
	 * @return bool|string
	 */
	function mok_slideshare_shortcode( $atts ) {
		if ( isset( $atts ) ) {
			global $content_width;
			$width = $content_width;

			$args = str_replace( [ '&#038;', '&amp;' ], '&', $atts['id'] );
			$r    = wp_parse_args( 'id=' . $args );


			return mok_slideshare_embed( $r['id'], $width );
		}

		return false;
	}
}
add_shortcode( 'slideshare', 'mok_slideshare_shortcode' );

if ( ! function_exists( 'mok_dropoff_location_shortcode' ) ) {
	/**
	 * Returns map with markers
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	function mok_dropoff_location_shortcode( $atts ) {
		$atts    = shortcode_atts(
			[
				'address' => 'irvine',
				'range'   => '10',
			],
			$atts
		);
		$address = $atts['address'];
		$range   = $atts['range'];
		$map_api = get_option( 'wpseo_local' )['api_key_browser'];
		$loc_xml = mok_drop_off_loc_xml( $address, $range );
		$scripts = <<<SCRIPTS
		function urldecode(str) {
            return decodeURIComponent((str+'').replace(/\+/g, '%20'));
		}
		jQuery(document).ready(function () {
			var myLatLng = new google.maps.LatLng(40, -100);
			MYMAP.init('#map', myLatLng, 3);

			MYMAP.placeMarkers('{$loc_xml}');
		});
		var MYMAP = {
			map: null,
			bounds: null
		};
		MYMAP.init = function (selector, latLng, zoom) {
			var myOptions = {
				zoom: zoom,
				center: latLng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			this.map = new google.maps.Map(jQuery(selector)[0], myOptions);
			this.bounds = new google.maps.LatLngBounds();
		};

		MYMAP.placeMarkers = function (xml) {
			jQuery(xml).find("marker").each(function () {
				var that = jQuery(this),
					name = that.find('name').text(),
					phone = that.find('phone').text(),
					address = urldecode(that.find('address').text()),
					link = that.find('site').text(),
					lat = that.find('lat').text(),
					lng = that.find('lng').text(),
					point = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
				MYMAP.bounds.extend(point);
				var marker = new google.maps.Marker({
						position: point,
						map: MYMAP.map
					}),
					infoWindow = new google.maps.InfoWindow(),
					html = '<p><strong>' + name + '</strong></p>';
				if (phone != '') {
					html += '<p>Phone: ' + phone + '</p>';
				}
				html += '<p>Address: ' + address + '</p>';
				if (link != '') {
					html += '<p><a href="' + link + '">More Details</a></p>';
				}
				google.maps.event.addListener(marker, 'click', function () {
					infoWindow.setContent(html);
					infoWindow.open(MYMAP.map, marker);
				});
				MYMAP.map.fitBounds(MYMAP.bounds);
			});
		}
SCRIPTS;
		wp_enqueue_script( 'sst-google-map', 'https://maps.googleapis.com/maps/api/js?key=' . $map_api, [ 'sst-theme-js' ], false, true );
		wp_add_inline_script( 'sst-google-map', $scripts );

		return mok_drop_off_loc( $address, $range );
	}
}
add_shortcode( 'dropoff_location', 'mok_dropoff_location_shortcode' );

if ( ! function_exists( 'mok_dropoff_search_bar_shortcode' ) ) {
	/**
	 * Returns drop off location search bar
	 * @return string
	 */
	function mok_dropoff_search_bar_shortcode() {
		$zip_code   = array_key_exists( 'dropoff-search-zip-code', $_GET ) != '' ? strip_tags( $_GET['dropoff-search-zip-code'] ) : '';
		$search_bar = '<form action="' . home_url( 'drop-off' ) . '" method="GET" class="dropoff-zip-search">
        <div id="custom-dropoff-search-input">
            <div class="input-group">
                <input type="number" name="dropoff-search-zip-code" class="dropoff-search-query form-control" placeholder="Enter Zip Code" value="' . $zip_code . '" required/>

                <div class="select-group">
                    Within
                    <select name="dropoff-search-range" id="dropoff-search-range">
                        <option value="25">25 miles</option>
                        <option value="100">100 miles</option>
                        <option value="200">200 miles</option>
                    </select>
                </div>
                <span class="input-group-btn">
                    <button class="button primary" type="submit">
                        Search
                    </button>
                </span>
            </div>
        </div>
    </form>';

		return $search_bar;
	}
}
add_shortcode( 'dropoff_location_search', 'mok_dropoff_search_bar_shortcode' );