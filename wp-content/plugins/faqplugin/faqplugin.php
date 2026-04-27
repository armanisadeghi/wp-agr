<?php
session_start();
/*
Plugin Name: FAQ Plugin
Plugin URI:  
Description:  FAQ Plugin
Version:     1.0.0
Author:      Apcomp Infotech LLP
Author URI:  
License:     GPL2
License URI: 
*/

include_once(__DIR__.'/includes/functions.php');

function faq_plugin_options_install() {
   	global $wpdb;
	$categorytable = getCategoryTableName();
	$faqtable = getFaqTableName();
	if($wpdb->get_var("show tables like '$categorytable'") != $categorytable) 
	{
		$sql = "CREATE TABLE " . $categorytable . " (
			`ID` mediumint(9) NOT NULL AUTO_INCREMENT,
			`Name` varchar(250) NOT NULL,
			`Description` text NOT NULL,
			`ShortCode` varchar(250) NOT NULL,
			`Status` int(1) NOT NULL DEFAULT 1,
			`created_at` timestamp NULL DEFAULT current_timestamp(),
			`updated_at` timestamp NULL DEFAULT current_timestamp(),
			UNIQUE KEY ID (ID)
		);";
 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	if($wpdb->get_var("show tables like '$faqtable'") != $faqtable) 
	{
		$sql = "CREATE TABLE " . $faqtable . " (
			`ID` mediumint(9) NOT NULL AUTO_INCREMENT,
			`Question` text NOT NULL,
			`Answer` text NOT NULL,
			`Category_id` int(10) NOT NULL,
			`ShortCode` varchar(250) NOT NULL,
			`Status` int(1) NOT NULL DEFAULT 1,
			`created_at` timestamp NULL DEFAULT current_timestamp(),
			`updated_at` timestamp NULL DEFAULT current_timestamp(),
			UNIQUE KEY ID (ID)
		);";
 
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
	return true;
}

register_activation_hook(__FILE__,'faq_plugin_options_install');

