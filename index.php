<?php
// This file is redirects to page.php as nothing is on it

// get_header();

// header("Location:page.php");
// die();

/**
 * This file is loaded if no other template files are found.
 * 
 * Know your WordPress template hierarchy:
 * https://wphierarchy.com
 * 
 */
?>
<?php get_header(); ?>

<div id="content">
    <div id="inner-content" class="wrap">
        <main id="main" class="main" data-title="<?php the_title(); ?>" data-router-view="default" role="main" itemscope
            itemprop="mainContentOfPage" itemtype="https://schema.org/Blog">
            <?php the_content(); ?>
        </main>
    </div>
</div>

<?php
    /*
    SIDEBAR
    get_sidebar();
    */
?>

<?php get_footer(); ?>