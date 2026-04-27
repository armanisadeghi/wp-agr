<?php
/**
 * The template for displaying single testimonial page
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 2.0.10
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
get_header();
while ( have_posts() ): the_post();
	$post_id = get_the_ID(); ?>
	<?php get_template_part( 'common/content', 'breadcrumbs' ); ?>
    <div class="page-content main-container fullwidth">
        <div class="holder">
            <article class="post-testimonial post">
                <div class="author vcard clearfix">
					<?php if ( has_post_thumbnail() ): ?>
                        <figure class="alignleft">
							<?php the_post_thumbnail( [ 90, 90 ], [ 'class' => 'img-circle' ] ); ?>
                        </figure>
					<?php endif; ?>
                    <div class="detail">
                        <h1><?php echo get_post_meta( $post_id, '_qwl_testimonial_author', 1 ); ?></h1>

                        <p><?php echo get_post_meta( $post_id, '_qwl_testimonial_author_desc', 1 ); ?></p>
                    </div>
                </div>
                <div class="content-wrapper">
                    <div class="featured-media">
						<?php if ( '' !== get_post_meta( $post_id, '_qwl_testimonial_author_feat_media', 1 ) ):
							echo wp_oembed_get( get_post_meta( $post_id, '_qwl_testimonial_author_feat_media', 1 ) );
						else:
							$galleries = get_post_meta( $post_id, '_qwl_testimonial_author_gallery', 1 );
							if ( is_array( $galleries ) && count( $galleries ) ) :
								foreach ( (array) $galleries as $gallery_id => $gallery_url ):
									echo wp_get_attachment_image( $gallery_id, 'full' );
									break;
								endforeach;
							endif;
						endif; ?>
                    </div>
                    <div class="content-box clearfix">
                        <blockquote>
							<?php the_content(); ?>
                        </blockquote>
                    </div>
                </div>
				<?php
				$galleries = get_post_meta( $post_id, '_qwl_testimonial_author_gallery', 1 );
				if ( is_array( $galleries ) && count( $galleries ) ): ?>
                    <div class="testimonial-gallery">
						<?php foreach ( (array) $galleries as $gallery_id => $gallery_url ):
							if ( '' !== get_post_meta( $post_id, '_qwl_testimonial_author_feat_media', 1 ) ): ?>
                                <a href="<?php echo wp_get_attachment_image_src( $gallery_id, 'full' )[0]; ?>"
                                   class="popup" rel="gallery">
									<?php echo wp_get_attachment_image( $gallery_id, [ 227, 206 ] ); ?>
                                </a>
							<?php endif;
						endforeach; ?>
                    </div>
				<?php endif; ?>
            </article>
        </div>
    </div>
	<?php
	$testimonials = new WP_Query( [
		'post_type'      => 'testimonials',
		'post_status'    => 'publish',
		'posts_per_page' => 3,
		'post__not_in'   => [ $post_id ]
	] );
	if ( $testimonials->have_posts() ): ?>
        <section id="testimonial_list_section">
            <div class="holder">
                <h2>OTHER REVIEWS</h2>
                <div class="grid-view testimonial testimonial-list equal-height">
					<?php while ( $testimonials->have_posts() ): $testimonials->the_post();
						get_template_part( 'common/content', 'testimonial' );
					endwhile;
					wp_reset_postdata(); ?>
                </div>
            </div>
        </section> <!-- #testimonial_list_section ends -->
	<?php endif;
endwhile;
get_footer();