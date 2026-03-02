<?php /** Meet The Team */ ?>
<section class="team-section" id="team">
    <div class="container">
        <h2 class="section-title">Meet The Team</h2>

        <div class="team-wrap">
            <button class="carousel-arrow" id="team-prev" aria-label="Previous">&lt;</button>

            <div class="team-track" id="team-track">
                <?php
                $args  = array( 'post_type' => 'team_member', 'posts_per_page' => 6, 'post_status' => 'publish' );
                $query = new WP_Query( $args );

                if ( $query->have_posts() ) :
                    while ( $query->have_posts() ) : $query->the_post();
                        $role         = get_post_meta( get_the_ID(), '_team_title', true );
                        $pricing      = get_post_meta( get_the_ID(), '_team_pricing', true );
                        $availability = get_post_meta( get_the_ID(), '_team_availability', true );
                        $booking_url  = get_post_meta( get_the_ID(), '_team_booking_url', true ) ?: '#book';
                        ?>
                        <div class="team-card">
                            <div class="team-card__photo">
                                <?php if ( has_post_thumbnail() ) : the_post_thumbnail('wellness-team');
                                else : ?><div class="team-card__photo-placeholder">&#128100;</div><?php endif; ?>
                            </div>
                            <div class="team-card__body">
                                <div class="team-card__head-row">
                                    <h3 class="team-card__name"><?php the_title(); ?></h3>
                                    <a href="<?php echo esc_url( $booking_url ); ?>" class="team-card__book-btn">BOOK A SESSION</a>
                                </div>
                                <?php if ( $role ) : ?><p class="team-card__title"><?php echo esc_html( $role ); ?></p><?php endif; ?>
                                <?php if ( $pricing ) : ?><p class="team-card__pricing"><?php echo esc_html( $pricing ); ?></p><?php endif; ?>
                                <div class="team-card__foot-row">
                                    <?php if ( $availability ) : ?><p class="team-card__avail"><?php echo esc_html( $availability ); ?></p><?php endif; ?>
                                    <a href="#team" class="team-card__up-btn" aria-label="Back to top">&#8963;</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata();
                else :
                    // Static fallback
                    $members = array(
                        array( 'name' => 'Komal Sharma',    'role' => 'Trainee Psychologist',    'pricing' => '1-On-1: ₹ 700 | Couples: ₹ 1000', 'avail' => 'Mon - Sun (Flexible) | 12pm - 7pm', 'img' => 'team-komal.jpg'   ),
                        array( 'name' => 'Prerna Tongariya','role' => 'Trainee Psychologist',    'pricing' => '1-On-1: ₹ 700 | Couples: ₹ 1000', 'avail' => 'Thurs & Sun | 11am - 6pm',          'img' => 'team-prerna.jpg'  ),
                        array( 'name' => 'Apoorva Khanna',  'role' => 'Counselling Psychologist','pricing' => '1-On-1: ₹ 1000 | Couples: ₹ 1300','avail' => 'Wed & Thurs | 4pm - 10pm',          'img' => 'team-apoorva.jpg' ),
                    );
                    foreach ( $members as $m ) :
                        $img_url = get_template_directory_uri() . '/assets/images/' . $m['img'];
                    ?>
                        <div class="team-card">
                            <div class="team-card__photo">
                                <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $m['name'] ); ?>" loading="lazy">
                            </div>
                            <div class="team-card__body">
                                <div class="team-card__head-row">
                                    <h3 class="team-card__name"><?php echo esc_html( $m['name'] ); ?></h3>
                                    <a href="#book" class="team-card__book-btn">BOOK A SESSION</a>
                                </div>
                                <p class="team-card__title"><?php echo esc_html( $m['role'] ); ?></p>
                                <p class="team-card__pricing"><?php echo esc_html( $m['pricing'] ); ?></p>
                                <div class="team-card__foot-row">
                                    <p class="team-card__avail"><?php echo esc_html( $m['avail'] ); ?></p>
                                    <a href="#team" class="team-card__up-btn" aria-label="Back to top">&#8963;</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                endif; ?>
            </div>

            <button class="carousel-arrow" id="team-next" aria-label="Next">&gt;</button>
        </div>
    </div>
</section>
