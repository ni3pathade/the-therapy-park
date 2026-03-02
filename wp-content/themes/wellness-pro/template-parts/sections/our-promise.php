<?php /** Our Promise Section */ ?>
<section class="promise-section" id="promise">

    <div class="promise-artwork">
        <?php
        $theme_uri  = get_template_directory_uri();
        $wave_img   = get_theme_mod( 'promise_wave_img',  '' ) ?: $theme_uri . '/assets/images/promise-wave.svg';
        $title_img  = get_theme_mod( 'promise_title_img', '' ) ?: $theme_uri . '/assets/images/promise-title-art.svg';
        ?>
        <svg class="promise-svg" viewBox="0 0 1280 209" width="100%"
             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             aria-label="Our Promise">

            <!-- Wave line — behind -->
            <image href="<?php echo esc_url( $wave_img ); ?>"
                   x="0" y="2" width="1280" height="205"/>

            <!-- Title + icons frame — in front, centered -->
            <image href="<?php echo esc_url( $title_img ); ?>"
                   x="40" y="0" width="1200" height="209"/>

        </svg>
    </div>

</section>
