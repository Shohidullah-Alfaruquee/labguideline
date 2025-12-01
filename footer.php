<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Lab_Guideline
 */

// This file starts by closing the main content container started in header.php
?>

</main>
<footer>
	<div class="footer">
		<div class="footer-container ft-left-container">

			<div class="footer-container-div">
				<h3 class="footer-service-heading">Services</h3>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-service-menu',
						'menu_class'     => 'footer-content-list links', // User's custom list class
						'container'      => false, // Prevent wrapping UL in a <div>
						'fallback_cb'    => false // Hide if no menu is assigned
					)
				);
				?>
			</div>

			<div class="footer-container-div">
				<h3 class="footer-service-heading">Resources</h3>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-resource-menu',
						'menu_class'     => 'footer-content-list links',
						'container'      => false,
						'fallback_cb'    => false
					)
				);
				?>
			</div>
		</div>
		<div class="footer-container ft-right-container">

<div class="footer-container-div">
    <h3 class="footer-service-heading">Pages</h3>
    <?php
    wp_nav_menu(
        array(
            'theme_location' => 'footer-pages-menu',
            'menu_class' => 'footer-content-list links', 
            'container' => false, 
            'fallback_cb'=> 'labguideline_fallback_labguideline_menu', 
			'callback_args' => array( 
                'css_class' => 'footer-content-list links' 
            )
        )
    );
    ?>
</div>

			<div id="copyright-logo-container" class="footer-container-div">
				<div class="footer-logo-container">
					<a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
						<?php
						// Check if the Custom Logo feature is supported and a logo is set.
						if (function_exists('the_custom_logo') && has_custom_logo()) {
							// Option 1: Load the custom logo
							the_custom_logo();
						} else {
							// Option 2: Fallback to a default image 
							// This acts as a great fallback if the user hasn't set the Customizer logo yet.
						?>
							<img src="<?php echo esc_url(get_template_directory_uri() . '/img/logo/Logo.png'); ?>" alt="<?php bloginfo('name'); ?> logo">
						<?php
						}
						?>
					</a>
				</div>
				<div class="footer-copyright">
					<p>Copyright &copy; <?php echo date('Y'); ?></p>
					<p>All Rights Reserved By <?php bloginfo('name'); ?></p>
				</div>
			</div>
		</div>
	</div>
</footer>

</div><?php wp_footer(); // CRITICAL: Used by scripts, plugins, and admin bar 
		?>

</body>

</html>