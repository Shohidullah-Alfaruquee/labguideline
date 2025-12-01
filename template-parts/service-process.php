<?php
/**
 * Template Name: Service Process
 * Template Post Type: service_process
 */
 
// Get the WordPress header (includes <html>, <head>, <body>, site header, etc.)

?>

<section class="service-process">
    <div class="service-process-container">
        <?php 
        // Calls the dynamic header function
        if ( function_exists( 'lab_guideline_display_service_process_header' ) ) {
            lab_guideline_display_service_process_header();
        }
        ?>
        <?php
        // Arguments for WP_Query: fetch all posts of type 'service_step' ordered by 'menu_order'
        $steps_query = new WP_Query( array(
            'post_type'      => 'service_step', 
            'posts_per_page' => -1, // Get all posts
            'order'          => 'ASC',
            'orderby'        => 'menu_order', // Order based on 'Order' field in Page Attributes
        ) );

        $step_counter = 1; // Initialize a counter for step numbering
        ?>

        <div class="service-process-tabs">
            <?php
            if ( $steps_query->have_posts() ) :
                while ( $steps_query->have_posts() ) : $steps_query->the_post();
                    
                    // Get the post slug to use as data-tab attribute
                    $step_slug = get_post_field( 'post_name', get_the_ID() );
                    // Set 'active' class for the first step
                    $active_class = ( $step_counter === 1 ) ? ' active' : '';
                    // Get the Font Awesome class dynamically using get_post_meta
// The meta key is '_service_step_icon_class'
$icon_class = get_post_meta( get_the_ID(), '_service_step_icon_class', true ); 

// Check if the icon class is set, otherwise use a fallback
if ( empty( $icon_class ) ) {
    $icon_class = 'fas fa-cogs'; // Fallback icon
}
                    ?>
                    
                    <div class="service-process-tab<?php echo esc_attr( $active_class ); ?>" data-tab="<?php echo esc_attr( $step_slug ); ?>">
                        <div class="service-process-tab-icon">
                            <i class="<?php echo esc_attr( $icon_class ); ?>"></i> 
                        </div>
                        <div class="service-process-tab-title">
                            <span class="service-process-step-number"><?php echo $step_counter; ?></span> <?php the_title(); ?>
                        </div>
                    </div>
                    
                    <?php
                    $step_counter++;
                endwhile;
                // Reset post data after the loop
                wp_reset_postdata(); 
            endif; 
            ?>
        </div>
        <div class="service-process-content-container">
            <div class="service-process-bg-pattern"></div>
            
            <?php
            // Re-run the query to loop through contents (The second loop is necessary as the first loop consumed the posts)
            $steps_query->rewind_posts(); 
            $step_counter = 1; // Reset counter for content sections

            if ( $steps_query->have_posts() ) :
                while ( $steps_query->have_posts() ) : $steps_query->the_post();
                    
                    $step_slug = get_post_field( 'post_name', get_the_ID() );
                    $active_class = ( $step_counter === 1 ) ? ' active' : ''; 
                    
                    ?>
                    
                    <div class="service-process-tab-content<?php echo esc_attr( $active_class ); ?>" id="<?php echo esc_attr( $step_slug ); ?>">
                        
                        <div class="service-process-text-content">
                            <h3><?php the_title(); ?></h3>
                            <?php the_content(); // The content from the WordPress editor ?>
                            
                            </div>
                        
                        <div class="service-process-image-content">
                            <?php 
                            // Display the Featured Image (Post Thumbnail) if set
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'medium', array( 'alt' => get_the_title() ) ); 
                            } 
                            ?>
                        </div>
                        
                        <div class="service-process-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                    <?php
                    $step_counter++;
                endwhile;
                // Reset post data after the loop
                wp_reset_postdata(); 
            endif;
            ?>

        </div>
        <div class="service-process-indicator">
            <div class="service-process-indicator-dot active" data-tab="gap-analysis"></div>
            <div class="service-process-indicator-dot" data-tab="documentation"></div>
            <div class="service-process-indicator-dot" data-tab="training"></div>
            <div class="service-process-indicator-dot" data-tab="onsite"></div>
            <div class="service-process-indicator-dot" data-tab="certification"></div>
        </div>

        <div class="service-process-footer">
            <p>Our comprehensive 5-step service process ensures a smooth transition to certified compliance with
                minimal disruption to your operations.</p>
        </div>
    </div>
</section>

<?php 