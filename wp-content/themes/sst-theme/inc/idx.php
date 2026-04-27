<?php

if ( ( isset( $_GET['propertyName'] ) && '' != $_GET['propertyName'] ) &&
     ( isset( $_GET['idxID'] ) && '' != $_GET['idxID'] ) &&
     ( isset( $_GET['listingID'] ) && '' != $_GET['listingID'] )
) {
	fav_property( $_GET['propertyName'], $_GET['idxID'], $_GET['listingID'] );
}

/**
 * @param null $url
 *
 * @return array|mixed|WP_Error
 */
function idx_json( $url = null ) {
	if ( '' == $url ) {
		$url = 'https://api.idxbroker.com/clients/featured';
	}
	$args = [
		'timeout' => 20,
		'headers' => [
			"Content-Type" => "application/x-www-form-urlencoded",
			"accesskey"    => "xmdo3uf0J8BEFZkaXU-1E1",
			"outputtype"   => "json",
			"apiversion"   => "1.2.1"
		],
	];


	if ( false === ( $response = get_transient( 'idx' ) ) ) {
		$response = wp_remote_get( $url, $args );
		if ( ! is_wp_error( $response ) ) {
			set_transient( 'idx', $response, 2 * HOUR_IN_SECONDS );
		}
	}

	return $response;
}

if ( ! function_exists( 'featured_listing_arr' ) ) {
	/**
	 * @return array|mixed|object|string
	 */
	function featured_listing_arr() {
		$data = idx_json( $url = 'https://api.idxbroker.com/clients/featured' );
		if ( is_array( $data ) ) {
			return json_decode( $data["body"], true );
		} else {
			return "Error during API call.";
		}
	}
}

if ( ! function_exists( 'get_featured_listing' ) ) {
	/**
	 * Get featured listing from IDX
	 */
	function get_featured_listing() {
		$count             = 1;
		$count_limit       = 4;
		$featured_listings = featured_listing_arr();
		if ( '' != $featured_listings && is_array( $featured_listings ) ): ?>
            <ul class="IDX-Featured-Listings IDX-Listings large-block-4 clearfix">
				<?php foreach ( $featured_listings as $feature ): ?>
                    <li class="IDX-featured-item" id="IDX-property-<?php echo $feature['listingID']; ?>">
                        <div class="IDX-item-inner">
							<?php if ( 'sold' != strtolower( $feature['propStatus'] ) ): ?>
                                <span class="status"><?php echo $feature['propStatus']; ?></span>
							<?php endif; ?>
                            <div class="address">
                                <span class="streetName"><?php echo $feature['streetName']; ?>, </span>
                                <span class="county"><?php echo $feature['countyName']; ?></span>
                            </div>
                            <div class="price"><?php echo $feature['listingPrice']; ?></div>
                            <div class="img-wrapper">
                                <a href="<?php echo $feature['fullDetailsURL']; ?>">
									<?php if ( '' != $feature['image'][0]['url'] ): ?>
                                        <img src="<?php echo $feature['image'][0]['url']; ?>"
                                             alt="<?php echo $feature['image'][0]['caption']; ?>"/>
									<?php else: ?>
                                        <img
                                                src="<?php echo get_stylesheet_directory_uri(); ?>/home-new/img/default.jpg"
                                                alt="<?php bloginfo(); ?>"/>
									<?php endif; ?>
                                </a>
                            </div>
                            <div class="property-meta">
                                <span class="bedrooms"><label>Beds</label><?php echo $feature['bedrooms']; ?> </span>
                                <span
                                        class="bathrooms"><label>Baths</label> <?php echo str_replace( '.00', '', $feature['totalBaths'] ); ?> </span>
                                <span
                                        class="sqft"><label>SqFT</label><span
                                            class="value"><?php echo number_format( $feature['sqFt'] ); ?></span></span>
                                <span class="acres"><label>Acres</label><span
                                            class="value"><?php echo $feature['acres']; ?></span></span>
                            </div>
                        </div>
                    </li>
					<?php
					if ( $count >= $count_limit ):
						break;
					endif;
					$count ++;
				endforeach; ?>
            </ul>
			<?php
		else:
			echo $featured_listings;
		endif;
	}

	add_action( 'featured_listing', 'get_featured_listing' );
}


if ( ! function_exists( 'recent_listing_arr' ) ) {
	/**
	 * @return array|mixed|object|string
	 */
	function recent_listing_arr() {
		$data = idx_json( $url = 'https://api.idxbroker.com/clients/featured?interval=2880' );
		if ( is_array( $data ) ):
			return json_decode( $data["body"], true );
		endif;

		return "Error during API call.";
	}
}

