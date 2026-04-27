<?php
/*
 * Template Name: SST Event
 */
get_header();
while ( have_posts() ): the_post(); ?>
	<div class="page-content fullpage events-container">
		<div class="page-title">
			<div class="holder">
				<h1>EVENTS.
					<small>&#187;</small>
					<span><?php the_title(); ?></span>
				</h1>
			</div>
		</div>
		<div class="holder">
			<div class="event-content">
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
								</div>
							</div>

						</li>
						<li><div class="event-search-holder">
								<a href="#" class="event-search-icon">Search for an Event</a>
								<div class="event-search">
									<form action="" method="post">
										<input type="text" name="event-search" id="event-search" value=""
										       placeholder="Search Event">
										<button type="submit" id="btn-search" name="btn-search">Go</button>
									</form>
								</div>
							</div></li>
					</ul>
				</div>
				<?php
				$events = new WP_query ( [
					'post_type'      => 'our-events',
					'posts_per_page' => - 1,
					'meta_query'     => [
						[
							'key'     => '_ttm_event_date',
							'value'   => time(),
							'compare' => '>='
						]
					]
				] );
				?>
				<div class="event-items">
					<?php
					$first = 1;
					while ( $events->have_posts() ): $events->the_post();
						$post_id          = get_the_ID();
						$event_title      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_branch', 1 ) );
						$event_address    = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_address', 1 ) );
						$event_city       = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_city', 1 ) );
						$event_state      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_state', 1 ) );
						$event_zip        = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_zip', 1 ) );
						$event_start_time = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_start_time', 1 ) );
						$event_end_time   = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_end_time', 1 ) );
						$event_date       = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_date', 1 ) );
						$is_featured      = wp_strip_all_tags( get_post_meta( $post_id, '_ttm_event_featured', 1 ) );
						?>
						<?php if ( $first == 1 ): ?>
							<div class="item featured-event">
								<div class="content">
									<div class="sub-holder">
										<?php if ( $is_featured ): ?>
											<div class="featured-title">
												<?php echo date( 'Y-m-d' ) == date( 'Y-m-d', $event_start_date ) ? 'Today' : 'Upcoming'; ?>
												<em>featured event</em>
											</div>
										<?php endif; ?>
										<div class="featured-content">
											<div class="info-meta">
												<span
													class="event-date"><?php echo date( 'd', $event_date ); ?>
													<small><?php echo date( 'M', $event_date ); ?></small> </span>
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
											<div class="event-detail">
												<div class="detail">
													<h3><a href="<?php the_permalink(); ?>"
													       class="read-more"><?php the_title(); ?></a>
													</h3>

													<?php the_excerpt(); ?>
												</div>
												<div class="event-item-footer">
													<a href="<?php the_permalink(); ?>" class="read-more">FIND OUT
														MORE</a>
												</div>
											</div>
										</div>
										<figure>
											<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
										</figure>
									</div>
								</div>
							</div>
						<?php else: ?>
							<div class="item">
								<div class="content">
									<figure>
										<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
										<?php if ( $is_featured ): ?>
											<div class="featured-title">
												<?php echo date( 'Y-m-d' ) == date( 'Y-m-d', $event_date ) ? 'Today' : date( 'Y-m-d' ) < date( 'Y-m-d', $event_date ) ? 'Upcoming' : 'Past'; ?>
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
						<?php endif; ?>
						<?php $first = 0; endwhile;
					wp_reset_postdata(); ?>
				</div>
				<?php
				$past_events = new WP_query ( [
					'post_type'      => 'our-events',
					'posts_per_page' => - 1,
					'meta_query'     => [
						[
							'key'     => '_ttm_event_date',
							'value'   => time(),
							'compare' => '<'
						]
					]
				] );
				if ( $past_events->have_posts() ): ?>
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
											<small><?php echo date( 'M', $event_date ); ?></small> </span>
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
				<?php endif; ?>
			</div>
		</div>
		<!-- /.row -->
	</div>
<?php endwhile; ?>
<?php get_footer(); ?>