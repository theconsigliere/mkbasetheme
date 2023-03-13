<?php

/**
 *  Content Section
 * 
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'ContentSection-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'ContentSection';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }

// Load values and assign defaults.
$content = get_field('content_area');
$anchor = get_field('html_anchor');
$width = get_field('content_width');
?>

<section class='<?php echo esc_attr($className); ?>' id="<?php echo esc_attr($id); ?>">
    <div class="container ContentSection__inner" id="<?php echo sanitize_title($anchor); ?>"
        style='--content-width:<?php echo $width . '%'; ?>'>
        <?php if($content):
            echo $content;
        endif; ?>
    </div>
</section>