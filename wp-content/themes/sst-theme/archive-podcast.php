<?php
/**
 * The template for displaying archive page for podcast post type
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.4.4
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
get_header(); ?>
<?php
$podcast_options        = get_option( 'sst_option' );
$podcast_logo_id        = array_key_exists( 'podcast-logo', $podcast_options ) && $podcast_options['podcast-logo']['id'] != '' ? $podcast_options['podcast-logo']['id'] : null;
$podcast_banner_id      = array_key_exists( 'podcast-banner-image', $podcast_options ) && $podcast_options['podcast-banner-image']['id'] != '' ? $podcast_options['podcast-banner-image']['id'] : null;
$podcast_banner_content = array_key_exists( 'podcast-banner-content', $podcast_options ) && $podcast_options['podcast-banner-content'] != '' ? apply_filters( 'the_content', $podcast_options['podcast-banner-content'] ) : null;
$podcast_link           = array_key_exists( 'podcast-itunes-link', $podcast_options ) && $podcast_options['podcast-itunes-link'] != '' ? esc_url( $podcast_options['podcast-itunes-link'] ) : '#';
$podcast_title          = array_key_exists( 'podcast-general-title', $podcast_options ) && $podcast_options['podcast-general-title'] != '' ? wp_strip_all_tags( $podcast_options['podcast-general-title'] ) : null;
$podcast_desc           = array_key_exists( 'podcast-general-desc', $podcast_options ) && $podcast_options['podcast-general-desc'] != '' ? apply_filters( 'the_content', $podcast_options['podcast-general-desc'] ) : null;
$podcast_main_content   = array_key_exists( 'podcast-main-content', $podcast_options ) && $podcast_options['podcast-main-content'] != '' ? apply_filters( 'the_content', $podcast_options['podcast-main-content'] ) : null;
?>
<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
    <div class="billboard-podcast bg-dark-color">
        <div class="holder">
            <div class="image-container">
				<?php if ( ! is_null( $podcast_banner_id ) ):
					echo wp_get_attachment_image( $podcast_banner_id, 'full' );
				endif; ?>
            </div>
            <div class="billboard-container">
				<?php if ( ! is_null( $podcast_banner_content ) ):
					echo $podcast_banner_content;
				endif; ?>
            </div>
        </div>
    </div>
    <div class="more-about-podcast">
        <div class="holder">
            <div class="podcast-logo">
				<?php if ( ! is_null( $podcast_logo_id ) ):
					echo wp_get_attachment_image( $podcast_logo_id, 'full' );
				endif; ?>
            </div>
            <div class="about-the-podcast bg-theme-color">
                <div class="alignright">
                    <a href="<?php echo $podcast_link; ?>">
                        <img src="<?php echo get_theme_file_uri( 'assets/images/itunes-icon.png' ); ?>" alt="iTunes">
                    </a>
                </div>
				<?php if ( ! is_null( $podcast_desc ) ): ?>
                    <h3>Description</h3>
					<?php echo $podcast_desc; ?>
				<?php endif; ?>
            </div>
        </div>
    </div>
<?php if ( have_posts() ): ?>
    <section class="podcast-list-section">
        <div class="holder">
            <div id="podcast-list">
                <header>
                    <h2>Episodes List</h2>
                </header>
                <div class="podcast-container">
					<?php while ( have_posts() ): the_post();
						$post_id       = get_the_ID();
						$episode_count = get_post_meta( $post_id, '_qwl_episode_count', 1 ); ?>
                        <article <?php post_class( 'post-podcast post clearfix' ); ?>>
                            <div class="episode-count">
                                <a href="<?php the_permalink(); ?>">Episode <?php echo $episode_count; ?></a>
                            </div>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="detail"><?php echo wp_trim_words( get_the_excerpt(), 25 ); ?></div>
                            <a href="<?php the_permalink(); ?>" class="link-more">Read More</a>
                        </article>
					<?php endwhile; ?>
                </div>
            </div>
            <div class="podcast-container">
				<?php echo $podcast_main_content; ?>
            </div>
			<?php if ( is_active_sidebar( 'podcast-sidebar' ) ) :
				dynamic_sidebar( 'podcast-sidebar' );
			endif; ?>
        </div>
    </section>
<?php endif; ?>
<?php get_footer(); ?>