<?php
/**
 * The template for displaying sidebar on podcast detail page
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.4.4
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
?>
<aside class="sidebar">
	<?php
	$podcast_more = new WP_Query( [
		'posts_per_page' => 6,
		'post_type'      => 'podcast',
		'post_status'    => 'publish',
		'post__not_in'   => [ get_the_ID() ]
	] );
	if ( $podcast_more->have_posts() ): ?>
        <aside class="widget widget-podcast-episodes bg-white">
            <h3 class="widget-title">More Episodes</h3>

            <div class="widget-entry">
                <ul>
					<?php while ( $podcast_more->have_posts() ): $podcast_more->the_post(); ?>
                        <li>
                            <a href="<?php the_permalink(); ?>">
                                <span
                                        class="episode-count">Episode <?php echo get_post_meta( get_the_ID(),
		                                '_qwl_episode_count', 1 ); ?></span>
                                <h4><?php the_title(); ?></h4>
                            </a>
                        </li>
					<?php endwhile;
					wp_reset_postdata(); ?>
                </ul>
                <div class="more-link">
                    <a href="<?php echo get_post_type_archive_link( 'podcast' ); ?>" class="link-more alignright">See
                        full list</a>
                </div>
            </div>
        </aside>
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'podcast-sidebar' ) ) :
		dynamic_sidebar( 'podcast-sidebar' );
	endif; ?>
	<?php
	$query_result = new WP_Query( [
		'posts_per_page' => 3,
		'post_type'      => 'post',
		'post_status'    => 'publish'
	] );
	if ( $query_result->have_posts() ): ?>
        <aside class="widget widget-last-blog-posts">
            <h3 class="widget-title">Last Blog Posts</h3>
            <div class="widget-entry">
				<?php while ( $query_result->have_posts() ):$query_result->the_post(); ?>
                    <article>
						<?php if ( has_post_thumbnail() ): ?>
                            <figure class="image-container">
                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( [ 122, 68 ] ); ?></a>
                            </figure>
						<?php endif; ?>
                        <h4>
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            <a href="<?php the_permalink(); ?>" class="alignright link-more">Read Article</a>
                        </h4>
                    </article>
				<?php endwhile;
				wp_reset_postdata(); ?>
            </div>
        </aside>
	<?php endif; ?>
</aside>