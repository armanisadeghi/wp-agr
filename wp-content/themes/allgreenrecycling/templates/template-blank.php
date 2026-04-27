<?php
/**
 * Template Name: Blank page
 *
 * A custom page template without sidebar.
 *
 * @package WordPress
 * @subpackage allgreen
 * @since allgreen v1.0
 */
?>
<html>
	<head>
		<style>
			body,
			html {
				margin: 0;
				padding: 0;
			}

			#csbwfs-delaydiv {
				display: none;
			}
		</style>
	</head>
	<body>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
	<?php endwhile; endif; ?>
	</body>
</html>