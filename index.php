<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Lab_Guideline
 */


get_header();
?>

<main id="main" class="site-main">
	<?php get_template_part('template-parts/hero'); ?>
	<?php get_template_part('template-parts/services'); ?>
	<?php get_template_part('template-parts/service-process'); ?>
	<?php get_template_part('template-parts/team-section'); ?>
</main>

<?php
get_sidebar();
get_footer();
