<?php

/**
 *  Hero Slideshow
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'HeroSlideshow-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'HeroSlideshow';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }

$speed = get_field('slideshow_speed');
?>

<section class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>"
    data-hero='<?php echo esc_attr($className); ?>' data-duration="<?php echo $speed; ?>">

    <?php if (have_rows('add_slide')) : ?>
    <div class="HeroSlideshow__container swiper-container js-container">
        <div class="HeroSlideshow__wrapper swiper-wrapper">

            <?php while (have_rows('add_slide')) : the_row(); 
                // Load values and assign defaults.
                $image = get_sub_field('image');
                $title = get_sub_field('title');
                $subtitle = get_sub_field('subtitle');
                $desc = get_sub_field('desc');
                $button = get_sub_field('button');
                $select = get_sub_field('select_text_colour');
                ?>

            <div class="HeroSlideshow__slide swiper-slide js-slide">

                <?php if (!empty($image)) : ?>
                <?php echo wp_get_attachment_image( $image, 'full' ,'', array('loading' => 'lazy')); ?>
                <?php endif; ?>

                <div class="HeroSlideshow__slide--text-group<?php echo $position; ?>">

                    <?php if ( $title ) : ?>
                    <h1 class="HeroSlideshow__slide--title <?php if ($select === 'white'){ ?> white <?php } ?>">
                        <?php echo $title; ?></h1>
                    <?php endif; ?>

                    <?php if ( $subtitle ) : ?>
                    <h4 class="<?php if ($select === 'white'){ ?> white <?php } ?>"><?php echo $subtitle; ?></h4>
                    <?php endif; ?>

                    <?php if ( $desc ) : ?>
                    <p class='HeroSlideshow__desc <?php if ($select === 'white'){ ?> white <?php } ?>'>
                        <?php echo $desc; ?></p>
                    <?php endif; ?>

                    <?php 
                    if( $button ): 
                        $button_url = $button['url'];
                        $button_title = $button['title'];
                        $button_target = $button['target'] ? $button['target'] : '_self';
                        ?>
                    <a class="btn--main" href="<?php echo esc_url( $button_url ); ?>"
                        target="<?php echo esc_attr( $button_target ); ?>"><?php echo esc_html( $button_title ); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <div class="HeroSlideshow__pagination swiper-pagination js-pagination"></div>
        <!-- If we need navigation buttons -->
        <div class="swiper-buttons HeroSlideshow__buttons">
            <div class="HeroSlideshow__button HeroSlideshow__button--prev js-prev">
                <?php echo load_inline_svg('down-arrow.svg'); ?>
            </div>
            <div class="HeroSlideshow__button HeroSlideshow__button--next js-next">
                <?php echo load_inline_svg('down-arrow.svg'); ?>
            </div>
        </div>

        <!-- If we need scrollbar 
         <div class="swiper-scrollbar HeroSlideshow__scrollbar js-scrollbar"></div> -->
    </div>
    <?php endif; ?>
</section>