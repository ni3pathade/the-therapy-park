<?php
/** AJAX handlers for blog filter + load more */

function wellness_render_post_card() {
    $cats = get_the_category();
    ob_start(); ?>
    <article class="post-card">
        <a href="<?php the_permalink(); ?>" class="post-card__img">
            <?php if (has_post_thumbnail()) : the_post_thumbnail('wellness-card');
            else : ?><div style="width:100%;aspect-ratio:16/10;background:#2e2d45;"></div><?php endif; ?>
        </a>
        <div class="post-card__body">
            <h3 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <div class="post-card__footer">
                <span class="post-card__date"><?php echo get_the_date('M j, Y'); ?></span>
                <a href="<?php the_permalink(); ?>" class="post-card__read">READ MORE</a>
            </div>
        </div>
    </article>
    <?php return ob_get_clean();
}

function wellness_filter_posts_cb() {
    check_ajax_referer('wellness-pro-nonce', 'nonce');
    $cat   = sanitize_text_field($_POST['category'] ?? 'all');
    $paged = absint($_POST['paged'] ?? 1);
    $args  = array('post_type' => 'post', 'posts_per_page' => 9, 'paged' => $paged, 'post_status' => 'publish', 'orderby' => 'date', 'order' => 'DESC');
    if ($cat !== 'all') $args['tax_query'] = array(array('taxonomy'=>'category','field'=>'slug','terms'=>$cat));
    $q = new WP_Query($args);
    ob_start();
    if ($q->have_posts()) : while ($q->have_posts()) : $q->the_post(); echo wellness_render_post_card(); endwhile;
    else : echo '<p style="color:rgba(255,255,255,.5);grid-column:1/-1;text-align:center;padding:3rem;">No posts found.</p>'; endif;
    $html = ob_get_clean();
    wp_send_json_success(array('html' => $html, 'max_pages' => $q->max_num_pages));
    wp_reset_postdata();
}
add_action('wp_ajax_wellness_filter_posts',       'wellness_filter_posts_cb');
add_action('wp_ajax_nopriv_wellness_filter_posts', 'wellness_filter_posts_cb');

function wellness_load_more_cb() {
    check_ajax_referer('wellness-pro-nonce', 'nonce');
    $cat   = sanitize_text_field($_POST['category'] ?? 'all');
    $paged = absint($_POST['paged'] ?? 2);
    $args  = array('post_type' => 'post', 'posts_per_page' => 9, 'paged' => $paged, 'post_status' => 'publish', 'orderby' => 'date', 'order' => 'DESC');
    if ($cat !== 'all') $args['tax_query'] = array(array('taxonomy'=>'category','field'=>'slug','terms'=>$cat));
    $q = new WP_Query($args);
    ob_start();
    if ($q->have_posts()) : while ($q->have_posts()) : $q->the_post(); echo wellness_render_post_card(); endwhile; endif;
    $html = ob_get_clean();
    wp_send_json_success(array('html' => $html, 'max_pages' => $q->max_num_pages));
    wp_reset_postdata();
}
add_action('wp_ajax_wellness_load_more',        'wellness_load_more_cb');
add_action('wp_ajax_nopriv_wellness_load_more',  'wellness_load_more_cb');

function wellness_subscribe_cb() {
    check_ajax_referer('wellness-pro-nonce', 'nonce');

    $email  = sanitize_email($_POST['email'] ?? '');
    $source = sanitize_text_field($_POST['source'] ?? 'website');

    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Please enter a valid email address.']);
    }

    // ── 1. Save to local WordPress database ──────────────────
    global $wpdb;
    $table = $wpdb->prefix . 'wellness_subscribers';

    $existing = $wpdb->get_var( $wpdb->prepare(
        "SELECT id FROM $table WHERE email = %s", $email
    ) );

    if ($existing) {
        wp_send_json_success(['message' => 'You are already subscribed. Thank you!']);
    }

    $wpdb->insert(
        $table,
        [
            'email'         => $email,
            'source'        => $source,
            'status'        => 'subscribed',
            'ip'            => sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '' ),
            'subscribed_at' => current_time('mysql'),
        ],
        ['%s', '%s', '%s', '%s', '%s']
    );

    // ── 2. Also sync to Mailchimp if configured (optional) ───
    $api_key = get_theme_mod('mailchimp_api_key', '');
    $list_id = get_theme_mod('mailchimp_list_id', '');

    if ($api_key && $list_id) {
        $dc  = substr($api_key, strpos($api_key, '-') + 1);
        $url = "https://{$dc}.api.mailchimp.com/3.0/lists/{$list_id}/members/" . md5(strtolower($email));
        wp_remote_request($url, [
            'method'  => 'PUT',
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode('anystring:' . $api_key),
                'Content-Type'  => 'application/json',
            ],
            'body'    => wp_json_encode(['email_address' => $email, 'status_if_new' => 'subscribed']),
            'timeout' => 10,
        ]);
    }

    wp_send_json_success(['message' => 'Thank you for subscribing!']);
}
add_action('wp_ajax_wellness_subscribe',        'wellness_subscribe_cb');
add_action('wp_ajax_nopriv_wellness_subscribe',  'wellness_subscribe_cb');
