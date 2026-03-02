<?php /** Our Services Section */ ?>
<section class="services-section" id="services">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html( get_theme_mod( 'services_heading', 'Our services' ) ); ?></h2>
        <p class="section-desc"><?php echo esc_html( get_theme_mod( 'services_desc', 'At The Therapy Park, we hold safe spaces to support you through the roller-coaster called life, with trauma-informed care.' ) ); ?></p>

        <div class="services-grid">
            <?php
            $svc_query = new WP_Query( array(
                'post_type'      => 'service',
                'posts_per_page' => 6,
                'post_status'    => 'publish',
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
            ) );

            if ( $svc_query->have_posts() ) :
                $num = 0;
                while ( $svc_query->have_posts() ) : $svc_query->the_post();
                    $num++;
                    $color   = get_post_meta( get_the_ID(), '_service_color', true ) ?: '#94946D';
                    $img_url = get_the_post_thumbnail_url( null, 'full' );
                    $icon    = get_post_meta( get_the_ID(), '_service_icon', true );
            ?>
                <div class="service-card service-card--<?php echo $num; ?>"
                     style="background: <?php echo esc_attr( $color ); ?>;">
                    <div class="service-card__illustration">
                        <?php if ( $img_url ) : ?>
                            <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                        <?php elseif ( $icon ) : ?>
                            <span style="font-size:3rem;"><?php echo esc_html( $icon ); ?></span>
                        <?php endif; ?>
                    </div>
                    <h3 class="service-card__name"><?php the_title(); ?></h3>
                </div>
            <?php endwhile; wp_reset_postdata();

            else :
                // Static fallback
                $services = array(
                    array( 'name' => 'Individual<br>Therapy',  'img' => 'svc-individual.svg',  'color' => '#94946D', 'num' => 1 ),
                    array( 'name' => 'Group<br>Therapy',       'img' => 'svc-group.svg',       'color' => '#8A7685', 'num' => 2 ),
                    array( 'name' => 'Couples<br>Therapy',     'img' => 'svc-couples.svg',     'color' => '#5E837F', 'num' => 3 ),
                    array( 'name' => 'Specialised<br>Areas',   'img' => 'svc-specialised.svg', 'color' => '#605C58', 'num' => 4 ),
                    array( 'name' => 'Therapy for<br>Parents', 'img' => 'svc-parents.svg',     'color' => '#8C8490', 'num' => 5 ),
                    array( 'name' => 'Workshops',              'img' => 'svc-workshops.svg',   'color' => '#677369', 'num' => 6 ),
                );
                foreach ( $services as $s ) :
                    $img_url = get_template_directory_uri() . '/assets/images/' . $s['img'];
            ?>
                <div class="service-card service-card--<?php echo $s['num']; ?>"
                     style="background: <?php echo esc_attr( $s['color'] ); ?>;">
                    <div class="service-card__illustration">
                        <img src="<?php echo esc_url( $img_url ); ?>"
                             alt="<?php echo esc_attr( strip_tags( $s['name'] ) ); ?>"
                             loading="lazy">
                    </div>
                    <h3 class="service-card__name"><?php echo wp_kses( $s['name'], array( 'br' => array() ) ); ?></h3>
                </div>
            <?php endforeach;
            endif; ?>
        </div>

    </div>
</section>
