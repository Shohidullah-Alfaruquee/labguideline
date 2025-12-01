<?php
// Get values from Customizer with fallback defaults
$hero_title       = get_theme_mod('hero_title', 'Everything You Need for <span>ISO Certification</span>');
$hero_description = get_theme_mod('hero_description', 'Supporting organizations in reaching their ISO certification objectives with expert guidance and comprehensive solutions.');
$hero_btn1_text   = get_theme_mod('hero_btn1_text', 'Our Services');
$hero_btn1_link   = get_theme_mod('hero_btn1_link', '/services');
$hero_btn2_text   = get_theme_mod('hero_btn2_text', 'Get Started');
$hero_btn2_link   = get_theme_mod('hero_btn2_link', '/contact');
?>

<section class="hero" id="home">
    <div class="hero-container">
        <div class="hero-content">
            <h1><?php echo wp_kses_post($hero_title); ?></h1>
            <p><?php echo esc_html($hero_description); ?></p>
            <div class="hero-btns">
                <a href="<?php echo esc_url($hero_btn1_link); ?>" class="btn"><?php echo esc_html($hero_btn1_text); ?></a>
                <a href="<?php echo esc_url($hero_btn2_link); ?>" class="btn btn-secondary"><?php echo esc_html($hero_btn2_text); ?></a>
            </div>
        </div>
    </div>
</section>