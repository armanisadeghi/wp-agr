<?php
/*
 * Template Name: SST Testimonials Home
 */
get_header(); ?>
	<div class="page-content fullpage">
		<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
		<div class="holder">
			<?php if ( have_posts() ) :
				global $count;
				$count = 1; ?>
				<div class="posts <?php if ( is_home() ) {
					echo "blog-posts";
				} ?>">
					<?php while ( have_posts() ) :
					the_post(); ?>
				<?php
				if ( ! is_home() ) {
					get_template_part( 'templates/content' );
				}
				if ( is_home() ) {
				?>
				<?php if ( 1 == $count ): ?>
					<div class="hero clearfix">
						<?php elseif ( $count == 5 ): ?>
						<div class="blog-col2 clearfix">
							<?php elseif ( $count == 7 ): ?>
							<div class="blog-list clearfix">
								<?php endif; ?>
								<?php if ( 1 == $count || 2 == $count ): ?>
								<div
									class="<?php if ( 1 == $count ) {
										echo "hero-one hero-item";
									} elseif ( 2 == $count ) {
										echo "hero-two hero-item";
									} ?>">
									<?php endif; ?>
									<?php get_template_part( 'templates/content', 'blog' ); ?>
									<?php if ( 1 == $count || 4 == $count ): ?>
								</div>
								<!-- .inner-hero ends -->
							<?php endif; ?>
								<?php if ( 4 == $count ): ?>
							</div>
							<!-- .hero ends -->
						<?php endif; ?>
							<?php if ( 6 == $count ): ?>
						</div>
						<!-- .blog-col2 ends -->
					<?php endif; ?>
						<?php
						}
						?>
						<?php $count ++;
						endwhile;
						?>
						<?php
						if ( $count > 7 ): ?>
					</div>
					<!-- .blog-list ends -->
				<?php endif; ?>
				</div>
				<!-- /.posts -->

				<?php the_posts_pagination(
				[
					'mid_size'           => 2,
					'prev_text'          => '<i class="fa fa-chevron-left"></i>',
					'next_text'          => '<i class="fa fa-chevron-right"></i>',
					'screen_reader_text' => false,
				]
			);
				?>
			<?php else : ?>
				<?php get_template_part( 'templates/content-not-found' ); ?>
			<?php endif; ?>


		</div>
		<!-- /.row -->
	</div>

<?php get_footer(); ?>