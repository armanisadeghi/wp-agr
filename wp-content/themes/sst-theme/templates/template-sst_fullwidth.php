<?php
/*
 * Template Name: SST Full Width
 */
get_header();
while ( have_posts() ): the_post(); ?>
	<div class="page-content fullpage">
		<article class="main-container fullwidth">
			<div class="holder">
				<?php the_title( '<h1>', '</h1>' ); ?>
			</div>
			<?php if ( has_post_thumbnail() ):
				the_post_thumbnail();
			endif; ?>
			<?php do_action( 'content_bottom' ); ?>
		</article>

		<div class="editor-content">
			<?php the_content(); ?>
			<?php
			$defaults = [
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
			];

			wp_link_pages( $defaults );
			if ( comments_open() ):
				comments_template();
			endif; ?>
		</div>
	</div>
<?php endwhile;
get_footer(); ?>