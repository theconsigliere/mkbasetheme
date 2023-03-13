<?php get_header(); 

// Template Name: Archive
//
// All archive components are in
// Page-components > Post > archive
//
// Styles
// src > scss > post > archive.scss
?>

<div class='Archive' data-title='<?php echo get_the_title(); ?>'>

    <?php // archive Hero
    get_template_part( 'page-components/post/archive/archive-hero' ); ?>

    <main class="container Archive__container js-archive-container">
        <?php // archive Intro
        get_template_part( 'page-components/post/archive/archive-grid' ); ?>

    </main>

</div>

<?php get_footer(); ?>