<?php   
$post_id = get_the_ID();
$title = get_the_title();
$articleHero = get_field_object('article_hero', $post_id)['value']; 
$date =  get_the_date( 'F j, Y' ); 
$image = $articleHero['image'];
$articleIntro = get_field_object('article_intro', $post_id)['value']; 
$desc = $articleIntro['intro_text'];
$time = $articleIntro['article_read_time'];
?>

<?php // WARNING 

// If you change this markup and add new ACF fields, 
// you will have to amend the
// PostItem JavaScript file in the JS folder
// So Archive & PostDisplay can load it

?>

<a href="<?php the_permalink( $post ); ?>" class='PostItem' target='_self' title="<?php echo $title; ?>">
    <article class="PostItem--inner">
        <div class="PostItem__image">
            <?php echo wp_get_attachment_image( $image['ID'], 'full', '', array('loading' => 'lazy')); ?>
        </div>
        <div class="PostItem__text-group">
            <div class="PostItem__categories">
                <?php foreach((get_the_category()) as $category) { ?>
                <p class='PostItem__category'>
                    <?php echo $category->name; ?>
                </p>
                <?php } ?>
            </div>

            <?php if( $title ):?>
            <h5 class="PostItem__title"><?php echo $title; ?></h5>
            <?php endif; ?>

            <?php if( $date ):?>
            <p class='PostItem__date'>
                <?php echo $date; ?>
                <?php if( $time ): ?>
                <span class="PostItem__readtime">
                    <?php echo ' | ' . $time . esc_attr( ' min read' ); ?>
                </span>
                <?php endif ?>
            </p>
            <?php endif; ?>

            <?php if( $desc ):?>
            <p class="PostItem__desc"><?php echo wp_trim_words($desc, 20); ?></p>
            <?php endif; ?>

            <button class="btn--underline PostItem__btn"><?php echo esc_attr( 'Full Article' )?></button>
        </div>
    </article>
</a>