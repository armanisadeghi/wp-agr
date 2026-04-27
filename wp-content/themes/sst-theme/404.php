<?php
/**
 * The template for displaying 404 pages
 *
 * @package Moksha Design Studio
 * @subpackage SST Theme
 * @category Template
 * @version 1.4.4
 * @author  Moksha Design Studio <webmaster@mokshastudio.com>
 */
get_header(); ?>
    <div class="page-content">
        <div class="holder">
            <article class="main-container">
                <h1>Page not found</h1>
                <p>The page you are looking for could not be found. <a href="<?php echo home_url(); ?>">Click here</a>
                    to go to homepage</p>
            </article>
			<?php get_sidebar(); ?>
        </div>
    </div>
<?php get_footer(); ?>