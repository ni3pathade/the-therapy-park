<?php /** Benefits of Working With Us */

// Collect benefits from CPT
$b_slides = array();
$b_query  = new WP_Query( array(
    'post_type'      => 'benefit',
    'posts_per_page' => 10,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
) );
if ( $b_query->have_posts() ) {
    while ( $b_query->have_posts() ) {
        $b_query->the_post();
        $b_slides[] = array(
            'title'    => get_the_title(),
            'text'     => wp_strip_all_tags( get_the_content() ),
            'btn_text' => get_post_meta( get_the_ID(), '_benefit_btn_text', true ) ?: 'Book a Session',
            'btn_url'  => get_post_meta( get_the_ID(), '_benefit_btn_url',  true ) ?: '#book',
        );
    }
    wp_reset_postdata();
}
if ( empty( $b_slides ) ) {
    $default_url = get_theme_mod( 'booking_url', '' ) ?: '#contact';
    $b_slides = array(
        array( 'title' => 'Benefit 1', 'text' => 'At Therapy Park, we equip our practitioners with tools for personal and professional growth through our collective Founder\'s Association.', 'btn_text' => 'Book a Session', 'btn_url' => $default_url ),
        array( 'title' => 'Benefit 2', 'text' => 'Connect with a community of like-minded therapists, receive supervision, and access resources that elevate your practice.',                  'btn_text' => 'Book a Session', 'btn_url' => $default_url ),
        array( 'title' => 'Benefit 3', 'text' => 'Develop your skills through workshops, mentorship programs, and hands-on training designed specifically for mental health professionals.',  'btn_text' => 'Book a Session', 'btn_url' => $default_url ),
    );
}
?>
<section class="benefits-section" id="benefits">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'benefits_heading', 'Benefits of working with us' ) ); ?></h2>
        <p class="section-desc"><?php echo esc_html( get_theme_mod( 'benefits_desc', 'At Therapy Park, we equip our practitioners with tools for personal and professional growth through our collective Founder\'s Association.' ) ); ?></p>

        <div class="benefits-grid">

            <!-- Left: Text carousel -->
            <div class="benefits-carousel">
                <div class="benefit-slides">
                    <?php foreach ( $b_slides as $i => $b ) : ?>
                        <div class="benefit-slide <?php echo $i === 0 ? 'active' : ''; ?>">
                            <h3 class="benefit-slide__title"><?php echo esc_html( $b['title'] ); ?></h3>
                            <p class="benefit-slide__text"><?php echo esc_html( $b['text'] ); ?></p>
                            <a href="<?php echo esc_url( $b['btn_url'] ); ?>" class="btn btn-yellow"><?php echo esc_html( $b['btn_text'] ); ?></a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="carousel-dots">
                    <?php for ( $i = 0; $i < count( $b_slides ); $i++ ) : ?>
                        <button class="dot <?php echo $i === 0 ? 'active' : ''; ?>" data-index="<?php echo $i; ?>" aria-label="Slide <?php echo $i + 1; ?>"></button>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Right: Tree illustration -->
            <div class="benefits-illustration" aria-hidden="true">
                <?php
                $ben_img = get_theme_mod( 'benefits_illustration', '' );
                $ben_url = $ben_img ?: get_template_directory_uri() . '/assets/images/benefits-tree.svg';
                ?>
                <img src="<?php echo esc_url( $ben_url ); ?>" alt="" loading="lazy">
            </div>

        </div>
    </div>
</section>
