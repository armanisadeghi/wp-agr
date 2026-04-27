<?php
/**
 * The template for displaying archive page for team post type
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.2.2
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
get_header();
$team_options   = get_option( 'sst_option' );
$team_banner_id = array_key_exists( 'team-bg-image', $team_options ) && $team_options['team-bg-image']['id'] != '' ? $team_options['team-bg-image']['id'] : null; ?>
    <div id="main">
        <?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
        <div class="page-content fullpage">
            <?php if ( ! is_null( $team_banner_id ) ): ?>
                <div id="billboard" class="billboard-fill">
                    <div class="image-container">
                        <?php echo wp_get_attachment_image( $team_banner_id, 'full' ); ?>
                    </div>
                    <div class="holder">
                        <h1><?php post_type_archive_title( '', true ); ?></h1>
                    </div>
                </div>
                <!-- Billboard Container -->
            <?php endif; ?>

            <!-- Meet Our Team Section -->
            <h1 class="team-header" style="text-align: center; margin-bottom: 20px;">Meet Our Team</h1>

            <?php
            $team = new WP_Query([
                'post_type'      => 'team',
                'posts_per_page' => -1
            ]);
            if ($team->have_posts()): ?>
                <div class="page-content full-width col2-container team-wrapper">
                    <div class="holder  equal-height">
                        <?php while ($team->have_posts()): $team->the_post();
                            $post_id     = get_the_ID();
                            $designation = get_post_meta($post_id, '_qwl_team_designation', 1); ?>
                            <div class="col item">
                                <div class="col-inner clearfix equal-height">

                                    <div class="img-wrapper item">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php if (has_post_thumbnail()):
                                                the_post_thumbnail([141, 141]);
                                            else: ?>
                                                <img src="<?php echo get_theme_file_uri('assets/images/avatar.png'); ?>"
                                                     alt="<?php the_title(); ?>">
                                            <?php endif; ?>
                                        </a>
                                    </div>

                                    <div class="detail item">
                                        <h3>
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <?php if ('' != $designation): ?>
                                            <span class="team-designation"><?php echo $designation; ?></span>
                                        <?php endif; ?>
                                        <?php echo apply_filters('the_excerpt', wp_trim_words(get_the_excerpt(), $num_words = 10, '[...]')); ?>
                                        <a href="<?php the_permalink(); ?>" class="align-right button link">read more &raquo;</a>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php get_footer();
