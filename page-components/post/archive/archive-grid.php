<?php if( have_rows('archive_grid') ): ?>
<section class="ArchiveGrid">
    <?php while( have_rows('archive_grid') ) : the_row(); 
    $filter = get_sub_field('show_filter');
    $postNumber = get_sub_field('post_number');
    $selectCat = get_sub_field('select_category');

    if($selectCat === 'yes'): 
        $terms = get_sub_field('select_posts'); 
    else: 
        $terms = '';
     endif;
    ?>

    <div class="ArchiveGrid--inner">
        <?php // WP FILTER ?>
        <?php if ($filter === 'yes'): ?>
        <?php $categories = get_categories(); ?>
        <div class="ArchiveGrid__filter">
            <div class="ArchiveGrid__filter--inner">
                <h5 class="ArchiveGrid__filter-item">
                    <?php echo esc_html( 'Filter by' ); ?>
                </h5>
                <a class="ArchiveGrid__filter-select js-filter-select js-active" href="#!" data-slug="all">
                    <?php echo esc_html('All') ?>
                </a>
                <?php foreach($categories as $category) : ?>
                <a class="ArchiveGrid__filter-select js-filter-select" href="#!"
                    data-slug="<?php echo sanitize_title($category->slug); ?>">
                    <?php echo $category->name; ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif;
        
        $number = intval($postNumber);

        // First, initialize how many posts to render per page
        if( $number === 2):  $display_count = 6;
            elseif ($number === 3):  $display_count = 9;
            elseif ($number === 4):  $display_count = 8;
            elseif ($number === 5):  $display_count = 10;
            else:
        endif;
        ?>

        <div class="ArchiveGrid__holder-outer js-master-holder" data-showposts="<?php echo $display_count; ?>"
            data-slug="<?php echo esc_html( $terms->slug ); ?>">
            <div class="ArchiveGrid__cover js-archive-cover"></div>
            <div class="ArchiveGrid__holder js-holder ArchiveGrid__holder--<?php echo $postNumber; ?>">
                <?php // post grid
                // Next, get the current page
                $page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

                $args = array(
                    // grabs from category or post
                    'post_type' => array('post', $terms->slug),
                    'category_name' => $terms->name,
                    'orderby'    =>  'date',
                    'order'      =>  'desc',
                    'showposts'  =>   $display_count,
                    'page'       =>  $page,
                );

                $loop = new WP_Query( $args );

                if ( $loop->have_posts() ) : 
                    while ( $loop->have_posts() ) : $loop->the_post(); 
                    get_template_part('page-components/post/post-item'); ?>
                <?php endwhile; 
                // this pagination is operated by the js Archive file ?>
                <?php wp_reset_postdata();  ?>
                <?php endif; ?>
            </div>
        </div>

        <?php // JS Pagination buttons ?>
        <?php if ($filter === 'yes'): ?>
        <div class="js-pagination ArchiveGrid__pagination">
            <div class="ArchiveGrid__pagination--inner">
                <button id="previous-posts"
                    class='js-previous-posts btn--block ArchiveGrid__pagination-btn ArchiveGrid__pagination-btn--prev'>
                    <?php echo esc_html( 'See previous posts' ); ?>
                </button>
                <button id="next-posts"
                    class='js-next-posts btn--block ArchiveGrid__pagination-btn ArchiveGrid__pagination-btn--prev'>
                    <?php echo esc_html( 'Show me more posts' ); ?>
                </button>
            </div>
        </div>
        <?php endif; ?>

    </div>
    <?php endwhile; ?>
</section>
<?php endif; ?>
