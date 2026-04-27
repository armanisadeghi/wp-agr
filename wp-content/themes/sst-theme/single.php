<?php
/**
 * The template for displaying single blog
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.4.4
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
get_header(); ?>
<?php while ( have_posts() ): the_post(); ?>
	<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
    <div class="page-content fullpage">
        <div class="holder">
            <h1><?php the_title(); ?></h1>
            <div class="featured-image">
				<?php if ( has_post_thumbnail() ):
					the_post_thumbnail( 'full' );
				endif; ?>
                <div class="caption">
					<?php the_excerpt(); ?>
                </div>
            </div>
            <article class="main-container">
                <div class="editor-content clearfix">
					<?php the_content(); ?>
                    <div class="addtoany_share_save_container addtoany_content_bottom">
                        <div class="addtoany_header"><strong>Share</strong> this story</div>
						<?php echo do_shortcode( '[addtoany]' ); ?>
                    </div>
                </div>
				<?php do_action( 'content_bottom' ); ?>
				<?php if ( comments_open() ):
					comments_template();
				endif; ?>
            </article>
			<?php get_sidebar(); ?>
        </div>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>