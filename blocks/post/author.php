<?php

/**
 *  Author
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'Author-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'Author';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.

$image = get_field('author_image');
$name = get_field('author_name');
$date = get_field('author_date');
$terms = get_field('author_category');
$anchor = get_field('html_anchor');
?>


<section class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>">
    <div class="container Author__inner" id="<?php echo sanitize_title($anchor); ?>">

        <div class="Author__section">
            <?php if ($image): ?>
            <div class="Author__image">
                <?php echo wp_get_attachment_image($image, 'full', '', array('loading' => 'lazy')); ?>
            </div>
            <?php endif; ?>

            <?php if ($name): ?>
            <div class="Author__desc">
                <p class='Author__written-by'><?php echo esc_html( 'Written By' ); ?></p>
                <h4 class='Author__name'><?php echo $name; ?></h4>
                <?php if ($date): ?>
                <h6 class='Author__date'><?php echo $date; ?></h6>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <?php if( $terms ): ?>
        <div class="Author__categories">
            <?php foreach( $terms as $term ): ?>
            <a class='btn--main'
                href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>