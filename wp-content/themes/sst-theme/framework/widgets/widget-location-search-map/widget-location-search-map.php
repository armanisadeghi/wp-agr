<?php
/**
 * Widget for displaying location and search form with map. Only for location archive page.
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

class Widget_Location_Search_Map extends WP_Widget {

	protected $widget_slug = 'widget-location-search-map';

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
			__( 'Location Search along with map', $this->get_widget_slug() ),
			[
				'classname'   => $this->get_widget_slug() . '-class',
				'description' => __( 'Display location and search form with map. Only for location archive page.', $this->get_widget_slug() )
			]
		);

		// Refreshing the widget's cached output with each new post
		add_action( 'save_post', [ $this, 'flush_widget_cache' ] );
		add_action( 'deleted_post', [ $this, 'flush_widget_cache' ] );
		add_action( 'switch_theme', [ $this, 'flush_widget_cache' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_widget_scripts' ], 100 );
		add_action( 'wp_ajax_location_search_detail_zip', [ $this, 'location_search_detail_zip' ] );
		add_action( 'wp_ajax_nopriv_location_search_detail_zip', [ $this, 'location_search_detail_zip' ] );
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
		
		if($_SERVER['REQUEST_URI']=='/location/'){
		$map_api = get_option( 'wpseo_local' )['api_key_browser'];
		//echo "test123".$map_api;
		wp_dequeue_script( 'sst-google-map' );
		wp_dequeue_script( 'sst-load-map' );
		wp_enqueue_script( $this->get_widget_slug() . 'sst-load-map', 'https://maps.googleapis.com/maps/api/js?key=' . $map_api . '&callback=initMap', [ 'sst-theme-js' ], false, true );
		wp_register_script( $this->get_widget_slug() . '-script', get_theme_file_uri( 'framework/widgets/widget-location-search-map/js/locations.js' ), [ 'jquery' ], false, true );
		wp_localize_script( $this->get_widget_slug() . '-script', 'myAjax', [
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'secret_zip' => wp_create_nonce( 'secret-nonce' )
		] );
		wp_enqueue_script( $this->get_widget_slug() . '-script' );
		
		$query         = new WP_Query( [
			'post_type'      => 'location',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		    'tax_query'      => [
				 [
					'taxonomy' => 'type',
					 'field'    => 'term_id',
					 'terms'    => 1760,
				 ],
			],
		] );
	if ( $query->have_posts() ):
		$zip_locations = [];
		while ( $query->have_posts() ): $query->the_post();
			 $post_id        = get_the_ID();
			$latitude_meta  = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_latitude', 1 ) );
			$longitude_meta = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_longitude', 1 ) );
	        $address        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address', 1 ) );
			$city           = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_city', 1 ) );
			$state          = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_state', 1 ) );
			$zip            = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_zip', 1 ) );
			$main_phone     = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_main_phone', 1 ) );
			$country        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_country', 1 ) );
			
			#geocode_address_get
			
			$addrs_str = str_replace(' ', '+', $address);
			$city_str = str_replace(' ', '+', $city);
			$state_str = str_replace(' ', '+', $state);
			$country_str = str_replace(' ', '+', $country);
			//echo $addrs_str;die;
			$addressn       = "$address,$city,$state $zip,$country";
			$addres_str = "$addrs_str,$city_str,$state_str+$zip,$country_str";
			//echo'<pre>';print_r($addres_str);
		

			$theme_options = get_option( 'sst_option' );
			$geocoding_api_key = get_option( 'sst_option' )['google-geocoding-api-key'];
			//echo'<pre>';print_r($geocoding_api_key);die;
			if(!empty($geocoding_api_key)){
				$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?key='.$geocoding_api_key.'&address='.$addres_str.'&sensor=false');
				//echo $geocode;
			}else{
				$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?key=&address='.$addres_str.'&sensor=false');
			}

			$output= json_decode($geocode);
             //echo'<pre>';print_r($output);
			$lat = $output->results[0]->geometry->location->lat;
			$long = $output->results[0]->geometry->location->lng;
			$full_address   = [ $address, $city, $state, $zip ];
		    $title=get_the_title();
			$link= get_the_permalink();
		    $locations[] = [
					 $lat,
					    $long,$title,$link,$main_phone,$full_address
					
			];
			
			//echo'<pre>';print_r($locations);
	   
		endwhile;
			 wp_reset_postdata();
		 $loc=json_encode($locations);
	 $countloc=count($locations);
	endif;
	
	//$path= $_SERVER['DOCUMENT_ROOT'].'/'.'/wp-content/themes/sst-theme/framework/widgets/widget-location-search-map';
	//file_put_contents('test.php', $countloc .'--k' . PHP_EOL, FILE_APPEND);
	
	$scripts = <<<SCRIPTS
    function initMap() {
	var alllocation=$loc;
	var count=$countloc;
	
        if (jQuery('#map').length > 0) {
		 
		   var infowindow = new google.maps.InfoWindow();
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
               center: {lat: 32.81397, lng: -96.78915}
            });
			for (i = 0; i < count; i++) {
			
	  
			var marker = new google.maps.Marker({
          position: new google.maps.LatLng(alllocation[i][0], alllocation[i][1]),
          map: map
        });
		 google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent('<a href='+alllocation[i][3]+'>'+alllocation[i][2]+'<a><br>Phone:'+alllocation[i][4]+'<br>'+alllocation[i][5]);
					        
                    infowindow.open(map, marker);
                }
            })(marker, i));
}
		
    }
    }
	
SCRIPTS;
        
		wp_add_inline_script( 'sst-theme-js', $scripts );
		}
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

	/**
	 * Returns array of location based on zip code and range
	 *
	 * @param $zip_codes
	 * @param $range
	 *
	 * @return array
	 */
	protected function loc_by_zip( $zip_codes, $range ) {
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
		//get data from database
		$query         = new WP_Query( [
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

			]
		] );
		$zip_locations = [];
		if ( $query->have_posts() ):
			while ( $query->have_posts() ): $query->the_post();

				$post_id         = get_the_ID();
				$latitude_meta   = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_latitude', 1 ) );
				$longitude_meta  = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_longitude', 1 ) );
				$main_phone      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_main_phone', 1 ) );
				$address         = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address', 1 ) );
				$city            = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_city', 1 ) );
				$state           = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_state', 1 ) );
				$zip             = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_zip', 1 ) );
				$full_address    = implode( ', ', [ $address, $city, $state, $zip ] );
				$zip_locations[] = [
					'distance' => $this->location_distance( $latitude, $longitude, $latitude_meta, $longitude_meta ),
					'title'    => get_the_title(),
					'address'  => $full_address,
					'phone'    => $main_phone,
					'link'     => get_the_permalink(),
					'lat'      => $latitude_meta,
					'lang'     => $longitude_meta,
				];
			endwhile;
			wp_reset_postdata();
		endif;

		return $zip_locations;
	}

	public function location_search_detail_zip() {
		if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] )
		     && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) === 'xmlhttprequest'
		     && wp_verify_nonce( $_REQUEST['secret'], 'secret-nonce' )
		):
			$zip_codes = (int) strip_tags( $_REQUEST['zip'] );
			$range     = (int) strip_tags( $_REQUEST['range'] );
			$result    = $this->loc_by_zip( $zip_codes, $range );
			if ( count( $result ) > 0 ):
				echo json_encode( $result );
			else:
				echo json_encode( [ 'message' => 'error' ] );
			endif;
		else:
			header( 'Location: ' . $_SERVER['HTTP_REFERER'] );
		endif;
		die();
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
		$widget_string = '';
		ob_start(); ?>
        <div class="location-map" id="location-map">	
            <div id="map" class="map-sec" style="width: 100%;height: 550px;"></div>
	
	    </div>		
			<div class="lsf-main">	
			           <div class="location-search-form">
                <form action="/locations" method="POST" data-hook="zip-detail-search" class="zip-detail-search">
                    <div id="custom-search-input">
                        <div class="input-group">
                            <input type="number" name="search-zip-code" class="search-query form-control"
                                   placeholder="Enter Zip Code" required="">

                            <div class="select-group">
                                Within
                                <select name="search-range" id="search-range">
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
                </form>
                <div class="zip-form-loader" style="display: none">Please wait...</div>
            </div>
			</div>
		<?php
		$widget_string .= ob_get_clean();

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

	} // end form

} // end class

add_action(
	'widgets_init', function() {
	register_widget( 'Widget_Location_Search_Map' );
}
);
