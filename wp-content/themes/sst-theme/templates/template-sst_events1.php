<?php
/*
 * Template Name: SST Event 2
 */
get_header( 'event' );
while ( have_posts() ): the_post();
	$post_id                = get_the_ID();
	$event_top_location     = get_post_meta( $post_id, '_events_below_header_location', 1 );
	$event_top_organization = get_post_meta( $post_id, '_event_header_organization', 1 );
	$event_top_phone        = get_post_meta( $post_id, '_event_header_phone', 1 );
	$event_top_img1_id      = get_post_meta( $post_id, '_event_header_logo_id', 1 );
	$event_top_img2_id      = get_post_meta( $post_id, '_event_header_right_image_id', 1 );
	$support_title          = get_post_meta( $post_id, '_events_below_header_title', 1 );
	$support_short_desc     = get_post_meta( $post_id, '_events_below_header_short_desc', 1 );
	$support_desc           = get_post_meta( $post_id, '_events_below_header_long_desc', 1 );
	$next_event_date        = get_post_meta( $post_id, '_events_next_events_date', 1 );
	$total_collected_title  = get_post_meta( $post_id, '_events_total_amount_title', 1 );
	$total_collected_amt    = get_post_meta( $post_id, '_events_total_amount', 1 );
	$upcoming_events        = get_post_meta( $post_id, '_events_first_section_list', 1 );
	$event_row_contents     = get_post_meta( $post_id, '_events_second_section_list', 1 );
	$past_events            = get_post_meta( $post_id, '_events_past_events_list', 1 );
	?>
    <div class="events1-container">
		<?php if ( $event_top_img1_id != '' || $event_top_location != '' || $event_top_organization != '' || $event_top_phone != '' || $event_top_img2_id != '' ): ?>
            <div class="page-content top-section bg-bright">
                <div class="holder">
					<?php if ( $event_top_img1_id != '' ): ?>
                        <div class="image-container">
							<?php echo wp_get_attachment_image( $event_top_img1_id, [ 210, 210 ] ); ?>
                        </div>
					<?php endif; ?>
                    <div class="detail">
						<?php if ( $event_top_organization != '' ): ?>
                            <h1><?php echo esc_html( $event_top_organization ); ?></h1>
						<?php endif; ?>
						<?php if ( $event_top_phone != '' ): ?>
                            <a href="tel:<?php echo urlencode( esc_html( $event_top_phone ) ); ?>">
								<?php echo esc_html( $event_top_phone ); ?>
                            </a>
						<?php endif; ?>
                    </div>
					<?php if ( $event_top_img2_id != '' ): ?>
                        <div class="image-container">
							<?php echo wp_get_attachment_image( $event_top_img2_id, [ 210, 210 ] ); ?>
                        </div>
					<?php endif; ?>
                </div>
            </div>
		<?php endif; ?>
        <div class="page-content support-section">
            <div class="holder">
                <div class="content two-cols">
                    <div class="item">
						<?php if ( $support_title != '' ): ?>
                            <h2><?php echo strtoupper( esc_html( $support_title ) ); ?></h2>
						<?php endif; ?>
						<?php if ( $support_short_desc != '' ): ?>
                            <blockquote><?php echo strtoupper( esc_textarea( $support_short_desc ) ); ?></blockquote>
						<?php endif; ?>
						<?php if ( $support_desc != '' ): ?>
							<?php echo apply_filters( 'the_content', $support_desc ); ?>
						<?php endif; ?>

                        <div class="deliver-box">
                            <a href="https://fs23.formsite.com/arman1234/form58/index.html?1384737263957"
                               class="icon deliver"></a>
                            <h4><a href="https://fs23.formsite.com/arman1234/form58/index.html?1384737263957">FREE
                                    BUSINESS PICKUP</a></h4>
                            <p>Minimum 20 total qualified items, including Computers, Laptops, Monitors or TVs
                                required</p>
                        </div>
                        <div class="powered"><span>Powered By:</span><span class="allgreen"></span></div>
                    </div>
                    <div class="content-footer">
						<?php if ( ! empty( $next_event_date ) ): ?>
                            <div class="event-date">
                                <span>Next Event: <?php echo date( "F d, Y", strtotime( esc_html( $next_event_date ) ) ); ?></span>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
                <div class="form-holder">
                    <div class="inner-holder">
                        <p>Show your support by pledging to recycle for our cause and we'll send you a reminder so you
                            don't forget about this event.</p>
						<?php echo do_shortcode( '[gravityform id="12" title="false" description="false" ajax="true"]' ); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content bg-dark-color strip">
            <div class="holder">
                <div class="social-group">
                    <h3>Share
                        <small>Our cause:</small>
                    </h3>
                    <ul>
                        <li>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_the_permalink() ); ?>"
                               target="_blank"><span class="fa fa-facebook"></span></a>
                        </li>
                        <li>
                            <a href="https://twitter.com/home?status=<?php echo urlencode( get_the_title() ); ?>%20:%20<?php echo urlencode( get_the_permalink() ); ?>"
                               target="_blank"><span class="fa fa-twitter"></span></a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode( get_the_permalink() ); ?>&amp;title=<?php echo urlencode( get_the_title() ); ?>&amp;summary=&amp;source="
                               target="_blank"><span class="fa fa-linkedin"></span></a>
                        </li>
                     <!--<li>
                            <a href="https://plus.google.com/share?url=<?php echo urlencode( get_the_permalink() ); ?>"
                               target="_blank"><span class="fa fa-google-plus"></span></a>
                        </li>-->
                    </ul>
                </div>
				<?php if ( $total_collected_title != '' || $total_collected_amt != '' ): ?>
                    <div class="content">
						<?php if ( $total_collected_title != '' ): ?>
                            <div class="title-holder">
                                <h3><?php echo wp_kses_post( $total_collected_title ); ?></h3>
                            </div>
						<?php endif; ?>
						<?php if ( $total_collected_amt != '' ): ?>
                            <div class="amt-holder">
                                <span class="amount"><?php echo esc_html( $total_collected_amt ); ?></span>
                            </div>
						<?php endif; ?>
                    </div>
				<?php endif; ?>
            </div>
        </div>
		<?php if ( is_array( $upcoming_events ) && array_key_exists( 'title', $upcoming_events[0] ) ): ?>
            <div class="page-content bg-bright fullwidth events-list">
                <div class="holder">
                    <div class="inner-container">
						<?php foreach ( (array) $upcoming_events as $event ): ?>
                            <div class="item">
                                <div class="content">
									<?php echo wp_get_attachment_image( $event['thumbnail_id'], [ 360, 175 ] ); ?>
                                    <div class="detail">
                                        <h3><?php echo trim( strtolower( $event['title'] ) ) === 'business pickup' ? 'E-waste Business Pickup' : esc_html( $event['title'] ); ?></h3>
										<?php
										$event_description = array_key_exists( 'description', $event ) ? $event['description'] : '';
										$event_location    = array_key_exists( '_event_location', $event ) ? wpautop( esc_textarea( $event['_event_location'] ) ) : '';
										$event_date_time   = array_key_exists( '_event_date_time', $event ) ? wpautop( esc_textarea( $event['_event_date_time'] ) ) : '';
										if ( $event_description != '' ):
											echo apply_filters( 'the_content', $event_description );
										endif;
										if ( $event_location != '' ):
											echo '<strong>Where: </strong>' . $event_location;
										endif;
										if ( $event_date_time != '' ):
											echo '<strong>When: </strong>' . $event_date_time;
										endif;
										?>
                                        <div class="detail-footer">
                                            <a href="<?php echo esc_url( $event['link'] ); ?>">Learn More
                                                <span class="fa fa-plus"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
						<?php endforeach; ?>
                    </div>
                </div>
            </div>
		<?php endif; ?>
		<?php if ( is_array( $event_row_contents ) && array_key_exists( 'title', $event_row_contents[0] ) ): ?>
            <div class="page-content fullwidth event-main">
                <div class="holder">
					<?php
					$count      = 1;
					$total_data = count( $event_row_contents );
					foreach ( (array) $event_row_contents as $content ):
						$row_class = sanitize_html_class( $count % 2 === 0 ? 'even' : 'odd' ); ?>
                        <div class="item <?php echo $row_class; ?>">
                            <div class="content">
                                <h3><?php echo wp_kses( $content['title'], [ 'span' => [] ] ); ?></h3>
								<?php echo apply_filters( 'the_content', $content['description'] ); ?>
								<?php if ( $count == 4 && $content['flyer'] != '' ):
									echo '<a href="' . esc_url( $content['flyer'] ) . '" class="btn onhover" target="_blank"><span class="fa fa-plus"></span> Click here for Event Flyer</a>';
								endif;
								if ( $count == 5 ):
									echo '<a href="https://allgreenrecycling.com/drop-off-locations/" class="btn onhover">See All Drop-Off Locations <span class="fa fa-plus"></span></a>';
								endif;
								if ( $count == 6 ):
									echo '<a href="http://fs23.formsite.com/arman1234/form58/index.html?1384737263957" class="btn onhover" target="_blank">Donation Program Link <span class="fa fa-plus"></span></a>';
								endif; ?>
                            </div>
                            <div class="image-container">
								<?php echo wp_get_attachment_image( $content['thumbnail_id'], 'full' ); ?>
                            </div>
                        </div>
						<?php echo $count < $total_data ? '<hr/>' : ''; ?><?php $count ++;
					endforeach; ?>
                </div>
            </div>
		<?php endif; ?>
		<?php if ( is_array( $past_events ) && array_key_exists( 'date', $past_events[0] ) ): ?>
            <div class="page-content fullwidth bg-bright events-list past-events">
                <div class="holder">
                    <div class="content-header">
                        <h2>Past Events</h2>
                    </div>
                    <div class="inner-container">
						<?php
						$count = 1;
						foreach ( (array) $past_events as $event ):?>
                            <div class="item">
                                <div class="content">
									<?php
									$images = get_post_meta( $post_id, 'image', true );
									if ( is_array( $event['image'] ) ): ?>
                                        <div class="image-container">
											<?php foreach ( $event['image'] as $image_id => $image_url ):
												echo wp_get_attachment_image( $image_id, [
													350,
													250
												], null, [ 'class' => 'img-responsive' ] );
											endforeach; ?>
                                        </div>
                                        <div class="thumbnail">
											<?php foreach ( $event['image'] as $image_id => $image_url ): ?>
                                                <div class="item"><?php echo wp_get_attachment_image( $image_id, [
														48,
														48
													] ); ?></div>
											<?php endforeach; ?>
                                        </div>
									<?php endif; ?>
                                    <div class="detail">
                                        <div class="date-holder">
											<?php
											$date = date_create( esc_html( $event['date'] ) );
											echo date_format( $date, "F d, Y" );
											?>
                                        </div>
										<?php echo apply_filters( 'the_content', $event['description'] ); ?>
                                    </div>
                                    <ul class="total-holder">
                                        <li class="total-title">Total raised:</li>
                                        <li class="total-value">
											<?php if ( array_key_exists( 'total_raised', $event ) ):
												echo esc_html( $event['total_raised'] );
											endif; ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
							<?php $count ++; endforeach; ?>
                    </div>
                    <div class="aligncenter">
                        <a href="/submit-request/" class="button button-medium">Pledge To Recycle</a>
                    </div>
                </div>
            </div>
		<?php endif; ?>
    </div>
<?php endwhile;
get_footer( 'event' );