if ( ! function_exists( 'get_recent_listing' ) ) {
	/**
	 * Get recent listings from IDX
	 */
	function get_recent_listing() {
		$count           = 1;
		$count_limit     = 8;
		$recent_listings = recent_listing_arr();
		shuffle( $recent_listings );
		if ( '' != $recent_listings && is_array( $recent_listings ) ): ?>
            <ul class="IDX-Recent-Listings IDX-Listings  large-block-4 clearfix">
				<?php foreach ( $recent_listings as $recent ): ?>
                    <li class="IDX-featured-item" id="IDX-property-<?php echo $recent['listingID']; ?>">
                        <div class="IDX-item-inner">
                            <span class="ribbon ribbon-new">NEW</span>
							<?php if ( 'sold' != strtolower( $recent['propStatus'] ) ): ?>
                                <span class="status"><?php echo $recent['propStatus']; ?></span>
							<?php endif; ?>
                            <div class="address">
                                <span class="streetName"><?php echo $recent['streetName']; ?>, </span>
                                <span class="county"><?php echo $recent['countyName']; ?></span>
                            </div>
                            <div class="price"><?php echo $recent['listingPrice']; ?></div>
                            <div class="img-wrapper">
                                <a href="<?php echo $recent['fullDetailsURL']; ?>">
									<?php if ( '' != $recent['image'][0]['url'] ): ?>
                                        <img src="<?php echo $recent['image'][0]['url']; ?>"
                                             alt="<?php echo $recent['image'][0]['caption']; ?>"/>
									<?php else: ?>
                                        <img
                                                src="<?php echo get_stylesheet_directory_uri(); ?>/home-new/img/default.jpg"
                                                alt="<?php bloginfo(); ?>"/>
									<?php endif; ?>
                                </a>
                            </div>
                            <!--                            <a href="#" class="favourite" >ADD TO FAVORITES <i class="fa fa-heart-o"></i></a>-->

                            <div class="property-meta">
                                <span class="bedrooms"><label>Beds</label><?php echo $recent['bedrooms']; ?> </span>
                                <span
                                        class="bathrooms"><label>Baths</label> <?php echo str_replace( '.00', '', $recent['totalBaths'] ); ?> </span>
                                <span
                                        class="sqft"><label>SqFT</label><span
                                            class="value"><?php echo number_format( $recent['sqFt'] ); ?> </span></span>
                                <span class="acres"><label>Acres</label><span
                                            class="value"><?php echo $recent['acres']; ?></span></span>
                            </div>
                        </div>
                    </li>
					<?php
					if ( $count >= $count_limit ):
						break;
					endif;
					$count ++;
				endforeach; ?>
            </ul>
			<?php
		else:
			echo $recent_listings;
		endif;
	}

	add_action( 'recent_listing', 'get_recent_listing' );
}


if ( ! function_exists( 'fav_property' ) ) {
	/**
	 * @param $propertyName
	 * @param $idxID
	 * @param $listingID
	 */
	function fav_property( $propertyName, $idxID, $listingID ) {
		$url = 'https://api.idxbroker.com/leads/property';

		$data = [
			'propertyName' => 'Test Property',
			'property'     => [ 'idxID' => 'a001', 'listingID' => '345678' ]
		];
		$data = http_build_query( $data ); // encode and & delineate
	}
}


if ( ! function_exists( 'current_lead' ) ) {
	/**
	 * @return array|mixed|object|string
	 */
	function current_lead_arr() {
		$data = idx_json( $url = 'https://api.idxbroker.com/leads/lead' );
		if ( is_array( $data ) ) {
			return json_decode( $data["body"], true );
		} else {
			return "Error during API call.";
		}
	}

}

if ( ! function_exists( 'get_current_lead' ) ) {
	function get_current_lead() {
		var_dump( current_lead_arr() );
	}
}

//get_current_lead();


// lead signup
//<script charset="UTF-8" type="text/javascript" id="idxwidgetsrc-35041" src="http://michaelputnam.idxbroker.com/idx/leadsignupwidget.php?widgetid=35041"></script>
// lead login
//<script charset="UTF-8" type="text/javascript" id="idxwidgetsrc-35042" src="http://michaelputnam.idxbroker.com/idx/leadloginwidget.php?widgetid=35042"></script>

