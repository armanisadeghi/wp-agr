<?php
/**
 * The partials for displaying testimonial below featured testimonials at the top of archive page
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Partials
 * @version 2.0.10
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
$post_id                    = get_the_ID();
$testimonial_featured_media = get_post_meta( $post_id, '_qwl_testimonial_author_feat_media', 1 );
$testimonial_gallery        = get_post_meta( $post_id, '_qwl_testimonial_author_gallery', 1 );
$testimonial_author         = get_post_meta( $post_id, '_qwl_testimonial_author', 1 );
$testimonial_author_desc    = get_post_meta( $post_id, '_qwl_testimonial_author_desc', 1 );
$fallback_image_id          = get_option( 'sst_option' )['testimonial-default-image']['id']; ?>
<article <?php post_class( 'post-testimonial post' ); ?> itemtype="http://schema.org/Review" itemscope>
    <div class="featured-media item" itemprop="itemReviewed" itemscope itemtype="http://schema.org/Product">
		<?php
		if ( '' !== $testimonial_featured_media ):
			echo wp_oembed_get( $testimonial_featured_media );
        elseif ( '' !== $testimonial_gallery && is_array( $testimonial_gallery ) ):
			foreach ( (array) $testimonial_gallery as $img_id => $img_path ):
				echo wp_get_attachment_image( $img_id, [ 306, 172 ] );
				break;
			endforeach;
		else:
			echo wp_get_attachment_image( $fallback_image_id, [ 306, 172 ] );
		endif; ?>
    </div>
    <!-- .featured-media ends -->
    <div class="content-wrapper">
        <div class="content-box clearfix">
            <blockquote itemprop="reviewBody">
                <p><?php echo wp_trim_words( get_the_content(), $num_words = 13, '[...]' ); ?></p>
            </blockquote>
            <a class="btn-link" href="<?php the_permalink(); ?>">READ MORE</a>
        </div>
        <div class="author vcard clearfix">
            <figure class="alignleft">
				<?php if ( has_post_thumbnail() ): ?>
					<?php the_post_thumbnail( [ 74, 74 ], [ 'class' => 'img-circle' ] ); ?>
				<?php else: ?>
                    <img
                            src="<?php echo get_theme_file_uri( 'assets/images/default_avatar.png' ); ?>"
                            alt="<?php the_title(); ?>" width="74" height="74" itemprop="image"/>
				<?php endif; ?>
            </figure>

            <div class="detail" itemprop="author" itemscope itemtype="http://schema.org/Person">
                <h3 itemprop="name"><?php echo $testimonial_author; ?></h3>
				<?php echo wpautop( $testimonial_author_desc ); ?>
            </div>

            <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                <meta itemprop="ratingValue" content="5"/>
            </div>
        </div>
        <!-- .author ends -->
    </div>
</article>
<!-- .post-testimonial ends -->