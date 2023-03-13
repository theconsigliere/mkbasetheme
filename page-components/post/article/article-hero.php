<?php if( have_rows('article_hero') ): ?>
<div class="ArticleHero js-hero">
    <?php while( have_rows('article_hero') ) : the_row(); 
                
        $image = get_sub_field('image');
        $quote = get_sub_field('article_title');
        $date =  get_the_date( 'F j, Y' ); 
        $title = get_the_title();
        $categories = get_the_category();
        ?>

    <?php if (!empty($image)) : ?>
    <div class="ArticleHero__image" itemprop="primaryImageOfPage">
        <?php echo wp_get_attachment_image( $image['ID'], 'full', '', array('loading' => 'lazy')); ?>
    </div>
    <?php endif; ?>

    <div class="ArticleHero__title-group">
        <div class="ArticleHero__title-group--inner">

            <div class="ArticleHero__categories">
                <?php foreach($categories as $category) { ?>
                <p class='ArticleHero__category'>
                    <?php echo $category->name; ?>
                </p>
                <?php  } ?>
            </div>

            <?php if($title): ?>
            <h1 class="ArticleHero__title"><?php echo $title; ?></h1>
            <?php endif; ?>

            <?php // date; ?>
            <?php if ($date): ?>
            <p class="ArticleHero__date"><?php echo $date; ?></p>
            <?php endif; ?>

            <?php 
                $link = get_field('link_to_archive_page', 'option'); 
                if ($link): 
                   
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>
            <a class="ArticleHero__btn" href="<?php echo esc_url( $link_url ); ?>"
                target="<?php echo esc_attr( $link_target ); ?>">
                <?php echo esc_html( $link_title ); ?>
            </a>
            <?php endif; ?>
        </div>
    </div>

    <?php endwhile; ?>
</div>
<?php endif; ?>