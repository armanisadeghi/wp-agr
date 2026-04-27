<?php
/**
 * List of all custom hooks used for styling purpose only
 *
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Framework
 * @version 2.0.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

/**
 * Change home page theme color based on selection in post meta
 */
function mok_home_theme_style() {
	global $wp_query;
	if ( is_page_template( [ 'templates/template-sst_home.php', 'templates/template-sst_home1.php' ] ) ):
		$post_id           = $wp_query->post->ID;
		$theme_enable      = get_post_meta( $post_id, '_qwl_page_theme_color_enabler', 1 );
		$theme_color       = get_post_meta( $post_id, '_qwl_page_theme_color', 1 );
		$theme_hover_color = get_post_meta( $post_id, '_qwl_page_theme_hover_color', 1 );
		$theme_color       = $theme_color != '' ? $theme_color : '#C48F29';
		$theme_hover_color = $theme_hover_color != '' ? $theme_hover_color : '#d49d32';
		if ( $theme_enable ):
			$styles = <<<CODE
				#billboard .billboard-content h1, #billboard .billboard-content h2, #billboard .billboard-content h3, 
				#billboard .billboard-content.alignleft h1 em, #billboard .billboard-content.alignleft h2 em, #billboard .billboard-content.alignleft h3 em, #billboard .billboard-content.alignleft h4 em, #billboard .billboard-content.alignleft h5 em,
				.goodie-bar p strong,
				.widget-testimonial .testimonial-summary,
				.section.title-theme-color h1, .section.title-theme-color h2, .section.title-theme-color h3, .section.title-theme-color h4, .section.title-theme-color h5,
				.col3-container .col h3, .col4-container .col h3,
				#page-footer .footer-title, #page-footer h2, #page-footer h3, #page-footer h4, .as-seen-on .holder h3, .as-seen-on .holder h4, .as-seen-on .holder > p, .companyinfo-section .detail a, .companyinfo-section .detail h2, .companyinfo-section .detail h3, .companyinfo-section .detail h4, .companyinfo-section p a, .copyright-section a, .copyright-section span:first-of-type, .sidebar a.link-more:after,
				.col3-container .col h2, .col3-container .col h3, .col4-container .col h2, .col4-container .col h3,
                .sidebar .widget-location-lists-class ul li .fa,
                .sidebar .widget-location-lists-class ul a p,
                .section.companyinfo-section .detail h2, 
                .section.companyinfo-section .detail h3, 
                .section.companyinfo-section .detail h4,
                .section.companyinfo-section .detail a, 
                .section.companyinfo-section p a,
                #billboard .billboard-content.alignleft h1, 
                #billboard .billboard-content.alignleft h2, 
                #billboard .billboard-content.alignleft h3{
					color: {$theme_color};
				}

				#billboard .billboard-content h1:after, 
				#billboard .billboard-content h2:after, 
				#billboard .billboard-content h3:after,
				#billboard .billboard-content h4:after,
				#billboard .billboard-content h5:after,
				 h1:after, 
				 h2:after, 
				 h3.widget-title:after, 
				 h3:after, 
				 h4:after,
				 .section.companyinfo-section,
                #billboard .billboard-content.alignleft h1:after, 
                #billboard .billboard-content.alignleft h2:after, 
                #billboard .billboard-content.alignleft h3:after{
					background-color: {$theme_hover_color};
				}

				.limit-locations #billboard .billboard-content a.color1.view-all, .location-wrapper .billboard #billboard .billboard-content .detail a.color1, #billboard .billboard-content .limit-locations a.color1.view-all, #billboard .billboard-content a.button.color1, #billboard .location-wrapper .billboard .billboard-content .detail a.color1,
				.limit-locations a.color1.view-all, .limit-locations a.view-all, 
				.location-wrapper .billboard .billboard-content .detail a, .location-wrapper .billboard .billboard-content .detail a.color1, .button.color1, .button.primary, .limit-locations a.color1.view-all, .limit-locations a.view-all, .location-wrapper .billboard .billboard-content .detail a, 
				.location-wrapper .billboard .billboard-content .detail a.color1,
				  .sidebar .widget.light .gform_wrapper input[type=submit].gform_button, 
				  .sidebar .widget.light h1:after, 
				  .sidebar .widget.light h2:after, 
				  .sidebar .widget.light h3:after, 
				  .sidebar .widget.light h4:after,
				  #popup-form .consultation_wrapper input.color1[type=submit], 
				  #popup-form .consultation_wrapper input.primary[type=submit], 
				  .button.color1, 
				  .button.primary, 
				  .consultation_wrapper input.color1[type=submit], 
				  .consultation_wrapper input.primary[type=submit], 
				  .location-wrapper .billboard .billboard-content .detail a, 
				  .location-wrapper .billboard .billboard-content .detail a.color1, 
				  .location-wrapper .billboard .billboard-content .detail a:visited, 
				  .location-wrapper .billboard .billboard-content .detail a:visited.color1, 
				  .widget-consultation-form input.color1[type=submit], 
				  .widget-consultation-form input.primary[type=submit], 
				  a.button.color1, 
				  a.button.primary, 
				  a.button:visited.color1, 
				  a.button:visited.primary,
				  .page-content.speaker-section{
					background-color: {$theme_hover_color};
					color: #fff
				}

				.limit-locations #billboard .billboard-content a.color1.view-all:hover, .location-wrapper .billboard #billboard .billboard-content .detail a.color1:hover, #billboard .billboard-content .limit-locations a.color1.view-all:hover, #billboard .billboard-content a.button.color1:hover, #billboard .location-wrapper .billboard .billboard-content .detail a.color1:hover,
				.limit-locations a.color1.view-all:hover, .limit-locations a.view-all:hover, .location-wrapper .billboard .billboard-content .detail a.color1:hover, .location-wrapper .billboard .billboard-content .detail a:hover, .button.color1:hover, .button.primary:hover, .limit-locations a.color1.view-all:hover, .limit-locations a.view-all:hover, .location-wrapper .billboard .billboard-content .detail a.color1:hover, .location-wrapper .billboard .billboard-content .detail a:hover, h1:after, h2:after, h3.widget-title:after, h3:after, h4:after
				.bg-theme-color, .newsletter-subscription input[type=submit], .page-content.fullwidth.speaker-section, .page-template-template-qwl_home1 .page-content.fullwidth.speaker-section, .widget_mc4wp_form_widget input[type=submit],
				h1:after, h2:after, h3.widget-title:after, h3:after, h4:after {
					background-color: {$theme_color};
				}

				.col4-container .holder a:hover {
					text-decoration: none
				}

				.editor-content a,
				.editor-content a:hover, 
				.editor-content a:visited, 
				.main-container a:hover, 
				.main-container a:visited{
					color: {$theme_hover_color}
				}

				.widget-consultation-form .gform_wrapper .gform_footer:last-child input, 
				.widget-read-more .textwidget, 
				.widget-read-more .widget-entry, 
				.widget-read-more > div,
				.newsletter-subscription input[type=submit], 
				.widget_mc4wp_form_widget input[type=submit],
				.section.companyinfo-section .detail h2:after, 
				.section.companyinfo-section .detail h3:after, 
				.section.companyinfo-section .detail h4:after{
					background-color: {$theme_hover_color}
				}

				article.col .icon-holder, div.col .icon-holder, li.col .icon-holder {
					border-color: {$theme_color};
				}
				.mejs-container .mejs-controls .mejs-play button:before,
				.mejs-container .mejs-controls .mejs-mute button:before, 
				.mejs-container .mejs-controls .mejs-unmute button:before{
					border-color: {$theme_color};
					color:  {$theme_color};
				}
