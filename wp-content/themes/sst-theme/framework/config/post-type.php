<?php

/**
 * Post meta field based on carbon post meta framework
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Custom Post Meta
 * @version 2.0.9
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

if ( ! function_exists( 'mok_post_type' ) ) {
	/**
	 * Returns list of post type
	 * @return array
	 */
	function mok_post_type() {
		return [
			'News'               => [
				'menu_icon' => 'dashicons-media-document',
				'supports'  => [ 'title', 'thumbnail', 'editor', 'excerpt' ]
			],
			'Press'              => [
				'menu_icon' => 'dashicons-media-document',
				'supports'  => [ 'title', 'thumbnail', 'editor' ],
				'labels'    => [
					'name'          => 'Press',
					'singular_name' => 'Press',
					'add_new'            => sprintf( __( 'Add New %s', '_mok' ), 'Press' ),
					'add_new_item'       => sprintf( __( 'Add New %s', '_mok' ), 'Press' ),
					'edit_item'          => sprintf( __( 'Edit %s', '_mok' ), 'Press' ),
					'new_item'           => sprintf( __( 'New %s', '_mok' ), 'Press' ),
					'all_items'          => sprintf( __( 'All %s', '_mok' ), 'Press' ),
					'view_item'          => sprintf( __( 'View %s', '_mok' ), 'Press' ),
					'search_items'       => sprintf( __( 'Search %s', '_mok' ), 'Press' ),
					'not_found'          => sprintf( __( 'No %s', '_mok' ), 'Press' ),
					'not_found_in_trash' => sprintf( __( 'No %s found in Trash', '_mok' ), 'Press' ),
					'parent_item_colon'  => sprintf( __( 'Parent %s:', '_mok' ), 'Press' ),
					'menu_name'          => 'Press',
				],
			],
			'Testimonials'       => [
				'show_in_nav_menus' => false,
				'menu_icon'         => 'dashicons-format-quote',
				'supports'          => [ 'title', 'thumbnail', 'editor' ],
				'rewrite'           => [ 'slug' => 'reviews' ],
				'labels'            => [
					'name'               => 'Reviews',
					'singular_name'      => 'Review',
					'add_new'            => sprintf( __( 'Add New %s', '_mok' ), 'Review' ),
					'add_new_item'       => sprintf( __( 'Add New %s', '_mok' ), 'Review' ),
					'edit_item'          => sprintf( __( 'Edit %s', '_mok' ), 'Review' ),
					'new_item'           => sprintf( __( 'New %s', '_mok' ), 'Review' ),
					'all_items'          => sprintf( __( 'All %s', '_mok' ), 'Reviews' ),
					'view_item'          => sprintf( __( 'View %s', '_mok' ), 'Review' ),
					'search_items'       => sprintf( __( 'Search %s', '_mok' ), 'Reviews' ),
					'not_found'          => sprintf( __( 'No %s', '_mok' ), 'Reviews' ),
					'not_found_in_trash' => sprintf( __( 'No %s found in Trash', '_mok' ), 'Reviews' ),
					'parent_item_colon'  => sprintf( __( 'Parent %s:', '_mok' ), 'Review' ),
					'menu_name'          => 'Reviews',
				]
			],
			'Podcast'            => [
				'show_in_nav_menus' => false,
				'menu_icon'         => 'dashicons-microphone',
				'supports'          => [ 'title', 'thumbnail', 'editor' ]
			],
			'Podcast Transcript' => [
				'show_in_nav_menus' => false,
				'menu_icon'         => 'dashicons-media-text',
				'supports'          => [ 'title', 'thumbnail', 'editor' ]
			],
			'Team'               => [
				'show_in_nav_menus' => false,
				'menu_icon'         => 'dashicons-groups',
				'supports'          => [ 'title', 'thumbnail', 'editor' ]
			],
			'Our Events'         => [
				'exclude_from_search' => true,
				'show_in_nav_menus'   => false,
				'menu_icon'           => 'dashicons-calendar-alt',
				'supports'            => [ 'title', 'thumbnail', 'editor', 'excerpt' ],
				'show_in_rest'        => true,
				'rest_base'           => 'events-api'
			],
			'Location'           => [
				'show_in_nav_menus' => false,
				'menu_icon'         => 'dashicons-location',
				'supports'          => [ 'title', 'thumbnail', 'editor' ]
			],
			'Job'                => [
				'show_in_nav_menus' => false,
				'menu_icon'         => 'dashicons-nametag',
				'supports'          => [ 'title', 'thumbnail', 'editor', 'excerpt' ],
				'rewrite'           => [ 'slug' => 'available-jobs' ],
			]
		];
	}
}
add_filter( 'mok_custom_post_type', 'mok_post_type' );

if ( ! function_exists( 'mok_taxonomy' ) ) {
	/**
	 * Registers taxonomy for selected post type
	 * @return array
	 */
	function mok_taxonomy() {
		return [
			'location' => [
				'type' => [ 'show_admin_column' => true ]
			]
		];
	}
}

add_filter( 'mok_custom_taxonomy', 'mok_taxonomy' );
