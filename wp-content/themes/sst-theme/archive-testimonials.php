<?php
/**
 * The template for displaying testimonial archive
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 2.0.10
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
get_header(); ?>
    <div class="pg-title clearfix">
        <div class="holder">
            <h1 class="alignright">Get an inside look at the people, places and ideas that moves us.</h1>
            <div class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">
				<?php bcn_display(); ?>
            </div>
        </div>
    </div>
<?php
$testimonials = new WP_Query( [
	'post_type'      => 'testimonials',
	'post_status'    => 'publish',
	'posts_per_page' => 3,
	'meta_query'     => [
		[ 'key' => '_qwl_testimonial_featured' ]
	]
] );

if ( $testimonials->have_posts() ): ?>
    <section class="featured-testimonial-section dark-theme">
        <div class="holder">
            <div id="testimonial_slider">
                <div class="slick-slider">
					<?php while ( $testimonials->have_posts() ): $testimonials->the_post();
						$post_id = get_the_ID(); ?>
                        <div>
                            <article <?php post_class( 'post-testimonial post clearfix equal-height' ); ?>>
                                <div class="content-wrapper item">
                                    <div class="author vcard clearfix">
                                        <figure class="alignleft">
											<?php if ( has_post_thumbnail() ): ?>
												<?php the_post_thumbnail( [
													90,
													90
												], [ 'class' => 'img-circle' ] ); ?>
											<?php else: ?>
                                                <img
                                                        src="<?php echo get_theme_file_uri( 'assets/images/default_avatar.png' ); ?>"
                                                        alt="<?php the_title(); ?>" width="90" height="90"/>
											<?php endif; ?>
                                        </figure>
                                        <div class="detail">
                                            <h3>
                                                <a href="<?php the_permalink(); ?>"><?php echo get_post_meta( $post_id, '_qwl_testimonial_author', 1 ); ?></a>
                                            </h3>
                                            <p><?php echo get_post_meta( $post_id, '_qwl_testimonial_author_desc', 1 ); ?></p>
                                        </div>
                                    </div>
                                    <!-- .author ends -->
                                    <div class="content-box clearfix">
                                        <blockquote>
											<?php the_excerpt(); ?>
                                        </blockquote>
                                    </div>
                                </div>
                                <div class="featured-media item">
									<?php
									if ( '' !== get_post_meta( $post_id, '_qwl_testimonial_author_feat_media', 1 ) ):
										echo wp_oembed_get( get_post_meta( $post_id, '_qwl_testimonial_author_feat_media', 1 ) );
                                    elseif ( '' !== get_post_meta( $post_id, '_qwl_testimonial_author_gallery', 1 ) ):
										$gallery = get_post_meta( $post_id, '_qwl_testimonial_author_gallery', 1 );
										if ( '' !== $gallery || is_array( $gallery ) ):
											foreach ( (array) $gallery as $img_id => $img_path ):
												echo wp_get_attachment_image( $img_id, 'full' );
										        break;
											endforeach;
										endif;
									else:
										echo wp_get_attachment_image( get_option( 'sst_option' )['testimonial-default-image']['id'], [
											306,
											172
										] );
									endif; ?>
                                </div>
                                <!-- .featured-media ends -->
                            </article>
                            <!-- .post-testimonial ends -->
                        </div>
					<?php endwhile;
					wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php if ( have_posts() ): ?>
    <section id="testimonial_list_section">
        <div class="holder">
            <div class="grid-view testimonial testimonial-list equal-height">
				<?php while ( have_posts() ): the_post(); ?>
					<?php get_template_part( 'common/content', 'testimonial' ); ?>
				<?php endwhile; ?>
            </div>
        </div>
    </section> <!-- #testimonial_list_section ends -->
<?php endif; ?>
<?php get_footer(); ?>