<?php if( have_rows('article_intro') ): ?>

<div class="Article__content Article__content--main">
    <section class="ArticleIntro">
        <?php while( have_rows('article_intro') ) : the_row(); 
        $intro = get_sub_field('intro_text');
        $time = get_sub_field('article_read_time');  
        ?>

        <div class="ArticleIntro--inner">
            <?php if ($intro): ?>
            <h3 class="ArticleIntro__title"><?php echo $intro; ?></h3>
            <?php endif; ?>

            <?php if ($time): ?>
            <p class="ArticleIntro__read-time">
                <?php echo esc_html('Read time '); echo $time; echo esc_html(' minutes '); ?></p>
            <?php endif; ?>
        </div>

        <?php endwhile; ?>
    </section>
</div>
<?php endif; ?>