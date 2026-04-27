<?php
/**
 * The partials for displaying content for showcase templates
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Partials
 * @version 2.0.1
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
$banners            = carbon_get_the_post_meta( 'showcase_banner' );
$below_banners      = carbon_get_the_post_meta( 'showcase_below_banner' );
$before_info        = carbon_get_the_post_meta( 'showcase_before_info' );
$info_title         = carbon_get_the_post_meta( 'showcase_info_title' );
$info_image         = carbon_get_the_post_meta( 'showcase_info_image' );
$info_content       = carbon_get_the_post_meta( 'showcase_info_content' );
$info_button        = carbon_get_the_post_meta( 'showcase_info_button' );
$info_url           = carbon_get_the_post_meta( 'showcase_info_url' );
$nwl_title          = carbon_get_the_post_meta( 'nwl_title' );
$nwl_shortcode      = carbon_get_the_post_meta( 'nwl_shortcode' );
$nwl_below_content  = carbon_get_the_post_meta( 'nwl_below_content' );
$instagram_username = carbon_get_the_post_meta( 'instagram_username' );
$instagram_user_id  = carbon_get_the_post_meta( 'instagram_user_id' ); ?>
<?php if ( is_array( $banners ) && count( $banners ) > 0 ): ?>
    <div id="billboard" <?php echo is_array( $below_banners ) && count( $below_banners ) == 0 ? 'class="no-feature-content-below"' : ''; ?>>
        <div class="billboard-slider">
			<?php foreach ( $banners as $banner ): ?>
                <div class="billboard-slide-item">
					<?php if ( $banner['image'] != '' ): ?>
                        <div class="image-container">
							<?php echo wp_get_attachment_image( $banner['image'], 'full' ); ?>
                        </div>
					<?php endif; ?>
                    <div class="billboard-text">
						<?php echo apply_filters( 'the_content', $banner['content'] ); ?>
						<?php if ( $banner['url'] != '' ): ?>
                            <a href="<?php echo esc_url( $banner['url'] ) ?>" class="button arrow no-bg"></a>
                            <a href="<?php echo esc_url( $banner['url'] ) ?>"
                               class="button align-right"><?php echo esc_html( $banner['button'] ) ?></a>
						<?php endif; ?>
                    </div>
                </div>
			<?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
<?php if ( is_array( $below_banners ) && count( $below_banners ) > 0 ): ?>
    <div class="feature-products">
        <div class="row">
			<?php foreach ( $below_banners as $banner ): ?>
                <div class="column medium-6 small-12">
                    <div class="feature-product-block"
                         style="background-color:<?php echo esc_attr( $banner['bg_color'] ); ?>">
						<?php if ( $banner['image'] != '' ): ?>
                            <figure class="graphic-container">
								<?php echo wp_get_attachment_image( $banner['image'], 'full' ); ?>
                            </figure>
						<?php endif; ?>
                        <h3><?php echo wp_kses_post( $banner['title'] ); ?></h3>
						<?php if ( $banner['url'] != '' ): ?>
                            <a href="<?php echo esc_url( $banner['url'] ); ?>" class="button arrow no-bg"></a>
						<?php endif; ?>
                    </div>
                </div>
			<?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
<?php if ( is_array( $before_info ) && count( $before_info ) > 0 ): ?>
	<?php foreach ( $before_info as $info ): ?>
        <div class="container-box full-width <?php echo esc_attr( $info['class'] ); ?>">
            <div class="row">
				<?php echo '<span class="watermark-text">' . substr( get_the_title(), 0, 1 ) . '</span>'; ?>
				<?php if ( $info['image'] != '' ): ?>
                    <div class="image-container column medium-7">
						<?php echo wp_get_attachment_image( $info['image'], 'full' ); ?>
                    </div>
				<?php endif; ?>
                <div class="column editor-text medium-5">
                    <h2><?php echo wp_kses_post( $info['title'] ); ?></h2>
					<?php echo apply_filters( 'the_content', $info['content'] ); ?>
                </div>
            </div>
        </div>
	<?php endforeach; ?>
<?php endif; ?>
<?php if ( $info_content != '' ): ?>
    <div class="infographic-section">
        <div class="alphabet-watermark"><?php echo strtoupper( substr( esc_html( $info_title ), 0, 1 ) ); ?></div>
        <div class="row">
            <div class="section-title theme-color"><?php echo wp_kses_post( $info_title ); ?></div>
			<?php if ( $info_image != '' ): ?>
                <div class="product-container">
					<?php echo wp_get_attachment_image( $info_image, 'full' ); ?>
                </div>
			<?php endif; ?>
            <div class="column medium-5 editor-content">
				<?php echo apply_filters( 'the_content', $info_content ); ?>
				<?php if ( $info_url != '' ): ?>
                    <a href="<?php echo esc_url( $info_url ) ?>"
                       class="button theme-bg"><?php echo esc_html( $info_button ) ?></a>
				<?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ( $nwl_shortcode != '' ): ?>
    <div class="subscription-section">
        <div class="row align-center">
            <div class="column medium-8 small-12">
				<?php if ( $nwl_title != '' ): ?>
                    <h2><?php echo strip_tags( $nwl_title ); ?></h2>
				<?php endif; ?>
				<?php echo do_shortcode( $nwl_shortcode ); ?>
				<?php echo wpautop( strip_tags( $nwl_below_content ) ); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ( $instagram_username != '' && $instagram_user_id != '' ): ?>
    <div class="instagram-section">
        <div class="section-header">
            <div class="row">
                <span class="fa-instagram"></span> @<?php echo esc_html( $instagram_username ); ?>
            </div>
        </div>
        <div class="row extended">
			<?php echo do_shortcode( '[instagram-feed id="' . $instagram_user_id . '" num=36 cols=9 width=100 widthunit=%]' ); ?>
        </div>
    </div>
<?php endif; ?>