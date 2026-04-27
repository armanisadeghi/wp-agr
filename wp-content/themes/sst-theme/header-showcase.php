<?php
/**
 * The template for displaying header on SST Showcase Home 1 template
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 2.0.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

global $wp_query;
$post_id      = $wp_query->post->ID;
$prefix       = "_ttm";
$site_logo_id = (int) get_post_meta( $post_id, $prefix . "_home8_site_logo_id", 1 );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=no">
    <link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="page-wrapper" class="showcase-homepage1">
    <header id="page-header" itemscope itemtype="https://schema.org/Organization">
        <div class="row custom-holder align-justify">
			<?php if ( '' != get_theme_mod( 'custom_logo' ) ): ?>
                <div id="logo">
					<?php the_custom_logo(); ?>
                </div>
			<?php endif; ?>
			<?php
			$menu = wp_nav_menu( [
				'theme_location'  => 'main-nav',
				'fallback_cb'     => false,
				'menu_class'      => 'slimmenu',
				'menu_id'         => 'main-nav',
				'container'       => false,
				'container_class' => false,
				'echo'            => false,
			] ); ?>
            <nav class="page-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
				<?php if ( $menu ): echo $menu; endif; ?>
                <div class="header-widgets">
                    <div class="site-search">
                        <span class="icon-search fa fa-search" aria-hidden="true"></span>
                        <form class="search-box" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <input type="text" id="s" class="text-box" placeholder="Search Keyword" name="s"
                                   tabindex="1">
                        </form>
                    </div>
                </div>
            </nav>
        </div>
    </header>
