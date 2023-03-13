<?php
/*
Template Name: Search Page
*/

// Load values and assign defaults.
$title = get_field('title', 'option');
$placeholderText = get_field('placeholder_text', 'option');
?>
<?php
get_header(); ?>

<div id="content">
    <div id="inner-content">
        <main id="main" class="main" data-title="<?php the_title(); ?>" data-router-view="default" role="main" itemscope
            itemprop="mainContentOfPage" itemtype="https://schema.org/Blog">

            <div class="SearchPage">
                <div class="SearchPage__inner container">

                    <?php if ( $title ): ?>
                    <h1 class='SearchPage__title'><?php echo $title; ?></h1>
                    <?php else: ?>
                    <h1 class='SearchPage__title'><?php echo esc_html('What are you looking for...'); ?></h1>
                    <?php endif; ?>

                    <form class='SearchPage__form js-search-form' method="get" action="<?php get_permalink(); ?>">
                        <input type="text" class="SearchPage__input search-field js-search-field"
                            placeholder="<?php echo $placeholderText; ?>" name="s"
                            value="<?php echo get_search_query(); ?>">
                        <button type="submit" class='SearchPage__btn js-search-submit'>
                            <i class="fa fa-search"></i>
                        </button>
                    </form>

                    <div class="SearchPage__disclaimer-group">
                        <h5 class="SearchPage__disclaimer js-disclaimer">
                            <?php echo esc_html('Hit enter to search'); ?><span class='js-disclaimer-span'>...</span>
                        </h5>
                        <h3 class="SearchPage__results__main-title js-results-title"></h3>
                    </div>


                    <div class="SearchPage__results-outer">
                        <div class="SearchPage__results js-render-results">
                        </div>
                        <div class="SearchPage__loader js-loader">
                            <div class="SearchPage__loader-grid">
                                <div class="SearchPage__loader-grid--item"></div>
                                <div class="SearchPage__loader-grid--item"></div>
                                <div class="SearchPage__loader-grid--item"></div>
                                <div class="SearchPage__loader-grid--item"></div>
                                <div class="SearchPage__loader-grid--item"></div>
                                <div class="SearchPage__loader-grid--item"></div>
                                <div class="SearchPage__loader-grid--item"></div>
                                <div class="SearchPage__loader-grid--item"></div>
                                <div class="SearchPage__loader-grid--item"></div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </main>
    </div>
</div>

<?php get_footer();