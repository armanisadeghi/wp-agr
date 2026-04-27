<?php
/*
 * Template Name: SST Thank You
 */
get_header(); ?>
    <!-- Page Header -->
<?php
$post_id = get_the_ID();

$banner_img       = get_post_meta( $post_id, '_ttm_thank_you_banner_img_id', 1 );
$banner_guide_img = get_post_meta( $post_id, '_ttm_thank_you_banner_guide_img_id', 1 );
$banner_style     = get_post_meta( $post_id, '_ttm_thank_you_banner_content_style', 1 );
$banner_content   = get_post_meta( $post_id, '_ttm_thank_you_banner_content', 1 ); ?>
<?php if ( '' != $banner_img ): ?>
    <div id="billboard">
		<?php if ( $banner_img != '' ): ?>
            <div class="billboard-inner">
                <figure>
					<?php echo wp_get_attachment_image( $banner_img, 'full' ); ?>
                </figure>
                <div class="billboard-content overlay <?php echo $banner_style; ?>">
                    <div class="holder">
                        <!--- figure>
							<?php echo wp_get_attachment_image( $banner_guide_img, 'full' ); ?>
                        </figure -->
                        <div class="detail">
							<?php echo wpautop( $banner_content ); ?>
                        </div>
                    </div>
                </div>
            </div>
		<?php endif; ?>
    </div><!-- Billboard Container -->
<?php endif; ?>
    <div class="page-content fullwidth">
        <div class="services-block">
            <div class="holder">
                <article class="main-container fullwidth">
                    <div class="editor-content">
						<?php echo do_shortcode( "[services]" ); ?>
                    </div>
                </article>
            </div>
        </div>

        <div class="blog-posts">
            <div class="holder">
				<?php
				$query_result = new WP_Query( [
					'posts_per_page' => 3,
					'post_type'      => 'post',
					'post_status'    => 'publish'
				] );
				if ( $query_result->have_posts() ): ?>
                    <h4 class="post-title">Learn More Reading Our Newest Blog Posts</h4>

                    <div class="blog-list clearfix">
						<?php while ( $query_result->have_posts() ):
							$query_result->the_post(); ?>
                            <div <?php post_class(); ?>>
                                <div class="content-wrapper">
                                    <div class="content">
										<?php if ( has_post_thumbnail() ): ?>
                                            <figure class="post-thumbnail">
                                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( [
														276,
														156
													] ); ?></a>
                                            </figure>
										<?php endif; ?>
                                        <div class="post-content">
                                            <div class="post-data">
                                                <h4>
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h4>

                                                <p><?php echo wp_trim_words( apply_filters( 'the_content', $post->post_content ),
														$num_words = 10, $more = false ); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
						<?php endwhile;
						wp_reset_postdata(); ?>
                    </div>
				<?php endif; ?>
            </div>
        </div>
        <div class="location-list-holder">
            <div class="holder">
				<?php
				if ( is_active_sidebar( 'location-widget' ) ):
					dynamic_sidebar( 'location-widget' );
				endif; ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>