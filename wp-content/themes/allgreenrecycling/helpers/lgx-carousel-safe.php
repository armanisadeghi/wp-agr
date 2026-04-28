<?php
/**
 * Safe fallback for LGX Owl Carousel plugin.
 *
 * Keeps the [lgx-carousel] shortcode working from child theme so the vulnerable
 * plugin can be removed without breaking homepage/client-logo carousel output.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register fallback CPT/taxonomy only when plugin is not active.
 */
add_action('init', function () {
    if (post_type_exists('lgxcarousel')) {
        return;
    }

    $labels = [
        'name'               => __('Owl Carousels', 'allgreenrecycling'),
        'singular_name'      => __('Owl Carousel', 'allgreenrecycling'),
        'menu_name'          => __('Owl Carousel', 'allgreenrecycling'),
        'all_items'          => __('All Items', 'allgreenrecycling'),
        'view_item'          => __('View Item', 'allgreenrecycling'),
        'add_new_item'       => __('Add New Carousel Item', 'allgreenrecycling'),
        'add_new'            => __('Add New', 'allgreenrecycling'),
        'edit_item'          => __('Edit Carousel Item', 'allgreenrecycling'),
        'update_item'        => __('Update Carousel Item', 'allgreenrecycling'),
        'search_items'       => __('Search Carousel', 'allgreenrecycling'),
        'not_found'          => __('No Carousel items found', 'allgreenrecycling'),
        'not_found_in_trash' => __('No Carousel items found in trash', 'allgreenrecycling'),
    ];

    register_post_type('lgxcarousel', [
        'label'               => __('Carousel Slider', 'allgreenrecycling'),
        'description'         => __('Owl Carousel Slider Post Type', 'allgreenrecycling'),
        'labels'              => $labels,
        'supports'            => ['title', 'editor', 'thumbnail'],
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 25,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    ]);

    register_taxonomy('lgxcarouselcat', ['lgxcarousel'], [
        'hierarchical'      => true,
        'label'             => __('Categories', 'allgreenrecycling'),
        'show_ui'           => true,
        'query_var'         => true,
        'show_admin_column' => true,
        'singular_label'    => __('Category', 'allgreenrecycling'),
    ]);
});

/**
 * Convert "yes"/"no" style values to booleans.
 */
function agr_lgx_to_bool($value, $default = false)
{
    if (is_bool($value)) {
        return $value;
    }

    $value = strtolower(trim((string) $value));
    if ($value === '') {
        return $default;
    }

    if (in_array($value, ['1', 'true', 'yes', 'on'], true)) {
        return true;
    }
    if (in_array($value, ['0', 'false', 'no', 'off'], true)) {
        return false;
    }

    return $default;
}

/**
 * Build safe rgba from theme/plugin-like values.
 */
function agr_lgx_hex_to_rgba($hex, $opacity = 1)
{
    $hex = trim((string) $hex);
    if ($hex === '' || strtolower($hex) === 'transparent') {
        return 'rgba(0,0,0,0)';
    }

    $hex = ltrim($hex, '#');
    if (!preg_match('/^([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/', $hex)) {
        return 'rgba(0,0,0,0)';
    }

    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }

    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    $a = max(0, min(1, (float) $opacity));

    return "rgba({$r},{$g},{$b},{$a})";
}

/**
 * Enqueue dependencies only when shortcode is rendered.
 */
