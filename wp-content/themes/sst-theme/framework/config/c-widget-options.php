<?php

/**
 * As seen on widget for SST theme
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Custom Widgets
 * @version  2.0.0
 * @since    1.6.0
 * @author   Moksha Design Studio <webmaster@mokshastudio.com>
 */

use Carbon_Fields\Widget;
use Carbon_Fields\Field;

/**
 * SeenOnWidget class that extends Carbon_Fields\Widget to register widget
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Custom Widgets
 * @version  2.0.0
 * @since    1.6.0
 * @author   Moksha Design Studio <webmaster@mokshastudio.com>
 */
class SeenOnWidget extends Widget {

	/**
	 * SeenOnWidget constructor.
	 * Field, title and description setup for widgets
	 */
	public function __construct() {
		$this->setup( 'as-seen-on-widget', 'As Seen On Widget', 'Displays as seen on list', [
			Field::make( 'text', 'title', 'Title' )->set_default_value( 'As Seen On' ),
			Field::make( 'complex', 'seen_list', __( 'As Seen On List' ) )
			     ->set_layout( 'tabbed-vertical' )
			     ->setup_labels( [
				     'plural_name'   => __( 'images' ),
				     'singular_name' => __( 'image' ),
			     ] )
			     ->add_fields( 'link', [
				     Field::make( 'image', 'image', __( 'Image' ) ),
				     Field::make( 'text', 'link', __( 'Link' ) )
				          ->set_attribute( 'type', 'url' ),
			     ] )
			     ->set_header_template( 'Image ID: <%- image %>' )
		] );
	}

	/**
	 * Output for widget
	 *
	 * @param array $args necessary argument while registering widgets
	 * @param array $instance returns instance of widget
	 */
	public function front_end( $args, $instance ) {
		echo $args['before_title'] . $instance['title'] . $args['after_title'];
		if ( array_key_exists( 'seen_list', $instance ) ):
			$lists = $instance['seen_list'];
			echo '<ul>';
			foreach ( $lists as $list ):
				$link = $list['link'] != '' ? esc_url( $list['link'] ) : 'javascript:void(0)';
				echo '<li><a href="' . $link . '">' . wp_get_attachment_image( $list['image'], 'full' ) . '</a></li>';
			endforeach;
			echo '</ul>';
		endif;
	}
}

/**
 * register widget for WordPress
 */
function load_widgets() {
	register_widget( 'SeenOnWidget' );
}

add_action( 'widgets_init', 'load_widgets' );