<?php get_header(); ?>

<main id="main">

    <!-- Blog Hero -->
    <section class="blog-hero-section">
        <!-- Layer 2: Ellipse background shape -->
        <div class="blog-hero-ellipse" aria-hidden="true">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog-hero-ellipse.svg" alt="">
        </div>
        <!-- Layer 3: Girl & boy line-art illustration -->
        <div class="blog-hero-art" aria-hidden="true">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/blog-hero-illustration.svg" alt="">
        </div>
        <!-- Layer 4: Text content -->
        <div class="container">
            <div class="blog-hero-content">
                <h1 class="blog-hero-title">Insights made for people looking for clarity</h1>
                <?php $nl_sc = get_theme_mod('newsletter_shortcode', '');
                if ($nl_sc) : ?>
                    <div class="blog-subscribe-shortcode"><?php echo do_shortcode($nl_sc); ?></div>
                <?php else : ?>
                <form class="blog-subscribe-form" id="subscribe-form" action="#" method="post">
                    <?php wp_nonce_field('wellness_subscribe','sub_nonce'); ?>
                    <input type="email" name="email" placeholder="Your email address" required>
                    <button type="submit" class="btn btn-subscribe">Subscribe</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <!-- Bottom center label -->
        <div class="blog-hero-bottom-label">
            <p class="filter-label">Select based on your needs</p>
        </div>
    </section>

    <!-- Filter Tags -->
    <section class="blog-filter-section">
        <div class="blog-filter-inner">
            <div class="filter-tags-row" id="filter-tags-row">
                <button class="filter-tag active" data-cat="all">All Tags</button>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/filter-divider.svg" class="filter-divider" alt="" aria-hidden="true">
                <?php
                $cats = get_categories( array('hide_empty' => true) );
                foreach ( $cats as $cat ) : ?>
                    <button class="filter-tag" data-cat="<?php echo esc_attr($cat->slug); ?>">
                        <?php echo esc_html($cat->name); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Post Grid -->
    <section class="blog-grid-section">
        <div class="container">
            <div class="posts-spinner" id="posts-spinner"><span class="spinner"></span></div>

            <div class="blog-grid" id="blog-grid">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                    $cats = get_the_category(); ?>
                    <article class="post-card">
                        <a href="<?php the_permalink(); ?>" class="post-card__img">
                            <?php if ( has_post_thumbnail() ) : the_post_thumbnail('wellness-card');
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
                <?php endwhile; else : ?>
                    <p style="color:rgba(255,255,255,.5);grid-column:1/-1;text-align:center;padding:3rem;">No posts found.</p>
                <?php endif; ?>
            </div>

            <?php
            global $wp_query;
            $max = $wp_query->max_num_pages;
            if ( $max > 1 ) : ?>
                <div class="load-more-wrap">
                    <button class="btn btn-outline-white load-more-btn" id="load-more"
                        data-page="2" data-max="<?php echo $max; ?>" data-cat="all">
                        Load More
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer CTA -->
    <?php get_template_part('template-parts/sections/footer-cta'); ?>

</main>

<?php get_footer(); ?>
