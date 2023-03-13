<?php

/**
 *  Slideshow
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'Slideshow-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'Slideshow';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }


// Load values and assign defaults.
$anchor = get_field('html_anchor');
$speed = get_field('slideshow_speed');
// $select = get_field('slideshow_effect');

?>

<section class='<?php echo esc_attr($className); ?>' id="<?php echo esc_attr($id); ?>"
    data-block="<?php echo esc_attr($className); ?>" data-duration="<?php echo $speed; ?>">

    <div class="Slideshow__inner swiper js-slider" id="<?php echo sanitize_title($anchor); ?>">

        <?php if (have_rows('add_slide')) : ?>
        <div class="Slideshow__wrapper swiper-wrapper js-wrapper">
            <?php while (have_rows('add_slide')) : the_row(); 
            
            $image = get_sub_field('slide_image');
            $title = get_sub_field('slide_title');
            $link = get_sub_field('slide_button');
            ?>

            <figure class="swiper-slide Slideshow__slide">
                <?php echo wp_get_attachment_image( $image, 'full', '', array('loading' => 'lazy'));   ?>

                <figcaption class="Slideshow__slide-figcaption">
                    <?php if ($title) : ?>
                    <h3 class="Slideshow__slide-title">
                        <?php echo $title; ?></h3>
                    <?php endif; ?>

                    <?php                                                
                        if( $link ): 
                            $link_url = $link['url'];
                            $link_title = $link['title'];
                            $link_target = $link['target'] ? $link['target'] : '_self';
                            ?>
                    <a class="btn--main" href="<?php echo esc_url( $link_url ); ?>"
                        target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                    <?php endif; ?>
                </figcaption>
            </figure>
            <?php endwhile; ?>
        </div>
        <div class="swiper-button-next js-next"></div>
        <div class="swiper-button-prev js-prev"></div>
        <div class="swiper-pagination js-pagination"></div>
        <?php endif; ?>
        <!-- If we need scrollbar -->
    </div>
</section>