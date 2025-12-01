<?php
/**
 * Theme Customizer Settings for Lab Guideline.
 *
 * This file combines all customizer settings (Core settings and Hero Section)
 * into a single function to prevent "Cannot redeclare function" fatal errors.
 *
 * @package Lab_Guideline
 */

/**
 * Add postMessage support for site title and description, and register all
 * custom sections, settings, and controls for the theme.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function labguideline_customize_register( $wp_customize ) {
    
    // =========================================================
    // 1. CORE CUSTOMIZER SETTINGS & SELECTIVE REFRESH
    // =========================================================
    
    // Set up transport for core WordPress settings for live preview
    $wp_customize->get_setting( 'blogname' )->transport      = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    // Add selective refresh support for site title and description
    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial(
            'blogname',
            array(
                'selector'          => '.site-title a',
                'render_callback'   => 'labguideline_customize_partial_blogname',
            )
        );
        $wp_customize->selective_refresh->add_partial(
            'blogdescription',
            array(
                'selector'          => '.site-description',
                'render_callback'   => 'labguideline_customize_partial_blogdescription',
            )
        );
    }
    
    // =========================================================
    // 2. HERO SECTION CUSTOM SETTINGS (Merged from first block)
    // =========================================================

    // Create Hero Section
    $wp_customize->add_section('hero_section', array(
        'title'    => __('Section Hero', 'labguideline'),
        'priority' => 30,
    ));

    // Title Setting & Control (Allows HTML for <span> tags)
    $wp_customize->add_setting('hero_title', array('default' => 'Everything You Need for <span>ISO Certification</span>', 'sanitize_callback' => 'wp_kses_post'));
    $wp_customize->add_control('hero_title', array(
        'label'   => __('Hero Title', 'labguideline'),
        'section' => 'hero_section',
        'type'    => 'textarea',
    ));

    // Description Setting & Control (Sanitized as plain text)
    $wp_customize->add_setting('hero_description', array('default' => 'Supporting organizations in reaching their ISO certification objectives with expert guidance and comprehensive solutions.', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('hero_description', array(
        'label'   => __('Hero Description', 'labguideline'),
        'section' => 'hero_section',
        'type'    => 'textarea',
    ));

    // Button 1 Text
    $wp_customize->add_setting('hero_btn1_text', array('default' => 'Our Services', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('hero_btn1_text', array('label' => 'Button 1 Text', 'section' => 'hero_section'));
    
    // Button 1 Link
    $wp_customize->add_setting('hero_btn1_link', array('default' => '/services', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('hero_btn1_link', array('label' => 'Button 1 Link', 'section' => 'hero_section'));

    // Button 2 Text
    $wp_customize->add_setting('hero_btn2_text', array('default' => 'Get Started', 'sanitize_callback' => 'sanitize_text_field'));
    $wp_customize->add_control('hero_btn2_text', array('label' => 'Button 2 Text', 'section' => 'hero_section'));
    
    // Button 2 Link
    $wp_customize->add_setting('hero_btn2_link', array('default' => '/contact', 'sanitize_callback' => 'esc_url_raw'));
    $wp_customize->add_control('hero_btn2_link', array('label' => 'Button 2 Link', 'section' => 'hero_section'));
}
add_action( 'customize_register', 'labguideline_customize_register' );

// Services Section 

function lab_guideline_service_customize_register( $wp_customize ) {

    // 1. Add a new section for Service Process settings
    $wp_customize->add_section( 'service_header_section', array(
        'title'    => __( 'Section Service Header', 'labguideline' ),
        'priority' => 31, // Position it below default sections
    ) );

    // 2. Setting for the Main Title (H2)
    $wp_customize->add_setting( 'service_title', array(
        'default'           => 'Our Laboratory Services', // Default text
        'transport'         => 'refresh', 
        'sanitize_callback' => 'sanitize_text_field', // Sanitize input
    ) );

    // Control for the Main Title
    $wp_customize->add_control( 'service_title_control', array(
        'label'    => __( 'Section Main Title', 'labguideline' ),
        'section'  => 'service_header_section',
        'settings' => 'service_title',
        'type'     => 'text',
    ) );

    // 3. Setting for the Subtitle (P)
    $wp_customize->add_setting( 'service_subtitle', array(
        'default'           => 'Professional services to ensure your laboratory meets international standards and operates with excellence',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    // Control for the Subtitle
    $wp_customize->add_control( 'service_subtitle_control', array(
        'label'    => __( 'Section Subtitle/Description', 'labguideline' ),
        'section'  => 'service_header_section',
        'settings' => 'service_subtitle',
        'type'     => 'textarea', // Use textarea for longer text
    ) );
}
add_action( 'customize_register', 'lab_guideline_service_customize_register' );

/**
 * Helper function to retrieve and display the dynamic service header text.
 * This function will be called directly in the template file.
 * Text domain used: labguideline
 */
function lab_guideline_display_service_header() {
    
    // Retrieve the saved values, falling back to defaults
    $title    = get_theme_mod( 'service_title', __( 'Our Laboratory Services', 'labguideline' ) );
    $subtitle = get_theme_mod( 'service_subtitle', __( 'Professional services to ensure your laboratory meets international standards and operates with excellence', 'labguideline' ) );

    // Display the dynamic HTML structure
    ?>
    <div class="service-header">
        <h1><?php echo esc_html( $title ); ?></h2>
        <p><?php echo esc_html( $subtitle ); ?></p>
    </div>
    <?php
}

