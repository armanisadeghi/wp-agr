<?php
/*
 * Template Name: SST Drop Off locations
 */
get_header();
while ( have_posts() ): the_post(); ?>
    <div class="page-content fullpage">
        <div class="holder">
            <article class="main-container">
				<?php the_title( '<h1>', '</h1>' ); ?>
				<?php if ( has_post_thumbnail() ):
					the_post_thumbnail();
				endif; ?>
                <div class="editor-content">
					<?php the_content(); ?>
                    <div class="dropoff-search-results">

                    </div>

                </div>
            </article>
			<?php get_sidebar(); ?>
        </div>
    </div>
<?php endwhile;
get_footer();
if ( array_key_exists( 'dropoff-search-zip-code', $_GET ) && $_GET['dropoff-search-zip-code'] != '' ): ?>
    <script>
        var firstRun = function () {
            var results = jQuery('.dropoff-search-results');
            jQuery("input,button").attr('disabled', 'disabled');
            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: sstAjax.ajaxurl,
                data: {
                    action: "mok_dropoff_loc_by_zip",
                    zip: <?php echo strip_tags( $_GET['dropoff-search-zip-code'] ); ?>,
                    range: <?php echo array_key_exists( 'dropoff-search-range', $_GET ) ? strip_tags( $_GET['dropoff-search-range'] ) : 25;?>,
                    secret: sstAjax.secret_sst
                }
            }).done(function (response) {
                jQuery("input,button").removeAttr('disabled');
                if (response.message == "error") {
                    results.html("<p>Couldn't find anything for entered zip code.</p>");
                }
                else {
                    results.html(response);
                }
            }).fail(function () {
                jQuery("input,button").removeAttr('disabled');
                results.html('<p>Something when terribly wrong :(</p>');
            });
        };
        setTimeout(firstRun(), 3000);
    </script>
<?php endif; ?>