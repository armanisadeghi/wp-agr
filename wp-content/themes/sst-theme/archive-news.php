<?php
/**
 * The template for displaying archive page for news post type
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.4.2
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
global $wp_query;
global $count;
$count          = 1;
$total_posts    = $wp_query->found_posts;
$post_displayed = $wp_query->post_count;
get_header(); ?>

<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
    <div class="page-content fullpage">
        <div class="holder">
			<?php if ( have_posts() ) : ?>
                <div class="posts <?php echo is_home() || is_archive() ? 'blog-posts' : ''; ?>">
					<?php while ( have_posts() ) : the_post();
						if ( $count < 5 ):
							echo $count == 1 ? '<div class="hero clearfix">' : '';
							echo $count == 1 ? '<div class="hero-one hero-item">' : ( $count == 2 ? '<div class="hero-two hero-item">' : '' );
							get_template_part( 'common/content', 'news' );
							echo $count == 1 || $count == 4 || ( $post_displayed < 5 && $count == $post_displayed ) ? '</div>' : '';
							echo $count == 4 || ( $post_displayed < 5 && $count == $post_displayed ) ? '</div>' : '';
						else:
							echo $count == 7 ? '<div class="blog-list clearfix">' : ( $count == 5 ? '<div class="blog-col2 clearfix">' : '' );
							get_template_part( 'common/content', 'news' );
							echo $count == 6 || ( $post_displayed < 7 && $count == $post_displayed ) ? '</div>' : '';
							echo $count == $post_displayed ? '</div>' : '';
						endif;
						$count ++;
					endwhile;
					the_posts_pagination( [
						'mid_size'           => 2,
						'prev_text'          => '<i class="fa fa-chevron-left"></i>',
						'next_text'          => '<i class="fa fa-chevron-right"></i>',
						'screen_reader_text' => false,
					] ); ?>
                </div>
			<?php else : ?>
				<?php get_template_part( 'templates/content-not-found' ); ?>
			<?php endif; ?>
        </div>
        <!-- /.row -->
    </div>
<?php get_footer(); ?>