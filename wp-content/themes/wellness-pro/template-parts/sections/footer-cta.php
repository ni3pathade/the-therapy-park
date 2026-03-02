<?php /** Footer CTA */ ?>
<section class="footer-cta-section" id="contact">
    <div class="footer-cta-card">
        <div class="footer-cta-content">
            <h2><?php echo esc_html(get_theme_mod('cta_heading', 'Reach out to us to find perfect therapist for you')); ?></h2>
            <p><?php echo esc_html(get_theme_mod('cta_desc', 'Lacinia vel faucibus nullam purus facilisis consectetur euismod.')); ?></p>
            <?php $cta_url = get_theme_mod('cta_btn_url', '') ?: get_theme_mod('booking_url', '') ?: '#contact'; ?>
            <a href="<?php echo esc_url($cta_url); ?>" class="btn btn-yellow"><?php echo esc_html(get_theme_mod('cta_btn_text', 'Book a Session')); ?></a>
        </div>
        <div class="footer-cta-image" aria-hidden="true">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/cta-illustration.svg" alt="">
        </div>
    </div>
</section>
