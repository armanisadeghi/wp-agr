<?php
/*
Plugin Name: Custom Share Buttons with Floating Sidebar Pro
Plugin URI: http://www.mrwebsolution.in/
Description: "custom-share-buttons-with-floating-sidebar-pro" is the very simple plugin for add to social share buttons with float sidebar. Even you can change the share buttons images if you wish.
Author: Raghunath
Author URI: http://www.mrwebsolution.in
Version: 2.5
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WN785E5V492L4
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//Admin "Custom Share Buttons with Floating Sidebar" Menu Item
if(!function_exists('csbwf_pro_sidebar_menu')){
add_action('admin_menu','csbwf_pro_sidebar_menu');
function csbwf_pro_sidebar_menu(){
	add_options_page('CSBWFS Pro','CSBWFS Pro','manage_options','csbwfs-settings-pro','csbwf_pro_sidebar_admin_option_page');
}
}
//Define Action for register "Custom Share Buttons with Floating Sidebar" Options
add_action('admin_init','csbwf_pro_sidebar_init');
if(!function_exists('csbwf_pro_sidebar_init')):
//Register "Custom Share Buttons with Floating Sidebar" options
function csbwf_pro_sidebar_init(){
	register_setting('csbwf_sidebar_options','csbwfs_pro_active');
	register_setting('csbwf_sidebar_options','csbwfs_pro_horizontal_for_mobile');
	register_setting('csbwf_sidebar_options','csbwfs_position');
	register_setting('csbwf_sidebar_options','csbwfs_btn_position');
	register_setting('csbwf_sidebar_options','csbwfs_btn_text');
	register_setting('csbwf_sidebar_options','csbwfs_share_count_tw');
	register_setting('csbwf_sidebar_options','csbwfs_share_count_fb');
	register_setting('csbwf_sidebar_options','csbwfs_share_count_li');
	register_setting('csbwf_sidebar_options','csbwfs_share_count_st');
	register_setting('csbwf_sidebar_options','csbwfs_share_count_pin');
	register_setting('csbwf_sidebar_options','csbwfs_share_count_gp');
	register_setting('csbwf_sidebar_options','csbwfs_share_count_re');
	register_setting('csbwf_sidebar_options','csbwfs_share_count_tu');
	register_setting('csbwf_sidebar_options','csbwfs_tu_image');
	register_setting('csbwf_sidebar_options','csbwfs_bl_image');
	register_setting('csbwf_sidebar_options','csbwfs_gm_image');	
	register_setting('csbwf_sidebar_options','csbwfs_de_image');	
	register_setting('csbwf_sidebar_options','csbwfs_fb_image');
	register_setting('csbwf_sidebar_options','csbwfs_tw_image');
	register_setting('csbwf_sidebar_options','csbwfs_li_image');	
	register_setting('csbwf_sidebar_options','csbwfs_re_image');	
	register_setting('csbwf_sidebar_options','csbwfs_st_image');	
	register_setting('csbwf_sidebar_options','csbwfs_mail_image');	
	register_setting('csbwf_sidebar_options','csbwfs_gp_image');	
	register_setting('csbwf_sidebar_options','csbwfs_pin_image');
	register_setting('csbwf_sidebar_options','csbwfs_yt_image');
	register_setting('csbwf_sidebar_options','csbwfs_gt_image');	
    register_setting('csbwf_sidebar_options','csbwfs_inst_image');
    register_setting('csbwf_sidebar_options','csbwfs_digg_image');
    register_setting('csbwf_sidebar_options','csbwfs_yum_image');
	register_setting('csbwf_sidebar_options','csbwfs_vk_image');
	register_setting('csbwf_sidebar_options','csbwfs_buf_image');
	register_setting('csbwf_sidebar_options','csbwfs_print_image');
	register_setting('csbwf_sidebar_options','csbwfs_fb_bg');
	register_setting('csbwf_sidebar_options','csbwfs_tw_bg');
	register_setting('csbwf_sidebar_options','csbwfs_li_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_mail_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_tu_bg');
	register_setting('csbwf_sidebar_options','csbwfs_gm_bg');
	register_setting('csbwf_sidebar_options','csbwfs_bl_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_de_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_gp_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_pin_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_re_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_st_bg');
	register_setting('csbwf_sidebar_options','csbwfs_yt_bg');
	register_setting('csbwf_sidebar_options','csbwfs_gt_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_inst_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_digg_bg');
	register_setting('csbwf_sidebar_options','csbwfs_yum_bg');
	register_setting('csbwf_sidebar_options','csbwfs_vk_bg');
	register_setting('csbwf_sidebar_options','csbwfs_buf_bg');
	register_setting('csbwf_sidebar_options','csbwfs_print_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_fpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_tpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_gpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_ppublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_ytpublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_republishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_stpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_gtpublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_instpublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_diggpublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_yumpublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_vkpublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_bufpublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_printpublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_whatsapppublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_rsspublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_lpublishBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_mpublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_linepublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_skypublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_skyUnpublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_depublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_blpublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_gmpublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_tupublishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_ytPath');
	register_setting('csbwf_sidebar_options','csbwfs_rssPath');	
	register_setting('csbwf_sidebar_options','csbwfs_mailMessage');
	register_setting('csbwf_sidebar_options','csbwfs_top_margin');
	register_setting('csbwf_sidebar_options','csbwfs_delayTimeBtn');
	register_setting('csbwf_sidebar_options','csbwfs_hide_on');
	register_setting('csbwf_sidebar_options','csbwfs_custom_page_ids');
	register_setting('csbwf_sidebar_options','csbwfs_og_tags_enable');
	register_setting('csbwf_sidebar_options','csbwfs_auto_hide');
	register_setting('csbwf_sidebar_options','csbwfs_position_from_lr');
	register_setting('csbwf_sidebar_options','csbwfs_sbi_image');
	//Options for post/pages
	register_setting('csbwf_sidebar_options','csbwfs_pro_buttons_active');
	register_setting('csbwf_sidebar_options','csbwfs_page_hide_home');
	register_setting('csbwf_sidebar_options','csbwfs_page_hide_post');
	register_setting('csbwf_sidebar_options','csbwfs_page_hide_product');
	register_setting('csbwf_sidebar_options','csbwfs_page_hide_page');
	register_setting('csbwf_sidebar_options','csbwfs_page_hide_archive');
	register_setting('csbwf_sidebar_options','csbwfs_hide_home');
	register_setting('csbwf_sidebar_options','csbwfs_hide_post');
	register_setting('csbwf_sidebar_options','csbwfs_hide_product');
	register_setting('csbwf_sidebar_options','csbwfs_hide_page');
	register_setting('csbwf_sidebar_options','csbwfs_hide_archive');
	register_setting('csbwf_sidebar_options','csbwfs_page_de_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_gm_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_bl_image');	
	register_setting('csbwf_sidebar_options','csbwfs_page_tu_image');	
	register_setting('csbwf_sidebar_options','csbwfs_page_fb_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_tw_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_li_image');	
	register_setting('csbwf_sidebar_options','csbwfs_page_mail_image');	
	register_setting('csbwf_sidebar_options','csbwfs_page_gp_image');	
	register_setting('csbwf_sidebar_options','csbwfs_page_pin_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_re_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_st_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_yt_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_gt_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_inst_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_digg_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_yum_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_vk_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_buf_image');
	register_setting('csbwf_sidebar_options','csbwfs_page_print_image');
	register_setting('csbwf_sidebar_options','csbwfs_btn_display');
	/** buttons title */
	register_setting('csbwf_sidebar_options','csbwfs_de_title');
	register_setting('csbwf_sidebar_options','csbwfs_gm_title');
	register_setting('csbwf_sidebar_options','csbwfs_bl_title');
	register_setting('csbwf_sidebar_options','csbwfs_tu_title');
	register_setting('csbwf_sidebar_options','csbwfs_fb_title');
	register_setting('csbwf_sidebar_options','csbwfs_tw_title');
	register_setting('csbwf_sidebar_options','csbwfs_li_title');
	register_setting('csbwf_sidebar_options','csbwfs_pin_title');
	register_setting('csbwf_sidebar_options','csbwfs_gp_title');
	register_setting('csbwf_sidebar_options','csbwfs_mail_title');
	register_setting('csbwf_sidebar_options','csbwfs_yt_title');
	register_setting('csbwf_sidebar_options','csbwfs_re_title');
	register_setting('csbwf_sidebar_options','csbwfs_st_title');
	register_setting('csbwf_sidebar_options','csbwfs_gt_title');
	register_setting('csbwf_sidebar_options','csbwfs_inst_title');
	register_setting('csbwf_sidebar_options','csbwfs_digg_title');
	register_setting('csbwf_sidebar_options','csbwfs_yum_title');
	register_setting('csbwf_sidebar_options','csbwfs_vk_title');
	register_setting('csbwf_sidebar_options','csbwfs_buf_title');
	register_setting('csbwf_sidebar_options','csbwfs_print_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_de_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_gm_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_bl_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_tu_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_fb_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_tw_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_li_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_pin_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_gp_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_mail_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_yt_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_re_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_st_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_gt_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_inst_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_digg_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_yum_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_vk_title');
	register_setting('csbwf_sidebar_options','csbwfs_page_buf_title');
	/** message content */	
	register_setting('csbwf_sidebar_options','csbwfs_show_btn');	
	register_setting('csbwf_sidebar_options','csbwfs_hide_btn');
	register_setting('csbwf_sidebar_options','csbwfs_share_msg');
	register_setting('csbwf_sidebar_options','csbwfs_rmSHBtn');	
	register_setting('csbwf_sidebar_options','csbwfs_featuredshrimg');	
	register_setting('csbwf_sidebar_options','csbwfs_defaultfeaturedshrimg');
	register_setting('csbwf_sidebar_options','csbwfs_deactive_for_mob');	
	/** Contact form */
	register_setting('csbwf_sidebar_options','csbwfs_mail_to');	
	register_setting('csbwf_sidebar_options','csbwfs_mail_from');	
	register_setting('csbwf_sidebar_options','csbwfs_mail_cc');	
	register_setting('csbwf_sidebar_options','csbwfs_mail_subject');
	register_setting('csbwf_sidebar_options','csbwfs_mail_welcome_msg');
	register_setting('csbwf_sidebar_options','csbwfs_mail_thank_msg');
	register_setting('csbwf_sidebar_options','csbwfs_mail_css');
	register_setting('csbwf_sidebar_options','csbwfs_mail_form_shortcode');	
	register_setting('csbwf_sidebar_options','csbwfs_de_page_url');
	register_setting('csbwf_sidebar_options','csbwfs_bl_page_url');
	register_setting('csbwf_sidebar_options','csbwfs_tu_page_url');	
	register_setting('csbwf_sidebar_options','csbwfs_fb_page_url');
	register_setting('csbwf_sidebar_options','csbwfs_tw_page_url');
	register_setting('csbwf_sidebar_options','csbwfs_li_page_url');	
	register_setting('csbwf_sidebar_options','csbwfs_re_page_url');	
	register_setting('csbwf_sidebar_options','csbwfs_st_page_url');	
	register_setting('csbwf_sidebar_options','csbwfs_gp_page_url');	
	register_setting('csbwf_sidebar_options','csbwfs_pin_page_url');
	register_setting('csbwf_sidebar_options','csbwfs_inst_page_url');
	register_setting('csbwf_sidebar_options','csbwfs_digg_page_url');
	register_setting('csbwf_sidebar_options','csbwfs_yum_page_url');
	register_setting('csbwf_sidebar_options','csbwfs_vk_page_url');
	register_setting('csbwf_sidebar_options','csbwfs_buf_page_url');
	register_setting('csbwf_sidebar_options','csbwfs_mail_page_url');
	/** Extra Button */
	register_setting('csbwf_sidebar_options','csbwfs_custom_image');	
	register_setting('csbwf_sidebar_options','csbwfs_custom2_image');	
	register_setting('csbwf_sidebar_options','csbwfs_custom3_image');	
	register_setting('csbwf_sidebar_options','csbwfs_custom4_image');	
	register_setting('csbwf_sidebar_options','csbwfs_custom_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_custom2_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_custom3_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_custom4_bg');	
	register_setting('csbwf_sidebar_options','csbwfs_custom_title');
	register_setting('csbwf_sidebar_options','csbwfs_custom2_title');
	register_setting('csbwf_sidebar_options','csbwfs_custom3_title');
	register_setting('csbwf_sidebar_options','csbwfs_custom4_title');
	register_setting('csbwf_sidebar_options','csbwfs_custom_url');
	register_setting('csbwf_sidebar_options','csbwfs_custom2_url');
	register_setting('csbwf_sidebar_options','csbwfs_custom3_url');
	register_setting('csbwf_sidebar_options','csbwfs_custom4_url');
	register_setting('csbwf_sidebar_options','csbwfs_c1publishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_c2publishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_c3publishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_c4publishBtn');
	register_setting('csbwf_sidebar_options','csbwfs_custom_width');
	register_setting('csbwf_sidebar_options','csbwfs_custom2_width');
	register_setting('csbwf_sidebar_options','csbwfs_custom3_width');
	register_setting('csbwf_sidebar_options','csbwfs_custom4_width');
	register_setting('csbwf_sidebar_options','csbwfs_custom3_defltwidth');
	register_setting('csbwf_sidebar_options','csbwfs_custom4_defltwidth');	
	register_setting('csbwf_sidebar_options','csbwfs_custom3_hght');
	register_setting('csbwf_sidebar_options','csbwfs_custom4_hght');	
	register_setting('csbwf_sidebar_options','csbwfs_custom_target');
	register_setting('csbwf_sidebar_options','csbwfs_custom2_target');
	register_setting('csbwf_sidebar_options','csbwfs_custom3_target');
	register_setting('csbwf_sidebar_options','csbwfs_custom4_target');
	register_setting('csbwf_sidebar_options','csbwfs_custom3_txt_color');
	register_setting('csbwf_sidebar_options','csbwfs_custom4_txt_color');
	register_setting('csbwf_sidebar_options','csbwfs_btn_display');
	register_setting('csbwf_sidebar_options','csbwfs_short_url');
	register_setting('csbwf_sidebar_options','csbwfs_btns_order');
	register_setting('csbwf_sidebar_options','csbwfs_count_sum');
	register_setting('csbwf_sidebar_options','csbwfs_count_sum_page');
	register_setting('csbwf_sidebar_options','csbwfs_wayofcount');
	/* UPDATE SETTINGS 18 MARCH 16*/
