<?php
/**
 * Widget for displaying location lists based on category. Widget specially for location detail page. Support for map in location detail page.
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Widget
 * @version 1.5.6
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Widget_Location_Details extends WP_Widget {

	protected $widget_slug = 'widget-location-details';

	/*
	--------------------------------------------------*/
	/*
	 Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		parent::__construct(
			$this->get_widget_slug(),
			__( 'Location Details', $this->get_widget_slug() ),
			[
				'classname'   => $this->get_widget_slug() . '-class',
				'description' => __( 'Display location lists based on category. Widget specially for location detail page. Support for map in location detail page.', $this->get_widget_slug() ),
			]
		);

		// Refreshing the widget's cached output with each new post
		add_action( 'save_post', [ $this, 'flush_widget_cache' ] );
		add_action( 'deleted_post', [ $this, 'flush_widget_cache' ] );
		add_action( 'switch_theme', [ $this, 'flush_widget_cache' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'load_google_map' ], 999 );
	} // end constructor

	/**
	 * for loading google map in single location page
	 */
	public function load_google_map() {
		if ( is_singular( 'location' ) ) :
			global $wp_query;
			$post_id        = $wp_query->post->ID;
			$map_api        = get_option( 'wpseo_local' )['api_key_browser'];
			$latitude_meta  = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_latitude', 1 ) );
			$longitude_meta = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address_longitude', 1 ) );
			$address        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address', 1 ) );
			$city           = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_city', 1 ) );
			$state          = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_state', 1 ) );
			$zip            = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_zip', 1 ) );
			$main_phone     = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_main_phone', 1 ) );
			$full_address   = implode( ', ', [ $address, $city, $state, $zip ] );
			$info           = '<p><strong>' . esc_html( get_the_title() ) . '</strong></p><p>Phone: ' . esc_html( $main_phone ) . '</p><p>Address: ' . $full_address . '</p><p><a href="' . esc_url( get_the_permalink() ) . '">More Details</a></p>';
			$scripts        = <<<SCRIPTS
function initMap() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };

    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map"), mapOptions);
    map.setTilt(45);

    // Multiple Markers
    var markers = [
        ['{$full_address}',{$latitude_meta},{$longitude_meta}]
    ];
    // Info Window Content
    var infoWindowContent = [
        ['{$info}']
    ];

    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;

    // Loop through our array of markers & place each one on the map
    for (i = 0; i < markers.length; i++) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });

        // Allow each marker to have an info window
        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
    }

    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function (event) {
        this.setZoom(18);
        google.maps.event.removeListener(boundsListener);
    });

}
SCRIPTS;
			wp_dequeue_script( 'sst-google-map' );
			wp_enqueue_script( 'sst-load-map', 'https://maps.googleapis.com/maps/api/js?key=' . $map_api . '&callback=initMap', [ 'sst-theme-js' ], false, true );
			wp_add_inline_script( 'sst-theme-js', $scripts );
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


	/*
	--------------------------------------------------*/
	/*
	 Widget API Functions
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

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			return print $cache[ $args['widget_id'] ];
		}
		extract( $args, EXTR_SKIP );
		$widget_string  = '';
		$title          = $instance['title'];
		$total_post     = $instance['number'];
		$type           = $instance['type'];
		$query          = new WP_Query(
			[
				'post_type'      => 'location',
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'ASC',
				'posts_per_page' => $total_post,
				'tax_query'      => [
					[
						'taxonomy' => 'type',
						'field'    => 'term_id',
						'terms'    => $type,
					],
				],
			]
		);
		$widget_string .= $before_widget;
			ob_start();
			echo $args['before_title'] . $title . $args['after_title']; ?>
			<div class="widget-entry">
				<ul class="listing-location" data-hook="listing-location">


					<?php
					if ( $query->have_posts() ) :
						while ( $query->have_posts() ) :
							$query->the_post();
									   $post_id       = get_the_ID();
									   $address       = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_address', 1 ) );
									   $city          = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_city', 1 ) );
									   $state         = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_state', 1 ) );
									   $zip           = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_zip', 1 ) );
									   $main_phone    = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_business_main_phone', 1 ) );
									   $city_state    = implode( ', ', [ $city, $state ] );
									   $citystate_zip = implode( ' ', [ $city_state, $zip ] );
									   $full_address  = implode( '<br/>', [ $address, $citystate_zip, $main_phone ] );
							?>
						<li>
							<i class="fa fa-map-marker"></i>
							<a href="<?php the_permalink(); ?>">
											   <?php the_title( '<h4>', '</h4>' ); ?>
											   <?php echo wpautop( $full_address ); ?>
							</a>
						</li>
								   <?php
					endwhile;
						wp_reset_postdata();
						?>
				</ul>
			</div>
						<?php
						$widget_string .= ob_get_clean();
						$widget_string .= $after_widget;
		endif;

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

		$instance           = $old_instance;
		$instance['title']  = ! empty( $new_instance['title'] ) ? stripslashes( wp_filter_post_kses( addslashes( $new_instance['title'] ) ) ) : $old_instance['title'];
		$instance['number'] = ! empty( $new_instance['number'] ) ? (int) trim( $new_instance['number'] ) : $old_instance['number'];
		$instance['type']   = ! empty( $new_instance['type'] ) ? (int) trim( $new_instance['type'] ) : $old_instance['type'];

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
				'title'  => '',
				'number' => 0,
				'type'   => 0,
			]
		);
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">Title</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
				   value="<?php echo esc_html( $instance['title'] ); ?>"/></p>
		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>">Number of data</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number"
				   value="<?php echo esc_html( $instance['number'] ); ?>"/></p>
		<p>*Set value to -1 to display all locations</p>
		<p><label for="<?php echo $this->get_field_id( 'type' ); ?>">Location Type</label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" class="widefat">
				<option value="0" <?php echo 0 == $instance['type'] ? 'selected' : ''; ?>>All</option>
				<?php
				$location_types = get_terms(
					[
						'taxonomy'   => 'type',
						'hide_empty' => false,
					]
				);
				foreach ( $location_types as $type ) :
					?>
					<option value="<?php echo $type->term_id; ?>" <?php echo $type->term_id == $instance['type'] ? 'selected' : ''; ?>><?php echo $type->name; ?></option>
				<?php endforeach; ?>
			</select>
		</p>

		<?php
	} // end form

} // end class

add_action(
	'widgets_init', function() {
	register_widget( 'Widget_Location_Details' );
}
);