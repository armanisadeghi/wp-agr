<?php
/**
 * The template for displaying single podcast page
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.4.4
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
get_header(); ?>
<?php while ( have_posts() ): the_post();
	$post_id             = get_the_ID();
	$video_url           = get_post_meta( $post_id, '_qwl_video_url', 1 );
	$video_screenshot    = get_post_meta( $post_id, '_qwl_video_screenshot', 1 );
	$episode_count       = get_post_meta( $post_id, '_qwl_episode_count', 1 );
	$audio_file          = get_post_meta( $post_id, "_qwl_audio_file", 1 );
	$transcript_link     = (int) get_post_meta( $post_id, "_qwl_podcast_trans_id", 1 );
	$podcast_options     = get_option( 'sst_option' );
	$podcast_logo_id     = array_key_exists( 'podcast-logo-inner', $podcast_options ) && $podcast_options['podcast-logo-inner']['id'] != '' ? $podcast_options['podcast-logo-inner']['id'] : null;
	$podcast_link        = array_key_exists( 'podcast-itunes-link', $podcast_options ) && $podcast_options['podcast-itunes-link'] != '' ? esc_url( $podcast_options['podcast-itunes-link'] ) : '#';
	$podcast_title       = array_key_exists( 'podcast-general-title-inner', $podcast_options ) && $podcast_options['podcast-general-title-inner'] != '' ? apply_filters( 'the_content', $podcast_options['podcast-general-title-inner'] ) : null;
	$podcast_desc        = array_key_exists( 'podcast-general-desc', $podcast_options ) && $podcast_options['podcast-general-desc'] != '' ? apply_filters( 'the_content', $podcast_options['podcast-general-desc'] ) : null;
	$podcast_guide_title = array_key_exists( 'podcast-guide-title', $podcast_options ) && $podcast_options['podcast-guide-title'] != '' ? wp_strip_all_tags( $podcast_options['podcast-guide-title'] ) : null;
	$podcast_guide_image = array_key_exists( 'podcast-guide-image', $podcast_options ) && $podcast_options['podcast-guide-image']['id'] != '' ? $podcast_options['podcast-guide-image']['id'] : null;
	$podcast_optin_slug  = array_key_exists( 'podcast-guide-slug', $podcast_options ) && $podcast_options['podcast-guide-slug'] != '' ? wp_strip_all_tags( $podcast_options['podcast-guide-slug'] ) : '';
	?>
	<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
    <div class="podcast-meta">
        <div class="holder">
            <div class="podcast-logo">
				<?php if ( ! is_null( $podcast_logo_id ) ):
					echo wp_get_attachment_image( $podcast_logo_id, 'full' );
				endif; ?>
            </div>
            <div class="itunes-link">
                <a href="<?php echo $podcast_link; ?>">
                    <img src="<?php echo get_theme_file_uri( 'assets/images/itunes-icon.png' ); ?>" alt="iTunes">
                </a>
            </div>
            <div class="podcast-title">
                <div class="program-title">
					<?php if ( ! is_null( $podcast_title ) ):
						echo $podcast_title;
					endif; ?>
                </div>
                <div class="episode-meta"><span
                            class="episode-count">Episode <?php echo $episode_count; ?></span>

                    <h2 class="episode-title"><?php the_title(); ?></h2></div>
            </div>
        </div>
    </div>
    <div class="page-content hero-container fullwidth bg-dark-color">
        <div class="holder">
            <div class="video-container">
				<?php
				preg_match(
					'/[\\?\\&]v=([^\\?\\&]+)/',
					$video_url,
					$matches
				);
				$id     = $matches[1];
				$width  = '560';
				$height = '330';

				if ( ! empty( $video_screenshot ) ) {
					echo do_shortcode( '[vds vds_video_link="' . $video_url . '" vds_image_link="' . $video_screenshot . '"]' );
				} else {
					echo '<div class="youtube-article"><iframe class="dt-youtube" width="' . $width . '" height="' . $height . '" src="//www.youtube.com/embed/' . $id . '" frameborder="0" allowfullscreen></iframe></div>';
				} ?>
            </div>
            <div class="player-container">
                <div class="free-guide-section">
                    <div class="img-container">
						<?php if ( ! is_null( $podcast_guide_image ) ):
							echo wp_get_attachment_image( $podcast_guide_image, 'full' );
						endif; ?>
                    </div>
					<?php if ( ! is_null( $podcast_guide_title ) ): ?>
                        <h2><?php echo $podcast_guide_title; ?></h2>
					<?php endif; ?>
                    <div class="free-guide">
                        <strong>Free Guide</strong>
                        <a href="#" class="button dark manual-optin-trigger"
                           data-optin-slug="<?php echo $podcast_optin_slug; ?>">Download Free Guide</a>
                    </div>
                </div>
                <div class="podcast-section">
                    <span class="fa-microphone"></span>

                    <h3>Don't Want Video? Listen <strong>Audio Version</strong></h3>
					<?php echo do_shortcode( '[audio mp3="' . $audio_file . '"][/audio]' ); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content fullpage">
        <div class="holder">
            <div class="content-holder">
                <article class="main-container">
                    <h2><?php the_title(); ?></h2>
					<?php if ( has_post_thumbnail() ): ?>
                        <figure><?php the_post_thumbnail(); ?></figure>
					<?php endif; ?>
                    <div class="editor-content">
						<?php the_content(); ?>
						<?php if ( $transcript_link ): ?>
                            <p><a class="button" href="<?php echo get_permalink( $transcript_link ); ?>">Episode
                                    Transcript</a></p>
						<?php endif; ?>
                    </div>
					<?php do_action( 'content_bottom' ); ?>
                </article>
				<?php if ( ! is_null( $podcast_desc ) ): ?>
                    <div class="about-the-podcast bg-dark-color">
                        <h3>Description</h3>
						<?php echo $podcast_desc; ?>
                    </div>
				<?php endif; ?>
            </div>
			<?php get_sidebar( 'podcast' ); ?>
        </div>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>