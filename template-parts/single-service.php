<?php get_header(); ?>

<div class="single-service-container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <article class="service-details">
            <h1><?php the_title(); ?></h1>

            <div class="service-meta">
                <?php 
                $icon = get_post_meta(get_the_ID(), '_service_icon_key', true);
                $badge = get_post_meta(get_the_ID(), '_service_badge_key', true);

                if (!empty($icon)) : ?>
                    <i class="service-icon <?php echo esc_attr($icon); ?>"></i>
                <?php endif; ?>

                <?php if (!empty($badge)) : ?>
                    <span class="service-badge"><?php echo esc_html($badge); ?></span>
                <?php endif; ?>
            </div>
            
            
            <?php if (has_post_thumbnail()) : ?>
                <div class="service-hero-image">
                    <?php the_post_thumbnail('full'); ?>
                </div>
            <?php endif; ?>

            <div class="service-content-body">
                <?php the_content(); ?>
            </div>
        </article>

    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>