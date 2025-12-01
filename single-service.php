<?php

/**
 * The template for displaying all single 'service' posts.
 *
 * @package Lab_Guideline
 */

get_header();
?>


<main id="main" class="site-main">
    <div class="single-article-container">
        <div class="single-article">

            <?php
            while (have_posts()) :
                the_post();

                // Display Service Content
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('service-detail-page'); ?>>
                    <header class="entry-header">
                        <!-- Display Post Title -->
                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>

                        <!-- You can add more meta data here -->
                        <?php
                        $badge_text = get_post_meta(get_the_ID(), 'certification_badge', true);
                        if (!empty($badge_text)) {
                            echo '<span class="service-badge">' . esc_html($badge_text) . '</span>';
                        }
                        ?>
                    </header>

                    <div class="entry-content">
                        <!-- Display Post Featured Image -->
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('large');
                        } ?>

                        <!-- Display Full Post Content -->
                        <?php the_content(); ?>
                    </div>

                    <!-- Add comments section or navigation if needed -->
                <?php
                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
                ?>

        </div>
    </div>
</main><!-- #main -->

<?php
get_footer();
