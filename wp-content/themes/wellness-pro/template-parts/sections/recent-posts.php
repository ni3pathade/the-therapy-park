<?php /** Recent Insights / Blog Posts */ ?>
<section class="insights-section" id="insights">
    <div class="container">
        <h2 class="section-title">Meet The Team</h2>

        <div class="insights-grid">
            <?php
            $args  = array( 'post_type' => 'post', 'posts_per_page' => 3, 'post_status' => 'publish', 'orderby' => 'date', 'order' => 'DESC' );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
                while ( $query->have_posts() ) : $query->the_post();
                    $cats = get_the_category();
                    ?>
                    <article class="post-card">
                        <a href="<?php the_permalink(); ?>" class="post-card__img">
                            <?php if ( has_post_thumbnail() ) : the_post_thumbnail('wellness-card');
                            else : ?><div style="width:100%;aspect-ratio:16/10;background:#d0cfc8;"></div><?php endif; ?>
                        </a>
                        <div class="post-card__body">
                            <h3 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="post-card__footer">
                                <span class="post-card__date"><?php echo get_the_date('M j, Y'); ?></span>
                                <a href="<?php the_permalink(); ?>" class="post-card__read">READ MORE</a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; wp_reset_postdata();
            else :
                $fallback_posts = array(
                    array( 'title' => 'Therapy Beyond Four Walls: How Online Sessions Changed My Life', 'cat' => 'Therapy', 'date' => 'Nov 13, 2025', 'img' => 'insight-1.jpg' ),
                    array( 'title' => 'Not A Guru, Not A God: What A Therapist Actually Does', 'cat' => 'Wellness', 'date' => 'Nov 13, 2025', 'img' => 'insight-2.jpg' ),
                    array( 'title' => 'Alopecia, Identity And Therapy: Finding Peace With Hair Loss', 'cat' => 'Identity', 'date' => 'Nov 13, 2025', 'img' => 'insight-3.jpg' ),
                );
                foreach ( $fallback_posts as $fp ) :
                    $img_url = get_template_directory_uri() . '/assets/images/' . $fp['img'];
                    ?>
                    <article class="post-card">
                        <div class="post-card__img">
                            <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $fp['title'] ); ?>" loading="lazy">
                        </div>
                        <div class="post-card__body">
                            <h3 class="post-card__title"><a href="#"><?php echo esc_html( $fp['title'] ); ?></a></h3>
                            <div class="post-card__footer"><span class="post-card__date"><?php echo esc_html( $fp['date'] ); ?></span><a href="#" class="post-card__read">READ MORE</a></div>
                        </div>
                    </article>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>
