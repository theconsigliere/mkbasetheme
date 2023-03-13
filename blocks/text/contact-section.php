<?php

/**
 *  Contact Section
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'ContactSection-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'ContactSection';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$title = get_field('form_title');
$desc = get_field('form_desc');
$ID = get_field('id');
$anchor = get_field('html_anchor');
?>


<section class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>"
    data-block="<?php echo esc_attr($className); ?>">
    <div class="container ContentSection__inner" id="<?php echo sanitize_title($anchor); ?>">
        <div class="ContentSection__item ContentSection__item--left">
            <?php if($title): ?>
            <h2 class="ContentSection__title"><?php echo $title; ?></h2>
            <?php endif; ?>
            <?php if($desc): ?>
            <p class="ContentSection__desc"><?php echo $desc; ?></p>
            <?php endif; ?>
        </div>
        <div class="ContentSection__item ContentSection__item--right">
            <?php
                if($ID):
                    echo do_shortcode($ID);
                endif; ?>
        </div>
    </div>
</section>