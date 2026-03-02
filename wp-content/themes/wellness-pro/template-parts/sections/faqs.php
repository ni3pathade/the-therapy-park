<?php /** FAQ Section */

// Try to load FAQs from CPT
$faq_q   = new WP_Query(array('post_type' => 'faq', 'posts_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'menu_order', 'order' => 'ASC'));
$use_cpt = $faq_q->have_posts();

// Static fallback
$static_faqs = array(
    array('q' => 'What types of therapy do you offer?',              'a' => 'We offer Individual Therapy, Group Therapy, Couples Therapy, Specialised Areas, Therapy for Parents, and Workshops. Our team of qualified therapists work with clients across a wide range of mental health concerns.'),
    array('q' => 'How do I book a session?',                        'a' => 'You can book a session through our website by clicking the "Book a Session" button. Choose your preferred therapist, select an available time slot, and complete your booking online.'),
    array('q' => 'Is online therapy available?',                    'a' => 'Yes, we offer both in-person and online therapy sessions. Online sessions are conducted via secure video call, making therapy accessible no matter where you are located.'),
    array('q' => 'How long is each therapy session?',               'a' => 'Standard individual therapy sessions are 50 minutes long. Group sessions may vary between 60–90 minutes. Your therapist will discuss the recommended session length during your initial consultation.'),
    array('q' => 'What can I expect in my first session?',          'a' => 'Your first session is an assessment and getting-to-know-you appointment. Your therapist will ask about your concerns, goals, and background. Together you will agree on a plan for your therapy journey.'),
    array('q' => 'Is everything I share kept confidential?',        'a' => 'Yes, confidentiality is fundamental to therapy. Everything you share is kept private, with limited exceptions (such as risk of serious harm) that your therapist will explain during your first session.'),
    array('q' => 'How many sessions will I need?',                  'a' => 'The number of sessions varies depending on your individual needs and goals. Some clients benefit from short-term focused work (6–10 sessions), while others prefer longer-term support. Your therapist will guide you.'),
    array('q' => 'What are your fees and do you offer concessions?', 'a' => 'Our fees vary by therapist and service type. We offer a limited number of reduced-fee slots for those experiencing financial hardship. Please contact us to discuss your options.'),
);
?>
<section class="faq-section" id="faq">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html(get_theme_mod('faq_heading', "FAQ's")); ?></h2>

        <div class="faq-grid">
            <?php if ($use_cpt) :
                $i = 0;
                while ($faq_q->have_posts()) : $faq_q->the_post(); ?>
                    <div class="faq-item" id="faq-<?php echo $i; ?>">
                        <button class="faq-item__btn" aria-expanded="false" aria-controls="faq-body-<?php echo $i; ?>">
                            <span><?php the_title(); ?></span>
                            <span class="faq-icon" aria-hidden="true">+</span>
                        </button>
                        <div class="faq-item__body" id="faq-body-<?php echo $i; ?>">
                            <?php echo wp_kses_post(get_the_content()); ?>
                        </div>
                    </div>
                <?php $i++; endwhile; wp_reset_postdata();
            else :
                foreach ($static_faqs as $i => $faq) : ?>
                    <div class="faq-item" id="faq-<?php echo $i; ?>">
                        <button class="faq-item__btn" aria-expanded="false" aria-controls="faq-body-<?php echo $i; ?>">
                            <span><?php echo esc_html($faq['q']); ?></span>
                            <span class="faq-icon" aria-hidden="true">+</span>
                        </button>
                        <div class="faq-item__body" id="faq-body-<?php echo $i; ?>">
                            <?php echo esc_html($faq['a']); ?>
                        </div>
                    </div>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>
