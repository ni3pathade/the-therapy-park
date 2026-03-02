<?php
/** Wellness Pro — Theme Customizer Settings */

add_action('customize_register', function($wp_customize) {

    /* ─────────────────────────────────────────────────
       PANEL: Homepage Sections
    ───────────────────────────────────────────────── */
    $wp_customize->add_panel('wellness_homepage', [
        'title'    => 'Homepage Sections',
        'priority' => 30,
    ]);

    /* ── HERO ──────────────────────────────────────── */
    $wp_customize->add_section('wellness_hero', [
        'title' => 'Hero Section',
        'panel' => 'wellness_homepage',
    ]);

    $hero_fields = [
        'hero_title'     => ['label' => 'Main Title',        'default' => 'Healing is a roller coaster ride'],
        'hero_highlight' => ['label' => 'Highlighted Text',  'default' => "Let's take it together"],
        'hero_desc'      => ['label' => 'Description',       'default' => 'At The Therapy Park, we hold safe spaces to support you through the roller-coaster called life, with trauma-informed care.'],
        'hero_btn1_text' => ['label' => 'Button 1 Label',    'default' => 'Book a Session'],
        'hero_btn1_url'  => ['label' => 'Button 1 URL',      'default' => '#contact'],
        'hero_btn2_text' => ['label' => 'Button 2 Label',    'default' => 'Contact us'],
        'hero_btn2_url'  => ['label' => 'Button 2 URL',      'default' => '#contact'],
    ];

    foreach ($hero_fields as $key => $args) {
        $wp_customize->add_setting($key, ['default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh']);
        $wp_customize->add_control($key, ['label' => $args['label'], 'section' => 'wellness_hero', 'type' => 'text']);
    }

    $wp_customize->add_setting('hero_bridge_img', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_bridge_img', [
        'label'   => 'Bridge / Roller Coaster Illustration',
        'section' => 'wellness_hero',
    ]));

    /* ── OUR PROMISE ────────────────────────────────── */
    $wp_customize->add_section('wellness_promise', [
        'title' => 'Our Promise Section',
        'panel' => 'wellness_homepage',
    ]);
    $wp_customize->add_setting('promise_heading', ['default' => 'Our Promise', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('promise_heading', ['label' => 'Section Heading', 'section' => 'wellness_promise', 'type' => 'text']);
    $wp_customize->add_setting('promise_wave_img', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'promise_wave_img', [
        'label'   => 'Wave Background Image',
        'section' => 'wellness_promise',
    ]));
    $wp_customize->add_setting('promise_title_img', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'promise_title_img', [
        'label'   => 'Promise Title Art Image',
        'section' => 'wellness_promise',
    ]));

    /* ── SERVICES ───────────────────────────────────── */
    $wp_customize->add_section('wellness_services', [
        'title' => 'Services Section',
        'panel' => 'wellness_homepage',
    ]);
    $wp_customize->add_setting('services_heading', ['default' => 'Our services', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('services_heading', ['label' => 'Section Heading', 'section' => 'wellness_services', 'type' => 'text']);
    $wp_customize->add_setting('services_desc', ['default' => 'At The Therapy Park, we hold safe spaces to support you through the roller-coaster called life, with trauma-informed care.', 'sanitize_callback' => 'sanitize_textarea_field']);
    $wp_customize->add_control('services_desc', ['label' => 'Section Description', 'section' => 'wellness_services', 'type' => 'textarea']);

    /* ── BENEFITS ───────────────────────────────────── */
    $wp_customize->add_section('wellness_benefits', [
        'title' => 'Benefits Section',
        'panel' => 'wellness_homepage',
    ]);
    $wp_customize->add_setting('benefits_heading', ['default' => 'Benefits of working with us', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('benefits_heading', ['label' => 'Section Heading', 'section' => 'wellness_benefits', 'type' => 'text']);
    $wp_customize->add_setting('benefits_desc', ['default' => 'At Therapy Park, we equip our practitioners with tools for personal and professional growth through our collective Founder\'s Association.', 'sanitize_callback' => 'sanitize_textarea_field']);
    $wp_customize->add_control('benefits_desc', ['label' => 'Section Description', 'section' => 'wellness_benefits', 'type' => 'textarea']);
    $wp_customize->add_setting('benefits_illustration', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'benefits_illustration', [
        'label'   => 'Tree Illustration Image',
        'section' => 'wellness_benefits',
    ]));

    /* ── TESTIMONIALS ───────────────────────────────── */
    $wp_customize->add_section('wellness_testimonials', [
        'title' => 'Testimonials Section',
        'panel' => 'wellness_homepage',
    ]);
    $wp_customize->add_setting('testimonials_heading', ['default' => 'Stories Of Transformation', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('testimonials_heading', ['label' => 'Section Heading', 'section' => 'wellness_testimonials', 'type' => 'text']);

    /* ── TEAM ───────────────────────────────────────── */
    $wp_customize->add_section('wellness_team', [
        'title' => 'Team Section',
        'panel' => 'wellness_homepage',
    ]);
    $wp_customize->add_setting('team_heading', ['default' => 'Meet The Team', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('team_heading', ['label' => 'Section Heading', 'section' => 'wellness_team', 'type' => 'text']);

    /* ── RECENT POSTS ───────────────────────────────── */
    $wp_customize->add_section('wellness_recent_posts', [
        'title' => 'Recent Posts Section',
        'panel' => 'wellness_homepage',
    ]);
    $wp_customize->add_setting('recent_posts_heading', ['default' => 'Recent Insights', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('recent_posts_heading', ['label' => 'Section Heading', 'section' => 'wellness_recent_posts', 'type' => 'text']);

    /* ── FAQ ────────────────────────────────────────── */
    $wp_customize->add_section('wellness_faq', [
        'title' => 'FAQ Section',
        'panel' => 'wellness_homepage',
    ]);
    $wp_customize->add_setting('faq_heading', ['default' => "FAQ's", 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('faq_heading', ['label' => 'Section Heading', 'section' => 'wellness_faq', 'type' => 'text']);

    /* ── FOOTER CTA ─────────────────────────────────── */
    $wp_customize->add_section('wellness_footer_cta', [
        'title' => 'Footer CTA Section',
        'panel' => 'wellness_homepage',
    ]);
    $cta_fields = [
        'cta_heading'  => ['label' => 'Heading',      'default' => 'Reach out to us to find perfect therapist for you', 'type' => 'text'],
        'cta_desc'     => ['label' => 'Description',  'default' => 'Lacinia vel faucibus nullam purus facilisis consectetur euismod.', 'type' => 'textarea'],
        'cta_btn_text' => ['label' => 'Button Label', 'default' => 'Book a Session', 'type' => 'text'],
        'cta_btn_url'  => ['label' => 'Button URL',   'default' => '#contact', 'type' => 'text'],
    ];
    foreach ($cta_fields as $key => $args) {
        $wp_customize->add_setting($key, ['default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control($key, ['label' => $args['label'], 'section' => 'wellness_footer_cta', 'type' => $args['type']]);
    }

    /* ─────────────────────────────────────────────────
       INTEGRATIONS
    ───────────────────────────────────────────────── */
    $wp_customize->add_section('wellness_integrations', [
        'title'    => 'Integrations',
        'priority' => 38,
    ]);

    // --- Booking (Calendly / Acuity / any URL) ---
    $wp_customize->add_setting('booking_url', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('booking_url', [
        'label'       => 'Booking URL',
        'description' => 'Paste your Calendly, Acuity, or booking page URL. All "Book a Session" buttons will link here.',
        'section'     => 'wellness_integrations',
        'type'        => 'url',
    ]);

    // --- Newsletter form (WPForms / Gravity Forms shortcode) ---
    $wp_customize->add_setting('newsletter_shortcode', ['default' => '', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('newsletter_shortcode', [
        'label'       => 'Newsletter Form Shortcode',
        'description' => 'Optional. Paste a WPForms or Gravity Forms shortcode e.g. [wpforms id="5"]. If filled, this replaces the default subscribe form.',
        'section'     => 'wellness_integrations',
        'type'        => 'textarea',
    ]);

    // --- Mailchimp (fallback when no form shortcode) ---
    $wp_customize->add_setting('mailchimp_api_key', ['default' => '', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('mailchimp_api_key', [
        'label'       => 'Mailchimp API Key',
        'description' => 'Format: xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx-us6 (used when no shortcode above)',
        'section'     => 'wellness_integrations',
        'type'        => 'text',
    ]);
    $wp_customize->add_setting('mailchimp_list_id', ['default' => '', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('mailchimp_list_id', [
        'label'       => 'Mailchimp Audience / List ID',
        'description' => 'Mailchimp → Audience → Settings → Audience name and defaults',
        'section'     => 'wellness_integrations',
        'type'        => 'text',
    ]);

    /* ─────────────────────────────────────────────────
       PANEL: Site Identity extras
    ───────────────────────────────────────────────── */
    $wp_customize->add_section('wellness_contact_info', [
        'title'    => 'Contact Info',
        'priority' => 35,
    ]);
    $contact_fields = [
        'contact_phone'   => ['label' => 'Phone Number', 'default' => '+91 98765 43210'],
        'contact_email'   => ['label' => 'Email',        'default' => 'hello@thetherapypark.com'],
        'contact_address' => ['label' => 'Address',      'default' => 'New Delhi, India'],
    ];
    foreach ($contact_fields as $key => $args) {
        $wp_customize->add_setting($key, ['default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control($key, ['label' => $args['label'], 'section' => 'wellness_contact_info', 'type' => 'text']);
    }
});
