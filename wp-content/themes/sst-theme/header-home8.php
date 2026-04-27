<?php
/**
 * The template for displaying header on SST Multi Block Feature template
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
$site_logo_id = (int) get_post_meta( $post_id, $prefix . "_home9_site_logo_id", 1 );
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
<div id="pg_wrapper" class="home8-container">
    <header id="page-header" itemscope itemtype="https://schema.org/Organization">
        <div class="holder custom-holder">
			<?php if ( '' != $site_logo_id ): ?>
                <a href="/" class="custom-logo-link" rel="home" itemprop="url">
					<?php echo wp_get_attachment_image( $site_logo_id, [ 232, 45 ] ); ?>
                </a>
			<?php else: ?>
				<?php if ( '' != get_theme_mod( 'custom_logo' ) ):
					the_custom_logo();
				endif; ?>
			<?php endif; ?>
			<?php
			do_action( 'mok_phone_number' );
			$menu = wp_nav_menu( [
				'theme_location'  => 'main-nav',
				'fallback_cb'     => false,
				'menu_class'      => 'slimmenu',
				'menu_id'         => 'main-nav',
				'container'       => false,
				'container_class' => false,
				'echo'            => false,
			] ); ?>
            <nav class="alignright page-navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
				<?php if ( $menu ) {
					echo $menu;
				} ?>
                <div class="site-search">
                    <span class="icon-search fa fa-search" aria-hidden="true"></span>

                    <form class="search-box" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <i class="fa fa-search" aria-hidden="true"></i>
                        <input type="text" id="s" class="text-box" placeholder="Search Keyword" name="s" tabindex="1">
                    </form>
                </div>
            </nav>
        </div>
    </header>
	<?php if ( is_post_type_archive( 'product' ) ):
		$shop_page = get_post( wc_get_page_id( 'shop' ) );
		if ( $shop_page && get_post_thumbnail_id( $shop_page ) != "" ) : ?>
            <div id="billboard">
                <ul class="slides">
                    <li>
                        <div class="image-container">
							<?php
							$image = wp_get_attachment_image_src( get_post_thumbnail_id( $shop_page ), 'full' ); ?>
                            <img src="<?php echo $image[0]; ?>" alt="Billboard Image"></div>
						<?php $description = wc_format_content( $shop_page->post_content );
						if ( $description ):
							?>
                            <div class="holder">
                                <div class="billboard-content alignleft">
									<?php echo $description; ?>
                                </div>
                            </div>
						<?php endif; ?>
                    </li>
                </ul>
            </div>
		<?php endif;
	endif; ?>
