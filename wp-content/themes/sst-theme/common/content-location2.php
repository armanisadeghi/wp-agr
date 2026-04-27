<?php
/**
 * The partials for displaying second template for location list based on theme options
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Partials
 * @version 1.6.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
$sst_option       = get_option( 'sst_option' );
$location_title   = is_array( $sst_option ) && array_key_exists( 'location-default-title', $sst_option ) && $sst_option['location-default-title'] != '' ? $sst_option['location-default-title'] : 'Locations';
$location_content = is_array( $sst_option ) && array_key_exists( 'location-default-content', $sst_option ) ? $sst_option['location-default-content'] : '';
$location_url     = is_array( $sst_option ) && array_key_exists( 'location-top-url', $sst_option ) ? $sst_option['location-top-url'] : '/contact';
$location_button  = is_array( $sst_option ) && array_key_exists( 'location-top-url-text', $sst_option ) ? $sst_option['location-top-url-text'] : 'Contact us'; ?>
<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
<div class="billboard location2-banner">
    <div class="holder">
        <div class="location-title">
            <h1><?php echo esc_html( $location_title ); ?></h1>
            <a href="<?php echo esc_url( $location_url ); ?>"
               class="button primary"><?php echo esc_html( $location_button ); ?></a>
        </div>
		<?php if ( is_active_sidebar( 'location-search-widget' ) ):
			dynamic_sidebar( 'location-search-widget' );
		endif; ?>
    </div>
</div>
<div class="page-content fullwidth location2-container">
    <div class="holder">
        <article class="main-container">
            <div class="editor-content">
				<?php echo apply_filters( 'the_content', $location_content ); ?>
            </div>
        </article>
        <div class="locations-bottom">
			<?php if ( is_active_sidebar( 'location-widget' ) ):
				dynamic_sidebar( 'location-widget' );
			endif; ?>
        </div>
    </div>
</div>