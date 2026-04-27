<?php
/**
 * Theme options based on Redux framework
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Theme Options
 * @version 2.0.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

if ( ! class_exists( 'Redux' ) ) {
	return;
}

#region redux settings and arguments
$opt_name = 'sst_option';
$theme    = wp_get_theme();
$args     = [
	'opt_name'             => $opt_name,
	'display_name'         => 'Theme defaults',
	'display_version'      => $theme->get( 'Version' ),
	'menu_type'            => 'menu',
	'allow_sub_menu'       => true,
	'menu_title'           => __( 'Theme Options', 'sst' ),
	'page_title'           => __( 'Theme Options', 'sst' ),
	'google_api_key'       => '',
	'google_update_weekly' => false,
	'async_typography'     => true,
	'admin_bar'            => true,
	'admin_bar_icon'       => 'dashicons-portfolio',
	'admin_bar_priority'   => 50,
	'global_variable'      => '',
	'dev_mode'             => false,
	'update_notice'        => false,
	'customizer'           => true,
	'page_priority'        => null,
	'page_parent'          => 'themes.php',
	'page_permissions'     => 'manage_options',
	'menu_icon'            => 'dashicons-portfolio',
	'last_tab'             => '',
	'page_icon'            => 'icon-themes',
	'page_slug'            => '',
	'save_defaults'        => true,
	'default_show'         => true,
	'default_mark'         => '',
	'show_import_export'   => true,
	'transient_time'       => 60 * MINUTE_IN_SECONDS,
	'output'               => true,
	'output_tag'           => true,
	'database'             => '',
	'use_cdn'              => true,
	'hints'                => [
		'icon'          => 'el el-question-sign',
		'icon_position' => 'right',
		'icon_color'    => 'lightgray',
		'icon_size'     => 'normal',
		'tip_style'     => [
			'color'   => 'red',
			'shadow'  => true,
			'rounded' => false,
			'style'   => '',
		],
		'tip_position'  => [
			'my' => 'top left',
			'at' => 'bottom right',
		],
		'tip_effect'    => [
			'show' => [
				'effect'   => 'slide',
				'duration' => '500',
				'event'    => 'mouseover',
			],
			'hide' => [
				'effect'   => 'slide',
				'duration' => '500',
				'event'    => 'click mouseleave',
			],
		],
	]
];
Redux::setArgs( $opt_name, $args );
#endregion

#region General options
Redux::setSection( $opt_name, [
	'title' => __( 'General', 'sst' ),
	'id'    => 'general',
	'desc'  => __( '', 'sst' ),
	'icon'  => 'el el-website'
] );
Redux::setSection( $opt_name, [
	'title'            => __( 'General Settings', 'sst' ),
	'id'               => 'web-general',
	'subsection'       => true,
	'customizer_width' => '450px',
	'desc'             => __( '', 'sst' ),
	'fields'           => [
		[
			'id'    => 'web-general-phone',
			'type'  => 'text',
			'title' => __( 'Default phone number', 'sst' ),
		]
	]
] );
Redux::setSection( $opt_name, [
	'title'            => __( 'Scripts', 'sst' ),
	'id'               => 'analytics-general',
	'subsection'       => true,
	'customizer_width' => '450px',
	'desc'             => __( 'Analytics or any scripts that need to be included on either header or footer example: Google analytics, Facebook pixel', 'sst' ),
	'fields'           => [
		[
			'id'    => 'analytics-general-head',
			'type'  => 'ace_editor',
			'title' => __( 'Analytics code before &lt;/head&gt; tag', 'sst' ),
		],
		[
			'id'    => 'analytics-general-footer',
			'type'  => 'ace_editor',
			'title' => __( 'Analytics code before &lt;/body&gt; tag', 'sst' ),
		],
	]
] );
#endregion

#region Home page options
Redux::setSection( $opt_name, [
	'title' => __( 'Homepage', 'sst' ),
	'id'    => 'home',
	'desc'  => __( '', 'sst' ),
	'icon'  => 'el el-home'
] );
#endregion

#region blog options
Redux::setSection( $opt_name, [
	'title' => __( 'Blog', 'sst' ),
	'id'    => 'blog',
	'desc'  => __( '', 'sst' ),
	'icon'  => 'el el-book'
] );
Redux::setSection( $opt_name, [
	'title'            => __( 'Defaults', 'sst' ),
	'id'               => 'default-blog',
	'subsection'       => true,
	'customizer_width' => '450px',
	'desc'             => __( 'Default settings for blog', 'sst' ),
	'fields'           => [
		[
			'id'      => 'blog-default-template',
			'type'    => 'select',
			'title'   => __( 'Choose template for blog', 'sst' ),
			'options' => [
				'blog'  => 'Default',
				'blog2' => 'Template without author name',
			]
		],
		[
			'id'    => 'blog-default-image',
			'type'  => 'media',
			'title' => __( 'Fallback image for blog', 'sst' ),
		],
		[
			'id'      => 'blog-enable-author-sidebar',
			'type'    => 'checkbox',
			'title'   => __( 'Display author name for blog detail page in sidebar', 'sst' ),
			'default' => '1'
		],
	]
] );
Redux::setSection( $opt_name, [
	'title'            => __( 'Exclude Categories', 'sst' ),
	'id'               => 'exclude-cat-blog',
	'subsection'       => true,
	'customizer_width' => '450px',
	'desc'             => __( 'Select categories lists that you want to exclude from lists, sidebar,etc. for blog', 'sst' ),
	'fields'           => [
		[
			'id'      => 'blog-exclude-cat',
			'type'    => 'select',
			'multi'   => true,
			'title'   => __( 'Select Categories', 'sst' ),
			'options' => categories_lists()
		],
	]
] );
#endregion

#region location options
Redux::setSection( $opt_name, [
	'title' => __( 'Locations', 'sst' ),
	'id'    => 'location',
	'desc'  => __( '', 'sst' ),
	'icon'  => 'el el-map-marker'
] );
Redux::setSection( $opt_name, [
	'title'            => __( 'Defaults', 'sst' ),
	'id'               => 'default-location',
	'subsection'       => true,
	'customizer_width' => '450px',
	'desc'             => __( 'Default settings for location', 'sst' ),
	'fields'           => [
		[
			'id'      => 'location-default-template',
			'type'    => 'select',
			'title'   => __( 'Choose template for location', 'sst' ),
			'options' => [
				'location'  => 'Default',
				'location2' => 'SST Location 2',
			]
		],
		[
			'id'    => 'location-default-title',
			'type'  => 'text',
			'title' => __( 'Title for location page', 'sst' ),
		],
		[
			'id'       => 'location-top-url',
			'type'     => 'text',
			'title'    => __( 'Button URL', 'sst' ),
			'validate' => 'url',
			'default'  => '/contact'
		],
		[
			'id'      => 'location-top-url-text',
			'type'    => 'text',
			'title'   => __( 'Button Text', 'sst' ),
			'default' => 'Contact Us'
		],
		[
			'id'      => 'google-geocoding-api-key',
			'type'    => 'text',
			'title'   => __( 'Google Geocoding Api Key', 'sst' )
		],
		[
			'id'    => 'location-default-content',
			'type'  => 'editor',
			'title' => __( 'Content for location page', 'sst' ),
			'args'  => [
				'teeny' => false,
			]
		],
	]
] );

#endregion

#region testimonial options
Redux::setSection( $opt_name, [
	'title' => __( 'Testimonial', 'sst' ),
	'id'    => 'testimonial',
	'desc'  => __( '', 'sst' ),
	'icon'  => 'el el-quote-right'
] );
Redux::setSection( $opt_name, [
	'title'            => __( 'Defaults', 'sst' ),
	'id'               => 'default-testimonial',
	'subsection'       => true,
	'customizer_width' => '450px',
	'desc'             => __( 'Default settings for testimonial', 'sst' ),
	'fields'           => [
		[
			'id'    => 'testimonial-default-image',
			'type'  => 'media',
			'title' => __( 'Default testimonial image', 'sst' ),
		],
	]
] );
#endregion

#region team options
Redux::setSection( $opt_name, [
	'title' => __( 'Team', 'sst' ),
	'id'    => 'team',
	'desc'  => __( '', 'sst' ),
	'icon'  => 'el el-group'
] );
Redux::setSection( $opt_name, [
	'title'            => __( 'Defaults', 'sst' ),
	'id'               => 'default-team',
	'subsection'       => true,
	'customizer_width' => '450px',
	'desc'             => __( 'Default settings for team list page', 'sst' ),
	'fields'           => [
		[
			'id'    => 'team-bg-image',
			'type'  => 'media',
			'title' => __( 'Default background image', 'sst' ),
		],
	]
] );
#endregion

#region Podcast options
Redux::setSection( $opt_name, [
	'title'            => __( 'Podcasts', 'sst' ),
	'id'               => 'podcast',
	'customizer_width' => '400px',
	'icon'             => 'el el-podcast'
] );
Redux::setSection( $opt_name, [
	'title'            => __( 'Podcast General', 'sst' ),
	'id'               => 'podcast-general',
	'subsection'       => true,
	'customizer_width' => '450px',
	'desc'             => __( 'Title and description for podcast', 'sst' ),
	'fields'           => [
		[
			'id'    => 'podcast-general-title',
			'type'  => 'text',
			'title' => __( 'Podcast Title', 'sst' ),
		],
		[
			'id'    => 'podcast-general-desc',
			'type'  => 'editor',
			'args'  => [
				'media_buttons' => false
			],
			'title' => __( 'Podcast Description', 'sst' ),
		],
		[
			'id'    => 'podcast-itunes-link',
			'type'  => 'text',
			'title' => __( 'Podcast Itunes Link', 'sst' ),
		],
		[
			'id'    => 'podcast-general-title-inner',
			'type'  => 'editor',
			'args'  => [
				'media_buttons' => false
			],
			'title' => __( 'Podcast Title for Detail Page (displays beside logo)', 'sst' ),
		],
		[
			'id'    => 'podcast-main-content',
			'type'  => 'editor',
			'title' => __( 'Podcast Main Content', 'sst' ),
		],
	]
] );
Redux::setSection( $opt_name, [
	'title'            => __( 'Podcast Logo', 'sst' ),
	'id'               => 'podcast-logo',
	'subsection'       => true,
	'customizer_width' => '450px',
	'desc'             => __( 'Logo for podcast list and detail page', 'sst' ),
	'fields'           => [
		[
			'id'    => 'podcast-logo',
			'type'  => 'media',
			'title' => __( 'Podcast Logo (for list)', 'sst' ),
		],
		[
			'id'    => 'podcast-logo-inner',
			'type'  => 'media',
			'title' => __( 'Podcast Logo (for single podcast page)', 'sst' ),
		],
	]
] );
Redux::setSection( $opt_name, [
	'title'            => __( 'Podcast Banner', 'sst' ),
	'id'               => 'podcast-banner',
	'subsection'       => true,
	'customizer_width' => '450px',
	'desc'             => __( 'Default banner for podcast list page', 'sst' ),
	'fields'           => [
		[
			'id'    => 'podcast-banner-content',
			'type'  => 'editor',
			'title' => __( 'Podcast Banner Content', 'sst' ),
			'args'  => [
				'media_buttons' => false
			]
		],
		[
			'id'    => 'podcast-banner-image',
			'type'  => 'media',
			'title' => __( 'Podcast Banner Image', 'sst' ),
		],
	]
] );
Redux::setSection( $opt_name, [
	'title'            => __( 'Podcast Guide', 'sst' ),
	'id'               => 'podcast-guide',
	'subsection'       => true,
	'customizer_width' => '450px',
	'desc'             => __( 'Default guide for all podcasts', 'sst' ),
	'fields'           => [
		[
			'id'    => 'podcast-guide-title',
			'type'  => 'text',
			'title' => __( 'Podcast Guide Title', 'sst' ),
		],
		[
			'id'    => 'podcast-guide-image',
			'type'  => 'media',
			'title' => __( 'Podcast Guide Book Image', 'sst' ),
		],
		[
			'id'    => 'podcast-guide-slug',
			'type'  => 'text',
			'title' => __( 'Podcast Guide Optinmonster slug', 'sst' ),
		],
	]
] );
#endregion

#region Remove Redux Demo
if ( ! function_exists( 'remove_demo' ) ) {
	function remove_demo() {
		if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
			remove_filter( 'plugin_row_meta', [
				ReduxFrameworkPlugin::instance(),
				'plugin_metalinks'
			], null, 2 );
			remove_action( 'admin_notices', [ ReduxFrameworkPlugin::instance(), 'admin_notices' ] );
		}
	}
}
add_action( 'redux/loaded', 'remove_demo' );
#endregion

function categories_lists() {
	$cat        = [];
	$categories = get_categories( [ 'orderby' => 'name' ] );
	foreach ( $categories as $category ):
		$cat[ $category->term_id ] = $category->name;
	endforeach;

	return $cat;
}