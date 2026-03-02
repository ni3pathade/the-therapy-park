<?php
/** Custom Post Types — Team Members & Testimonials */

function wellness_register_cpts() {
    // Team Members
    register_post_type('team_member', array(
        'labels'      => array('name' => 'Team Members', 'singular_name' => 'Team Member', 'add_new_item' => 'Add Team Member'),
        'public'      => true,
        'show_in_menu'=> true,
        'menu_icon'   => 'dashicons-groups',
        'supports'    => array('title','thumbnail','editor','custom-fields'),
        'rewrite'     => array('slug' => 'team'),
        'show_in_rest'=> true,
    ));

    // Testimonials
    register_post_type('testimonial', array(
        'labels'      => array('name' => 'Testimonials', 'singular_name' => 'Testimonial', 'add_new_item' => 'Add Testimonial'),
        'public'      => false,
        'show_ui'     => true,
        'show_in_menu'=> true,
        'menu_icon'   => 'dashicons-format-quote',
        'supports'    => array('title','editor','custom-fields'),
        'show_in_rest'=> true,
    ));

    // Services
    register_post_type('service', array(
        'labels'      => array('name' => 'Services', 'singular_name' => 'Service', 'add_new_item' => 'Add Service'),
        'public'      => false,
        'show_ui'     => true,
        'show_in_menu'=> true,
        'menu_icon'   => 'dashicons-heart',
        'supports'    => array('title','editor','thumbnail'),
        'show_in_rest'=> true,
    ));

    // FAQs
    register_post_type('faq', array(
        'labels'      => array('name' => 'FAQs', 'singular_name' => 'FAQ', 'add_new_item' => 'Add FAQ'),
        'public'      => false,
        'show_ui'     => true,
        'show_in_menu'=> true,
        'menu_icon'   => 'dashicons-editor-help',
        'supports'    => array('title','editor'),
        'show_in_rest'=> true,
    ));

    // Benefits
    register_post_type('benefit', array(
        'labels'      => array('name' => 'Benefits', 'singular_name' => 'Benefit', 'add_new_item' => 'Add Benefit'),
        'public'      => false,
        'show_ui'     => true,
        'show_in_menu'=> true,
        'menu_icon'   => 'dashicons-star-filled',
        'supports'    => array('title', 'editor', 'page-attributes'),
        'show_in_rest'=> true,
    ));

    // Therapist Services
    register_post_type('therapist_service', array(
        'labels'      => array('name' => 'Therapist Services', 'singular_name' => 'Therapist Service', 'add_new_item' => 'Add Therapist Service'),
        'public'      => false,
        'show_ui'     => true,
        'show_in_menu'=> true,
        'menu_icon'   => 'dashicons-admin-users',
        'supports'    => array('title', 'thumbnail', 'page-attributes'),
        'show_in_rest'=> true,
    ));
}
add_action('init', 'wellness_register_cpts');

// Meta boxes
add_action('add_meta_boxes', function() {
    add_meta_box('team_meta',    'Team Member Details',     'wellness_team_meta_box',    'team_member',       'normal', 'high');
    add_meta_box('test_meta',    'Testimonial Details',     'wellness_test_meta_box',    'testimonial',       'normal', 'high');
    add_meta_box('service_meta', 'Service Details',         'wellness_service_meta_box', 'service',           'normal', 'high');
    add_meta_box('benefit_meta', 'Benefit Button',          'wellness_benefit_meta_box', 'benefit',           'normal', 'high');
});

function wellness_team_meta_box($post) {
    wp_nonce_field('wellness_team','team_nonce');
    $title  = get_post_meta($post->ID, '_team_title', true);
    $avail  = get_post_meta($post->ID, '_team_availability', true);
    $url    = get_post_meta($post->ID, '_team_booking_url', true);
    echo '<table class="form-table">';
    echo '<tr><th>Job Title</th><td><input name="team_title" value="' . esc_attr($title) . '" class="regular-text"></td></tr>';
    echo '<tr><th>Availability</th><td><input name="team_availability" value="' . esc_attr($avail) . '" class="regular-text" placeholder="e.g. Mon – Wed"></td></tr>';
    echo '<tr><th>Booking URL</th><td><input type="url" name="team_booking_url" value="' . esc_attr($url) . '" class="regular-text"></td></tr>';
    echo '</table>';
}

