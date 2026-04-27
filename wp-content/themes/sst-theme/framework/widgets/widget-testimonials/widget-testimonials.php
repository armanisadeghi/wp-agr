<?php
/**
 * Widget for displaying testimonials
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

class Widget_Testimonials extends WP_Widget {

	protected $widget_slug = 'widget-testimonials';

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
			__( 'Latest Testimonials', $this->get_widget_slug() ),
			[
				'classname'   => $this->get_widget_slug() . '-class',
				'description' => __( 'Display testimonials widget', $this->get_widget_slug() )
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
			$cache = [ ];
		}

		if ( ! isset ( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		if ( isset ( $cache[ $args['widget_id'] ] ) ) {
			return print $cache[ $args['widget_id'] ];
		}
		extract( $args, EXTR_SKIP );
		$widget_string = '';
		$title         = $instance['title'];
		$total_post    = $instance['number'];
		$more_link     = $instance['more_link'];
		$more_label    = $instance['more_label'];
		$testimonials  = new WP_Query( [
			'post_type'      => 'testimonials',
			'post_status'    => 'publish',
			'posts_per_page' => $total_post,
		] );
		if ( $testimonials->have_posts() ):
			$widget_string .= $before_widget;
			ob_start();
			echo $args['before_title'] . $title . $args['after_title']; ?>
			<div class="widget-entry">
				<ul class="testimonial-list">
					<?php while ( $testimonials->have_posts() ): $testimonials->the_post();
						$post_id     = get_the_ID();
						$author      = get_post_meta( $post_id, '_qwl_testimonial_author', 1 );
						$author_desc = get_post_meta( $post_id, '_qwl_testimonial_author_desc', 1 ); ?>
						<li class="testimonial-item">
							<div class="testimonial-head">
                                <span class="testimonial-img">
                                    <a href="<?php the_permalink(); ?>">
	                                    <?php if ( has_post_thumbnail() ) :
		                                    the_post_thumbnail( [ 90, 90 ] );
	                                    else:
		                                    $default_attachment_id = get_option( 'sst_option' )['testimonial-default-image']['id'];
		                                    echo wp_get_attachment_image( $default_attachment_id, [ 90, 90 ] );
	                                    endif; ?>
                                    </a>
                                </span>

								<div class="testimonial-summary">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</div>
							</div>
							<div class="testimonial-content">
								<blockquote>
									<p>"<?php echo get_the_excerpt(); ?>"</p>
								</blockquote>
								<div class="testimonial-user">
									<a href="<?php the_permalink(); ?>"><?php echo $author; ?></a>
									<small><?php echo $author_desc; ?></small>
								</div>
							</div>
						</li>
					<?php endwhile;
					wp_reset_postdata(); ?>
				</ul>
				<a href="<?php echo $more_link; ?>" class="link-more"><?php echo $more_label ?></a>
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

		$instance               = $old_instance;
		$instance['title']      = ! empty( $new_instance['title'] ) ? stripslashes( wp_filter_post_kses( addslashes( $new_instance['title'] ) ) ) : $old_instance['title'];
		$instance['number']     = ! empty( $new_instance['number'] ) ? (int) trim( $new_instance['number'] ) : $old_instance['number'];
		$instance['more_link']  = ! empty( $new_instance['more_link'] ) ? esc_url( trim( $new_instance['more_link'] ) ) : $old_instance['more_link'];
		$instance['more_label'] = ! empty( $new_instance['more_label'] ) ? sanitize_text_field( trim( $new_instance['more_label'] ) ) : $old_instance['more_label'];

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
				'title'      => '<span>READ THESE </span>SUCCESS STORIES',
				'number'     => 3,
				'more_link'  => '',
				'more_label' => 'READ MORE'
			]
		);
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">Title</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
			       value="<?php echo esc_html( $instance['title'] ); ?>"/></p>
		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>">Number of testimonials</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number"
			       value="<?php echo esc_html( $instance['number'] ); ?>"/></p>
		<p><label for="<?php echo $this->get_field_id( 'more_link' ); ?>">Link for more</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'more_link' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'more_link' ) ); ?>" type="url"
			       value="<?php echo esc_url( $instance['more_link'] ); ?>"/></p>
		<p><label for="<?php echo $this->get_field_id( 'more_label' ); ?>">Label for more button</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'more_label' ) ); ?>"
			       name="<?php echo esc_attr( $this->get_field_name( 'more_label' ) ); ?>" type="text"
			       value="<?php echo esc_html( $instance['more_label'] ); ?>"/></p>

		<?php
	} // end form

} // end class

add_action(
	'widgets_init', function() {
	register_widget( 'Widget_Testimonials' );
}
);