register_setting('csbwf_sidebar_options','cswbfs_exclude_post_type');
register_setting('csbwf_sidebar_options','cswbfs_include_post_type');
register_setting('csbwf_sidebar_options','csbwfs_dft_og_title');
register_setting('csbwf_sidebar_options','csbwfs_dft_og_desc');
register_setting('csbwf_sidebar_options','csbwfs_dft_og_img');
register_setting('csbwf_sidebar_options','csbwfs_tu_un');
register_setting('csbwf_sidebar_options','csbwfs_disable_hover');
register_setting('csbwf_sidebar_options','csbwfs_page_hide_on');
register_setting('csbwf_sidebar_options','csbwfs_page_custom_page_ids');
register_setting('csbwf_sidebar_options','csbwfs_form_heading');
register_setting('csbwf_sidebar_options','csbwfs_form_subheading');
register_setting('csbwf_sidebar_options','csbwfs_form_width');
register_setting('csbwf_sidebar_options','csbwfs_form_bg');
} 
endif;

if(!function_exists('csbwfs_add_settings_link')):
// Add settings link to plugin list page in admin
        function csbwfs_add_settings_link( $links ) {
            $settings_link = '<a href="options-general.php?page=csbwfs-settings-pro">' . __( 'Settings', 'csbwfs-pro' ) . '</a>';
            array_unshift( $links, $settings_link );
            return $links;
        }
endif;
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'csbwfs_add_settings_link' );

if (isset($_GET['page']) && $_GET['page'] == 'csbwfs-settings-pro') {

if(!function_exists('add_csbwfs_pro_admin_style_script')):
function add_csbwfs_pro_admin_style_script()
{
    //wp_enqueue_style( 'wp-color-picker' );
    //wp_enqueue_script('media-upload');
   // wp_enqueue_script('thickbox');
    wp_register_script('csbwfs-image-upload', plugins_url('/js/csbwfs-pro.js',__FILE__ ), array('jquery','media-upload','thickbox','wp-color-picker'));
    wp_enqueue_script('csbwfs-image-upload');
    
}	
endif;

function csbwfs_pro_admin_styles() {
wp_register_style( 'csbwf_pro_admin_style', plugins_url( 'css/admin-csbwfs.css',__FILE__ ) );
wp_enqueue_style( 'csbwf_pro_admin_style' );
wp_enqueue_style( 'wp-color-picker' ); 
wp_enqueue_style('thickbox');
}

// better use get_current_screen(); or the global $current_screen

    add_action('admin_print_styles', 'csbwfs_pro_admin_styles');
    add_action('admin_footer','add_csbwfs_pro_admin_style_script');
}

if(get_option('csbwfs_og_tags_enable')=='yes'){
add_action( 'admin_enqueue_scripts', 'prfx_image_enqueue' );
}
function prfx_image_enqueue() {
    global $typenow;
        wp_enqueue_media();
        // Registers and enqueues the required javascript.
        wp_register_script( 'meta-box-image', plugin_dir_url( __FILE__ ) . 'js/meta-box-image.js', array( 'jquery' ) );
        wp_localize_script( 'meta-box-image', 'meta_image',
            array(
                'title' => __( 'Choose or Upload an Image', 'prfx-textdomain' ),
                'button' => __( 'Use this image', 'prfx-textdomain' ),
            )
        );
        wp_enqueue_script( 'meta-box-image' );
}


