<?php
/**
 * List of all custom hooks used for modifying backend and default WordPress behaviours
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Framework
 * @version 2.0.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

if ( ! function_exists( 'mok_theme_starter ' ) ) {
	function mok_theme_starter() {
		// remove pesky injected css for recent comments widget
		add_filter( 'wp_head', 'mok_remove_wp_widget_recent_comments_style', 1 );

		// clean up comment styles in the head
		add_action( 'wp_head', 'mok_remove_recent_comments_style', 1 );
		add_action( 'wp_before_admin_bar_render', 'mok_remove_admin_bar_links' );
		// clean up gallery output in wp
		add_filter( 'gallery_style', 'mok_gallery_style' );

		// ie conditional wrapper
		add_filter( 'style_loader_tag', 'mok_ie_conditional', 10, 2 );

		// additional post related cleaning
		add_filter( 'img_caption_shortcode', 'mok_cleaner_caption', 10, 3 );
		add_filter( 'get_image_tag_class', 'mok_image_tag_class', 0, 4 );
		add_filter( 'get_image_tag', 'mok_image_editor', 0, 4 );
		add_filter( 'the_content', 'mok_img_unautop', 30 );
		add_filter( 'nav_menu_css_class', 'mok_active_nav_class', 10, 2 );
		add_filter( 'wp_list_pages', 'mok_active_list_pages_class', 10, 2 );

	}
}
add_action( 'after_setup_theme', 'mok_theme_starter' );

// remove WP version from scripts
if ( ! function_exists( 'mok_remove_wp_ver_css_js ' ) ) {
	function mok_remove_wp_ver_css_js( $src ) {
		if ( strpos( $src, 'ver=' ) ) {
			$src = remove_query_arg( 'ver', $src );
		}

		return $src;
	}
}

// remove injected CSS for recent comments widget
if ( ! function_exists( 'mok_remove_wp_widget_recent_comments_style ' ) ) {
	function mok_remove_wp_widget_recent_comments_style() {
		if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
			remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
		}
	}
}

// remove injected CSS from recent comments widget
if ( ! function_exists( 'mok_remove_recent_comments_style ' ) ) {
	function mok_remove_recent_comments_style() {
		global $wp_widget_factory;
		if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
			remove_action( 'wp_head', array(
				$wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
				'recent_comments_style'
			) );
		}
	}
}

// remove injected CSS from gallery
if ( ! function_exists( 'mok_gallery_style ' ) ) {
	function mok_gallery_style( $css ) {
		return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
	}
}

// adding the conditional wrapper around ie stylesheet
if ( ! function_exists( 'mok_ie_conditional ' ) ) {
	function mok_ie_conditional( $tag, $handle ) {
		if ( 'mok-ie-only' == $handle ) {
			$tag = '<!--[if lt IE 9]>' . "\n" . $tag . '<![endif]-->' . "\n";
		}

		return $tag;
	}
}

/* Customized the output of caption, you can remove the filter to restore back to the WP default output. */
if ( ! function_exists( 'mok_cleaner_caption ' ) ) {
	function mok_cleaner_caption( $output, $attr, $content ) {

		/* We're not worried abut captions in feeds, so just return the output here. */
		if ( is_feed() ) {
			return $output;
		}

		/* Set up the default arguments. */
		$defaults = array(
			'id'      => '',
			'align'   => 'alignnone',
			'width'   => '',
			'caption' => ''
		);

		/* Merge the defaults with user input. */
		$attr = shortcode_atts( $defaults, $attr );

		/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
		if ( 1 > $attr['width'] || empty( $attr['caption'] ) ) {
			return $content;
		}

		/* Set up the attributes for the caption <div>. */
		$attributes = ' class="figure ' . esc_attr( $attr['align'] ) . '"';

		/* Open the caption <div>. */
		$output = '<figure' . $attributes . '>';

		/* Allow shortcodes for the content the caption was created for. */
		$output .= do_shortcode( $content );

		/* Append the caption text. */
		$output .= '<figcaption>' . $attr['caption'] . '</figcaption>';

		/* Close the caption </div>. */
		$output .= '</figure>';

		/* Return the formatted, clean caption. */

		return $output;

	}
}

// Clean the output of attributes of images in editor.
if ( ! function_exists( 'mok_image_tag_class ' ) ) {
	function mok_image_tag_class( $class, $id, $align, $size ) {
		$align = 'align' . esc_attr( $align );

		return $align;
	}
}

// Remove width and height in editor, for a better responsive world.
if ( ! function_exists( 'mok_image_editor ' ) ) {
	function mok_image_editor( $html, $id, $alt, $title ) {
		return preg_replace( array(
			'/\s+width="\d+"/i',
			'/\s+height="\d+"/i',
			'/alt=""/i'
		),
			array(
				'',
				'',
				'',
				'alt="' . $title . '"'
			),
			$html );
	}
}

// Wrap images with figure tag.
if ( ! function_exists( 'mok_img_unautop ' ) ) {
	function mok_img_unautop( $pee ) {
		$pee = preg_replace( '/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '$1', $pee );

		return $pee;
	}
}

// Pagination
if ( ! function_exists( 'mok_pagination' ) ) {
	function mok_pagination() {
		global $wp_query;

		$big = 999999999; // This needs to be an unlikely integer

		$paginate_links = paginate_links( array(
			'base'      => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $wp_query->max_num_pages,
			'mid_size'  => 5,
			'prev_next' => true,
			'prev_text' => __( '&laquo;' ),
			'next_text' => __( '&raquo;' ),
			'type'      => 'list'
		) );

		// Display the pagination if more than one page is found
		if ( $paginate_links ) {
			echo '<div class="pagination-centered">';
			echo $paginate_links;
			echo '</div><!--// end .pagination -->';
		}
	}
}

// A fallback when no navigation is selected by default.
if ( ! function_exists( 'mok_menu_fallback' ) ) {
	function mok_menu_fallback() {
		echo '<div class="alert-box secondary">';
		// Translators 1: Link to Menus, 2: Link to Customize
		printf( __( 'Please assign a menu to the primary menu location under %1$s or %2$s the design.', '_mok' ),
			sprintf( __( '<a href="%s">Menus</a>', '_mok' ),
				get_admin_url( get_current_blog_id(), 'nav-menus.php' )
			),
			sprintf( __( '<a href="%s">Customize</a>', '_mok' ),
				get_admin_url( get_current_blog_id(), 'customize.php' )
			)
		);
		echo '</div>';
	}
}

// Remove wp logo from dashboard
if ( ! function_exists( 'mok_remove_admin_bar_links' ) ) {
	function mok_remove_admin_bar_links() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'wp-logo' );
	}
}

// Add Foundation 'active' class for the current menu item
if ( ! function_exists( 'mok_active_nav_class' ) ) {
	function mok_active_nav_class( $classes, $item ) {
		if ( $item->current == 1 || $item->current_item_ancestor == true ) {
			$classes[] = 'active';
		}

		return $classes;
	}
}

// Use the active class of ZURB Foundation on wp_list_pages output.
if ( ! function_exists( 'mok_active_list_pages_class' ) ) {
	function mok_active_list_pages_class( $input ) {

		$pattern = '/current_page_item/';
		$replace = 'current_page_item active';

		$output = preg_replace( $pattern, $replace, $input );

		return $output;
	}
}