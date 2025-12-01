<?php

/**
 * Lab Guideline functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Lab_Guideline
 */

if (! defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

// Define the path to the 'inc' directory for cleaner code
$labguideline_inc_dir = get_template_directory() . '/inc/';

// Define the path to the 'assets' directory for cleaner code
$labguideline_assets_dir = get_template_directory() . '/assets/';

// Define the path to the 'js' directory for cleaner code
$labguideline_js_dir = get_template_directory() . '/js/';
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function labguideline_theme_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Lab Guideline, use a find and replace
		* to change 'labguideline' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('labguideline', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');



	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'header-top-navbar-menu' => esc_html__('Header-top-navbar-menu', 'labguideline'),
			'footer-service-menu'    => esc_html__('Footer Services Menu', 'labguideline'),
			'footer-resource-menu'   => esc_html__('Footer Resources Menu', 'labguideline'),
			'footer-pages-menu'      => esc_html__('Footer Pages Menu', 'labguideline'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'labguideline_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'labguideline_theme_setup');


/**
 * Display a custom fallback menu when no menu is set in the dashboard.
 * * @param array $args The full arguments array passed from wp_nav_menu.
 */
function labguideline_fallback_labguideline_menu( $args = array() ) {
    
    $css_class = 'nav-links'; // Default class for the header menu

    if ( is_array( $args ) ) {
        
        // 1. Try to get the class from the custom 'callback_args' (used for footer)
        if ( isset( $args['callback_args']['css_class'] ) && ! empty( $args['callback_args']['css_class'] ) ) {
            $css_class = $args['callback_args']['css_class'];
        } 
        // 2. Fallback: If not in callback_args, use the standard 'menu_class' (if available)
        elseif ( isset( $args['menu_class'] ) && ! empty( $args['menu_class'] ) ) {
             $css_class = $args['menu_class'];
        }
        
    }
    
    // Start the unordered list with the determined CSS class using printf for robustness
    printf( '<ul class="%s" id="%s-fallback">', esc_attr( $css_class ), esc_attr( $css_class ) );
    
    // Dynamic Links (as defined previously)
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/about-us/' ) ) . '">About Us</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/standards/' ) ) . '">Standards</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/contact-us/' ) ) . '">Contact Us</a></li>';
    
    // Close the list
    echo '</ul>';
}


// Title Separator Customization
function labguideline_theme_title_separator($sep)
{
	return '|';
}
add_filter('document_title_separator', 'labguideline_theme_title_separator');


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function labguideline_content_width()
{
	$GLOBALS['content_width'] = apply_filters('labguideline_content_width', 640);
}
add_action('after_setup_theme', 'labguideline_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function labguideline_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'labguideline'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'labguideline'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'labguideline_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function labguideline_scripts()
{
	//Enqueue Font Awesome from CDN
	wp_enqueue_style(
		'font-awesome', // Handle (unique name)
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', // Source URL
		array(), // Dependencies (none)
		'6.4.0' // Version number
	);
	wp_enqueue_style('labguideline-style', get_stylesheet_uri(), array(), _S_VERSION);
	// Enqueue a custom stylesheet located in the theme's assets/css directory
	wp_enqueue_style(
		'custom-style',
		get_template_directory_uri() . '/assets/css/style.css',
		array('labguideline-style'),
		_S_VERSION
	);


	wp_style_add_data('labguideline-style', 'rtl', 'replace');

	//  Enqueue a custom JavaScript file located in the theme's assets/js directory
	wp_enqueue_script(
		'labguideline_script', // 1. Handle (Unique name)
		get_template_directory_uri() . '/assets/js/main.js', // 2. Source URL
		array(), // 3. Dependencies 
		_S_VERSION, // 4. Version
		true // 5. Load in Footer (Critical!)
	);
	wp_enqueue_script('labguideline-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'labguideline_scripts');


//All CPT related code
// Services CPT code
require_once $labguideline_inc_dir . 'service-cpt.php';
// Service Process Flow CPT code
require_once $labguideline_inc_dir . 'service-process-flow-cpt.php';
// Team Section CPT code
require_once $labguideline_inc_dir . 'team-cpt.php';

/**
 * Implement the Custom Header feature.
 */
require_once $labguideline_inc_dir . 'custom-header.php';

/**
 * Custom template tags for this theme.
 */
require_once $labguideline_inc_dir . 'template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once $labguideline_inc_dir . 'template-functions.php';

/**
 * Customizer additions.
 */
require_once $labguideline_inc_dir . 'customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require_once get_template_directory() . '/inc/jetpack.php';
}