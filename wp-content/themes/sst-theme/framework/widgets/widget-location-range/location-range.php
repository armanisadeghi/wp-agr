<?php
/**
 * Widget for displaying location within given miles with map
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Widget
 * @version 2.0.9
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Location_Range extends WP_Widget {

	protected $widget_slug = 'mok-location-range';

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		parent::__construct(
			$this->get_widget_slug(),
			__( 'Location within given miles', $this->get_widget_slug() ),
			[
				'classname'   => $this->get_widget_slug() . '-class',
				'description' => __( 'Display location within given miles with map', $this->get_widget_slug() )
			]
		);

		// Refreshing the widget's cached output with each new post
		add_action( 'save_post', [ $this, 'flush_widget_cache' ] );
		add_action( 'deleted_post', [ $this, 'flush_widget_cache' ] );
		add_action( 'switch_theme', [ $this, 'flush_widget_cache' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'location_google_map' ], 100 );
	} // end constructor

	/**
	 * loads google map
	 */
	public function location_google_map() {
		if ( is_singular( 'location' ) ):
			global $wp_query;
			$post_id     = $wp_query->post->ID;
			$address     = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address', 1 ) );
			$options_all = get_option( $this->option_name );
			$options     = $this->number !== null ? $options_all[ $this->number ] : [];
			$range       = $options['location_range'];
			$map_api     = get_option( 'wpseo_local' )['api_key_browser'];
			$loc_xml     = $this->drop_off_loc_xml( $address, $range );
			$scripts     = <<<SCRIPTS
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
		endif;
	}

	/**
	 * Return the widget slug.
	 *
	 * @return string
	 */
	public function get_widget_slug() {
		return $this->widget_slug;
	}

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @param array $args The array of form elements
	 * @param array $instance The current instance of the widget
	 *
	 * @return int|void
	 */
	public function widget( $args, $instance ) {

		// Check if there is a cached output
		$cache = wp_cache_get( $this->get_widget_slug(), 'widget' );

		if ( ! is_array( $cache ) ) {
			$cache = [];
		}

		if ( ! isset ( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset ( $cache[ $args['widget_id'] ] ) ) {
			return print $cache[ $args['widget_id'] ];
		}

		extract( $args, EXTR_SKIP );

		$widget_string = $before_widget;
		global $wp_query;
		$post_id        = $wp_query->post->ID;
		$address        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address', 1 ) );
		$location_lists = $this->drop_off_loc( $address, $instance['location_range'] );
		ob_start();
		include plugin_dir_path( __FILE__ ) . 'views/widget.php';
		$widget_string .= ob_get_clean();
		$widget_string .= $after_widget;


		$cache[ $args['widget_id'] ] = $widget_string;

		wp_cache_set( $this->get_widget_slug(), $cache, 'widget' );

		print $widget_string;

	} // end widget


	public function flush_widget_cache() {
		wp_cache_delete( $this->get_widget_slug(), 'widget' );
	}

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array $new_instance The new instance of values to be generated via the update.
	 * @param array $old_instance The previous instance of values before the update.
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['location_title'] = ! empty( $new_instance['location_title'] ) ? strip_tags( trim( $new_instance['location_title'] ) ) : $old_instance['location_title'];
		$instance['location_range'] = ! empty( $new_instance['location_range'] ) ? strip_tags( trim( $new_instance['location_range'] ) ) : $old_instance['location_range'];

		return $instance;

	} // end widget

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array $instance The array of keys and values for the widget.
	 *
	 * @return string|void
	 */
	public function form( $instance ) {

		$instance = wp_parse_args(
			(array) $instance, [
				'location_title' => 'Locations within 10 miles',
				'location_range' => 10,
			]
		);

		// Display the admin form
		include plugin_dir_path( __FILE__ ) . 'views/admin.php';

	} // end form

	/**
	 * Returns drop off location list based on address and range
	 *
	 * @param $address
	 * @param $range
	 *
	 * @return string
	 */
	protected function drop_off_loc( $address, $range ) {
		global $wp_query;
		$address = urlencode( $address );
		//get lat and lng from provided zip code
		$zip       = wp_remote_get( 'https://maps.googleapis.com/maps/api/geocode/json?key=' . MAP_API . "&address=$address&components=country:US" );
		$zip       = json_decode( $zip['body'] );
		$latitude  = $zip->results[0]->geometry->location->lat;
		$longitude = $zip->results[0]->geometry->location->lng;
		//get range
		$drop_loc  = '';
		$lat_range = $range / 69.172;
		$lon_range = abs( $range / ( cos( $latitude ) * 69.172 ) );
		$min_lat   = number_format( $latitude - $lat_range, '4', '.', '' );
		$max_lat   = number_format( $latitude + $lat_range, '4', '.', '' );
		$min_lon   = number_format( $longitude - $lon_range, '4', '.', '' );
		$max_lon   = number_format( $longitude + $lon_range, '4', '.', '' );
		//get data from database
		$query = new WP_Query( [
			'post_type'      => 'location',
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
			'post__not_in'   => [ $wp_query->post->ID ],
			'meta_query'     => [
				'relation' => 'AND',
				[
					'key'   => '_ttm_business_closed',
					'value' => '1',
				],
				[
					'relation' => 'AND',
					[
						'key'     => '_ttm_business_address_latitude',
						'value'   => [ $min_lat, $max_lat ],
						'type'    => 'DECIMAL(10,5)',
						'compare' => 'BETWEEN',
					],
					[
						'key'     => '_ttm_business_address_longitude',
						'value'   => [ $min_lon, $max_lon ],
						'type'    => 'DECIMAL(10,5)',
						'compare' => 'BETWEEN',
					],
				]

			],
		] );
		if ( $query->have_posts() ):
			$zip_locations = [];
			while ( $query->have_posts() ): $query->the_post();
				$post_id        = get_the_ID();
				$latitude_meta  = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_latitude', 1 ) );
				$longitude_meta = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_longitude', 1 ) );
				$distance_diff  = $this->location_distance( $latitude, $longitude, $latitude_meta, $longitude_meta );
				$address        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address', 1 ) );
				$city           = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_city', 1 ) );
				$state          = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_state', 1 ) );
				$zip            = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_zip', 1 ) );
				$main_phone     = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_main_phone', 1 ) );
				$full_address   = [ $address, $city, $state, $zip ];
				if ( $distance_diff <= $range ):
					$zip_locations[] = [
						'distance' => $distance_diff,
						'title'    => get_the_title(),
						'link'     => get_the_permalink(),
						'address'  => implode( ', ', $full_address ),
						'phone'    => $main_phone,
					];
				endif;
			endwhile;
			wp_reset_postdata();
			if ( count( $zip_locations ) > 0 ):
				foreach ( $zip_locations as $key => $row ) {
					$distance[ $key ] = $row['distance'];
				}
				array_multisort( $distance, SORT_ASC, $zip_locations );
				$drop_loc .= '<ul class="listing-location" data-hook="listing-location">';
				foreach ( $zip_locations as $location ):
					$drop_loc .= '<li><i class="fa fa-map-marker"></i><a href="' . $location['link'] . '"><h4>' . $location['title'] . '</h4><p>' . esc_html( $location['address'] ) . ' (' . $location['distance'] . ' miles) . <br/><b>Phone: </b>' . $location['phone'] . '</p></a></li>';
				endforeach;
				$drop_loc .= '</ul>';
			else:
				$drop_loc .= "No location found within {$range} miles.";
			endif;
		endif;

		return $drop_loc;
	}

	/**
	 * Returns drop off location list based on address and range in xml format
	 *
	 * @param $address
	 * @param $range
	 *
	 * @return string
	 */
	protected function drop_off_loc_xml( $address, $range ) {
		$address = urlencode( $address );
		//get lat and lng from provided zip code
		$zip       = wp_remote_get( 'https://maps.googleapis.com/maps/api/geocode/json?key=' . MAP_API . "&address=$address&components=country:US" );
		$zip       = json_decode( $zip['body'] );
		$latitude  = $zip->results[0]->geometry->location->lat;
		$longitude = $zip->results[0]->geometry->location->lng;
		//get range
		$lat_range = $range / 69.172;
		$lon_range = abs( $range / ( cos( $latitude ) * 69.172 ) );
		$min_lat   = number_format( $latitude - $lat_range, '4', '.', '' );
		$max_lat   = number_format( $latitude + $lat_range, '4', '.', '' );
		$min_lon   = number_format( $longitude - $lon_range, '4', '.', '' );
		$max_lon   = number_format( $longitude + $lon_range, '4', '.', '' );
		$xml       = '';
		//get data from database
		$query = new WP_Query( [
			'post_type'      => 'location',
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
			'meta_query'     => [
				'relation' => 'AND',
				[
					'key'   => '_ttm_business_closed',
					'value' => '1',
				],
				[
					'relation' => 'AND',
					[
						'key'     => '_ttm_business_address_latitude',
						'value'   => [ $min_lat, $max_lat ],
						'type'    => 'DECIMAL(10,5)',
						'compare' => 'BETWEEN',
					],
					[
						'key'     => '_ttm_business_address_longitude',
						'value'   => [ $min_lon, $max_lon ],
						'type'    => 'DECIMAL(10,5)',
						'compare' => 'BETWEEN',
					],
				]

			],
		] );
		if ( $query->have_posts() ):
			while ( $query->have_posts() ): $query->the_post();
				$post_id        = get_the_ID();
				$latitude_meta  = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_latitude', 1 ) );
				$longitude_meta = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_longitude', 1 ) );
				$distance_diff  = $this->location_distance( $latitude, $longitude, $latitude_meta, $longitude_meta );
				$address        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address', 1 ) );
				$city           = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_city', 1 ) );
				$state          = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_state', 1 ) );
				$zip            = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_zip', 1 ) );
				$main_phone     = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_main_phone', 1 ) );
				$full_address   = [ $address, $city, $state, $zip ];
				$xml            .= '<?xml version="1.0"?><markers>';
				if ( $distance_diff <= $range ):
					$xml .= '<marker>';
					$xml .= '<name>' . esc_html( get_the_title() ) . '</name>';
					$xml .= '<site>' . (string) get_the_permalink() . '</site>';
					$xml .= '<address>' . urlencode( implode( ', ', $full_address ) ) . '</address>';
					$xml .= '<phone>' . esc_html( $main_phone ) . '</phone>';
					$xml .= '<lat>' . $latitude_meta . '</lat>';
					$xml .= '<lng>' . $longitude_meta . '</lng>';
					$xml .= '</marker>';
				endif;
				$xml .= '</markers>';
			endwhile;
			wp_reset_postdata();
		endif;

		return $xml;
	}

	/**
	 * Return distance between two locations based on latitude and longitude
	 *
	 * @param $lat1
	 * @param $lon1
	 * @param $lat2
	 * @param $lon2
	 *
	 * @return float
	 */
	protected function location_distance( $lat1, $lon1, $lat2, $lon2 ) {
		$lat1 = deg2rad( $lat1 );
		$lon1 = deg2rad( $lon1 );
		$lat2 = deg2rad( $lat2 );
		$lon2 = deg2rad( $lon2 );

		// Find the deltas
		$delta_lat = $lat2 - $lat1;
		$delta_lon = $lon2 - $lon1;

		// Find the Great Circle distance
		$temp     = ( sin( $delta_lat / 2.0 ) ** 2 ) + cos( $lat1 ) * cos( $lat2 ) * ( sin( $delta_lon / 2.0 ) ** 2 );
		$distance = 3956 * 2 * atan2( sqrt( $temp ), sqrt( 1 - $temp ) );

		return round( $distance, 2 );
	}
} // end class

add_action(
	'widgets_init', function() {
	register_widget( 'Location_Range' );
}
);
