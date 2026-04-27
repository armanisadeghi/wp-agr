<?php
/**
 * The template for displaying single job
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.5.2
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
get_header(); ?>
<?php while ( have_posts() ): the_post();
	$post_id         = get_the_ID();
	$job_summary     = get_post_meta( $post_id, '_ttm_job_summary', 1 );
	$job_apply_label = esc_html( get_post_meta( $post_id, '_ttm_job_apply_label', 1 ) );
	$job_apply_link  = esc_url( get_post_meta( $post_id, '_ttm_job_apply_link', 1 ) ); ?>
	<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
    <div class="page-content fullpage">
        <div class="holder">
            <h1 itemprop="name"><?php the_title(); ?></h1>
            <div class="featured-image">
				<?php if ( has_post_thumbnail() ):
					the_post_thumbnail( 'full' );
				endif; ?>
                <div class="caption">
					<?php if ( $job_summary != '' ):
						echo apply_filters( 'the_content', wp_trim_words( $job_summary, 240, null ) );
					else:
						echo apply_filters( 'the_excerpt', wp_trim_words( get_the_excerpt(), 240, null ) );
					endif; ?>
                </div>
            </div>
            <article class="main-container" itemprop="description">
                <div class="editor-content clearfix">
					<?php the_content(); ?>
					<?php if ( $job_apply_link != '' ): ?>
                        <p><a class="button primary"
                              href="<?php echo $job_apply_link; ?>"><?php echo $job_apply_label; ?></a></p>
					<?php endif; ?>
                    <div class="addtoany_share_save_container addtoany_content_bottom">
                        <div class="addtoany_header"><strong>Share</strong> this story</div>
						<?php echo do_shortcode( '[addtoany]' ); ?>
                    </div>
                </div>
				<?php do_action( 'content_bottom' ); ?>
            </article>
			<?php get_sidebar(); ?>
        </div>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>