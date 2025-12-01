<?php 
/**
 * Lab Guideline Theme Customizer
 *
 * @package Lab_Guideline
 */ 
//services  section  code
function labguideline_custom_service_post_type() {
    register_post_type('service',
        array(
            'labels' => array(
                'name' => __('Services'),
                'singular_name' => __('Service')
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-beaker', // Icon for the admin menu
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'rewrite' => array('slug' => 'services'),
        )
    );
}

add_action('init', 'labguideline_custom_service_post_type');

// Meta box for Service CPT
function labguideline_add_service_meta_boxes() {
    add_meta_box(
        'labguideline_service_details',
        __('Service Details', 'labguideline'),
        'labguideline_service_meta_box_html',
        'service',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'labguideline_add_service_meta_boxes');

function labguideline_service_meta_box_html($post) {
    wp_nonce_field('labguideline_save_service_meta_data', 'labguideline_service_meta_nonce');

    $icon = get_post_meta($post->ID, '_service_icon_key', true);
    $badge = get_post_meta($post->ID, '_service_badge_key', true);
    ?>
    <p>
        <label for="service_icon"><?php _e('Icon', 'labguideline'); ?></label>
        <input type="text" id="service_icon" name="service_icon" value="<?php echo esc_attr($icon); ?>" class="widefat">
        <span class="description"><?php _e('Enter a Font Awesome class (e.g., "fa-solid fa-vial").', 'labguideline'); ?></span>
    </p>
    <p>
        <label for="service_badge"><?php _e('Badge', 'labguideline'); ?></label>
        <input type="text" id="service_badge" name="service_badge" value="<?php echo esc_attr($badge); ?>" class="widefat">
    </p>
    <?php
}

function labguideline_save_service_meta_data($post_id) {
    if (!isset($_POST['labguideline_service_meta_nonce']) || !wp_verify_nonce($_POST['labguideline_service_meta_nonce'], 'labguideline_save_service_meta_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['service_icon'])) {
        update_post_meta($post_id, '_service_icon_key', sanitize_text_field($_POST['service_icon']));
    }
    if (isset($_POST['service_badge'])) {
        update_post_meta($post_id, '_service_badge_key', sanitize_text_field($_POST['service_badge']));
    }
}
add_action('save_post', 'labguideline_save_service_meta_data');
?>