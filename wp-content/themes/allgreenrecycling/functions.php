<?php
require 'helpers/helpers.php';
add_filter('sst_enqueue_parent_stylesheet', '__return_true');

if (!session_id()) {
    session_start();
}

if (!isset($_SESSION["refURL"])) {
    $params = [];
    if (isset($_SERVER["HTTP_REFERER"])) {
        $parse = parse_url($_SERVER["HTTP_REFERER"]);
        $_SESSION["refURL"] = $_SERVER["HTTP_REFERER"];
        $_SESSION["landingPage"] = get_site_url() . $_SERVER["REQUEST_URI"];
        parse_str($parse['query'], $params);
        foreach ($params as $key => $value) {
            if ($key == 'q' || $key == 'p')
                $_SESSION["keyword"] = $value;
        }
        if (isset($_SESSION["keyword"]) && strlen($_SESSION["keyword"]) < 3) {
            $_SESSION["keyword"] = "None Found";
        }
    }
}

/**
 * Redirect URLs with landing_page/keyword params to clean URLs
 * Placed AFTER session tracking to preserve tracking data
 * Added on 2026-01-27
 */
add_action('template_redirect', 'redirect_tracking_params_to_clean_url', 1);
function redirect_tracking_params_to_clean_url()
{
    // Only redirect if these specific parameters exist
    if (isset($_GET['landing_page']) || isset($_GET['keyword'])) {
        // Get clean URL without query string
        $clean_url = home_url(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        // 301 permanent redirect to clean URL
        wp_redirect($clean_url, 301);
        exit;
    }
}

/**
 * Populates job listings in gravity form
 *
 * @param $form
 *
 * @return mixed
 */
if (!function_exists('populate_jobs')) {
    function populate_jobs($form)
    {
        foreach ($form['fields'] as &$field) {
            if ($field->type != 'select' || strpos($field->cssClass, 'populate-jobs') === false) {
                continue;
            }

            $packages = new WP_Query(
                [
                    'post_status' => 'publish',
                    'post_type' => 'job',
                    'posts_per_page' => -1,
                ]
            );

            $choices = [];

            while ($packages->have_posts()):
                $packages->the_post();
                $choices[] = [
                    'text' => get_the_title(),
                    'value' => strtolower(get_the_title()),
                ];
            endwhile;

            $field->placeholder = 'Select Available Jobs';
            $field->choices = $choices;
        }
        return $form;
    }

    add_filter('gform_pre_render_17', 'populate_jobs');
    add_filter('gform_pre_validation_17', 'populate_jobs');
    add_filter('gform_pre_submission_filter_17', 'populate_jobs');
    add_filter('gform_admin_pre_render_17', 'populate_jobs');
}

/**
 * add conversion code for thank you page
 */
function mok_adword_webform()
{
    if (is_page([31084, 33316])): ?>
        <script>
            /* <![CDATA[ */
            var google_conversion_id = 1070150182;
            var google_conversion_language = "en";
            var google_conversion_format = "3";
            var google_conversion_color = "ffffff";
            var google_conversion_label = "1IWfCJ-giVsQpuSk_gM";
            var google_remarketing_only = false;
            /* ]]> */
        </script>
        <script src="//www.googleadservices.com/pagead/conversion.js"></script>
        <noscript>
            <div style="display:inline;">
                <img height="1" width="1" style="border-style:none;" alt=""
                    src="//www.googleadservices.com/pagead/conversion/1070150182/?label=1IWfCJ-giVsQpuSk_gM&amp;guid=ON&amp;script=0" />
            </div>
        </noscript>
        <?php
    endif;
}

add_action('wp_footer', 'mok_adword_webform', 999);
add_filter('gform_save_field_value', 'replace_text', 10, 3);
function replace_text($value, $entry, $field)
{
    if ($field->get_input_type() == 'textarea') {
        $value = preg_replace('/\s+/', ' ', $value);
    }
    return $value;
}

/****** Gp server cron ********/
function cron_gravity_gp_server()
{
    require 'cron/gp_cron.php';
}
add_action('gravity_gp_server', 'cron_gravity_gp_server', 10, 0);

function cron_gravity_gp_delete()
{
    require 'cron/gp_delete.php';
}
add_action('gravity_gp_delete', 'cron_gravity_gp_delete', 10, 0);

function nex_remove_type_attr($tag)
{
    return preg_replace("/type=['\"]text\/(javascript|css)['\"]/", '', $tag);
}
add_filter('script_loader_tag', 'nex_remove_type_attr', 10, 1);
add_filter('style_loader_tag', 'nex_remove_type_attr', 10, 1);

remove_filter('widget_text_content', 'wpautop');

/**
 * Different number of posts per page
 *
 * @param $query
 */
function mok_console_fix_per_page_filter($query)
{
    if (!is_admin() && $query->is_main_query()) {
        if (is_tag(['green', 'energy-tag', 'solar-power'])) {
            $query->set('posts_per_page', 6);
        }
        if (is_tag(['ewaste'])) {
            $query->set('posts_per_page', 9);
        }
        if (is_post_type_archive('our-events')) {
            $query->set('posts_per_page', 9);
        }
        if (is_category([1200, 'energy'])) {
            $query->set('posts_per_page', 27);
        }
        if (is_home()) {
            $query->set('posts_per_page', 27);
        }
    }
}
add_action('pre_get_posts', 'mok_console_fix_per_page_filter', 999);

add_filter('gform_twilio_message', 'change_message', 10, 4);
function change_message($args, $feed, $entry, $form)
{
    $entry['source_url'] = str_replace('http://www.', '', $entry['source_url']);
    $entry['source_url'] = str_replace('https://www.', '', $entry['source_url']);
    $entry['source_url'] = str_replace('http://', '', $entry['source_url']);
    $entry['source_url'] = str_replace('https://', '', $entry['source_url']);
    $args['body'] = str_replace('{embed_url}', '', $args['body']);
    $args['body'] .= $entry['source_url'];
    return $args;
}

/**
 * Block User Enumeration
 */
function nex_block_user_enumeration_attempts()
{
    if (is_admin()) {
        return;
    }

    $author_by_id = (isset($_REQUEST['author']) && is_numeric($_REQUEST['author']));

    if ($author_by_id) {
        wp_die('Author archives have been disabled.');
    }
}
add_action('template_redirect', 'nex_block_user_enumeration_attempts');

function ns_google_analytics()
{ ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-8989393-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'UA-8989393-2');
    </script>
    <?php
}
add_action('wp_head', 'ns_google_analytics', 10);