CODE;
			wp_add_inline_style( 'sst-child', $styles );
		endif;
	endif;
}

add_action( 'wp_enqueue_scripts', 'mok_home_theme_style', 99 );

/**
 * Change landing page 1 theme color based on selection in post meta
 */
function mok_landing_page1_style() {
	$styles = '';
	if ( is_page_template( [ 'templates/template-sst_landing_page1.php' ] ) ):
		global $wp_query;
		$post_id         = $wp_query->post->ID;
		$title_color     = get_post_meta( $post_id, '_ttm_landing1_title_color', 1 ) != '' ? esc_html( get_post_meta( $post_id, '_ttm_landing1_title_color', 1 ) ) : '#1c9bf1';
		$fancy_btn_color = get_post_meta( $post_id, '_ttm_landing1_button_color', 1 ) != '' ? esc_html( get_post_meta( $post_id, '_ttm_landing1_button_color', 1 ) ) : '#f99a48';
		$styles          = <<<STYLES
<style>
    .fancy-button,
    .fancy-button:after, 
    .fancy-button:before{
        background-color: {$fancy_btn_color};
    }
    .fancy-button:hover,
    .fancy-button:hover:after, 
    .fancy-button:hover:before{
        background-color: {$fancy_btn_color};
        opacity: 0.8;
    }
    .landing-page-wrapper #verticalTab .button.active,
    .landing-page-wrapper #verticalTab .button:hover{
        background-color: {$fancy_btn_color};
        color: #ffffff;
    }
    .fancy-button i:after, 
    .fancy-button i:before{
        background-color: {$title_color} 
    }
    .fancy-button:hover i:after, 
    .fancy-button:hover i:before,
    .landing-page-wrapper .resp-tabs-list .resp-tab-active .img-inner{
        background-color: {$title_color};
    }
    
    .landing-page-wrapper .page-content h1, 
    .landing-page-wrapper .page-content h2, 
    .landing-page-wrapper .page-content h3, 
    .landing-page-wrapper .page-content h4, 
    .landing-page-wrapper .page-content h5, 
    .landing-page-wrapper .page-content h6,
    .landing-page-wrapper .thumbs-group p,
    .landing-page-wrapper #verticalTab .resp-tab-active [class*="-title"], 
    .landing-page-wrapper #verticalTab1 .resp-tab-active [class*="-title"]{
        color: {$title_color};
        }
        
    .landing-page-wrapper .page-content .two-cols h1, 
    .landing-page-wrapper .page-content .two-cols h2, 
    .landing-page-wrapper .page-content .two-cols h3, 
    .landing-page-wrapper .page-content .two-cols h4, 
    .landing-page-wrapper .page-content .two-cols h5{
        color: {$fancy_btn_color};
    }
    .landing-page-wrapper #verticalTab ul.resp-tabs-list .resp-tab-active figure, 
    .landing-page-wrapper #verticalTab1 ul.resp-tabs-list .resp-tab-active figure{
        box-shadow: 0 0 1px 0 {$title_color} ;
    }
