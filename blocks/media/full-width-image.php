<?php

/**
 * Full Width image
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'FullWidthImage-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'FullWidthImage';

if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$image = get_field('image');
$select = get_field('image_size');
$textColour = get_field('text_colour');
$title = get_field('title');
$desc = get_field('description');
$link = get_field('button');
$anchor = get_field('html_anchor');

?>

<section class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>"
    data-block="<?php echo esc_attr($className); ?>">
    <div class="FullWidthImage__inner  FullWidthImage__inner--<?php echo $select; ?>"
        id="<?php echo sanitize_title($anchor); ?>">

        <?php if( $image ): ?>
        <div class='FullWidthImage__parallax-image js-parallax' style="background-image:url('<?php echo $image; ?>');">
        </div>
        <?php endif; ?>

        <div class="FullWidthImage__text-group">

            <?php if ($title) : ?>
            <h3 class="FullWidthImage__title <?php if($textColour === 'white'): ?> white <?php endif; ?>">
                <?php echo $title; ?></h3>
            <?php endif; ?>

            <?php if ($desc) : ?>
            <p class="FullWidthImage__desc <?php if($textColour === 'white'): ?> white <?php endif; ?>">
                <?php echo $desc; ?></p>
            <?php endif; ?>

            <?php if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self'; ?>

            <a class="btn--gradient FullWidthImage__button" href="<?php echo esc_url( $link_url ); ?>"
                target="<?php echo esc_attr( $link_target ); ?>">
                <span class="btn--gradient__text">
                    <?php echo esc_html( $link_title ); ?>
                </span>
            </a>
            <?php endif; ?>
        </div>
    </div>
</section>