/* Insightly Code */
add_action('gform_after_submission', 'post_to_third_party', 10, 2);
function post_to_third_party($entry, $form)
{
    require_once get_theme_file_path('insightly/gravity-to-insightly.php');
}

function insightly_register_options_page()
{
    add_options_page('Page Title', 'Insightly Settings', 'manage_options', 'insightly-setting', 'insightly_options_page');
}
add_action('admin_menu', 'insightly_register_options_page');

function insightly_options_page()
{
    require_once get_theme_file_path('insightly/insightly-settings.php');
}

/*    Slow/LAGGY GF     */
/* Commented code on 18-10-2024 Starts Here */
/* add_action( 'gform_register_init_scripts_' . SLOW_FORM_ID, function( $form ) {
  // Do not void out on last page
  if ( rgpost( 'gform_target_page_number_' . SLOW_FORM_ID ) == SLOW_LAST_PAGE ) {
    return;
  }
  ?>
    <script type="text/javascript">
      // Into the void
      gformCalculateProductPrice = function() {};
    </script>
  <?php
} ); */
/* Commented code on 18-10-2024 Ends Here */

/*
 *  "Let Us Contact You" form new fields.
 */
add_filter('gform_pre_submission_12', 'pre_submission_handler');
function pre_submission_handler($form)
{
    $_POST['input_42'] = $form['title'];
}

add_filter('gform_pre_submission_11', 'pre_submission_handler11');
function pre_submission_handler11($form)
{
    $_POST['input_70'] = $form['title'];
}

