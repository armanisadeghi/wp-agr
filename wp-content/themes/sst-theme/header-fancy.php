<?php
/**
 * The template for displaying header on SST Standard Page w/ Sub Buttons template
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
<div id="main_wrapper">
    <header id="page-header" itemscope itemtype="https://schema.org/Organization">
        <div class="holder">
			<?php if ( '' != get_theme_mod( 'custom_logo' ) ):
				the_custom_logo();
			endif; ?>
			<?php do_action( 'mok_phone_number' ); ?>
			<?php $menu = wp_nav_menu( [
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
            </nav>
        </div>
    </header>

	<?php
	if ( is_post_type_archive( 'product' ) ):
	$shop_page = get_post( wc_get_page_id( 'shop' ) );
	if ( $shop_page ) : ?>
    <div id="billboard">
        <ul class="slides">
            <li>
                <div class="image-container">
					<?php
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $shop_page ), 'full' ); ?>
                    <img src="<?php echo $image[0]; ?>" alt="Billboard Image"></div>
				<?php $description = wc_format_content( $shop_page->post_content );
				if ( $description ): ?>
                    <div class="holder">
                        <div class="billboard-content">
							<?php echo $description; ?>
                        </div>
                    </div>
				<?php endif; ?>
            </li>
        </ul>
    </div>
<?php endif;
endif; ?>