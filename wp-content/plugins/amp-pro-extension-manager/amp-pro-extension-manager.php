<?php
/**
* Plugin Name: AMP Pro Extension Manager
* Plugin URI: https://ampforwp.com/
* Description: This is AMP Extension Manger Plugin.
* Version: 1.10.19
* Author: AMPforWP Team
* Author URI: https://ampforwp.com/
**/
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) && !function_exists('ampforwp_generate_endpoint')) exit;
define('AMPFORWPPRO_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('AMPFORWPPRO_PLUGIN_DIR_URI', plugin_dir_url(__FILE__));
define('AMPFORWPPRO_IMAGE_DIR',plugin_dir_url(__FILE__).'img');
define('AMPFORWPPRO_ITEM_NAME', 'AMP Pro Extension Manager');
define('AMPFORWPPRO_VERSION','1.10.19');
define( 'AMPFORWPPRO_ITEM_FOLDER_NAME',basename(__DIR__));
class AMPExtensionManager{
    var $store_url = 'https://accounts.ampforwp.com';
    var $license = '';
    var $download_id = '';
    var $plugin_active_path = '';
    var $message = '';
    var $license_info = '';
    var $product_name = '';
    var $all_extension_list = array();
    var $all_plugin_list = array();
    var $plugin_count = 0;
    public function __construct() {
        add_action( 'init', array($this, 'ampforwppro_init') );
        add_action( 'plugins_loaded', array($this, 'ampforwpp_plugin_loaded') );
        add_filter('http_request_args', function ($args, $url) {
            $args['sslverify'] = false;
            return $args;
        }, 10, 2);
    }
    public function ampforwppro_init(){
        if(is_admin()){
            add_action( 'admin_menu', array($this, 'ampforwppro_admin_menu') );
            add_action( 'admin_enqueue_scripts',  array($this, 'ampfrowppro_scripts') );
            add_action( 'wp_ajax_nopriv_ampforwppro_validate_licence', array( $this, 'ampforwppro_activate_licence' ) );
            add_action( 'wp_ajax_ampforwppro_validate_licence', array( $this, 'ampforwppro_activate_licence' ) );
            add_action( 'wp_ajax_nopriv_ampforwppro_activate_licence', array( $this, 'ampforwppro_activate_child_licence' ) );
            add_action( 'wp_ajax_ampforwppro_activate_licence', array( $this, 'ampforwppro_activate_child_licence' ) );

            add_action( 'wp_ajax_nopriv_ampforwppro_remove_licence', array( $this, 'ampforwppro_remove_licence' ) );
            add_action( 'wp_ajax_ampforwppro_remove_licence', array( $this, 'ampforwppro_remove_licence' ) );

            add_action( 'wp_ajax_nopriv_afwpp_refresh_bundle', array( $this, 'ampforwppro_refresh_bundle' ) );
            add_action( 'wp_ajax_afwpp_refresh_bundle', array( $this, 'ampforwppro_refresh_bundle' ) );
            add_action( 'wp_ajax_nopriv_afwpp_run_once', array( $this, 'ampforwppro_run_once' ) );
            add_action( 'wp_ajax_afwpp_run_once', array( $this, 'ampforwppro_run_once' ) );
            add_action( 'wp_ajax_nopriv_afwpp_run_oncef7', array( $this, 'ampforwppro_run_oncef7' ) );
            add_action( 'wp_ajax_afwpp_run_oncef7', array( $this, 'ampforwppro_run_oncef7' ) );
            add_filter( 'plugin_action_links', array( $this, 'ampforwppro_plugin_settings_link' ), 12, 2 );
            add_filter( "views_plugins", array( $this, 'amforwppro_plugin_heading' ) );
            add_action('wp_ajax_amp_pro_ext_mger_accept_data', array( $this, 'amp_pro_ext_mger_accept_data' ));
            add_action('wp_ajax_nopriv_amp_pro_ext_mger_accept_data', array( $this, 'amp_pro_ext_mger_accept_data' ));            
            add_action('admin_init', array( $this, 'ampforwp_amp_pro_notice_dismiss' ));
            global $pagenow;
            if (  $pagenow == 'plugins.php'  ){
            add_action('admin_notices', array( $this, 'ampforwp_ampproextmgr_admin_notice' ));
            }            
            add_action('current_screen', array( $this, 'ampforwppro_load_plugin_list'));

            if(defined('EOS_DP_VERSION')){
                add_filter( 'pre_update_site_option_active_plugins', array( $this, 'amp_eos_dp_return_pro_ext' ), 11 );
                add_filter( 'pre_update_option_active_plugins', array( $this, 'amp_eos_dp_return_pro_ext' ), 11 );
            }

            $this->ampforwppro_plugin_updater();
        }
    }
    public function ampforwppro_reset_transient(){
        delete_transient('ampforwp_extensions_list_trans');
    }
    public function ampforwpp_plugin_loaded(){
        add_filter( 'ampforwp_extension_lists_filter', array( $this, 'ampforwppro_get_all_extensions_list' ), 20, 1 );
    }
    public function ampforwppro_plugin_settings_link( $actions, $plugin_file ) {
            $plugin = plugin_basename(__FILE__);
            if ( $plugin === $plugin_file ) {
                $amp_activate = '';
                $settings = array( 'settings' => '<a href="admin.php?page=amp-extension-manager">Settings</a>');
                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                $actions = array_merge( $actions, $settings );
            }
        return $actions;
    }
    public function ampfrowppro_scripts($hook){
        if($hook=='amp_page_amp-extension-manager' || ( function_exists('amp_activate') && $hook=='admin_page_amp-extension-manager') || $hook == 'AMP_page_amp-extension-manager' || $hook == 'admin_page_amp-extension-manager'){
            wp_register_style( 'ampforwppro_css', untrailingslashit(AMPFORWPPRO_PLUGIN_DIR_URI) . '/css/style.css', false, AMPFORWPPRO_VERSION );
            wp_enqueue_style( 'ampforwppro_css' );
            wp_register_script( 'ampforwppro_script',  untrailingslashit(AMPFORWPPRO_PLUGIN_DIR_URI) .'/js/script.js', array(), AMPFORWPPRO_VERSION, true );
            wp_enqueue_script( 'ampforwppro_script' );
        }
        if(isset($_GET["page"]) && !empty($_GET)){
        if($_GET['page'] == 'amp_options' ){
            wp_register_style( 'ampforwppro_panel_css', untrailingslashit(AMPFORWPPRO_PLUGIN_DIR_URI) . '/css/panel_style.css', false, AMPFORWPPRO_VERSION );
            wp_enqueue_style( 'ampforwppro_panel_css' );

        }
    }
    }
    public function ampforwppro_admin_menu(){
        $license_alert = $days = '';
        $get_license_info = get_option( 'ampforwppro_license_info');
        if($get_license_info){
            $ampforwp_pro_expires = date('Y-m-d', strtotime($get_license_info->expires));
            $license_info_lifetime = $get_license_info->expires;
            $today = date('Y-m-d');
            $exp_date = $ampforwp_pro_expires;
            $date1 = date_create($today);
            $date2 = date_create($exp_date);
            $diff = date_diff($date1,$date2);
            $days = $diff->format("%a");
            if( $license_info_lifetime == 'lifetime' ){
                $days = 'Lifetime';
            }elseif($today > $exp_date){
              $days = -$days;
            }
            $license_alert = $days<=7 && $days!=='Lifetime' ? "<span class='ampforwp_pro_icon dashicons dashicons-warning ampforwp_pro_alert'></span>": "" ;
        }
      $page_title = 'AMP Extension Manager';
      $menu_title = 'Extension Manager'.$license_alert.'';
      $capability = 'manage_options';
      $menu_slug  = 'amp-extension-manager';
      $function   = array($this,'ampforwppro_settings_page');
      $position   = 4;
      add_submenu_page('amp_options', $page_title, $menu_title, $capability, $menu_slug,$function );
    }
    public function ampforwppro_settings_page(){
       
            $plugin_list = get_plugins();            
            foreach ($plugin_list as $key => $value) {
               $author_url = $value['AuthorURI'];
                if(strpos($author_url, 'ampforwp')!==false || strpos($author_url, 'magazine3.in')!==false){
                   $is_active = is_plugin_active($key);
                   $p_key = strtolower(str_replace(' ', '-', $value['Title']));
                   if($p_key=="amp-pop-up"){
                        $p_key = "amp-popup";
                   }else if($p_key=="the-events-calendar-for-amp"){
                        $p_key = "the-event-calender-for-amp";
                   }else if($p_key=="amp-woocommerce-pro"){
                        $p_key = "woocommerce"; 
                   }else if($p_key=="amp-shortcodes-ultimate"){
                        $p_key = "shortcodes-ultimate";
                   }else if($p_key=="amp-opt-in-forms"){
                        $p_key = "opt-in-forms-for-amp";
                   }else if($p_key=="newspaper-amp-theme"){
                        $p_key = "newspaper-theme-for-amp";
                   }else if($p_key=="amp-gravity-forms"){
                        $p_key = "gravity-forms";
                   }else if($p_key=="amp-custom-post-type"){
                        $p_key = "custom-post-type-support-for-amp";
                   }else if($p_key=="amp-cta"){
                        $p_key = "call-to-action-for-amp";
                   }
                   $this->all_plugin_list[$p_key]['name'] = $value['Title'];
                   $this->all_plugin_list[$p_key]['description'] = $value['Description'];
                   $this->all_plugin_list[$p_key]['version'] = $value['Version'];
                   $this->all_plugin_list[$p_key]['plugin_path'] = $key;
                   $this->all_plugin_list[$p_key]['is_active'] = ($is_active)?1:0;
                   $this->all_plugin_list[$p_key]['all_data'] = $value;
                }
        }        
        if(!defined('AMPFORWP_PLUGIN_DIR') && function_exists('amp_activate')){  
            require_once dirname( __FILE__ ).'/amp-by-google-extension-settings.php';
        }else{
            require_once dirname( __FILE__ ).'/amp-extension-manager-settings.php';
        }
    }
    public function ampforwppro_activate_licence(){
        if ( ! isset( $_POST['verify_nonce'] ) || ! wp_verify_nonce( $_POST['verify_nonce'], 'ampforwppro_nonce' )) {
            $res['success'] = 2;
            $res['message'] = 'Sorry, your nonce did not verify.';
            echo json_encode($res);
        } else {
            if(isset($_POST['license']) && $_POST['license']!=""){
                $license_k = sanitize_text_field($_POST['license']);
                $this->ampforwppro_activate_bundle_license($license_k);
            }else{
                $res['success'] = 2;
                $res['message'] = "Please enter a valid license key";
                echo json_encode($res);
                exit;
            }
        }
    }
    public function ampforwppro_activate_bundle_license($license_k){
        if ( ! isset( $_POST['verify_nonce'] ) || ! wp_verify_nonce( $_POST['verify_nonce'], 'ampforwppro_nonce' )) {
            $res['success'] = 2;
            $res['message'] = 'Sorry, your nonce did not verify.';
            echo json_encode($res);
        }else{
            $item_name = "Membership Bundle";
            $api_params = array(
                'edd_action' => 'activate_license',
                'license'    => $license_k,
                'item_name'  => urlencode( $item_name ), // the name of our product in EDD
                'url'        => home_url(),
                'referer'    => 'extension_manager',
                'activation_type'    => 'bundle',
            );
            $response = wp_remote_post( $this->store_url, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
            if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
                if(!empty($response->get_error_message())){
                    $error_message = strtolower($response->get_error_message());
                    $error_pos = strpos($error_message, 'operation timed out');
                    if($error_pos !== false){
                        $res['success'] = 2;
                        $res['message'] = esc_html__('Request timed out, please try again', 'accelerated-mobile-pages');
                        echo json_encode($res);
                        exit;
                    }else{
                        $res['success'] = 2;
                        $res['message'] = esc_html($response->get_error_message());
                        echo json_encode($res);
                        exit;
                    }
                }
            }
            $response = wp_remote_retrieve_body( $response );
            $license_data = json_decode( $response );
            if (!$license_data->success ) {
                switch( $license_data->error ) {
                    case 'expired' :
                        $this->message = sprintf(
                            esc_html__( 'Your license key expired on %s.', 'accelerated-mobile-pages' ),
                            date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
                        );
                        update_option('ampforwppro_license_info',$license_data);
                        break;

                    case 'revoked' :

                        $this->message = esc_html__( 'Your license key has been disabled.', 'accelerated-mobile-pages' );
                        break;

                    case 'missing' :
                        $this->message = esc_html__( 'Invalid license or missing', 'accelerated-mobile-pages' );
                        break;

                    case 'invalid' :
                        $this->message = sprintf( 
                            esc_html__( ' This appears to be an invalid license key for %s.', 'accelerated-mobile-pages' ),
                            $item_name
                        );                                        
                        break;

                    case 'site_inactive' :

                        $this->message = esc_html__( 'Your license is not active for this URL.', 'accelerated-mobile-pages' );
                        break;

                    case 'item_name_mismatch' :

                        $this->message = sprintf( 
                            esc_html__( 'This appears to be an item name mismatch for %s.', 'accelerated-mobile-pages' ),
                            $item_name
                        );
                        break;

                    case 'no_activations_left':

                        $this->message = esc_html__( 'Your license key has reached its activation limit.', 'accelerated-mobile-pages' );
                        break;

                    default :

                        $this->message = esc_html__( 'An error occurred, please try again.', 'accelerated-mobile-pages' );
                        $res['other'] = $response;
                        break;
                }
                if ($license_data->error == 'expired' ) {
                $res['success'] = 3;
                }
                else{
                    $res['success'] = 2;
                }
                $res['message'] = $this->message;
                echo json_encode($res);
                exit;
            }else{                
                $license_data->license_key = $license_k;                
                update_option('ampforwppro_license_info',$license_data);
                global $all_extensions_data;
                $renew = "no";
                $license_exp = "";
                $license_info = $license_data;                
                $t = date('Y-m-d', strtotime($license_info->expires));
                $today = date('Y-m-d');
                $exp_date =$t;
                $date1 = date_create($today);
                $date2 = date_create($exp_date);
                $diff = date_diff($date1,$date2);
                $days = $diff->format("%a");
                $t = $license_info->expires;
                $res['success'] = 1;
                $res['message'] = "Activated";
                $res['license_exp__'] = $days;
                echo json_encode($res);
                 exit;
            } 

        }
    }
    public function ampforwppro_activate_child_licence(){
        if ( ! isset( $_POST['verify_nonce'] ) || ! wp_verify_nonce( $_POST['verify_nonce'], 'ampforwppro_nonce' )) {
           $res['success'] = 2;
           $res['message'] = 'Sorry, your nonce did not verify.';
           echo json_encode($res);
           exit;
        } else {
            $this->ampforwppro_reset_transient();
            $is_active = $_POST['is_active'];
            $key = $_POST['id'];
            $c_status = $_POST['c_status'];
            if($is_active=="" || $is_active=="0"){
                $this->license_info = get_option( 'ampforwppro_license_info');
                $response = $this->license_info->afwpp_response;
                $this->product_name = $response[$key]->post_title;
                $this->license = $response[$key]->license_key;
                $this->download_id = $response[$key]->download_id;
                $edd_action = 'activate_license';
                if($c_status=="Deactivate" || $c_status=="Revoke"){
                    $edd_action = 'deactivate_license';
                }
                $api_params = array(
                    'edd_action' => $edd_action,
                    'license'    => $this->license,
                    'item_name'  => urlencode( $this->product_name ), // the name of our product in EDD
                    'referer'    => 'extension_manager',
                    'activation_type'    => 'individual',
                );
                $response = wp_remote_post( $this->store_url, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
                if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
                    if(!empty($response->get_error_message())){
                        $error_message = strtolower($response->get_error_message());
                        $error_pos = strpos($error_message, 'operation timed out');
                        if($error_pos !== false){
                            $res['success'] = 2;
                            $res['message'] = esc_html__('Request timed out, please try again', 'accelerated-mobile-pages');
                            echo json_encode($res);
                            exit;
                        }else{
                            $res['success'] = 2;
                            $res['message'] = esc_html($response->get_error_message());
                            echo json_encode($res);
                            exit;
                        }
                    }
                }
                $response = wp_remote_retrieve_body( $response );
                $license_data = json_decode( $response );
                if (!$license_data->success ) {
                    switch( $license_data->error ) {
                        case 'expired' :
                            $this->message = sprintf(
                                esc_html__( 'Your license key expired on %s.', 'accelerated-mobile-pages' ),
                                date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
                            );
                            break;

                        case 'revoked' :

                            $this->message = esc_html__( 'Your license key has been disabled.', 'accelerated-mobile-pages' );
                            break;

                        case 'missing' :
                            $this->message = esc_html__( 'Invalid license or missing', 'accelerated-mobile-pages' );
                            break;

                        case 'invalid' :
                          $this->message = sprintf( 
                                esc_html__( 'This appears to be an invalid license key for %s.', 'accelerated-mobile-pages' ),
                                $this->product_name
                            );
                            break;

                        case 'site_inactive' :

                            $this->message = esc_html__( 'Your license is not active for this URL.', 'accelerated-mobile-pages' );
                            break;

                        case 'item_name_mismatch' :

                            $this->message = sprintf( 
                                esc_html__( 'This appears to be an invalid item name for %s.', 'accelerated-mobile-pages' ),
                                $this->product_name
                            );
                            break;

                        case 'no_activations_left':

                            $this->message = esc_html__( 'Your license key has reached its activation limit.', 'accelerated-mobile-pages' );
                            break;

                        default :
                            $this->message = esc_html__( 'An error occurred, please try again.', 'accelerated-mobile-pages' );
                            break;
                    }
                    $res['success'] = 2;
                    $res['message'] = $this->message;
                    echo json_encode($res);
                    exit;
                }else{
                    if(isset($license_data->afwpp_response[0])){
                        $this->license_info->afwpp_response[$key]->status = $license_data->afwpp_response[0]->status;
                    }
                    if($c_status=="Activate" || $c_status=="Activate Plugin" || $c_status=="Activate License"){
                        $this->ampforwppro_process_plugin_activation($this->license_info,$key);
                    }else if($c_status=="Deactivate" || $c_status=="Revoke"){
                        $this->ampforwppro_process_plugin_deactivation($this->license_info,$key);
                    }
                }
            }else{
                $plugin_path = $_POST['plugin_path'];
                if($is_active==0){
                    activate_plugin($plugin_path);
                    $res['success'] = 1;
                    $res['message'] = "Successful";
                    echo json_encode($res);
                }else{
                    deactivate_plugins($plugin_path);
                    $res['success'] = 1;
                    $res['message'] = "Successful";
                    echo json_encode($res);
                }
            }
        }
    }

    public function ampforwp_get_extension_info($name){
       global $all_extensions_data;
       if(!defined('AMPFORWP_PLUGIN_DIR') && function_exists('amp_activate')){
        $all_extensions_data = $this->ampforwppro_amp_extension_array_lists();
       }
       if( is_array($all_extensions_data) ){
        foreach ($all_extensions_data as $key => $value) {
                  if(strtolower($name)==strtolower($value['item_name'])){
                       return $value;
                  }
              }
          }
    }   

    public function ampforwppro_process_plugin_activation($license_data,$key){
        $activation_reps = $license_data->afwpp_response;
        $this->license_info->afwpp_response = $activation_reps;
        $request = $this->ampforwppro_get_the_version_info();
        if(isset($request->download_link)){
            $url  = $request->download_link;
            $slug = $request->slug;
            $name = $request->name;
            $download   = download_url($url,300,false);
            $plugin_dir  = plugin_dir_path( __FILE__ );
            $plugin_path = str_replace('amp-pro-extension-manager/','',$plugin_dir);
            $permfile   = $plugin_path.$slug.'.zip';
            $upload_to  = $plugin_path;
            copy( $download, $permfile );
            unlink( $download );
            if(!defined('AMPFORWP_PLUGIN_DIR') && function_exists('amp_activate')){
                global $wp_filesystem;
                if ( empty( $wp_filesystem ) ) {
                    require_once ABSPATH . '/wp-admin/includes/file.php';
                    if(function_exists('WP_Filesystem')){
                      WP_Filesystem();
                    }
                }
            }
            unzip_file($permfile, $upload_to );
            unlink( $permfile );
            if(isset($_POST['plugin_path']) && $_POST['plugin_path']!=""){
                $plugin_path = $_POST['plugin_path'];
            }else{                
                $ext_info  = $this->ampforwp_get_extension_info($name);
                $plugin_path = $ext_info['plugin_active_path'];
            }
            $this->plugin_active_path = $plugin_path;
            if(!defined('AMPFORWP_PLUGIN_DIR') && function_exists('amp_activate')){
                
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

             $cache_plugins = wp_cache_get( 'plugins', 'plugins' );
                if ( !empty( $cache_plugins ) ) {
                    $new_plugin = array(
                        'Name' => $name,
                        'PluginURI' => '',
                        'Version' => $request->stable_version,
                        'Description' => '',
                        'Author' => 'Ahmed Kaludi, Mohammed Kaludi,ampforwp',
                        'AuthorURI' => 'https://ampforwp.com/',
                        'TextDomain' => '',
                        'DomainPath' => '',
                        'Network' => '',
                        'Title' => $name,
                        'AuthorName' => 'Ahmed Kaludi, Mohammed Kaludi,ampforwp',
                    );
                    $cache_plugins[''][$plugin_path] = $new_plugin;
                    wp_cache_set( 'plugins', $cache_plugins, 'plugins' );
                }
            }
            activate_plugin($plugin_path);
            $this->license_info->afwpp_response[$key]->slug = $slug;
            update_option('ampforwppro_license_info',$this->license_info);
            $this->ampforwppro_redux_update($license_data,$slug,"activate");
            $res['success'] = 1;
            $res['message'] = "Successful";
            echo json_encode($res);
            exit;
        }else{
            $res['success'] = 2;
            $res['message'] = $request->msg;
            echo json_encode($res);
            exit;
        }
    }
    public function ampforwppro_process_plugin_deactivation($license_data,$key){
        $this->ampforwppro_reset_transient();
        $activation_reps = $license_data->afwpp_response;
        $this->license_info->afwpp_response = $activation_reps;
         $request = $this->ampforwppro_get_the_version_info();
        if(isset($request->download_link)){
            $url  = $request->download_link;
            $slug = $request->slug;
            $name = $request->name;
            $this->license_info->afwpp_response[$key]->slug = $slug;
            update_option('ampforwppro_license_info',$this->license_info);
            if(isset($_POST['plugin_path']) && $_POST['plugin_path']!=""){
                $plugin_path = $_POST['plugin_path'];
            }else{
                $ext_info  = $this->ampforwp_get_extension_info($name);
                $plugin_path = $ext_info['plugin_active_path'];
            }
            $this->plugin_active_path = $plugin_path;
            deactivate_plugins($plugin_path);
            $this->ampforwppro_redux_update($license_data,$slug,"deactivate");
            $res['success'] = 1;
            $res['message'] = "Successful";
            echo json_encode($res);
            exit;
        }else{
            $res['success'] = 2;
            $res['message'] = $request->msg;
            echo json_encode($res);
            exit;
        }
    }
    public function ampforwppro_get_the_version_info(){
        $api_params = array(
          'edd_action' => 'get_version',
          'license'    => $this->license,
          'item_name'  => $this->product_name,
          'referer'    => 'extension_manager',
        );
        $request    = wp_remote_post( $this->store_url, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
        $response = wp_remote_retrieve_body( $request );
        $version_info = json_decode( $response);
        return $version_info;
    }
    public function ampforwppro_redux_update($license_data,$slug,$type){
        $selectedOption = get_option('redux_builder_amp',array());
        $active_path = explode("/", $this->plugin_active_path);
        $slug = $active_path[0];
        if(isset($selectedOption['amp-license'][$slug]['license']) || !isset($selectedOption['amp-license'][$slug]['license']) && $type=="activate"){
            $selectedOption['amp-license'][$slug]['license']   = $this->license;
            $selectedOption['amp-license'][$slug]['item_name'] = $license_data->item_name;
            $selectedOption['amp-license'][$slug]['store_url'] = $this->store_url;
            $selectedOption['amp-license'][$slug]['plugin_active_path'] = $this->plugin_active_path;
            $selectedOption['amp-license'][$slug]['limit'] =   $license_data->license_limit;
            $selectedOption['amp-license'][$slug]['all_data']['success'] =  $license_data->success;
            $selectedOption['amp-license'][$slug]['all_data']['license'] =  $license_data->license;
            $selectedOption['amp-license'][$slug]['all_data']['item_name'] =  $license_data->item_name;
            $selectedOption['amp-license'][$slug]['all_data']['expires'] =   $license_data->expires;
            $selectedOption['amp-license'][$slug]['all_data']['customer_name'] =   $license_data->customer_name;
            $selectedOption['amp-license'][$slug]['all_data']['customer_email'] =  $license_data->customer_email;
            $selectedOption['amp-license'][$slug]['status']  =  $license_data->license;
            $selectedOption['amp-license'][$slug]['message'] =  $this->message;
            update_option( 'redux_builder_amp', $selectedOption );
        }else if($type=="deactivate"){
            $selectedOption['amp-license'][$slug]['license']   = '';
            $selectedOption['amp-license'][$slug]['item_name'] = $license_data->item_name;
            $selectedOption['amp-license'][$slug]['store_url'] = $this->store_url;
            $selectedOption['amp-license'][$slug]['plugin_active_path'] = $this->plugin_active_path;
            $selectedOption['amp-license'][$slug]['limit'] =   '';
            $selectedOption['amp-license'][$slug]['all_data']['success'] =  '';
            $selectedOption['amp-license'][$slug]['all_data']['license'] = '';
            $selectedOption['amp-license'][$slug]['all_data']['item_name'] =  '';
            $selectedOption['amp-license'][$slug]['all_data']['expires'] =   '';
            $selectedOption['amp-license'][$slug]['all_data']['customer_name'] =   '';
            $selectedOption['amp-license'][$slug]['all_data']['customer_email'] =  '';
            $selectedOption['amp-license'][$slug]['status']  =  '';
            $selectedOption['amp-license'][$slug]['message'] =  '';
            update_option( 'redux_builder_amp', $selectedOption );
        }
    }
    public function amforwppro_get_plugin_prefix($name,$slug){
        $ind = strtolower($slug);
        $plugin_path = $slug."/".$slug.".php";
        if(isset($this->all_extension_list[$ind])){
            $plugin_path = $this->all_extension_list[$ind]['plugin_active_path'];
        }
        return $plugin_path;
    }
    public function ampforwppro_get_menu_link($name){
        global $menu, $submenu;
        if($name=='Purge AMP CDN Cache'){
            $name = 'amp purge';
        }
        $pn = strtolower($name);

        $has_settings_link = array(
                                    'amp ratings'=>'amp rating',
                                    'amp cta'=>'call to action for amp',
                                    'amp acf'=>'acf for amp',
                                    'amp facebook chat'=>'facebook chat for amp',
                                    'amp cf7'=>'contact form 7 for amp'
                                );
        $m_link = '';
        $amp_ext_menu_link = $submenu['amp_options'];

        foreach ($amp_ext_menu_link as $key => $value) {
            $pli = strtolower($amp_ext_menu_link[$key][0]);
            if($pli==$pn){
                return 'admin.php?page='.$amp_ext_menu_link[$key][2];
            }else if(isset($has_settings_link[$pli]) && $has_settings_link[$pli]==$pn){
                return 'admin.php?page='.$amp_ext_menu_link[$key][2];
            }
        }
        if($m_link == ''){
            foreach ($menu as $key => $value) {
                $pli = strtolower($menu[$key][0]);
                if($pli==$pn){
                    return $menu[$key][2];
                }else if(isset($has_settings_link[$pli]) && $has_settings_link[$pli]==$pn){
                    return $menu[$key][2];
                }
            }
        }
        if($name=="AMP Pagebuilder Compatibility"){
            $m_link = 'admin.php?page=amp_options&tabid=amp-content-builder';
        }
        if($name=="Subdomain Endpoints for AMP"){
            $m_link = 'admin.php?page=amp_options&tabid=amp-subdomain-subsection';
        }
        return $m_link;
    }
    public function ampforwppro_get_all_extensions_list($extension_list){
        $m_link = '#';
        foreach ($extension_list as $key => $value) {
            $ind = strtolower(str_replace(' ', '-', $value['item_name']));
            $plugin_path = $value['plugin_active_path'];
            $plugin_path = $value['plugin_active_path'];
            $this->all_extension_list[$ind]['plugin_active_path'] =$value['plugin_active_path'];
            $this->all_extension_list[$ind]['is_activated'] = $value['is_activated'];
            $m_link = '';
            if(isset($value['settingUrl'])){
                if(!preg_match('/{(.*)}/', $value['settingUrl'])){
                    $m_link = $value['settingUrl'];
                }
            }
            $this->all_extension_list[$ind]['plugin_active_url'] = $m_link;
        }
        return $extension_list;
    }
    public function ampforwppro_get_plugin_update( $file, $plugin_data ) {
        $current = get_site_transient( 'update_plugins' );
        if ( ! isset( $current->response[ $file ] ) ) {
            return false;
        }
        $response = $current->response[ $file ];
        $plugins_allowedtags = array(
            'a'       => array(
                'href'  => array(),
                'title' => array(),
            ),
            'abbr'    => array( 'title' => array() ),
            'acronym' => array( 'title' => array() ),
            'code'    => array(),
            'em'      => array(),
            'strong'  => array(),
        );

        $plugin_name = wp_kses( $plugin_data['Name'], $plugins_allowedtags );
        $details_url = self_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $response->slug . '&section=changelog&TB_iframe=true&width=600&height=800' );
        $update_info = '';
        if(!empty($response->download_link)){
            $update_info = '<a href="'.esc_url( $details_url ).'" title="Update Plugin" class="afwpp-link" target="_self"> <i class="dashicons dashicons-update-alt ext-update"></i> <span class="ext-update">Update</span></a>';
        }
        if ( is_network_admin() || ! is_multisite() ) {
            if ( is_network_admin() ) {
                $active_class = is_plugin_active_for_network( $file ) ? ' active' : '';
            } else {
                $active_class = is_plugin_active( $file ) ? ' active' : '';
            }

            $requires_php   = isset( $response->requires_php ) ? $response->requires_php : null;
            $compatible_php = is_php_version_compatible( $requires_php );
            $notice_type    = $compatible_php ? 'notice-warning' : 'notice-error';

            if ( ! current_user_can( 'update_plugins' ) ) {
                $update_info = '<a href="'.esc_url( $details_url ).'" title="Update Plugin" class="afwpp-link" target="_self"> <i class="dashicons dashicons-update-alt ext-update"></i> <span class="ext-update">Update</span></a>';
           
            } else {
                if ( $compatible_php ) {
                    $update_info = '<a  target="_self" href="'.wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin=' ) . $file, 'upgrade-plugin_' . $file ).'" title="Update Plugin" class="afwpp-link"> <i class="dashicons dashicons-update-alt ext-update"></i> <span class="ext-update">Update</span></a>';
                
                } else {
                    $update_info = '<a href="'.esc_url( $details_url ).'" title="Update Plugin" class="afwpp-link" target="_self"> <i class="dashicons dashicons-update-alt ext-update"></i> <span class="ext-update">Update</span></a>';
                
                }
            }
        }
        return $update_info;
    }
    public function ampforwppro_get_documentation($name){
             $docs = array(
            'AAWP for AMP' => 'https://ampforwp.com/tutorials/article/how-to-integrate-aawp-for-amp/',
            'ACF for AMP' => 'https://ampforwp.com/tutorials/article-categories/acf-for-amp/',
            'Advanced AMP Ads' => 'https://ampforwp.com/tutorials/article-categories/advanced-amp-ads/',
            'AMP Cache' => 'https://ampforwp.com/tutorials/article-categories/amp-cache/',
            'AMP Comments' => 'https://ampforwp.com/tutorials/article-categories/comments/',
            'AMP Layouts' => 'https://ampforwp.com/tutorials/article-categories/amp-layouts/',
            'AMP Pagebuilder Compatibility'=>'https://ampforwp.com/tutorials/article-categories/amp-pagebuilder-compatibility/',
            'AMP Popup'=>'https://ampforwp.com/tutorials/article-categories/amp-popup-extension/',
            'AMP Rating' => 'https://ampforwp.com/tutorials/article-categories/ratings/',
            'AMP Stories' => 'https://ampforwp.com/tutorials/article-categories/amp-story/',
            'AMP Teaser'=>  'https://ampforwp.com/tutorials/article-categories/amp-teaser/',
            'bbPress for AMP'=> 'https://ampforwp.com/tutorials/article-categories/bbpress-for-amp/',
            'Call To Action for AMP'=> 'https://ampforwp.com/tutorials/article-categories/amp-cta-extension/',
            'Conversion Goals Tracking for AMP'=> 'https://ampforwp.com/tutorials/article-categories/conversion-goals-tracking-for-amp/',
            'Classipress for AMP'=>'https://ampforwp.com/tutorials/article-categories/classipress-for-amp-extension/',
            'Contact Form 7 for AMP'=>'https://ampforwp.com/tutorials/article-categories/contact-form-7/',
            'CCPA for AMP'=>'https://ampforwp.com/tutorials/article/how-to-use-ccpa-for-amp/',
            'Custom Post Type Support for AMP' =>'https://ampforwp.com/tutorials/article-categories/custom-post-types/',
            'Floating Button for AMP'=>'https://ampforwp.com/tutorials/article-categories/floating-button/',
            'Formidable forms for AMP'=>'https://ampforwp.com/tutorials/article/how-to-add-formidable-forms-for-amp/',
            'Forminator for AMP'=>'https://ampforwp.com/tutorials/article/how-to-add-forminator-for-amp/',
            'Gravity Forms'=>'https://ampforwp.com/tutorials/article-categories/gravity-forms/',
            'iZooto for AMP'=>'https://ampforwp.com/tutorials/article/how-to-setup-izooto-in-amp/',
            'JW Player compatibility for AMP'=>'https://ampforwp.com/tutorials/article/how-to-use-jw-player-compatibility-for-amp/',
            'Liveblog For AMP'=>'https://ampforwp.com/tutorials/article-categories/liveblog-for-amp/',
            'Newspaper Theme for AMP'=>'https://ampforwp.com/tutorials/article-categories/newspaper-theme/',
            'Ninja Forms for AMP'=>'https://ampforwp.com/tutorials/article-categories/ninja-forms/',
            'Opt-in-Forms for AMP'=>'https://ampforwp.com/tutorials/article-categories/amp-opt-in/',
            'Polylang For AMP'=>'https://ampforwp.com/tutorials/article-categories/polylang/',
            'Purge AMP CDN Cache'=>'https://ampforwp.com/tutorials/article-categories/purge-amp-cdn-cache/',
            'Paid Memberships PRO for AMP'=>'https://ampforwp.com/tutorials/article/how-to-use-paid-memberships-pro-plugin-in-amp/',
            'Pinterest for AMP'=>'https://ampforwp.com/tutorials/article/how-to-install-and-use-the-pinterest-for-amp/',
            'Polls for AMP'=>'https://ampforwp.com/tutorials/article/how-to-use-polls-for-amp/',
            'Post Views for AMP'=>'https://ampforwp.com/tutorials/article/how-to-enable-post-views-for-amp-support-in-amp/',
            'Reading Progress Bar for AMP'=>'https://ampforwp.com/tutorials/article/how-to-add-reading-progress-bar-for-amp/',
            'Recipe Compatibility for AMP'=>'https://ampforwp.com/tutorials/article/how-to-enable-recipe-compatibility-for-amp/ ',
            'Shortcodes Ultimate'=>'https://ampforwp.com/tutorials/article-categories/shortcodes-ultimate/',
            'Smart Sticky Header for AMP'=>'https://ampforwp.com/tutorials/article/how-to-add-smart-sticky-header-for-amp-support-in-amp/',
            'Transposh for AMP'=>'https://ampforwp.com/tutorials/article/how-to-add-smart-sticky-header-for-amp-support-in-amp/',
            'WooCommerce'=>'https://ampforwp.com/tutorials/article-categories/woocommerce/',
            'WP Forms for AMP'=>'https://ampforwp.com/tutorials/article-categories/wp-forms/',
            'AMP Email'=>'https://ampforwp.com/tutorials/article/what-is-amp-email-and-how-to-use-them-in-wordpress/',
            'Easy Table of Contents for AMP'=>'https://ampforwp.com/tutorials/article/how-to-integrate-easy-table-of-contents-in-amp/',
            'Facebook Chat For AMP'=>'https://ampforwp.com/tutorials/article/facebook-chat-for-amp/',
            'Table Of Content Plus For AMP'=>'https://ampforwp.com/tutorials/article/table-of-content-compatibility-in-amp/',
            'The Event Calender for AMP'=>'https://ampforwp.com/tutorials/article/the-events-calendar-for-amp/',
            'WPML For AMP'=>'https://ampforwp.com/tutorials/article/wpml-for-amp-setup-tutorial/',
            'EDD for AMP'=>'https://ampforwp.com/tutorials/article/edd-for-amp-setup-tutorial/',
            'Caldera Forms for AMP'=>'https://ampforwp.com/tutorials/article/how-to-install-and-use-the-caldera-forms-for-amp/',
            'LuckyWP Table of Contents for AMP'=>'https://ampforwp.com/tutorials/article/luckywp-table-of-contents-for-amp/',
            'Subdomain Endpoints for AMP'=>'https://ampforwp.com/tutorials/article/how-to-set-up-subdomain-endpoint-for-amp/',
        );
        $doc = '';
        if(isset($docs[$name])){
            $doc ='<a href="'.esc_url($docs[$name]).'" title="Documentation" class="afwpp-link" target="_blank"><button class="button btn-setting">Documentation</button></a>';
          
        }
        return $doc;
    }
    public function ampforwppro_remove_licence(){
        if(isset($_POST['action']) && $_POST['action']=='ampforwppro_remove_licence'){
            $license_info =  get_option('ampforwppro_license_info');
            $license_k = $license_info->license_key;
            $item_name = "Membership Bundle";
            $api_params = array(
                'edd_action' => 'deactivate_license',
                'license'    => $license_k,
                'item_name'  => urlencode( $item_name ), // the name of our product in EDD
                'url'        => home_url(),
                'referer'    => 'extension_manager',
                'activation_type' => 'bundle',
            );
            $response = wp_remote_post( $this->store_url, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
            if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
                if(!empty($response->get_error_message())){
                    $error_message = strtolower($response->get_error_message());
                    $error_pos = strpos($error_message, 'operation timed out');
                    if($error_pos !== false){
                        $res['success'] = 2;
                        $res['message'] = esc_html__('Request timed out, please try again', 'accelerated-mobile-pages');
                        echo json_encode($res);
                        exit;
                    }else{
                        $res['success'] = 2;
                        $res['message'] = esc_html($response->get_error_message());
                        echo json_encode($res);
                        exit;
                    }
                }
            }
            $response = wp_remote_retrieve_body( $response );
            $license_data = json_decode( $response );
            if($license_data->success){
                if($license_data->license=='deactivated'){
                    delete_option('ampforwppro_license_info');
                    $this->ampforwppro_reset_transient();
                    $res['success'] = 1;
                    $res['message'] = "Successful";
                    echo json_encode($res);
                    exit;
                }else{
                    $res['success'] = 2;
                    $res['message'] = "Opps! something went wrong please try again.";
                    echo json_encode($res);
                    exit;
                }
            }elseif(isset($license_info->error) && $license_info->error == 'expired'){
                delete_option('ampforwppro_license_info');
                $this->ampforwppro_reset_transient();
                $res['success'] = 1;
                $res['message'] = "Successful";
                echo json_encode($res);
            }
            else{
                if(isset($license_data->license) && $license_data->license == 'failed'){
                delete_option('ampforwppro_license_info');
                $this->ampforwppro_reset_transient();
                $res['success'] = 1;
                $res['message'] = "Successful";
                echo json_encode($res);
                }
                else{
                $res['success'] = 2;
                $res['message'] = "Placed license key is Invalid please contact our support team to deactivate.";
                echo json_encode($res);
                exit;
            }
            }
        }
    }
    public function ampforwppro_refresh_bundle(){
        if ( ! isset( $_POST['verify_nonce'] ) || ! wp_verify_nonce( $_POST['verify_nonce'], 'ampforwppro_nonce' )) {
            $res['success'] = 2;
            $res['message'] = 'Sorry, your nonce did not verify.';
            echo json_encode($res);
        }else{
            $this->ampforwppro_reset_transient();
            $renew_status = $_POST['renew_status'];
            $license_info =  get_option('ampforwppro_license_info');
            $payment_id = $license_info->payment_id;
            $download_id = $license_info->download_id;
            $api_params = array(
                'action'        => 'afwpp_refresh_lincense',
                'verify_nonce'  => 'refresh_bundle_list',
                'payment_id'    => $payment_id, 
                'download_id'   => $download_id,
                'referer'       => 'extension_manager',
            );
            $response = wp_remote_post( $this->store_url, array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );
            if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
                if(!empty($response->get_error_message())){
                    $error_message = strtolower($response->get_error_message());
                    $error_pos = strpos($error_message, 'operation timed out');
                    if($error_pos !== false){
                        $res['success'] = 2;
                        $res['message'] = esc_html__('Request timed out, please try again', 'accelerated-mobile-pages');
                        echo json_encode($res);
                        exit;
                    }else{
                        $res['success'] = 2;
                        $res['message'] = esc_html($response->get_error_message());
                        echo json_encode($res);
                        exit;
                    }
                }
            }
            $response = wp_remote_retrieve_body( $response );
            $resp_data = json_decode( $response );
            if($resp_data->success==1){
                $license_k = $license_info->license_key;
                $this->ampforwppro_activate_bundle_license($license_k);
            }else if($renew_status=="yes" || $resp_data->success==2){
                $license_k = $license_info->license_key;
                $this->ampforwppro_activate_bundle_license($license_k);
            }else{
                $res['success'] = 2;
                $res['message'] = "Opps! something went wrong.";
                echo json_encode($res);
            }
        }
    }

    public function ampforwppro_run_once( $value )
    {
            $transient =  'ampforwppro_t';
            $value =  'ampforwppro_t_v';
            $expiration =  '' ;
            set_transient( $transient, $value, $expiration );
    }

    public function ampforwppro_run_oncef7( $value )
    {
            $transient_load =  'ampforwppro_load';
            $value_load =  'ampforwppro_load_v';
            $expiration_load =  86400 ;
            set_transient( $transient_load, $value_load, $expiration_load );
    }

    public function ampforwppro_load_plugin_list($screen){
        if($screen->base){
            if ( !isset( $_REQUEST['plugin_status'] ) || ($_REQUEST['plugin_status']=="amp-ext-manage" || $_REQUEST['plugin_status']=="all")) {
                add_filter( "all_plugins", array( $this, 'amforwppro_plugin_extension_list' ),30 );
            }
        }
    }

    public function amp_eos_dp_return_pro_ext($plugins){
        if( isset( $_REQUEST['action'] ) && ( $_REQUEST['action'] === 'ampforwppro_activate_licence' ) && isset( $_REQUEST['plugin_path'] ) && isset( $_REQUEST['c_status'] ) ){
            if($_REQUEST['c_status'] !== 'Deactivate'){
                array_push($plugins, $_REQUEST['plugin_path']);
            }else{
                $plugins = array_diff($plugins, array($_REQUEST['plugin_path']));
            }
        }
        return $plugins;
    }

    public function ampforwppro_amp_extension_array_lists(){

    $all_extensions_data = array(
                        array(
                            'name'=>'Contact Form 7',
                            'desc'=>'Add Contact Us Form in AMP.',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/cf7.png',
                            'price'=>'$39',
                            'url_link'=>'http://ampforwp.com/contact-form-7/#utm_source=options-panel&utm_medium=extension-tab_cf7&utm_campaign=AMP%20Plugin',
                            'plugin_active_path'=> 'amp-cf7/amp-cf7.php',
                            'item_name'=>'Contact Form 7 for AMP',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('amp-cf7/amp-cf7.php')? 1 : 2),
                            'settingUrl'=>'{ampforwp-cf7-subsection}',
                        ), 
                        array(
                            'name'=>'Caldera Forms for AMP',
                            'desc'=>'Add Caldera Form in AMP.',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/cf.png',
                            'price'=>'$39',
                            'url_link'=>'http://ampforwp.com/caldera-forms-for-amp',
                            'plugin_active_path'=> 'caldera-forms-for-amp/caldera-forms-for-amp.php',
                            'item_name'=>'Caldera Forms for AMP',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('caldera-forms-for-amp/caldera-forms-for-amp.php')? 1 : 2),
                        ),
                        array(
                            'name'=>'Gravity Forms',
                            'desc'=>'Add Gravity Forms Support in AMP.',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/gf.png',
                            'price'=>'$79',
                            'url_link'=>'http://ampforwp.com/gravity-forms/#utm_source=options-panel&utm_medium=extension-tab_gf&utm_campaign=AMP%20Plugin',
                            'plugin_active_path'=> 'amp-gravity-forms/amp-gravity-forms.php',
                            'item_name'=>'Gravity Forms',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('amp-gravity-forms/amp-gravity-forms.php')? 1 : 2),
                            'settingUrl'=>'{ampforwp-gf-subsection}',
                        ),
                        array(
                            'name'=>'Ninja Forms for AMP',
                            'desc'=>'Add Ninja Forms Support in AMP.',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/nf.png',
                            'price'=>'$79',
                            'url_link'=>'http://ampforwp.com/ninja-forms/#utm_source=options-panel&utm_medium=extension-tab_gf&utm_campaign=AMP%20Plugin',
                            'plugin_active_path'=> 'amp-ninja-forms/amp-ninja-forms.php',
                            'item_name'=>'Ninja Forms for AMP',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('amp-ninja-forms/amp-ninja-forms.php')? 1 : 2),
                            'settingUrl'=>'{ampforwp-nf-subsection}',
                        ),
                        array(
                            'name'=>'Pinterest for AMP',
                            'label' => 'Pinterest for AMP',
                            'desc'=>'Pinterest compatibility with AMP',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/amp-icon.png',
                            'price'=>'$19',
                            'url_link'=>'https://ampforwp.com/addons/pinterest-for-amp/#utm_source=options-panel&utm_medium=extension-tab_polylang-for-amp&utm_campaign=AMP%20Plugin',
                            'plugin_active_path'=> 'pinterest-for-amp/pinterest-for-amp.php',
                            'item_name'=>'Pinterest for AMP',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('pinterest-for-amp/pinterest-for-amp.php')? 1: 2),
                        ),
                        array(
                            'name'=>'WP Forms for AMP',
                            'desc'=>'Add WP Forms Support in AMP.',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/wpf.png',
                            'price'=>'$79',
                            'url_link'=>'http://ampforwp.com/wp-forms/#utm_source=options-panel&utm_medium=extension-tab_gf&utm_campaign=AMP%20Plugin',
                            'plugin_active_path'=> 'wp-forms-for-amp/amp-wpforms.php',
                            'item_name'=>'WP Forms for AMP',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('wp-forms-for-amp/amp-wpforms.php')? 1 : 2),
                        ),
                        array(
                            'name'=>'Email Opt-in Forms',
                            'desc'=>'Capture Leads with Email Subscription.',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/email.png',
                            'price'=>'$79',
                            'url_link'=>'http://ampforwp.com/opt-in-forms/#utm_source=options-panel&utm_medium=extension-tab_opt-in-forms&utm_campaign=AMP%20Plugin',
                            'plugin_active_path'=> 'amp-optin/amp-optin.php',
                            'item_name'=>'Opt-in-Forms for AMP',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('amp-optin/amp-optin.php')? 1 : 2),
                            'settingUrl'=>'{ampforwp-optin-subsection}'
                        ),
                        array(
                            'name'=>'AMP Popup',
                            'desc'=>'Pop-Up Functionality for AMP in WordPress. Most easiest and the best way to include Pop-Up in AMP.',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/pwa-icon.png',
                            'price'=>'$39',
                            'url_link'=>'https://ampforwp.com/amp-popup/',
                            'plugin_active_path'=> 'amp-popup/amp-popup.php',
                            'item_name'=>'AMP Popup',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('amp-popup/amp-popup.php')? 1 : 2),
                        ),
                        array(
                            'name'=>'AMP Pagebuilder Compatibility',
                            'desc'=>'Page Builder Functionality for AMP in WordPress. Most easiest and the best way to include Page Builder in AMP.',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/pwa-icon.png',
                            'price'=>'$89',
                            'url_link'=>'http://ampforwp.com/page-builder-compatibility-for-amp/#utm_source=options-panel&utm_medium=extension-tab_pagebuilder-for-amp&utm_campaign=AMP%20Plugin',
                            'plugin_active_path'=> 'amp-pagebuilder-compatibility/amp-pagebuilder-compatibility.php',
                            'item_name'=>'AMP Pagebuilder Compatibility',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('amp-pagebuilder-compatibility/amp-pagebuilder-compatibility.php')? 1 : 2),
                            'settingUrl'=>'{amp-content-builder}',
                        ),
                        array(
                            'name'=>'AMP WooCommerce Pro',
                            'desc'=>'Advanced WooCommerce in AMP in two clicks.',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/woo.png',
                            'price'=>'$79',
                            'url_link'=>'https://ampforwp.com/woocommerce/#utm_source=options-panel&utm_medium=extension-tab_woocommerce&utm_campaign=AMP%20Plugin',
                            'plugin_active_path'=> 'amp-woocommerce-pro/amp-woocommerce.php',
                            'item_name'=>'WooCommerce',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('amp-woocommerce-pro/amp-woocommerce.php')? 1 : 2),
                            'settingUrl'=>'{ampforwp-wcp-subsection}',
                        ),
                        array(
                            'name'=>'Facebook Chat For AMP',
                            'desc'=>'Facebook Chat for AMP in WordPress. Most easiest and the best way to include Facebook Chat in AMP.',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/comments.png',
                            'price'=>'$19',
                            'url_link'=>'https://ampforwp.com/facebook-chat-for-amp/',
                            'plugin_active_path'=> 'facebook-chat-for-amp/facebook-chat-for-amp.php',
                            'item_name'=>'Facebook Chat For AMP',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('facebook-chat-for-amp/facebook-chat-for-amp.php')? 1 : 2),
                        ),
                        array(
                            'name'=>'AMP Comments',
                            'desc'=>'You can now allow the same comment functionality on AMP.',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/comments.png',
                            'price'=>'$29.99',
                            'url_link'=>'https://ampforwp.com/amp-comments/#utm_source=options-panel&utm_medium=extension-tab_amp-comments&utm_campaign=AMP%20Plugin',
                            'plugin_active_path'=> 'amp-comments/amp-comments.php',
                            'item_name'=>'AMP Comments',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('amp-comments/amp-comments.php')? 1: 2),
                            'settingUrl'=>'{ampforwp-cmt-subsection}',
                        ),
                        array(
                            'name'=>'AMP Stories',
                            'desc'=>'A Revolutionary new way to share your stories',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/amp-stories.png',
                            'price'=>'$79',
                            'url_link'=>'https://ampforwp.com/amp-stories/#utm_source=options-panel&utm_medium=extension-tab_stories&utm_campaign=AMP%20Plugin',
                            'plugin_active_path'=> 'amp-stories/ampforwp-stories.php',
                            'item_name'=>'AMP Stories',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('amp-stories/ampforwp-stories.php')? 1 : 2),
                            'settingUrl'=>admin_url( 'edit.php?post_type=ampforwp_story' ),
                        ),
                        array(
                            'name'=>'Purge AMP CDN Cache',
                            'class'=>'new-ext',
                            'label' => 'Purge AMP CDN Cache',
                            'desc'=>'Purge AMP CDN Cache on one click. Editors can update/purge the google cdn cache of amp post and pages in one click.',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/cache-icon.png',
                            'price'=>'$19',
                            'url_link'=>'https://ampforwp.com/addons/purge-amp-cdn-cache/#utm_source=options-panel&utm_medium=extension-tab_purge-amp-cdn-cache&utm_campaign=AMP%20Plugin',
                            'plugin_active_path'=> 'purge-amp-cdn-cache/purge-amp-cdn-cache.php',
                            'item_name'=>'Purge AMP CDN Cache',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('purge-amp-cdn-cache/purge-amp-cdn-cache.php')? 1 : 2),
                        ),
                        array(
                            'name'=>'Table Of Content Plus For AMP',
                            'desc'=>'This is an extension of Table Of Content For AMP',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/amp-SU.png',
                            'price'=>'$19',
                            'url_link'=>'https://ampforwp.com/table-of-contents-plus/#utm_source=options-panel&utm_medium=extension-tab_tableofcontent&utm_campaign=AMP%20Plugin',
                            'plugin_active_path'=> 'table-of-content-plus-for-amp/table-of-content-plus-for-amp.php',
                            'item_name'=>'Table Of Content Plus For AMP',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('table-of-content-plus-for-amp/table-of-content-plus-for-amp.php')? 1 : 2),
                        ),
                        array(
                            'name'=>'Easy Table of Contents for AMP',
                            'class'=>'new-ext',
                            'desc'=>'Easy Table of Contents Plugin Compatibility in AMP',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/easytoc-icon.png',
                            'price'=>'$39',
                            'url_link'=>'https://ampforwp.com/addons/easy-table-of-contents-for-amp/',
                            'plugin_active_path'=> 'easy-table-of-contents-for-amp/easy-table-of-contents-for-amp.php',
                            'item_name'=>'Easy Table of Contents for AMP',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('easy-table-of-contents-for-amp/easy-table-of-contents-for-amp.php')? 1 : 2),
                        ), 
                        array(
                            'name'=>'LuckyWP Table of Contents for AMP',
                            'class'=>'new-ext',
                            'desc'=>'This extension automatically adds LuckyWP Table of Contents functionality in AMP',
                            'img_src'=>AMPFORWPPRO_IMAGE_DIR . '/LuckyWpTOCforAMP.png',
                            'price'=>'$19',
                            'url_link'=>'https://ampforwp.com/addons/luckywp-table-of-contents-for-amp/',
                            'plugin_active_path'=> 'luckywp-table-of-contents-for-amp/luckywp-table-of-contents-for-amp.php',
                            'item_name'=>'LuckyWP Table of Contents for AMP',
                            'store_url'=>'https://accounts.ampforwp.com',
                            'is_activated'=>(is_plugin_active('luckywp-table-of-contents-for-amp/luckywp-table-of-contents-for-amp.php')? 1 : 2),
                        ),
                    );

      return $all_extensions_data;
    }

    public function ampforwppro_amp_by_google_supported_plugin_list($extension){
        $popular = array('amp pagebuilder compatibility','contact form 7 for amp','woocommerce','gravity forms','wp forms for amp','table of content plus for amp','purge amp cdn cache','pinterest for amp','opt-in-forms for amp','ninja forms for amp','luckywp table of contents for amp','facebook chat for amp','easy table of contents for amp','caldera forms for amp','amp stories','amp popup','amp comments');
        $extension = strtolower($extension);
        if(in_array($extension, $popular)){
            return true;
        }
        return false;
    }
    public function amforwppro_plugin_extension_list($all_plugins){
        $get_li_info = get_option('ampforwppro_license_info');
        if($get_li_info){
            $all_plugin_count = count($all_plugins);
            $response = $get_li_info->afwpp_response;
            $extension_arr = array();
            foreach ($response as $key => $value) {
                $status = ucfirst($response[$key]->status);
                $title = $response[$key]->post_title;
                $tit = $title;
                $ind = trim(strtolower(str_replace(' ', '-', $tit)));
                if($ind=='woocommerce'){
                    $ind = 'amp-woocommerce-pro';
                }else if($ind=='shortcodes-ultimate'){
                    $ind = 'shortcodes-ultimate-for-amp';
                }else if($ind=='gravity-forms'){
                    $ind = 'amp-gravity-forms';
                }
                $extension_arr[] = $ind;
            }

            foreach ($all_plugins as $key => $value) {
                   $p_key = strtolower(str_replace(' ', '-', $value['Title']));
                   if($p_key=="amp-pop-up"){
                        $p_key = "amp-popup";
                   }else if($p_key=="the-events-calendar-for-amp"){
                        $p_key = "the-event-calender-for-amp";
                   }else if($p_key=="amp-shortcodes-ultimate"){
                        $p_key = "shortcodes-ultimate-for-amp";
                   }else if($p_key=="amp-opt-in-forms"){
                        $p_key = "opt-in-forms-for-amp";
                   }else if($p_key=="newspaper-amp-theme"){
                        $p_key = "newspaper-theme-for-amp";
                   }else if($p_key=="amp-custom-post-type"){
                        $p_key = "custom-post-type-support-for-amp";
                   }else if($p_key=="amp-cta"){
                        $p_key = "call-to-action-for-amp";
                   }
                   if(isset($_REQUEST['plugin_status']) && $_REQUEST['plugin_status']=="amp-ext-manage" && (!in_array($p_key, $extension_arr))){
                        unset($all_plugins[$key]);
                   }else if((!isset($_REQUEST['plugin_status']) || $_REQUEST['plugin_status']=="all") && in_array($p_key, $extension_arr)){
                        unset($all_plugins[$key]);
                   }
               
            }
            if(isset($_REQUEST['plugin_status'])&& $_REQUEST['plugin_status']== "amp-ext-manage"){
                $plugins = json_encode($all_plugins);
                $this->plugin_count = count($all_plugins);
            }else{
                $this->plugin_count = $all_plugin_count - count($all_plugins);
            }
        }
        return $all_plugins;
    }
    public function amforwppro_plugin_heading($views){
        global $totals;
        $get_li_info = get_option('ampforwppro_license_info');
        if($get_li_info){
            $response = $get_li_info->afwpp_response;
            $count = '';
            if(is_array($response)){
                $ext_count = $this->plugin_count;
                $totals['amp-ext-manage'] = $ext_count;
                $count = '<span class="count">('.$ext_count.')</span>';
            }
            $class="";
            $current="";
            if ( isset( $_REQUEST['plugin_status'] ) && $_REQUEST['plugin_status']=="amp-ext-manage") {
                $class="current";
                $current= 'aria-current="page"';
            }
            $views['amp-ext-manage'] = '<a href="plugins.php?plugin_status=amp-ext-manage" class="'.$class.'" '.$current.'>AMP '.$count.'</a>';
        }
        return $views;
    }
    public function ampforwppro_popular_plugin_list($extension){
        $popular = array('advanced amp ads','amp cache','amp pagebuilder compatibility','amp layouts','contact form 7 for amp','woocommerce','gravity forms');
        $extension = strtolower($extension);
        if(in_array($extension, $popular)){
            return true;
        }
        return false;
    }
    public function ampforwppro_recommended_plugin_list($extension){
        $recommended = array();
        $recommended[] = 'Opt-in-Forms for AMP';
        if(defined('WPCF7_VERSION')){
            $recommended[] = 'Contact Form 7 for AMP';
        }
        if(class_exists('Ninja_Forms')){
            $recommended[] = 'Ninja Forms for AMP';
        }
        if(function_exists('caldera_forms_fallback_shortcode')){
            $recommended[] = 'Caldera Forms for AMP';
        }
        if(function_exists('wpforms')){
            $recommended[] = 'WP Forms for AMP';
        }
        if(function_exists('WC')){
            $recommended[] = 'WooCommerce';
        }
        if(class_exists('Easy_Digital_Downloads')){
            $recommended[] = 'EDD for AMP';
        }
        if(defined('POLYLANG_BASENAME')){
            $recommended[] = 'Polylang For AMP';
        }
        if(class_exists('bbPress')){
            $recommended[] = 'bbPress for AMP';
        }
        if(function_exists('activate_shortcodes_ultimate')){
            $recommended[] = 'Shortcodes Ultimate';
        }
        if(class_exists('toc')){
            $recommended[] = 'Table Of Content Plus For AMP';
        }
        if(class_exists('ezTOC')){
            $recommended[] = 'Easy Table of Contents for AMP';
        }
        if(class_exists('WPCOM_Liveblog')){
            $recommended[] = 'Liveblog For AMP';
        }
        if(defined('TRIBE_EVENTS_FILE')){
            $recommended[] = 'The Event Calender for AMP';
        }
        if(function_exists('run_wp_recipe_maker') || function_exists('yasr_fs') || function_exists('wp_review_constants') || function_exists('postratings_init') || class_exists('WPCustomerReviews3') || defined('KKSR_PLUGIN') || function_exists('taqyeem_init') || class_exists('Multi_Rating')){
            $recommended[] = 'AMP Rating';
        }
        if(class_exists('GFForms')){
            $recommended[] = 'Gravity Forms';
        }
        if(function_exists('cp_display_version_warning')){
            $recommended[] = 'Classipress for AMP';
        }
        if(function_exists('elementor_load_plugin_textdomain') || function_exists('et_divi_theme_body_class')){
            if(function_exists('elementor_load_plugin_textdomain') || function_exists('et_divi_theme_body_class')){
                $recommended[] = 'AMP Pagebuilder Compatibility';
            }
        }
        if(function_exists('wpml_upgrade')){
            $recommended[] = 'WPML For AMP';
        }
        if(in_array($extension, $recommended)){
            return true;
        }
        return false;
    }

    public function amp_pro_ext_mger_accept_data(){   
    if( !wp_verify_nonce($_POST['amppro_details_nonce'],'amppro_details_nonce')){
        header('HTTP/1.1 500 FORBIDDEN');
        die;
      }
      else{
    $user_id = get_current_user_id();
    add_user_meta( $user_id, 'ampforwp_amp_pro_notice_dismiss', 'true', true );
    $get_blog_info = get_bloginfo("language");
    $get_website_type = '';
    if(function_exists('ampforwp_get_setup_info')){
    $get_website_type = ampforwp_get_setup_info('ampforwp-ux-website-type-section');
    }
    $get_site_info = get_site_url();
    $email_info = get_bloginfo('admin_email'); 
    $apl = get_option('active_plugins');
    $plugins = get_plugins(); // gets all info about the Plugins    
    $activated_plugins=array();
    foreach ($apl as $p){           
        if(isset($plugins[$p])){
            $activated_plugins[] = $plugins[$p][ 'Name' ];
         
        }              
    }
    $sendData = array(
                'lang'=> $get_blog_info,
                'site_type'=> $get_website_type,
                'site_info'=> $get_site_info,
                'active_plugins'=> $activated_plugins,
                'email_info' => $email_info,
                );
    $postdata = array('body'=> $sendData);
    $url = 'https://wordpress-123147-847862.cloudwaysapps.com/serverFile.php';
    $remoteResponse = wp_remote_post($url, $postdata);
    if( is_wp_error( $remoteResponse ) ){
        $remoteData = array('status'=>401, "response"=>"could not connect to server");
    }
    else
    {
        $remoteData = wp_remote_retrieve_body($remoteResponse);
        $remoteData = json_decode($remoteData, true);
    }
    $url =  "admin.php?page=amp-extension-manager";    
    wp_redirect( $url );
    exit;
    }
}

