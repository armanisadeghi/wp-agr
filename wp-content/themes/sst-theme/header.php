<?php
/**
 * The template for displaying header on every page
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.4.4
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
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
<div id="pg_wrapper">
    <header id="page-header" itemscope itemtype="https://schema.org/Organization">
        <div class="holder">
			<!--<a href="https://sustainableelectronics.org/" target="_blank"><img class="header-logos" src="https://allgreenrecycling.com/wp-content/uploads/2023/09/We-Are-R2V3-Certified-1.png" alt="R2V3 certification logo" width="55" height="55"></a>
			<a href="https://isigmaonline.org/certifications/naid-aaa-certification/" target="_blank"><img class="header-logos" src="https://allgreenrecycling.com/wp-content/uploads/2023/09/NaidLogo.png" alt="NAID AAA certification logo" width="55" height="55"></a>-->
			<?php if ( '' != get_theme_mod( 'custom_logo' ) ):
				the_custom_logo();
			endif;
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
            <nav class="alignright page-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
				<?php if ( $menu ):
					echo $menu;
				endif; ?>
                <div class="site-search">
                <span class="icon-search">
                    O\ 
                </span>
                    <form class="search-box" action="<?php echo esc_url( home_url( '/' ) ); ?>">
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
							<?php echo wp_get_attachment_image( get_post_thumbnail_id( $shop_page ), 'full' ); ?>
                        </div>
						<?php $description = wc_format_content( $shop_page->post_content );
						if ( $description ):?>
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