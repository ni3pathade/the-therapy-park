<?php
/**
 * Footer — Wellness Pro
 */
?>
<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-logo">
            <a href="<?php echo esc_url( home_url('/') ); ?>">
                <span class="logo-text">the therapy park</span>
            </a>
        </div>

        <nav class="footer-nav">
            <?php wp_nav_menu( array(
                'theme_location' => 'footer',
                'container'      => false,
                'fallback_cb'    => false,
                'depth'          => 1,
                'items_wrap'     => '<ul>%3$s</ul>',
            ) ); ?>
        </nav>

        <p class="footer-copy">
            &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.
        </p>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
