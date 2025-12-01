<?php
// ----------------------------------------------------
// 1. CUSTOM POST TYPE (CPT) REGISTRATION - TEAM MEMBER
// ----------------------------------------------------

function register_team_member_cpt() {

    // Labels for the custom post type in the Admin UI
    $labels = array(
        'name'                => _x( 'Team Members', 'Post Type General Name', 'labguideline' ),
        'singular_name'       => _x( 'Team Member', 'Post Type Singular Name', 'labguideline' ),
        'menu_name'           => __( 'Scientific Team', 'labguideline' ),
        'name_admin_bar'      => __( 'Team Member', 'labguideline' ),
        'all_items'           => __( 'All Members', 'labguideline' ),
        'add_new_item'        => __( 'Add New Member', 'labguideline' ),
        'add_new'             => __( 'Add New', 'labguideline' ),
        'new_item'            => __( 'New Member', 'labguideline' ),
        'edit_item'           => __( 'Edit Member', 'labguideline' ),
        'update_item'         => __( 'Update Member', 'labguideline' ),
        'view_item'           => __( 'View Member', 'labguideline' ),
        'view_items'          => __( 'View Members', 'labguideline' ),
    );
    
    // Arguments to define the CPT behavior
    $args = array(
        'label'               => __( 'Team Member', 'labguideline' ),
        'description'         => __( 'Profiles of scientific and regulatory consultants.', 'labguideline' ),
        'labels'              => $labels,
        // Supports: title (for Name), editor (for long description/bio), thumbnail (for Picture), and page-attributes (for ordering)
        'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
        'taxonomies'          => array(),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-groups',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => false, // Usually set to false for single team members
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'capability_type'     => 'post',
        'rewrite'             => false,
        'query_var'           => false,
    );
    
    // Register the CPT with slug 'team_member'
    register_post_type( 'team_member', $args );

}
add_action( 'init', 'register_team_member_cpt', 0 );


// ----------------------------------------------------
// 2. CUSTOM META BOX REGISTRATION AND DISPLAY - TEAM DETAILS
// ----------------------------------------------------

/**
 * Register the meta box for the 'team_member' CPT.
 */
function team_member_add_details_meta_box() {
    add_meta_box(
        'team_member_details_fields',                 // Unique ID
        __( 'Team Member Details', 'labguideline' ), // Box title
        'team_member_details_meta_box_callback',     // Callback function to display the fields
        'team_member',                               // Custom Post Type slug
        'normal',                                    // Context
        'high'                                       // Priority
    );
}
add_action( 'add_meta_boxes', 'team_member_add_details_meta_box' );

/**
 * Display the custom fields in the meta box.
 * @param WP_Post $post The current post object.
 */
function team_member_details_meta_box_callback( $post ) {
    // Security Check: Nonce field
    wp_nonce_field( 'team_member_details_save', 'team_member_details_nonce' );

    // Get current values
    $credentials  = get_post_meta( $post->ID, '_team_member_credentials', true );
    $designation  = get_post_meta( $post->ID, '_team_member_designation', true );
    $description  = get_post_meta( $post->ID, '_team_member_description', true );
    $expertise    = get_post_meta( $post->ID, '_team_member_expertise', true );
    $contact_link = get_post_meta( $post->ID, '_team_member_contact_link', true );
    
    ?>
    
    <p>
        <label for="team_credentials_input"><strong><?php _e( 'Credentials (e.g., Ph.D., RAC)', 'labguideline' ); ?></strong></label>
        <input type="text" id="team_credentials_input" name="team_credentials_input" value="<?php echo esc_attr( $credentials ); ?>" size="60" />
    </p>

    <p>
        <label for="team_designation_input"><strong><?php _e( 'Designation (Job Title)', 'labguideline' ); ?></strong></label>
        <input type="text" id="team_designation_input" name="team_designation_input" value="<?php echo esc_attr( $designation ); ?>" size="60" />
    </p>

    <p>
        <label for="team_description_input"><strong><?php _e( 'Detailed Biography / Description (Card Back)', 'labguideline' ); ?></strong></label>
        <textarea id="team_description_input" name="team_description_input" rows="4" cols="60"><?php echo esc_textarea( $description ); ?></textarea>
    </p>
    
    <p>
        <label for="team_expertise_input"><strong><?php _e( 'Expertise Tags (Comma Separated, e.g., HPLC, GMP Compliance, ICH)', 'labguideline' ); ?></strong></label>
        <input type="text" id="team_expertise_input" name="team_expertise_input" value="<?php echo esc_attr( $expertise ); ?>" size="60" />
        <p class="description"><?php _e( 'Separate each tag with a comma.', 'labguideline' ); ?></p>
    </p>

    <p>
        <label for="team_contact_link_input"><strong><?php _e( 'Contact/Profile Link (e.g., /contact or full URL)', 'labguideline' ); ?></strong></label>
        <input type="url" id="team_contact_link_input" name="team_contact_link_input" value="<?php echo esc_url( $contact_link ); ?>" size="60" />
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
function team_member_save_details_meta_box( $post_id ) {
    
    // Check post type and security (similar to service step CPT saving)
    if ( get_post_type( $post_id ) !== 'team_member' ) return $post_id;
    if ( ! isset( $_POST['team_member_details_nonce'] ) || ! wp_verify_nonce( $_POST['team_member_details_nonce'], 'team_member_details_save' ) ) return $post_id;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return $post_id;

    // Array of fields to process and their sanitization functions
    $fields_to_save = array(
        'team_credentials_input'  => array( 'meta_key' => '_team_member_credentials',  'sanitize' => 'sanitize_text_field' ),
        'team_designation_input'  => array( 'meta_key' => '_team_member_designation',  'sanitize' => 'sanitize_text_field' ),
        'team_description_input'  => array( 'meta_key' => '_team_member_description',  'sanitize' => 'wp_kses_post' ), // Allows basic HTML for rich text/paragraphs
        'team_expertise_input'    => array( 'meta_key' => '_team_member_expertise',    'sanitize' => 'sanitize_text_field' ),
        'team_contact_link_input' => array( 'meta_key' => '_team_member_contact_link', 'sanitize' => 'esc_url_raw' ),
    );

    foreach ( $fields_to_save as $input_name => $data ) {
        if ( isset( $_POST[ $input_name ] ) ) {
            $new_value = call_user_func( $data['sanitize'], $_POST[ $input_name ] );
            $old_value = get_post_meta( $post_id, $data['meta_key'], true );

            if ( ! empty( $new_value ) ) {
                update_post_meta( $post_id, $data['meta_key'], $new_value );
            } elseif ( empty( $new_value ) && ! empty( $old_value ) ) {
                delete_post_meta( $post_id, $data['meta_key'] );
            }
        }
    }
}
add_action( 'save_post', 'team_member_save_details_meta_box' );



?>