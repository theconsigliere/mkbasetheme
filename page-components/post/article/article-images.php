<div class="ArticleImages">
    <?php if( have_rows('add_a_image') ):  ?>

    <?php while( have_rows('add_a_image') ) : the_row();
        $image= get_sub_field('article_image');
        $caption = get_sub_field('caption');
        ?>

    <div class="ArticleImages__image-group">
        <?php if (!empty($image)) : ?>
        <?php echo wp_get_attachment_image( $image, 'full' ,'', array('loading' => 'lazy', 'class' => 'ArticleImages__image')); ?>
        <?php endif; ?>

        <?php if ($caption) : ?>
        <p class='ArticleImages__caption'><?php echo $caption; ?></p>
        <?php endif; ?>
    </div>
    <?php endwhile; ?>

    <?php endif; ?>
</div>