<?php
/*
 * Template Name: SST Showcase Home 2
 */
get_header( 'showcase' );
while ( have_posts() ):the_post(); ?>
    <!-- Page Header -->
	<?php get_template_part( 'common/content', 'showcase' ); ?>
<?php endwhile;
get_footer( 'showcase' );