add_filter('gform_field_value_landing_page', 'landing_page');
function landing_page($value)
{
    return $_SESSION["landingPage"];
}

add_filter('gform_field_value_keyword', 'keyword');
function keyword($value)
{
    return $_SESSION["keyword"];
}

add_filter('gform_field_value_ref_url', 'ref_url');
function ref_url($value)
{
    return $_SESSION["refURL"];
}

add_filter('gform_allowable_tags', '__return_true');

add_filter('gform_upload_path', 'change_upload_path', 10, 2);
function change_upload_path($path_info, $form_id)
{
    $path_info['path'] = '/home/steve/public_html/wp-content/uploads/gravity_forms';
    $path_info['url'] = 'https://allgreenrecycling.com/wp-content/uploads/gravity_forms/';
    return $path_info;
}

add_filter('rank_math/sitemap/enable_caching', '__return_false');
add_filter('rank_math/sitemap/entry', function ($url) {
    if (isset($url['loc']) && empty($url['loc'])) {
        return false;
    }return $url;
});

update_option('siteurl', 'https://allgreenrecycling.com');
update_option('home', 'https://allgreenrecycling.com');

add_filter('rank_math/snippet/rich_snippet_videoobject_entity', function ($entity) {
    if (empty($entity['uploadDate'])) {
        return $entity;
    }

    $parts = explode('T', $entity['uploadDate']);
    if (!empty($parts[1])) {
        return $entity;
    }

    $entity['uploadDate'] = wp_date('Y-m-d\TH:i:sP', strtotime($entity['uploadDate']));

    return $entity;
});

/* Added on 26-07-2024 */
function add_custom_canonical_and_pagination_links()
{
    // Check if we are on a paginated page
    if (is_home() || is_archive() || is_category() || is_tag()) {
        global $paged, $wp_query;

        // Get the current page number
        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }

        // Get the base URL for the canonical link
        $canonical_url = get_pagenum_link(1);

        // Add canonical URL for the first page
        if ($paged > 1) {
            echo '<link rel="canonical" href="' . esc_url(get_pagenum_link($paged)) . '" />' . "\n";
        } else {
            // echo '<link rel="canonical" href="' . esc_url(get_pagenum_link($paged)) . '" />' . "\n";
        }

        // Add rel="prev" link if not on the first page
        if ($paged > 1) {
            echo '<link rel="prev" href="' . esc_url(get_pagenum_link($paged - 1)) . '" />' . "\n";
        }

        // Add rel="next" link if not on the last page
        if ($paged < $wp_query->max_num_pages && $paged != 1) {
            echo '<link rel="next" href="' . esc_url(get_pagenum_link($paged + 1)) . '" />' . "\n";
        }
    }
}
add_action('wp_head', 'add_custom_canonical_and_pagination_links', 5);

/* add_action('init', 'test_my_db');
function test_my_db() {
    if(isset($_GET['test']) && $_GET['test'] == 1){

        // echo 'Hello world: '.site_url(). $_SERVER['REQUEST_URI'];
        // echo'<pre>';print_r($_SERVER);echo'</pre>';
        try {
            // Define your remote database connection details
            $dsn = 'mysql:host=allgreen.cmsfg3ols5pn.us-west-2.rds.amazonaws.com;dbname=allgreendb;charset=utf8mb4';
            $username = 'root';
            $password = 'ggA7LRiSrwis';

            // Create a new PDO instance
            $leads_db = new PDO($dsn, $username, $password, [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            if ($leads_db) {
                try {
                    $stmt = $leads_db->prepare('SELECT * FROM tblprocurementleads ORDER BY id DESC LIMIT 50');
                    $stmt->execute();
                    $leads = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    echo '<pre>';
                    print_r($leads);
                    echo '</pre>';
                } catch (PDOException $e) {
                    echo 'Query failed: ' . $e->getMessage();
                }
            }

            exit;
            return $leads_db; // Return the PDO instance for future use

        } catch (PDOException $e) {
            // If there's an error, catch it and display the message
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
} */