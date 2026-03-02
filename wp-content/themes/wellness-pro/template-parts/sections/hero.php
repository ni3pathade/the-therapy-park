<?php /** Hero Section */ ?>
<section class="hero-section" id="home">

    <!-- Cloud SVGs -->
    <div class="hero-clouds" aria-hidden="true">
        <div class="cloud-left">
            <svg width="140" height="100" viewBox="0 0 140 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 70 Q10 70 10 60 Q10 50 20 50 Q18 40 28 38 Q30 25 45 25 Q55 20 62 30 Q72 22 80 30 Q92 28 95 40 Q108 40 108 55 Q108 70 95 70 Z" stroke="white" stroke-width="1.5" fill="none" opacity="0.6"/>
                <path d="M5 85 Q-2 85 -2 77 Q-2 69 5 69 Q4 62 12 60 Q14 51 26 51 Q34 47 40 55" stroke="white" stroke-width="1" fill="none" opacity="0.35"/>
            </svg>
        </div>
        <div class="cloud-right">
            <svg width="140" height="100" viewBox="0 0 140 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 70 Q10 70 10 60 Q10 50 20 50 Q18 40 28 38 Q30 25 45 25 Q55 20 62 30 Q72 22 80 30 Q92 28 95 40 Q108 40 108 55 Q108 70 95 70 Z" stroke="white" stroke-width="1.5" fill="none" opacity="0.6"/>
            </svg>
        </div>
    </div>

    <!-- Content -->
    <div class="hero-content">
        <h1 class="hero-title"><?php echo esc_html(get_theme_mod('hero_title', 'Healing is a roller coaster ride')); ?></h1>
        <p class="hero-sub">
            <span class="hero-highlight"><?php echo esc_html(get_theme_mod('hero_highlight', "Let's take it together")); ?></span>
        </p>
        <p class="hero-desc">
            <?php echo esc_html(get_theme_mod('hero_desc', 'At The Therapy Park, we hold safe spaces to support you through the roller-coaster called life, with trauma-informed care.')); ?>
        </p>
        <?php
        $booking_url = get_theme_mod('booking_url', '');
        $btn1_url    = get_theme_mod('hero_btn1_url', '') ?: $booking_url ?: '#contact';
        $btn2_url    = get_theme_mod('hero_btn2_url', '') ?: '#contact';
        ?>
        <div class="hero-btns">
            <a href="<?php echo esc_url($btn1_url); ?>" class="btn btn-yellow"><?php echo esc_html(get_theme_mod('hero_btn1_text', 'Book a Session')); ?></a>
            <a href="<?php echo esc_url($btn2_url); ?>" class="btn btn-purple"><?php echo esc_html(get_theme_mod('hero_btn2_text', 'Contact us')); ?></a>
        </div>
    </div>

    <!-- Roller coaster bridge illustration -->
    <div class="hero-bridge" aria-hidden="true">
        <?php
        $bridge = get_theme_mod( 'hero_bridge_img', '' );
        $bridge_url = $bridge ?: get_template_directory_uri() . '/assets/images/hero-bridge.svg';
        ?>
        <img src="<?php echo esc_url( $bridge_url ); ?>" alt="" loading="eager">
    </div>

</section>
