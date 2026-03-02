<?php /** Stories Of Transformation */

// Collect all testimonials
$all_testimonials = array();
$args  = array( 'post_type' => 'testimonial', 'posts_per_page' => 10, 'post_status' => 'publish' );
$query = new WP_Query( $args );

if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
        $query->the_post();
        $client = get_post_meta( get_the_ID(), '_testimonial_client_name', true ) ?: get_the_title();
        $all_testimonials[] = array(
            'quote'  => wp_strip_all_tags( get_the_content() ),
            'author' => $client,
        );
    }
    wp_reset_postdata();
} else {
    $all_testimonials = array(
        array( 'quote' => 'Amet ut aliqua labore nisi anim Lorem exercitation irure velit fugiat ipsum tempor elit cillum nulla. Sunt voluptate excepteur anim qui aliqua. Ea in labore labore do officia.', 'author' => 'Anonymous' ),
        array( 'quote' => 'At The Therapy Park, we hold safe spaces to support you through the roller-coaster called life, with trauma-informed care.', 'author' => 'Anonymous' ),
        array( 'quote' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit. Aenean tempor velit tempus velit donec nulla facilisi pellentesque.', 'author' => 'Anonymous' ),
        array( 'quote' => 'I have completed around 50 sessions with Akshita. I found her to be very perceptive and someone who steps out of conventional thinking to accommodate issues she may not have experience with.', 'author' => 'Anonymous' ),
        array( 'quote' => 'A year ago I was in a really difficult place — overwhelmed, lost, and unsure how to move forward. Akshita helped me navigate the storm and make sense of the chaos.', 'author' => 'Anonymous' ),
    );
}

$json_data = wp_json_encode( $all_testimonials );
?>
<section class="testimonials-section" id="testimonials">
    <div class="container">
        <h2 class="section-title">Stories Of Transformation</h2>

        <div class="testimonials-wrap">
            <button class="carousel-arrow" id="test-prev" aria-label="Previous">&lt;</button>

            <div class="testimonials-track" id="testimonials-track"
                 data-testimonials="<?php echo esc_attr( $json_data ); ?>">

                <!-- Left card (prev testimonial) -->
                <div class="testimonial-card" id="test-card-prev">
                    <p class="testimonial-card__quote" id="test-quote-prev"></p>
                    <p class="testimonial-card__author" id="test-author-prev"></p>
                </div>

                <!-- Center card — always purple, always middle -->
                <div class="testimonial-card testimonial-card--purple" id="test-card-center">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/happy.svg"
                         class="testimonial-card__happy" alt="" aria-hidden="true">
                    <p class="testimonial-card__quote" id="test-quote-center"></p>
                    <p class="testimonial-card__author" id="test-author-center"></p>
                </div>

                <!-- Right card (next testimonial) -->
                <div class="testimonial-card" id="test-card-next">
                    <p class="testimonial-card__quote" id="test-quote-next"></p>
                    <p class="testimonial-card__author" id="test-author-next"></p>
                </div>

            </div>

            <button class="carousel-arrow" id="test-next" aria-label="Next">&gt;</button>
        </div>
    </div>
</section>
