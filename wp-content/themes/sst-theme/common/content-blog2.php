<?php
/**
 * The partials for displaying default blog list without author name based on theme options
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Partials
 * @version 1.1.0
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */

global $count;
global $post; ?>
<div <?php post_class(); ?>>
    <div class="clearfix">
        <div class="content-wrapper">
            <div class="content">
                <div class="row post-row">
                    <div class="post-thumbnail">
                        <a href="<?php the_permalink(); ?>">
							<?php
							$sizes       = [
								0 => [ 308, 172 ],
								1 => [ 821, 490 ],
								2 => [ 279, 155 ],
								3 => [ 279, 155 ],
								4 => [ 279, 155 ],
								5 => [ 549, 306 ],
								6 => [ 549, 306 ],
							];
							$size_number = $count > 6 ? 0 : $count;
							if ( has_post_thumbnail() ):
								the_post_thumbnail( $sizes[ $size_number ] );
							else:
								echo wp_get_attachment_image( get_option( 'sst_option' )['blog-default-image']['id'], $sizes[ $size_number ] );
							endif; ?>
                        </a>
                    </div>
                    <div class="post-content">
						<?php if ( $count == 1 ): ?>
                            <div class="author-info">
                                <h1>Featured Article</h1>
                            </div>
						<?php endif; ?>
                        <div class="post-data">
							<?php if ( $count == 2 || $count == 3 || $count == 4 ) { ?>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <p><?php echo wp_trim_words( apply_filters( 'the_content', $post->post_content ), $num_words = 30, $more = '..' ); ?></p>
							<?php } elseif ( $count == 1 ) { ?>
                                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <p><?php echo wp_trim_words( apply_filters( 'the_content', $post->post_content ), $num_words = 30, $more = '..' ); ?></p>
							<?php } elseif ( $count == 5 || $count == 6 ) { ?>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <p><?php echo wp_trim_words( apply_filters( 'the_content', $post->post_content ), $num_words = 20, $more = '..' ); ?></p>
							<?php } else { ?>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <p><?php echo wp_trim_words( apply_filters( 'the_content', $post->post_content ), $num_words = 30, $more = '..' ); ?></p>
							<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>