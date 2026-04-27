<?php
/**
 * Widget for displaying location based on zip code
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

class Location_Search extends WP_Widget {

	protected $widget_slug = 'mok-location-search';

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
			__( 'Location Search', $this->get_widget_slug() ),
			[
				'classname'   => $this->get_widget_slug() . '-class',
				'description' => __( 'Display location based on zip code', $this->get_widget_slug() )
			]
		);

		// Refreshing the widget's cached output with each new post
		add_action( 'save_post', [ $this, 'flush_widget_cache' ] );
		add_action( 'deleted_post', [ $this, 'flush_widget_cache' ] );
		add_action( 'switch_theme', [ $this, 'flush_widget_cache' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_widget_scripts' ], 100 );
		add_action( 'wp_ajax_location_search_zip', [ $this, 'location_search_zip' ] );
		add_action( 'wp_ajax_nopriv_location_search_zip', [ $this, 'location_search_zip' ] );
	} // end constructor


	/**
	 * Return the widget slug.
	 *
	 * @return string
	 */
	public function get_widget_slug() {
		return $this->widget_slug;
	}

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {
		wp_register_script( $this->get_widget_slug() . '-script', get_theme_file_uri( 'framework/widgets/widget-location-search/js/locations.js' ), [ 'jquery' ], false, true );
		wp_localize_script( $this->get_widget_slug() . '-script', 'myAjax', [
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'secret_zip' => wp_create_nonce( 'secret-nonce' )
		] );
		wp_enqueue_script( $this->get_widget_slug() . '-script' );

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

		$widget_string  = $before_widget;
		$location_lists = $this->default_loc_by_zip( $instance['location_number'], $instance['type'] );
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

		$instance['location_title']  = ! empty( $new_instance['location_title'] ) ? strip_tags( trim( $new_instance['location_title'] ) ) : $old_instance['location_title'];
		$instance['location_number'] = ! empty( $new_instance['location_number'] ) ? strip_tags( trim( $new_instance['location_number'] ) ) : $old_instance['location_number'];
		$instance['type']            = ! empty( $new_instance['type'] ) ? (int) trim( $new_instance['type'] ) : $old_instance['type'];

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
				'location_title'  => 'Search location with zip code',
				'location_number' => 5,
				'type'            => 0,
			]
		);

		// Display the admin form
		include plugin_dir_path( __FILE__ ) . 'views/admin.php';

	} // end form

	/**
	 * Ajax search location based on zip code
	 */
	public function location_search_zip() {
		if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) === 'xmlhttprequest' && wp_verify_nonce( $_REQUEST['secret'],
				'secret-nonce' )
		):
			$zip_codes   = (int) strip_tags( $_REQUEST['zip'] );
			$range       = (int) strip_tags( $_REQUEST['range'] );
			$options_all = get_option( $this->option_name );
			$options     = $options_all[ $this->number ];
			$result      = $this->loc_by_zip( $zip_codes, $range, $options['location_number'], $options['type'] );
			if ( ! empty( $result ) ):
				echo json_encode( $result );
			else:
				echo json_encode( [ 'message' => 'error' ] );
			endif;
		else:
			header( 'Location: ' . $_SERVER['HTTP_REFERER'] );
		endif;
		die();
	}

	/**
	 * Returns location based on zip code, range and number of location to return
	 *
	 * @param $zip_codes
	 * @param $range
	 * @param $number
	 * @param $type
	 *
	 * @return string
	 */
	public function loc_by_zip( $zip_codes, $range, $number, $type ) {
		$drop_loc = '';
		//get lat and lng from provided zip code
		$zip       = wp_remote_get( 'https://maps.googleapis.com/maps/api/geocode/json?key=' . MAP_API . "&components=postal_code:$zip_codes|country:US" );
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
		$args      = [
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
		];
		if ( $type != 0 ):
			$args = array_merge( $args, [
				'tax_query' => [
					[
						'taxonomy' => 'type',
						'field'    => 'term_id',
						'terms'    => $type,
					],
				]
			] );
		endif;
		//get data from database
		$query         = new WP_Query( $args );
		$zip_locations = [];
		if ( $query->have_posts() ):

			while ( $query->have_posts() ): $query->the_post();
				$post_id         = get_the_ID();
				$latitude_meta   = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_latitude', 1 ) );
				$longitude_meta  = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_longitude', 1 ) );
				$address         = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address', 1 ) );
				$city            = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_city', 1 ) );
				$state           = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_state', 1 ) );
				$zip             = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_zip', 1 ) );
				$full_address    = implode( ', ', [ $address, $city, $state, $zip ] );
				$zip_locations[] = [
					'distance' => $this->location_distance( $latitude, $longitude, $latitude_meta, $longitude_meta ),
					'title'    => get_the_title(),
					'address'  => $full_address,
					'link'     => get_the_permalink(),
				];
			endwhile;
			wp_reset_postdata();
			if ( count( $zip_locations ) > 0 ):
				foreach ( $zip_locations as $key => $row ) {
					$distance[ $key ] = $row['distance'];
				}
				array_multisort( $distance, SORT_ASC, $zip_locations );
				$zip_locations = array_slice( $zip_locations, 0, $number );
				$drop_loc      .= '<ul class="listing-location-zip" data-hook="listing-location-zip">';
				foreach ( $zip_locations as $location ):
					$drop_loc .= '<li><i class="fa fa-map-marker"></i><a href="' . $location['link'] . '"><h4>' . $location['title'] . '</h4><p>' . esc_html( $location['address'] ) . '<br/>' . ' (' . $location['distance'] . ' miles)</p></a></li>';
				endforeach;
				$drop_loc .= '</ul>';
			else:
				$drop_loc .= "<ul class=\"listing-location-zip\" data-hook=\"listing-location-zip\">No location found within {$range} miles.</ul>";
			endif;
		else:
			$drop_loc .= "<ul class=\"listing-location-zip\" data-hook=\"listing-location-zip\">No location found within {$range} miles.</ul>";
		endif;

		return $drop_loc;
	}

	/**
	 * Returns default location by zip code
	 *
	 * @param $number
	 * @param $type
	 *
	 * @return string
	 */
	public function default_loc_by_zip( $number, $type ) {
		$drop_loc      = '';
		$query         = new WP_Query( [
			'post_type'      => 'location',
			'post_status'    => 'publish',
			'posts_per_page' => $number,
			'meta_query'     => [
				[
					'key'   => '_ttm_business_closed',
					'value' => '1',
				]
			],
			'tax_query'      => [
				[
					'taxonomy' => 'type',
					'field'    => 'term_id',
					'terms'    => $type,
				],
			],
		] );
		$zip_locations = [];
		if ( $query->have_posts() ):

			while ( $query->have_posts() ): $query->the_post();
				$post_id         = get_the_ID();
				$address         = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address', 1 ) );
				$city            = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_city', 1 ) );
				$state           = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_state', 1 ) );
				$zip             = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_zip', 1 ) );
				$full_address    = implode( ', ', [ $address, $city, $state, $zip ] );
				$zip_locations[] = [
					'title'   => get_the_title(),
					'address' => $full_address,
					'link'    => get_the_permalink(),
				];
			endwhile;
			wp_reset_postdata();
			if ( count( $zip_locations ) > 0 ):
				$zip_locations = array_slice( $zip_locations, 0, $number );
				$drop_loc      .= '<ul class="listing-location-zip" data-hook="listing-location-zip" style="display: none">';
				foreach ( $zip_locations as $location ):
					$drop_loc .= '<li><i class="fa fa-map-marker"></i><a href="' . $location['link'] . '"><h4>' . $location['title'] . '</h4><p>' . esc_html( $location['address'] ) . '</p></a></li>';
				endforeach;
				$drop_loc .= '</ul>';
			else:
				$drop_loc .= 'No location found';
			endif;
		endif;

		return $drop_loc;
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
	register_widget( 'Location_Search' );
}
);