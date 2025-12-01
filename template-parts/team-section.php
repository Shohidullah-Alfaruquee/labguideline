
<?php
/**
 * Template Name: Team Section
 * Template Post Type: team_section
 */
 
// Get the WordPress header (includes <html>, <head>, <body>, site header, etc.)


/**
 * Display the dynamically queried Team Members section.
 * Call this function where you want the team grid to appear (e.g., front-page.php).
 */
function lab_guideline_display_team_members() {
    
    $args = array(
        'post_type'      => 'team_member',
        'posts_per_page' => -1, // Retrieve all team members
        'orderby'        => 'menu_order', // Order by 'Order' set in Page Attributes
        'order'          => 'ASC',
        'suppress_filters' => true,
    );

    $team_query = new WP_Query( $args );

    if ( $team_query->have_posts() ) : ?>

        <div class="team-grid">
            <?php while ( $team_query->have_posts() ) : $team_query->the_post(); 
                
                // Retrieve data
                $image_url    = get_the_post_thumbnail_url( get_the_ID(), 'medium' ); // Adjust size if needed
                $credentials  = get_post_meta( get_the_ID(), '_team_member_credentials', true );
                $designation  = get_post_meta( get_the_ID(), '_team_member_designation', true );
                $description  = get_post_meta( get_the_ID(), '_team_member_description', true );
                $expertise    = get_post_meta( get_the_ID(), '_team_member_expertise', true );
                $contact_link = get_post_meta( get_the_ID(), '_team_member_contact_link', true );
                
                // Prepare expertise tags (assuming comma-separated input)
                $expertise_tags = array_map( 'trim', explode( ',', $expertise ) );
                $expertise_tags = array_filter( $expertise_tags ); // Remove empty tags
                
                // Title for contact button (e.g., 'Consult with [Name]')
                $button_text = sprintf( __( 'Consult with %s', 'labguideline' ), get_the_title() );

                ?>
                
                <div class="team-card">
                    <div class="card-front">
                        <?php if ( $image_url ) : ?>
                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php the_title_attribute(); ?>" class="card-image">
                        <?php endif; ?>
                        <div class="card-info">
                            <h3><?php the_title(); ?></h3>
                            <?php if ( $credentials ) : ?>
                                <div class="credentials"><?php echo esc_html( $credentials ); ?></div>
                            <?php endif; ?>
                            <?php if ( $designation ) : ?>
                                <div class="designation"><?php echo esc_html( $designation ); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="card-back">
                        <div class="card-details">
                            <?php if ( $description ) : ?>
                                <p><?php echo wp_kses_post( $description ); ?></p>
                            <?php endif; ?>
                            <?php if ( ! empty( $expertise_tags ) ) : ?>
                                <div class="expertise-tags">
                                    <?php foreach ( $expertise_tags as $tag ) : ?>
                                        <span><?php echo esc_html( $tag ); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if ( $contact_link ) : ?>
                            <a href="<?php echo esc_url( $contact_link ); ?>" class="contact-btn"><?php echo esc_html( $button_text ); ?></a>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endwhile; wp_reset_postdata(); ?>
        </div>

    <?php endif;
}
?>


<section class="team-section">
    
    <?php 
    // 1. Display the dynamic header
    if ( function_exists( 'lab_guideline_display_team_header' ) ) {
        lab_guideline_display_team_header();
    }
    
    // 2. Display the team members grid
    if ( function_exists( 'lab_guideline_display_team_members' ) ) {
        lab_guideline_display_team_members();
    }
    ?>
    
</section>