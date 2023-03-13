<?php

/**
 *  Hero Full-Width
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'HeroFullWidth-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'HeroFullWidth';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }

// Load values and assign defaults.
$heroimage = get_field('hero_image') ?: '275';
$position = get_field('text_position');
$textColour = get_field('select_text_colour');
$title = get_field('hero_title');
$subtitle = get_field('hero_sub_title');
$desc = get_field('hero_desc');
$button = get_field('hero_button');
?>

<div class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>" data-header-state="reverse"
    data-hero='<?php echo esc_attr($className); ?>'>
    <?php 

    if (!empty($heroimage)) : ?>
    <?php echo wp_get_attachment_image( $heroimage, 'full', '', array('loading' => 'lazy', 'class' => 'HeroFullWidth__image js-image')); ?>
    <?php endif; ?>


    <div class="HeroFullWidth__text-group HeroFullWidth__text-group--<?php echo $position; ?>">
        <?php if ( $title ): ?>
        <h1 class='HeroFullWidth__title js-title <?php if ($textColour === 'white'){ ?> white <?php } ?>'>
            <?php echo $title; ?></h1>
        <?php endif; ?>

        <?php if ( $subtitle ): ?>
        <h4 class='HeroFullWidth__subtitle js-subtitle <?php if ($textColour === 'white'){ ?> white <?php } ?>'>
            <?php echo $subtitle; ?></h4>
        <?php endif; ?>

        <?php if ( $desc ) : ?>
        <p class='HeroFullWidth__desc js-desc <?php if ($textColour === 'white'){ ?> white <?php } ?>'>
            <?php echo $desc; ?></p>
        <?php endif; ?>


        <?php 
        if( $button ): 
            $button_url = $button['url'];
            $button_title = $button['title'];
            $button_target = $button['target'] ? $button['target'] : '_self';
            ?>
        <a class="btn--gradient js-btn" href="<?php echo esc_url( $button_url ); ?>"
            target="<?php echo esc_attr( $button_target ); ?>">
            <span class="btn--gradient__text">
                <?php echo esc_html( $button_title ); ?>
            </span>
        </a>
        <?php endif; ?>
    </div>

</div>