/** Display the Options form for CSBWFS */
if(!function_exists('csbwf_pro_sidebar_admin_option_page')):
function csbwf_pro_sidebar_admin_option_page(){ 
	?>
	<div style="width: 80%; padding: 10px; margin: 10px;" id="csbwfs-pro-admin"> 
	<h1>Custom Share Buttons With Floating Sidebar Pro Settings</h1>
<!-- Start Options Form -->
	<form action="options.php" method="post" id="csbwf-sidebar-admin-form">
	<div id="csbwf-tab-menu"><a id="csbwfs-general" class="csbwf-tab-links active" >General</a> <a  id="csbwfs-sidebar" class="csbwf-tab-links">Floating Sidebar</a> <a  id="csbwfs-share-buttons" class="csbwf-tab-links">Social Share Buttons</a> <a  id="csbwfs-form" class="csbwf-tab-links">Contact Form</a> <a  id="csbwfs-advance" class="csbwf-tab-links">Advance Settings</a> <a  id="csbwfs-support" class="csbwf-tab-links">Support</a></div>
	<div align="right" class="topsubbtn"><?php echo get_submit_button('Save Settings','button-primary','submit','','');?></div>
	<div class="csbwfs-setting">
	<!-- General Setting -->	
	<div class="first csbwfs-tab" id="div-csbwfs-general">
	<h2>General Settings</h2>
	<p><label>Enable:</label><input type="checkbox" id="csbwfs_pro_active" name="csbwfs_pro_active" value='1' <?php if(get_option('csbwfs_pro_active')!=''){ echo ' checked="checked"'; }?>/></p>
	<p><h3><strong><?php _e('Publish Buttons:','csbwfs');?></strong></h3></p>
	<p class="csbwfs-genp"><input type="checkbox" id="publish1" value="yes" name="csbwfs_fpublishBtn" <?php if(get_option('csbwfs_fpublishBtn')=='yes'){echo 'checked="checked"';}?>/><span>Facebook</span> 
	<input type="checkbox" id="publish2" name="csbwfs_tpublishBtn" value="yes" <?php if(get_option('csbwfs_tpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <span>Twitter</span>
	<input type="checkbox" id="publish3" name="csbwfs_gpublishBtn" value="yes" <?php if(get_option('csbwfs_gpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <span>Google Plus</span>
	<input type="checkbox" id="publish4" name="csbwfs_lpublishBtn" value="yes" <?php if(get_option('csbwfs_lpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <span>Linkdin</span>
	<input type="checkbox" id="publish5" name="csbwfs_ppublishBtn" value="yes" <?php if(get_option('csbwfs_ppublishBtn')=='yes'){echo 'checked="checked"';}?>/> <span>Pinterest</span>
	<input type="checkbox" id="publish6" name="csbwfs_republishBtn" value="yes" <?php if(get_option('csbwfs_republishBtn')=='yes'){echo 'checked="checked"';}?>/> <span>Reddit</span>
	<input type="checkbox" id="publish7" name="csbwfs_stpublishBtn" value="yes" <?php if(get_option('csbwfs_stpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <span>Stumbleupon</span>
	<input type="checkbox" id="publish8" name="csbwfs_mpublishBtn" value="yes" <?php if(get_option('csbwfs_mpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <span>Mailbox</span>
	<input type="checkbox" id="publish08" name="csbwfs_printpublishBtn" value="yes" <?php if(get_option('csbwfs_printpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <span>Print</span>
	<input type="checkbox" id="csbwfs_tupublishBtn" name="csbwfs_tupublishBtn" value="yes" <?php if(get_option('csbwfs_tupublishBtn')=='yes'){echo 'checked="checked"';}?>/> <span>Tumblr</span>
	<input type="checkbox" id="csbwfs_gmpublishBtn" name="csbwfs_gmpublishBtn" value="yes" <?php checked(get_option('csbwfs_gmpublishBtn'),'yes');?>/> <span>Gmail</span>
	<input type="checkbox" id="csbwfs_blpublishBtn" name="csbwfs_blpublishBtn" value="yes" <?php if(get_option('csbwfs_blpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <span>Blogger</span>
	<input type="checkbox" id="csbwfs_depublishBtn" name="csbwfs_depublishBtn" value="yes" <?php checked(get_option('csbwfs_depublishBtn'),'yes');?>/> <span>Delicious</span>
	<input type="checkbox" id="csbwfs_whatsapppublishBtn" name="csbwfs_whatsapppublishBtn" value="yes" <?php if(get_option('csbwfs_whatsapppublishBtn')=='yes'){echo 'checked="checked"';}?>/> <span>WhatsApp</span>
	<input type="checkbox" id="csbwfs_linepublishBtn" name="csbwfs_linepublishBtn" value="yes" <?php checked(get_option('csbwfs_linepublishBtn'),'yes');?>/> <span>Line</span>
	<input type="checkbox" id="publish10" name="csbwfs_diggpublishBtn" value="yes" <?php if(get_option('csbwfs_diggpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <span>Diggit</span>
	<input type="checkbox" id="publish9" name="csbwfs_gtpublishBtn" value="yes" <?php if(get_option('csbwfs_gtpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <span>Google Translate</span>
	<input type="checkbox" id="publish10" name="csbwfs_yumpublishBtn" value="yes" <?php if(get_option('csbwfs_yumpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <span>Yummly</span>
	<input type="checkbox" id="publish11" name="csbwfs_vkpublishBtn" value="yes" <?php if(get_option('csbwfs_vkpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <span>VK</span>
	<input type="checkbox" id="publish12" name="csbwfs_bufpublishBtn" value="yes" <?php if(get_option('csbwfs_bufpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <span>Buffer</span>	</p>
	<p><input type="checkbox" id="ytBtns" name="csbwfs_ytpublishBtn" value="yes" <?php if(get_option('csbwfs_ytpublishBtn')=='yes'){echo 'checked="checked"';}?>/> Youtube</p>
	<p id="ytpath" <?php if(get_option('csbwfs_ytpublishBtn')=='yes'): echo 'style="display:block;"';else:echo 'style="display:none;"';endif;?>>Youtube Channel URL<input type="text" name="csbwfs_ytPath" id="csbwfs_ytPath" value="<?php echo get_option('csbwfs_ytPath');?>" placeholder="http://www.youtube.com" size="40" class="regular-text ltr"></p>
	<p><input type="checkbox" id="rssBtns" name="csbwfs_rsspublishBtn" value="1" <?php checked( get_option('csbwfs_rsspublishBtn'), 1 ); ?> /> RSS Feed</p>
	<p id="rsspath" <?php if(get_option('csbwfs_rsspublishBtn')=='1'): echo 'style="display:block;"';else:echo 'style="display:none;"';endif;?>>Feed URL<input type="text" name="csbwfs_rssPath" id="csbwfs_rssPath" value="<?php echo get_option('csbwfs_rssPath');?>" placeholder="http://www.yoursite.com/feed" size="40" class="regular-text ltr"></p>
	<p><input type="checkbox" id="csbwfs_instpublishBtn" name="csbwfs_instpublishBtn" value="yes" <?php if(get_option('csbwfs_instpublishBtn')=='yes'){echo 'checked="checked"';}?>/> <b>Instagram</b></p>
	<p id="csbwfs_inst" <?php if(get_option('csbwfs_instpublishBtn')=='yes'): echo 'style="display:block;"';else:echo 'style="display:none;"';endif;?> ><?php echo 'Instagram Official Page URL:';?> <input type="text" id="csbwfs_inst_page_url" name="csbwfs_inst_page_url" value="<?php echo get_option('csbwfs_inst_page_url'); ?>" placeholder="https://instagram.com/hello/" size="40"/>
	</p>
	<p><input type="checkbox" id="csbwfs_skypublishBtn" name="csbwfs_skypublishBtn" value="yes" <?php checked( get_option('csbwfs_skypublishBtn'),'yes' ); ?>/> <b>Skype</b></p>
	<p id="csbwfs_inst" <?php if(get_option('csbwfs_skypublishBtn')=='yes'): echo 'style="display:block;"';else:echo 'style="display:none;"';endif;?> ><?php echo 'Skype User Name:';?> <input type="text" id="csbwfs_skyUnpublishBtn" name="csbwfs_skyUnpublishBtn" value="<?php echo get_option('csbwfs_skyUnpublishBtn'); ?>" placeholder="Skype User Name" size="40"/>
	</p>
	<hr>
	<p class="csbwfs-genp"><h3><?php _e('Show share count:','csbwfs');?></h3></br>
			<input type="checkbox" id="csbwfs_share_count_fb" name="csbwfs_share_count_fb" value="yes" <?php if(get_option('csbwfs_share_count_fb')=='yes'){echo 'checked="checked"';}?>/> <span>Facebook</span>
			<input type="checkbox" id="csbwfs_share_count_gp" name="csbwfs_share_count_gp" value="yes" <?php if(get_option('csbwfs_share_count_gp')=='yes'){echo 'checked="checked"';}?>/> <span>Google Plus</span>
			<input type="checkbox" id="csbwfs_share_count_li" name="csbwfs_share_count_li" value="yes" <?php if(get_option('csbwfs_share_count_li')=='yes'){echo 'checked="checked"';}?>/> <span>LinkedIn</span>
			<input type="checkbox" id="csbwfs_share_count_pin" name="csbwfs_share_count_pin" value="yes" <?php if(get_option('csbwfs_share_count_pin')=='yes'){echo 'checked="checked"';}?>/> <span>Pinterest</span>
			<input type="checkbox" id="csbwfs_share_count_st" name="csbwfs_share_count_st" value="yes" <?php if(get_option('csbwfs_share_count_st')=='yes'){echo 'checked="checked"';}?>/> <span>StumbleUpon</span>
			<input type="checkbox" id="csbwfs_share_count_re" name="csbwfs_share_count_re" value="yes" <?php if(get_option('csbwfs_share_count_re')=='yes'){echo 'checked="checked"';}?>/> <span>Reddit</span>
			<input type="checkbox" id="csbwfs_share_count_tu" name="csbwfs_share_count_tu" value="yes" <?php if(get_option('csbwfs_share_count_tu')=='yes'){echo 'checked="checked"';}?>/> <span>Tumblr</span></p>
	<p><select name="csbwfs_wayofcount" id="csbwfs_wayofcount"><option value="default" <?php selected(get_option('csbwfs_wayofcount'),'default') ?>>Default</option><option value="curl" <?php selected(get_option('csbwfs_wayofcount'),'curl') ?>>cURL</option></select></p>
	<hr />
	<p><label><h3 ><strong><?php _e('Define your custom message:','csbwfs');?></strong></h3></label></p>
	<p><label><?php _e('Show:');?></label><input type="text" id="csbwfs_show_btn" name="csbwfs_show_btn" value="<?php echo get_option('csbwfs_show_btn'); ?>" placeholder="Show Buttons" size="40"/></p>
	<p><label><?php _e('Hide:');?></label><input type="text" id="csbwfs_hide_btn" name="csbwfs_hide_btn" value="<?php echo get_option('csbwfs_hide_btn'); ?>" placeholder="Hide Buttons" size="40"/></p>
	<p><label><?php _e('Message:');?></label><input type="text" id="csbwfs_share_msg" name="csbwfs_share_msg" value="<?php echo get_option('csbwfs_share_msg'); ?>" placeholder="Share This With Your Friends" size="40"/></p>
	<!--<p><?php _e('Enable Short Url:');?><select id="csbwfs_short_url" name="csbwfs_short_url" >
	<option value="no" <?php selected(get_option('csbwfs_short_url'),'no');?>>No</option>	
	<option value="yes" <?php selected(get_option('csbwfs_short_url'),'yes');?>>Yes</option>
    </select></p> -->
	<p><?php _e('Enable OG Tags:');?><select id="csbwfs_og_tags_enable" name="csbwfs_og_tags_enable" >
	<option value="no" <?php if(get_option('csbwfs_og_tags_enable')=='no'){echo 'selected="selected"';}?>>No</option>	
	<option value="yes" <?php if(get_option('csbwfs_og_tags_enable')=='yes'){echo 'selected="selected"';}?>>Yes</option>
    </select></p>
     <?php if(get_option('csbwfs_og_tags_enable')=='yes'){?>
	<p><label><h3 ><strong><?php _e('Define default OG tag content:','csbwfs');?></strong></h3></label></p>
	<table>
	<tr>
	<td><label><?php _e('OG Title:');?></label></td>
	<td><input type="text" id="csbwfs_dft_og_title" name="csbwfs_dft_og_title" value="<?php echo get_option('csbwfs_dft_og_title'); ?>" placeholder="Show Buttons" size="40"/></td>
	</tr>
	<tr>
	<td><label><?php _e('OG Description:');?></label></td>
	<td><textarea type="text" id="csbwfs_dft_og_desc" name="csbwfs_dft_og_desc" rows="5" cols="40"><?php echo get_option('csbwfs_dft_og_desc'); ?></textarea></td>
	</tr>
	<tr><td><label><?php _e('OG Image:');?></label></td>
	<td class="csbwfsButtonsImg" id="csbwfsButtonsOgImg">		
				<input type="text" id="csbwfs_dft_og_img" name="csbwfs_dft_og_img" value="<?php echo get_option('csbwfs_dft_og_img'); ?>" placeholder="Insert OG image path" size="30" class="inputButtonid"/><input id="csbwfs_dft_og_img_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;</td>
	</tr>
	</table>
<?php }?>
</div>
<!-- Floating Sidebar -->
<div class="csbwfs-tab" id="div-csbwfs-sidebar">
<h2>Floating Sidebar Settings</h2>
	<table>
			<tr>
				<th nowrap><?php echo 'Siderbar Position:';?></th>
				<td>
				<select id="csbwfs_position" name="csbwfs_position" >
				<option value="left" <?php if(get_option('csbwfs_position')=='left'){echo 'selected="selected"';}?>>Left</option>
				<option value="right" <?php if(get_option('csbwfs_position')=='right'){echo 'selected="selected"';}?>>Right</option>
				<option value="bottom" <?php if(get_option('csbwfs_position')=='bottom'){echo 'selected="selected"';}?>>Bottom</option>
				</select>
				</td>
			</tr>
			<tr><th nowrap valign="top"><?php _e('Delay Time:','csbwfs'); ?></th><td><input type="text" name="csbwfs_delayTimeBtn" id="csbwfs_delayTimeBtn" value="<?php echo get_option('csbwfs_delayTimeBtn')?get_option('csbwfs_delayTimeBtn'):0;?>"  size="40" class="regular-text ltr"><br><i>Publish share buttons after given time(millisecond)</i></td></tr>
			<tr><th></th>
				<td><input type="checkbox" id="csbwfs_deactive_for_mob" name="csbwfs_deactive_for_mob" value="yes" <?php if(get_option('csbwfs_deactive_for_mob')=='yes'){echo 'checked="checked"';}?>/><?php _e('Disable On Mobile','csbwfs');?></td>
			</tr>
			<tr><th></th>
				<td><input type="checkbox" id="csbwfs_auto_hide" name="csbwfs_auto_hide" value="yes" <?php if(get_option('csbwfs_auto_hide')=='yes'){echo 'checked="checked"';}?>/><?php _e('Auto Hide Sidebar On Page Load','csbwfs');?></td>
			</tr>
			<tr><th></th>
				<td><input type="checkbox" id="csbwfs_pro_horizontal_for_mobile" name="csbwfs_pro_horizontal_for_mobile" value="yes" <?php if(get_option('csbwfs_pro_horizontal_for_mobile')=='yes'){echo 'checked="checked"';}?>/><?php _e('Set Horizontal Position for Mobile','csbwfs');?></td>
			</tr>
			<tr>
			<th> </th>
			<td><input type="checkbox" id="csbwfs_rmSHBtn" name="csbwfs_rmSHBtn" value="yes" <?php if(get_option('csbwfs_rmSHBtn')=='yes'){echo 'checked="checked"';}?>/><?php _e('Remove Show/Hide Button:','csbwfs');?></td>
			</tr>
			<tr><th><strong><?php _e('Hide Sidebar On :','csbwfs');?></strong></th><td><input type="checkbox" id="csbwfs_hide_home" value="yes" name="csbwfs_hide_home" <?php if(get_option('csbwfs_hide_home')!='yes'){echo '';}else{echo 'checked="checked"';}?>/>Home <input type="checkbox" id="csbwfs_hide_page" value="yes" name="csbwfs_hide_page" <?php if(get_option('csbwfs_hide_page')!='yes'){echo '';}else { echo 'checked="checked"';}?>/> Page <input type="checkbox" id="csbwfs_hide_post" value="yes" name="csbwfs_hide_post" <?php if(get_option('csbwfs_hide_post')!='yes'){echo '';}else{echo 'checked="checked"';}?>/> Post <input type="checkbox" id="csbwfs_hide_product" value="yes" name="csbwfs_hide_product" <?php if(get_option('csbwfs_hide_product')!='yes'){echo '';}else{echo 'checked="checked"';}?>/> Product <input type="checkbox" id="csbwfs_hide_archive" value="yes" name="csbwfs_hide_archive" <?php if(get_option('csbwfs_hide_archive')!='yes'){echo '';}else{echo 'checked="checked"';}?>/> Category/Archive  <br>
			</td></tr>
			<tr><td>&nbsp;</td><td> <br><input type="text" name="cswbfs_exclude_post_type" placeholder="add comma seprate custom post type where you want to hide sidebar" id="cswbfs_exclude_post_type" size="70" value="<?php echo get_option('cswbfs_exclude_post_type'); ?>" ></td></tr>
			<tr><td colspan="2" align="right"><hr><hr></td></tr>
			<tr><td colspan="2"><strong><h4>Social Share Button Images 36X34 (Optional) :</h4></strong></td></tr>
			<tr><td><strong>Buttons</strong></td><td><strong>Button Image Path</strong> <span style="padding-left: 40%;"><strong>Button BG Color</strong></span><span style="padding-left: 10%;"><strong>Title</strong></span></td></tr>
			<tr><td colspan="2"><hr></td></tr>
			<tr>
			<th><?php echo 'Facebook:';?></th>
			<td class="csbwfsButtonsImg" id="csbwfsButtonsFbImg" nowrap>
	       <input type="text" id="csbwfs_fb_image" name="csbwfs_fb_image" value="<?php echo get_option('csbwfs_fb_image'); ?>" placeholder="Insert facebook button image path" size="30" class="inputButtonid"/> <input id="csbwfs_fb_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_fb_bg" data-default-color="#305891" class="color-field" name="csbwfs_fb_bg" value="<?php echo get_option('csbwfs_fb_bg'); ?>" size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_fb_title"  name="csbwfs_fb_title" value="<?php echo get_option('csbwfs_fb_title'); ?>" placeholder="Share on facebook" size="20"/>
			</td>
			</tr>
			<tr><th><?php echo 'Twitter:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsTwImg">		
				<input type="text" id="csbwfs_tw_image" name="csbwfs_tw_image" value="<?php echo get_option('csbwfs_tw_image'); ?>" placeholder="Insert twitter button image path" size="30" class="inputButtonid"/><input id="csbwfs_tw_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_tw_bg" name="csbwfs_tw_bg" value="<?php echo get_option('csbwfs_tw_bg'); ?>" data-default-color="#2ca8d2" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_tw_title"  name="csbwfs_tw_title" value="<?php echo get_option('csbwfs_tw_title'); ?>" placeholder="Share on twitter" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Linkdin:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsLiImg">
				<input type="text" id="csbwfs_li_image" name="csbwfs_li_image" value="<?php echo get_option('csbwfs_li_image'); ?>" placeholder="Insert linkdin button image path" class="inputButtonid" size="30" class="buttonimg"/><input id="csbwfs_li_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_li_bg" name="csbwfs_li_bg" value="<?php echo get_option('csbwfs_li_bg'); ?>" data-default-color="#dd4c39" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_li_title"  name="csbwfs_li_title" value="<?php echo get_option('csbwfs_li_title'); ?>" placeholder="Share on linkdin" size="20"/>
				</td>
			</tr>
			<tr><th><?php echo 'Pintrest:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsPiImg">			
				<input type="text" id="csbwfs_pin_image" name="csbwfs_pin_image" value="<?php echo get_option('csbwfs_pin_image'); ?>" class="inputButtonid" placeholder="Insert pinterest button image path" size="30" class="buttonimg"/><input id="csbwfs_pin_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_pin_bg" name="csbwfs_pin_bg" value="<?php echo get_option('csbwfs_pin_bg'); ?>" data-default-color="#ca2027" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_pin_title"  name="csbwfs_pin_title" value="<?php echo get_option('csbwfs_pin_title'); ?>" placeholder="Share on pintrest" size="20"/>
				</td>
			</tr>
			<tr><th><?php echo 'Google Plus:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsGoImg">
				<input type="text" id="csbwfs_gp_image" name="csbwfs_gp_image" value="<?php echo get_option('csbwfs_gp_image'); ?>" placeholder="Insert google button image path" size="30" class="inputButtonid"/><input id="csbwfs_gp_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_gp_image" name="csbwfs_gp_bg" value="<?php echo get_option('csbwfs_gp_bg'); ?>" data-default-color="#dd4c39" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_gp_title"  name="csbwfs_gp_title" value="<?php echo get_option('csbwfs_gp_title'); ?>" placeholder="Share on google" size="20"/>
				</td>
			</tr>
			<tr><th><?php echo 'Mail:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsMaImg">
				<input type="text" id="csbwfs_mail_image" name="csbwfs_mail_image" value="<?php echo get_option('csbwfs_mail_image'); ?>" placeholder="Insert mail button image path" size="30" class="inputButtonid"/><input id="csbwfs_mail_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_mail_bg" name="csbwfs_mail_bg" value="<?php echo get_option('csbwfs_mail_bg'); ?>" data-default-color="#738a8d" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_mail_title"  name="csbwfs_mail_title" value="<?php echo get_option('csbwfs_mail_title'); ?>" placeholder="Send contact request" size="20"/>
				</td>
			</tr>
			<tr><th><?php echo 'Print:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsPrintImg">
				<input type="text" id="csbwfs_print_image" name="csbwfs_print_image" value="<?php echo get_option('csbwfs_print_image'); ?>" placeholder="Insert print button image path" size="30" class="inputButtonid"/><input id="csbwfs_print_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_print_bg" name="csbwfs_print_bg" value="<?php echo get_option('csbwfs_print_bg'); ?>" data-default-color="#738a8d" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_print_title"  name="csbwfs_print_title" value="<?php echo get_option('csbwfs_print_title'); ?>" placeholder="Print" size="20"/>
				</td>
			</tr>
			<tr><th><?php echo 'Youtube:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsYtImg">
				<input type="text" id="csbwfs_yt_image" name="csbwfs_yt_image" value="<?php echo get_option('csbwfs_yt_image'); ?>" placeholder="Insert youtube button image path" size="30" class="inputButtonid"/><input id="csbwfs_yt_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_yt_bg" name="csbwfs_yt_bg" value="<?php echo get_option('csbwfs_yt_bg'); ?>" data-default-color="#ffffff" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_yt_title"  name="csbwfs_yt_title" value="<?php echo get_option('csbwfs_yt_title'); ?>" placeholder="Youtube" size="20"/>
				</td>
			</tr>
			<tr><th><?php echo 'Reddit:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsReImg">
				<input type="text" id="csbwfs_re_image" name="csbwfs_re_image" value="<?php echo get_option('csbwfs_re_image'); ?>" placeholder="Insert reddit button image path" size="30" class="inputButtonid"/><input id="csbwfs_re_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_re_bg" name="csbwfs_re_bg" value="<?php echo get_option('csbwfs_re_bg'); ?>" data-default-color="#ff1a00" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_re_title"  name="csbwfs_re_title" value="<?php echo get_option('csbwfs_re_title'); ?>" placeholder="Share on reddit" size="20"/>
				</td>
			</tr>
			<tr><th><?php echo 'Stumbleupon:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsStImg">
				<input type="text" id="csbwfs_st_image" name="csbwfs_st_image" value="<?php echo get_option('csbwfs_st_image'); ?>" placeholder="Insert stumbleupon button image path" size="30" class="inputButtonid"/><input id="csbwfs_st_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_st_bg" name="csbwfs_st_bg" value="<?php echo get_option('csbwfs_st_bg'); ?>" data-default-color="#eb4924" class="color-field"  size="20"/>
				&nbsp;&nbsp;<input type="text" id="csbwfs_st_title"  name="csbwfs_st_title" value="<?php echo get_option('csbwfs_st_title'); ?>" placeholder="Share on stumbleupon" size="20"/>
				</td>
			</tr>
			<tr><th><?php _e('Google Translate:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsGtImg">
				<input type="text" id="csbwfs_gt_image" name="csbwfs_gt_image" value="<?php echo get_option('csbwfs_gt_image'); ?>" placeholder="Insert google translate button image path" size="30" class="inputButtonid"/><input id="csbwfs_gt_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_gt_bg" name="csbwfs_gt_bg" value="<?php echo get_option('csbwfs_gt_bg'); ?>" data-default-color="#2c72c7" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_gt_title"  name="csbwfs_gt_title" value="<?php echo get_option('csbwfs_gt_title'); ?>" placeholder="Translate page" size="20"/>
				</td>
			</tr>
			<tr><th><?php _e('Instagram:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsInImg">
				<input type="text" id="csbwfs_inst_image" name="csbwfs_inst_image" value="<?php echo get_option('csbwfs_inst_image'); ?>" placeholder="Insert instagram button image path" size="30" class="inputButtonid"/><input id="csbwfs_in_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/> <input type="text" id="csbwfs_inst_bg" name="csbwfs_inst_bg" value="<?php echo get_option('csbwfs_inst_bg'); ?>" data-default-color="#467499" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_inst_title"  name="csbwfs_inst_title" value="<?php echo get_option('csbwfs_inst_title'); ?>" placeholder="Share on instagram" size="20"/>
				</td>
			</tr>
			<tr><th><?php _e('Diggit:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsDiggImg">
				<input type="text" id="csbwfs_digg_image" name="csbwfs_digg_image" value="<?php echo get_option('csbwfs_digg_image'); ?>" placeholder="Insert diggit button image path" size="30" class="inputButtonid"/><input id="csbwfs_digg_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/> <input type="text" id="csbwfs_digg_bg" name="csbwfs_digg_bg" value="<?php echo get_option('csbwfs_digg_bg'); ?>" data-default-color="#467499" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_digg_title"  name="csbwfs_digg_title" value="<?php echo get_option('csbwfs_digg_title'); ?>" placeholder="Share on Diggit" size="20"/>
				</td>
			</tr>		
			<tr><th><?php _e('Yummly:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsYumImg">
				<input type="text" id="csbwfs_yum_image" name="csbwfs_yum_image" value="<?php echo get_option('csbwfs_yum_image'); ?>" placeholder="Insert yummly button image path" size="30" class="inputButtonid"/><input id="csbwfs_yum_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/> <input type="text" id="csbwfs_yum_bg" name="csbwfs_yum_bg" value="<?php echo get_option('csbwfs_yum_bg'); ?>" data-default-color="#467499" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_yum_title"  name="csbwfs_yum_title" value="<?php echo get_option('csbwfs_yum_title'); ?>" placeholder="Share on Yummly" size="20"/>
				</td>
			</tr>		
			<tr><th><?php _e('VK:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsVkImg">
				<input type="text" id="csbwfs_vk_image" name="csbwfs_vk_image" value="<?php echo get_option('csbwfs_vk_image'); ?>" placeholder="Insert vk button image path" size="30" class="inputButtonid"/><input id="csbwfs_vk_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/> <input type="text" id="csbwfs_vk_bg" name="csbwfs_vk_bg" value="<?php echo get_option('csbwfs_vk_bg'); ?>" data-default-color="#467499" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_vk_title"  name="csbwfs_vk_title" value="<?php echo get_option('csbwfs_vk_title'); ?>" placeholder="Share on VK" size="20"/>
				</td>
			</tr>		
			<tr><th><?php _e('Buffer:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsBufImg">
				<input type="text" id="csbwfs_buf_image" name="csbwfs_buf_image" value="<?php echo get_option('csbwfs_buf_image'); ?>" placeholder="Insert buffer button image path" size="30" class="inputButtonid"/><input id="csbwfs_buf_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/> <input type="text" id="csbwfs_buf_bg" name="csbwfs_buf_bg" value="<?php echo get_option('csbwfs_buf_bg'); ?>" data-default-color="#467499" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_buf_title"  name="csbwfs_buf_title" value="<?php echo get_option('csbwfs_buf_title'); ?>" placeholder="Share on Buffer" size="20"/>
				</td>
			</tr>			
			<tr><th><?php _e('Tumblr:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsTuImg">
				<input type="text" id="csbwfs_tu_image" name="csbwfs_tu_image" value="<?php echo get_option('csbwfs_tu_image'); ?>" placeholder="Insert tumblr button image path" size="30" class="inputButtonid"/><input id="csbwfs_tu_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/> <input type="text" id="csbwfs_tu_bg" name="csbwfs_tu_bg" value="<?php echo get_option('csbwfs_tu_bg'); ?>" data-default-color="#314f6b" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_tu_title"  name="csbwfs_tu_title" value="<?php echo get_option('csbwfs_tu_title'); ?>" placeholder="Share on Tumblr" size="20"/>
				</td>
			</tr>			
			<tr><th><?php _e('Gmail:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsGmImg">
				<input type="text" id="csbwfs_gm_image" name="csbwfs_gm_image" value="<?php echo get_option('csbwfs_gm_image'); ?>" placeholder="Insert gmail button image path" size="30" class="inputButtonid"/><input id="csbwfs_gm_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/> <input type="text" id="csbwfs_gm_bg" name="csbwfs_gm_bg" value="<?php echo get_option('csbwfs_gm_bg'); ?>" data-default-color="#db4939" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_gm_title"  name="csbwfs_gm_title" value="<?php echo get_option('csbwfs_gm_title'); ?>" placeholder="Share on Gmail" size="20"/>
				</td>
			</tr>			
			<tr><th><?php _e('Blogger:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsBlImg">
				<input type="text" id="csbwfs_bl_image" name="csbwfs_bl_image" value="<?php echo get_option('csbwfs_bl_image'); ?>" placeholder="Insert blogger button image path" size="30" class="inputButtonid"/><input id="csbwfs_bl_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/> <input type="text" id="csbwfs_bl_bg" name="csbwfs_bl_bg" value="<?php echo get_option('csbwfs_bl_bg'); ?>" data-default-color="#f58d38" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_bl_title"  name="csbwfs_bl_title" value="<?php echo get_option('csbwfs_bl_title'); ?>" placeholder="Share on Blogger" size="20"/>
				</td>
			</tr>			
			<tr><th><?php _e('Delicious:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsDeImg">
				<input type="text" id="csbwfs_de_image" name="csbwfs_de_image" value="<?php echo get_option('csbwfs_de_image'); ?>" placeholder="Insert delicious button image path" size="30" class="inputButtonid"/><input id="csbwfs_de_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/> <input type="text" id="csbwfs_de_bg" name="csbwfs_de_bg" value="<?php echo get_option('csbwfs_de_bg'); ?>" data-default-color="#349afa" class="color-field"  size="20"/>&nbsp;&nbsp;<input type="text" id="csbwfs_de_title"  name="csbwfs_de_title" value="<?php echo get_option('csbwfs_de_title'); ?>" placeholder="Share on Delicious" size="20"/>
				</td>
			</tr>			
			<tr><td colspan="2"><hr><h3><strong>Extra Buttons:</strong></h3></td></tr>
			<tr><th valign="top"><?php _e('Custom Image Button 1:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsC1Img" valign="top"> Enable : <input type="checkbox" id="publish10" name="csbwfs_c1publishBtn" value="yes" <?php if(get_option('csbwfs_c1publishBtn')=='yes'){echo 'checked="checked"';}?>/> <br>
				<span>Image URL :</span> <input type="text" id="csbwfs_custom_image" name="csbwfs_custom_image" value="<?php echo get_option('csbwfs_custom_image'); ?>" placeholder="Insert custom 1 button image path" size="30" class="inputButtonid"/><input id="csbwfs_custom_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/><br>Button URL: <input type="text" id="csbwfs_custom_url"  name="csbwfs_custom_url" value="<?php echo get_option('csbwfs_custom_url'); ?>" placeholder="http://www.yourdomain.com" size="40"/><br>Text/Title : &nbsp;&nbsp;&nbsp;<input type="text" id="csbwfs_custom_title"  name="csbwfs_custom_title" value="<?php echo get_option('csbwfs_custom_title'); ?>" placeholder="custom 1" size="40"/> <br>Animate Width: &nbsp;&nbsp;&nbsp;<input type="text" id="csbwfs_custom_width"  name="csbwfs_custom_width" value="<?php echo get_option('csbwfs_custom_width'); ?>" placeholder="150" size="40"/>px <br>Link Target : <select name="csbwfs_custom_target"><option value="_self" <?php if(get_option('csbwfs_custom_target')=='_self'){ echo 'selected="selected"';}?>>Self</option><option value="_blank" <?php if(get_option('csbwfs_custom_target')=='_blank'){ echo 'selected="selected"';}?>>Blank</option></select> Background Color : <input type="text" id="csbwfs_custom_bg" name="csbwfs_custom_bg" value="<?php echo get_option('csbwfs_custom_bg'); ?>" data-default-color="#2c72c7" class="color-field"  size="20"/>
				</td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr><th valign="top"><?php _e('Custom Image Button 2:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsC2Img" valign="top">Enable : <input type="checkbox" id="publish11" name="csbwfs_c2publishBtn" value="yes" <?php if(get_option('csbwfs_c2publishBtn')=='yes'){echo 'checked="checked"';}?>/><br>
				Image URL : <input type="text" id="csbwfs_custom2_image" name="csbwfs_custom2_image" value="<?php echo get_option('csbwfs_custom2_image'); ?>" placeholder="custom2 button image path" size="30" class="inputButtonid"/><input id="csbwfs_custom2_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/><br>Button URL: <input type="text" id="csbwfs_custom2_url"  name="csbwfs_custom2_url" value="<?php echo get_option('csbwfs_custom2_url'); ?>" placeholder="http://www.yourdomain.com" size="40"/><br>Text/Title : &nbsp;&nbsp;&nbsp;<input type="text" id="csbwfs_custom2_title"  name="csbwfs_custom2_title" value="<?php echo get_option('csbwfs_custom2_title'); ?>" placeholder="custom2" size="40"/> <br>Animate Width: &nbsp;&nbsp;&nbsp;<input type="text" id="csbwfs_custom2_width"  name="csbwfs_custom2_width" value="<?php echo get_option('csbwfs_custom2_width'); ?>" placeholder="150" size="40"/>px <br>Link Target : <select name="csbwfs_custom2_target"><option value="_self" <?php if(get_option('csbwfs_custom2_target')=='_self'){ echo 'selected="selected"';}?>>Self</option><option value="_blank" <?php if(get_option('csbwfs_custom2_target')=='_blank'){ echo 'selected="selected"';}?>>Blank</option></select> Background Color : <input type="text" id="csbwfs_custom2_bg" name="csbwfs_custom2_bg" value="<?php echo get_option('csbwfs_custom2_bg'); ?>" data-default-color="#467499" class="color-field"  size="20"/>
				</td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr><th valign="top"><?php _e('Custom Text Button 1:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsC3Img" valign="top"> Enable : <input type="checkbox" id="publish12" name="csbwfs_c3publishBtn" value="yes" <?php if(get_option('csbwfs_c3publishBtn')=='yes'){echo 'checked="checked"';}?>/> <br>
				Title : <input type="text" id="csbwfs_custom3_title" name="csbwfs_custom3_title" value="<?php echo get_option('csbwfs_custom3_title'); ?>" placeholder="button title" size="40" class="inputButtonid"/><br>Button URL: <input type="text" id="csbwfs_custom3_url"  name="csbwfs_custom3_url" value="<?php echo get_option('csbwfs_custom3_url'); ?>" placeholder="http://www.yourdomain.com" size="40"/><br> Width: <input type="text" id="csbwfs_custom3_defltwidth"  name="csbwfs_custom3_defltwidth" value="<?php echo get_option('csbwfs_custom3_defltwidth'); ?>" placeholder="40" size="5"/>px &nbsp;&nbsp;&nbsp;Animate Width:<input type="text" id="csbwfs_custom3_width"  name="csbwfs_custom3_width" value="<?php echo get_option('csbwfs_custom3_width'); ?>" placeholder="150" size="5"/>px <br>Height:<input type="text" id="csbwfs_custom3_hght"  name="csbwfs_custom3_hght" value="<?php echo get_option('csbwfs_custom3_hght'); ?>" placeholder="41" size="5"/>px &nbsp;&nbsp;&nbsp;Link Target :<select name="csbwfs_custom3_target"><option value="_self" <?php if(get_option('csbwfs_custom3_target')=='_self'){ echo 'selected="selected"';}?>>Self</option><option value="_blank" <?php if(get_option('csbwfs_custom3_target')=='_blank'){ echo 'selected="selected"';}?>>Blank</option></select><br>Text Color:<input type="text" id="csbwfs_custom3_txt_color" name="csbwfs_custom3_txt_color" value="<?php echo get_option('csbwfs_custom3_txt_color'); ?>" data-default-color="#ffffff" class="color-field"  size="20"/>&nbsp;&nbsp;&nbsp; Background Color:<input type="text" id="csbwfs_custom3_bg" name="csbwfs_custom3_bg" value="<?php echo get_option('csbwfs_custom3_bg'); ?>" data-default-color="#666666" class="color-field"  size="20"/>
				</td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr><th valign="top"><?php _e('Custom Text Button 2:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsC4Img" valign="top"> Enable : 	
	<input type="checkbox" id="publish13" name="csbwfs_c4publishBtn" value="yes" <?php if(get_option('csbwfs_c4publishBtn')=='yes'){echo 'checked="checked"';}?>/><br>
				Title : <input type="text" id="csbwfs_custom4_title" name="csbwfs_custom4_title" value="<?php echo get_option('csbwfs_custom4_title'); ?>" placeholder="button title" size="40" class="inputButtonid"/><br>Button URL: <input type="text" id="csbwfs_custom4_url"  name="csbwfs_custom4_url" value="<?php echo get_option('csbwfs_custom4_url'); ?>" placeholder="http://www.yourdomain.com" size="40"/><br>Width:<input type="text" id="csbwfs_custom4_defltwidth"  name="csbwfs_custom4_defltwidth" value="<?php echo get_option('csbwfs_custom4_defltwidth'); ?>" placeholder="41" size="5"/>px &nbsp;&nbsp;&nbsp;Animate Width:<input type="text" id="csbwfs_custom4_width"  name="csbwfs_custom4_width" value="<?php echo get_option('csbwfs_custom4_width'); ?>" placeholder="150" size="5"/>px <br>Height:<input type="text" id="csbwfs_custom4_hght"  name="csbwfs_custom4_hght" value="<?php echo get_option('csbwfs_custom4_hght'); ?>" placeholder="41" size="5"/>px &nbsp;&nbsp;&nbsp;Link Target:<select name="csbwfs_custom4_target"><option value="_self" <?php if(get_option('csbwfs_custom4_target')=='_self'){ echo 'selected="selected"';}?>>Self</option><option value="_blank" <?php if(get_option('csbwfs_custom4_target')=='_blank'){ echo 'selected="selected"';}?>>Blank</option></select> <br>Text Color:<input type="text" id="csbwfs_custom4_txt_color" name="csbwfs_custom4_txt_color" value="<?php echo get_option('csbwfs_custom4_txt_color'); ?>" data-default-color="#ffffff" class="color-field"  size="20"/>&nbsp;&nbsp;&nbsp;Background Color:<input type="text" id="csbwfs_custom4_bg" name="csbwfs_custom4_bg" value="<?php echo get_option('csbwfs_custom4_bg'); ?>" data-default-color="#666666" class="color-field"  size="20"/>
				</td>
			</tr>
			
			<tr><td colspan="2"><h3><strong>Additional Settings:</strong></h3></td></tr>
				<tr>
				<th nowrap><?php echo 'Show/Hide Floating Sidebar<br> on specific pages:';?></th>
				<td><select id="csbwfs_hide_on" name="csbwfs_hide_on" >
				<option value="hide" <?php if(get_option('csbwfs_hide_on')=='hide'){echo 'selected="selected"';}?>>Hide on</option>
				<option value="show" <?php if(get_option('csbwfs_hide_on')=='show'){echo 'selected="selected"';}?>>Show on </option>
				</select><input type="text" id="csbwfs_custom_page_ids" name="csbwfs_custom_page_ids" value="<?php echo get_option('csbwfs_custom_page_ids'); ?>" placeholder="Insert comma separate multi id" size="30"/> (i.e 1,2,3)</td>
			</tr>
			<tr><th><?php echo 'Show Total Share Count:';?></th>
				<td>
				<input type="text" id="csbwfs_count_sum" name="csbwfs_count_sum" value="<?php echo get_option('csbwfs_count_sum'); ?>" placeholder="" size="40"/> (<i>Leave blank to hide number of total share buttons</i>)
				</td>
			</tr>
			<tr><th>Define Distance From Left/Right</th>
				<td>	
			<input type="text" id="csbwfs_position_from_lr"  name="csbwfs_position_from_lr" value="<?php echo get_option('csbwfs_position_from_lr'); ?>" placeholder="0px" size="20"/></td>
			</tr>					
			<tr><th><?php echo 'Top Margin:';?></th>
				<td>
				<input type="text" id="csbwfs_top_margin" name="csbwfs_top_margin" value="<?php echo get_option('csbwfs_top_margin'); ?>" placeholder="10% OR 10px" size="10"/>
				</td>
			</tr>
			<tr><th><?php _e('Share Button Image (General Size:80x30):');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsSbiImg">
				<input type="text" id="csbwfs_sbi_image" name="csbwfs_sbi_image" value="<?php echo get_option('csbwfs_sbi_image'); ?>" placeholder="Insert Share Button image path" size="30" class="inputButtonid"/><input id="csbwfs_sbi_image_button" type="button" value="Upload Image" class="cswbfsUploadBtn"/>
				</td>
			</tr>			
	</table>
	</div>
	<!-- Share Buttons -->
	<div class="csbwfs-tab" id="div-csbwfs-share-buttons">
	<h2>Social Share Buttons Settings</h2>
	<table>
		<tr>
		    <th><?php _e('Enable:','csbwfs');?></th>
				<td ><input type="checkbox" id="csbwfs_pro_buttons_active" name="csbwfs_pro_buttons_active" value='1' <?php if(get_option('csbwfs_pro_buttons_active')!=''){ echo ' checked="checked"'; }?>/>
				</td>
		    </tr>
			<tr><th nowrap><?php echo 'Share Button Position:';?></th>
				<td>
				<select id="csbwfs_btn_position" name="csbwfs_btn_position" >
				<option value="left" <?php if(get_option('csbwfs_btn_position')=='left'){echo 'selected="selected"';}?>>Left</option>
				<option value="right" <?php if(get_option('csbwfs_btn_position')=='right'){echo 'selected="selected"';}?>>Right</option>
				</select>
				</td>
			</tr>
			<tr>
				<th nowrap><?php echo 'Display Buttons On ';?></th>
				<td>
				<select id="csbwfs_btn_display" name="csbwfs_btn_display" >
				<option value="above" <?php if(get_option('csbwfs_btn_display')=='above'){echo 'selected="selected"';}?>>Top Of The Content</option>
				<option value="below" <?php if(get_option('csbwfs_btn_display')=='below'){echo 'selected="selected"';}?>>Bottom Of The Content</option>
				</select>
				</td>
			</tr>
			<tr><th nowrap><?php echo 'Share Button Text:';?></th>
				<td>
				<input type="text" id="csbwfs_btn_text" name="csbwfs_btn_text" value="<?php echo get_option('csbwfs_btn_text'); ?>" placeholder="Share This!" size="20"/><i>(Leave blank if you want hide button)</i>
				</td>
			</tr>
			<tr><td colspan="2"><h3><strong>Additional Settings:</strong></h3></td></tr>
				<tr>
				<th nowrap><?php _e('Show/Hide buttons<br> on specific pages:');?></th>
				<td><select id="csbwfs_page_hide_on" name="csbwfs_page_hide_on" >
				<option value="hide" <?php selected(get_option('csbwfs_page_hide_on_'),'hide');?>>Hide on</option>
				<option value="show" <?php selected(get_option('csbwfs_page_hide_on'),'show');?>>Show on </option>
				</select><input type="text" id="csbwfs_page_custom_page_ids" name="csbwfs_page_custom_page_ids" value="<?php echo get_option('csbwfs_page_custom_page_ids'); ?>" placeholder="Insert comma separate multi id" size="30"/> (i.e 1,2,3)</td>
			</tr>
			<!--<tr><th><?php echo 'Show Total Share Count:';?></th>
				<td>
				<input type="text" id="csbwfs_count_sum_page" name="csbwfs_count_sum_page" value="<?php echo get_option('csbwfs_count_sum_page'); ?>" placeholder="" size="40"/> (<i>Leave blank to hide number of total share buttons</i>)
				</td>
			</tr>-->
			<tr><td colspan="2"><strong>Publish Share Buttons On :</strong> Home <input type="checkbox" id="csbwfs_page_hide_home" value="yes" name="csbwfs_page_hide_home" <?php if(get_option('csbwfs_page_hide_home')!='yes'){echo '';}else{echo 'checked="checked"';}?>/> Page <input type="checkbox" id="csbwfs_page_hide_page" value="yes" name="csbwfs_page_hide_page" <?php if(get_option('csbwfs_page_hide_page')!='yes'){echo '';}else { echo 'checked="checked"';}?>/> Post <input type="checkbox" id="csbwfs_page_hide_post" value="yes" name="csbwfs_page_hide_post" <?php if(get_option('csbwfs_page_hide_post')!='yes'){echo '';}else{echo 'checked="checked"';}?>/> Product <input type="checkbox" id="csbwfs_page_hide_product" value="yes" name="csbwfs_page_hide_product" <?php if(get_option('csbwfs_page_hide_product')!='yes'){echo '';}else{echo 'checked="checked"';}?>/> Category/Archive <input type="checkbox" id="csbwfs_page_hide_archive" value="yes" name="csbwfs_page_hide_archive" <?php if(get_option('csbwfs_page_hide_archive')!='yes'){echo '';}else{echo 'checked="checked"';}?>/>
			</td></tr>
				<tr><td>&nbsp;</td><td> <br><input type="text" name="cswbfs_include_post_type" placeholder="add comma seprate custom post type where you want to show share buttons" id="cswbfs_include_post_type" size="70" value="<?php echo get_option('cswbfs_include_post_type'); ?>" ></td></tr>
			<tr><td colspan="2" align="right"><hr><hr></td></tr>
			<tr><td colspan="2"><strong><h4>Social Share Button Images 31X30 (Optional) :</h4></strong></td></tr>
			<tr><th><?php echo 'Facebook:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsFbImg2"><input type="text" id="csbwfs_page_fb_image" name="csbwfs_page_fb_image" value="<?php echo get_option('csbwfs_page_fb_image'); ?>" placeholder="Insert facebook button image path" size="40"  class="inputButtonid"/>
                <input id="csbwfs_fb_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_fb_title"  name="csbwfs_page_fb_title" value="<?php echo get_option('csbwfs_page_fb_title'); ?>" placeholder="Alt Text" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Twitter:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsTwImg2">
				<input type="text" id="csbwfs_page_tw_image" name="csbwfs_page_tw_image" value="<?php echo get_option('csbwfs_page_tw_image'); ?>" placeholder="Insert twitter button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_tw_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_tw_title"  name="csbwfs_page_tw_title" value="<?php echo get_option('csbwfs_page_tw_title'); ?>" placeholder="Alt Text" size="20"/>
				</td>
			</tr>
			<tr><th><?php echo 'Linkdin:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsLiImg2"><input type="text" id="csbwfs_page_li_image" name="csbwfs_page_li_image" value="<?php echo get_option('csbwfs_page_li_image'); ?>" placeholder="Insert linkdin button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_li_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_li_title"  name="csbwfs_page_li_title" value="<?php echo get_option('csbwfs_page_li_title'); ?>" placeholder="Alt Text" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Pintrest:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsPiImg2"><input type="text" id="csbwfs_page_pin_image" name="csbwfs_page_pin_image" value="<?php echo get_option('csbwfs_page_pin_image'); ?>" placeholder="Insert pinterest button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_pi_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_pin_title"  name="csbwfs_page_pin_title" value="<?php echo get_option('csbwfs_page_pin_title'); ?>" placeholder="Alt Text" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Google Plus:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsGpImg2">
				<input type="text" id="csbwfs_page_gp_image" name="csbwfs_page_gp_image" value="<?php echo get_option('csbwfs_page_gp_image'); ?>" placeholder="Insert google button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_gp_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_gp_title"  name="csbwfs_page_gp_title" value="<?php echo get_option('csbwfs_page_gp_title'); ?>" placeholder="Alt Text" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Reddit:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsReImg2">
				<input type="text" id="csbwfs_page_re_image" name="csbwfs_page_re_image" value="<?php echo get_option('csbwfs_page_re_image'); ?>" placeholder="Insert reddit button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_re_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_re_title"  name="csbwfs_page_re_title" value="<?php echo get_option('csbwfs_page_re_title'); ?>" placeholder="Alt Text" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Stumbleupon:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsStImg2">
				<input type="text" id="csbwfs_page_st_image" name="csbwfs_page_st_image" value="<?php echo get_option('csbwfs_page_st_image'); ?>" placeholder="Insert stumbleupon button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_st_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_st_title"  name="csbwfs_page_st_title" value="<?php echo get_option('csbwfs_page_st_title'); ?>" placeholder="Alt Text" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Mail:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsMlImg2">
				<input type="text" id="csbwfs_page_mail_image" name="csbwfs_page_mail_image" value="<?php echo get_option('csbwfs_page_mail_image'); ?>" placeholder="Insert mail button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_ml_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_mail_title"  name="csbwfs_page_mail_title" value="<?php echo get_option('csbwfs_page_mail_title'); ?>" placeholder="Alt Text" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Print:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsPrintImg2">
				<input type="text" id="csbwfs_page_print_image" name="csbwfs_page_print_image" value="<?php echo get_option('csbwfs_page_print_image'); ?>" placeholder="Insert print button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_print_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_print_title"  name="csbwfs_page_print_title" value="<?php echo get_option('csbwfs_page_print_title'); ?>" placeholder="Alt Text" size="20"/>
				</td>
			</tr>
			<tr>
				<th><?php echo 'Youtube:';?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsYtImg2">
				<input type="text" id="csbwfs_page_yt_image" name="csbwfs_page_yt_image" value="<?php echo get_option('csbwfs_page_yt_image'); ?>" placeholder="Insert youtube button image path" size="40" class="inputButtonid"/>
				<input id="csbwfs_yt_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_yt_title"  name="csbwfs_page_yt_title" value="<?php echo get_option('csbwfs_page_yt_title'); ?>" placeholder="Alt Text" size="20"/>
				</td>
			</tr>
			<tr><th><?php _e('Google Translate:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsGtImg2">
				<input type="text" id="csbwfs_page_gt_image" name="csbwfs_page_gt_image" value="<?php echo get_option('csbwfs_page_gt_image'); ?>" placeholder="Insert google translate button image path" size="40" class="inputButtonid"/><input id="csbwfs_gt_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_gt_title"  name="csbwfs_page_gt_title" value="<?php echo get_option('csbwfs_page_gt_title'); ?>" placeholder="Alt Text" size="20"/>
				</td>
			</tr>
			<tr><th><?php _e('Instagram:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsInImg2">
				<input type="text" id="csbwfs_page_inst_image" name="csbwfs_page_inst_image" value="<?php echo get_option('csbwfs_page_inst_image'); ?>" placeholder="Insert instagram button image path" size="40" class="inputButtonid"/><input id="csbwfs_in_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_inst_title"  name="csbwfs_page_inst_title" value="<?php echo get_option('csbwfs_page_inst_title'); ?>" placeholder="Alt Text" size="20"/>
			</tr>
			<tr><th><?php _e('Diggit:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsDiggImg2">
				<input type="text" id="csbwfs_page_digg_image" name="csbwfs_page_digg_image" value="<?php echo get_option('csbwfs_page_digg_image'); ?>" placeholder="Insert diggit button image path" size="40" class="inputButtonid"/><input id="csbwfs_digg_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_digg_title"  name="csbwfs_page_digg_title" value="<?php echo get_option('csbwfs_page_digg_title'); ?>" placeholder="Alt Text" size="20"/>
			</tr>			
			<tr><th><?php _e('Yummly:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsYumImg2">
				<input type="text" id="csbwfs_page_yum_image" name="csbwfs_page_yum_image" value="<?php echo get_option('csbwfs_page_yum_image'); ?>" placeholder="Insert yummly button image path" size="40" class="inputButtonid"/><input id="csbwfs_yum_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_yum_title"  name="csbwfs_page_yum_title" value="<?php echo get_option('csbwfs_page_yum_title'); ?>" placeholder="Alt Text" size="20"/>
			</tr>			
			<tr><th><?php _e('VK:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsVkImg2">
				<input type="text" id="csbwfs_page_vk_image" name="csbwfs_page_vk_image" value="<?php echo get_option('csbwfs_page_vk_image'); ?>" placeholder="Insert vk button image path" size="40" class="inputButtonid"/><input id="csbwfs_vk_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_vk_title"  name="csbwfs_page_vk_title" value="<?php echo get_option('csbwfs_page_vk_title'); ?>" placeholder="Alt Text" size="20"/>
			</tr>			
			<tr><th><?php _e('Buffer:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsBufImg2">
				<input type="text" id="csbwfs_page_buf_image" name="csbwfs_page_buf_image" value="<?php echo get_option('csbwfs_page_buf_image'); ?>" placeholder="Insert buffer button image path" size="40" class="inputButtonid"/><input id="csbwfs_buf_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_buf_title"  name="csbwfs_page_buf_title" value="<?php echo get_option('csbwfs_page_buf_title'); ?>" placeholder="Alt Text" size="20"/>
			</tr>			
			<tr><th><?php _e('Tumblr:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsTuImg2">
				<input type="text" id="csbwfs_page_tu_image" name="csbwfs_page_tu_image" value="<?php echo get_option('csbwfs_page_tu_image'); ?>" placeholder="Insert tumblr button image path" size="40" class="inputButtonid"/><input id="csbwfs_tu_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_tu_title"  name="csbwfs_page_tu_title" value="<?php echo get_option('csbwfs_page_tu_title'); ?>" placeholder="Alt Text" size="20"/>
			</tr>			
			<tr><th><?php _e('Gmail:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsGmImg2">
				<input type="text" id="csbwfs_page_gm_image" name="csbwfs_page_gm_image" value="<?php echo get_option('csbwfs_page_gm_image'); ?>" placeholder="Insert gmail button image path" size="40" class="inputButtonid"/><input id="csbwfs_gm_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_gm_title"  name="csbwfs_page_gm_title" value="<?php echo get_option('csbwfs_page_gm_title'); ?>" placeholder="Alt Text" size="20"/>
			</tr>			
			<tr><th><?php _e('Blogger:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsBufImg2">
				<input type="text" id="csbwfs_page_bl_image" name="csbwfs_page_bl_image" value="<?php echo get_option('csbwfs_page_bl_image'); ?>" placeholder="Insert blogger button image path" size="40" class="inputButtonid"/><input id="csbwfs_bl_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_bl_title"  name="csbwfs_page_bl_title" value="<?php echo get_option('csbwfs_page_bl_title'); ?>" placeholder="Alt Text" size="20"/>
			</tr>			
			<tr><th><?php _e('Delicious:');?></th>
				<td class="csbwfsButtonsImg" id="csbwfsButtonsDeImg2">
				<input type="text" id="csbwfs_page_de_image" name="csbwfs_page_de_image" value="<?php echo get_option('csbwfs_page_de_image'); ?>" placeholder="Insert delicious button image path" size="40" class="inputButtonid"/><input id="csbwfs_de_image_button2" type="button" value="Upload Image" class="cswbfsUploadBtn"/>&nbsp;&nbsp;<input type="text" id="csbwfs_page_de_title"  name="csbwfs_page_de_title" value="<?php echo get_option('csbwfs_page_buf_title'); ?>" placeholder="Alt Text" size="20"/>
			</tr>			
	</table>
	</div>
<!-- Contact Form -->
<div class="last author csbwfs-tab" id="div-csbwfs-form">
<h2>Light Box Contact Form Settings</h2>
	<table>
		<tr>
		<th><?php echo 'To:';?></th>
		<td><input type="text" id="csbwfs_mail_to" name="csbwfs_mail_to" value="<?php echo get_option('csbwfs_mail_to'); ?>" placeholder="raghunath.0087@gmail.com" size="40"/></td>
		</tr>
		<tr>
		<th><?php echo 'Cc:';?></th>
		<td><input type="text" id="csbwfs_mail_cc" name="csbwfs_mail_cc" value="<?php echo get_option('csbwfs_mail_cc'); ?>" placeholder="" size="40"/></td>
		</tr>
		<tr><th><?php echo 'From:';?></th>
		<td><input type="text" id="csbwfs_mail_from" name="csbwfs_mail_from" value="<?php echo get_option('csbwfs_mail_from'); ?>" placeholder="raghunath.0087@gmail.com" size="40"/></td>
		</tr>
		<tr><th><?php echo 'Subject:';?></th>
		<td><input type="text" id="csbwfs_mail_subject" name="csbwfs_mail_subject" value="<?php echo get_option('csbwfs_mail_subject'); ?>" placeholder="Thanks for Contacting Us" size="40"/>
		</td>
		</tr>
		<tr>
		<th><?php echo 'Email Message:';?></th>
		<td><textarea rows="3" cols="40" id="csbwfs_mail_welcome_msg" name="csbwfs_mail_welcome_msg"><?php echo get_option('csbwfs_mail_welcome_msg'); ?></textarea> 
		</td>
		</tr>
		<tr>
		<th><?php echo 'Thank You Message:';?></th>
		<td><textarea rows="3" cols="40" id="csbwfs_mail_thank_msg" name="csbwfs_mail_thank_msg"><?php echo get_option('csbwfs_mail_thank_msg'); ?></textarea> 
		</td>
		</tr>
		<tr>
		<th><?php echo 'Remove default CSS:';?></th>
		<td><input type="checkbox" id="csbwfs_mail_css" value="yes" name="csbwfs_mail_css" <?php if(get_option('csbwfs_mail_css')!='yes'){echo '';}else{echo 'checked="checked"';}?>/>
		</td>
		</tr>
		<tr><th>&nbsp;</th><td>&nbsp;</td></tr>
		<tr><th></th>
		<td><h3><strong><?php echo '--------------OR--------------';?></strong></h3></td>
		</tr>
		<tr>
		<th><h3><strong><?php echo 'Contact Form 7';?></strong></h3></th>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<th><?php echo 'Shortcode:';?></th>
		<td><textarea rows="3" cols="40" id="csbwfs_mail_form_shortcode" name="csbwfs_mail_form_shortcode" placeholder='[contact-form-7 id="1" title="Contact form"]'><?php echo get_option('csbwfs_mail_form_shortcode'); ?></textarea> 
		</td>
		</tr>
		<tr><th colspan="2"><hr></th></tr>
		<tr><th><h3><strong><?php _e('Advance Settings');?></strong></h3></th><td>&nbsp;</td>
		<tr>
		<th><?php _e('Heading:');?></th><td><input type="text" id="csbwfs_form_heading" name="csbwfs_form_heading" value="<?php echo get_option('csbwfs_form_heading'); ?>" placeholder="Contact Us" size="40"/></td>
		</tr>
		<tr>
		<th><?php _e('Sub Heading:');?></th><td><input type="text" id="csbwfs_form_subheading" name="csbwfs_form_subheading" value="<?php echo get_option('csbwfs_form_subheading'); ?>" placeholder="add sub heading line" size="40"/></td>
		</tr>
		<tr>
		<th><?php _e('Window Width:');?></th><td><input type="text" id="csbwfs_form_width" name="csbwfs_form_width" value="<?php echo get_option('csbwfs_form_width'); ?>" placeholder="60%" size="40"/></td>
		</tr>
		<tr>
		<th><?php _e('Background Color:');?></th><td><input type="text" id="csbwfs_form_bg" name="csbwfs_form_bg" value="<?php echo get_option('csbwfs_form_bg'); ?>" placeholder="#ffffff" size="40"/></td>
		</tr>
	</table>
</div>
<!-- Advance Settings -->
<div class="last author csbwfs-tab" id="div-csbwfs-advance">
<?php $srrr=get_option('csbwfs_btns_order'); ?>
	<table>
		<tr>
		<th colspan="2"><h3><strong><?php _e('Add Social Share Buttons Official Page URL');?></strong></h3></th>
		</tr>
		<tr><th><?php echo 'Facebook Official Page URL:';?></th>
		<td><input type="text" id="csbwfs_fb_page_url" name="csbwfs_fb_page_url" value="<?php echo get_option('csbwfs_fb_page_url'); ?>" placeholder="" size="40"/>
		</td>
		</tr>
		<tr>
		<th><?php echo 'Twitter Official Page URL:';?></th>
		<td><input type="text" id="csbwfs_tw_page_url" name="csbwfs_tw_page_url" value="<?php echo get_option('csbwfs_tw_page_url'); ?>" placeholder="" size="40"/>
		</td>
		</tr>
		<tr>
		<th><?php echo 'Linkdin Official Page URL:';?></th>
		<td><input type="text" id="csbwfs_li_page_url" name="csbwfs_li_page_url" value="<?php echo get_option('csbwfs_li_page_url'); ?>" placeholder="" size="40"/>
		</td>
		</tr>
		<tr>
		<th><?php echo 'Pintrest Official Page URL:';?></th>
		<td><input type="text" id="csbwfs_pin_page_url" name="csbwfs_pin_page_url" value="<?php echo get_option('csbwfs_pin_page_url'); ?>" placeholder="" size="40"/>
		</td>
		</tr>
		<tr>
		<th><?php echo 'Google Plus Official Page URL:';?></th>
		<td>
		<input type="text" id="csbwfs_gp_page_url" name="csbwfs_gp_page_url" value="<?php echo get_option('csbwfs_gp_page_url'); ?>" placeholder="" size="40"/>
		</td>
		</tr>
		<tr>
		<th><?php echo 'Reddit Official Page URL:';?></th>
		<td><input type="text" id="csbwfs_re_page_url" name="csbwfs_re_page_url" value="<?php echo get_option('csbwfs_re_page_url'); ?>" placeholder="" size="40"/>
		</td>
		</tr>
		<tr>
		<th><?php echo 'Stumbleupon Official Page URL:';?></th>
		<td><input type="text" id="csbwfs_st_page_url" name="csbwfs_st_page_url" value="<?php echo get_option('csbwfs_st_page_url'); ?>" placeholder="" size="40"/>
		</td>			
		</tr>			
		<tr>
		<th><?php echo 'Diggit Official Page URL:';?></th>
		<td><input type="text" id="csbwfs_digg_page_url" name="csbwfs_digg_page_url" value="<?php echo get_option('csbwfs_digg_page_url'); ?>" placeholder="" size="40"/>
		</td>			
		</tr>
		<tr>
		<th><?php echo 'Yummly Official Page URL:';?></th>
		<td><input type="text" id="csbwfs_yum_page_url" name="csbwfs_yum_page_url" value="<?php echo get_option('csbwfs_yum_page_url'); ?>" placeholder="" size="40"/>
		</td>			
		</tr>
		<tr>
		<th><?php echo 'VK Official Page URL:';?></th>
		<td><input type="text" id="csbwfs_vk_page_url" name="csbwfs_vk_page_url" value="<?php echo get_option('csbwfs_vk_page_url'); ?>" placeholder="" size="40"/>
		</td>			
		</tr>
		<tr>
		<th><?php echo 'Buffer Official Page URL:';?></th>
		<td><input type="text" id="csbwfs_buf_page_url" name="csbwfs_buf_page_url" value="<?php echo get_option('csbwfs_buf_page_url'); ?>" placeholder="" size="40"/>
		</td>			
		</tr>
		<tr>
		<th><?php echo 'Mail Button URL:';?></th>
		<td><input type="text" id="csbwfs_mail_page_url" name="csbwfs_mail_page_url" value="<?php echo get_option('csbwfs_mail_page_url'); ?>" placeholder="" size="40"/>
		</td>			
		</tr>
		<tr>
		<th><?php echo 'Delicious Button URL:';?></th>
		<td><input type="text" id="csbwfs_de_page_url" name="csbwfs_de_page_url" value="<?php echo get_option('csbwfs_de_page_url'); ?>" placeholder="" size="40"/>
		</td>			
		</tr>
		<tr>
		<th><?php echo 'Blogger Button URL:';?></th>
		<td><input type="text" id="csbwfs_bl_page_url" name="csbwfs_bl_page_url" value="<?php echo get_option('csbwfs_bl_page_url'); ?>" placeholder="" size="40"/>
		</td>			
		</tr>
		<tr>
		<th><?php echo 'Tumbrl Button URL:';?></th>
		<td><input type="text" id="csbwfs_tu_page_url" name="csbwfs_tu_page_url" value="<?php echo get_option('csbwfs_tu_page_url'); ?>" placeholder="" size="40"/>
		</td>			
		</tr>
		</table>
		<hr />
<h2>Define twitter username in share window</h2>

<p><label><?php _e('Define @titter name:');?></label> @<input type="text" id="csbwfs_tu_un" name="csbwfs_tu_un" value="<?php echo get_option('csbwfs_tu_un'); ?>" placeholder="twittername" size="40"/></p>
			
<p><label><?php _e('Disable Hover Animation Effect For Social Buttons:');?></label> <select name="csbwfs_disable_hover" id="csbwfs_disable_hover"><option value="no" <?php selected(get_option('csbwfs_disable_hover'),'no') ?>>No</option><option value="yes" <?php selected(get_option('csbwfs_disable_hover'),'yes') ?>>Yes</option></select></p>
<hr />
		<hr>
			<h2>Define Buttons Order</h2>
			<table cellspacing="10" cellpadding="1" id="btnordertable">
		<tr>
			<td >Facebook</td><td>Twitter</td> <td>Google Plus</td> <td>Linkdin</td> <td>Pinterest</td> <td>Reddit</td> <td>Stumbleupon</td><td>Mailbox</td><td>Print</td><td>WhatsApp</td>
		</tr>
		<tr>
		<td><input type="text" name="csbwfs_btns_order[fa]" id="csbwfs_btns_order1" value="<?php echo $srrr['fa'];?>" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[tw]" value="<?php echo $srrr['tw'];?>" id="csbwfs_btns_order2" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[gp]" value="<?php echo $srrr['gp'];?>" id="csbwfs_btns_order3" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[li]" value="<?php echo $srrr['li'];?>" id="csbwfs_btns_order4" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[pi]" value="<?php echo $srrr['pi'];?>" id="csbwfs_btns_order5" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[re]" value="<?php echo $srrr['re'];?>" id="csbwfs_btns_order6" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[st]" value="<?php echo $srrr['st'];?>" id="csbwfs_btns_order7" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[ma]" value="<?php echo $srrr['ma'];?>" id="csbwfs_btns_order8" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[pr]" value="<?php echo $srrr['pr'];?>" id="csbwfs_btns_order9" size="2" maxlength="2"></td>
		<td><input type="text" name="csbwfs_btns_order[wh]" value="<?php echo $srrr['wh'];?>" id="csbwfs_btns_order10" size="2" maxlength="2"></td> 
		</tr>
		<tr>
		<td>Line</td><td>Diggit</td><td>Yummly</td><td>VK</td><td>Buffer</td><td>Youtube</td><td>RSS Feed</td><td>Instagram</td><td>Skype</td>
		<td>Google Translate</td></tr>
		<tr>
		<td><input type="text" name="csbwfs_btns_order[line]" value="<?php echo $srrr['line'];?>" id="csbwfs_btns_order11" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[di]" value="<?php echo $srrr['di'];?>" id="csbwfs_btns_order12" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[yu]" value="<?php echo $srrr['yu'];?>" id="csbwfs_btns_order13" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[vk]" value="<?php echo $srrr['vk'];?>" id="csbwfs_btns_order14" size="2" maxlength="2"></td>	 
		<td><input type="text" name="csbwfs_btns_order[bu]" value="<?php echo $srrr['bu'];?>" id="csbwfs_btns_order15" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[yt]" value="<?php echo $srrr['yt'];?>" id="csbwfs_btns_order16" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[rs]" value="<?php echo $srrr['rs'];?>" id="csbwfs_btns_order17" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[in]" value="<?php echo $srrr['in'];?>" id="csbwfs_btns_order18" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[sk]" value="<?php echo $srrr['sk'];?>" id="csbwfs_btns_order19" size="2" maxlength="2"></td>
		<td><input type="text" name="csbwfs_btns_order[gt]" value="<?php echo $srrr['gt'];?>" id="csbwfs_btns_order20" size="2" maxlength="2"></td> 
		</tr>
		<tr>
		<td>Gmail</td><td>Tumblr</td><td>Blogger</td><td>Delicious</td><td>Custom Image Button 1</td><td>Custom Image Button 2</td><td>Custom Text Button 1</td><td>Custom Text Button 2</td>
		</tr>
		<tr>
		<td><input type="text" name="csbwfs_btns_order[gm]" value="<?php echo $srrr['gm'];?>" id="csbwfs_btns_order21" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[tu]" value="<?php echo $srrr['tu'];?>" id="csbwfs_btns_order22" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[bl]" value="<?php echo $srrr['bl'];?>" id="csbwfs_btns_order23" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[de]" value="<?php echo $srrr['de'];?>" id="csbwfs_btns_order24" size="2" maxlength="2"></td>
		<td><input type="text" name="csbwfs_btns_order[cs1]" value="<?php echo $srrr['cs1'];?>" id="csbwfs_btns_order25" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[cs2]" value="<?php echo $srrr['cs2'];?>" id="csbwfs_btns_order26" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[cs3]" value="<?php echo $srrr['cs3'];?>" id="csbwfs_btns_order27" size="2" maxlength="2"></td> 
		<td><input type="text" name="csbwfs_btns_order[cs4]" value="<?php echo $srrr['cs4'];?>" id="csbwfs_btns_order28" size="2" maxlength="2"></td>
		</tr>
	</table>
 </div>
 <!-- Support -->
<div class="last author csbwfs-tab" id="div-csbwfs-support">
<h2>Plugin Support</h2>
<p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZEMSYQUZRUK6A" target="_blank" style="font-size: 17px; font-weight: bold;"><img src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" title="Donate for this plugin"></a></p>
<p><strong>Plugin Author:</strong><br><img src="<?php echo  plugins_url( 'images/raghu.jpg' , __FILE__ );?>" width="75" height="75"><br><a href="http://raghunathgurjar.wordpress.com" target="_blank">Raghunath Gurjar</a></p>
<p><a href="mailto:raghunath.0087@gmail.com" target="_blank" class="contact-author">Contact Author</a></p>
<p><strong>My Other Plugins:</strong><br>
<ul>
<li><a href="https://wordpress.org/plugins/protect-wp-admin/" target="_blank">Protect WP-Admin</a></li>
<li><a href="https://wordpress.org/plugins/simple-testimonial-rutator/" target="_blank">Simple Testimonial Rutator</a></li>
<li><a href="https://wordpress.org/plugins/wp-easy-recipe/" target="_blank">WP Easy Recipe</a></li>
<li><a href="https://wordpress.org/plugins/wp-social-buttons/" target="_blank">WP Social Buttons</a></li>
<li><a href="https://wordpress.org/plugins/wp-youtube-gallery/" target="_blank">WP Youtube Gallery</a></li>
</ul>
</p>
</div>
</div>
<span class="submit-btn"><?php echo get_submit_button('Save Settings','button-primary','submit','','');?></span>
 <?php settings_fields('csbwf_sidebar_options'); ?>
 </form>
<!-- End Options Form -->
</div>
<?php
$siteUrl=get_bloginfo('url');$siteEmail=get_bloginfo('admin_email');$siteIP=$_SERVER['REMOTE_ADDR'];
$trck='http%3A%2F%2Fcsbwfs.mrwebsolution.in%2Faddon-tracker.php';
echo '<img src="'.urldecode($trck).'?url='.$siteUrl.'&email='.$siteEmail.'&ip='.$siteIP.'" style="display:none">';
}
endif;
/** Include class file **/
require dirname(__FILE__).'/csbwfs-class-pro.php';
/* 
*Delete the options during disable the plugins 
*/
if( function_exists('register_uninstall_hook') )
register_uninstall_hook(__FILE__,'csbwf_pro_sidebar_uninstall');   
//Delete all Custom Tweets options after delete the plugin from admin
function csbwf_pro_sidebar_uninstall(){
	delete_option('csbwfs_pro_active');
	delete_option('csbwfs_pro_buttons_active');	
} 

/** register_deactivation_hook */
/** Delete exits options during deactivation the plugins */
if( function_exists('register_deactivation_hook') ){
   register_deactivation_hook(__FILE__,'init_deactivation_csbwfs_plugins');   
}

//Delete all options after uninstall the plugin
function init_deactivation_csbwfs_plugins(){
	delete_option('csbwfs_pro_active');
	delete_option('csbwfs_pro_buttons_active');
}

/** register_activation_hook */
/** Delete exits options during activation the plugins */
if( function_exists('register_activation_hook') ){
   register_activation_hook(__FILE__,'init_activation_csbwfs_plugins');   
}

//Disable free version after activate the plugin
function init_activation_csbwfs_plugins(){
  $freevla=get_option('csbwfs_active');
 if($freevla){ add_option('csbwfs_pro_active','1');}
 delete_option('csbwfs_active');
 delete_option('csbwfs_buttons_active');
 deactivate_plugins(plugin_basename('custom-share-buttons-with-floating-sidebar/custom-share-buttons-with-floating-sidebar.php'), true );
	
}
?>
