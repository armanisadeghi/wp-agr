<?php
$first_column_content  = get_post_meta( $post->ID, '_qwl_four_columns2_column1_content', 1 );
$second_column_content = get_post_meta( $post->ID, '_qwl_four_columns2_column2_content', 1 );
$third_column_content  = get_post_meta( $post->ID, '_qwl_four_columns2_column3_content', 1 );
$fourth_column_content = get_post_meta( $post->ID, '_qwl_four_columns2_column4_content', 1 );

$count = 0;

$first_column_content != '' ? $count ++ : FALSE;
$second_column_content != '' ? $count ++ : FALSE;
$third_column_content != '' ? $count ++ : FALSE;
$fourth_column_content != '' ? $count ++ : FALSE;
if ( $first_column_content != '' || $second_column_content != '' || $third_column_content != '' || $fourth_column_content != '' ):
    ?>
    <div class="page-content fullwidth bg-bright col<?php echo $count; ?>-container">
        <div class="holder">
            <?php for ( $i = 1; $i <= 4; $i ++ ):
                if ( '' != get_post_meta( $post->ID, '_qwl_four_columns2_column' . $i . '_content', 1 ) ):
                    ?>
                    <article class="col">
                        <?php
                        if ( '' != get_post_meta( $post->ID, '_qwl_four_columns2_column' . $i . '_img', 1 ) ) {
                            $img_id = get_post_meta( $post->ID, '_qwl_four_columns2_column' . $i . '_img_id', 1 );
                            ?>
                            <div class="icon-holder icon-target">
                                <?php echo wp_get_attachment_image( $img_id, 'full' ); ?>
                            </div>
                            <?php
                        } else if ( '' != get_post_meta( $post->ID, '_qwl_four_columns2_column' . $i . '_icon',
                                        1 ) && 'none' != get_post_meta( $post->ID,
                                        '_qwl_four_columns2_column' . $i . '_icon', 1 )
                        ) {
                            ?>
                            <div class="icon-holder icon-target">
                                <img
                                        src="<?php echo get_post_meta( $post->ID,
                                                '_qwl_four_columns2_column' . $i . '_icon', 1 ); ?>"
                                        alt="<?php echo get_post_meta( $post->ID,
                                                '_qwl_four_columns2_column' . $i . '_icon_alt', 1 ); ?>">
                            </div>
                        <?php } ?>

                        <?php if ( '' != get_post_meta( $post->ID, '_qwl_four_columns2_column' . $i . '_content',
                                        1 )
                        ): ?>
                            <div class="detail">
                                <?php echo do_shortcode( wpautop( get_post_meta( $post->ID,
                                        '_qwl_four_columns2_column' . $i . '_content', 1 ) ) ); ?>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endif;endfor; ?>
        </div>
    </div>
<?php endif; ?>