function faq_plugin_scripts() {
    wp_enqueue_style( 'faq-plugin-style-1', plugins_url() . '/'.getPluginName().'/includes/assets/css/styles.css' );
	/*akanksha add css*/
	 wp_enqueue_style( 'faq-plugin-style-2', plugins_url() . '/'.getPluginName().'/includes/assets/bootstrap/css/bootstrap.min.css' );
	  wp_enqueue_style( 'faq-plugin-style-3', plugins_url() . '/'.getPluginName().'/includes/assets/font-awesome/css/font-awesome.min.css' );
     wp_enqueue_script( 'faq-plugin-jquery-2', plugins_url() . '/'.getPluginName().'/includes/assets/js/jquery.js', array(), '1.0.0', true );
	/*akanksha add script*/
	wp_enqueue_script( 'faq-plugin-jquery-1', plugins_url() . '/'.getPluginName().'/includes/assets/bootstrap/js/bootstrap.min.js', array(), '1.0.0', true );
	wp_enqueue_script( 'faq-plugin-accordion-3', plugins_url() . '/'.getPluginName().'/includes/assets/js/jquery-accordion.js', array(), '1.0.0', true );
    wp_enqueue_script( 'faq-plugin-scripts-4', plugins_url() . '/'.getPluginName().'/includes/assets/js/scripts.js', array(), '1.0.0', true );
    
    wp_enqueue_script( 'faq-plugin-scripts-4', plugins_url() . '/'.getPluginName().'/includes/assets/js/scripts.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'faq_plugin_scripts' );

function wpb_hook_google_ld($script = '') { 
        echo $script;
     }
     
add_action('wp_head', 'wpb_hook_google_ld');

// Register the toggle shortcode
function toggle_shortcode( $atts ) {
	
	extract( shortcode_atts( array(
		'title' => 'Click To Open',
		'color' => ''
	), $atts ) );
	
	//print_r($atts);
	
	global $wpdb;
	$table = getFaqTableName();
	$category_table = getCategoryTableName();
	
	$query = "SELECT * FROM ".$table." Order by ID DESC";
	
	if((ISSET($atts['type']) && $atts['type'] == 'faq') && (ISSET($atts['id']) && $atts['type'] != ''))
	{
	    $query = "SELECT ".$table.".*, ".$category_table.".Name as category_name FROM ".$table." left join ".$category_table." on ".$category_table.".id = ".$table.".Category_id where ".$category_table.".Status = 1 and ".$table.".Status = 1 and ".$table.".ID in (".$atts['id'].") Order by ".$table.".ID DESC";
	}
	
	if((ISSET($atts['type']) && $atts['type'] == 'category') && (ISSET($atts['id']) && $atts['type'] != ''))
	{
	    $query = "SELECT ".$table.".*, ".$category_table.".Name as category_name FROM ".$table." left join ".$category_table." on ".$category_table.".id = ".$table.".Category_id where ".$category_table.".Status = 1 and ".$table.".Status = 1 and ".$table.".Category_id in (".$atts['id'].") Order by ".$table.".ID DESC";
	}
	
	$result = $wpdb->get_results($query);
	$faq_html = '<div class="container main-general-div"> <div class="panel-group" id="accordion">';
    $schema_ld = array();
	foreach ( $result as $print )   {
	    $schema_ld[] = [
	        "@type" => "Question",
            "name" => $print->Question,
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => $print->Answer
            ]
	    ];
	    $uniqid = rand(1000000,999999999);
        $faq_html .= '<div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title panel-box-title">
                          <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapseOne-'.$print->ID.$uniqid.'">'.$print->Question.'</a>
                        </h4>
                    </div>
                        <div id="collapseOne-'.$print->ID.$uniqid.'" class="panel-collapse collapse">
                                 <div class="panel-body panel-body-content">'.$print->Answer.'</div>
                        </div>
                    </div>';

	}
	$faq_html .= '</div></div>';
    
	if((count($schema_ld) > 0) && !strpos($_SERVER['REQUEST_URI'], 'wp-admin') && !strpos($_SERVER['REQUEST_URI'], 'wp-json'))
	{
	    if(!ISSET($atts['jsonld']) || (ISSET($atts['jsonld']) && $atts['jsonld'] == 'yes'))
	    {
	        do_action('wp_head','
        	    <script type="application/ld+json">
                    {
                      "@context": "https://schema.org",
                      "@type": "FAQPage",
                      "mainEntity": '.json_encode($schema_ld).'
                    }
                </script>'
            );
	    }
	}
	
	return $faq_html;

}

add_shortcode( 'faq-plugin', 'toggle_shortcode' );

function faq_menu() {
	add_menu_page( 'FAQ', 'FAQ Plugin', 'manage_options', 'Faq_process', 'faqpage', '',98 );
	add_submenu_page( 'Faq_process', 'Manage Categories', 'Manage Categories','manage_options', 'Manage_Categories','managecategory'); 
	add_submenu_page( 'Faq_process', 'Manage FAQs', 'Manage FAQs','manage_options', 'Manage_FAQs','managefaqs'); 
}

add_action('admin_menu', 'faq_menu');

function faqpage()
{
	
	managecategory();

}

function managecategory()
{
	
	include_once(__DIR__.'/includes/common/header.php');

	if(!ISSET($_GET['action'])){
		include_once(__DIR__.'/includes/category/manage_category.php');
	}

	if(ISSET($_GET['action']) && $_GET['action'] == 'edit'){
		include_once(__DIR__.'/includes/category/edit_category.php');
	}

	if(ISSET($_GET['action']) && $_GET['action'] == 'add'){
		include_once(__DIR__.'/includes/category/add_category.php');
	}
	
	if(ISSET($_GET['action']) && $_GET['action'] == 'delete'){
		include_once(__DIR__.'/includes/category/delete_category.php');
	}

	include_once(__DIR__.'/includes/common/footer.php');

}

function managefaqs()
{
	
	include_once(__DIR__.'/includes/common/header.php');

	if(!ISSET($_GET['action'])){
		include_once(__DIR__.'/includes/faq/manage_faq.php');
	}

	if(ISSET($_GET['action']) && $_GET['action'] == 'edit'){
		include_once(__DIR__.'/includes/faq/edit_faq.php');
	}

	if(ISSET($_GET['action']) && $_GET['action'] == 'add'){
		include_once(__DIR__.'/includes/faq/add_faq.php');
	}
	
	if(ISSET($_GET['action']) && $_GET['action'] == 'delete'){
		include_once(__DIR__.'/includes/faq/delete_faq.php');
	}

	include_once(__DIR__.'/includes/common/footer.php');

}

?>