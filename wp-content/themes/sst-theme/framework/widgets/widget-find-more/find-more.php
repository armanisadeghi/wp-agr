<?php
/**
 * Find more widget
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Widget
 * @version 1.5.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Find_More extends WP_Widget {

	protected $widget_slug = 'mok-find-more';

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
			__( 'Find More', $this->get_widget_slug() ),
			[
				'classname'   => $this->get_widget_slug() . '-class',
				'description' => __( 'Display find more widget', $this->get_widget_slug() ),
			]
		);

		// Refreshing the widget's cached output with each new post
		add_action( 'save_post', [ $this, 'flush_widget_cache' ] );
		add_action( 'deleted_post', [ $this, 'flush_widget_cache' ] );
		add_action( 'switch_theme', [ $this, 'flush_widget_cache' ] );
	} // end constructor


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

		global $wp_query;
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

		$widget_string = '';
		ob_start();
		$find_more   = get_post_meta( $wp_query->post->ID, '_qwl_widget_findmore_content', 1 );
		$theme_color = get_post_meta( $wp_query->post->ID, '_qwl_widget_findmore_check', 1 ) ? 'dark' : '';
		if ( '' !== $find_more ) : ?>
			<aside class="widget-read-more <?php echo $theme_color; ?>">
				<div class="widget-entry">
					<?php echo $find_more; ?>
				</div>
			</aside>
			<?php
		endif;
		$widget_string .= ob_get_clean();
		$widget_string .= '';

		$cache[ $args['widget_id'] ] = $widget_string;

		wp_cache_set( $this->get_widget_slug(), $cache, 'widget' );

		print $widget_string;

	} // end widget


	public function flush_widget_cache() {
		wp_cache_delete( $this->get_widget_slug(), 'widget' );
	}


} // end class

add_action(
	'widgets_init', function() {
		register_widget( 'Find_More' );
	}
);
