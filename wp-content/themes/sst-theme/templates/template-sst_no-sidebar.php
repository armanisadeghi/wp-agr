<?php
/*
 * Template Name: SST No Sidebar Page
 */

get_header(); ?>
    <div class="page-content fullpage">
        <div class="holder">
            <article class="main-container fullwidth">
				<?php the_title( '<h1>', '</h1>' ); ?>
				<?php while ( have_posts() ): the_post(); ?>
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
						] );
						if ( comments_open() ):
							comments_template();
						endif; ?>
                    </div>
				<?php endwhile; ?>
				<?php do_action( 'content_bottom' ); ?>
            </article>
        </div>
    </div>

<?php get_footer(); ?>