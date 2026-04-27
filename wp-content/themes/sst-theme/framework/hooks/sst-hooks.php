<?php
/**
 * List of all custom hooks used
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Framework
 * @version 2.0.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

/**
 * Handler for getting custom field data.
 *
 * @since 0.1.0
 *
 * @param array $object The object from the response
 * @param string $field_name Name of field
 * @param WP_REST_Request $request Current request
 *
 * @return mixed
 */
function mok_get_event_date( $object, $field_name, $request ) {
	return get_post_meta( $object['id'], '_ttm_event_date' );
}

/**
 * Add the field "event date" to REST API responses for posts read
 */
function mok_slug_register_spaceship() {
	register_rest_field( 'our-events',
		'event_date',
		[
			'get_callback'    => 'mok_get_event_date',
			'update_callback' => null,
			'schema'          => null,
		]
	);
}

add_action( 'rest_api_init', 'mok_slug_register_spaceship' );

/**
 * Displays analytics from theme options before </head> tag
 */
function mok_head_analytics() {
	$sst_options = get_option( 'sst_option' );
	echo is_array( $sst_options ) && array_key_exists( 'analytics-general-head', $sst_options ) && $sst_options['analytics-general-head'] != '' ? $sst_options['analytics-general-head'] : '';
}

add_action( 'wp_head', 'mok_head_analytics', 999 );

/**
 * Displays analytics from theme options before </body> tag
 */
function mok_footer_analytics() {
	$sst_options = get_option( 'sst_option' );
	echo is_array( $sst_options ) && array_key_exists( 'analytics-general-footer', $sst_options ) && $sst_options['analytics-general-footer'] != '' ? $sst_options['analytics-general-footer'] : '';
}

add_action( 'wp_footer', 'mok_footer_analytics', 999 );

/**
 * Get phone number from theme option or from post meta field to display on top of the page
 */
function mok_phone_number() {
	global $wp_query;
	$general_options = get_option( 'sst_option' );
	$phone_number    = is_array( $general_options )
	                   && array_key_exists( 'web-general-phone', $general_options )
	                   && $general_options['web-general-phone'] != '' ? $general_options['web-general-phone'] : null;
	if ( is_singular() ):
		$post_id = $wp_query->post->ID;
		if ( is_singular( 'location' ) ):
			$phone_number = get_post_meta( $post_id, '_ttm_business_main_phone', 1 ) != ''
				? esc_html( get_post_meta( $post_id, '_ttm_business_main_phone', 1 ) )
				: $phone_number;
		else:
			$phone_number = get_post_meta( $post_id, '_qwl_menu_phone_number', 1 ) != ''
				? esc_html( get_post_meta( $post_id, '_qwl_menu_phone_number', 1 ) )
				: $phone_number;
		endif;
	endif;
	if ( $phone_number != null ):
        $phone_number_href = str_replace(['-','(',')',' '],'',$phone_number);
		echo sprintf( '<span class="alignright phone-number"><a href="tel:%1$s">%2$s</a></span>', $phone_number_href, $phone_number );
	endif;
}

add_action( 'mok_phone_number', 'mok_phone_number' );

/**
 * Exclude blog posts from some of the selected categories listed on theme options
 *
 * @param $query
 */
function mok_exclude_cat_blog( $query ) {
	if ( ! is_admin() && $query->is_home() && $query->is_main_query() ):
		$query->set( 'category__not_in',
			is_array( get_option( 'sst_option' ) )
			&& array_key_exists( 'blog-exclude-cat', get_option( 'sst_option' ) )
				? get_option( 'sst_option' )['blog-exclude-cat'] : [] );
	endif;
}

add_action( 'pre_get_posts', 'mok_exclude_cat_blog' );

/**
 * Include both post and page in search results
 *
 * @param $query
 */
function mok_modify_search_result( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search ):
		if ( get_query_var( 'post_type' ) != '' ):
			$query->set( 'post_type', get_query_var( 'post_type' ) );
		else:
			$query->set( 'post_type', [ 'post', 'page' ] );
		endif;
	endif;
}

add_action( 'pre_get_posts', 'mok_modify_search_result' );

/**
 * Displays latest job on sidebar
 */
