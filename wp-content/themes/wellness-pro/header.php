<?php
/**
 * Header — Wellness Pro
 * Layout: [Nav Left] [Logo Center] [CTA Buttons Right]
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
    <div class="header-inner">

        <!-- Left: Navigation -->
        <nav class="site-nav" id="site-nav" aria-label="Primary">
            <?php wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'fallback_cb'    => 'wellness_pro_fallback_menu',
                'depth'          => 2,
                'items_wrap'     => '<ul>%3$s</ul>',
            ) ); ?>
        </nav>

        <!-- Center: Logo -->
        <div class="site-logo">
            <a href="<?php echo esc_url( home_url('/') ); ?>" rel="home">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="<?php bloginfo('name'); ?>" class="logo-img">
            </a>
        </div>

        <!-- Right: CTA Buttons -->
        <div class="header-cta">
            <a href="#book" class="btn btn-yellow">Book a Session</a>
            <a href="#contact" class="btn btn-purple">Contact us</a>
        </div>

        <!-- Mobile Toggle -->
        <button class="nav-toggle" id="nav-toggle" aria-label="Menu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>

    </div>
</header>
