<?php
/*
 * Template Name: SST Contact
 */
get_header();
while ( have_posts() ): the_post();
	$post_id = get_the_ID();
	$contact_map = get_post_meta( $post_id, '_qwl_contact_map', 1 )?>
	<div class="page-content fullpage">
		<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
		<?php
		$thumbnail = '';
		if ( has_post_thumbnail() ):
			$thumbnail = 'style="background-image: url(\''.get_the_post_thumbnail_url( $post_id, 'full' ).'\');"';
		endif; ?>
		<div class="contact-container" <?php echo $thumbnail; ?>>
			<div class="holder">
				<?php the_title( '<h1>', '</h1>' ); ?>
				<div class="editor-content">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
		<div class="holder">
			<?php if ( is_active_sidebar( 'location-widget' ) ):
				dynamic_sidebar( 'location-widget' );
			endif; ?>
		</div>
	</div>
	<div class="map-holder">
		<?php if ( $contact_map!='' ): ?>
			<?php echo $contact_map; ?>
		<?php endif; ?>
	</div>
<?php endwhile;
get_footer(); ?>