function agr_lgx_enqueue_assets()
{
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;

    wp_enqueue_style(
        'agr-owl-carousel',
        'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css',
        [],
        '2.3.4'
    );
    wp_enqueue_style(
        'agr-owl-carousel-theme',
        'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css',
        ['agr-owl-carousel'],
        '2.3.4'
    );

    wp_enqueue_script(
        'agr-owl-carousel',
        'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js',
        ['jquery'],
        '2.3.4',
        true
    );

    $inline_css = <<<'CSS'
.lgx-carousel-section .owl-nav {
  position: absolute;
  inset: 0;
  pointer-events: none;
}
.lgx-carousel-section .lgx-carousel {
  padding-left: 30px;
  padding-right: 30px;
}
.lgx-carousel-section .owl-nav button.owl-prev,
.lgx-carousel-section .owl-nav button.owl-next {
  pointer-events: auto;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 34px;
  height: 34px;
  border: 0;
  border-radius: 50%;
  background: rgba(0, 0, 0, 0.55) !important;
  color: #fff !important;
  font-size: 26px !important;
  line-height: 34px !important;
  text-align: center;
  padding: 0 !important;
  margin: 0 !important;
}
.lgx-carousel-section .owl-nav button.owl-prev { left: -18px; }
.lgx-carousel-section .owl-nav button.owl-next { right: -18px; }
.lgx-carousel-section .owl-nav button.owl-prev span,
.lgx-carousel-section .owl-nav button.owl-next span {
  display: inline-block;
  line-height: 1;
  transform: translateY(-1px);
}
@media (max-width: 991px) {
  .lgx-carousel-section .lgx-carousel {
    padding-left: 22px;
    padding-right: 22px;
  }
  .lgx-carousel-section .owl-nav button.owl-prev { left: 4px; }
  .lgx-carousel-section .owl-nav button.owl-next { right: 4px; }
}
CSS;
    wp_add_inline_style('agr-owl-carousel-theme', $inline_css);

    $inline_js = <<<'JS'
jQuery(function($){
  $('.lgx-carousel').each(function(){
    var $item = $(this);
    if ($item.hasClass('owl-loaded')) {
      return;
    }
    var d = $item.data();
    $item.owlCarousel({
      loop: !!d.loop,
      dots: !!d.dots,
      autoplay: !!d.autoplay,
      lazyLoad: !!d.lazyload,
      autoplayTimeout: parseInt(d.autoplaytimeout || 5000, 10),
      margin: parseInt(d.margin || 10, 10),
      nav: !!d.nav,
      autoplayHoverPause: !!d.autoplayhoverpause,
      smartSpeed: parseInt(d.smartspeed || 500, 10),
      slideSpeed: parseInt(d.slidespeed || 200, 10),
      paginationSpeed: parseInt(d.paginationspeed || 800, 10),
      rewindSpeed: parseInt(d.rewindspeed || 1000, 10),
      navText: ['<span aria-hidden="true">&#10094;</span>','<span aria-hidden="true">&#10095;</span>'],
      responsive: {
        0: { items: parseInt(d.itemmobile || 1, 10), nav: !!d.navmobile },
        768: { items: parseInt(d.itemtablet || 1, 10), nav: !!d.navtablet },
        992: { items: parseInt(d.itemdesk || 1, 10), nav: !!d.navdesk },
        1200: { items: parseInt(d.itemlarge || 1, 10), nav: !!d.navlarge }
      }
    });
  });
});
JS;
    wp_add_inline_script('agr-owl-carousel', $inline_js);
}

/**
 * Keep the same shortcode name: [lgx-carousel].
 * Also supports old attr alias "category" => "cat".
 */
