<?php
/**
 * Sidebar — Single Post
 */

// Author widget
$author_id   = get_the_author_meta('ID');
$author_name = get_the_author();
$author_bio  = get_the_author_meta('description');
?>

<!-- Author Widget -->
<div class="sidebar-author">
    <p class="sidebar-author__label">Written by</p>
    <div class="sidebar-author__info">
        <div class="sidebar-author__avatar">
            <?php echo get_avatar( $author_id, 48 ); ?>
        </div>
        <div>
            <p class="sidebar-author__name"><?php echo esc_html($author_name); ?></p>
            <?php if ($author_bio) : ?>
                <p class="sidebar-author__bio"><?php echo esc_html($author_bio); ?></p>
            <?php else : ?>
                <p class="sidebar-author__bio">Lorem ipsum dolor sit amet</p>
            <?php endif; ?>
        </div>
    </div>
    <p class="sidebar-share-label">Share</p>
    <div class="sidebar-share-icons">
        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener" class="sidebar-share-icon" aria-label="Twitter">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-twitter.svg" alt="Twitter">
        </a>
        <a href="https://facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener" class="sidebar-share-icon" aria-label="Facebook">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-facebook.svg" alt="Facebook">
        </a>
        <a href="https://instagram.com" target="_blank" rel="noopener" class="sidebar-share-icon" aria-label="Instagram">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-instagram.svg" alt="Instagram">
        </a>
        <a href="https://linkedin.com/shareArticle?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener" class="sidebar-share-icon" aria-label="LinkedIn">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-linkedin.svg" alt="LinkedIn">
        </a>
    </div>
</div>

<!-- Newsletter Widget -->
<div class="sidebar-newsletter">
    <h3>Join our Newsletter</h3>
    <p>If you're driven by curiosity and love research-based culture arguments, the newsletter is for you.</p>
    <?php $nl_sc = get_theme_mod('newsletter_shortcode', '');
    if ($nl_sc) : ?>
        <div class="newsletter-shortcode"><?php echo do_shortcode($nl_sc); ?></div>
    <?php else : ?>
    <form class="newsletter-input-row" action="#" method="post">
        <?php wp_nonce_field('wellness_newsletter','nl_nonce'); ?>
        <input type="email" name="nl_email" placeholder="Enter your email" required>
        <button type="submit" class="btn btn-purple">Contact us</button>
    </form>
    <?php endif; ?>
</div>

<!-- Featured Posts Widget -->
<div class="sidebar-featured">
    <h3>Featured post</h3>
    <div class="sidebar-divider"></div>
    <?php
    $sticky = get_option('sticky_posts');
    $args   = array(
        'post_type'      => 'post',
        'posts_per_page' => 3,
        'post_status'    => 'publish',
        'post__in'       => !empty($sticky) ? array_slice($sticky, 0, 3) : array(),
        'orderby'        => !empty($sticky) ? 'post__in' : 'date',
    );
    if ( empty($sticky) ) unset($args['post__in']);
    $fp = new WP_Query($args);
    while ( $fp->have_posts() ) : $fp->the_post();
        $fcats = get_the_category(); ?>
        <div class="featured-post-row">
            <div class="featured-post-thumb">
                <?php if ( has_post_thumbnail() ) : the_post_thumbnail('wellness-thumbnail');
                else : ?><div style="width:100%;height:100%;background:#ddd;"></div><?php endif; ?>
            </div>
            <div>
                <p class="featured-post-meta">
                    <?php if ($fcats) : ?><span style="color:var(--purple);font-size:.7rem;font-weight:700;"><?php echo esc_html($fcats[0]->name); ?></span> &nbsp;<?php endif; ?>
                    <span><?php the_title(); ?></span>
                </p>
                <p class="featured-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
            </div>
        </div>
    <?php endwhile; wp_reset_postdata(); ?>
</div>

<?php if ( is_active_sidebar('blog-sidebar') ) : ?>
    <div><?php dynamic_sidebar('blog-sidebar'); ?></div>
<?php endif; ?>
