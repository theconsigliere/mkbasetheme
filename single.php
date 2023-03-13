<?php get_header(); 

// ARTICLE PAGE
// All article components are in
// Page-components > Post > Article

// Styles in
// src > scss > post > article.scss
?>

<div class='Article' itemscope itemtype="https://schema.org/Article" data-title='<?php echo get_the_title(); ?>'>

    <?php // Article Hero
    get_template_part( 'page-components/post/article/article-hero' ); ?>

    <main class="container Article__container js-article-container">
        <?php // Article Intro
        get_template_part( 'page-components/post/article/article-intro' ); ?>

        <?php // Check value exists.
        if( have_rows('article_content') ): ?>
        <div class="Article__content Article__content--main">
            <?php while ( have_rows('article_content') ) : the_row();
                        
            if( get_row_layout() == 'text' ): ?>
            <?php // Article Text
            get_template_part( 'page-components/post/article/article-text' ); ?>

            <?php elseif( get_row_layout() == 'quote' ):  
            // Article Quote
            get_template_part( 'page-components/post/article/article-quote' ); ?>

            <?php elseif( get_row_layout() == 'video' ): 
            // Article video
            get_template_part( 'page-components/post/article/article-video' ); ?>

            <?php elseif( get_row_layout() == 'tip' ):                  
            // Article Tip
            get_template_part( 'page-components/post/article/article-tip' ); ?>

            <?php elseif( get_row_layout() == 'images' ):   
            // Article Images
            get_template_part( 'page-components/post/article/article-images' ); ?>


            <?php endif; ?>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>

        <?php // Article Author
         get_template_part( 'page-components/post/article/article-author' ); ?>

    </main>

    <?php // Article Holder
     get_template_part( 'page-components/post/article/article-post-holder' ); ?>

</div>

<?php get_footer(); ?>