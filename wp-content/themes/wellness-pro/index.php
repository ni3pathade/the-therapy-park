<?php
/**
 * The main template file — fallback for Wellness Pro theme
 */
get_header(); ?>

<main id="main">
    <?php if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
    else : ?>
        <p><?php _e( 'No content found.', 'wellness-pro' ); ?></p>
    <?php endif; ?>
</main>

<?php get_footer();
