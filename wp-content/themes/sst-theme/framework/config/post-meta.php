<?php

/**
 * Post meta field based on CMB2 framework
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Custom Post Meta
 * @version 2.0.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

/**
 * @var string prefix for post meta field name
 */
global $prefix;
$prefix = '_qwl';

/**
 * Filter to show post meta field on front page
 *
 * @param $display
 * @param $meta_box
 *
 * @return bool
 */
function mok_front_page( $display, $meta_box ) {
	if ( ! isset( $meta_box['show_on']['key'] ) ) {
		return $display;
	}

	if ( 'front-page' !== $meta_box['show_on']['key'] ) {
		return $display;
	}

	$post_id = 0;

	// If we're showing it based on ID, get the current ID
	if ( isset( $_GET['post'] ) ) {
		$post_id = $_GET['post'];
	} elseif ( isset( $_POST['post_ID'] ) ) {
		$post_id = $_POST['post_ID'];
	}

	if ( ! $post_id ) {
		return false;
	}

	// Get ID of page set as front page, 0 if there isn't one
	$front_page = get_option( 'page_on_front' );

	// there is a front page set and we're on it!
	return $post_id == $front_page;
}

add_filter( 'cmb2_show_on', 'mok_front_page', 10, 2 );

/**
 * Returns list of podcast
 * @return array
 */
function mok_podcast_list() {
	$query = new WP_Query( [
		'post_type'      => 'podcast',
		'post_status'    => 'publish',
		'posts_per_page' => - 1,
	] );
	$lists = [];
	while ( $query->have_posts() ): $query->the_post();
		$lists[ get_the_ID() ] = get_the_title();
	endwhile;
	wp_reset_postdata();

	return $lists;
}

#region Top Banner section with revolution slider (for template with revolution slider)
if ( ! function_exists( 'mok_banner_rev' ) ) {
	/**
	 * Top Banner section with revolution slider (for template with revolution slider)
	 */
	function mok_banner_rev() {
		global $prefix;
		$rev_banner = new_cmb2_box( [
			'id'           => $prefix . '_rev_banner',
			'title'        => __( 'Top Banner Section', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_rev_slider.php',
					'templates/template-qwl_home_rev_slider.php',
				],
			],
		] );
		$rev_banner->add_field( [
			'name' => __( 'ShortCode of Revolutionary Slider - Banner', $prefix ),
			'desc' => __( 'Please edit <a href="/wp-admin/admin.php?page=revslider" target="_blank">revolution slider</a> and paste shortcode generated here.',
				$prefix ),
			'id'   => $prefix . '_revolutionary_banner_shortcode',
			'type' => 'text',
		] );

		$rev_banner->add_field( [
			'name'    => __( 'Mobile Banner Image', $prefix ),
			'desc'    => __( 'Please upload your banner image here. [Image size: (768 X 400)px]',
				$prefix ),
			'id'      => $prefix . '_mobile_banner_image',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );

		$rev_banner->add_field( [
			'name' => __( 'Mobile Banner Content', $prefix ),
			'desc' => __( 'Enter your banner content here.', $prefix ),
			'id'   => $prefix . '_mobile_banner_content',
			'type' => 'wysiwyg',
		] );

		###TEAM MEMBER METABOXES AND ADDITIONAL FIELDS
		$team = new_cmb2_box( [
			'id'           => $prefix . '_team',
			'title'        => __( 'Team Detail', $prefix ),
			'object_types' => [ 'team' ],
			'priority'     => 'high'
		] );

		$team->add_field( [
			'name' => __( 'Designation', $prefix ),
			'desc' => __( 'Please enter team member\'s designation', $prefix ),
			'id'   => $prefix . '_team_designation',
			'type' => 'text'
		] );

		$team->add_field( [
			'name' => __( 'Team Content', $prefix ),
			'desc' => __( 'Please enter content for team detail', $prefix ),
			'id'   => $prefix . '_team_content',
			'type' => 'wysiwyg',
		] );
	}
}
add_action( 'cmb2_admin_init', 'mok_banner_rev' );
#endregion

#region Top Banner for home pages, service, sub service, event details, team, community, city
if ( ! function_exists( 'mok_banner_normal' ) ) {
	/**
	 * Top Banner for home pages, service, sub service, event details, team, community, city
	 */
	function mok_banner_normal() {
		global $prefix;
		$banner = new_cmb2_box( [
			'id'           => $prefix . '_banner',
			'title'        => __( 'Top Banner Section', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_fancy.php',
					'templates/template-sst_home_fancy-2.php',
					'templates/template-sst_home7.php',
					'templates/template-sst_home.php',
					'templates/template-sst_home1.php',
					'templates/template-sst_home_je.php',
					'templates/template-sst_home_service.php',
					'templates/template-sst_home_subservice.php',
					'templates/template-sst_home_supercity.php',
					'templates/template-sst_home_city.php',
					'templates/template-sst_home_re1.php',
					'templates/template-sst_community.php',
					'templates/template-sst-home6.php',
					'templates/template-sst_e-commercehome1.php',
					'templates/template-sst-ambassador.php',
					'templates/template-sst_event_detail.php',
					'templates/template-sst_team_template.php',
					'templates/template-sst_home1_services.php',
					'templates/template-sst_property_listing.php',
				],
			],
		] );
		$banner->add_field( [
			'name'    => __( 'Banner List', $prefix ),
			'desc'    => __( 'Banner List', $prefix ),
			'id'      => $prefix . '_banner_group',
			'type'    => 'group',
			'options' => [
				'group_title'   => __( 'Banner {#}', $prefix ),
				'add_button'    => __( 'Add Another Banner', $prefix ),
				'remove_button' => __( 'Remove banner', $prefix ),
				'sortable'      => true,
			],
			'fields'  => [
				[
					'name'    => __( 'Banner Image', $prefix ),
					'desc'    => __( 'Upload an image', $prefix ),
					'id'      => $prefix . '_banner_img',
					'type'    => 'file',
					'options' => [
						'url' => false,
					],
				],
				[
					'name'    => __( 'Font Color', $prefix ),
					'desc'    => __( 'Please select font color', $prefix ),
					'id'      => $prefix . '_banner_font_color_class',
					'type'    => 'select',
					'default' => 'dark',
					'options' => [
						'light' => __( 'Light Color', $prefix ),
						'theme' => __( 'Theme Color', $prefix ),
						'dark'  => __( 'Dark Color', $prefix ),
					],
				],
				[
					'name'    => __( 'Content Alignment', $prefix ),
					'desc'    => __( 'Please select content alignment', $prefix ),
					'id'      => $prefix . '_banner_content_alignment_class',
					'type'    => 'select',
					'default' => 'center',
					'options' => [
						'left'   => __( 'Align Left', $prefix ),
						'center' => __( 'Align Center', $prefix ),
					],
				],
				[
					'name' => __( 'Banner Heading', $prefix ),
					'desc' => __( 'Add banner heading', $prefix ),
					'id'   => $prefix . '_banner_heading',
					'type' => 'wysiwyg',
				],
				[
					'name' => __( 'Banner Paragraph', $prefix ),
					'desc' => __( 'Add banner paragraph', $prefix ),
					'id'   => $prefix . '_banner_para',
					'type' => 'wysiwyg',
				],
				[
					'name' => __( 'Banner button text', $prefix ),
					'desc' => __( 'Add banner button text', $prefix ),
					'id'   => $prefix . '_banner_btn_txt',
					'type' => 'text',
				],
				[
					'name'      => __( 'Banner button URL', $prefix ),
					'desc'      => __( 'field description (optional)', $prefix ),
					'id'        => $prefix . '_banner_btn_url',
					'type'      => 'text_url',
					'protocols' => [ 'http', 'https' ],
				],
				[
					'name' => __( 'Optin Monster Slug for banner button', $prefix ),
					'desc' => __( 'Optin Monster slug will take priority over banner button URL', $prefix ),
					'id'   => $prefix . '_banner_btn_optin',
					'type' => 'text',
				],
			],
		] );
		$banner->add_field( [
			'name'    => __( 'Mobile Banner Image', $prefix ),
			'desc'    => __( 'Please upload your banner image here. [Image size: (768 X 400)px]',
				$prefix ),
			'id'      => $prefix . '_mobile_banner_image',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$banner->add_field( [
			'name' => __( 'Mobile Banner Content', $prefix ),
			'desc' => __( 'Enter your banner content here.', $prefix ),
			'id'   => $prefix . '_mobile_banner_content',
			'type' => 'wysiwyg',
		] );
	}
}
add_action( 'cmb2_admin_init', 'mok_banner_normal' );
#endregion

#region Pop up form that uses Gravity form shortcode
if ( ! function_exists( 'mok_evaluation_form' ) ) {
	/**
	 * Pop up form that uses Gravity form shortcode
	 */
	function mok_evaluation_form() {
		$prefix = '_ttm';

		$eval_form = new_cmb2_box( [
			'id'           => $prefix . '_popup',
			'title'        => __( 'Popup Form', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_re1.php',
					'templates/template-sst_home_fancy.php',
					'templates/template-sst_home_fancy-2.php',
					'templates/template-sst_home7.php',
					'templates/template-sst_home.php',
					'templates/template-sst_home1.php',
					'templates/template-sst_home1_services.php',
				],
			],
		] );

		$eval_form->add_field( [
			'name' => __( 'Gravity Form Shortcode', $prefix ),
			'desc' => __( 'Please enter gravity form shortcode', $prefix ),
			'id'   => $prefix . '_popup_content',
			'type' => 'text',
		] );

	}
}
add_action( 'cmb2_admin_init', 'mok_evaluation_form' );
#endregion

