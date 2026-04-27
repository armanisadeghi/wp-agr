<?php
/**
 * The template for displaying search result
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.4.4
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

get_header(); ?>
    <div class="page-content fullpage">
        <div class="holder">
            <div class="main-container">
                <h1>Search Result: <?php echo get_search_query(); ?></h1>
				<?php if ( have_posts() ):
					while ( have_posts() ): the_post(); ?>
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
                                <p><?php the_excerpt(); ?></p>
                                <a href="<?php the_permalink(); ?>" class="alignright link-more">Read Article</a>
                            </div>
                        </article>
					<?php endwhile;
					the_posts_pagination( [
						'mid_size'           => 2,
						'prev_text'          => '<i class="fa fa-chevron-left"></i>',
						'next_text'          => '<i class="fa fa-chevron-right"></i>',
						'screen_reader_text' => false,
					] );
				else:?>
                    <p>No result found.</p>
				<?php endif; ?>
            </div>
			<?php get_sidebar(); ?>
        </div>
    </div>
<?php get_footer(); ?>