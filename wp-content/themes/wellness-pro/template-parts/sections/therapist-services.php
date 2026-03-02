<?php /** Services for Therapists Section */

// Collect therapist service items from CPT
$th_items = array();
$th_query = new WP_Query( array(
    'post_type'      => 'therapist_service',
    'posts_per_page' => 6,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
) );
if ( $th_query->have_posts() ) {
    while ( $th_query->have_posts() ) {
        $th_query->the_post();
        $th_items[] = array(
            'name'    => get_the_title(),
            'img_url' => get_the_post_thumbnail_url( null, 'full' ) ?: '',
        );
    }
    wp_reset_postdata();
}
if ( empty( $th_items ) ) {
    $base = get_template_directory_uri() . '/assets/images/';
    $th_items = array(
        array( 'name' => 'Internship', 'img_url' => $base . 'therapist-internship.gif' ),
        array( 'name' => 'Workshop',   'img_url' => $base . 'therapist-workshop.gif'   ),
        array( 'name' => 'Mentorship', 'img_url' => $base . 'therapist-mentorship.gif' ),
        array( 'name' => 'Therapy',    'img_url' => $base . 'therapist-therapy.gif'    ),
    );
}
?>
<section class="therapist-section" id="therapists">

    <div class="therapist-header">
        <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'therapist_heading', 'Services for Therapists' ) ); ?></h2>
        <p class="section-desc">
            <?php echo esc_html( get_theme_mod( 'therapist_desc', 'At Therapy Park, we equip our practitioners with tools for personal and professional growth through our collective' ) ); ?>
            <a href="#" class="therapist-link">Founder's Anonymous</a>.
        </p>
    </div>

    <div class="therapist-grid">
        <?php foreach ( $th_items as $item ) : ?>
        <div class="therapist-item">
            <?php if ( $item['img_url'] ) : ?>
                <img src="<?php echo esc_url( $item['img_url'] ); ?>"
                     alt="<?php echo esc_attr( $item['name'] ); ?>"
                     loading="lazy">
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>

</section>