#region Top banner section for real estate template
if ( ! function_exists( 'mok_banner_estate' ) ) {
	/**
	 * Top banner section for real estate template
	 */
	function mok_banner_estate() {
		global $prefix;
		$estate_banner = new_cmb2_box( [
			'id'           => $prefix . '_estate_banner',
			'title'        => __( 'Top Banner Section', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_real_estate_home.php'
			],
		] );

		$estate_banner->add_field( [
			'name'    => __( 'Banner Image', $prefix ),
			'desc'    => __( 'Upload an image', $prefix ),
			'id'      => $prefix . '_estate_banner_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );

		$estate_banner->add_field( [
			'name' => __( 'Banner Content', $prefix ),
			'desc' => __( 'Add banner Content', $prefix ),
			'id'   => $prefix . '_estate_banner_content',
			'type' => 'wysiwyg',
		] );

		$estate_banner->add_field( [
			'name' => __( 'Banner button text', $prefix ),
			'desc' => __( 'Add banner button text', $prefix ),
			'id'   => $prefix . '_estate_banner_btn_txt',
			'type' => 'text',
		] );

		$estate_banner->add_field( [
			'name'      => __( 'Banner button URL', $prefix ),
			'desc'      => __( 'field description (optional)', $prefix ),
			'id'        => $prefix . '_estate_banner_btn_url',
			'type'      => 'text_url',
			'protocols' => [ 'http', 'https' ],
		] );
	}
}
add_action( 'cmb2_admin_init', 'mok_banner_estate' );
#endregion

if ( ! function_exists( 'mok_meta_boxes' ) ) {
	/**
	 * Post meta for
	 * Guide Book Section
	 * Homes Listing Slider for real estate and community template
	 * Four Column Section (Below Guide)
	 * Owner introduction section (below home listing slider for real estate)
	 * Call to action button (below owner section for real estate template)
	 * Infographic Content
	 * Podcast infographics
	 * Podcast Episode
	 * Podcast files
	 * podcast transcript meta box
	 * Section with left image (Below content)
	 * Section with text center aligned (Below Content)
	 * Section with text left aligned (Below content)
	 * Section with image right (Below content)
	 * Google Map for contact us template
	 * Contact information for contact us template
	 * Testimonial author details
	 * Communities List (below property listings) for real estate template
	 * Section (with image left, below Communities List) for real estate template
	 * Section (with no image below three columns section) for real estate template
	 * Community list section for community template
	 * User profile meta box
	 * location details for SST Location Template
	 * location details for SST Location Home Template
	 * Find out more widget
	 * Special logos section
	 * Page theme Option
	 * Top Menu phone number
	 */
	function mok_meta_boxes() {

		global $prefix;
		#region Guide Book Section
		$guide = new_cmb2_box( [
			'id'           => $prefix . '_guide',
			'title'        => __( 'Guide Section', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_fancy.php',
					'templates/template-sst_home_fancy-2.php',
					'templates/template-sst_home7.php',
					'templates/template-sst_home8.php',
					'templates/template-sst_e-commercehome1.php',
					'templates/template-sst-ambassador.php',
					'templates/template-sst_home_rev_slider.php',
					'templates/template-sst_home.php',
					'templates/template-sst_home1.php',
					'templates/template-sst_home_je.php',
					'templates/template-sst_home_service.php',
					'templates/template-sst_home_subservice.php',
					'templates/template-sst_home_supercity.php',
					'templates/template-sst_home_city.php',
					'templates/template-sst_home_re1.php',
					'templates/template-sst_community.php',
					'templates/template-sst_real_estate_home.php',
					'templates/template-sst-home6.php',
					'templates/template-sst_event_detail.php',
					'templates/template-sst_team_template.php',
					'templates/template-sst_home1_services.php',
					'templates/template-sst_property_listing.php'
				],
			],
		] );
		$guide->add_field( [
			'name'    => __( 'Guide Book Image', $prefix ),
			'desc'    => __( 'Upload an image', $prefix ),
			'id'      => $prefix . '_guide_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$guide->add_field( [
			'name'            => __( 'Guide Content', $prefix ),
			'desc'            => __( 'Guide Content', $prefix ),
			'id'              => $prefix . '_guide_content',
			'type'            => 'wysiwyg',
			'sanitization_cb' => 'wp_kses_post',
			'escape_cb'       => 'wp_kses_post'
		] );
		$guide->add_field( [
			'name' => __( 'Guide Button Label', $prefix ),
			'desc' => __( 'Please enter guide button label', $prefix ),
			'id'   => $prefix . '_guide_btn_txt',
			'type' => 'text',
		] );
		$guide->add_field( [
			'name' => __( 'Guide URL', $prefix ),
			'desc' => __( 'Please enter guide button URL (if you aren\'t using Opt-in monster)', $prefix ),
			'id'   => $prefix . '_guide_url',
			'type' => 'text',
		] );
		$guide->add_field( [
			'name' => __( 'Opt-in monster Slug', $prefix ),
			'desc' => __( 'Please enter optin monster slug', $prefix ),
			'id'   => $prefix . '_guide_slug',
			'type' => 'text',
		] );
		#endregion
		#region As seen on Section
		$asseenon = new_cmb2_box( [
			'id'           => $prefix . '_asseenon',
			'title'        => __( 'As Seen On', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_fancy.php',
					'templates/template-sst_home_fancy-2.php',
					'templates/template-sst_home7.php',
					'templates/template-sst_home8.php',
					'templates/template-sst_e-commercehome1.php',
					'templates/template-sst-ambassador.php',
					'templates/template-sst_home_as_seen_on.php',
					'templates/template-sst_home_rev_slider.php',
					'templates/template-sst_home.php',
					'templates/template-sst_home1.php',
					'templates/template-sst_home_je.php',
					'templates/template-sst_home_service.php',
					'templates/template-sst_home_subservice.php',
					'templates/template-sst_home_supercity.php',
					'templates/template-sst_home_city.php',
					'templates/template-sst_home_re1.php',
					'templates/template-sst_community.php',
					'templates/template-sst_real_estate_home.php',
					'templates/template-sst-home6.php',
					'templates/template-sst_event_detail.php',
					'templates/template-sst_team_template.php',
					'templates/template-sst_home1_services.php',
					'templates/template-sst_property_listing.php'
				],
			],
		] );
		$asseenon->add_field( [
			'name' => __( 'As Seen On Heading', $prefix ),
			'desc' => __( 'Please enter As seen on heading', $prefix ),
			'id'   => $prefix . '_seen_heading',
			'type' => 'text',
		] );
		$asseenon->add_field( [
			'name'            => __( 'As Seen On Content', $prefix ),
			'desc'            => __( 'As Seen On Content', $prefix ),
			'id'              => $prefix . '_seen_content',
			'type'            => 'wysiwyg',
			'sanitization_cb' => 'wp_kses_post',
			'escape_cb'       => 'wp_kses_post'
		] );
		#endregion
				#region Notable Clients Section
		$notableclients = new_cmb2_box( [
			'id'           => $prefix . '_notableclients',
			'title'        => __( 'Notable Clients', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_fancy.php',
					'templates/template-sst_home_fancy-2.php',
					'templates/template-sst_home7.php',
					'templates/template-sst_home8.php',
					'templates/template-sst_e-commercehome1.php',
					'templates/template-sst-ambassador.php',
					'templates/template-sst_home_as_seen_on.php',
					'templates/template-sst_home_rev_slider.php',
					'templates/template-sst_home.php',
					'templates/template-sst_home1.php',
					'templates/template-sst_home_je.php',
					'templates/template-sst_home_service.php',
					'templates/template-sst_home_subservice.php',
					'templates/template-sst_home_supercity.php',
					'templates/template-sst_home_city.php',
					'templates/template-sst_home_re1.php',
					'templates/template-sst_community.php',
					'templates/template-sst_real_estate_home.php',
					'templates/template-sst-home6.php',
					'templates/template-sst_event_detail.php',
					'templates/template-sst_team_template.php',
					'templates/template-sst_home1_services.php',
					'templates/template-sst_property_listing.php'
				],
			],
		] );
		$notableclients->add_field( [
			'name' => __( 'Notable Clients Heading', $prefix ),
			'desc' => __( 'Please Enter Notable Clients Heading', $prefix ),
			'id'   => $prefix . '_notable_heading',
			'type' => 'text',
		] );
		$notableclients->add_field( [
			'name'            => __( 'Notable Clients Content', $prefix ),
			'desc'            => __( 'Notable Clients Content', $prefix ),
			'id'              => $prefix . '_notable_content',
			'type'            => 'wysiwyg',
			'sanitization_cb' => 'wp_kses_post',
			'escape_cb'       => 'wp_kses_post'
		] );
		#endregion

		#region Homes Listing Slider for real estate and community template
		$homes_carousel_list = new_cmb2_box( [
			'id'           => '_homes_listing',
			'title'        => __( 'Homes Listing Slider (below guide book section)', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_re1.php',
					'templates/template-sst_community.php',
					'templates/template-sst_real_estate_home.php'
				],
			],
		] );
		$homes_carousel_list->add_field( [
			'name'    => __( 'Home Listing Group', $prefix ),
			'desc'    => __( 'Home Listing Group', $prefix ),
			'id'      => '_homes_listing_group_id',
			'type'    => 'group',
			'options' => [
				'add_button'    => __( 'Add More List', $prefix ),
				'remove_button' => __( 'Remove List', $prefix ),
				'sortable'      => true,
			],
			'fields'  => [
				[
					'name' => __( 'Item', $prefix ),
					'id'   => '_homes_listing_name',
					'type' => 'text',
				],
				[
					'name' => __( 'Item Link', $prefix ),
					'id'   => '_homes_listing_link',
					'type' => 'text',
				],
			],
		] );
		#endregion

		#region Four Column Section (Below Guide)
		$column = new_cmb2_box( [
			'id'           => $prefix . '_four_columns1',
			'title'        => __( 'Four Column Section', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_fancy.php',
					'templates/template-sst_home_fancy-2.php',
					'templates/template-sst_home7.php',
					'templates/template-sst_home8.php',
					'templates/template-sst_home_rev_slider.php',
					'templates/template-sst_home.php',
					'templates/template-sst_home_je.php',
					'templates/template-sst_home_re1.php',
					'templates/template-sst_home_service.php',
					'templates/template-sst_home_subservice.php',
					'templates/template-sst_home_supercity.php',
					'templates/template-sst_home_city.php',
					'templates/template-sst_home1.php',
					'templates/template-sst-home6.php',
					'templates/template-sst_event_detail.php',
					'templates/template-sst_home1_services.php',
				],
			],
		] );
		$column->add_field( [
			'name'    => __( 'First Column Icon', $prefix ),
			'desc'    => __( 'First Column Icon', $prefix ),
			'id'      => $prefix . '_four_columns1_column1_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$column->add_field( [
			'name'    => __( 'First Column Icon', $prefix ),
			'desc'    => __( 'First Column Icon', $prefix ),
			'id'      => $prefix . '_four_columns1_column1_icon',
			'type'    => 'select',
			'options' => mok_get_icon_list(),
		] );
		$column->add_field( [
			'name' => __( 'First Column Icon Alt', $prefix ),
			'desc' => __( 'First Column Icon Alt', $prefix ),
			'id'   => $prefix . '_four_columns1_column1_icon_alt',
			'type' => 'text',
		] );
		$column->add_field( [
			'name' => __( 'First Column URL', $prefix ),
			'desc' => __( 'First Column URL', $prefix ),
			'id'   => $prefix . '_four_columns1_column1_link',
			'type' => 'text_url',
		] );
		$column->add_field( [
			'name' => __( 'First Column Content', $prefix ),
			'desc' => __( 'First Column Content', $prefix ),
			'id'   => $prefix . '_four_columns1_column1_content',
			'type' => 'wysiwyg',
		] );
		$column->add_field( [
			'name'    => __( 'Second Column Icon', $prefix ),
			'desc'    => __( 'Second Column Icon', $prefix ),
			'id'      => $prefix . '_four_columns1_column2_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$column->add_field( [
			'name'    => __( 'Second Column Icon', $prefix ),
			'desc'    => __( 'Second Column Icon', $prefix ),
			'id'      => $prefix . '_four_columns1_column2_icon',
			'type'    => 'select',
			'options' => mok_get_icon_list(),
		] );
		$column->add_field( [
			'name' => __( 'Second Column Icon Alt', $prefix ),
			'desc' => __( 'Second Column Icon Alt for above icon only', $prefix ),
			'id'   => $prefix . '_four_columns1_column2_icon_alt',
			'type' => 'text',
		] );
		$column->add_field( [
			'name' => __( 'Second Column URL', $prefix ),
			'desc' => __( 'Second Column URL', $prefix ),
			'id'   => $prefix . '_four_columns1_column2_link',
			'type' => 'text_url',
		] );
		$column->add_field( [
			'name' => __( 'Second Column Content', $prefix ),
			'desc' => __( 'Second Column Content', $prefix ),
			'id'   => $prefix . '_four_columns1_column2_content',
			'type' => 'wysiwyg',
		] );
		$column->add_field( [
			'name'    => __( 'Third Column Icon', $prefix ),
			'desc'    => __( 'Third Column Icon', $prefix ),
			'id'      => $prefix . '_four_columns1_column3_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],

		] );
		$column->add_field( [
			'name'    => __( 'Third Column Icon', $prefix ),
			'desc'    => __( 'Third Column Icon', $prefix ),
			'id'      => $prefix . '_four_columns1_column3_icon',
			'type'    => 'select',
			'options' => mok_get_icon_list(),
		] );
		$column->add_field( [
			'name' => __( 'Third Column Icon Alt', $prefix ),
			'desc' => __( 'Third Column Icon Alt for above icon only', $prefix ),
			'id'   => $prefix . '_four_columns1_column3_icon_alt',
			'type' => 'text',
		] );
		$column->add_field( [
			'name' => __( 'Third Column URL', $prefix ),
			'desc' => __( 'Third Column URL', $prefix ),
			'id'   => $prefix . '_four_columns1_column3_link',
			'type' => 'text_url',
		] );
		$column->add_field( [
			'name' => __( 'Third Column Content', $prefix ),
			'desc' => __( 'Third Column Content', $prefix ),
			'id'   => $prefix . '_four_columns1_column3_content',
			'type' => 'wysiwyg',
		] );
		$column->add_field( [
			'name'    => __( 'Fourth Column Icon', $prefix ),
			'desc'    => __( 'Fourth Column Icon', $prefix ),
			'id'      => $prefix . '_four_columns1_column4_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$column->add_field( [
			'name'    => __( 'Fourth Column Icon', $prefix ),
			'desc'    => __( 'Fourth Column Icon', $prefix ),
			'id'      => $prefix . '_four_columns1_column4_icon',
			'type'    => 'select',
			'options' => mok_get_icon_list(),
		] );
		$column->add_field( [
			'name' => __( 'Fourth Column Icon Alt', $prefix ),
			'desc' => __( 'Fourth Column Icon Alt Text for above field only', $prefix ),
			'id'   => $prefix . '_four_columns1_column4_icon_alt',
			'type' => 'text',
		] );
		$column->add_field( [
			'name' => __( 'Fourth Column URL', $prefix ),
			'desc' => __( 'Fourth Column URL', $prefix ),
			'id'   => $prefix . '_four_columns1_column4_link',
			'type' => 'text_url',
		] );
		$column->add_field( [
			'name' => __( 'Fourth Column Content', $prefix ),
			'desc' => __( 'Fourth Column Content', $prefix ),
			'id'   => $prefix . '_four_columns1_column4_content',
			'type' => 'wysiwyg',
		] );
		#endregion

		#region Owner introduction section (below home listing slider for real estate)
		$intro_home = new_cmb2_box( [
			'id'      => $prefix . '_owner_intro',
			'title'   => __( 'Owner Introduction Section (below home listing slider)', $prefix ),
			'show_on' => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_re1.php',
					'templates/template-sst_real_estate_home.php'
				],
			],
		] );
		$intro_home->add_field( [
			'name' => __( 'Content', $prefix ),
			'desc' => __( 'Please enter content', $prefix ),
			'id'   => $prefix . '_owner_intro_content',
			'type' => 'wysiwyg',
		] );
		$intro_home->add_field( [
			'name'    => __( 'Image', $prefix ),
			'desc'    => __( 'Please upload image', $prefix ),
			'id'      => $prefix . '_owner_intro_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		#endregion

		#region Call to action button (below owner section for real estate template)
		$call_to_action = new_cmb2_box( [
			'id'           => $prefix . '_coa_id',
			'title'        => __( 'Call to Action Section', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_re1.php',
					'templates/template-sst_real_estate_home.php'
				],
			],
		] );
		$call_to_action->add_field( [
			'name' => __( 'Call to Action Section', $prefix ),
			'desc' => __( 'Call to Action Section Content', $prefix ),
			'id'   => $prefix . '_coa_content',
			'type' => 'wysiwyg',
		] );
		#endregion

		#region Infographic Content
		$sst_content = new_cmb2_box( [
			'id'           => $prefix . '_infographic_id',
			'title'        => __( 'Infographic Content (use this code in editor &lt;div class="article-assets"&gt;[slide][infographic]&lt;/div&gt;)', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_fancy.php',
					'templates/template-sst_home_fancy-2.php',
					'templates/template-sst_home7.php',
					'templates/template-sst_home_rev_slider.php',
					'templates/template-sst_home.php',
					'templates/template-sst_home1.php',
					'templates/template-sst_home_je.php',
					'templates/template-sst_home_service.php',
					'templates/template-sst_home_subservice.php',
					'templates/template-sst_home_supercity.php',
					'templates/template-sst_home_city.php',
					'templates/template-sst-home6.php',
					'templates/template-sst_home1_services.php',
				],
			],
			'context'      => 'normal',
		] );
		$sst_content->add_field( [
			'name' => __( 'SlideShare Button Title', $prefix ),
			'desc' => __( 'Name for SlideShare tag', $prefix ),
			'id'   => $prefix . '_info_slide_title',
			'type' => 'text',
		] );
		$sst_content->add_field( [
			'name'    => __( 'Image for SlideShare Image', $prefix ),
			'desc'    => __( 'Image for SlideShare tag', $prefix ),
			'id'      => $prefix . '_info_slide_image',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$sst_content->add_field( [
			'name' => __( 'Link of the SlideShare', $prefix ),
			'desc' => __( 'Link of the SlideShare that is supposed to be displayed', $prefix ),
			'id'   => $prefix . '_info_slide_link',
			'type' => 'oembed',
		] );
		$sst_content->add_field( [
			'name' => __( 'Slideshare Shortcode', $prefix ),
			'desc' => __( 'Wordpress Short Code from Slideshare.com', $prefix ),
			'id'   => $prefix . '_slideshare_shortcode',
			'type' => 'text',
		] );
		$sst_content->add_field( [
			'name' => __( 'Slideshow slider images', $prefix ),
			'desc' => __( 'Multiple images for Slideshow', $prefix ),
			'id'   => $prefix . '_slideshow_slider',
			'type' => 'text',
		] );
		$sst_content->add_field( [
			'name' => __( 'Infographic Title', $prefix ),
			'desc' => __( 'Name for infographic tag', $prefix ),
			'id'   => $prefix . '_info_graphic_title',
			'type' => 'text',
		] );
		$sst_content->add_field( [
			'name'    => __( 'Infographic Image', $prefix ),
			'desc'    => __( 'Image for infographic tag', $prefix ),
			'id'      => $prefix . '_info_graphic_image',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$sst_content->add_field( [
			'name' => __( 'Infographic Image List', $prefix ),
			'desc' => __( 'Image list for infographic tag', $prefix ),
			'id'   => $prefix . '_info_graphic_image_list',
			'type' => 'file_list',
		] );
		$sst_content->add_field( [
			'name' => __( 'Revolution Slider Shortcode', $prefix ),
			'desc' => __( 'Short Code for Revolution Slider', $prefix ),
			'id'   => $prefix . '_info_graphic_revolutionary_slider_short_code',
			'type' => 'text',
		] );
		#endregion

		#region Podcast infographics
		$podcast = new_cmb2_box( [
			'id'           => $prefix . '_podcast_infographic_id',
			'title'        => __( 'Infographic Content', $prefix ),
			'object_types' => [ 'podcast' ],
			'priority'     => 'low',
		] );

		$podcast->add_field( [
			'name' => __( 'SlideShare Button Title', $prefix ),
			'desc' => __( 'Name for SlideShare tag', $prefix ),
			'id'   => $prefix . '_info_slide_title',
			'type' => 'text',
		] );

		$podcast->add_field( [
			'name'    => __( 'Image for SlideShare Image', $prefix ),
			'desc'    => __( 'Image for SlideShare tag', $prefix ),
			'id'      => $prefix . '_info_slide_image',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );

		$podcast->add_field( [
			'name' => __( 'Link of the SlideShare', $prefix ),
			'desc' => __( 'Link of the SlideShare that is supposed to be displayed', $prefix ),
			'id'   => $prefix . '_info_slide_link',
			'type' => 'oembed',
		] );

		$podcast->add_field( [
			'name' => __( 'Infographic Title', $prefix ),
			'desc' => __( 'Name for infographic tag', $prefix ),
			'id'   => $prefix . '_info_graphic_title',
			'type' => 'text',
		] );

		$podcast->add_field( [
			'name'    => __( 'Infographic Image', $prefix ),
			'desc'    => __( 'Image for infographic tag', $prefix ),
			'id'      => $prefix . '_info_graphic_image',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );

		$podcast->add_field( [
			'name' => __( 'Infographic Image List', $prefix ),
			'desc' => __( 'Image list for infographic tag', $prefix ),
			'id'   => $prefix . '_info_graphic_image_list',
			'type' => 'file_list',
		] );
		$podcast->add_field( [
			'name' => __( 'Revolution Slider Shortcode Field', $prefix ),
			'desc' => __( 'Short Code for Revolutionary Slider', $prefix ),
			'id'   => $prefix . '_info_graphic_revolutionary_slider_short_code',
			'type' => 'text',
		] );
		#endregion

		#region Podcast Episode
		$podcast_episode = new_cmb2_box( [
			'id'           => $prefix . '_podcast_episode_id',
			'title'        => __( 'Podcast Episode', $prefix ),
			'object_types' => [ 'podcast' ],
			'context'      => 'side',
			'priority'     => 'low',
		] );

		$podcast_episode->add_field( [
			'name' => __( 'Podcast Episode Count', $prefix ),
			'desc' => __( 'Episode Number of the podcast.', $prefix ),
			'id'   => $prefix . '_episode_count',
			'type' => 'text_small',
		] );
		#endregion

		#region Podcast files
		$podcast_audio = new_cmb2_box( [
			'id'           => $prefix . '_podcast_audio_file',
			'title'        => __( 'Podcast File', $prefix ),
			'object_types' => [ 'podcast' ],
			'priority'     => 'high',
		] );

		$podcast_audio->add_field( [
			'name'    => __( 'Podcast Audio File', $prefix ),
			'desc'    => __( 'Upload .mp3 file for the podcast', $prefix ),
			'id'      => $prefix . '_audio_file',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$podcast_audio->add_field( [
			'name'            => __( 'Link to Podcast Transcript', $prefix ),
			'desc'            => __( 'Enter a ID of podcast transcript. Or click the magnifying glass to search for content.', $prefix ),
			'id'              => $prefix . '_podcast_trans_id',
			'type'            => 'post_search_text',
			'post_type'       => 'podcast-transcript',
			'select_type'     => 'radio',
			'select_behavior' => 'replace'
		] );
		$podcast_audio->add_field( [
			'name' => __( 'Podcast Video URL', $prefix ),
			'desc' => __( 'Youtube URL link here.', $prefix ),
			'id'   => $prefix . '_video_url',
			'type' => 'oembed',
		] );

		$podcast_audio->add_field( [
			'name'    => __( 'Alternate Screenshot for Video', $prefix ),
			'desc'    => __( 'Upload Alternate Screenshot for Video', $prefix ),
			'id'      => $prefix . '_video_screenshot',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		#endregion

		#region podcast transcript meta box
		$podcast_transcript = new_cmb2_box( [
			'id'           => $prefix . '_podcast_meta',
			'title'        => __( 'Podcast', $prefix ),
			'object_types' => [ 'podcast-transcript' ],
			'priority'     => 'low',
		] );
		$podcast_transcript->add_field( [
			'name'            => __( 'Link to Podcast', $prefix ),
			'desc'            => __( 'Enter a ID of podcast. Or click the magnifying glass to search for content.', $prefix ),
			'id'              => $prefix . '_podcast_id',
			'type'            => 'post_search_text',
			'post_type'       => 'podcast',
			'select_type'     => 'radio',
			'select_behavior' => 'replace'
		] );
		#endregion

		#region Section with left image (Below content)
		$section1 = new_cmb2_box( [
			'id'           => $prefix . '_section1_id',
			'title'        => __( 'Section with left image (Below content)', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_rev_slider.php',
					'templates/template-sst_home.php',
					'templates/template-sst_home_je.php',
					'templates/template-sst_home_service.php',
					'templates/template-sst_home_subservice.php',
					'templates/template-sst_home_supercity.php',
					'templates/template-sst_home_city.php',
					'templates/template-sst-home6.php',
					'templates/template-sst_event_detail.php'
				],
			],
		] );
		$section1->add_field( [
			'name'    => __( 'Image', $prefix ),
			'desc'    => __( 'Please upload / select the image for the section', $prefix ),
			'id'      => $prefix . '_section1_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$section1->add_field( [
			'name' => __( 'Content', $prefix ),
			'desc' => __( 'Please enter the content for business bible section', $prefix ),
			'id'   => $prefix . '_section1_content',
			'type' => 'wysiwyg',
		] );
		#endregion

		#region Section with text center aligned (Below Content)
		$section2 = new_cmb2_box( [
			'id'           => $prefix . '_section2_id',
			'title'        => __( 'Section with text center aligned (below content)', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_rev_slider.php',
					'templates/template-sst_home.php',
					'templates/template-sst_home_je.php',
					'templates/template-sst_home_service.php',
					'templates/template-sst_home_subservice.php',
					'templates/template-sst_home_supercity.php',
					'templates/template-sst_home_city.php',
					'templates/template-sst-home6.php',
					'templates/template-sst_event_detail.php'
				],
			],
		] );
		$section2->add_field( [
			'name'    => __( 'Section Background Image', $prefix ),
			'desc'    => __( 'Add background image if needed.', $prefix ),
			'id'      => $prefix . '_section2_bg_image',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$section2->add_field( [
			'name' => __( 'Content', $prefix ),
			'desc' => __( 'Please enter the content for section with text center', $prefix ),
			'id'   => $prefix . '_section2_content',
			'type' => 'wysiwyg',
		] );
		#endregion

		#region Section with text left aligned (Below content)
		$section3 = new_cmb2_box( [
			'id'           => $prefix . '_section3_id',
			'title'        => __( 'Section with text left aligned (below content)', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_rev_slider.php',
					'templates/template-sst_home.php',
					'templates/template-sst_home_je.php',
					'templates/template-sst_home_service.php',
					'templates/template-sst_home_subservice.php',
					'templates/template-sst_home_supercity.php',
					'templates/template-sst_home_city.php',
					'templates/template-sst-home6.php'
				],
			],
		] );
		$section3->add_field( [
			'name' => __( 'Content', $prefix ),
			'desc' => __( 'Please enter the content for section with text left', $prefix ),
			'id'   => $prefix . '_section3_content',
			'type' => 'wysiwyg',
		] );
		#endregion

		#region Section with image right (Below content)
		$section4 = new_cmb2_box( [
			'id'           => $prefix . '_section4_id',
			'title'        => __( 'Section with image right (below content)', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_rev_slider.php',
					'templates/template-sst_home.php',
					'templates/template-sst_home_je.php',
					'templates/template-sst_home_service.php',
					'templates/template-sst_home_subservice.php',
					'templates/template-sst_home_supercity.php',
					'templates/template-sst_home_city.php',
					'templates/template-sst-home6.php',
					'templates/template-sst_event_detail.php'
				],
			],
		] );
		$section4->add_field( [
			'name'    => __( 'Image', $prefix ),
			'desc'    => __( 'Please upload / select the image for section 4', $prefix ),
			'id'      => $prefix . '_section4_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$section4->add_field( [
			'name' => __( 'Content', $prefix ),
			'desc' => __( 'Please enter the content for section 4', $prefix ),
			'id'   => $prefix . '_section4_content',
			'type' => 'wysiwyg',
		] );
		#endregion

		#region Google Map for contact us template
		$contact_map = new_cmb2_box( [
			'id'           => $prefix . '_contact_map_id',
			'title'        => __( 'Google Map', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_contact.php',
					'templates/template-sst_contact-2.php',
				],
			],
		] );
		$contact_map->add_field( [
			'name'            => __( 'Google Map Iframe URL', $prefix ),
			'desc'            => __( 'Please enter google map iframe url and use [google-map] to use in editor', $prefix ),
			'id'              => $prefix . '_contact_map',
			'type'            => 'textarea',
			'sanitization_cb' => false
		] );
		#endregion

		#region Contact information for contact us template
		$contact_info = new_cmb2_box( [
			'id'           => $prefix . '_contact_info_id',
			'title'        => __( 'Contact Information', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_contact.php',
			],
		] );
		$contact_info->add_field( [
			'name'    => __( 'Info 1 Icon', $prefix ),
			'desc'    => __( 'Please upload icon for info 1', $prefix ),
			'id'      => $prefix . '_contact_info1_icon',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$contact_info->add_field( [
			'name' => __( 'Info 1 Title', $prefix ),
			'desc' => __( 'Please enter the title for info 1', $prefix ),
			'id'   => $prefix . '_contact_info1_title',
			'type' => 'text',
		] );
		$contact_info->add_field( [
			'name' => __( 'Info 1 Content', $prefix ),
			'desc' => __( 'Please enter the content for for info 1', $prefix ),
			'id'   => $prefix . '_contact_info1_content',
			'type' => 'textarea',
		] );
		$contact_info->add_field( [
			'name'    => __( 'Info 2 Icon', $prefix ),
			'desc'    => __( 'Please upload icon for info 2', $prefix ),
			'id'      => $prefix . '_contact_info2_icon',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$contact_info->add_field( [
			'name' => __( 'Info 2 Title', $prefix ),
			'desc' => __( 'Please enter the content for info 2', $prefix ),
			'id'   => $prefix . '_contact_info2_title',
			'type' => 'text',
		] );
		$contact_info->add_field( [
			'name' => __( 'Info 2 Content', $prefix ),
			'desc' => __( 'Please enter the content for info 2', $prefix ),
			'id'   => $prefix . '_contact_info2_content',
			'type' => 'textarea',
		] );
		$contact_info->add_field( [
			'name'    => __( 'Info 3 Icon', $prefix ),
			'desc'    => __( 'Please upload icon for info 3', $prefix ),
			'id'      => $prefix . '_contact_info3_icon',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$contact_info->add_field( [
			'name' => __( 'Info 3 Title', $prefix ),
			'desc' => __( 'Please enter the title for info 3', $prefix ),
			'id'   => $prefix . '_contact_info3_title',
			'type' => 'text',
		] );
		$contact_info->add_field( [
			'name' => __( 'Info 3 Content', $prefix ),
			'desc' => __( 'Please enter the content for info 3', $prefix ),
			'id'   => $prefix . '_contact_info3_content',
			'type' => 'textarea',
		] );
		#endregion

		#region Testimonial author details
		$testimonial = new_cmb2_box( [
			'id'           => $prefix . '_testimonial_id',
			'title'        => __( 'Review Author Details', $prefix ),
			'object_types' => [ 'testimonials' ],
			'priority'     => 'high',

		] );
		$testimonial->add_field( [
			'name' => __( 'Review Author', $prefix ),
			'desc' => __( 'Please enter review author', $prefix ),
			'id'   => $prefix . '_testimonial_author',
			'type' => 'text',
		] );
		$testimonial->add_field( [
			'name' => __( 'Review Author Designation', $prefix ),
			'desc' => __( 'Please enter author designation', $prefix ),
			'id'   => $prefix . '_testimonial_author_desc',
			'type' => 'text',
		] );
		$testimonial->add_field( [
			'name' => __( 'Review Featured Media', $prefix ),
			'desc' => __( 'Please fill in the youtube/vimeo url', $prefix ),
			'id'   => $prefix . '_testimonial_author_feat_media',
			'type' => 'oembed',
		] );
		$testimonial->add_field( [
			'name' => __( 'Review Author Gallery', $prefix ),
			'desc' => __( 'Please upload review author gallery', $prefix ),
			'id'   => $prefix . '_testimonial_author_gallery',
			'type' => 'file_list',

		] );
		$testimonial->add_field( [
			'name' => __( 'Featured Review', $prefix ),
			'desc' => __( 'Please check this section to show on slider of review listings', $prefix ),
			'id'   => $prefix . '_testimonial_featured',
			'type' => 'checkbox',

		] );
		#endregion

		#region Communities List (below property listings) for real estate template
		$top_areas = new_cmb2_box( [
			'id'           => '_top_areas',
			'title'        => __( 'Communities List (below property listings)', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_re1.php',
					'templates/template-sst_real_estate_home.php',
				],
			],
		] );
		$top_areas->add_field( [
			'name' => __( 'Communities List Title', $prefix ),
			'id'   => '_top_areas_title',
			'type' => 'text',
		] );
		$top_areas->add_field( [
			'name'    => __( 'Communities Lists', $prefix ),
			'id'      => '_top_areas_group_id',
			'type'    => 'group',
			'options' => [
				'add_button'    => __( 'Add More Community', $prefix ),
				'remove_button' => __( 'Remove Community', $prefix ),
				'sortable'      => true,
			],
			'fields'  => [
				[
					'name' => __( 'Community Name', $prefix ),
					'id'   => '_top_area_name',
					'type' => 'text',
				],
				[
					'name' => __( 'Community Page Link', $prefix ),
					'id'   => '_top_area_link',
					'type' => 'text',
				],
				[
					'name' => __( 'Number of community', $prefix ),
					'id'   => '_top_area_number',
					'type' => 'text',
				],
			],
		] );
		#endregion

		#region Section (with image left, below Communities List) for real estate template
		$section5 = new_cmb2_box( [
			'id'           => $prefix . '_section5',
			'title'        => __( 'Section (with image left, below Communities List)', '_mok' ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_re1.php',
					'templates/template-sst_real_estate_home.php',
					'templates/template-sst_event_detail.php'
				],
			],
		] );
		$section5->add_field( [
			'name'    => __( 'Image', '_mok' ),
			'desc'    => __( 'Please upload the image', '_mok' ),
			'id'      => $prefix . '_section5_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$section5->add_field( [
			'name' => __( 'Content', '_mok' ),
			'desc' => __( 'Please enter the content', '_mok' ),
			'id'   => $prefix . '_section5_content',
			'type' => 'wysiwyg',
		] );
		#endregion

		#region Section (with no image below three columns section) for real estate template
		$section6 = new_cmb2_box( [
			'id'           => $prefix . '_section6',
			'title'        => __( 'Section (with no image below three columns section)', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_re1.php',
					'templates/template-sst_real_estate_home.php'
				],
			],
		] );
		$section6->add_field( [
			'name' => __( 'Content', '_mok' ),
			'desc' => __( 'Please enter the content', '_mok' ),
			'id'   => $prefix . '_section6_content',
			'type' => 'wysiwyg',
		] );
		#endregion

		#region Community list section for community template
		$community_section = new_cmb2_box( [
			'id'           => $prefix . '_community_section',
			'title'        => __( 'Community Section', '_mok' ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_community.php' ],
			],
		] );
		$community_section->add_field( [
			'name'    => __( 'Community', '_mok' ),
			'id'      => $prefix . '_community_list',
			'type'    => 'group',
			'options' => [
				'group_title'   => __( 'Community {#}', $prefix ),
				'add_button'    => __( 'Add Another Community', $prefix ),
				'remove_button' => __( 'Remove community', $prefix ),
				'sortable'      => true,
			],
			'fields'  => [
				[
					'name'    => __( 'Image', $prefix ),
					'desc'    => __( 'Upload an image', $prefix ),
					'id'      => $prefix . '_community_img',
					'type'    => 'file',
					'options' => [
						'url' => false,
					],
				],
				[
					'name' => __( 'Title', $prefix ),
					'desc' => __( 'Please enter title of community', $prefix ),
					'id'   => $prefix . '_community_title',
					'type' => 'text',
				],
				[
					'name' => __( 'Description', $prefix ),
					'desc' => __( 'Please enter community description', $prefix ),
					'id'   => $prefix . '_community_desc',
					'type' => 'wysiwyg',
				],
				[
					'name' => __( 'URL / Link', $prefix ),
					'desc' => __( 'Please enter url / link of the community', $prefix ),
					'id'   => $prefix . '_community_url',
					'type' => 'text',
				],
			],
		] );
		#endregion

		#region User profile meta box
		$user_edit = new_cmb2_box( [
			'id'               => $prefix . 'edit',
			'title'            => __( 'User Profile Metabox', $prefix ),
			'object_types'     => [ 'user' ],
			'show_names'       => true,
			'new_user_section' => 'add-new-user',
		] );
		$user_edit->add_field( [
			'name'     => __( 'Extra Information', $prefix ),
			'id'       => $prefix . '_extra_info',
			'type'     => 'title',
			'on_front' => false,
		] );
		$user_edit->add_field( [
			'name'    => __( 'Avatar', $prefix ),
			'desc'    => __( 'Please upload your profile image.', $prefix ),
			'id'      => $prefix . '_avatar',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$user_edit->add_field( [
			'name' => __( 'Designation', $prefix ),
			'desc' => __( 'Please enter your designation.', $prefix ),
			'id'   => $prefix . '_designation',
			'type' => 'text',
		] );
		#endregion

		#region location details for SST Location Template
		$meta_info_location = new_cmb2_box( [
			'id'           => $prefix . '_location_meta_id',
			'title'        => __( 'Branch Details', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_location.php',
			],
		] );
		$meta_info_location->add_field( [
			'name' => __( 'Branch Address', $prefix ),
			'desc' => __( 'Please enter info about branch address', $prefix ),
			'id'   => $prefix . '_location_meta_info1',
			'type' => 'textarea',
		] );
		$meta_info_location->add_field( [
			'name' => __( 'Branch Contacts', $prefix ),
			'desc' => __( 'Please enter info about branch contacts', $prefix ),
			'id'   => $prefix . '_location_meta_info2',
			'type' => 'textarea',
		] );
		$meta_info_location->add_field( [
			'name' => __( 'Branch Openings', $prefix ),
			'desc' => __( 'Please enter info about branch openings', $prefix ),
			'id'   => $prefix . '_location_meta_info3',
			'type' => 'textarea',
		] );
		$meta_info_location->add_field( [
			'name' => __( 'Branch Map', $prefix ),
			'desc' => __( 'Please enter iframe src for branch map', $prefix ),
			'id'   => $prefix . '_location_map',
			'type' => 'textarea',
		] );
		#endregion

		#region location details for SST Location Home Template
		$meta_info_locations = new_cmb2_box( [
			'id'           => $prefix . '_locations_meta_id',
			'title'        => __( 'Branch Details', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_locations.php',
			],
		] );
		$meta_info_locations->add_field( [
			'name'        => __( 'Locations', '_mok' ),
			'id'          => $prefix . '_location_list',
			'type'        => 'group',
			'description' => __( 'Add Locations', '_mok' ),
			'options'     => [
				'group_title'   => __( 'Locations {#}', '_mok' ),
				'add_button'    => __( 'Add More Location', '_mok' ),
				'remove_button' => __( 'Remove Location', '_mok' ),
				'sortable'      => true,
			],
			'fields'      => [
				[
					'name' => __( 'Branch Title', $prefix ),
					'desc' => __( 'Please enter title of Location', $prefix ),
					'id'   => $prefix . '_location_meta_title',
					'type' => 'text',
				],
				[
					'name' => __( 'Branch Address', $prefix ),
					'desc' => __( 'Please enter info about branch address', $prefix ),
					'id'   => $prefix . '_location_meta_info1',
					'type' => 'textarea',
				],
				[
					'name' => __( 'Branch Contacts', $prefix ),
					'desc' => __( 'Please enter info about branch contacts', $prefix ),
					'id'   => $prefix . '_location_meta_info2',
					'type' => 'text',
				],
				[
					'name' => __( 'Branch Openings', $prefix ),
					'desc' => __( 'Please enter info about branch openings', $prefix ),
					'id'   => $prefix . '_location_meta_info3',
					'type' => 'textarea',
				],
				[
					'name' => __( 'Branch Map', $prefix ),
					'desc' => __( 'Please enter iframe src for branch map', $prefix ),
					'id'   => $prefix . '_location_map',
					'type' => 'textarea',
				],
				[
					'name' => __( 'Branch Detail Page Link', $prefix ),
					'desc' => __( 'Please enter link to detail page of location', $prefix ),
					'id'   => $prefix . '_location_link',
					'type' => 'text',
				],
			],
		] );
		#endregion

		#region Find out more widget
		$widget_find_more = new_cmb2_box( [
			'id'           => $prefix . '_widget_findmore',
			'title'        => __( 'Find Out More Widget', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'low',
			'context'      => 'side',
		] );
		$widget_find_more->add_field( [
			'name' => __( 'Theme Color Option', $prefix ),
			'desc' => __( 'Please check this if you want to use dark color for find out more widget', $prefix ),
			'id'   => $prefix . '_widget_findmore_check',
			'type' => 'checkbox',
		] );
		$widget_find_more->add_field( [
			'name' => __( 'Widget Find out more Content', $prefix ),
			'desc' => __( 'Please enter content for find out more widget', $prefix ),
			'id'   => $prefix . '_widget_findmore_content',
			'type' => 'wysiwyg',
		] );
		#endregion

		#region Special logos section
		$special_logos = new_cmb2_box( [
			'id'           => $prefix . '_special_logos_id',
			'title'        => __( 'Special logos section', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_lead_capture.php',
				],
			],
		] );
		$special_logos->add_field( [
			'name'    => __( 'Content', $prefix ),
			'desc'    => __( 'Please enter the content for special logos section', $prefix ),
			'id'      => $prefix . '_special_logos_content',
			'type'    => 'wysiwyg',
			'show_on' => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_lead_capture.php',
				],
			],
		] );
		#endregion

		#region Page theme Option
		$theme_color_option = new_cmb2_box( [
			'id'           => $prefix . '_page_theme_color',
			'title'        => __( 'Page Theme Color', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home.php'
				]
			]
		] );
		$theme_color_option->add_field( [
			'name' => __( 'Page Theme Color', $prefix ),
			'desc' => __( 'Choose page theme color', $prefix ),
			'id'   => $prefix . '_page_theme_color',
			'type' => 'colorpicker'
		] );
		$theme_color_option->add_field( [
			'name' => __( 'Page Theme Hover Color', $prefix ),
			'desc' => __( 'Choose page theme hover color', $prefix ),
			'id'   => $prefix . '_page_theme_hover_color',
			'type' => 'colorpicker'
		] );
		$theme_color_option->add_field( [
			'name' => __( 'Enable theme color', $prefix ),
			'desc' => __( 'Enable theme color', $prefix ),
			'id'   => $prefix . '_page_theme_color_enabler',
			'type' => 'checkbox'
		] );
		#endregion

		#region Top Menu phone number
		$phone_number = new_cmb2_box( [
			'id'           => $prefix . '_top_phone_number',
			'title'        => __( 'Phone Number', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
		] );
		$phone_number->add_field( [
			'name' => __( 'Phone Number', $prefix ),
			'desc' => __( 'Insert phone number. Leave empty to display default phone number', $prefix ),
			'id'   => $prefix . '_menu_phone_number',
			'type' => 'text'
		] );
		#endregion
		/* Four section dropdown */
			$four_section = new_cmb2_box( [
			'id'           => $prefix . '_four_section',
			'title'        => __( 'Page Dynamic Sections(Download Guide, As seen on, Notable Clients)', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_fancy.php',
					'templates/template-sst_home_fancy-2.php',
					'templates/template-sst_home7.php',
					'templates/template-sst_home8.php',
					'templates/template-sst_e-commercehome1.php',
					'templates/template-sst-ambassador.php',
					'templates/template-sst_home_as_seen_on.php',
					'templates/template-sst_home_rev_slider.php',
					'templates/template-sst_home.php',
					'templates/template-sst_home1.php',
					'templates/template-sst_home_je.php',
					'templates/template-sst_home_service.php',
					'templates/template-sst_home_subservice.php',
					'templates/template-sst_home_supercity.php',
					'templates/template-sst_home_city.php',
					'templates/template-sst_home_re1.php',
					'templates/template-sst_community.php',
					'templates/template-sst_real_estate_home.php',
					'templates/template-sst-home6.php',
					'templates/template-sst_event_detail.php',
					'templates/template-sst_team_template.php',
					'templates/template-sst_home1_services.php',
					'templates/template-sst_property_listing.php'
				],
			],
		] );
		$four_section->add_field( [
			'name'    => __( 'Make Selection', $prefix ),
			'id'      => $prefix . '_four_section',
			'type'    => 'select',
			'options' => [
				'none' => 'Nothing',
			'guide' => 'Download Guide',
			'seen' => 'As seen on',
			'clients' => 'Notable Clients',
			
			]
		] );

	}
}
add_action( 'cmb2_admin_init', 'mok_meta_boxes' );

#region Four Column Section (Below Content)
if ( ! function_exists( 'mok_columns2' ) ) {
	/**
	 * Four Column Section (Below Content)
	 */
	function mok_columns2() {
		global $prefix;
		$column2 = new_cmb2_box( [
			'id'           => $prefix . '_four_columns2',
			'title'        => __( 'Four Column Section (Below Content)', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'low',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_rev_slider.php',
					'templates/template-sst_home.php',
					'templates/template-sst_home1.php',
					'templates/template-sst_home_je.php',
					'templates/template-sst_home_re1.php',
					'templates/template-sst_home_service.php',
					'templates/template-sst_home_subservice.php',
					'templates/template-sst_home_supercity.php',
					'templates/template-sst_home_city.php',
					'templates/template-sst-home6.php',
					'templates/template-sst_home1_services.php',
				],
			],
		] );

		$column2->add_field( [
			'name'    => __( 'First Column Icon', $prefix ),
			'desc'    => __( 'First Column Icon', $prefix ),
			'id'      => $prefix . '_four_columns2_column1_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );

		$column2->add_field( [
			'name'    => __( 'First Column Icon', $prefix ),
			'desc'    => __( 'First Column Icon', $prefix ),
			'id'      => $prefix . '_four_columns2_column1_icon',
			'type'    => 'select',
			'options' => mok_get_icon_list(),
		] );

		$column2->add_field( [
			'name' => __( 'First Column Icon Alt Text', $prefix ),
			'desc' => __( 'First Column Icon Alt Text', $prefix ),
			'id'   => $prefix . '_four_columns2_column1_icon_alt',
			'type' => 'text',
		] );
		$column2->add_field( [
			'name' => __( 'First Column URL', $prefix ),
			'desc' => __( 'First Column URL', $prefix ),
			'id'   => $prefix . '_four_columns2_column1_link',
			'type' => 'text_url',
		] );

		$column2->add_field( [
			'name' => __( 'First Column Content', $prefix ),
			'desc' => __( 'First Column Content', $prefix ),
			'id'   => $prefix . '_four_columns2_column1_content',
			'type' => 'wysiwyg',
		] );

		$column2->add_field( [
			'name'    => __( 'Second Column Icon', $prefix ),
			'desc'    => __( 'Second Column Icon', $prefix ),
			'id'      => $prefix . '_four_columns2_column2_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );

		$column2->add_field( [
			'name'    => __( 'Second Column Icon', $prefix ),
			'desc'    => __( 'Second Column Icon', $prefix ),
			'id'      => $prefix . '_four_columns2_column2_icon',
			'type'    => 'select',
			'options' => mok_get_icon_list(),
		] );

		$column2->add_field( [
			'name' => __( 'Second Column Icon Alt Text', $prefix ),
			'desc' => __( 'Second Column Icon Alt Text for above only', $prefix ),
			'id'   => $prefix . '_four_columns2_column2_icon_alt',
			'type' => 'text',
		] );
		$column2->add_field( [
			'name' => __( 'Second Column URL', $prefix ),
			'desc' => __( 'Second Column URL', $prefix ),
			'id'   => $prefix . '_four_columns2_column2_link',
			'type' => 'text_url',
		] );

		$column2->add_field( [
			'name' => __( 'Second Column Content', $prefix ),
			'desc' => __( 'Second Column Content', $prefix ),
			'id'   => $prefix . '_four_columns2_column2_content',
			'type' => 'wysiwyg',
		] );

		$column2->add_field( [
			'name'    => __( 'Third Column Icon', $prefix ),
			'desc'    => __( 'Third Column Icon', $prefix ),
			'id'      => $prefix . '_four_columns2_column3_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );

		$column2->add_field( [
			'name'    => __( 'Third Column Icon', $prefix ),
			'desc'    => __( 'Third Column Icon', $prefix ),
			'id'      => $prefix . '_four_columns2_column3_icon',
			'type'    => 'select',
			'options' => mok_get_icon_list(),
		] );

		$column2->add_field( [
			'name' => __( 'Third Column Icon Alt Text', $prefix ),
			'desc' => __( 'Third Column Icon Alt Text for above field only', $prefix ),
			'id'   => $prefix . '_four_columns2_column3_icon_alt',
			'type' => 'text',
		] );
		$column2->add_field( [
			'name' => __( 'Third Column URL', $prefix ),
			'desc' => __( 'Third Column URL', $prefix ),
			'id'   => $prefix . '_four_columns2_column3_link',
			'type' => 'text_url',
		] );

		$column2->add_field( [
			'name' => __( 'Third Column Content', $prefix ),
			'desc' => __( 'Third Column Content', $prefix ),
			'id'   => $prefix . '_four_columns2_column3_content',
			'type' => 'wysiwyg',
		] );

		$column2->add_field( [
			'name'    => __( 'Fourth Column Icon', $prefix ),
			'desc'    => __( 'Fourth Column Icon', $prefix ),
			'id'      => $prefix . '_four_columns2_column4_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );

		$column2->add_field( [
			'name'    => __( 'Fourth Column Icon', $prefix ),
			'desc'    => __( 'Fourth Column Icon', $prefix ),
			'id'      => $prefix . '_four_columns2_column4_icon',
			'type'    => 'select',
			'options' => mok_get_icon_list(),
		] );

		$column2->add_field( [
			'name'    => __( 'Fourth Column Icon Alt Text', $prefix ),
			'desc'    => __( 'Fourth Column Icon alt text for above field only', $prefix ),
			'id'      => $prefix . '_four_columns2_column4_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$column2->add_field( [
			'name' => __( 'Fourth Column URL', $prefix ),
			'desc' => __( 'Fourth Column URL', $prefix ),
			'id'   => $prefix . '_four_columns2_column4_link',
			'type' => 'text_url',
		] );

		$column2->add_field( [
			'name' => __( 'Fourth Column Content', $prefix ),
			'desc' => __( 'Fourth Column Content', $prefix ),
			'id'   => $prefix . '_four_columns2_column4_content',
			'type' => 'wysiwyg',
		] );
	}
}
add_action( 'cmb2_admin_init', 'mok_columns2' );
#endregion

if ( ! function_exists( 'mok_three_columns_re' ) ) {
	/**
	 * hree Column Section for real estate template
	 */
	function mok_three_columns_re() {
		global $prefix;
		$three_columns = new_cmb2_box( [
			'id'           => $prefix . '_three_column1',
			'title'        => __( 'Three Column Section', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_re1.php',
					'templates/template-sst_real_estate_home.php',
				],
			],
		] );

		$three_columns->add_field( [
			'name'    => __( 'Column 1 Image', '_mok' ),
			'desc'    => __( 'Column 1 Image', '_mok' ),
			'id'      => $prefix . '_three_column1_column1_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );


		$three_columns->add_field( [
			'name' => __( 'Column 1 Content', '_mok' ),
			'desc' => __( 'Column 1 Content', '_mok' ),
			'id'   => $prefix . '_three_column1_column1_content',
			'type' => 'wysiwyg',
		] );

		$three_columns->add_field( [
			'name'    => __( 'Column 2 Image', '_mok' ),
			'desc'    => __( 'Column 2 Image', '_mok' ),
			'id'      => $prefix . '_three_column1_column2_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );


		$three_columns->add_field( [
			'name' => __( 'Column 2 Content', '_mok' ),
			'desc' => __( 'Column 2 Content', '_mok' ),
			'id'   => $prefix . '_three_column1_column2_content',
			'type' => 'wysiwyg',
		] );

		$three_columns->add_field( [
			'name'    => __( 'Column 3 Image', '_mok' ),
			'desc'    => __( 'Column 3 Image', '_mok' ),
			'id'      => $prefix . '_three_column1_column3_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );


		$three_columns->add_field( [
			'name' => __( 'Column 3 Content', '_mok' ),
			'desc' => __( 'Column 3 Content', '_mok' ),
			'id'   => $prefix . '_three_column1_column3_content',
			'type' => 'wysiwyg',
		] );

		/* ============ THREE COLUMN SECTION ends ============== */
	}
}
add_action( 'cmb2_admin_init', 'mok_three_columns_re' );

if ( ! function_exists( 'mok_sections1' ) ) {
	/**
	 * Page Section 1 (Below content)
	 */
	function mok_sections1() {
		$prefix   = '_ttm';
		$sections = new_cmb2_box( [
			'id'           => $prefix . '_section1',
			'title'        => __( 'Page Section 1 (Below content) ', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_fancy.php',
					'templates/template-sst_home_fancy-2.php',
					'templates/template-sst_home7.php',
					'templates/template-sst_home.php',
					'templates/template-sst_home_je.php',
					'templates/template-sst_home_service.php',
					'templates/template-sst_home_subservice.php',
					'templates/template-sst_home_supercity.php',
					'templates/template-sst_home_city.php',
					'templates/template-sst_home_re1.php',
					'templates/template-sst_community.php',
					'templates/template-sst-home6.php',
					'templates/template-sst_client_exhibit.php'
				],
			],
		] );
		$sections->add_field( [
			'name'    => __( 'Section List', $prefix ),
			'desc'    => __( 'Section List', $prefix ),
			'id'      => $prefix . '_section_group1',
			'type'    => 'group',
			'options' => [
				'group_title'   => __( 'Section {#}', $prefix ),
				'add_button'    => __( 'Add Another Section', $prefix ),
				'remove_button' => __( 'Remove Section', $prefix ),
				'sortable'      => true,
			],
			'fields'  => [
				[
					'name' => __( 'CSS Class', $prefix ),
					'desc' => __( 'Please input a css class to change style. WARNING! ADDING CLASSES WILL CHANGE THE STYLE OF THE SECTION' . '</br>' .
					              '<strong>Acceptable Classes:</strong>' .
					              '<ul style="margin-left: 16px; list-style: circle; color: #867a7a;">
					                <li>imagefloat (To remove padding from Top & Bottom)</li>
					                <li>fda-approved</li>
					                <li>vertical-center (To place content vertically center)</li>
					                <li>tall-gap (To add padding on Top & Bottom of section)</li>
					              </ul>'
						,
						$prefix ),
					'id'   => $prefix . '_section_class',
					'type' => 'text',
				],
				[
					'name'    => __( 'Section Structure', $prefix ),
					'desc'    => __( 'Please select the layout of the section', $prefix ),
					'id'      => $prefix . '_section_layout',
					'type'    => 'select',
					'options' => [
						'none'       => 'None',
						'imageleft'  => 'Image in left side',
						'imageright' => 'Image in right side',
					],
				],
				[
					'name'    => __( 'Section Background Image', $prefix ),
					'desc'    => __( 'Upload an image', $prefix ),
					'id'      => $prefix . '_section_bg',
					'type'    => 'file',
					'options' => [
						'url' => false,
					],
				],
				[
					'name'    => __( 'Section Image', $prefix ),
					'desc'    => __( 'Upload an image', $prefix ),
					'id'      => $prefix . '_section_img',
					'type'    => 'file',
					'options' => [
						'url' => false,
					],
				],
				[
					'name' => __( 'Section Paragraph', $prefix ),
					'desc' => __( 'Add Section paragraph', $prefix ),
					'id'   => $prefix . '_section_content',
					'type' => 'wysiwyg',
				],

			],
		] );
	}
}
add_action( 'cmb2_admin_init', 'mok_sections1', 21 );

if ( ! function_exists( 'mok_sections' ) ) {
	/**
	 * Post Meta for
	 * Page Section
	 * Bottom section just above footer
	 * Thank You page banner
	 * Thank You page services lists
	 * Events Custom Fields
	 * Banner with content Slider
	 * Franchise Opportunity about list
	 * Info About Business
	 * Areas reviewed & planned
	 * VIP Experience
	 * Team Template Section's Fields
	 * Team Detail Page Banner
	 * Team Template Contact Info
	 * Locations page Banner
	 * Locations content
	 * Offer Page Fields
	 * Landing Banner
	 * Landing page theme option
	 * Landing Media
	 * Landing_Results
	 * Landing Contact
	 * Landing Bottom Section
	 * therapy additional with results groups
	 * Events with form
	 * Fields for Landing Page 2
	 * Home8 post meta group
	 * home8 page banner region
	 * home8 Learn/Register region
	 * home8 page article sections region
	 */
	function mok_sections() {
		$prefix = '_ttm';
		#region Page Section
		$sections = new_cmb2_box( [
			'id'           => $prefix . '_section',
			'title'        => __( 'Sections below main content', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_fancy.php',
					'templates/template-sst_home_fancy-2.php',
					'templates/template-sst_home7.php',
					'templates/template-sst_home8.php',
					'templates/template-sst_home.php',
					'templates/template-sst_home_je.php',
					'templates/template-sst_home_service.php',
					'templates/template-sst_home_subservice.php',
					'templates/template-sst_home_supercity.php',
					'templates/template-sst_home_city.php',
					'templates/template-sst_home_re1.php',
					'templates/template-sst_home1.php',
					'templates/template-sst_community.php',
					'templates/template-sst-home6.php',
					'templates/template-sst_event_detail.php',
					'templates/template-sst_home1_services.php',
					'templates/template-sst_home_rev_slider.php',
					'templates/template-sst_franchise_opportunity.php'
				],
			],
		] );
		$sections->add_field( [
			'name'    => __( 'Section List', $prefix ),
			'desc'    => __( 'Basic classes are available here you should use for the related sections:
					<ol  style="color: #B3B1B1; font-size: 11px; font-weight: 400;">
						<li><strong style="color: #B3B1B1; font-size: 11px; font-weight: 700;">SECTION [COMPANY INFO (MEDICAL SPA)]:  </strong><br/>
							<strong style="color: #B3B1B1; font-size: 11px; font-weight: 700;">CLASSES:  </strong><span style="color: #B1AFAF; font-size: 11px; font-weight: 400;">page-content bg-theme-color companyinfo-section image-overlay-right</span><br/>
							<strong style="color: #B3B1B1; font-size: 11px; font-weight: 700;">SECTION STRUCTURE:  </strong><span style="color: #B1AFAF; font-size: 11px; font-weight: 400;">Image in right side</span>
						</li>
						<li><strong style="color: #B3B1B1; font-size: 11px; font-weight: 700;">SECTION [SPEAKER (LISTEN)]:  </strong><br/>
							<strong style="color: #B3B1B1; font-size: 11px; font-weight: 700;">CLASSES:  </strong><span style="color: #B1AFAF; font-size: 11px; font-weight: 400;">page-content bg-theme-color speaker-section</span><br/>
							<strong style="color: #B3B1B1; font-size: 11px; font-weight: 700;">SECTION STRUCTURE:  </strong><span style="color: #B1AFAF; font-size: 11px; font-weight: 400;">Image in left side</span>
						</li>
						<li><strong style="color: #B3B1B1; font-size: 11px; font-weight: 700;">SECTION [AS SEEN ON]:  </strong><br/>
							<strong style="color: #B3B1B1; font-size: 11px; font-weight: 700;">CLASSES:  </strong><span style="color: #B1AFAF; font-size: 11px; font-weight: 400;">page-content aligncenter bg-light-color as-seen-on</span><br/>
							<strong style="color: #B3B1B1; font-size: 11px; font-weight: 700;">SECTION STRUCTURE:  </strong><span style="color: #B1AFAF; font-size: 11px; font-weight: 400;">None</span>
						</li>
						<li><strong style="color: #B3B1B1; font-size: 11px; font-weight: 700;">SECTION [EDITOR CONTENT (BOTTOM CONTENT)]:  </strong><br/>
							<strong style="color: #B3B1B1; font-size: 11px; font-weight: 700;">CLASSES:  </strong><span style="color: #B1AFAF; font-size: 11px; font-weight: 400;">page-content bottom-content editor-content transparent-bg</span><br/>
							<strong style="color: #B3B1B1; font-size: 11px; font-weight: 700;">SECTION STRUCTURE:  </strong><span style="color: #B1AFAF; font-size: 11px; font-weight: 400;">None</span>
						</li>
						<li><strong style="color: #B3B1B1; font-size: 11px; font-weight: 700;">SECTION [TESTIMONIAL IMAGE (IMAGE BELOW EDITOR CONTENT)]:  </strong><br/>
							<strong style="color: #B3B1B1; font-size: 11px; font-weight: 700;">CLASSES:  </strong><span style="color: #B1AFAF; font-size: 11px; font-weight: 400;">fullwidth page-content bg-dark-color testimonial-block clearfix</span><br/>
							<strong style="color: #B3B1B1; font-size: 11px; font-weight: 700;">SECTION STRUCTURE:  </strong><span style="color: #B1AFAF; font-size: 11px; font-weight: 400;">None</span>
						</li>
					</ol>
			', $prefix ),
			'id'      => $prefix . '_section_group',
			'type'    => 'group',
			'options' => [
				'group_title'   => __( 'Section {#}', $prefix ),
				'add_button'    => __( 'Add Another Section', $prefix ),
				'remove_button' => __( 'Remove Section', $prefix ),
				'sortable'      => true,
			],
			'fields'  => [
				[
					'name' => __( 'CSS Class', $prefix ),
					'desc' => __( 'Please input a css class to change style. WARNING! ADDING CLASSES WILL CHANGE THE STYLE OF THE SECTION',
						$prefix ),
					'id'   => $prefix . '_section_class',
					'type' => 'text',
				],
				[
					'name'    => __( 'Section Structure', $prefix ),
					'desc'    => __( 'Please select the layout of the section', $prefix ),
					'id'      => $prefix . '_section_layout',
					'type'    => 'select',
					'options' => [
						'none'       => 'None',
						'imageleft'  => 'Image in left side',
						'imageright' => 'Image in right side',
						'imagebg'    => 'Image as Background',
					],
				],
				[
					'name'    => __( 'Section Background Image', $prefix ),
					'desc'    => __( 'Upload an image', $prefix ),
					'id'      => $prefix . '_section_bg',
					'type'    => 'file',
					'options' => [
						'url' => false,
					],
				],
				[
					'name'    => __( 'Section Image', $prefix ),
					'desc'    => __( 'Upload an image', $prefix ),
					'id'      => $prefix . '_section_img',
					'type'    => 'file',
					'options' => [
						'url' => false,
					],
				],
				[
					'name'            => __( 'Section Paragraph', $prefix ),
					'desc'            => __( 'Add Section paragraph', $prefix ),
					'id'              => $prefix . '_section_content',
					'type'            => 'wysiwyg',
					'sanitization_cb' => 'wp_kses_post'
				],

			],
		] );
		#endregion

		#region Bottom section just above footer
		$bottom_section = new_cmb2_box( [
			'id'           => $prefix . '_section8_id',
			'title'        => __( 'Bottom section just above footer', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'low',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_home_rev_slider.php',
					'templates/template-sst_home.php',
					'templates/template-sst_home1.php',
					'templates/template-sst_home_je.php',
					'templates/template-sst_home_service.php',
					'templates/template-sst_home_subservice.php',
					'templates/template-sst_home_supercity.php',
					'templates/template-sst_home_city.php',
					'templates/template-sst-home6.php',
					'templates/template-sst_home1_services.php',
				],
			],
		] );
		$bottom_section->add_field( [
			'name' => __( 'Bottom Content', $prefix ),
			'desc' => __( 'Please enter extra content that goes above footer', $prefix ),
			'id'   => '_qwl_section8_content',
			'type' => 'wysiwyg',
		] );
		#endregion

		#region Thank You page banner
		$thank_you_banner = new_cmb2_box( [
			'id'           => $prefix . '_thank_you_banner',
			'title'        => __( 'Thank Your Banner', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_thank_you.php'
			]
		] );
		$thank_you_banner->add_field( [
			'name'    => __( 'Banner Content style', $prefix ),
			'desc'    => __( '', $prefix ),
			'id'      => $prefix . '_thank_you_banner_content_style',
			'type'    => 'select',
			'options' => [
				'default' => 'Default',
				'dark-bg' => 'Dark Background'
			],
		] );
		$thank_you_banner->add_field( [
			'name'    => __( 'Banner Image', $prefix ),
			'desc'    => __( 'Upload an image', $prefix ),
			'id'      => $prefix . '_thank_you_banner_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$thank_you_banner->add_field( [
			'name'    => __( 'Banner Guide Image', $prefix ),
			'desc'    => __( 'Upload an image', $prefix ),
			'id'      => $prefix . '_thank_you_banner_guide_img',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$thank_you_banner->add_field( [
			'name' => __( 'Banner Content', $prefix ),
			'desc' => __( 'Add banner content', $prefix ),
			'id'   => $prefix . '_thank_you_banner_content',
			'type' => 'wysiwyg',
		] );
		#endregion

		#region Thank You page services lists
		$thank_you_services = new_cmb2_box( [
			'id'           => $prefix . '_thank_you_services_list',
			'title'        => __( 'Services List', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_services.php'
			]
		] );
		$thank_you_services->add_field( [
			'name'    => __( 'Service title', $prefix ),
			'desc'    => __( 'Title of service list', $prefix ),
			'id'      => $prefix . '_service_title',
			'type'    => 'text',
			'default' => 'Learn More About Our Services'
		] );
		$thank_you_services->add_field( [
			'name'    => __( 'Services list', $prefix ),
			'desc'    => __( 'List of services', $prefix ),
			'id'      => $prefix . '_thank_you_services_group',
			'type'    => 'group',
			'show_on' => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_services.php'
			],
			'options' => [
				'group_title'   => __( 'Services {#}', $prefix ),
				'add_button'    => __( 'Add another service', $prefix ),
				'remove_button' => __( 'Remove service', $prefix ),
				'sortable'      => true,
			],
			'fields'  => [
				[
					'name'    => __( 'Service Image', $prefix ),
					'desc'    => __( 'Upload an image', $prefix ),
					'id'      => $prefix . '_thank_you_service_img',
					'type'    => 'file',
					'options' => [
						'url' => false,
					],
				],
				[
					'name' => __( 'Service Title', $prefix ),
					'desc' => __( 'Add service title', $prefix ),
					'id'   => $prefix . '_thank_you_service_title',
					'type' => 'text',
				],
				[
					'name' => __( 'Service button text', $prefix ),
					'desc' => __( 'Add service button text', $prefix ),
					'id'   => $prefix . '_thank_you_service_link_txt',
					'type' => 'text',
				],
				[
					'name'      => __( 'Banner button URL', $prefix ),
					'desc'      => __( 'field description (optional)', $prefix ),
					'id'        => $prefix . '_thank_you_service_link_url',
					'type'      => 'text_url',
					'protocols' => [ 'http', 'https' ]
				]
			]
		] );
		#endregion
#about us region

$banner = new_cmb2_box( [
			'id'           => $prefix . '_banner',
			'title'        => __( 'Top Banner Section', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_about_us.php',
				],
			],
		] );
		$banner->add_field( [
			'name'    => __( 'Banner List', $prefix ),
			'desc'    => __( 'Banner List', $prefix ),
			'id'      => $prefix . '_banner_slide_about_group',
			'type'    => 'group',
			'options' => [
				'group_title'   => __( 'Banner {#}', $prefix ),
				'add_button'    => __( 'Add Another Banner', $prefix ),
				'remove_button' => __( 'Remove banner', $prefix ),
				'sortable'      => true,
			],
			'fields'  => [
				[
					'name'    => __( 'Banner Image', $prefix ),
					'desc'    => __( 'Upload an image', $prefix ),
					'id'      => $prefix . '_banner_img',
					'type'    => 'file',
					'options' => [
						'url' => false,
					],
				],
				
				[
					'name' => __( 'Banner Heading', $prefix ),
					'desc' => __( 'Add banner heading', $prefix ),
					'id'   => $prefix . '_banner_heading',
					'type' => 'wysiwyg',
				],
				[
					'name' => __( 'Banner Paragraph', $prefix ),
					'desc' => __( 'Add banner paragraph', $prefix ),
					'id'   => $prefix . '_banner_para',
					'type' => 'wysiwyg',
				],
				
			],
		] );
		$banner->add_field( [
			'name'    => __( 'Mobile Banner Image', $prefix ),
			'desc'    => __( 'Please upload your banner image here. [Image size: (768 X 400)px]',
				$prefix ),
			'id'      => $prefix . '_mobile_banner_image',
			'type'    => 'file',
			'options' => [
				'url' => false,
			],
		] );
		$banner->add_field( [
			'name' => __( 'Mobile Banner Content', $prefix ),
			'desc' => __( 'Enter your banner content here.', $prefix ),
			'id'   => $prefix . '_mobile_banner_content',
			'type' => 'wysiwyg',
		] );

	$leadership_aboutus = new_cmb2_box( [
			'id'           => $prefix . 'leadership_aboutus',
			'title'        => __( 'Leadership Section', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_about_us.php'
			]
		] );
		$leadership_aboutus->add_field( [
			'name' => __( 'Enable Leadership', $prefix ),
			'desc' => __( 'Please check this section to show on about us page', $prefix ),
			'id'   => $prefix . '_enable_leadership',
			'type' => 'checkbox',

		] );
		$leadership_aboutus->add_field( [
			'name'    => __( 'Leadership Title', $prefix ),
			'desc'    => __( 'Title of leadership section', $prefix ),
			'id'      => $prefix . '_leadership_title',
			'type'    => 'text',
			'default' => 'LEADERSHIP'
		] );
		$leadership_aboutus->add_field( [
			'name'    => __( 'Leadership Description', $prefix ),
			'desc'    => __( 'Description of leadership section', $prefix ),
			'id'      => $prefix . '_leadership_desc',
			'type'    => 'textarea',
			'default' => ''
		] );

		$values_aboutus = new_cmb2_box( [
			'id'           => $prefix . '_values',
			'title'        => __( 'Values Section', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_about_us.php',
				],
			],
		] );
		$values_aboutus->add_field( [
			'name' => __( 'Enable Values', $prefix ),
			'desc' => __( 'Please check this section to show on about us page', $prefix ),
			'id'   => $prefix . '_enable_values_section',
			'type' => 'checkbox',

		] );
		$values_aboutus->add_field( [
			'name'    => __( 'Our Values Title', $prefix ),
			'desc'    => __( 'Title of Values section', $prefix ),
			'id'      => $prefix . '_values_title',
			'type'    => 'text',
			'default' => 'Our  Values'
		] );
		$values_aboutus->add_field( [
			'name'    => __( 'Values List', $prefix ),
			'desc'    => __( 'Values List', $prefix ),
			'id'      => $prefix . '_values_group',
			'type'    => 'group',
			'options' => [
				'group_title'   => __( 'Values {#}', $prefix ),
				'add_button'    => __( 'Add Another Value', $prefix ),
				'remove_button' => __( 'Remove value', $prefix ),
				'sortable'      => true,
			],
			'fields'  => [
				[
					'name' => __( 'Value Heading', $prefix ),
					'desc' => __( 'Add value heading', $prefix ),
					'id'   => $prefix . '_value_heading',
					'type' => 'text',
				],
				[
					'name' => __( 'Value description', $prefix ),
					'desc' => __( 'Add value description', $prefix ),
					'id'   => $prefix . '_value_para',
					'type' => 'textarea',
				],
				
			],
		] );
	$company_timeline = new_cmb2_box( [
			'id'           => $prefix . '_comptimeline',
			'title'        => __( 'Company Timeline', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [  
					'templates/template-sst_about_us.php',
				],
			],
		] );

	$company_timeline->add_field( [
			'name' => __( 'Enable Company Timeline', $prefix ),
			'desc' => __( 'Please check this section to show on about us page', $prefix ),
			'id'   => $prefix . '_enable_company',
			'type' => 'checkbox',

		] );
	$company_timeline->add_field( [
			'name' => __( 'Company Title', $prefix ),
			'desc' => __( 'Add company title here.', $prefix ),
			'id'   => $prefix . '_company_title',
			'type' => 'text',
			'default' => 'COMPANY TIMELINE',

		] );
		$company_timeline->add_field( [
			'name'    => __( 'Company Timeline List', $prefix ),
			'desc'    => __( 'Company Timeline List', $prefix ),
			'id'      => $prefix . '_company_group',
			'type'    => 'group',
			'options' => [
				'group_title'   => __( 'Company Timeline {#}', $prefix ),
				'add_button'    => __( 'Add Another Timeline', $prefix ),
				'remove_button' => __( 'Remove Timeline', $prefix ),
				'sortable'      => true,
			],
			

			'fields'  => [
				[
					'name' => __( 'Company Year', $prefix ),
					'desc' => __( 'Add company year', $prefix ),
					'id'   => $prefix . '_company_year',
					'type' => 'text',
				],

				[
					'name' => __( 'Company Month', $prefix ),
					'desc' => __( 'Add company title', $prefix ),
					'id'   => $prefix . '_company_title',
					'type' => 'select',
					'options' => [
						'January' => __( 'January', $prefix ),
						'February'    => __( 'February', $prefix ),
						'March'    => __( 'March', $prefix ),
						'April'    => __( 'April', $prefix ),
						'May'    => __( 'May', $prefix ),
						'June'    => __( 'June', $prefix ),
						'July'    => __( 'July', $prefix ),
						'August'    => __( 'August', $prefix ),
						'September'    => __( 'September', $prefix ),
						'October'    => __( 'October', $prefix ),
						'November'    => __( 'November', $prefix ),
						'December'    => __( 'December', $prefix ),
					],
				],
				[
					'name' => __( 'Company description', $prefix ),
					'desc' => __( 'Add company description', $prefix ),
					'id'   => $prefix . 'company_desc',
					'type' => 'textarea',
				],
				[
					'name'    => __( 'Company Image', $prefix ),
					'desc'    => __( 'Upload an image', $prefix ),
					'id'      => $prefix . '_company_img',
					'type'    => 'file',
					'options' => [
						'url' => false,
					],
				],
			],
		] );

$philosophy_aboutus = new_cmb2_box( [
			'id'           => $prefix . 'philosophy_aboutus',
			'title'        => __( 'Philosophy Section', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_about_us.php'
			]
		] );
		$philosophy_aboutus->add_field( [
			'name' => __( 'Enable Philosophy', $prefix ),
			'desc' => __( 'Please check this section to show on about us page', $prefix ),
			'id'   => $prefix . '_enable_philosophy',
			'type' => 'checkbox',

		] );
		$philosophy_aboutus->add_field( [
			'name'    => __( 'Philosophy Title', $prefix ),
			'desc'    => __( 'Title of Philosophy section', $prefix ),
			'id'      => $prefix . '_philosophy_title',
			'type'    => 'text',
			'default' => 'OUR PHILOSOPHY'
		] );
       $philosophy_aboutus->add_field( [
			'name'    => __( 'Philosophy Description', $prefix ),
			'desc'    => __( 'Description of Philosophy section', $prefix ),
			'id'      => $prefix . '_philosophy_desc',
			'type'    => 'textarea',
			'default' => ''
		] );
$reviews_aboutus = new_cmb2_box( [
			'id'           => $prefix . 'reviews_aboutus',
			'title'        => __( 'Reviews Section', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_about_us.php'
			]
		] );
		$reviews_aboutus->add_field( [
			'name' => __( 'Enable Reviews', $prefix ),
			'desc' => __( 'Please check this section to show on about us page', $prefix ),
			'id'   => $prefix . '_enable_reviews',
			'type' => 'checkbox',

		] );
		$reviews_aboutus->add_field( [
			'name'    => __( 'Title of Review Section', $prefix ),
			'desc'    => __( 'title of section', $prefix ),
			'id'      => $prefix . '_title_reviews',
			'type'    => 'text',
			'default' => 'Reviews'
		] );
    
		$reviews_aboutus->add_field( [
			'name'    => __( 'Number of Reviews', $prefix ),
			'desc'    => __( 'Set number of reviews to be shown', $prefix ),
			'id'      => $prefix . '_num_reviews',
			'type'    => 'text',
			'default' => '2'
		] );
    
$location_aboutus = new_cmb2_box( [
			'id'           => $prefix . 'location_aboutus',
			'title'        => __( 'Location Section', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_about_us.php'
			]
		] );
		$location_aboutus->add_field( [
			'name' => __( 'Enable Location', $prefix ),
			'desc' => __( 'Please check this section to show on about us page', $prefix ),
			'id'   => $prefix . '_enable_location',
			'type' => 'checkbox',

		] );
		$location_aboutus->add_field( [
			'name'    => __( 'Title of Location Section', $prefix ),
			'desc'    => __( 'title of section', $prefix ),
			'id'      => $prefix . '_title_location',
			'type'    => 'text',
			'default' => 'Our Location'
		] );
#end region
		#region Events Custom Fields
		$event_fields = new_cmb2_box( [
			'id'           => $prefix . '_event_meta',
			'title'        => __( 'Event Meta', $prefix ),
			'object_types' => [ 'our-events' ],
			'priority'     => 'low'
		] );

		$event_fields->add_field( [
			'name' => __( 'Event Title', '_mok' ),
			'desc' => __( 'Add Event Branch', '_mok' ),
			'id'   => $prefix . '_event_branch',
			'type' => 'text',

		] );

		$event_fields->add_field( [
			'name' => __( 'Event Address', '_mok' ),
			'desc' => __( 'Add Event address', '_mok' ),
			'id'   => $prefix . '_event_address',
			'type' => 'text',

		] );

		$event_fields->add_field( [
			'name' => __( 'Event City', '_mok' ),
			'desc' => __( 'Add Event city', '_mok' ),
			'id'   => $prefix . '_event_city',
			'type' => 'text',

		] );
		$event_fields->add_field( [
			'name' => __( 'Event State', '_mok' ),
			'desc' => __( 'Add Event state', '_mok' ),
			'id'   => $prefix . '_event_state',
			'type' => 'text',

		] );
		$event_fields->add_field( [
			'name' => __( 'Event Zip Code', '_mok' ),
			'desc' => __( 'Add Event zip code', '_mok' ),
			'id'   => $prefix . '_event_zip',
			'type' => 'text',

		] );

		$event_fields->add_field( [
			'name' => __( 'Event Start Time', '_mok' ),
			'desc' => __( 'Add Event start time', '_mok' ),
			'id'   => $prefix . '_event_start_time',
			'type' => 'text_time',
		] );

		$event_fields->add_field( [
			'name' => __( 'Event End Time', '_mok' ),
			'desc' => __( 'Add Event end time', '_mok' ),
			'id'   => $prefix . '_event_end_time',
			'type' => 'text_time',
		] );

		$event_fields->add_field( [
			'name' => __( 'Date', '_mok' ),
			'desc' => __( 'Add Event Date', '_mok' ),
			'id'   => $prefix . '_event_date',
			'type' => 'text_date_timestamp',
		] );

		$event_fields->add_field( [
			'name' => __( 'Is Featured Event?', '_mok' ),
			'desc' => __( 'Tick if its featured event', '_mok' ),
			'id'   => $prefix . '_event_featured',
			'type' => 'checkbox',
		] );

		$event_fields->add_field( [
			'name'            => __( 'Google Map Iframe', '_mok' ),
			'desc'            => __( 'add google map iframe', '_mok' ),
			'id'              => $prefix . '_event_google_map',
			'type'            => 'textarea',
			'sanitization_cb' => false,
			'escape_cb'       => false
		] );

		$event_fields = new_cmb2_box( [
			'id'           => $prefix . '_event_content',
			'title'        => __( 'Event Content', $prefix ),
			'object_types' => [ 'our-events' ],
			'priority'     => 'low'
		] );

		$event_fields->add_field( [
			'name'            => __( 'Content', '_mok' ),
			'desc'            => __( 'Add Event Content', '_mok' ),
			'id'              => $prefix . '_event_detail',
			'type'            => 'wysiwyg',
			'sanitization_cb' => false
		] );
		#endregion

		#region Banner with content Slider
		$banner_with_slider = new_cmb2_box( [
			'id'           => $prefix . '_banner_with_slider',
			'title'        => __( 'Top Banner', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_franchise_opportunity.php',
					'templates/template-sst_client_exhibit.php',
					'templates/template-sst_services.php',
					'templates/template-sst_thank_you_new.php',
					'templates/template-sst_404.php',
				]
			]
		] );
		$banner_with_slider->add_field( [
			'name'    => __( 'Banner List', $prefix ),
			'desc'    => __( 'Banner List', $prefix ),
			'id'      => $prefix . '_banner_slider_group',
			'type'    => 'group',
			'show_on' => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_franchise_opportunity.php',
					'templates/template-sst_client_exhibit.php',
					'templates/template-sst_services.php',
					'templates/template-sst_thank_you_new.php',
					'templates/template-sst_404.php',
				]
			],
			'options' => [
				'group_title'   => __( 'Banner {#}', $prefix ),
				'add_button'    => __( 'Add Another Banner', $prefix ),
				'remove_button' => __( 'Remove banner', $prefix ),
				'sortable'      => true,
			],
			'fields'  => [
				[
					'name'    => __( 'Banner Background Image', $prefix ),
					'desc'    => __( 'Upload background image', $prefix ),
					'id'      => $prefix . '_banner_slider_bg',
					'type'    => 'file',
					'options' => [
						'url' => false,
					],
				],
				[
					'name'    => __( 'Banner Image', $prefix ),
					'desc'    => __( 'Upload an image', $prefix ),
					'id'      => $prefix . '_banner_slider_img',
					'type'    => 'file',
					'options' => [
						'url' => false,
					],
				],
				[
					'name' => __( 'Banner Content', $prefix ),
					'desc' => __( 'Add banner content', $prefix ),
					'id'   => $prefix . '_banner_slider_content',
					'type' => 'wysiwyg',
				],
				[
					'name' => __( 'Banner button text', $prefix ),
					'desc' => __( 'Add banner button text', $prefix ),
					'id'   => $prefix . '_banner_slider_btn_txt',
					'type' => 'text',
				],
				[
					'name'      => __( 'Banner button URL', $prefix ),
					'desc'      => __( 'field description (optional)', $prefix ),
					'id'        => $prefix . '_banner_slider_btn_url',
					'type'      => 'text_url',
					'protocols' => [ 'http', 'https' ]
				]
			]
		] );
		#endregion

		#region Franchise Opportunity about list
		$franchise_about_list = new_cmb2_box( [
			'id'           => $prefix . '_franchise_about_list',
			'title'        => __( 'About List For Franchise Opportunity', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_franchise_opportunity.php'
			]
		] );
		$franchise_about_list->add_field( [
			'name'    => __( 'About List', $prefix ),
			'desc'    => __( 'About List', $prefix ),
			'id'      => $prefix . '_about_list_group',
			'type'    => 'group',
			'show_on' => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_franchise_opportunity.php',
					'templates/template-sst_client_exhibit.php',
				]
			],
			'options' => [
				'group_title'   => __( 'About Item {#}', $prefix ),
				// since version 1.1.4, {#} gets replaced by row number
				'add_button'    => __( 'Add Another Item', $prefix ),
				'remove_button' => __( 'Remove Item', $prefix ),
				'sortable'      => true,
			],
			'fields'  => [
				[
					'name'    => __( 'About Item Image', $prefix ),
					'desc'    => __( 'Upload about image', $prefix ),
					'id'      => $prefix . '_about_item_image',
					'type'    => 'file',
					'options' => [
						'url' => false,
					],
				],
				[
					'name' => __( 'About Item Content', $prefix ),
					'desc' => __( 'Add about content', $prefix ),
					'id'   => $prefix . '_about_item_content',
					'type' => 'wysiwyg',
				]
			]
		] );
		#endregion

		#region Info About Business
		$info_about_business_list = new_cmb2_box( [
			'id'           => $prefix . '_business_info',
			'title'        => __( 'Business Info', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_franchise_opportunity.php'
			]
		] );
		$info_about_business_list->add_field( [
			'name' => __( 'Business Title', $prefix ),
			'desc' => __( 'Business title', $prefix ),
			'id'   => $prefix . '_business_title',
			'type' => 'text',
		] );
		$info_about_business_list->add_field( [
			'name'    => __( 'Business Contents', $prefix ),
			'desc'    => __( 'Business Contents', $prefix ),
			'id'      => $prefix . '_business_info_group',
			'type'    => 'group',
			'show_on' => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_franchise_opportunity.php',
					'templates/template-sst_client_exhibit.php',
				]
			],
			'options' => [
				'group_title'   => __( 'Business Info Item {#}', $prefix ),
				// since version 1.1.4, {#} gets replaced by row number
				'add_button'    => __( 'Add Another Item', $prefix ),
				'remove_button' => __( 'Remove Item', $prefix ),
				'sortable'      => true,
				// beta
				// 'closed'     => true, // true to have the groups closed by default
			],
			'fields'  => [
				[
					'name' => __( 'Business Info Title', $prefix ),
					'desc' => __( 'Upload business info title', $prefix ),
					'id'   => $prefix . '_business_info_title',
					'type' => 'text',
				],
				[
					'name' => __( 'Business Info Content', $prefix ),
					'desc' => __( 'Business info content', $prefix ),
					'id'   => $prefix . '_business_info_content',
					'type' => 'textarea',
				]
			]
		] );
		#endregion

		#region Areas reviewed & planned
		$areas_reviewed_planned = new_cmb2_box( [
			'id'           => $prefix . '_review_plan',
			'title'        => __( 'Areas reviewed & planned', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_event_detail.php'
			]
		] );
		$areas_reviewed_planned->add_field( [
			'name' => __( 'Review & Plan Content', $prefix ),
			'desc' => __( 'Review & Plan content', $prefix ),
			'id'   => $prefix . '_review_plan_content',
			'type' => 'wysiwyg',
		] );
		$areas_reviewed_planned->add_field( [
			'name' => __( 'Review & Plan Bonus', $prefix ),
			'desc' => __( 'Review & Plan Bonus', $prefix ),
			'id'   => $prefix . '_review_plan_bonus',
			'type' => 'textarea',
		] );
		#endregion

		#region VIP Experience
		$vip_experience = new_cmb2_box( [
			'id'           => $prefix . '_vip_experience',
			'title'        => __( 'VIP Experience', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_event_detail.php'
			]
		] );

		$vip_experience->add_field( [
			'name' => __( 'VIP Experience Content', $prefix ),
			'desc' => __( 'Add VIP Experience Content', $prefix ),
			'id'   => $prefix . '_vip_experience_content',
			'type' => 'wysiwyg'
		] );
		#endregion

		#region Team Template Section's Fields
		$team_template_fields = new_cmb2_box( [
			'id'           => $prefix . '_team_template_sections',
			'title'        => __( 'Team Template Sections', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_team_template.php'
			]
		] );
		$team_template_fields->add_field( [
			'name'    => __( 'Team Template Sections', $prefix ),
			'desc'    => __( 'Team Template Section\'s Contents', $prefix ),
			'id'      => $prefix . '_team_template_sections_group',
			'type'    => 'group',
			'show_on' => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_team_template.php'
			],
			'options' => [
				'group_title'   => __( 'Team Section\'s Item {#}', $prefix ),
				'add_button'    => __( 'Add Another Item', $prefix ),
				'remove_button' => __( 'Remove Item', $prefix ),
				'sortable'      => true,
			],
			'fields'  => [
				[
					'name'    => __( 'Section Layout', $prefix ),
					'desc'    => __( 'Please, select layout if needed.', $prefix ),
					'id'      => $prefix . '_team_section_layout',
					'type'    => 'select',
					'default' => 'fullwidth',
					'options' => [
						'fullwidth' => __( 'Fullwidth Section', $prefix ),
						'square'    => __( 'Square Section', $prefix ),
					],
				],
				[
					'name' => __( 'Theme Color', $prefix ),
					'desc' => __( 'Choose theme color', $prefix ),
					'id'   => $prefix . '_team_section_theme_color',
					'type' => 'colorpicker',
				],
				[
					'name'    => __( 'Font Color', $prefix ),
					'desc'    => __( 'Please, select theme color if needed.', $prefix ),
					'id'      => $prefix . '_team_section_font_color',
					'type'    => 'select',
					'default' => 'light',
					'options' => [
						'light' => __( 'Light Color', $prefix ),
						'dark'  => __( 'Dark Color', $prefix ),
					],
				],
				[
					'name'    => __( 'Team Section Image', $prefix ),
					'desc'    => __( 'Add team section image', $prefix ),
					'id'      => $prefix . '_team_section_image',
					'type'    => 'file',
					'options' => [
						'url' => false,
					],
				],
				[
					'name' => __( 'Team Section Title', $prefix ),
					'desc' => __( 'Add team section title', $prefix ),
					'id'   => $prefix . '_team_section_title',
					'type' => 'text',
				],
				[
					'name' => __( 'Team Section Tag', $prefix ),
					'desc' => __( 'Add team section tag', $prefix ),
					'id'   => $prefix . '_team_section_tag',
					'type' => 'text',
				],
				[
					'name' => __( 'Team Section Content', $prefix ),
					'desc' => __( 'Add team section\'s content', $prefix ),
					'id'   => $prefix . '_team_section_content',
					'type' => 'textarea',
				],
				[
					'name' => __( 'Team Section Button', $prefix ),
					'desc' => __( 'Add team section button', $prefix ),
					'id'   => $prefix . '_team_section_button',
					'type' => 'text',
				],
				[
					'name' => __( 'Team Section Button URL', $prefix ),
					'desc' => __( 'Add team section button url', $prefix ),
					'id'   => $prefix . '_team_section_button_url',
					'type' => 'text',
				],
				[
					'name' => __( 'Led By\'s Title', $prefix ),
					'desc' => __( 'Add led by\'s title', $prefix ),
					'id'   => $prefix . '_team_led_by_title',
					'type' => 'text',
				],
				[
					'name'    => __( 'Led By\'s Image', $prefix ),
					'desc'    => __( 'Add led by\'s image', $prefix ),
					'id'      => $prefix . '_team_led_by_image',
					'type'    => 'file',
					'options' => [
						'url' => false,
					],
				],
				[
					'name' => __( 'Led By\'s Name', $prefix ),
					'desc' => __( 'Add led by\'s name', $prefix ),
					'id'   => $prefix . '_team_led_by_name',
					'type' => 'text',
				],
				[
					'name' => __( 'Team Captain\'s Title', $prefix ),
					'desc' => __( 'Add captain\'s title', $prefix ),
					'id'   => $prefix . '_team_captain_title',
					'type' => 'text',
				],
				[
					'name'    => __( 'Team Captain\'s Image', $prefix ),
					'desc'    => __( 'Add captain\'s image', $prefix ),
					'id'      => $prefix . '_team_captain_img',
					'type'    => 'file',
					'options' => [
						'url' => false,
					],
				],
				[
					'name' => __( 'Team Captain\'s Name', $prefix ),
					'desc' => __( 'Add captain\'s name', $prefix ),
					'id'   => $prefix . '_team_captain_name',
					'type' => 'text',
				]
			]
		] );
		#endregion

		#region Team Detail Page Banner
		$team_detail_banner = new_cmb2_box( [
			'id'           => $prefix . '_team_detail_banner',
			'title'        => __( 'Team Detail Page Banner', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_team_detail.php'
			]
		] );
		$team_detail_banner->add_field( [
			'name' => __( 'Banner Background Image', $prefix ),
			'desc' => __( 'Add banner background image', $prefix ),
			'id'   => $prefix . '_team_banner_bg_image',
			'type' => 'file'
		] );
		$team_detail_banner->add_field( [
			'name' => __( 'Banner Image', $prefix ),
			'desc' => __( 'Add banner image', $prefix ),
			'id'   => $prefix . '_team_banner_image',
			'type' => 'file'
		] );
		$team_detail_banner->add_field( [
			'name' => __( 'Banner Content', $prefix ),
			'desc' => __( 'Add banner content', $prefix ),
			'id'   => $prefix . '_team_banner_content',
			'type' => 'wysiwyg'
		] );
		$team_detail_banner->add_field( [
			'name' => __( 'Banner Bottom Content', $prefix ),
			'desc' => __( 'Add banner bottom content', $prefix ),
			'id'   => $prefix . '_team_banner_bottom_content',
			'type' => 'wysiwyg'
		] );
		#endregion

		#region Team Template Contact Info
		$team_template_contact = new_cmb2_box( [
			'id'           => $prefix . '_team_template_contact',
			'title'        => __( 'Team Template Contact Bottom Section', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_team_template.php',
					'templates/template-sst_team_detail.php'
				]
			]
		] );
		$team_template_contact->add_field( [
			'name' => __( 'Team Contact Title', $prefix ),
			'desc' => __( 'Add team contact title', $prefix ),
			'id'   => $prefix . '_team_contact_title',
			'type' => 'text'
		] );
		$team_template_contact->add_field( [
			'name' => __( 'Team Contact Number', $prefix ),
			'desc' => __( 'Add team contact number', $prefix ),
			'id'   => $prefix . '_team_contact_number',
			'type' => 'text'
		] );
		$team_template_contact->add_field( [
			'name' => __( 'Click To Call Button Text', $prefix ),
			'desc' => __( 'Add click to call button text', $prefix ),
			'id'   => $prefix . '_team_click_to_call_text',
			'type' => 'text'
		] );
		$team_template_contact->add_field( [
			'name' => __( 'More Button Text', $prefix ),
			'desc' => __( 'Add more button text', $prefix ),
			'id'   => $prefix . '_team_more_text',
			'type' => 'text'
		] );
		$team_template_contact->add_field( [
			'name' => __( 'More Button URL', $prefix ),
			'desc' => __( 'Add more button url', $prefix ),
			'id'   => $prefix . '_team_more_url',
			'type' => 'text'
		] );
		#endregion

		#region Locations page Banner
		$location_banner = new_cmb2_box( [
			'id'           => $prefix . '_location_page_banner',
			'title'        => __( 'Location Banner', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-location1.php',
					'templates/template-location_detail.php',
				]
			]
		] );

		$location_banner->add_field( [
			'name'            => __( 'Location Banner Map', $prefix ),
			'desc'            => __( 'Add map data, $prefix ' ),
			'id'              => $prefix . '_location_banner_map',
			'type'            => 'textarea',
			'sanitization_cb' => false
		] );
		$location_banner->add_field( [
			'name'            => __( 'Location Banner Content', $prefix ),
			'desc'            => __( 'Add banner content, $prefix ' ),
			'id'              => $prefix . '_location_banner_content',
			'type'            => 'wysiwyg',
			'sanitization_cb' => false
		] );
		#endregion

		#region Locations content
		$location_content = new_cmb2_box( [
			'id'           => $prefix . '_location_page_content',
			'title'        => __( 'Location Content', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-location_detail.php'
			]
		] );
		$location_content->add_field( [
			'name' => __( 'Location Address', $prefix ),
			'desc' => __( 'Add location address, $prefix ' ),
			'id'   => $prefix . '_location_address',
			'type' => 'textarea'
		] );
		$location_content->add_field( [
			'name' => __( 'Location Phone', $prefix ),
			'desc' => __( 'Add location phone, $prefix ' ),
			'id'   => $prefix . '_location_phone',
			'type' => 'textarea'
		] );
		$location_content->add_field( [
			'name' => __( 'Location Time', $prefix ),
			'desc' => __( 'Add location time, $prefix ' ),
			'id'   => $prefix . '_location_time',
			'type' => 'textarea'
		] );
		#endregion

		#region Offer Page Fields
		$offer_page_fields = new_cmb2_box( [
			'id'           => $prefix . '_offer_page_fields',
			'title'        => __( 'Offer Content\'s Fields', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_offer1.php',
					'templates/template-sst_offer2.php',
					'templates/template-sst_offer3.php'
				]
			]
		] );

		$offer_page_fields->add_field( [
			'name' => __( 'Banner Background Image', $prefix ),
			'desc' => __( 'Add banner background image, $prefix' ),
			'id'   => $prefix . '_banner_bg_image',
			'type' => 'file'
		] );
		$offer_page_fields->add_field( [
			'name' => __( 'Offer Title', $prefix ),
			'desc' => __( 'Add offer title, $prefix' ),
			'id'   => $prefix . '_offer_title',
			'type' => 'text'
		] );
		$offer_page_fields->add_field( [
			'name' => __( 'Offer Sub-Title', $prefix ),
			'desc' => __( 'Add offer sub-title, $prefix' ),
			'id'   => $prefix . '_offer_sub_title',
			'type' => 'text'
		] );
		$offer_page_fields->add_field( [
			'name' => __( 'Offer Description', $prefix ),
			'desc' => __( 'Add offer description, $prefix' ),
			'id'   => $prefix . '_offer_description',
			'type' => 'textarea'
		] );
		#endregion

		#region Landing Banner
		$landing_banner = new_cmb2_box( [
			'id'           => $prefix . '_landing_page_banner',
			'title'        => __( 'Landing Banner', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_landing_page1.php',
					'templates/template-sst_before_after.php',
				]
			]
		] );

		$landing_banner->add_field( [
			'name' => __( 'Banner Image', $prefix ),
			'desc' => __( 'Add banner image, $prefix ' ),
			'id'   => $prefix . '_landing_banner_image',
			'type' => 'file'
		] );

		$landing_banner->add_field( [
			'name' => __( 'Banner Content', $prefix ),
			'desc' => __( 'Add banner content, $prefix ' ),
			'id'   => $prefix . '_landing_banner_content',
			'type' => 'wysiwyg'
		] );
		#endregion

		#region Landing page theme option
		$landing1_theme = new_cmb2_box( [
			'id'           => '_landing1_theme',
			'title'        => __( 'Landing Page Theme Settings', '_mok' ),
			'object_types' => [ 'page' ],
			'context'      => 'side',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_landing_page1.php' ]
			]
		] );
		$landing1_theme->add_field( [
			'name'    => __( 'Title Color', '_mok' ),
			'desc'    => __( '', '_mok' ),
			'id'      => $prefix . '_landing1_title_color',
			'type'    => 'colorpicker',
			'default' => '#1c9bf1',
		] );
		$landing1_theme->add_field( [
			'name'    => __( 'Button Color', '_mok' ),
			'desc'    => __( '', '_mok' ),
			'id'      => $prefix . '_landing1_button_color',
			'type'    => 'colorpicker',
			'default' => '#f99a48',
		] );
		#endregion

		#region Landing Media
		$landing_media = new_cmb2_box( [
			'id'           => $prefix . '_landing_media',
			'title'        => __( 'Landing Media', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_landing_page1.php'
			]
		] );

		$landing_media->add_field( [
			'name' => __( 'Video Cover Image', $prefix ),
			'desc' => __( 'Add video cover image' . $prefix ),
			'id'   => $prefix . '_landing_video_cover',
			'type' => 'file'
		] );

		$landing_media->add_field( [
			'name'            => __( 'Media File', $prefix ),
			'desc'            => __( 'Add media url, $prefix ' ),
			'id'              => $prefix . '_landing_media_file',
			'type'            => 'oembed',
			'sanitization_cb' => false
		] );

		$landing_media->add_field( [
			'name' => __( 'Media Content', $prefix ),
			'desc' => __( 'Add media content, $prefix ' ),
			'id'   => $prefix . '_landing_media_content',
			'type' => 'wysiwyg'
		] );
		#endregion

		#region Landing_Results
		$landing_result_content = new_cmb2_box( [
			'id'           => $prefix . '_result_content',
			'title'        => __( 'Result\'s Contents', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_landing_page1.php',
					'templates/template-sst_before_after.php',
				]
			]
		] );
		$landing_result_content->add_field( [
			'name' => __( 'Result\'s Title', $prefix ),
			'desc' => __( 'Add result\'s title, $prefix ' ),
			'id'   => $prefix . '_results_title',
			'type' => 'text'
		] );
		$landing_result_content->add_field( [
			'name'    => __( 'Result\'s Contents', $prefix ),
			'desc'    => __( 'Add result\'s contents', $prefix ),
			'id'      => $prefix . '_result_content_group',
			'type'    => 'group',
			'show_on' => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_landing_page1.php',
					'templates/template-sst_before_after.php',
				]
			],
			'options' => [
				'group_title'   => __( 'Results {#}', $prefix ),
				// since version 1.1.4, {#} gets replaced by row number
				'add_button'    => __( 'Add Another Result', $prefix ),
				'remove_button' => __( 'Remove Result', $prefix ),
				'sortable'      => true,
				// beta
				// 'closed'     => true, // true to have the groups closed by default
			],
			'fields'  => [
				[
					'name' => __( 'Vertical Menu Icon', $prefix ),
					'desc' => __( 'Upload Icon image', $prefix ),
					'id'   => $prefix . '_vertical_menu_icon',
					'type' => 'file',
				],
				[
					'name' => __( 'Vertical Menu Text', $prefix ),
					'desc' => __( 'Add menu text', $prefix ),
					'id'   => $prefix . '_vertical_menu_text',
					'type' => 'text',
				],
				[
					'name' => __( 'Female - Before Image', $prefix ),
					'desc' => __( 'Add before image for female', $prefix ),
					'id'   => $prefix . '_female_before_image',
					'type' => 'file',
				],
				[
					'name' => __( 'Female - After Image', $prefix ),
					'desc' => __( 'Add after image for female', $prefix ),
					'id'   => $prefix . '_female_after_image',
					'type' => 'file',
				],
				[
					'name' => __( 'Female - Duration Text', $prefix ),
					'desc' => __( 'Add duration in days for female', $prefix ),
					'id'   => $prefix . '_female_after_text',
					'type' => 'text',
				],
				[
					'name' => __( 'Male - Before Image', $prefix ),
					'desc' => __( 'Add before image for male', $prefix ),
					'id'   => $prefix . '_male_before_image',
					'type' => 'file',
				],
				[
					'name' => __( 'Male - After Image', $prefix ),
					'desc' => __( 'Add after image for male', $prefix ),
					'id'   => $prefix . '_male_after_image',
					'type' => 'file',
				],
				[
					'name' => __( 'Male - Duration Text', $prefix ),
					'desc' => __( 'Add duration in days for male', $prefix ),
					'id'   => $prefix . '_male_after_text',
					'type' => 'text',
				]
			]
		] );
		#endregion

		#region Landing Contact
		$landing_contact = new_cmb2_box( [
			'id'           => $prefix . '_landing_contact',
			'title'        => __( 'Landing Contact Section', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_landing_page1.php'
			]
		] );
		$landing_contact->add_field( [
			'name' => __( 'Landing Contact Background', $prefix ),
			'desc' => __( 'Add contact background, $prefix ' ),
			'id'   => $prefix . '_landing_contact_background',
			'type' => 'file'
		] );
		$landing_contact->add_field( [
			'name' => __( 'Landing Contact Section', $prefix ),
			'desc' => __( 'Add contact content, $prefix ' ),
			'id'   => $prefix . '_landing_contact_content',
			'type' => 'wysiwyg'
		] );
		#endregion

		#region Landing Bottom Section
		$landing_bottom = new_cmb2_box( [
			'id'           => $prefix . '_landing_bottom',
			'title'        => __( 'Landing Bottom Section', $prefix ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_landing_page1.php'
			]
		] );
		$landing_bottom->add_field( [
			'name' => __( 'Landing Bottom Section', $prefix ),
			'desc' => __( 'Add bottom content, $prefix ' ),
			'id'   => $prefix . '_landing_bottom_content',
			'type' => 'wysiwyg'
		] );
		#endregion

		#region therapy additional with results groups
		$therapy_restus = new_cmb2_box( [
			'id'           => $prefix . '_therapy_content',
			'title'        => __( 'Therapy\'s Contents', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_before_after.php'
			]
		] );
		$therapy_restus->add_field( [
			'name' => __( 'Therapy\'s Title', $prefix ),
			'desc' => __( 'Add therapy\'s title, $prefix ' ),
			'id'   => $prefix . '_therapy_title',
			'type' => 'text'
		] );
		$therapy_restus->add_field( [
			'name'    => __( 'Therapy\'s Contents', $prefix ),
			'desc'    => __( 'Add therapy\'s contents', $prefix ),
			'id'      => $prefix . '_therapy_content_group',
			'type'    => 'group',
			'show_on' => [
				'key'   => 'page-template',
				'value' => 'templates/template-sst_before_after.php'
			],
			'options' => [
				'group_title'   => __( 'Results {#}', $prefix ),
				// since version 1.1.4, {#} gets replaced by row number
				'add_button'    => __( 'Add Another Result', $prefix ),
				'remove_button' => __( 'Remove Result', $prefix ),
				'sortable'      => true,
				// beta
				// 'closed'     => true, // true to have the groups closed by default
			],
			'fields'  => [
				[
					'name' => __( 'Vertical Menu Icon', $prefix ),
					'desc' => __( 'Upload Icon image', $prefix ),
					'id'   => $prefix . '_vertical_menu_icon',
					'type' => 'file',
				],
				[
					'name' => __( 'Vertical Menu Text', $prefix ),
					'desc' => __( 'Add menu text', $prefix ),
					'id'   => $prefix . '_vertical_menu_text',
					'type' => 'text',
				],
				[
					'name' => __( 'Female - Before Image', $prefix ),
					'desc' => __( 'Add before image for female', $prefix ),
					'id'   => $prefix . '_female_before_image',
					'type' => 'file',
				],
				[
					'name' => __( 'Female - After Image', $prefix ),
					'desc' => __( 'Add after image for female', $prefix ),
					'id'   => $prefix . '_female_after_image',
					'type' => 'file',
				],
				[
					'name' => __( 'Female - Duration Text', $prefix ),
					'desc' => __( 'Add duration in days for female', $prefix ),
					'id'   => $prefix . '_female_after_text',
					'type' => 'text',
				],
				[
					'name' => __( 'Male - Before Image', $prefix ),
					'desc' => __( 'Add before image for male', $prefix ),
					'id'   => $prefix . '_male_before_image',
					'type' => 'file',
				],
				[
					'name' => __( 'Male - After Image', $prefix ),
					'desc' => __( 'Add after image for male', $prefix ),
					'id'   => $prefix . '_male_after_image',
					'type' => 'file',
				],
				[
					'name' => __( 'Male - Duration Text', $prefix ),
					'desc' => __( 'Add duration in days for male', $prefix ),
					'id'   => $prefix . '_male_after_text',
					'type' => 'text',
				]
			]
		] );
		#endregion

		#region Events with form
		$events_header_section = new_cmb2_box( [
			'id'           => '_events_header',
			'title'        => __( 'Header Section', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_events1.php' ]
			]
		] );

		$events_header_section->add_field( [
			'name' => __( 'Logo', '_mok' ),
			'desc' => __( 'Add logo', '_mok' ),
			'id'   => '_event_header_logo',
			'type' => 'file'
		] );

		$events_header_section->add_field( [
			'name' => __( 'Organization Name', '_mok' ),
			'desc' => __( 'Add Organization Name', '_mok' ),
			'id'   => '_event_header_organization',
			'type' => 'text'
		] );

		$events_header_section->add_field( [
			'name' => __( 'Phone Number', '_mok' ),
			'desc' => __( 'Add Phone Number', '_mok' ),
			'id'   => '_event_header_phone',
			'type' => 'text'
		] );

		$events_header_section->add_field( [
			'name' => __( 'Image right to the title', '_mok' ),
			'desc' => __( 'Add image right to the title', '_mok' ),
			'id'   => '_event_header_right_image',
			'type' => 'file'
		] );

		$events_below_header_section = new_cmb2_box( [
			'id'           => '_events_below_header',
			'title'        => __( 'Section below header', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_events1.php' ]
			]
		] );

		$events_below_header_section->add_field( [
			'name' => __( 'Location', '_mok' ),
			'desc' => __( 'Add electronics recycling fundraiser location', '_mok' ),
			'id'   => '_events_below_header_location',
			'type' => 'text'
		] );

		$events_below_header_section->add_field( [
			'name' => __( 'Title', '_mok' ),
			'desc' => __( 'Add Title', '_mok' ),
			'id'   => '_events_below_header_title',
			'type' => 'text'
		] );

		$events_below_header_section->add_field( [
			'name' => __( 'Short Description', '_mok' ),
			'desc' => __( 'Add short description below header', '_mok' ),
			'id'   => '_events_below_header_short_desc',
			'type' => 'textarea'
		] );

		$events_below_header_section->add_field( [
			'name' => __( 'Long Description', '_mok' ),
			'desc' => __( 'Add long description below short description', '_mok' ),
			'id'   => '_events_below_header_long_desc',
			'type' => 'wysiwyg'
		] );

		$events_next_events_section = new_cmb2_box( [
			'id'           => '_events_next_events',
			'title'        => __( 'Next Event Date', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_events1.php' ]
			]
		] );

		$events_next_events_section->add_field( [
			'name' => __( 'Date', '_mok' ),
			'desc' => __( '', '_mok' ),
			'id'   => '_events_next_events_date',
			'type' => 'text_date'
		] );

		$events_first_section_below_total_raised_section = new_cmb2_box( [
			'id'           => '_events_first_section_below_total_raised',
			'title'        => __( 'First Section Below Total Raised', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_events1.php' ]
			]
		] );

		$events_first_section_below_total_raised_section->add_field( [
			'name'        => __( 'Block', '_mok' ),
			'id'          => '_events_first_section_list',
			'type'        => 'group',
			'description' => __( 'Add block', '_mok' ),
			'options'     => [
				'group_title'   => __( 'Block {#}', '_mok' ),
				'add_button'    => __( 'Add More Block', '_mok' ),
				'remove_button' => __( 'Remove Block', '_mok' ),
				'sortable'      => true
			],
			'fields'      => [
				[
					'name' => 'Title',
					'id'   => 'title',
					'type' => 'text'
				],
				[
					'name' => 'Description',
					'id'   => 'description',
					'type' => 'wysiwyg'
				],
				[
					'name' => __( 'Event Location', '_mok' ),
					'desc' => __( 'Add Event location', '_mok' ),
					'id'   => '_event_location',
					'type' => 'textarea'
				],
				[
					'name' => __( 'Event Date', '_mok' ),
					'desc' => __( 'Add Event Date Time', '_mok' ),
					'id'   => '_event_date_time',
					'type' => 'textarea'
				],
				[
					'name' => 'Link',
					'id'   => 'link',
					'type' => 'text_url'
				],
				[
					'name' => 'Thumbnail',
					'id'   => 'thumbnail',
					'type' => 'file'
				]
			]
		] );

		$events_total_raised_section = new_cmb2_box( [
			'id'           => '_events_total_raised',
			'title'        => __( 'Total Raised Section', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_events1.php' ]
			]
		] );

		$events_total_raised_section->add_field( [
			'name'            => __( 'Total Raised Title', '_mok' ),
			'desc'            => __( 'Add Total Raised Title', '_mok' ),
			'id'              => '_events_total_amount_title',
			'type'            => 'text',
			'sanitization_cb' => false
		] );

		$events_total_raised_section->add_field( [
			'name' => __( 'Total', '_mok' ),
			'desc' => __( 'Add Total', '_mok' ),
			'id'   => '_events_total_amount',
			'type' => 'text'
		] );

		$events_second_section_below_total_raised_section = new_cmb2_box( [
			'id'           => '_events_second_section_below_total_raised',
			'title'        => __( 'Second Section Below Total Raised Section', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_events1.php' ]
			]
		] );

		$events_second_section_below_total_raised_section->add_field( [
			'name'        => __( 'Blocks', '_mok' ),
			'id'          => '_events_second_section_list',
			'type'        => 'group',
			'description' => __( 'Add block', '_mok' ),
			'options'     => [
				'group_title'   => __( 'Block {#}', '_mok' ),
				'add_button'    => __( 'Add More Block', '_mok' ),
				'remove_button' => __( 'Remove Block', '_mok' ),
				'sortable'      => true
			],
			'fields'      => [
				[
					'name'            => 'Title',
					'id'              => 'title',
					'type'            => 'text',
					'sanitization_cb' => false
				],
				[
					'name' => 'Description',
					'id'   => 'description',
					'type' => 'wysiwyg'
				],
				[
					'name' => 'Thumbnail',
					'id'   => 'thumbnail',
					'type' => 'file'
				],
				[
					'name' => 'Flyer',
					'id'   => 'flyer',
					'type' => 'file',
					'desc' => 'Flyer will be shown in fourth block only'
				]
			]
		] );

		$events_past_events_section = new_cmb2_box( [
			'id'           => '_events_past_events',
			'title'        => __( 'Past Events', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_events1.php' ]
			]
		] );

		$events_past_events_section->add_field( [
			'name'        => __( 'Events', '_mok' ),
			'id'          => '_events_past_events_list',
			'type'        => 'group',
			'description' => __( 'Add Events', '_mok' ),
			'options'     => [
				'group_title'   => __( 'Event {#}', '_mok' ),
				'add_button'    => __( 'Add More Event', '_mok' ),
				'remove_button' => __( 'Remove Event', '_mok' ),
				'sortable'      => true
			],
			'fields'      => [
				[
					'name' => 'Title',
					'id'   => 'title',
					'type' => 'text'
				],
				[
					'name' => 'Description',
					'id'   => 'description',
					'type' => 'wysiwyg'
				],
				[
					'name' => 'Images',
					'id'   => 'image',
					'type' => 'file_list'
				],
				[
					'name' => 'Total Raised',
					'id'   => 'total_raised',
					'type' => 'text'
				],
				[
					'name'        => 'Date',
					'id'          => 'date',
					'type'        => 'text_date',
					'date_format' => 'M d, Y'
				]
			]
		] );
		#endregion

		#region Fields for Landing Page 2
		$landing_theme = new_cmb2_box( [
			'id'           => '_landing_theme',
			'title'        => __( 'Landing Page Theme Settings', '_mok' ),
			'object_types' => [ 'page' ],
			'context'      => 'side',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_landing_page2.php' ]
			]
		] );
		$landing_theme->add_field( [
			'name'    => __( 'Theme Color', '_mok' ),
			'desc'    => __( '', '_mok' ),
			'id'      => $prefix . '_landing_theme_color',
			'type'    => 'colorpicker',
			'default' => '#1c9bf1',
		] );
		$landing_theme->add_field( [
			'name'    => __( 'Billboard Brand Watermark', '_mok' ),
			'desc'    => __( '', '_mok' ),
			'id'      => $prefix . '_landing_theme_billboard_watermark',
			'type'    => 'file',
			'options' => [ 'url' => false ],
		] );
		$landing_theme->add_field( [
			'name'    => __( 'Slider Indicator Icon', '_mok' ),
			'desc'    => __( '', '_mok' ),
			'id'      => $prefix . '_landing_theme_slider_icon',
			'type'    => 'file',
			'options' => [ 'url' => false ],
		] );
		$landing_theme->add_field( [
			'name'    => __( 'Slider Indicator Inverse Icon', '_mok' ),
			'desc'    => __( '', '_mok' ),
			'id'      => $prefix . '_landing_theme_slider_inverse_icon',
			'type'    => 'file',
			'options' => [ 'url' => false ],
		] );
		$landing_theme->add_field( [
			'name'    => __( 'Footer Brand Watermark', '_mok' ),
			'desc'    => __( '', '_mok' ),
			'id'      => $prefix . '_landing_theme_footer_watermark',
			'type'    => 'file',
			'options' => [ 'url' => false ],
		] );
		$landing_index_fields = new_cmb2_box( [
			'id'           => '_landing_index_fields',
			'title'        => __( 'Landing Index Fields', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_landing_page2.php' ]
			]
		] );
		$landing_index_fields->add_field( [
			'name' => __( 'Index Image', '_mok' ),
			'desc' => __( 'Add index image', '_mok' ),
			'id'   => $prefix . '_landing_index_image',
			'type' => 'file'
		] );
		$landing_index_fields->add_field( [
			'name' => __( 'Logo Image', '_mok' ),
			'desc' => __( 'Add logo image', '_mok' ),
			'id'   => $prefix . '_logo_image',
			'type' => 'file'
		] );
		$landing_index_fields->add_field( [
			'name' => __( 'Index Content', '_mok' ),
			'desc' => __( 'Add index content', '_mok' ),
			'id'   => $prefix . '_index_content',
			'type' => 'wysiwyg'
		] );
		$landing_index_fields->add_field( [
			'name' => __( 'Button Text', '_mok' ),
			'desc' => __( 'Add button text', '_mok' ),
			'id'   => $prefix . '_button_text',
			'type' => 'text'
		] );
		$landing_index_fields->add_field( [
			'name'      => __( 'Button URL', '_mok' ),
			'desc'      => __( 'Add button url', '_mok' ),
			'id'        => $prefix . '_button_url',
			'type'      => 'text_url',
			'protocols' => [ 'http', 'https' ],
		] );
		$landing_index_fields->add_field( [
			'name' => __( 'Slogan Text Bellow Button', '_mok' ),
			'desc' => __( 'Add slogan text', '_mok' ),
			'id'   => $prefix . '_slogan_text',
			'type' => 'text'
		] );

		$landing_procedure_section = new_cmb2_box( [
			'id'           => '_landing_procedure_section',
			'title'        => __( 'Landing Procedure Section', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_landing_page2.php' ]
			]
		] );
		$landing_procedure_section->add_field( [
			'name' => __( 'Section Title', '_mok' ),
			'desc' => __( 'Add section title', '_mok' ),
			'id'   => $prefix . '_landing_procedure_title',
			'type' => 'text'
		] );
		$landing_procedure_section->add_field( [
			'name' => __( 'Section Sub-Title', '_mok' ),
			'desc' => __( 'Add section sub-title', '_mok' ),
			'id'   => $prefix . '_landing_procedure_sub_title',
			'type' => 'text'
		] );
		$landing_procedure_section->add_field( [
			'name' => __( 'Section Image', '_mok' ),
			'desc' => __( 'Add section image', '_mok' ),
			'id'   => $prefix . '_landing_procedure_image',
			'type' => 'file'
		] );
		$landing_procedure_section->add_field( [
			'name'        => __( 'Procedure Steps', '_mok' ),
			'id'          => $prefix . '_procedure_steps_group',
			'type'        => 'group',
			'description' => __( 'Add Steps', '_mok' ),
			'options'     => [
				'group_title'   => __( 'Step {#}', '_mok' ),
				'add_button'    => __( 'Add More Step', '_mok' ),
				'remove_button' => __( 'Remove Step', '_mok' ),
				'sortable'      => true
			],
			'fields'      => [
				[
					'name' => 'Title',
					'id'   => $prefix . '_title',
					'type' => 'text'
				],
				[
					'name' => 'Images',
					'id'   => $prefix . '_image',
					'type' => 'file'
				],
				[
					'name' => 'Description',
					'id'   => $prefix . '_description',
					'type' => 'wysiwyg'
				]
			]
		] );

		$landing_result_section = new_cmb2_box( [
			'id'           => '_landing_result_section',
			'title'        => __( 'Landing Result Section', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_landing_page2.php' ]
			]
		] );
		$landing_result_section->add_field( [
			'name' => __( 'Section Title', '_mok' ),
			'desc' => __( 'Add section title', '_mok' ),
			'id'   => $prefix . '_landing_result_title',
			'type' => 'text'
		] );
		$landing_result_section->add_field( [
			'name' => __( 'Section Sub-Title', '_mok' ),
			'desc' => __( 'Add section sub-title', '_mok' ),
			'id'   => $prefix . '_landing_result_sub_title',
			'type' => 'text'
		] );
		$landing_result_section->add_field( [
			'name' => __( 'Section Content', '_mok' ),
			'desc' => __( 'Add section content', '_mok' ),
			'id'   => $prefix . '_landing_result_content',
			'type' => 'wysiwyg'
		] );
		$landing_result_section->add_field( [
			'name' => __( 'Result Button Price Text', '_mok' ),
			'desc' => __( 'Add result button price text', '_mok' ),
			'id'   => $prefix . '_result_button_price_text',
			'type' => 'text'
		] );
		$landing_result_section->add_field( [
			'name' => __( 'Result Button Text', '_mok' ),
			'desc' => __( 'Add result button text', '_mok' ),
			'id'   => $prefix . '_result_button_text',
			'type' => 'text'
		] );
		$landing_result_section->add_field( [
			'name'      => __( 'Result Button URL', '_mok' ),
			'desc'      => __( 'Add result button url', '_mok' ),
			'id'        => $prefix . '_result_button_url',
			'type'      => 'text_url',
			'protocols' => [ 'http', 'https' ],
		] );
		$landing_result_section->add_field( [
			'name' => __( 'Result Schedule Link Text', '_mok' ),
			'desc' => __( 'Add result schedule link text', '_mok' ),
			'id'   => $prefix . '_result_schedule_link_text',
			'type' => 'text'
		] );
		$landing_result_section->add_field( [
			'name'      => __( 'Result Schedule Link URL', '_mok' ),
			'desc'      => __( 'Add result schedule link url', '_mok' ),
			'id'        => $prefix . '_result_schedule_link_url',
			'type'      => 'text_url',
			'protocols' => [ 'http', 'https' ],
		] );
		$landing_result_section->add_field( [
			'name'        => __( 'Results', '_mok' ),
			'id'          => $prefix . '_results_group',
			'type'        => 'group',
			'description' => __( 'Add Results', '_mok' ),
			'options'     => [
				'group_title'   => __( 'Result {#}', '_mok' ),
				'add_button'    => __( 'Add More Result', '_mok' ),
				'remove_button' => __( 'Remove Result', '_mok' ),
				'sortable'      => true
			],
			'fields'      => [
				[
					'name' => 'Menu Text',
					'id'   => $prefix . '_menu_text',
					'type' => 'text'
				],
				[
					'name' => 'Menu Icon',
					'id'   => $prefix . '_menu_icon_image',
					'type' => 'file'
				],
				[
					'name' => 'Female (Before Image)',
					'id'   => $prefix . '_female_before_image',
					'type' => 'file'
				],
				[
					'name' => 'Female (After Image)',
					'id'   => $prefix . '_female_after_image',
					'type' => 'file'
				],
				[
					'name' => 'Female (After Text)',
					'id'   => $prefix . '_female_after_text',
					'type' => 'text'
				],
				[
					'name' => 'Male (Before Image)',
					'id'   => $prefix . '_male_before_image',
					'type' => 'file'
				],
				[
					'name' => 'Male (After Image)',
					'id'   => $prefix . '_male_after_image',
					'type' => 'file'
				],
				[
					'name' => 'Male (After Text)',
					'id'   => $prefix . '_male_after_text',
					'type' => 'text'
				]
			]
		] );

		$landing_testimonial_section = new_cmb2_box( [
			'id'           => '_landing_testimonial_section',
			'title'        => __( 'Landing Testimonial Section', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_landing_page2.php' ]
			]
		] );
		$landing_testimonial_section->add_field( [
			'name' => __( 'Section Title', '_mok' ),
			'desc' => __( 'Add section title', '_mok' ),
			'id'   => $prefix . '_landing_testimonial_title',
			'type' => 'text'
		] );
		$landing_testimonial_section->add_field( [
			'name' => __( 'Section Sub-Title', '_mok' ),
			'desc' => __( 'Add section sub-title', '_mok' ),
			'id'   => $prefix . '_landing_testimonial_sub_title',
			'type' => 'text'
		] );
		$landing_testimonial_section->add_field( [
			'name' => __( 'Section Content', '_mok' ),
			'desc' => __( 'Add section content', '_mok' ),
			'id'   => $prefix . '_landing_testimonial_content',
			'type' => 'wysiwyg'
		] );
		$landing_testimonial_section->add_field( [
			'name'        => __( 'Testimonials', '_mok' ),
			'id'          => $prefix . '_testimonials_group',
			'type'        => 'group',
			'description' => __( 'Add Testimonials', '_mok' ),
			'options'     => [
				'group_title'   => __( 'Testimonial {#}', '_mok' ),
				'add_button'    => __( 'Add More Testimonial', '_mok' ),
				'remove_button' => __( 'Remove Testimonial', '_mok' ),
				'sortable'      => true
			],
			'fields'      => [
				[
					'name' => 'Testimonial Image',
					'id'   => $prefix . '_testimonial_image',
					'type' => 'file'
				],
				[
					'name' => 'Testimonial Video',
					'id'   => $prefix . '_testimonial_video',
					'type' => 'oembed'
				],
				[
					'name' => 'Testimonial Content',
					'id'   => $prefix . '_testimonial_content',
					'type' => 'wysiwyg'
				],
				[
					'name' => 'Testimonial Duration',
					'id'   => $prefix . '_testimonial_time',
					'type' => 'text'
				]
			]
		] );
		$landing_about_section = new_cmb2_box( [
			'id'           => '_landing_about_section',
			'title'        => __( 'Landing About Section', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_landing_page2.php' ]
			]
		] );
		$landing_about_section->add_field( [
			'name' => __( 'Section Title', '_mok' ),
			'desc' => __( 'Add section title', '_mok' ),
			'id'   => $prefix . '_landing_about_title',
			'type' => 'text'
		] );
		$landing_about_section->add_field( [
			'name' => __( 'Section Sub-Title', '_mok' ),
			'desc' => __( 'Add section sub-title', '_mok' ),
			'id'   => $prefix . '_landing_about_sub_title',
			'type' => 'text'
		] );
		$landing_about_section->add_field( [
			'name' => __( 'Section Image', '_mok' ),
			'desc' => __( 'Add section image', '_mok' ),
			'id'   => $prefix . '_landing_about_image',
			'type' => 'file'
		] );
		$landing_about_section->add_field( [
			'name' => __( 'Section Video', '_mok' ),
			'desc' => __( 'Add section video', '_mok' ),
			'id'   => $prefix . '_landing_about_video',
			'type' => 'oembed'
		] );
		$landing_about_section->add_field( [
			'name' => __( 'Section Content', '_mok' ),
			'desc' => __( 'Add section content', '_mok' ),
			'id'   => $prefix . '_landing_about_content',
			'type' => 'wysiwyg'
		] );
		$landing_about_section->add_field( [
			'name' => __( 'Button Text', '_mok' ),
			'desc' => __( 'Add button text', '_mok' ),
			'id'   => $prefix . '_about_button_text',
			'type' => 'text'
		] );
		$landing_about_section->add_field( [
			'name'      => __( 'Button URL', '_mok' ),
			'desc'      => __( 'Add button url', '_mok' ),
			'id'        => $prefix . '_about_button_url',
			'type'      => 'text_url',
			'protocols' => [ 'http', 'https' ],
		] );
		$landing_about_section->add_field( [
			'name' => __( 'Slogan Text Bellow Button', '_mok' ),
			'desc' => __( 'Add slogan text', '_mok' ),
			'id'   => $prefix . '_about_slogan_text',
			'type' => 'text'
		] );
		$landing_about_section->add_field( [
			'name' => __( 'Logo Container', '_mok' ),
			'desc' => __( 'Add Logo\'s list', '_mok' ),
			'id'   => $prefix . '_landing_logo_container',
			'type' => 'wysiwyg'
		] );
		$landing_contact_section = new_cmb2_box( [
			'id'           => '_landing_contact_section',
			'title'        => __( 'Landing Contact Section', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_landing_page2.php' ]
			]
		] );
		$landing_contact_section->add_field( [
			'name' => __( 'Section Title', '_mok' ),
			'desc' => __( 'Add section title', '_mok' ),
			'id'   => $prefix . '_landing_contact_title',
			'type' => 'text'
		] );
		$landing_contact_section->add_field( [
			'name' => __( 'Section Image', '_mok' ),
			'desc' => __( 'Add section image', '_mok' ),
			'id'   => $prefix . '_landing_contact_image',
			'type' => 'file'
		] );
		$landing_contact_section->add_field( [
			'name' => __( 'Form Title', '_mok' ),
			'desc' => __( 'Add form title', '_mok' ),
			'id'   => $prefix . '_landing_contact_form_title',
			'type' => 'text'
		] );
		$landing_contact_section->add_field( [
			'name' => __( 'Section Content', '_mok' ),
			'desc' => __( 'Add section content', '_mok' ),
			'id'   => $prefix . '_landing_contact_content',
			'type' => 'wysiwyg'
		] );
		#endregion

		#region Home8 post meta group
		$home8_site_logo = new_cmb2_box( [
			'id'           => '_home8_site_logo_holder',
			'title'        => __( 'Site Logo for this template', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_home8.php' ]
			]
		] );
		$home8_site_logo->add_field( [
			'name' => __( 'Site Logo', '_mok' ),
			'desc' => __( 'Add site logo', '_mok' ),
			'id'   => $prefix . '_home8_site_logo',
			'type' => 'file'
		] );
		#endregion

		#region home8 page banner region
		$home8_banner = new_cmb2_box( [
			'id'           => '_home8_banner',
			'title'        => __( 'Banner', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_home8.php' ]
			]
		] );
		$home8_banner->add_field( [
			'name'        => __( 'Banner Group', '_mok' ),
			'id'          => $prefix . '_home8_banner_group',
			'type'        => 'group',
			'description' => __( 'Add Banner Item', '_mok' ),
			'options'     => [
				'group_title'   => __( 'Banner {#}', '_mok' ),
				'add_button'    => __( 'Add More Banner', '_mok' ),
				'remove_button' => __( 'Remove Banner', '_mok' ),
				'sortable'      => true
			],
			'fields'      => [
				[
					'name' => 'Banner Image',
					'id'   => $prefix . '_banner_image',
					'type' => 'file'
				],
				[
					'name' => 'Banner Content',
					'id'   => $prefix . '_banner_content',
					'type' => 'wysiwyg'
				],
				[
					'name' => 'Button Label',
					'id'   => $prefix . '_button_label',
					'type' => 'text'
				],
				[
					'name' => 'Button URL',
					'id'   => $prefix . '_button_url',
					'type' => 'text_url'
				],
				[
					'name' => 'Blockquote',
					'id'   => $prefix . '_blockquote',
					'type' => 'wysiwyg'
				],
				[
					'name' => 'Author',
					'id'   => $prefix . '_author',
					'type' => 'text'
				],
				[
					'name' => 'Profession',
					'id'   => $prefix . '_designation',
					'type' => 'text'
				],
				[
					'name' => 'Member Since',
					'id'   => $prefix . '_address',
					'type' => 'text'
				]
			]
		] );
		#endregion

		#region home8 Learn/Register region
		$home8_learn_register = new_cmb2_box( [
			'id'           => '_home8_learn_register',
			'title'        => __( 'Learn / Register', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_home8.php' ]
			]
		] );
		$home8_learn_register->add_field( [
			'name' => __( 'Learn Title', '_mok' ),
			'desc' => __( 'Add learn title', '_mok' ),
			'id'   => $prefix . '_home8_learn_title',
			'type' => 'text'
		] );
		$home8_learn_register->add_field( [
			'name' => __( 'Learn Confidential Text', '_mok' ),
			'desc' => __( 'Add confidential text', '_mok' ),
			'id'   => $prefix . '_home8_learn_confidential',
			'type' => 'text'
		] );
		$home8_learn_register->add_field( [
			'name' => __( 'Learn Button Label', '_mok' ),
			'desc' => __( 'Add learn button label', '_mok' ),
			'id'   => $prefix . '_home8_learn_button_label',
			'type' => 'text'
		] );
		$home8_learn_register->add_field( [
			'name' => __( 'Learn Button URL', '_mok' ),
			'desc' => __( 'Add learn button url', '_mok' ),
			'id'   => $prefix . '_home8_learn_button_url',
			'type' => 'text_url'
		] );
		$home8_learn_register->add_field( [
			'name' => __( 'Register Form', '_mok' ),
			'desc' => __( 'Add register Form shortcode eg. [gravityform id="6" title="true" description="true" ajax="true"]', '_mok' ),
			'id'   => $prefix . '_home8_register_form',
			'type' => 'text'
		] );
		#endregion

		#region home8 page article sections region
		$home8_article_sections = new_cmb2_box( [
			'id'           => '_home8_article_section',
			'title'        => __( 'Article Section', '_mok' ),
			'object_types' => [ 'page' ],
			'priority'     => 'high',
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [ 'templates/template-sst_home8.php' ]
			]
		] );
		$home8_article_sections->add_field( [
			'name'        => __( 'Articles', '_mok' ),
			'id'          => $prefix . '_home8_articles_group',
			'type'        => 'group',
			'description' => __( 'Add Article', '_mok' ),
			'options'     => [
				'group_title'   => __( 'Article {#}', '_mok' ),
				'add_button'    => __( 'Add More Article', '_mok' ),
				'remove_button' => __( 'Remove Article', '_mok' ),
				'sortable'      => true
			],
			'fields'      => [
				[
					'name'    => 'Section Background Color',
					'id'      => $prefix . '_section_background_color',
					'type'    => 'colorpicker',
					'default' => '#FFF'
				],
				[
					'name' => 'Article Tag',
					'id'   => $prefix . '_article_tag',
					'type' => 'text'
				],
				[
					'name'            => 'Article Title',
					'id'              => $prefix . '_article_title',
					'type'            => 'text',
					'sanitization_cb' => false
				],
				[
					'name' => 'Article Image',
					'id'   => $prefix . '_article_image',
					'type' => 'file'
				],
				[
					'name' => 'Article Content',
					'id'   => $prefix . '_article_content',
					'type' => 'wysiwyg'
				],
				[
					'name' => 'Read More Label',
					'id'   => $prefix . '_read_more_label',
					'type' => 'text'
				],
				[
					'name' => 'Read More URL',
					'id'   => $prefix . '_read_more_url',
					'type' => 'text_url'
				]
			]
		] );
		#endregion
	}
}
add_action( 'cmb2_admin_init', 'mok_sections', 21 );

