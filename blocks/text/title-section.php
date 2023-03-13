<?php

/**
 * Title Section
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'TitleSection-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'TitleSection';

if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }

// Load values and assign defaults.
$title = get_field('title');
$subtitle = get_field('subtitle');
$desc = get_field('description');
$button = get_field('button');
$position = get_field('position');
$style = get_field('button_style');
$anchor = get_field('html_anchor');
?>

<section class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>">
    <div class="container TitleSection__inner TitleSection__inner--<?php echo $position; ?>"
        id="<?php echo sanitize_title($anchor); ?>">

        <?php if($title): ?>
        <h2 class="TitleSection__title"><?php echo $title; ?></h2>
        <?php endif; ?>
        <?php if($subtitle): ?>
        <h4 class="TitleSection__subtitle"><?php echo $subtitle; ?></h4>
        <?php endif; ?>
        <?php if($desc): ?>
        <p class="TitleSection__desc"><?php echo $desc; ?></p>
        <?php endif; ?>

        <?php 
        if( $button ): 
            $button_url = $button['url'];
            $button_title = $button['title'];
            $button_target = $button['target'] ? $button['target'] : '_self';
            ?>
        <a class="TitleSection__btn  btn--<?php echo $style; ?>" href="<?php echo esc_url( $button_url ); ?>"
            target="<?php echo esc_attr( $button_target ); ?>">
            <?php if($style === 'gradient'): ?>
            <span class="btn--gradient__text">
                <?php echo esc_html( $button_title ); ?>
            </span>
            <?php else: ?>
            <?php echo esc_html( $button_title ); ?>
            <?php endif; ?>
        </a>
        <?php endif; ?>
    </div>
</section>