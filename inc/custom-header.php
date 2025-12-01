<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * This file sets up theme support for the Custom Header and defines the
 * function to output dynamic CSS for the header text color and visibility.
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Lab_Guideline
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses labguideline_header_style()
 */
function labguideline_custom_header_setup() {
    add_theme_support(
        'custom-header',
        apply_filters(
            'labguideline_custom_header_args',
            array(
                'default-image'      => '',
                'default-text-color' => '000000',
                'width'              => 1000,
                'height'             => 250,
                'flex-height'        => true,
                'wp-head-callback'   => 'labguideline_header_style', // Function that outputs dynamic CSS
            )
        )
    );
}
add_action( 'after_setup_theme', 'labguideline_custom_header_setup' );

if ( ! function_exists( 'labguideline_header_style' ) ) :
    /**
     * Styles the header image and text displayed on the blog.
     * Outputs inline CSS using clean string concatenation to prevent syntax errors.
     *
     * @see labguideline_custom_header_setup().
     */
    function labguideline_header_style() {
        $header_text_color = get_header_textcolor();

        // Bail if the custom color matches the default color.
        if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
            return;
        }

        $css = '';
        
        // Check if the header text has been hidden in the Customizer.
        if ( ! display_header_text() ) {
            $css .= '
                .site-title,
                .site-description {
                    position: absolute;
                    clip: rect(1px, 1px, 1px, 1px);
                }
            ';
        } 
        // If the user has set a custom color for the text, use that.
        else {
            $css .= '
                .site-title a,
                .site-description {
                    color: #' . esc_attr( $header_text_color ) . ';
                }
            ';
        }

        // Output the final CSS in a single style block if styles are present.
        if ( ! empty( $css ) ) {
            echo '<style type="text/css">' . $css . '</style>';
        }
    }
endif;