// Service Flow section

/**
 * Add custom settings to the Theme Customizer for the Service Process header.
 * Text domain used: labguideline
 */
function lab_guideline_service_process_customize_register( $wp_customize ) {

    // 1. Add a new section for Service Process settings
    $wp_customize->add_section( 'service_process_header_section', array(
        'title'    => __( 'Section Service Process Header', 'labguideline' ),
        'priority' => 32, // Position it below default sections
    ) );

    // 2. Setting for the Main Title (H2)
    $wp_customize->add_setting( 'service_process_title', array(
        'default'           => 'Service Process Flow', // Default text
        'transport'         => 'refresh', 
        'sanitize_callback' => 'sanitize_text_field', // Sanitize input
    ) );

    // Control for the Main Title
    $wp_customize->add_control( 'service_process_title_control', array(
        'label'    => __( 'Section Main Title', 'labguideline' ),
        'section'  => 'service_process_header_section',
        'settings' => 'service_process_title',
        'type'     => 'text',
    ) );

    // 3. Setting for the Subtitle (P)
    $wp_customize->add_setting( 'service_process_subtitle', array(
        'default'           => 'Our structured approach to ensure quality and efficiency',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    // Control for the Subtitle
    $wp_customize->add_control( 'service_process_subtitle_control', array(
        'label'    => __( 'Section Subtitle/Description', 'labguideline' ),
        'section'  => 'service_process_header_section',
        'settings' => 'service_process_subtitle',
        'type'     => 'textarea', // Use textarea for longer text
    ) );
}
add_action( 'customize_register', 'lab_guideline_service_process_customize_register' );

/**
 * Helper function to retrieve and display the dynamic service process header text.
 * This function will be called directly in the template file.
 * Text domain used: labguideline
 */
function lab_guideline_display_service_process_header() {
    
    // Retrieve the saved values, falling back to defaults
    $title    = get_theme_mod( 'service_process_title', __( 'Service Process Flow', 'labguideline' ) );
    $subtitle = get_theme_mod( 'service_process_subtitle', __( 'Our structured approach to ensure quality and efficiency', 'labguideline' ) );

    // Display the dynamic HTML structure
    ?>
    <div class="service-process-header">
        <h2><?php echo esc_html( $title ); ?></h2>
        <p><?php echo esc_html( $subtitle ); ?></p>
    </div>
    <?php
}

// Team section
/**
 * Add custom settings to the Theme Customizer for the team section header.
 * Text domain used: labguideline
 */
function lab_guideline_team_customize_register( $wp_customize ) {

    // 1. Add a new section for team section settings
    $wp_customize->add_section( 'team_header_section', array(
        'title'    => __( 'Section team Header', 'labguideline' ),
        'priority' => 33, // Position it below default sections
    ) );

    // 2. Setting for the Main Title (H2)
    $wp_customize->add_setting( 'team_title', array(
        'default'           => 'Our Scientific Team', // Default text
        'transport'         => 'refresh', 
        'sanitize_callback' => 'sanitize_text_field', // Sanitize input
    ) );

    // Control for the Main Title
    $wp_customize->add_control( 'team_title_control', array(
        'label'    => __( 'Section Main Title', 'labguideline' ),
        'section'  => 'team_header_section',
        'settings' => 'team_title',
        'type'     => 'text',
    ) );

    // 3. Setting for the Subtitle (P)
    $wp_customize->add_setting( 'team_subtitle', array(
        'default'           => 'Meet our team of accredited laboratory consultants with expertise across multiple scientific disciplines and regulatory frameworks.',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    // Control for the Subtitle
    $wp_customize->add_control( 'team_subtitle_control', array(
        'label'    => __( 'Section Subtitle/Description', 'labguideline' ),
        'section'  => 'team_header_section',
        'settings' => 'team_subtitle',
        'type'     => 'textarea', // Use textarea for longer text
    ) );
}
add_action( 'customize_register', 'lab_guideline_team_customize_register' );

/**
 * Helper function to retrieve and display the dynamic team section header text.
 * This function will be called directly in the template file.
 * Text domain used: labguideline
 */
function lab_guideline_display_team_header() {
    
    // Retrieve the saved values, falling back to defaults
    $title    = get_theme_mod( 'team_title', __( 'Our Scientific Team', 'labguideline' ) );
    $subtitle = get_theme_mod( 'team_subtitle', __( 'Meet our team of accredited laboratory consultants with expertise across multiple scientific disciplines and regulatory frameworks.', 'labguideline' ) );

    // Display the dynamic HTML structure
    ?>
    <div class="section-header">
        <h2><?php echo esc_html( $title ); ?></h2>
        <p><?php echo esc_html( $subtitle ); ?></p>
    </div>
    <?php
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function labguideline_customize_partial_blogname() {
    bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function labguideline_customize_partial_blogdescription() {
    bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function labguideline_customize_preview_js() {
    // Assuming you have a customizer.js file for asynchronous updates
    wp_enqueue_script( 'labguideline-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), null, true );
}
add_action( 'customize_preview_init', 'labguideline_customize_preview_js' );

?>