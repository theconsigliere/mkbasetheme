<?php

/**
 *  Logo Credentials
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'LogoCredentials-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'LogoCredentials';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }

// variables
$anchor = get_field('html_anchor');
$title = get_field('title');
$colour = get_field('background_colour');
?>


<section class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>"
    data-block="<?php echo esc_attr($className); ?>" style='background-color:<?php echo $colour; ?>'>

    <div class="LogoCredentials__inner" itemscope itemtype="https://schema.org/FAQPage"
        id="<?php echo sanitize_title($anchor); ?>">

        <?php if($title): ?>
        <h5 class="LogoCredentials__title"><?php echo $title; ?></h5>
        <?php endif; ?>

        <?php if (have_rows('add_a_logo')) : ?>
        <div class="LogoCredentials__row">
            <?php while (have_rows('add_a_logo')) : the_row(); 
                $logo = get_sub_field('logo');
                ?>

            <?php if (!empty($logo)) : ?>
            <div class="LogoCredentials__logo">
                <?php echo wp_get_attachment_image( $logo, 'full' ,'', array('loading' => 'lazy')); ?>
            </div>
            <?php endif; ?>

            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
</section>