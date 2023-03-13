<?php

/**
 *  Gallery Section
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'Gallery-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'Gallery';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }


// Block preview

$title = get_field('gallery_title');
$images = get_field('gallery');
$anchor = get_field('html_anchor');

?>

<section class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>"
    data-block="<?php echo esc_attr($className); ?>">
    <div class="Gallery__inner" id="<?php echo sanitize_title($anchor); ?>">
        <div class="container">
            <?php if ($title) : ?>
            <h3 class="Gallery__title">
                <?php echo $title; ?></h3>
            <?php endif; ?>
            <?php if (have_rows('add_gallery')) : ?>
            <div class="Gallery__items js-gallery">
                <?php while (have_rows('add_gallery')) : the_row(); ?>
                <div class="Gallery__item js-image">
                    <?php echo wp_get_attachment_image( get_sub_field('image_item'), 'full', "", array( "title" => get_sub_field('image_title'), 'data-description' => get_sub_field('image_description'), 'loading' => 'lazy'));   ?>
                </div>
                <?php endwhile; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="Gallery__modal js-modal">

        <div class="Gallery__modal-inner">
            <figure class="Gallery__figure">
                <img class="Gallery__modal-image js-modal-image" src="" alt="<?php the_title(); ?>" />
                <figcaption class="Gallery__figcaption">
                    <h4 class='js-modal-title white'></h4>
                    <p class='js-modal-desc white Gallery__modal-desc'></p>
                </figcaption>
            </figure>
        </div>

        <div class="Gallery__button-group js-button-group">
            <button aria-label="Previous Photo" class="Gallery__button Gallery__button--prev js-prev">
                <?php echo load_inline_svg('arrow-up.svg'); ?>
            </button>
            <button class="Gallery__button Gallery__button--close js-close">
                <?php echo load_inline_svg('close.svg'); ?>
            </button>
            <button class="Gallery__button Gallery__button--next js-next" aria-label="Next Photo">
                <?php echo load_inline_svg('arrow-up.svg'); ?>
            </button>
        </div>
    </div>
</section>