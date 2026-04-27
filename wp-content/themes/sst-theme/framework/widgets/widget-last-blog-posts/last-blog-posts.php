<?php
/**
 * Widget for displaying blog posts with thumbnails
 *
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

class Last_Blog_Posts extends WP_Widget {

	protected $widget_slug = 'widget-last-blog-posts';

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
			__( 'Blog Posts with thumbnails', $this->get_widget_slug() ),
			[
				'classname'   => $this->get_widget_slug() . '-class',
				'description' => __( 'Display blog posts with thumbnails widget', $this->get_widget_slug() )
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
		$title         = $instance['title'];
		$total_post    = $instance['number'];
		$template      = array_key_exists( 'template', $instance ) ? $instance['template'] : 'full';
		$blog          = new WP_Query(
			[
				'post_type'        => 'post',
				'post_status'      => 'publish',
				'posts_per_page'   => $total_post,
				'category__not_in' => is_array( get_option( 'sst_option' ) ) && array_key_exists( 'blog-exclude-cat', get_option( 'sst_option' ) ) ? get_option( 'sst_option' )['blog-exclude-cat'] : [],
			]
		);
		if ( $blog->have_posts() ) :
			$widget_string .= $before_widget;
			ob_start();
			echo $args['before_title'] . $title . $args['after_title']; ?>
			<div class="widget-entry">
				<?php
				while ( $blog->have_posts() ) :
					$blog->the_post();
					?>
					<?php if ( $template == 'full' ) : ?>
						<article <?php post_class(); ?>>
							<figure class="image-container">
								<a href="<?php the_permalink(); ?>">
									<?php
									if ( has_post_thumbnail() ) :
										the_post_thumbnail( [ 410, 232 ] );
									else :
										$default_attachment_id = get_option( 'sst_option' )['blog-default-image']['id'];
										echo wp_get_attachment_image( $default_attachment_id, [ 410, 232 ] );
									endif;
									?>
								</a>
							</figure>
							<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
						</article>
					<?php else : ?>
						<article class="widget-image-left">
							<figure class="image-container">
								<a href="<?php the_permalink(); ?>">
									<?php
									if ( has_post_thumbnail() ) :
										the_post_thumbnail( [ 122, 68 ] );
									else :
										$default_attachment_id = get_option( 'sst_option' )['blog-default-image']['id'];
										echo wp_get_attachment_image( $default_attachment_id, [ 122, 68 ] );
									endif;
									?>
								</a>
							</figure>
							<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
							<a class="alignright link-more"
							   href="<?php the_permalink(); ?>"><?php echo apply_filters( 'sidebar_read_more', 'Read Article' ); ?></a>
						</article>
					<?php endif; ?>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
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

		$instance             = $old_instance;
		$instance['title']    = ! empty( $new_instance['title'] ) ? stripslashes( wp_filter_post_kses( addslashes( $new_instance['title'] ) ) ) : $old_instance['title'];
		$instance['number']   = ! empty( $new_instance['number'] ) ? intval( trim( $new_instance['number'] ) ) : $old_instance['number'];
		$instance['template'] = ! empty( $new_instance['template'] ) ? esc_html( $new_instance['template'] ) : $old_instance['template'];

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
				'title'    => 'Last Blog Posts',
				'number'   => 3,
				'template' => 'full',
			]
		);
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">Title</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text"
				   value="<?php echo esc_html( $instance['title'] ); ?>"/></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>">Number of posts</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"
				   name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number"
				   value="<?php echo esc_html( $instance['number'] ); ?>"/></p>
		<p><label for="<?php echo $this->get_field_id( 'template' ); ?>">Template Style</label>
			<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'template' ) ); ?>"
					id="<?php echo esc_attr( $this->get_field_id( 'template' ) ); ?>">
				<option value="full" <?php echo $instance['template'] == 'full' ? 'selected' : ''; ?>>Full Width Image
				</option>
				<option value="image-left" <?php echo $instance['template'] == 'image-left' ? 'selected' : ''; ?>>Image
					Aligned Left
				</option>
			</select>
		</p>

		<?php
	}

}

add_action(
	'widgets_init', function() {
		register_widget( 'Last_Blog_Posts' );
	}
);

