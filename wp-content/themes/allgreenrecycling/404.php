<?php
/**
 * The template for displaying 404 pages
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.4.4
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
get_header();
$post_id       = 36891;
$banners       = get_post_meta( $post_id, '_ttm_banner_slider_group', 1 );
$service_title = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_service_title', 1 ) );
$services      = get_post_meta( $post_id, '_ttm_thank_you_services_group', 1 ); 
?>
<?php if ( is_array( $banners ) && array_key_exists( '_ttm_banner_slider_img_id', $banners[0] ) ): ?>
<div id="billboard" class="banner-holder" data-info="test">
    <div class="slides slick-slider">
        <?php foreach ( $banners as $banner ): ?>
            <?php if ( $banner['_ttm_banner_slider_img_id'] != "" ) : ?>
                <div style="background-image: url(<?php echo wp_get_attachment_image_url( $banner['_ttm_banner_slider_bg_id'], 'full' ); ?>)">
                    <div class="bg-container">
                        <?php echo wp_get_attachment_image( $banner['_ttm_banner_slider_bg_id'], 'full' ); ?>
                    </div>
                    <?php if ( '' != $banner['_ttm_banner_slider_content'] || '' != $banner['_ttm_banner_slider_btn_txt'] || '' != $banner['_ttm_banner_slider_btn_url'] ): ?>
                        <div class="holder">
                            <figure>
                                <?php echo wp_get_attachment_image( $banner['_ttm_banner_slider_img_id'], 'full' ); ?>
                            </figure>
                            <div class="billboard-content">
                                <div class="detail">
                                    <?php echo apply_filters( 'the_content', $banner['_ttm_banner_slider_content'] ); ?>
                                    <?php if ( '' != $banner['_ttm_banner_slider_btn_txt'] || '' != $banner['_ttm_banner_slider_btn_url'] ): ?>
                                        <br/>
                                        <a href="<?php echo esc_url( $banner['_ttm_banner_slider_btn_url'] ); ?>"
                                        class="button color1"><?php echo wp_strip_all_tags( $banner['_ttm_banner_slider_btn_txt'] ); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div><!-- Billboard Container -->
<?php endif; ?>

<h2 class="services-titled">Find Whatever You Are Looking For</h2>
<?php echo do_shortcode( "[services]" ); ?>

<?php get_footer(); ?>