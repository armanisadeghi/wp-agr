<?php
/**
 * Post meta field based on carbon post meta framework
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Custom Post Meta
 * @version 2.0.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

#region New Shop Post Meta
Container::make( 'post_meta', 'Shop page content sections' )
         ->where( 'post_type', '=', 'page' )
         ->where( 'post_template', 'IN', [ 'templates/template-sst_e-commercehome1.php' ] )
         ->add_tab( __( 'Below Guide Bar Section' ), [
	         Field::make( 'text', 'below_guide_bar_title', __( 'Title' ) )->set_width( 30 )->set_required( true ),
	         Field::make( 'rich_text', 'below_guide_bar_content', __( 'Content' ) )->set_width( 70 )->set_required( true ),
         ] )
         ->add_tab( __( 'Feature Product Block Section' ), [
	         Field::make( 'complex', 'block_products_list', __( 'Products List' ) )
	              ->set_layout( 'tabbed-vertical' )
	              ->set_max( 4 )
	              ->setup_labels( [
		              'plural_name'   => __( 'products' ),
		              'singular_name' => __( 'product' ),
	              ] )
	              ->add_fields( 'video', [
		              Field::make( 'image', 'video_image', __( 'Video Image' ) )->set_width( 50 )->set_required( true ),
		              Field::make( 'text', 'video_url', __( 'Video URL' ) )->set_width( 50 )->set_required( true ),
	              ] )
	              ->add_fields( 'product', [
		              Field::make( 'image', 'image', __( 'Product Image' ) )->set_width( 30 )->set_required( true ),
		              Field::make( 'rich_text', 'content', __( 'Product Content' ) )->set_width( 70 )->set_required( true ),
		              Field::make( 'text', 'button_url', __( 'Button URL' ) )->set_width( 50 )->set_required( true ),
		              Field::make( 'text', 'button_name', __( 'Button Name' ) )->set_width( 50 )->set_required( true ),
	              ] )
         ] )
         ->add_tab( __( 'Product Section below Block section' ), [
	         Field::make( 'image', 'below_block_image', __( 'Product Image' ) )->set_width( 30 )->set_required( true ),
	         Field::make( 'rich_text', 'below_block_content', __( 'Product Content' ) )->set_width( 70 )->set_required( true ),
	         Field::make( 'text', 'below_block_button_url', __( 'Button URL' ) )->set_width( 50 )->set_required( true ),
	         Field::make( 'text', 'below_block_button_name', __( 'Button Name' ) )->set_width( 50 )->set_required( true ),
         ] )
         ->add_tab( __( 'Founder section' ), [
	         Field::make( 'text', 'founder_title', __( 'Title' ) )->set_width( 30 )->set_required( true ),
	         Field::make( 'rich_text', 'founder_content', __( 'Content' ) )->set_width( 70 )->set_required( true ),
	         Field::make( 'image', 'founder_image', __( 'Founder Image' ) )->set_width( 30 )->set_required( true ),
	         Field::make( 'complex', 'founder_profile_list', __( 'Profile Link List' ) )
	              ->set_layout( 'tabbed-vertical' )
	              ->set_max( 2 )
	              ->setup_labels( [
		              'plural_name'   => __( 'founders' ),
		              'singular_name' => __( 'founder' ),
	              ] )
	              ->add_fields( 'link', [
		              Field::make( 'text', 'profile_url', __( 'Profile link' ) )->set_width( 50 )->set_required( true ),
		              Field::make( 'text', 'profile_name', __( 'Profile Button Name' ) )->set_width( 50 )->set_required( true ),
	              ] )
	              ->set_header_template( 'Profile: <%- profile_name %>' )
	              ->set_width( 70 )
         ] );
#endregion

#region Product Post Meta
Container::make( 'post_meta', 'Additional Information' )
         ->where( 'post_type', '=', 'product' )
         ->add_tab( __( 'Short desc below title' ), [
	         Field::make( 'rich_text', 'below_title_short_desc', __( 'Short Description' ) ),
         ] )
         ->add_tab( __( 'Extra Accordion Info' ), [
	         Field::make( 'complex', 'product_extra_info', __( 'Extra Accordion Info' ) )
	              ->set_layout( 'tabbed-vertical' )
	              ->setup_labels( [
		              'plural_name'   => __( 'info' ),
		              'singular_name' => __( 'info' ),
	              ] )
	              ->add_fields( 'video', [
		              Field::make( 'image', 'video_image', __( 'Video Image' ) )->set_width( 20 )->set_required( true ),
		              Field::make( 'text', 'video_title', __( 'Title' ) )->set_width( 40 )->set_required( true ),
		              Field::make( 'text', 'video_url', __( 'Video URL' ) )
		                   ->set_width( 40 )
		                   ->help_text( 'Enter Youtube URL like: https://www.youtube.com/watch?v=fQurc3V12qw' )
		                   ->set_required( true ),
	              ] )
	              ->set_header_template( 'Video URL: <%- video_title %>' )
	              ->add_fields( 'content', [
		              Field::make( 'text', 'content_title', __( 'Title' ) )->set_width( 30 )->set_required( true ),
		              Field::make( 'rich_text', 'content_desc', __( 'Content' ) )->set_width( 70 )->set_required( true ),
	              ] )
	              ->set_header_template( 'Title: <%- content_title %>' ),
	         Field::make( 'rich_text', 'below_product_extra_info', __( 'Content below accordion' ) ),
         ] );
#endregion
#region About Us post meta
Container::make( 'post_meta', 'Video section' )
         ->where( 'post_type', '=', 'page' )
         ->where( 'post_template', 'IN', [ 'templates/template-sst_about_us.php' ] )
         ->add_tab( __( 'Video section settings' ), [
			Field::make( 'checkbox', 'enable_video_section', __( 'Enable Video' ) )->set_required( false )->set_help_text( ' Please check this section to show on about us page ' )->set_classes( 'my-video-class' ),
			Field::make( 'text', 'video_aboutus_title', __( 'Section Title' ) )->set_required( false ),
	         Field::make( 'textarea', 'video_aboutus_desc', __( 'Section Description' ) )->set_required( false ),
	         Field::make( 'complex', 'video_aboutus_list', __( 'Video List' ) )
	              ->set_layout( 'tabbed-vertical' )
	              ->setup_labels( [
		              'plural_name'   => __( 'videos' ),
		              'singular_name' => __( 'video' ),
	              ] )
	              ->add_fields( [
		              Field::make( 'image', 'video_image', __( 'Video Image' ) )->set_width( 50 )->set_required( false ),
		              Field::make( 'text', 'video_url', __( 'Video URL' ) )->set_width( 50 )->set_required( false ),
	              ] )
         ] );
#endregion
#region Ambassador post meta
Container::make( 'post_meta', 'Ambassador content sections' )
         ->where( 'post_type', '=', 'page' )
         ->where( 'post_template', 'IN', [ 'templates/template-sst-ambassador.php' ] )
         ->add_tab( __( 'Feature Product Block Section' ), [
	         Field::make( 'complex', 'ambassador_products_list', __( 'Products List' ) )
	              ->set_layout( 'tabbed-vertical' )
	              ->set_max( 4 )
	              ->setup_labels( [
		              'plural_name'   => __( 'products' ),
		              'singular_name' => __( 'product' ),
	              ] )
	              ->add_fields( 'video', [
		              Field::make( 'image', 'video_image', __( 'Video Image' ) )->set_width( 50 )->set_required( true ),
		              Field::make( 'text', 'video_url', __( 'Video URL' ) )->set_width( 50 )->set_required( true ),
	              ] )
	              ->add_fields( 'product', [
		              Field::make( 'image', 'image', __( 'Product Image' ) )->set_width( 33 )->set_required( true ),
		              Field::make( 'text', 'title', __( 'Product Title' ) )->set_width( 33 )->set_required( true ),
		              Field::make( 'text', 'off_price', __( 'Product off price' ) )->set_width( 33 )->set_help_text( 'Add product off content. For example: 20% off' ),
		              Field::make( 'rich_text', 'content', __( 'Product Content' ) )->set_required( true ),
		              Field::make( 'text', 'button_url', __( 'Button URL' ) )->set_width( 50 )->set_required( true ),
		              Field::make( 'text', 'button_name', __( 'Button Name' ) )->set_width( 50 )->set_required( true ),
	              ] )
         ] )
         ->add_tab( __( 'Ad Banner Section' ), [
	         Field::make( 'image', 'ad_image', __( 'Ad Banner Image' ) )->set_width( 33 )->set_required( true ),
	         Field::make( 'rich_text', 'ad_content', __( 'Ad Banner Content' ) )->set_required( true ),
	         Field::make( 'text', 'ad_btn_url', __( 'Button URL' ) )->set_width( 50 )->set_required( true ),
	         Field::make( 'text', 'ad_btn_name', __( 'Button Name' ) )->set_width( 50 )->set_required( true ),
         ] )
         ->add_tab( __( 'Section below ad banner' ), [
	         Field::make( 'text', 'about_ambassador_title', __( 'Section Title' ) )->set_required( true ),
	         Field::make( 'complex', 'about_ambassador_list', __( 'Content List' ) )
	              ->set_layout( 'tabbed-vertical' )
	              ->setup_labels( [
		              'plural_name'   => __( 'content' ),
		              'singular_name' => __( 'content' ),
	              ] )
	              ->add_fields( [
		              Field::make( 'image', 'image', __( 'Image' ) )->set_width( 20 ),
		              Field::make( 'select', 'image_align', __( 'Image Alignment' ) )->set_width( 20 )
		                   ->set_options( [
			                   'alignright' => 'Right align',
			                   'alignleft'  => 'Left align',
		                   ] )
		                   ->set_default_value( 'alignright' ),
		              Field::make( 'rich_text', 'content', __( 'Content' ) )->set_width( 60 )->set_required( true ),
	              ] )
         ] )
         ->add_tab( __( 'Video section' ), [
	         Field::make( 'text', 'video_ambassador_title', __( 'Section Title' ) )->set_required( true ),
	         Field::make( 'complex', 'video_ambassador_list', __( 'Video List' ) )
	              ->set_layout( 'tabbed-vertical' )
	              ->setup_labels( [
		              'plural_name'   => __( 'videos' ),
		              'singular_name' => __( 'video' ),
	              ] )
	              ->add_fields( [
		              Field::make( 'image', 'video_image', __( 'Video Image' ) )->set_width( 50 )->set_required( true ),
		              Field::make( 'text', 'video_url', __( 'Video URL' ) )->set_width( 50 )->set_required( true ),
	              ] )
         ] )
         ->add_tab( __( 'Instagram section' ), [
	         Field::make( 'text', 'instagram_username', __( 'Instagram Username' ) ),
	         Field::make( 'text', 'instagram_user_id', __( 'Instagram User ID' ) )
	              ->set_help_text( 'Go to https://www.instagram.com/<%- instagram_username %>/?__a=1. You will find your user id on it.' ),
         ] );
#endregion

#region SST Showcase Home post meta
Container::make( 'post_meta', 'Showcase Additional Content' )
         ->where( 'post_type', '=', 'page' )
         ->where( 'post_template', 'IN', [
	         'templates/template-sst-showcase-home1.php',
	         'templates/template-sst-showcase-home2.php',
	         'templates/template-sst-showcase-home3.php'
         ] )
         ->add_tab( __( 'Theme Color Section' ), [
	         Field::make( 'color', 'showcase_theme_color', __( 'Theme Color' ) ),
         ] )
         ->add_tab( __( 'Banner Section' ), [
	         Field::make( 'complex', 'showcase_banner', __( 'Banners List' ) )
	              ->set_layout( 'tabbed-vertical' )
	              ->set_max( 5 )
	              ->setup_labels( [
		              'plural_name'   => __( 'Banners' ),
		              'singular_name' => __( 'Banner' ),
	              ] )
	              ->add_fields( [
		              Field::make( 'image', 'image', __( 'Image' ) )->set_required( true )->set_width( 20 ),
		              Field::make( 'rich_text', 'content', __( 'Details' ) )->set_width( 75 ),
		              Field::make( 'text', 'button', __( 'Button Name' ) )->set_width( 50 ),
		              Field::make( 'text', 'url', __( 'Button URL' ) )->set_width( 50 ),
	              ] )
	              ->set_header_template( 'Image Attachment ID: <%- image %>' )
         ] )
         ->add_tab( __( 'Below banners Section' ), [
	         Field::make( 'complex', 'showcase_below_banner', __( 'Below banners List' ) )
	              ->set_layout( 'tabbed-vertical' )
	              ->set_max( 2 )
	              ->add_fields( [
		              Field::make( 'image', 'image', __( 'Image' ) )->set_required( true )->set_width( 20 ),
		              Field::make( 'text', 'title', __( 'Title' ) )->set_width( 75 )
		                   ->set_help_text( 'wrap text with <code>&lt;span&gt;&lt;/span&gt;</code> HTML tag to highlight it with theme color' ),
		              Field::make( 'color', 'bg_color', __( 'Background Color' ) )->set_width( 50 ),
		              Field::make( 'text', 'url', __( 'URL' ) )->set_width( 50 ),
	              ] )
	              ->set_header_template( 'Title: <%- title %>' )
         ] )
         ->add_tab( __( 'Section before Infographics' ), [
	         Field::make( 'complex', 'showcase_before_info', __( 'Section List before Infographics' ) )
	              ->set_layout( 'tabbed-vertical' )
	              ->add_fields( [
		              Field::make( 'image', 'image', __( 'Image' ) )->set_width( 20 ),
		              Field::make( 'rich_text', 'content', __( 'Details' ) )->set_width( 75 ),
		              Field::make( 'text', 'title', __( 'Title' ) )->set_width( 50 )
		                   ->set_help_text( 'wrap text with <code>&lt;span&gt;&lt;/span&gt;</code> HTML tag to highlight it with theme color' ),
		              Field::make( 'text', 'class', __( 'Class' ) )->set_width( 50 ),
	              ] )
	              ->set_header_template( 'Title: <%- title %>' ),
	         Field::make( 'html', 'showcase_before_info_guide' )
	              ->set_html( '<h2 style="font-size: 18px">Guide for <strong>class</strong> field:</h2>
<dl>
    <dt><code>image-right/image-left</code></dt>
    <dd>To position image alignment use this class</dd>
    <dt><code>dark-bg gap-top</code></dt>
    <dd>Add this class to add grey background with extra space on top</dd>
    <dt><code>gap-bottom</code></dt>
    <dd>Add this class to add extra space on bottom</dd>
</dl>
<p>Example: to add dark background with space on top and image aligned right, you have to add this value in class field
    <code>image-right dark-bg gap-top</code></p>
' )
         ] )
         ->add_tab( __( 'Infographics Section' ), [
	         Field::make( 'text', 'showcase_info_title', __( 'Title' ) )->set_width( 80 ),
	         Field::make( 'image', 'showcase_info_image', __( 'Image' ) )->set_width( 20 ),
	         Field::make( 'rich_text', 'showcase_info_content', __( 'Details' ) ),
	         Field::make( 'text', 'showcase_info_button', __( 'Button Name' ) )->set_width( 50 ),
	         Field::make( 'text', 'showcase_info_url', __( 'Button URL' ) )->set_width( 50 ),
         ] )
         ->add_tab( __( 'Newsletter Section' ), [
	         Field::make( 'text', 'nwl_title', __( 'Title' ) ),
	         Field::make( 'text', 'nwl_shortcode', __( 'Newsletter Shortcode' ) )->set_width( 50 ),
	         Field::make( 'text', 'nwl_below_content', __( 'Content below form' ) )->set_width( 50 ),
         ] )
         ->add_tab( __( 'Instagram section' ), [
	         Field::make( 'text', 'instagram_username', __( 'Instagram Username' ) ),
	         Field::make( 'text', 'instagram_user_id', __( 'Instagram User ID' ) )
	              ->set_help_text( 'Go to https://www.instagram.com/<%- instagram_username %>/?__a=1. You will find your user id on it.' ),
         ] );
#endregion
Container::make( 'post_meta', 'Additional Information (For List)' )
         ->where( 'post_type', '=', 'press' )
         ->add_fields(
	         [
		         Field::make( 'image', 'press_list_image', __( 'List Image' ) )->set_width( 30 ),
		         Field::make( 'rich_text', 'press_excerpt', __( 'Content (for list)' ) )->set_width( 70 )->set_required(),
	         ]
         );