public function ampforwp_amp_pro_notice_dismiss() {
    global $user_id;
    $user_id = get_current_user_id();
    if ( isset( $_GET['amp-enhancer-dismissed'] ) ){
        add_user_meta( $user_id, 'ampforwp_amp_pro_notice_dismiss', 'true', true );
    }
}


public function ampforwp_ampproextmgr_admin_notice() {        
    global $user_id;
    $user_id = get_current_user_id();    
    $amppro_details_nonce = wp_create_nonce( 'amppro_details_nonce' );
    $appender = '?action=amp_pro_ext_mger_accept_data';

    if ( !get_user_meta( $user_id, 'ampforwp_amp_pro_notice_dismiss' ) ){
    $user_id = get_current_user_id();?>
        <div class="updated notice">
            <form action=" <?php echo esc_url( admin_url( 'admin-ajax.php'.$appender ) ); ?>" method="post" id="user_accept" >
                <?php
                global $user_id;
                $user_id = get_current_user_id();
                 if ( !get_user_meta( $user_id, 'ampforwp_amp_pro_notice_dismiss' ) ){ ?>
                    <p class="amp-pro-admin" style = "font-size:14px;"> Thank You for activating our AMP Pro Extension manager, we want to collect non-sensitive information for research and Development Purpose
          <button type="submit" name="submit" id="submit" class="button button-primary" value="Submit Form">Allow</button>           
                <?php } ?>
                <?php 
        $user_id = get_current_user_id();        
         echo '<a  href="?amp-enhancer-dismissed" class="button">'. esc_html__('No Thanks','amp-enhancer').'</a>';
         ?></p>
            <input type="hidden" name="amppro_details_nonce" value="<?php echo $amppro_details_nonce ?>" />
                </form>
                </div>
                <?php
             }
        }

    // Check for updates
    public function ampforwppro_plugin_updater() {
        require_once dirname( __FILE__ ) . '/updater/EDD_SL_Plugin_Updater.php';
        // setup the updater
        $edd_updater = new AMP_EXTENSION_MANAGER_EDD_SL_Plugin_Updater( $this->store_url, __FILE__, array(
                'version'   => AMPFORWPPRO_VERSION,
                'license'   => '9151d882f9f16467f6c1805e3469280d',  
                'license_status'=>'active',
                'item_name' => AMPFORWPPRO_ITEM_NAME,
                'author'    => 'AMPforWP Team',
                'beta'      => false,
            )
        );
        $path = plugin_basename( __FILE__ );
        add_action("after_plugin_row_{$path}", function( $plugin_file, $plugin_data, $status ) {
            if(! defined('AMPFORWPPRO_ITEM_FOLDER_NAME')){
                $folderName = basename(__DIR__);
                define( 'AMPFORWPPRO_ITEM_FOLDER_NAME', $folderName );
            }
            $update_cache = get_site_transient( 'update_plugins' );
            $update_cache = is_object( $update_cache ) ? $update_cache : new stdClass();
            if(isset($update_cache->response[ AMPFORWPPRO_ITEM_FOLDER_NAME ]) 
                && empty($update_cache->response[ AMPFORWPPRO_ITEM_FOLDER_NAME ]->download_link) 
              ){
               unset($update_cache->response[ AMPFORWPPRO_ITEM_FOLDER_NAME ]);
                set_site_transient( 'update_plugins', $update_cache );
            }  
           
        }, 10, 3 );
    }
// Notice to enter license key once activate the plugin
}
$afwpp_obj = new AMPExtensionManager();