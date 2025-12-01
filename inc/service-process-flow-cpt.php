<?php
/**
 * Lab Guideline Theme Customizer
 *
 * @package Lab_Guideline
 */ 

// ----------------------------------------------------
// 1. CUSTOM POST TYPE (CPT) REGISTRATION - SERVICE STEP
// ----------------------------------------------------

function register_service_process_cpt() {

    // Labels for the custom post type in the Admin UI
    $labels = array(
        'name'                  => _x( 'Service Steps', 'Post Type General Name', 'your-text-domain' ),
        'singular_name'         => _x( 'Service Step', 'Post Type Singular Name', 'your-text-domain' ),
        'menu_name'             => __( 'Service Process', 'your-text-domain' ),
        'name_admin_bar'        => __( 'Service Step', 'your-text-domain' ),
        'all_items'             => __( 'All Steps', 'your-text-domain' ),
        'add_new_item'          => __( 'Add New Step', 'your-text-domain' ),
        'add_new'               => __( 'Add New', 'your-text-domain' ),
        'new_item'              => __( 'New Step', 'your-text-domain' ),
        'edit_item'             => __( 'Edit Step', 'your-text-domain' ),
        'update_item'           => __( 'Update Step', 'your-text-domain' ),
        'view_item'             => __( 'View Step', 'your-text-domain' ),
        'view_items'            => __( 'View Steps', 'your-text-domain' ),
    );
    
    // Arguments to define the CPT behavior
    $args = array(
        'label'                 => __( 'Service Step', 'your-text-domain' ),
        'description'           => __( 'Steps for the service process flow.', 'your-text-domain' ),
        'labels'                => $labels,
        // Supports Title, Content Editor, Featured Image, and Page Attributes (for ordering)
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-networking',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false, // Prevent public access to individual CPT pages
        'capability_type'       => 'post',
        'rewrite'               => false, // No rewrite needed as they are not public pages
        'query_var'             => false, // No query variable needed
    );
    
    // Register the CPT with slug 'service_step'
    register_post_type( 'service_step', $args );

}

add_action( 'init', 'register_service_process_cpt', 0 );
// ----------------------------------------------------
// 2. CUSTOM META BOX REGISTRATION AND DISPLAY
// ----------------------------------------------------



/**
 * Register the meta box for the 'service_step' CPT.
 */
function service_step_add_icon_meta_box() {
    add_meta_box(
        'service_step_icon_field',             // Unique ID
        __( 'Service Step Icon Class', 'your-text-domain' ), // Box title
        'service_step_icon_meta_box_callback', // Callback function to display the fields
        'service_step',                        // Custom Post Type slug
        'normal',                              // Context (e.g., 'normal', 'side')
        'high'                                 // Priority
    );
}

// Hook into WordPress to add the meta box
add_action( 'add_meta_boxes', 'service_step_add_icon_meta_box' );

/**
 * Display the custom field in the meta box.
 * This HTML field will store the Font Awesome class (e.g., fas fa-search).
 * @param WP_Post $post The current post object.
 */
function service_step_icon_meta_box_callback( $post ) {
    // Security check: Use a nonce field for security (important!)
    wp_nonce_field( 'service_step_icon_save', 'service_step_icon_nonce' );

    // Get the current value from the database
    $icon_class = get_post_meta( $post->ID, '_service_step_icon_class', true );
    ?>
    
    <p>
        <label for="step_icon_class_input"><?php _e( 'Font Awesome Icon Class (e.g., fas fa-search)', 'your-text-domain' ); ?></label>
        <br>
        <input 
            type="text" 
            id="step_icon_class_input" 
            name="step_icon_class_input" 
            value="<?php echo esc_attr( $icon_class ); ?>" 
            size="50"
            placeholder="e.g., fas fa-search"
        />
        <p class="description"><?php _e( 'Enter the full Font Awesome class name.', 'your-text-domain' ); ?></p>
    </p>

    <?php
}


// ----------------------------------------------------
// 3. META DATA SAVING
// ----------------------------------------------------

/**
 * Save the meta box data when the post is saved.
 * @param int $post_id The ID of the post being saved.
 */
function service_step_save_icon_meta_box( $post_id ) {
    
    // Check if the current post type is 'service_step' (Crucial Check)
    if ( get_post_type( $post_id ) !== 'service_step' ) {
        return $post_id;
    }
    
    // Check if our nonce is set (Security Check 1)
    if ( ! isset( $_POST['service_step_icon_nonce'] ) ) {
        return $post_id;
    }

    // Verify that the nonce is valid (Security Check 2)
    if ( ! wp_verify_nonce( $_POST['service_step_icon_nonce'], 'service_step_icon_save' ) ) {
        return $post_id;
    }
    
    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }

    // Check the user's permissions (Security Check 3)
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }

    // Check if the input field is set
    if ( ! isset( $_POST['step_icon_class_input'] ) ) {
        return $post_id;
    }

    // Sanitize the user input before saving to the database
    $new_icon_class = sanitize_text_field( $_POST['step_icon_class_input'] );
    
    // Get the existing value
    $old_icon_class = get_post_meta( $post_id, '_service_step_icon_class', true );

    // Update the meta data in the database
    $meta_key = '_service_step_icon_class';
    
    if ( ! empty( $new_icon_class ) ) {
        // If the new value is not empty, update it
        update_post_meta( $post_id, $meta_key, $new_icon_class );
    } elseif ( empty( $new_icon_class ) && ! empty( $old_icon_class ) ) {
        // If the new value is empty, but an old value existed, delete the old value
        delete_post_meta( $post_id, $meta_key, $old_icon_class );
    }
}
// Hook into WordPress to save the meta box data
add_action( 'save_post', 'service_step_save_icon_meta_box' );
// End of functions.php

?>