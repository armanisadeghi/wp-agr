<?php
/*
 * Template Name: SST test
 */
get_header();
while ( have_posts() ):the_post(); ?>
    <div class="page-content fullpage">
        <div class="holder">
            <article class="main-container">
            	<?php echo get_the_ID(); ?>
				<a href="<?php the_permalink();?>"><?php the_title(); ?></a>
				<?php echo get_permalink($ID);?>
                <br />
                <?php wp_list_pages(); ?>
            </article>
			<?php get_sidebar(); ?>
        </div>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>