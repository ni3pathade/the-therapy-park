<?php get_header(); ?>

<main id="main" class="single-page">
    <?php while ( have_posts() ) : the_post(); ?>

    <div class="single-layout">

        <!-- Main Content -->
        <article class="single-content">

            <!-- Breadcrumb -->
            <nav class="breadcrumb">
                <a href="<?php echo home_url('/'); ?>">Home</a>
                <span class="breadcrumb-sep">•</span>
                <?php $cats = get_the_category();
                if ( $cats ) : ?>
                    <a href="<?php echo get_category_link($cats[0]->term_id); ?>"><?php echo esc_html($cats[0]->name); ?></a>
                    <span class="breadcrumb-sep">•</span>
                <?php endif; ?>
                <span><?php the_title(); ?></span>
            </nav>

            <!-- Category tag -->
            <?php if ( $cats ) : ?>
                <a href="<?php echo get_category_link($cats[0]->term_id); ?>" class="post-category-tag">
                    <?php echo esc_html($cats[0]->name); ?>
                </a>
            <?php endif; ?>

            <!-- Title -->
            <h1 class="post-page-title"><?php the_title(); ?></h1>

            <!-- Excerpt/intro -->
            <?php if ( has_excerpt() ) : ?>
                <p class="post-page-intro"><?php the_excerpt(); ?></p>
            <?php endif; ?>

            <!-- Featured image -->
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="post-featured-img"><?php the_post_thumbnail('wellness-hero'); ?></div>
            <?php endif; ?>

            <!-- Content -->
            <div class="post-body entry-content">
                <?php the_content(); ?>
            </div>

        </article>

        <!-- Sidebar -->
        <aside class="single-sidebar">
            <?php get_sidebar(); ?>
        </aside>

    </div>

    <!-- Related Posts -->
    <?php
    $related = wellness_pro_related_posts( get_the_ID(), 3 );
    if ( $related->have_posts() ) : ?>
        <section class="related-posts-section">
            <h2>Other Posts for your Reference</h2>
            <div class="related-posts-grid">
                <?php while ( $related->have_posts() ) : $related->the_post();
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
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Footer CTA -->
    <?php get_template_part('template-parts/sections/footer-cta'); ?>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
