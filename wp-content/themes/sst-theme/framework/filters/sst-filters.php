<?php
/**
 * List of all custom filters used
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Framework
 * @version 2.0.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

if ( ! function_exists( 'mok_html_widget_title' ) ) {
	/**
	 * enables html tag in widget [ instead of <
	 *
	 * @param $title
	 *
	 * @return mixed
	 */

	function mok_html_widget_title( $title ) { //HTML tag opening/closing brackets
		$title = str_replace( '[', '<', $title );
		$title = str_replace( '[/', '</', $title );
		$title = str_replace( ']', '>', $title );

		return $title;
	}
}

add_filter( 'widget_title', 'mok_html_widget_title' );

/**
 * enables shortcode in text widget
 */
add_filter( 'widget_text', 'do_shortcode' );

if ( ! function_exists( 'mok_modify_breadcrumb' ) ) {
	/**
	 * Modifies breadcrumb for team archive page
	 *
	 * @param $title
	 * @param $this_type
	 * @param $this_id
	 *
	 * @return string
	 */
	function mok_modify_breadcrumb( $title, $this_type, $this_id ) {
		if ( array_key_exists( 1, $this_type ) && $this_type[1] == 'post-team-archive' ):
			$title = 'MEET OUR TEAM';
		endif;

		return $title;
	}
}

add_filter( 'bcn_breadcrumb_title', 'mok_modify_breadcrumb', 10, 3 );

/**
 * Changes excerpt length
 *
 * @param $length
 *
 * @return int
 */
function mok_excerpt_length( $length ) {
	return 58;
}

add_filter( 'excerpt_length', 'mok_excerpt_length', 999 );

/**
 * Returns new format excerpt read more
 *
 * @param $more
 *
 * @return string
 */
function mok_excerpt_more( $more ) {
	return '&hellip;';
}

add_filter( 'excerpt_more', 'mok_excerpt_more' );

/**
 * Changes gravity form button only if form title is "Free Consultation - Landing"
 *
 * @param $button
 * @param $form
 *
 * @return string
 */
function mok_form_submit_button( $button, $form ) {
	if ( $form['title'] == 'Free Consultation - Landing' ) {
		return "<button class='fancy-button' id='gform_submit_button_{$form['id']}'><i></i>Submit</button>";
	}

	return $button;
}

add_filter( 'gform_submit_button', 'mok_form_submit_button', 10, 2 );

/**
 * Remove version parameter from script and style
 *
 * @param $src
 *
 * @return mixed
 */
function mok_remove_version_parameter( $src ) {
	$parts = explode( '?ver', $src );

	return $parts[0];
}

add_filter( 'script_loader_src', 'mok_remove_version_parameter', 15, 1 );
add_filter( 'style_loader_src', 'mok_remove_version_parameter', 15, 1 );

/**
 * Alters alt tag for avatar
 *
 * @param $text
 *
 * @return mixed
 */
function mok_replace_content( $text ) {
	$alt  = get_the_author_meta( 'display_name' );
	$text = str_replace( 'alt=\'\'', 'alt=\'Avatar for ' . $alt . '\' title=\'Gravatar for ' . $alt . '\'', $text );

	return $text;
}

add_filter( 'get_avatar', 'mok_replace_content' );

/**
 * add attributes to link attributes
 *
 * @param $atts
 * @param $item
 * @param $args
 *
 * @return mixed
 */
function mok_add_attribute( $atts, $item, $args ) {
	if ( $args->theme_location == 'main-nav' ) {
		$atts['itemprop'] = 'url';
	}

	return $atts;
}

add_filter( 'nav_menu_link_attributes', 'mok_add_attribute', 10, 3 );

/**
 * Hide/show blog author in sidebar based on theme options
 * @return int
 */
function mok_show_hide_author_block() {
	$theme_options = get_option( 'sst_option' );

	return array_key_exists( 'blog-enable-author-sidebar', $theme_options ) ? $theme_options['blog-enable-author-sidebar'] : 1;
}

add_filter( 'blog_author_display_sidebar', 'mok_show_hide_author_block' );