add_action('save_post_team_member', function($id) {
    if (!isset($_POST['team_nonce']) || !wp_verify_nonce($_POST['team_nonce'],'wellness_team')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    foreach (array('team_title','team_availability','team_booking_url') as $key) {
        if (isset($_POST[$key])) update_post_meta($id, '_'.$key, sanitize_text_field($_POST[$key]));
    }
});

function wellness_test_meta_box($post) {
    wp_nonce_field('wellness_test','test_nonce');
    $name = get_post_meta($post->ID, '_testimonial_client_name', true);
    $hl   = get_post_meta($post->ID, '_testimonial_highlighted', true);
    echo '<table class="form-table">';
    echo '<tr><th>Client Name</th><td><input name="test_client_name" value="' . esc_attr($name) . '" class="regular-text"></td></tr>';
    echo '<tr><th>Highlight (purple card)?</th><td><input type="checkbox" name="test_highlighted" value="1"' . checked($hl,'1',false) . '></td></tr>';
    echo '</table>';
}

function wellness_service_meta_box($post) {
    wp_nonce_field('wellness_service','service_nonce');
    $color = get_post_meta($post->ID, '_service_color', true) ?: '#C4B5E8';
    $icon  = get_post_meta($post->ID, '_service_icon',  true);
    echo '<table class="form-table">';
    echo '<tr><th>Card Color</th><td><input type="color" name="service_color" value="' . esc_attr($color) . '"></td></tr>';
    echo '<tr><th>Icon (emoji or text)</th><td><input name="service_icon" value="' . esc_attr($icon) . '" class="regular-text" placeholder="e.g. 🧠 or leave blank"></td></tr>';
    echo '</table>';
}

add_action('save_post_service', function($id) {
    if (!isset($_POST['service_nonce']) || !wp_verify_nonce($_POST['service_nonce'],'wellness_service')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    foreach (array('service_color','service_icon') as $key) {
        if (isset($_POST[$key])) update_post_meta($id, '_'.$key, sanitize_text_field($_POST[$key]));
    }
});

add_action('save_post_testimonial', function($id) {
    if (!isset($_POST['test_nonce']) || !wp_verify_nonce($_POST['test_nonce'],'wellness_test')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['test_client_name'])) update_post_meta($id, '_testimonial_client_name', sanitize_text_field($_POST['test_client_name']));
    update_post_meta($id, '_testimonial_highlighted', isset($_POST['test_highlighted']) ? '1' : '0');
});

function wellness_benefit_meta_box($post) {
    wp_nonce_field('wellness_benefit', 'benefit_nonce');
    $btn_text = get_post_meta($post->ID, '_benefit_btn_text', true) ?: 'Book a Session';
    $btn_url  = get_post_meta($post->ID, '_benefit_btn_url',  true) ?: '#book';
    echo '<table class="form-table">';
    echo '<tr><th>Button Text</th><td><input name="benefit_btn_text" value="' . esc_attr($btn_text) . '" class="regular-text"></td></tr>';
    echo '<tr><th>Button URL</th><td><input name="benefit_btn_url" value="' . esc_attr($btn_url) . '" class="regular-text"></td></tr>';
    echo '</table>';
}

add_action('save_post_benefit', function($id) {
    if (!isset($_POST['benefit_nonce']) || !wp_verify_nonce($_POST['benefit_nonce'], 'wellness_benefit')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    foreach (array('benefit_btn_text', 'benefit_btn_url') as $key) {
        if (isset($_POST[$key])) update_post_meta($id, '_' . $key, sanitize_text_field($_POST[$key]));
    }
});
