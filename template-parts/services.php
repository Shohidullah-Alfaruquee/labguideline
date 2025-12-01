<?php
/**
 * Template Name: Service
 * Template Post Type: service
 */
 
// Get the WordPress header (includes <html>, <head>, <body>, site header, etc.)

?>


<section class="service" id="services">
           <?php 
        // Calls the dynamic header function
        if ( function_exists( 'lab_guideline_display_service_header' ) ) {
            lab_guideline_display_service_header();
        }
        ?>

    <div class="services-container">
        <?php
        // Query arguments: Get 6 posts of type 'service'
        $args = array(
            'post_type'      => 'service',
            'posts_per_page' => 6,
            'orderby'        => 'date',
            'order'          => 'DESC'
        );

        $services_query = new WP_Query($args);

        if ($services_query->have_posts()) :
            while ($services_query->have_posts()) : $services_query->the_post();

                // Get Custom Fields - ***Corrected Meta Keys used here***
                $icon_class = get_post_meta(get_the_ID(), '_service_icon_key', true);    // Changed to CPT-defined key
                $badge_text = get_post_meta(get_the_ID(), '_service_badge_key', true); // Changed to CPT-defined key
                ?>

                <div class="service-card">
                    <div class="card-image">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                        <?php endif; ?>

                        <?php if (!empty($badge_text)) : ?>
                            <div class="certification-badge"><?php echo esc_html($badge_text); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="card-content">
                        <?php if (!empty($icon_class)) : ?>
                            <div class="service-icon">
                                <i class="<?php echo esc_attr($icon_class); ?>"></i>
                            </div>
                        <?php endif; ?>

                        <h3><?php the_title(); ?></h3>
                        
                        <p><?php echo get_the_excerpt(); ?></p>
                        
                        <a href="<?php the_permalink(); ?>" class="read-more">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

            <?php endwhile;
            wp_reset_postdata(); // Reset query for the rest of the page
        else : ?>
            <p>No services found.</p>
        <?php endif; ?>
    </div>
</section>