/**
 * Returns new slidehare iframe
 *
 * @param $html
 * @param $url
 * @param $attr
 *
 * @return mixed|string
 */
function mok_change_slideshare_oembed( $html, $url, $attr ) {
	global $content_width;
	$width = $content_width;

	if ( ! preg_match( '#https?://(www\.)?slideshare\.net/([^/]+)/([^/]+)#i', $url ) ) {
		return $html;
	}

	if ( preg_match( '#slideshow/embed_code/(\d+)#', $html, $matches ) ) {
		$new_html = mok_slideshare_embed( $matches[1], $width );
	} else {
		$new_html = $html;
	}

	// Force https
	$new_html = str_replace( 'http://www.slideshare.net', 'https://www.slideshare.net', $new_html );

	// Strip out credit links
	$new_html = preg_replace( '/(.*<\/iframe>)(.*)/', '$1', $new_html );

	return $new_html;
}

add_filter( 'embed_oembed_html', 'mok_change_slideshare_oembed', 1, 3 );

/**
 * adds json ld schema for blog and page
 */
function mok_json_ld_schema() {
	if ( ( is_singular( 'post' ) || is_page() ) && ! is_singular( 'location' ) && ! is_page_template( 'templates/template-sst_home.php' ) ) {
		global $post;
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); 
		/* Code Added By Harsh&Team */
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
		
		
		?>
        <script type="application/ld+json">
            {
              "@context": "http://schema.org",
              "@type": "BlogPosting",
              "mainEntityOfPage":{
                "@type":"WebPage",
                "@id":"<?php echo get_the_permalink( $post->ID ); ?>"
              },
              "headline": "<?php echo get_the_title( $post->ID ) ?>",
              "image": {
                "@type": "ImageObject",
                "url": "<?php echo $thumb['0']; ?>",
                "height": <?php echo absint( $thumb['2'] ); ?>,
                "width": <?php echo absint( $thumb['1'] ); ?>
              },
              "datePublished": "<?php echo get_the_time( 'Y-m-d\TH:i:s', $post->ID ); ?>",
              "dateModified": "<?php echo get_the_time( 'Y-m-d\TH:i:s', $post->ID ); ?>",
              "author": {
                "@type": "Person",
                "name": "<?php echo ucwords( get_the_author_meta( 'user_nicename', $post->post_author ) ); ?>"
              },
               "publisher": {
                "@type": "Organization",
                "name": "<?php bloginfo( 'name' ) ?>",
                "logo": {
                  "@type": "ImageObject",
                  "url": "<?php echo $image[0]; ?>",
                  "width": <?php echo get_custom_header()->width; ?>,
                  "height": <?php echo get_custom_header()->height; ?>
                }
              },
              "description": "<?php echo  $post->post_excerpt ; ?>"
            }
        </script>
		<?php
	}
}

//add_filter( 'wp_head', 'mok_json_ld_schema' );

/**
 * Custom archive title for theme
 * @return string
 */
function mok_custom_archive_title() {
	$title = '';
	if ( is_category() ) {
		$title = sprintf( __( '%s' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( __( '%s' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		/* translators: Author archive title. 1: Author name */
		$title = sprintf( __( 'Author: %s' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		/* translators: Yearly archive title. 1: Year */
		$title = sprintf( __( 'Year: %s' ), get_the_date( _x( 'Y', 'yearly archives date format' ) ) );
	} elseif ( is_month() ) {
		/* translators: Monthly archive title. 1: Month name and year */
		$title = sprintf( __( 'Month: %s' ), get_the_date( _x( 'F Y', 'monthly archives date format' ) ) );
	} elseif ( is_day() ) {
		/* translators: Daily archive title. 1: Date */
		$title = sprintf( __( 'Day: %s' ), get_the_date( _x( 'F j, Y', 'daily archives date format' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title' );
		}
	} elseif ( is_post_type_archive() ) {
		/* translators: Post type archive title. 1: Post type name */
		$title = sprintf( __( '%s' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: Taxonomy term archive title. 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( __( '%s' ), single_term_title( '', false ) );
	} else {
		$title = __( 'Archives' );
	}

	return $title;
}

add_filter( 'get_the_archive_title', 'mok_custom_archive_title' );