<?php
/**
 * The template for displaying single page
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.4.4
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
get_header();
while ( have_posts() ): the_post(); ?>
    <div class="page-content fullpage">
        <div class="holder">
            <article class="main-container">
				<?php the_title( '<h1>', '</h1>' ); ?>
				<?php if ( has_post_thumbnail() ):
					the_post_thumbnail();
				endif; ?>
                <div class="editor-content">
					<?php the_content(); ?>
					<?php
					wp_link_pages( [
						'before'           => '<p>' . __( 'Pages:' ),
						'after'            => '</p>',
						'link_before'      => '',
						'link_after'       => '',
						'next_or_number'   => 'number',
						'separator'        => ' ',
						'nextpagelink'     => __( 'Next page' ),
						'previouspagelink' => __( 'Previous page' ),
						'pagelink'         => '%',
						'echo'             => 1
					] ); ?>
                </div>
				<?php do_action( 'content_bottom' ); ?>
            </article>
			<?php get_sidebar(); ?>
        </div>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>