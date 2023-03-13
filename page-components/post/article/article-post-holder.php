<?php $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

    $args = array(
        // grabs from category or post
        'post_type' => 'post',
        'posts_per_page' => 4,
        'paged'          => $paged,
        'post_status' => 'publish',
        'order' => 'DESC',
        'post__not_in'  => [get_the_ID()]
    );

$loop = new WP_Query( $args ); 

if ( $loop->have_posts() ) : ?>
<section class="ArticleHolder">
    <h3 class="ArticleHolder__title"><?php echo esc_html('Our latest posts'); ?></h3>
    <div class="ArticleHolder__grid">
        <?php while ( $loop->have_posts() ) : $loop->the_post();
        $post_id = get_the_ID();

        $read_time = get_field('article_read_time', $post_id );
        get_template_part('page-components/post/post-item');

        endwhile; 
        wp_reset_postdata();  ?>
    </div>
</section>
<?php endif; ?>