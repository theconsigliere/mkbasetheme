<?php

/**
 *  Hero Image Side / Text Side
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'HeroImagesideTextside-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'HeroImagesideTextside';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }

// Block preview
if( !empty( $block['data']['is_preview'] ) ) { ?>
<img src="<?php echo get_theme_file_uri(); ?>/blocks/preview/Hero text-image.jpg" alt="">
<?php } 

// Load values and assign defaults.
$image = get_field('image');
$select = get_field('select_image_side');
$title = get_field('title');
$link = get_field('button');

?>

<section class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>"
    data-hero="<?php echo esc_attr($className); ?>">

    <div class="HeroImagesideTextside__inner  HeroImagesideTextside__inner--<?php echo $select; ?>"
        id="<?php echo sanitize_title($anchor); ?>">

        <?php if( $image ): ?>
        <div class="HeroImagesideTextside__image">
            <?php echo wp_get_attachment_image( $image , 'full', '', array('loading' => 'lazy', 'class' => 'js-parallax')); ?>
        </div>
        <?php endif; ?>

        <div class="HeroImagesideTextside__text">
            <div class="HeroImagesideTextside__text-inner">
                <?php if ($title) : ?>
                <h3 class="HeroImagesideTextside__title"><?php echo $title; ?></h3>
                <?php endif; ?>

                <?php if( have_rows('add_text') ): ?>
                <div class="HeroImagesideTextside__text-group">
                    <?php while( have_rows('add_text') ) : the_row();                 
                    $desc = get_sub_field('description'); ?>
                    <p class='HeroImagesideTextside__desc'><?php echo $desc; ?></p>
                    <?php endwhile; ?>
                </div>
                <?php endif;?>

                <?php if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self'; ?>

                <a class="btn--main" href="<?php echo esc_url( $link_url ); ?>"
                    target="<?php echo esc_attr( $link_target ); ?>">
                    <?php echo esc_html( $link_title ); ?>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>