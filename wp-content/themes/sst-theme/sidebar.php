<?php
/**
 * The template for displaying sidebar on pages where it is included
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.4.4
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
 
   $author_bio_display = get_post_meta(get_the_ID(), 'author_bio_display', true);
?>
<div class="sidebar">
	<?php do_action( 'mok_before_sidebar' ); ?>
	<?php if ( is_singular( [ 'post' ] ) && apply_filters( 'blog_author_display_sidebar', 1 ) && $author_bio_display == 'yes' ): ?>
        <section class="widget widget_author_info">
            <h4 class="widget-title">About the Author</h4>
            <div class="author-meta">
                <div class="author-img">
					<?php
					$author_id = get_the_author_meta( 'ID' );
					$image_id  = get_the_author_meta( '_qwl_avatar_id', $author_id );
					if ( is_array( $image_id ) || $image_id != '' ):
						echo wp_get_attachment_image( $image_id );
					else:
						echo get_avatar( $author_id, 124 );
					endif; ?>
                </div>
                <h3 class="author-name"><?php echo ucwords( get_the_author() ); ?></h3>
                <span class="author-desc">
                    <?php echo get_the_author_meta( '_qwl_designation', $author_id ); ?>
                </span>
            </div>
            <div class="author-desc">
				<?php echo get_the_author_meta( 'description', $author_id ); ?>
            </div>
        </section>
	<?php endif; ?>
	<?php if ( is_active_sidebar( 'sidebar-widget' ) && ! is_singular( 'job' ) ):
		dynamic_sidebar( 'sidebar-widget' );
	endif; ?>
	<?php do_action( 'mok_after_sidebar' ); ?>
</div>