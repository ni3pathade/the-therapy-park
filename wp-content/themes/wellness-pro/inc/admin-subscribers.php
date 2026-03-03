<?php
/**
 * Admin page — Newsletter Subscribers
 * Stored in: wp_wellness_subscribers
 */

add_action( 'admin_menu', function() {
    add_menu_page(
        'Subscribers',
        'Subscribers',
        'manage_options',
        'wellness-subscribers',
        'wellness_subscribers_page',
        'dashicons-email-alt',
        25
    );
} );

function wellness_subscribers_page() {
    global $wpdb;
    $table = $wpdb->prefix . 'wellness_subscribers';

    // ── Delete single subscriber ──────────────────────────────
    if ( isset( $_GET['delete'] ) && check_admin_referer( 'wellness_delete_sub' ) ) {
        $wpdb->delete( $table, array( 'id' => absint( $_GET['delete'] ) ), array( '%d' ) );
        echo '<div class="notice notice-success is-dismissible"><p>Subscriber deleted.</p></div>';
    }

    // ── Export CSV ───────────────────────────────────────────
    if ( isset( $_GET['export'] ) && check_admin_referer( 'wellness_export_subs' ) ) {
        $rows = $wpdb->get_results( "SELECT id, email, source, status, ip, subscribed_at FROM $table ORDER BY subscribed_at DESC", ARRAY_A );
        header( 'Content-Type: text/csv; charset=utf-8' );
        header( 'Content-Disposition: attachment; filename="subscribers-' . date('Y-m-d') . '.csv"' );
        $out = fopen( 'php://output', 'w' );
        fputcsv( $out, array( 'ID', 'Email', 'Source', 'Status', 'IP', 'Date' ) );
        foreach ( $rows as $row ) {
            fputcsv( $out, $row );
        }
        fclose( $out );
        exit;
    }

    // ── Fetch data ───────────────────────────────────────────
    $search      = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';
    $per_page    = 20;
    $current_page = max( 1, absint( $_GET['paged'] ?? 1 ) );
    $offset      = ( $current_page - 1 ) * $per_page;

    if ( $search ) {
        $subscribers = $wpdb->get_results( $wpdb->prepare(
            "SELECT * FROM $table WHERE email LIKE %s ORDER BY subscribed_at DESC LIMIT %d OFFSET %d",
            '%' . $wpdb->esc_like( $search ) . '%', $per_page, $offset
        ) );
        $total = $wpdb->get_var( $wpdb->prepare(
            "SELECT COUNT(*) FROM $table WHERE email LIKE %s",
            '%' . $wpdb->esc_like( $search ) . '%'
        ) );
    } else {
        $subscribers = $wpdb->get_results( $wpdb->prepare(
            "SELECT * FROM $table ORDER BY subscribed_at DESC LIMIT %d OFFSET %d",
            $per_page, $offset
        ) );
        $total = $wpdb->get_var( "SELECT COUNT(*) FROM $table" );
    }

    $total_pages = ceil( $total / $per_page );
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Newsletter Subscribers</h1>
        <span class="title-count" style="background:#2271b1;color:#fff;border-radius:10px;padding:2px 8px;font-size:12px;margin-left:8px;"><?php echo intval($total); ?></span>

        <div style="margin:12px 0;display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
            <!-- Search -->
            <form method="get" style="display:inline-flex;gap:6px;">
                <input type="hidden" name="page" value="wellness-subscribers">
                <input type="search" name="s" value="<?php echo esc_attr($search); ?>" placeholder="Search by email…" class="regular-text">
                <button type="submit" class="button">Search</button>
                <?php if ($search) : ?><a href="?page=wellness-subscribers" class="button">Clear</a><?php endif; ?>
            </form>

            <!-- Export -->
            <a href="<?php echo wp_nonce_url( admin_url('admin.php?page=wellness-subscribers&export=1'), 'wellness_export_subs' ); ?>" class="button button-secondary">
                Export CSV
            </a>
        </div>

        <?php if ( $wpdb->last_error ) : ?>
            <div class="notice notice-error"><p>Database error: <?php echo esc_html($wpdb->last_error); ?> — <a href="?page=wellness-subscribers&rebuild=1">Click here to create table</a></p></div>
        <?php endif; ?>

        <table class="wp-list-table widefat fixed striped" style="margin-top:10px;">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Email</th>
                    <th style="width:100px;">Source</th>
                    <th style="width:90px;">Status</th>
                    <th style="width:120px;">IP</th>
                    <th style="width:150px;">Date</th>
                    <th style="width:80px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ( $subscribers ) : foreach ( $subscribers as $sub ) : ?>
                <tr>
                    <td><?php echo intval($sub->id); ?></td>
                    <td><strong><?php echo esc_html($sub->email); ?></strong></td>
                    <td><?php echo esc_html($sub->source); ?></td>
                    <td>
                        <span style="color:<?php echo $sub->status === 'subscribed' ? '#2e7d32' : '#b71c1c'; ?>;font-weight:600;">
                            <?php echo esc_html($sub->status); ?>
                        </span>
                    </td>
                    <td><?php echo esc_html($sub->ip ?: '—'); ?></td>
                    <td><?php echo esc_html($sub->subscribed_at); ?></td>
                    <td>
                        <a href="<?php echo wp_nonce_url( admin_url('admin.php?page=wellness-subscribers&delete=' . $sub->id), 'wellness_delete_sub' ); ?>"
                           onclick="return confirm('Delete <?php echo esc_js($sub->email); ?>?')"
                           style="color:#b71c1c;text-decoration:none;font-size:12px;">Delete</a>
                    </td>
                </tr>
                <?php endforeach; else : ?>
                <tr><td colspan="7" style="text-align:center;padding:2rem;color:#666;">
                    <?php echo $search ? 'No subscribers match your search.' : 'No subscribers yet. They will appear here when someone fills the subscribe form.'; ?>
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if ( $total_pages > 1 ) : ?>
        <div class="tablenav bottom" style="margin-top:10px;">
            <div class="tablenav-pages">
                <?php
                echo paginate_links( array(
                    'base'      => add_query_arg( 'paged', '%#%' ),
                    'format'    => '',
                    'prev_text' => '&laquo;',
                    'next_text' => '&raquo;',
                    'total'     => $total_pages,
                    'current'   => $current_page,
                ) );
                ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php
}