</style>
STYLES;
	endif;

	echo $styles;
}

add_action( 'wp_head', 'mok_landing_page1_style', 99 );

/**
 * Change landing page 2 theme color based on selection in post meta
 */
function mok_landing_page2_style() {
	$styles = '';
	if ( is_page_template( [ 'templates/template-sst_landing_page2.php' ] ) ):
		global $wp_query;
		$post_id                   = $wp_query->post->ID;
		$billboard_brand_watermark = wp_get_attachment_image_src( (int) get_post_meta( $post_id, '_ttm_landing_theme_billboard_watermark_id', 1 ), 'full' )[0];
		$footer_brand_watermark    = wp_get_attachment_image_src( (int) get_post_meta( $post_id, '_ttm_landing_theme_footer_watermark_id', 1 ), 'full' )[0];
		$theme_color               = get_post_meta( $post_id, '_ttm_landing_theme_color', 1 ) != '' ? esc_html( get_post_meta( $post_id, '_ttm_landing_theme_color', 1 ) ) : '#1c9bf1';
		$indicator_icon            = wp_get_attachment_image_src( (int) get_post_meta( $post_id, '_ttm_landing_theme_slider_icon_id', 1 ), 'full' )[0];
		$indicator_icon_invert     = wp_get_attachment_image_src( (int) get_post_meta( $post_id, '_ttm_landing_theme_slider_inverse_icon_id', 1 ), 'full' )[0];
		$styles                    = <<<STYLES
<style>
    .section-group .bg-color-image:after {
        background: url({$billboard_brand_watermark}) no-repeat right 0 top 50% transparent;
    }

    .section-group .bg-color-image:after,
    .section-group .bg-color-image:before,
    .has-additional-tab .toggle-group a.active,
    .section-group ul.resp-tabs-list .resp-tab-active figure,
    .section-group .bg-blue,
    .btn-primary,
    .section-group .bottom-section .gform_wrapper .gform_button:focus,
    .section-group .bottom-section .gform_wrapper .gform_button:hover,
    .section-group .bottom-section .gform_wrapper .gform_button,
    .section-group .section-large-column {
        background-color: {$theme_color};
    }

    #fp-nav ul li a.active span {
        background: url({$indicator_icon}) no-repeat center center transparent;
    }

    .fp-viewing-3 #fp-nav ul li a.active span {
        background: url({$indicator_icon_invert}) no-repeat center center transparent;
    }

    .section-group h1, .section-group h2, .section-group h3, .section-group h4, .section-group h5, .section-group h6 {
        color: {$theme_color};
    }

    .icon-image figure,
    #fp-nav ul li a span,
    .section-group ul.resp-tabs-list .resp-tab-active .icon-image {
        border: 1px solid {$theme_color};
    }

    .section-group .bg-light-cyan.bottom-section:before {
        background: url({$footer_brand_watermark}) no-repeat right 0 top 50% transparent;
    }

    .detailed-list li figure {
        border: 3px solid {$theme_color};
    }

    #fp-nav ul li:hover a span {
        box-shadow: 0 0 0 2px {$theme_color};
    }
</style>
STYLES;
	endif;

	echo $styles;
}

add_action( 'wp_head', 'mok_landing_page2_style', 99 );

/**
 * Change showcase template theme color based on selection in post meta
 */
function mok_showcase_theme_color() {
	if ( is_page_template( [
		'templates/template-sst-showcase-home1.php',
		'templates/template-sst-showcase-home2.php',
		'templates/template-sst-showcase-home3.php'
	] ) ):
		global $post;
		$theme_color = carbon_get_post_meta( $post->ID, 'showcase_theme_color' ); ?>
        <style>
            .billboard-slider h1 span,
            .billboard-slider h2 span,
            .button,
            .subscription-section .row:before,
            .subscription-section input[type=submit],
            .instagram-section .section-header .fa-instagram {
                background-color: <?php echo  $theme_color;?>;
            }

            h1 span,
            h2 span,
            h3 span,
            h4 span,
            h5 span,
            h6 span,
            .infographic-section .section-title,
            .subscription-section p {
                color: <?php echo  $theme_color;?>;
            }

            .container-box.image-left:after {
                border-bottom-color: <?php echo  $theme_color;?>;
            }

            .subscription-section input[type=email], .subscription-section input[type=submit] {
                border: 1px solid <?php echo  $theme_color;?>;
            }

            .billboard-slider .slick-arrow.slick-next:after {
                border: 2px solid <?php echo  $theme_color;?>;
                border-left-color: transparent;
            }
        </style>
		<?php
	endif;
}

add_action( 'wp_head', 'mok_showcase_theme_color' );