add_action('init', function () {
    if (shortcode_exists('lgx-carousel')) {
        return;
    }

    add_shortcode('lgx-carousel', function ($atts = []) {
        agr_lgx_enqueue_assets();

        $basic = (array) get_option('lgxowl_basic', []);
        $config = (array) get_option('lgxowl_config', []);
        $responsive = (array) get_option('lgxowl_responsive', []);
        $style = (array) get_option('lgxowl_style', []);

        $defaults = [
            'cat'              => $basic['lgxowl_settings_cat'] ?? '',
            'category'         => '',
            'order'            => $basic['lgxowl_settings_order'] ?? 'DESC',
            'orderby'          => $basic['lgxowl_settings_orderby'] ?? 'date',
            'limit'            => $basic['lgxowl_settings_limit'] ?? -1,
            'color'            => $style['lgxowl_settings_color'] ?? '#333333',
            'bgcolor'          => $style['lgxowl_settings_bgcolor'] ?? '#000000',
            'bgopacity'        => $style['lgxowl_settings_bgopacity'] ?? 0,
            'bgimage'          => $style['lgxowl_settings_bgimage'] ?? '',
            'itembg'           => $style['lgxowl_settings_itembg'] ?? 'no',
            'margin'           => $config['lgxowl_settings_margin'] ?? 10,
            'loop'             => $config['lgxowl_settings_loop'] ?? 'yes',
            'nav'              => $config['lgxowl_settings_nav'] ?? 'yes',
            'dots'             => $config['lgxowl_settings_dots'] ?? 'no',
            'autoplay'         => $config['lgxowl_settings_autoplay'] ?? 'yes',
            'autoPlay'         => '',
            'autoplay_timeout' => $config['lgxowl_settings_autoplay_timeout'] ?? 5000,
            'hover_pause'      => $config['lgxowl_settings_hover_pause'] ?? 'no',
            'lazyload'         => $config['lgxowl_settings_lazyload'] ?? 'no',
            'smartspeed'       => $config['lgxowl_settings_autoplay_smartspeed'] ?? 500,
            'slidespeed'       => $config['lgxowl_settings_autoplay_slidespeed'] ?? 200,
            'paginationspeed'  => $config['lgxowl_settings_autoplay_paginationspeed'] ?? 800,
            'rewindspeed'      => $config['lgxowl_settings_autoplay_rewindspeed'] ?? 1000,
            'itemlarge'        => $responsive['lgxowl_settings_largedesktop_item'] ?? 4,
            'itemdesk'         => $responsive['lgxowl_settings_desktop_item'] ?? 3,
            'itemtablet'       => $responsive['lgxowl_settings_tablet_item'] ?? 2,
            'itemmobile'       => $responsive['lgxowl_settings_mobile_item'] ?? 1,
            'navlarge'         => $responsive['lgxowl_settings_largedesktop_nav'] ?? 'yes',
            'navdesk'          => $responsive['lgxowl_settings_desktop_nav'] ?? 'yes',
            'navtablet'        => $responsive['lgxowl_settings_tablet_nav'] ?? 'yes',
            'navmobile'        => $responsive['lgxowl_settings_mobile_nav'] ?? 'yes',
        ];

        $atts = shortcode_atts($defaults, (array) $atts, 'lgx-carousel');

        if (!empty($atts['category']) && empty($atts['cat'])) {
            $atts['cat'] = $atts['category'];
        }
        if ($atts['autoPlay'] !== '') {
            $atts['autoplay'] = $atts['autoPlay'];
        }

        $order = strtoupper((string) $atts['order']) === 'ASC' ? 'ASC' : 'DESC';
        $allowed_orderby = ['date', 'title', 'menu_order', 'rand', 'ID', 'modified'];
        $orderby = in_array((string) $atts['orderby'], $allowed_orderby, true) ? (string) $atts['orderby'] : 'date';
        $limit = (int) $atts['limit'];
        if ($limit === 0) {
            $limit = -1;
        }

        $query_args = [
            'post_type'           => 'lgxcarousel',
            'post_status'         => 'publish',
            'posts_per_page'      => $limit,
            'order'               => $order,
            'orderby'             => $orderby,
            'no_found_rows'       => true,
            'ignore_sticky_posts' => true,
        ];

        $cat = sanitize_text_field((string) $atts['cat']);
        if ($cat !== '') {
            $slugs = array_filter(array_map('trim', explode(',', $cat)));
            if (!empty($slugs)) {
                $query_args['tax_query'] = [[
                    'taxonomy' => 'lgxcarouselcat',
                    'field'    => 'slug',
                    'terms'    => $slugs,
                ]];
            }
        }

        $loop = new WP_Query($query_args);
        if (!$loop->have_posts()) {
            wp_reset_postdata();
            return '';
        }

        $data = [
            'margin'            => (int) $atts['margin'],
            'loop'              => agr_lgx_to_bool($atts['loop'], true),
            'nav'               => agr_lgx_to_bool($atts['nav'], true),
            'dots'              => agr_lgx_to_bool($atts['dots'], false),
            'autoplay'          => agr_lgx_to_bool($atts['autoplay'], true),
            'autoplaytimeout'   => (int) $atts['autoplay_timeout'],
            'lazyload'          => agr_lgx_to_bool($atts['lazyload'], false),
            'autoplayhoverpause'=> agr_lgx_to_bool($atts['hover_pause'], false),
            'smartspeed'        => (int) $atts['smartspeed'],
            'slidespeed'        => (int) $atts['slidespeed'],
            'paginationspeed'   => (int) $atts['paginationspeed'],
            'rewindspeed'       => (int) $atts['rewindspeed'],
            'itemlarge'         => max(1, (int) $atts['itemlarge']),
            'itemdesk'          => max(1, (int) $atts['itemdesk']),
            'itemtablet'        => max(1, (int) $atts['itemtablet']),
            'itemmobile'        => max(1, (int) $atts['itemmobile']),
            'navlarge'          => agr_lgx_to_bool($atts['navlarge'], true),
            'navdesk'           => agr_lgx_to_bool($atts['navdesk'], true),
            'navtablet'         => agr_lgx_to_bool($atts['navtablet'], true),
            'navmobile'         => agr_lgx_to_bool($atts['navmobile'], true),
        ];

        $data_attrs = '';
        foreach ($data as $k => $v) {
            $value = is_bool($v) ? ($v ? 'true' : 'false') : (string) $v;
            $data_attrs .= ' data-' . esc_attr($k) . '="' . esc_attr($value) . '"';
        }

        $bg_image = esc_url((string) $atts['bgimage']);
        $section_style = $bg_image !== '' ? ' style="background-image:url(' . $bg_image . ');"' : '';
        $inner_style = ' style="background-color:' . esc_attr(agr_lgx_hex_to_rgba((string) $atts['bgcolor'], (float) $atts['bgopacity'])) .
            ';color:' . esc_attr((string) $atts['color']) . ';"';

        ob_start();
        ?>
        <div class="lgx-carousel-section"<?php echo $section_style; ?>>
            <div class="lgx-section-inner"<?php echo $inner_style; ?>>
                <div class="lgx-carousel-wrapper">
                    <div class="lgx-carousel owl-carousel owl-theme"<?php echo $data_attrs; ?>>
                        <?php
                        $use_item_bg = agr_lgx_to_bool($atts['itembg'], false);
                        while ($loop->have_posts()) :
                            $loop->the_post();
                            $item_style = '';
                            if ($use_item_bg && has_post_thumbnail()) {
                                $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                                if (!empty($thumb[0])) {
                                    $item_style = ' style="background-image:url(' . esc_url($thumb[0]) . ');"';
                                }
                            }
                            ?>
                            <div class="item lgx-item"<?php echo $item_style; ?>>
                                <?php
                                $content = get_post_field('post_content', get_the_ID());
                                echo do_shortcode(wp_kses_post($content));
                                ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        wp_reset_postdata();

        return trim((string) ob_get_clean());
    });
});
