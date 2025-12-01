<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Lab_Guideline
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <?php wp_body_open();?> 

    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'labguideline' ); ?></a>

    <header id="masthead" class="site-header header">
        <nav class="navbar">
            <div class="site-branding logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php
                    // custom logo 
                    if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
                        the_custom_logo();
                    } else {
                        
                        echo '<h1>' . get_bloginfo( 'name' ) . '</h1>';
                    }
                    ?>
                </a>
                
                <p class="brand-name"><?php bloginfo( 'name' ); ?></p>

                <div class="hamburger" id="hamburger" aria-label="Toggle navigation" aria-expanded="false">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </div>
            </div>
    <?php
    wp_nav_menu(
        array(
            'theme_location' => 'header-top-navbar-menu',
            'menu_class' => 'nav-links', 
            'container' => false, 
            'fallback_cb'=> 'labguideline_fallback_labguideline_menu', 
        )
    );
    ?>

        </nav>
	</header>
