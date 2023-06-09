<?php
/*
 Template Name: Theme Template

*/
?>
<?php get_header(); ?>

<div id="content">
    <div id="inner-content">
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