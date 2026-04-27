<?php
/**
 * The template for displaying archive page for job post type
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.5.2
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
get_header(); ?>
<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
    <div class="page-content fullpage search-results">
        <div class="holder">
            <div class="main-container">
                <h1>Available Job Opportunities</h1>
				<?php if ( have_posts() ):
					while ( have_posts() ): the_post();
						$post_id     = get_the_ID();
						$job_summary = get_post_meta( $post_id, '_ttm_job_summary', 1 ); ?>
                        <article <?php post_class(); ?>>
                            <figure class="image-container">
                                <a href="<?php the_permalink(); ?>">
									<?php if ( has_post_thumbnail() ):
										the_post_thumbnail( [ 122, 68 ] );
									else:
										$default_attachment_id = get_option( 'sst_option' )['blog-default-image']['id'];
										echo wp_get_attachment_image( $default_attachment_id, [ 122, 68 ] );
									endif; ?>
                                </a>
                            </figure>
                            <div class="detail">
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
								<?php if ( $job_summary != '' ):
									echo apply_filters( 'the_content', $job_summary );
								else:
									the_excerpt();
								endif; ?>
                                <a href="<?php the_permalink(); ?>" class="alignright link-more">Read More</a>
                            </div>
                        </article>
					<?php endwhile;
					the_posts_pagination( [
						'mid_size'           => 2,
						'prev_text'          => '<i class="fa fa-chevron-left"></i>',
						'next_text'          => '<i class="fa fa-chevron-right"></i>',
						'screen_reader_text' => false,
					] );
				else: ?>
                    <p>Sorry, no job postings found.</p>
				<?php endif; ?>
            </div>
			<?php get_sidebar(); ?>
        </div>
    </div>
<?php get_footer(); ?>