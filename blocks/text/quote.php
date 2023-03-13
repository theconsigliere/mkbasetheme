<?php

/**
 *  Quote
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'Quote-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'Quote';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }


// Load values and assign defaults.
$quote = get_field('quote');
$anchor = get_field('html_anchor');
?>

<section class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>">
    <article class="container" id="<?php echo sanitize_title($anchor); ?>">
        <?php if ($quote): ?>
        <blockquote>
            <h4 class='Quote__title'><?php echo $quote; ?></h4>
        </blockquote>
        <?php endif; ?>
    </article>
</section>