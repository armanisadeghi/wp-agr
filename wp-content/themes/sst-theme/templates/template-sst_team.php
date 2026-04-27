<?php
/*
 * Template Name: SST Team Home
 */
get_header();
while ( have_posts() ): the_post(); ?>
    <div id="main">
        <div class="page-content fullpage">
			<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
			<?php if ( has_post_thumbnail() ): ?>
                <div id="billboard" class="billboard-fill">
                    <div class="image-container">
						<?php the_post_thumbnail(); ?>
                    </div>
                    <div class="holder">
                        <h1><?php the_title(); ?></h1>
                    </div>
                </div>
                <!-- Billboard Container -->
			<?php endif; ?>

			<?php
			$team = new WP_Query( [
				'post_type'      => 'team',
				'posts_per_page' => - 1
			] );
			if ( $team->have_posts() ): ?>
                <div class="page-content full-width col2-container team-wrapper">
                    <div class="holder  equal-height">
						<?php while ( $team->have_posts() ): $team->the_post();
							$post_id     = get_the_ID();
							$designation = get_post_meta( $post_id, '_qwl_team_designation', 1 ); ?>
                            <div class="col item">
                                <div class="col-inner clearfix equal-height">

                                    <div class="img-wrapper item">
                                        <a href="<?php the_permalink(); ?>">
											<?php if ( has_post_thumbnail() ) :
												the_post_thumbnail( [ 141, 141 ] );
											else: ?>
                                                <img src="<?php echo get_theme_file_uri('assets/images/avatar.png'); ?>" alt="<?php the_title(); ?>">
											<?php endif; ?>
                                        </a>
                                    </div>

                                    <div class="detail item">
                                        <h3>
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
										<?php if ( '' != $designation ): ?>
                                            <span class="team-designation"><?php echo $designation; ?></span>
										<?php endif; ?>
										<?php echo apply_filters( 'the_excerpt', wp_trim_words( get_the_excerpt(), $num_words = 10, '[...]' ) ); ?>
                                        <a href="<?php the_permalink(); ?>" class="align-right button link">read
                                            more &raquo;</a>
                                    </div>
                                </div>
                            </div>
						<?php endwhile;
						wp_reset_postdata(); ?>
                    </div>
                </div>
			<?php endif; ?>
        </div>
    </div>
<?php endwhile;
get_footer(); ?>