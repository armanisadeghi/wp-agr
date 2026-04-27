<?php
/**
 * List of all custom functions used
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Framework
 * @version 2.0.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

/**
 * Count number of widgets in a sidebar
 * Used to add classes to widget areas so widgets can be displayed one, two, three or four per row
 *
 * @param $sidebar_id
 *
 * @return string
 */
function mok_count_widgets( $sidebar_id ) {
	global $sidebars_widgets;
	$count = count( $sidebars_widgets[ $sidebar_id ] );
	global $_wp_sidebars_widgets;
	if ( empty( $_wp_sidebars_widgets ) ) :
		$_wp_sidebars_widgets = get_option( 'sidebars_widgets', [] );
	endif;

	$sidebars_widgets_count = $_wp_sidebars_widgets;

	if ( isset( $sidebars_widgets_count[ $sidebar_id ] ) ) :
		$widget_count   = count( $sidebars_widgets_count[ $sidebar_id ] );
		$widget_classes = 'widget-count-' . count( $sidebars_widgets_count[ $sidebar_id ] );
		if ( $widget_count % 4 == 0 || $widget_count > 6 ) :
			// Four widgets er row if there are exactly four or more than six
			$widget_classes .= ' per-row-4';
		elseif ( $widget_count >= 3 ) :
			// Three widgets per row if there's three or more widgets
			$widget_classes .= ' per-row-3';
		elseif ( 2 == $widget_count ) :
			// Otherwise show two widgets per row
			$widget_classes .= ' per-row-2';
		endif;

		return $widget_classes;
	endif;

	return '';
}

/**
 * Returns icon list for use in post meta
 * @return array
 */
function mok_get_icon_list() {
	$location = get_template_directory() . '/assets/images/icons';
	if ( file_exists( $location ) ):
		$icons      = scandir( $location );
		$collection = [ 'none' => 'None' ];
		$count      = 1;
		foreach ( $icons as $icon ):
			if ( $count > 2 ):
				$ico_name   = explode( '.', $icon );
				$collection = array_merge_recursive( $collection, [
					get_template_directory_uri() . '/assets/images/icons' . '/' . $icon => ucwords( str_replace( '-',
						' ', $ico_name[0] ) )
				] );
			endif;
			$count ++;
		endforeach;

		return $collection;
	endif;

	return [];
}

/**
 * Returns excerpt
 *
 * @param $limit
 *
 * @return array|mixed|string
 */
function excerpt( $limit ) {
	$excerpt = explode( ' ', get_the_excerpt(), $limit );
	if ( count( $excerpt ) >= $limit ) {
		array_pop( $excerpt );
		$excerpt = implode( " ", $excerpt ) . '...';
	} else {
		$excerpt = implode( " ", $excerpt );
	}
	$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );

	return $excerpt;
}

/**
 * Returns slideshare iframe code
 *
 * @param $id
 * @param $width
 *
 * @return string
 */
function mok_slideshare_embed( $id, $width ) {
	$height = round( $width / 1.32 ) + 34;

	return '<iframe src="https://www.slideshare.net/slideshow/embed_code/' . esc_attr( $id ) . '" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '"></iframe><br/>';
}

/**
 * Returns drop off location list based on address and range
 *
 * @param $address
 * @param $range
 *
 * @return string
 */
function mok_drop_off_loc( $address, $range ) {
	$address = urlencode( $address );
	//get lat and lng from provided zip code
	$zip       = wp_remote_get( "https://maps.googleapis.com/maps/api/geocode/json?key=" . MAP_API . "&address=$address&components=country:US" );
	$zip       = json_decode( $zip['body'] );
	$latitude  = $zip->results[0]->geometry->location->lat;
	$longitude = $zip->results[0]->geometry->location->lng;
	//get range
	$drop_loc  = '<div id="map" class="map-sec" style="width: 100%;height: 550px;"></div>';
	$lat_range = $range / 69.172;
	$lon_range = abs( $range / ( cos( $latitude ) * 69.172 ) );
	$min_lat   = number_format( $latitude - $lat_range, "4", ".", "" );
	$max_lat   = number_format( $latitude + $lat_range, "4", ".", "" );
	$min_lon   = number_format( $longitude - $lon_range, "4", ".", "" );
	$max_lon   = number_format( $longitude + $lon_range, "4", ".", "" );

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
		$zip_locations = [];
		while ( $query->have_posts() ): $query->the_post();
			$post_id        = get_the_ID();
			$latitude_meta  = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_latitude', 1 ) );
			$longitude_meta = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_longitude', 1 ) );
			$distance_diff  = mok_location_distance( $latitude, $longitude, $latitude_meta, $longitude_meta );
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
function mok_drop_off_loc_xml( $address, $range ) {
	$address = urlencode( $address );
	//get lat and lng from provided zip code
	$zip       = wp_remote_get( "https://maps.googleapis.com/maps/api/geocode/json?key=" . MAP_API . "&address=$address&components=country:US" );
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
			$distance_diff  = mok_location_distance( $latitude, $longitude, $latitude_meta, $longitude_meta );
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
			$xml .= "</markers>";
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
function mok_location_distance( $lat1, $lon1, $lat2, $lon2 ) {
	$lat1 = deg2rad( $lat1 );
	$lon1 = deg2rad( $lon1 );
	$lat2 = deg2rad( $lat2 );
	$lon2 = deg2rad( $lon2 );

	// Find the deltas
	$delta_lat = $lat2 - $lat1;
	$delta_lon = $lon2 - $lon1;

	// Find the Great Circle distance
	$temp     = pow( sin( $delta_lat / 2.0 ), 2 ) + cos( $lat1 ) * cos( $lat2 ) * pow( sin( $delta_lon / 2.0 ), 2 );
	$distance = 3956 * 2 * atan2( sqrt( $temp ), sqrt( 1 - $temp ) );

	return round( $distance, 2 );
}