function mok_job_sidebar() {
	if ( is_singular( 'job' ) ):
		$jobs = new WP_Query( [
			'post_type'      => 'job',
			'post_status'    => 'publish',
			'posts_per_page' => 5
		] );
		if ( $jobs->have_posts() ): ?>
            <section class="widget widget-last-blog-posts">
                <h4 class="widget-title">Latest Jobs</h4>

                <div class="widget-entry">
					<?php while ( $jobs->have_posts() ): $jobs->the_post(); ?>
                        <article <?php post_class(); ?>>
                            <figure class="image-container">
                                <a href="<?php the_permalink(); ?>">
									<?php
									if ( has_post_thumbnail() ):
										the_post_thumbnail( [ 410, 232 ] );
									else:
										$default_attachment_id = get_option( 'sst_option' )['blog-default-image']['id'];
										echo wp_get_attachment_image( $default_attachment_id, [ 410, 232 ] );
									endif; ?>
                                </a>
                            </figure>
                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                        </article>
					<?php endwhile;
					wp_reset_postdata(); ?>
                </div>
            </section>
		<?php endif;
	endif;
}

add_action( 'mok_before_sidebar', 'mok_job_sidebar' );

/**
 * Different number of posts per page
 *
 * @param $query
 */
function mok_post_per_page_filter( $query ) {
	if ( ! is_admin() && $query->is_main_query() ) {
		if ( is_home() || is_category() ) {
			$query->set( 'posts_per_page', 51 );
		}
		if ( is_post_type_archive( 'testimonials' ) ) {
			$query->set( 'posts_per_page', 45 );
		}
		if ( is_post_type_archive( 'location' ) || is_tax( 'type' ) ) {
			$query->set( 'posts_per_page', - 1 );
		}
	}
}

add_action( 'pre_get_posts', 'mok_post_per_page_filter' );

/**
 * add new slideshare embed format
 */
function mok_enable_open_slideshare_embed() {
	wp_oembed_add_provider( '#https?://(www\.)?slideshare\.net/([^/]+)/([^/]+)#i', 'http://www.slideshare.net/api/oembed/2', true );
}

add_action( 'init', 'mok_enable_open_slideshare_embed' );

if ( ! function_exists( 'mok_dropoff_loc_by_zip' ) ) {
	/**
	 * Ajax search drop off location by zip code
	 */
	function mok_dropoff_loc_by_zip() {
		if ( ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) === 'xmlhttprequest' && wp_verify_nonce( $_REQUEST['secret'],
				'secret-nonce' )
		):
			$zip_codes = (int) strip_tags( $_REQUEST['zip'] );
			$range     = (int) strip_tags( $_REQUEST['range'] );
			$type      = 118;
			$drop_loc  = '';
//get lat and lng from provided zip code

			$zip       = wp_remote_get( "https://maps.googleapis.com/maps/api/geocode/json?key=" . MAP_API . "&components=postal_code:$zip_codes|country:US" );
			$zip       = json_decode( $zip['body'] );
			$latitude  = $zip->results[0]->geometry->location->lat;
			$longitude = $zip->results[0]->geometry->location->lng;
//get range
			$lat_range = $range / 69.172;
			$lon_range = abs( $range / ( cos( $latitude ) * 69.172 ) );
			$min_lat   = number_format( $latitude - $lat_range, "4", ".", "" );
			$max_lat   = number_format( $latitude + $lat_range, "4", ".", "" );
			$min_lon   = number_format( $longitude - $lon_range, "4", ".", "" );
			$max_lon   = number_format( $longitude + $lon_range, "4", ".", "" );
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
					$latitude_meta   = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_latitude', 1 ) );
					$longitude_meta  = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_longitude', 1 ) );
					$address         = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address', 1 ) );
					$city            = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_city', 1 ) );
					$state           = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_state', 1 ) );
					$zip             = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_zip', 1 ) );
					$main_phone      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_main_phone', 1 ) );
					$city_zip        = implode( ', ', [ $city, $state, $zip ] );
					$full_address    = implode( '<br/>', [ $address, $city_zip, $main_phone ] );
					$zip_locations[] = [
						'distance' => mok_location_distance( $latitude, $longitude, $latitude_meta, $longitude_meta ),
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
					$drop_loc .= '<ul class="dropoff-location">';
					foreach ( $zip_locations as $location ):
						$drop_loc .= '<li><i class="fa fa-map-marker"></i><a href="' . $location['link'] . '"><h4>' . $location['title'] . '</h4><p>' . $location['address'] . '<br/>Distance: ' . $location['distance'] . ' miles</p></a></li>';
					endforeach;
					$drop_loc .= '</ul>';
					echo json_encode( $drop_loc );
				else:
					echo json_encode( [ 'message' => 'error' ] );
				endif;
			else:
				echo json_encode( [ 'message' => 'error' ] );
			endif;
		else:
			header( 'Location: ' . $_SERVER['HTTP_REFERER'] );
		endif;
		die();
	}
}
add_action( 'wp_ajax_mok_dropoff_loc_by_zip', 'mok_dropoff_loc_by_zip' );
add_action( 'wp_ajax_nopriv_mok_dropoff_loc_by_zip', 'mok_dropoff_loc_by_zip' );