#region location post type meta fields
if ( ! function_exists( 'mok_location_meta' ) ) {
	/**
	 * location post type meta fields
	 */
	function mok_location_meta() {
		$prefix          = '_ttm';
		$location_banner = new_cmb2_box( [
			'id'           => $prefix . '_location_banner',
			'title'        => __( 'Banner Details', $prefix ),
			'object_types' => [ 'location' ],
		] );
		$location_banner->add_field( [
			'name' => __( 'Banner Title', $prefix ),
			'id'   => $prefix . '_banner_title',
			'type' => 'wysiwyg',
		] );
		$banner_link_group = $location_banner->add_field( [
			'name'    => __( 'Banner Buttons', $prefix ),
			'id'      => $prefix . '_banner_buttons',
			'type'    => 'group',
			'options' => [
				'group_title'   => __( 'Link {#}', $prefix ),
				'add_button'    => __( 'Add Another Entry', $prefix ),
				'remove_button' => __( 'Remove Entry', $prefix ),
				'sortable'      => true,
			],
		] );
		$location_banner->add_group_field( $banner_link_group, [
			'name' => __( 'Banner Button Link', $prefix ),
			'id'   => $prefix . '_banner_button_link',
			'type' => 'text_url',
		] );
		$location_banner->add_group_field( $banner_link_group, [
			'name' => __( 'Banner Button Label', $prefix ),
			'id'   => $prefix . '_banner_button_label',
			'type' => 'text'
		] );
		$sections = new_cmb2_box( [
			'id'           => $prefix . '_business_address_details',
			'title'        => __( 'Business Address Details', $prefix ),
			'object_types' => [ 'location' ],
		] );
		$sections->add_field( [
			'name'    => __( 'Business Location Closed?', $prefix ),
			'id'      => $prefix . '_business_closed',
			'type'    => 'select',
			'default' => 0,
			'options' => [
				0 => 'Yes',
				1 => 'No'
			]
		] );
		$sections->add_field( [
			'name' => __( 'Business Address', $prefix ),
			'id'   => $prefix . '_business_address',
			'type' => 'text',
		] );
		$sections->add_field( [
			'name' => __( 'Business City', $prefix ),
			'id'   => $prefix . '_business_city',
			'type' => 'text',
		] );
		$sections->add_field( [
			'name' => __( 'Business State', $prefix ),
			'id'   => $prefix . '_business_state',
			'type' => 'text',
		] );
		$sections->add_field( [
			'name' => __( 'Business Zip Code', $prefix ),
			'id'   => $prefix . '_business_zip',
			'type' => 'text',
		] );
		$sections->add_field( [
			'name'    => __( 'Business Country', $prefix ),
			'id'      => $prefix . '_business_country',
			'type'    => 'select',
			'default' => 'US',
			'options' => [
				'AD' => 'Andorra',
				'AE' => 'United Arab Emirates',
				'AF' => 'Afghanistan',
				'AG' => 'Antigua and Barbuda',
				'AI' => 'Anguilla',
				'AL' => 'Albania',
				'AM' => 'Armenia',
				'AN' => 'Netherlands Antilles',
				'AO' => 'Angola',
				'AQ' => 'Antarctica',
				'AR' => 'Argentina',
				'AS' => 'American Samoa',
				'AT' => 'Austria',
				'AU' => 'Australia',
				'AW' => 'Aruba',
				'AX' => 'Åland Islands',
				'AZ' => 'Azerbaijan',
				'BA' => 'Bosnia and Herzegovina',
				'BB' => 'Barbados',
				'BD' => 'Bangladesh',
				'BE' => 'Belgium',
				'BF' => 'Burkina Faso',
				'BG' => 'Bulgaria',
				'BH' => 'Bahrain',
				'BI' => 'Burundi',
				'BJ' => 'Benin',
				'BL' => 'Saint Barthélemy',
				'BM' => 'Bermuda',
				'BN' => 'Brunei',
				'BO' => 'Bolivia',
				'BQ' => 'British Antarctic Territory',
				'BR' => 'Brazil',
				'BS' => 'Bahamas',
				'BT' => 'Bhutan',
				'BV' => 'Bouvet Island',
				'BW' => 'Botswana',
				'BY' => 'Belarus',
				'BZ' => 'Belize',
				'CA' => 'Canada',
				'CC' => 'Cocos [Keeling] Islands',
				'CD' => 'Congo - Kinshasa',
				'CF' => 'Central African Republic',
				'CG' => 'Congo - Brazzaville',
				'CH' => 'Switzerland',
				'CI' => 'Côte d’Ivoire',
				'CK' => 'Cook Islands',
				'CL' => 'Chile',
				'CM' => 'Cameroon',
				'CN' => 'China',
				'CO' => 'Colombia',
				'CR' => 'Costa Rica',
				'CS' => 'Serbia and Montenegro',
				'CT' => 'Canton and Enderbury Islands',
				'CU' => 'Cuba',
				'CV' => 'Cape Verde',
				'CX' => 'Christmas Island',
				'CY' => 'Cyprus',
				'CZ' => 'Czech Republic',
				'DD' => 'East Germany',
				'DE' => 'Germany',
				'DJ' => 'Djibouti',
				'DK' => 'Denmark',
				'DM' => 'Dominica',
				'DO' => 'Dominican Republic',
				'DZ' => 'Algeria',
				'EC' => 'Ecuador',
				'EE' => 'Estonia',
				'EG' => 'Egypt',
				'EH' => 'Western Sahara',
				'ER' => 'Eritrea',
				'ES' => 'Spain',
				'ET' => 'Ethiopia',
				'FI' => 'Finland',
				'FJ' => 'Fiji',
				'FK' => 'Falkland Islands',
				'FM' => 'Micronesia',
				'FO' => 'Faroe Islands',
				'FQ' => 'French Southern and Antarctic Territories',
				'FR' => 'France',
				'FX' => 'Metropolitan France',
				'GA' => 'Gabon',
				'GB' => 'United Kingdom',
				'GD' => 'Grenada',
				'GE' => 'Georgia',
				'GF' => 'French Guiana',
				'GG' => 'Guernsey',
				'GH' => 'Ghana',
				'GI' => 'Gibraltar',
				'GL' => 'Greenland',
				'GM' => 'Gambia',
				'GN' => 'Guinea',
				'GP' => 'Guadeloupe',
				'GQ' => 'Equatorial Guinea',
				'GR' => 'Greece',
				'GS' => 'South Georgia and the South Sandwich Islands',
				'GT' => 'Guatemala',
				'GU' => 'Guam',
				'GW' => 'Guinea-Bissau',
				'GY' => 'Guyana',
				'HK' => 'Hong Kong SAR China',
				'HM' => 'Heard Island and McDonald Islands',
				'HN' => 'Honduras',
				'HR' => 'Croatia',
				'HT' => 'Haiti',
				'HU' => 'Hungary',
				'ID' => 'Indonesia',
				'IE' => 'Ireland',
				'IL' => 'Israel',
				'IM' => 'Isle of Man',
				'IN' => 'India',
				'IO' => 'British Indian Ocean Territory',
				'IQ' => 'Iraq',
				'IR' => 'Iran',
				'IS' => 'Iceland',
				'IT' => 'Italy',
				'JE' => 'Jersey',
				'JM' => 'Jamaica',
				'JO' => 'Jordan',
				'JP' => 'Japan',
				'JT' => 'Johnston Island',
				'KE' => 'Kenya',
				'KG' => 'Kyrgyzstan',
				'KH' => 'Cambodia',
				'KI' => 'Kiribati',
				'KM' => 'Comoros',
				'KN' => 'Saint Kitts and Nevis',
				'KP' => 'North Korea',
				'KR' => 'South Korea',
				'KW' => 'Kuwait',
				'KY' => 'Cayman Islands',
				'KZ' => 'Kazakhstan',
				'LA' => 'Laos',
				'LB' => 'Lebanon',
				'LC' => 'Saint Lucia',
				'LI' => 'Liechtenstein',
				'LK' => 'Sri Lanka',
				'LR' => 'Liberia',
				'LS' => 'Lesotho',
				'LT' => 'Lithuania',
				'LU' => 'Luxembourg',
				'LV' => 'Latvia',
				'LY' => 'Libya',
				'MA' => 'Morocco',
				'MC' => 'Monaco',
				'MD' => 'Moldova',
				'ME' => 'Montenegro',
				'MF' => 'Saint Martin',
				'MG' => 'Madagascar',
				'MH' => 'Marshall Islands',
				'MI' => 'Midway Islands',
				'MK' => 'Macedonia',
				'ML' => 'Mali',
				'MM' => 'Myanmar [Burma]',
				'MN' => 'Mongolia',
				'MO' => 'Macau SAR China',
				'MP' => 'Northern Mariana Islands',
				'MQ' => 'Martinique',
				'MR' => 'Mauritania',
				'MS' => 'Montserrat',
				'MT' => 'Malta',
				'MU' => 'Mauritius',
				'MV' => 'Maldives',
				'MW' => 'Malawi',
				'MX' => 'Mexico',
				'MY' => 'Malaysia',
				'MZ' => 'Mozambique',
				'NA' => 'Namibia',
				'NC' => 'New Caledonia',
				'NE' => 'Niger',
				'NF' => 'Norfolk Island',
				'NG' => 'Nigeria',
				'NI' => 'Nicaragua',
				'NL' => 'Netherlands',
				'NO' => 'Norway',
				'NP' => 'Nepal',
				'NQ' => 'Dronning Maud Land',
				'NR' => 'Nauru',
				'NT' => 'Neutral Zone',
				'NU' => 'Niue',
				'NZ' => 'New Zealand',
				'OM' => 'Oman',
				'PA' => 'Panama',
				'PC' => 'Pacific Islands Trust Territory',
				'PE' => 'Peru',
				'PF' => 'French Polynesia',
				'PG' => 'Papua New Guinea',
				'PH' => 'Philippines',
				'PK' => 'Pakistan',
				'PL' => 'Poland',
				'PM' => 'Saint Pierre and Miquelon',
				'PN' => 'Pitcairn Islands',
				'PR' => 'Puerto Rico',
				'PS' => 'Palestinian Territories',
				'PT' => 'Portugal',
				'PU' => 'U.S. Miscellaneous Pacific Islands',
				'PW' => 'Palau',
				'PY' => 'Paraguay',
				'PZ' => 'Panama Canal Zone',
				'QA' => 'Qatar',
				'RE' => 'Réunion',
				'RO' => 'Romania',
				'RS' => 'Serbia',
				'RU' => 'Russia',
				'RW' => 'Rwanda',
				'SA' => 'Saudi Arabia',
				'SB' => 'Solomon Islands',
				'SC' => 'Seychelles',
				'SD' => 'Sudan',
				'SE' => 'Sweden',
				'SG' => 'Singapore',
				'SH' => 'Saint Helena',
				'SI' => 'Slovenia',
				'SJ' => 'Svalbard and Jan Mayen',
				'SK' => 'Slovakia',
				'SL' => 'Sierra Leone',
				'SM' => 'San Marino',
				'SN' => 'Senegal',
				'SO' => 'Somalia',
				'SR' => 'Suriname',
				'ST' => 'São Tomé and Príncipe',
				'SU' => 'Union of Soviet Socialist Republics',
				'SV' => 'El Salvador',
				'SY' => 'Syria',
				'SZ' => 'Swaziland',
				'TC' => 'Turks and Caicos Islands',
				'TD' => 'Chad',
				'TF' => 'French Southern Territories',
				'TG' => 'Togo',
				'TH' => 'Thailand',
				'TJ' => 'Tajikistan',
				'TK' => 'Tokelau',
				'TL' => 'Timor-Leste',
				'TM' => 'Turkmenistan',
				'TN' => 'Tunisia',
				'TO' => 'Tonga',
				'TR' => 'Turkey',
				'TT' => 'Trinidad and Tobago',
				'TV' => 'Tuvalu',
				'TW' => 'Taiwan',
				'TZ' => 'Tanzania',
				'UA' => 'Ukraine',
				'UG' => 'Uganda',
				'UM' => 'U.S. Minor Outlying Islands',
				'US' => 'United States',
				'UY' => 'Uruguay',
				'UZ' => 'Uzbekistan',
				'VA' => 'Vatican City',
				'VC' => 'Saint Vincent and the Grenadines',
				'VD' => 'North Vietnam',
				'VE' => 'Venezuela',
				'VG' => 'British Virgin Islands',
				'VI' => 'U.S. Virgin Islands',
				'VN' => 'Vietnam',
				'VU' => 'Vanuatu',
				'WF' => 'Wallis and Futuna',
				'WK' => 'Wake Island',
				'WS' => 'Samoa',
				'YD' => 'People\'s Democratic Republic of Yemen',
				'YE' => 'Yemen',
				'YT' => 'Mayotte',
				'ZA' => 'South Africa',
				'ZM' => 'Zambia',
				'ZW' => 'Zimbabwe',
				'ZZ' => 'Unknown or Invalid Region',
			]
		] );
		$sections->add_field( [
			'name' => __( 'Business Main Phone Number', $prefix ),
			'id'   => $prefix . '_business_main_phone',
			'type' => 'text',
		] );
		$sections->add_field( [
			'name' => __( 'Business Second Phone Number', $prefix ),
			'id'   => $prefix . '_business_second_phone',
			'type' => 'text',
		] );
		$sections->add_field( [
			'name' => __( 'Business Fax Number', $prefix ),
			'id'   => $prefix . '_business_fax',
			'type' => 'text',
		] );
		$sections->add_field( [
			'name' => __( 'Business Email Address', $prefix ),
			'id'   => $prefix . '_business_email',
			'type' => 'text_email',
		] );
		$sections->add_field( [
			'name' => __( 'Business Address Latitude', $prefix ),
			'id'   => $prefix . '_business_address_latitude',
			'desc' => '<strong>Use highlighted section of your map information here</strong><br>https://www.google.com.np/maps/place/xxxxxxxxxx/@<strong style="color: red;">xxxxxxxxx</strong>,xxxxxxxxxxx,15z/data=...',
			'type' => 'text',
		] );
		$sections->add_field( [
			'name' => __( 'Business Address Longitude', $prefix ),
			'id'   => $prefix . '_business_address_longitude',
			'desc' => '<strong>Use highlighted section of your map information here</strong><br>https://www.google.com.np/maps/place/xxxxxxxxxx/@xxxxxxxxx,<strong style="color: red;">xxxxxxxxxxx</strong>,15z/data=...',
			'type' => 'text',
		] ); 
		$sections->add_field( [
			'name' => __( 'Business Opening Hours', $prefix ),
			'id'   => $prefix . '_business_opening',
			'type' => 'wysiwyg',
		] );

		$sections = new_cmb2_box( [
			'id'           => $prefix . '_google_map_embed_code',
			'title'        => __( 'Google Map Embed Code', $prefix ),
			'object_types' => [ 'location' ],
		] );
		$sections->add_field( [
			'name' => __( 'Enter Code Here', $prefix ),
			'id'   => $prefix . '_google_embed_code',
			'type' => 'textarea',
			'sanitization_cb' => false
		] );
		
		$location2_banner = new_cmb2_box( [
			'id'           => $prefix . '_location2_banner',
			'title'        => __( 'Location Map', $prefix ),
			'object_types' => [ 'page' ],
			'show_on'      => [
				'key'   => 'page-template',
				'value' => [
					'templates/template-sst_location2.php'
				],
			],
		] );
		$location2_banner->add_field( [
			'name' => __( 'Location Title', $prefix ),
			'id'   => $prefix . '_location2_title',
			'type' => 'text',
		] );
		$location2_banner->add_field( [
			'name'            => __( 'Location Map', $prefix ),
			'id'              => $prefix . '_location2_map',
			'type'            => 'wysiwyg',
			'sanitization_cb' => false
		] );
	}
}
add_action( 'cmb2_admin_init', 'mok_location_meta' );
#endregion

#region job post type meta fields
if ( ! function_exists( 'job_meta_fields' ) ) {
	/**
	 * job post type meta fields
	 */
	function job_meta_fields() {
		$prefix   = '_ttm';
		$sections = new_cmb2_box( [
			'id'           => $prefix . '_job_details',
			'title'        => __( 'Job Details', $prefix ),
			'object_types' => [ 'job' ],
		] );
		$sections->add_field( [
			'name' => __( 'Job Summary', $prefix ),
			'id'   => $prefix . '_job_summary',
			'type' => 'wysiwyg',
		] );
		$sections->add_field( [
			'name' => __( 'Job Apply Link Label', $prefix ),
			'id'   => $prefix . '_job_apply_label',
			'type' => 'text',
		] );
		$sections->add_field( [
			'name' => __( 'Job Apply Link', $prefix ),
			'id'   => $prefix . '_job_apply_link',
			'type' => 'text_url',
		] );
	}
}
add_action( 'cmb2_admin_init', 'job_meta_fields' );
#endregion