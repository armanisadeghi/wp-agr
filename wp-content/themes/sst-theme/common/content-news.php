<?php global $count;
global $post; ?>

<div <?php post_class( 'post' ); ?>>
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
                    <!-- /.post-thumbnail -->
                    <div class="post-content">
						<?php if ( $count == 1 ): ?>
                            <div class="author-info">
                                <h3>Breaking News</h3>
                                <div class="published-date"><?php the_time( 'F j, Y' ); ?></div>
                            </div>
						<?php endif; ?>
                         <div class="post-data">
						<?php if($count == 2 || $count == 3 || $count == 4){ ?>
						<h3><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( apply_filters( 'the_title', $post->post_title ), $num_words = 9, $more = '......' ); ?></a></h3>
						<?php }elseif($count == 1){?>
                            <h1><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( apply_filters( 'the_title', $post->post_title ), $num_words = 15, $more = '......' ); ?></a></h1>
							<?php }elseif($count == 5 || $count == 6){?>
							
							<h3><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( apply_filters( 'the_title', $post->post_title ), $num_words = 5, $more = '......' ); ?></a></h3>
							
							<?php } else{?>
							
							  <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							
							<?php } ?>

                            <p><?php echo wp_trim_words( apply_filters( 'the_content', $post->post_content ), $num_words = 30, $more = '......' ); ?></p>
                        </div>
                        <!-- /.post-data -->
                    </div>
                    <!-- /.col-sm-8 -->
                </div>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
</div>