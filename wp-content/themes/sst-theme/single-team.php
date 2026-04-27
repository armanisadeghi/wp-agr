<?php
/**
 * The template for displaying single team page
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.4.4
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
/*
 * Template Name: SST Team
 */
get_header(); ?>
<?php while ( have_posts() ): the_post();
	$post_id = get_the_ID(); ?>
    <div class="page-content fullpage">
		<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
        <div class="page-content fullpage dark-theme team-single-header aligncenter">
            <div class="holder">
                <div class="img-wrapper">
					<?php if ( has_post_thumbnail() ) :
						the_post_thumbnail( [ 141, 141 ] );
					else: ?>
                        <img
                                src="<?php echo get_template_directory_uri(); ?>/assets/images/avatar.png"
                                alt="<?php bloginfo(); ?> default avatar image">
					<?php endif; ?>
                </div>
                <h1><?php the_title(); ?></h1>
				<?php if ( '' != get_post_meta( $post_id, '_qwl_team_designation', 1 ) ): ?>
                    <span class="team-designation">
						<?php echo get_post_meta( $post_id, '_qwl_team_designation', 1 ); ?>
					</span>
				<?php endif; ?>
            </div>
        </div>
        <div class="page-content">
            <div class="holder">
                <div class="editor-content multi-column">
					<?php the_content(); ?>
                </div>
				<?php if ( get_post_meta( $post_id, '_qwl_team_content', 1 ) != '' ): ?>
                    <div class="team-additional-info">
						<?php echo apply_filters( 'the_content', get_post_meta( $post_id, '_qwl_team_content', 1 ) ); ?>
                    </div>
				<?php endif; ?>
            </div>
        </div>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>