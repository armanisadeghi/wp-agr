<?php
/**
 * The template for displaying single event
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.4.1
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
get_header();
while ( have_posts() ):the_post();
	$post_id          = get_the_ID();
	$event_title      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_branch', 1 ) );
	$event_address    = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_address', 1 ) );
	$event_city       = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_city', 1 ) );
	$event_state      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_state', 1 ) );
	$event_zip        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_zip', 1 ) );
	$event_start_time = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_start_time', 1 ) );
	$event_end_time   = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_end_time', 1 ) );
	$event_date       = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_date', 1 ) );
	$event_map        = apply_filters( 'the_content', get_post_meta( $post_id, '_ttm_event_google_map', 1 ) );
	$is_featured      = get_post_meta( $post_id, '_ttm_event_featured', 1 ) != '' ? wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_featured', 1 ) ) : '';
	$event_detail     = apply_filters( 'the_content', get_post_meta( $post_id, '_ttm_event_detail', 1 ) );
	?>
    <div class="page-content fullpage events-container event-detail-container">
		<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
        <div class="holder event-content">
            <div class="event-search-strip">
                <ul>
                    <li class="event-trigger"><a href="#" class="event-calendar-icon toggle-event-date">Choose
                            Date</a>

                        <div class="event-container">
                            <div class="calendar hidden-print">
                                <header>
                                    <h2 class="month"></h2>
                                    <a class="btn-prev" href="#">&lt;</a>
                                    <a class="btn-next" href="#">&gt;</a>
                                </header>
                                <table>
                                    <thead class="event-days">
                                    <tr></tr>
                                    </thead>
                                    <tbody class="event-calendar">
                                    <tr class="1"></tr>
                                    <tr class="2"></tr>
                                    <tr class="3"></tr>
                                    <tr class="4"></tr>
                                    <tr class="5"></tr>
                                    </tbody>
                                </table>
                                <div class="event-calendar-list"></div>
                            </div>
                        </div>

                    </li>
                    <li>
                        <div class="event-search-holder">
                            <a href="#" class="event-search-icon">Search for an Event</a>

                            <div class="event-search">
                                <form action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" method="get">
                                    <input type="text" name="s" id="event-search"
                                           value="<?php echo get_search_query(); ?>"
                                           placeholder="Search For An Event">
                                    <input type="hidden" name="post_type" value="our-events" readonly>
                                    <button type="submit" id="btn-search" name="btn-search">Go</button>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <article class="main-content">
                <div class="featured-banner">
					<?php if ( $is_featured != '' ): ?>
                        <div class="featured-title">
							<?php echo date( 'Y-m-d' ) == date( 'Y-m-d', $event_date ) ? 'Today' : date( 'Y-m-d' ) < date( 'Y-m-d', $event_date ) ? 'Upcoming' : 'Past'; ?>
                            <em>featured event</em>
                        </div>
					<?php endif; ?>
                    <div class="featured-content">
                        <div class="info-meta overlay">
							<?php if ( $event_date != '' ): ?>
                                <span class="event-date"><?php echo date( 'd', $event_date ); ?>
                                    <small><?php echo date( 'M', $event_date ); ?></small></span>
							<?php endif; ?>
                            <span class="meta-detail">
							<?php if ( $event_title != '' ): ?>
                                <span class="meta-title"><?php echo $event_title; ?></span>
							<?php endif; ?>
								<?php if ( $event_address != '' || $event_city != '' || $event_state != '' || $event_zip != '' ): ?>
                                    <span
                                            class="meta-location"> <?php echo sprintf( '%s <br/> %s, %s, %s', $event_address, $event_city, $event_state, $event_zip ); ?> </span>
								<?php endif; ?>
								<?php if ( $event_start_time != '' || $event_end_time != '' ): ?>
                                    <span
                                            class="meta-duration"><?php echo sprintf( 'From %s to %s', $event_start_time, $event_end_time ); ?></span>
								<?php endif; ?>
							</span>
                        </div>
                    </div>
                    <figure>
						<?php the_post_thumbnail(); ?>
                    </figure>
                </div>
                <div class="content-wrapper">
                    <h1 class="event-title"><?php the_title() ?></h1>
                    <blockquote class="event-caption">
						<?php the_excerpt(); ?>
                    </blockquote>
                    <div class="addtoany_share_save_container addtoany_content_bottom">
						<?php echo do_shortcode( '[addtoany]' ); ?>
                    </div>
                    <div class="event-editor two-cols">
						<?php if ( $event_detail != '' ): ?>
                            <div class="vertical-items">
								<?php echo $event_detail; ?>
                            </div>
						<?php endif; ?>
                        <div class="content-holder">
							<?php the_content(); ?>
                        </div>
                    </div>

					<?php if ( $event_map != '' ): ?>
                        <div class="map-holder">
							<?php echo $event_map; ?>
                        </div>
					<?php endif; ?>
                </div>
            </article>
            <aside class="sidebar">
				<?php
				$events = new WP_query ( [
					'post_type'      => 'our-events',
					'posts_per_page' => 4,
					'post__not_in'   => [ $post_id ],
					'meta_query'     => [
						[
							'key'     => '_ttm_event_date',
							'value'   => time(),
							'compare' => '>='
						]
					]
				] );
				if ( $events->have_posts() ): ?>
                    <div class="events-container">
                        <div class="event-items">
							<?php
							while ( $events->have_posts() ): $events->the_post();
								$post_id     = get_the_ID();
								$event_date  = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_date', 1 ) );
								$is_featured = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_featured', 1 ) );
								?>
                                <div class="item">
                                    <div class="content">
                                        <figure>
                                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
											<?php if ( $is_featured ): ?>
                                                <div class="featured-title">
													<?php echo date( 'Y-m-d' ) == date( 'Y-m-d', $event_date ) ? 'Today' : 'Upcoming'; ?>
                                                    <em>featured event</em>
                                                </div>
											<?php endif; ?>
                                        </figure>
                                        <div class="event-inner">
                                            <div class="info-meta">
											<span class="event-date"><?php echo date( 'd', $event_date ); ?>
                                                <small><?php echo date( 'M', $event_date ); ?></small> </span>
                                            </div>
                                            <div class="event-detail">
                                                <h3><a href="<?php the_permalink(); ?>"
                                                       class="read-more"><?php the_title(); ?></a></h3>
												<?php the_excerpt(); ?>
                                            </div>
                                            <div class="event-item-footer">
                                                <a href="<?php the_permalink(); ?>" class="read-more">FIND OUT MORE</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							<?php endwhile;
							wp_reset_postdata(); ?>
                        </div>
                    </div>
				<?php endif; ?>
				<?php
				$query_result = new WP_Query( [
					'posts_per_page' => 3,
					'post_type'      => 'post',
					'post_status'    => 'publish'
				] );
				if ( $query_result->have_posts() ): ?>
                    <div class="widget widget-last-blog-posts">
                        <h4 class="widget-title">Last Blog Posts</h4>

                        <div class="widget-entry">
							<?php while ( $query_result->have_posts() ): $query_result->the_post(); ?>
                                <article>
									<?php if ( has_post_thumbnail() ): ?>
                                        <figure class="image-container">
                                            <a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail( [ 122, 68 ] ); ?>
                                            </a>
                                        </figure>
									<?php endif; ?>
                                    <div class="detail">
                                        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <a href="<?php the_permalink(); ?>" class="alignright link-more">Read
                                            Article</a>
                                    </div>
                                </article>
							<?php endwhile;
							wp_reset_postdata(); ?>
                        </div>
                    </div>
				<?php endif; ?>
            </aside>
        </div>
        <!-- /.row -->
		<?php
		$past_events = new WP_query ( [
			'post_type'      => 'our-events',
			'posts_per_page' => 6,
			'post__not_in'   => [ $post_id ],
			'meta_query'     => [
				[
					'key'     => '_ttm_event_date',
					'value'   => time(),
					'compare' => '<'
				]
			]
		] );
		if ( $past_events->have_posts() ): ?>
            <div class="events-container">
                <div class="holder">
                    <h3 class="past-title">Past <strong>Events</strong></h3>

                    <div class="event-items past">
						<?php
						while ( $past_events->have_posts() ): $past_events->the_post();
							$post_id     = get_the_ID();
							$event_date  = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_date', 1 ) );
							$is_featured = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_featured', 1 ) );
							?>
                            <div class="item">
                                <div class="content">
                                    <div class="event-title-holder">
                                        <div class="info-meta">
										<span class="event-date"><?php echo date( 'd', $event_date ); ?>
                                            <small><?php echo date( 'M', $event_date ); ?></small></span>
                                        </div>
                                        <div class="title-holder">
                                            <h3><a href="<?php the_permalink(); ?>"
                                                   class="read-more"><?php the_title(); ?></a></h3>
                                        </div>
                                    </div>
                                    <div class="event-detail">
										<?php the_excerpt(); ?>
                                    </div>
                                    <div class="event-item-footer">
                                        <a href="<?php the_permalink(); ?>" class="read-more">FIND OUT MORE</a>
                                    </div>
                                </div>
                            </div>
						<?php endwhile;
						wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
		<?php endif; ?>
    </div>
<?php endwhile;
get_footer(); ?>