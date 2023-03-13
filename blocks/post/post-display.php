<?php

/**
 *  Post Display
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'post-display-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'PostDisplay';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }


// Load values and assign defaults.
$title = get_field('title');
$filter = get_field('show_filter');
$postNumber = get_field('post_number');
$select = get_field('show_blog_filter');
$selectCat = get_field('select_category');

if($selectCat === 'yes'): 
    $terms = get_field('select_posts'); 
else: 
    $terms = '';
 endif;

?>

<section class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>"
    data-block="<?php echo esc_attr($className); ?>">
    <div class="container PostDisplay__inner" id="<?php echo sanitize_title($anchor); ?>">

        <?php if($title): ?>
        <h3 class="PostDisplay__title"><?php echo $title; ?></h3>
        <?php endif; ?>

        <?php // WP FILTER ?>
        <?php if ($filter === 'yes'): ?>
        <?php $categories = get_categories(); ?>
        <div class="PostDisplay__filter">
            <div class="PostDisplay__filter--inner">
                <h5 class="PostDisplay__filter-item">
                    <?php echo esc_html( 'Filter by' ); ?>
                </h5>
                <a class="PostDisplay__filter-select js-filter-select js-active" href="#!" data-slug="all">
                    <?php echo esc_html('All') ?>
                </a>
                <?php foreach($categories as $category) : ?>
                <a class="PostDisplay__filter-select js-filter-select" href="#!"
                    data-slug="<?php echo sanitize_title($category->slug); ?>">
                    <?php echo $category->name; ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif;     

        $number = intval($postNumber);
        ?>

        <div class="PostDisplay__holder-outer js-master-holder" data-slug="<?php echo esc_html( $terms->slug ); ?>"
            data-showposts="<?php echo $postNumber; ?>">
            <div class="PostDisplay__cover js-archive-cover"></div>
            <div class="PostDisplay__holder js-holder PostDisplay__holder--<?php echo $number; ?>">
                <?php // post grid
                // Next, get the current page
                $page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

                $args = array(
                    // grabs from category or post
                    'post_type' => array('post', $terms->slug),
                    'category_name' => $terms->name,
                    'orderby'    =>  'date',
                    'order'      =>  'desc',
                    'showposts'  =>   $number,
                    'page'       =>  $page,
                );

                $loop = new WP_Query( $args );

                if ( $loop->have_posts() ) : 
                    while ( $loop->have_posts() ) : $loop->the_post(); ?>
                <?php get_template_part('page-components/post/post-item'); ?>
                <?php endwhile; 
                // this pagination is operated by the js Archive file ?>
                <?php wp_reset_postdata();  ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</section>