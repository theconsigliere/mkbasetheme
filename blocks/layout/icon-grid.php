<?php

/**
 * Icon Grid
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'IconGrid-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'IconGrid';

if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }

// Load values and assign defaults.
$title = get_field('title');
$anchor = get_field('html_anchor');
?>

<section id="<?php echo esc_attr($id); ?>" class='<?php echo esc_attr($className); ?> full-width-section'>
    <div class="container InfoGrid__inner" id="<?php echo sanitize_title($anchor); ?>">

        <?php if($title): ?>
        <h3 class="IconGrid__title"><?php echo $title; ?></h3>
        <?php endif; ?>

        <?php if (have_rows('add_an_icon')) : ?>
        <div class="IconGrid__item-group">
            <?php while (have_rows('add_an_icon')) : the_row(); 
                    $icon = get_sub_field('icon');
                    $iconTitle = get_sub_field('icon_title');
                    $iconDesc = get_sub_field('icon_description');
                ?>

            <div class="IconGrid__item">
                <?php if($icon): ?>
                <div class="IconGrid__item-icon">
                    <?php echo $icon; ?>
                </div>
                <?php endif; ?>

                <?php if($iconTitle): ?>
                <h5 class="IconGrid__item-title">
                    <?php echo $iconTitle; ?>
                </h5>
                <?php endif; ?>

                <?php if($iconDesc): ?>
                <p class="IconGrid__item-desc">
                    <?php echo $iconDesc; ?>
                </p>
                <?php endif; ?>
            </div>

            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
</section>