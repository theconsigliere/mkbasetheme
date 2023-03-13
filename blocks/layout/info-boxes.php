<?php

/**
 * Info Boxes
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'InfoBoxes-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'InfoBoxes';

if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }

// Load values and assign defaults.
$anchor = get_field('html_anchor');

?>

<section id="<?php echo esc_attr($id); ?>" class='<?php echo esc_attr($className); ?> full-width-section'
    data-block="<?php echo esc_attr($className); ?>">
    <?php if (have_rows('add_info_box')) : $counter = 0; ?>
    <div class="container InfoBoxes__inner" id="<?php echo sanitize_title($anchor); ?>">
        <?php while (have_rows('add_info_box')) : the_row();
        $counter++; 
        $title = get_sub_field('title');
        $desc = get_sub_field('description');
        $button = get_sub_field('button');
        ?>

        <div class="InfoBox">
            <div class="InfoBox__inner">
                <div class='InfoBox__counter stroke stroke--grey'>0<?php echo $counter ?></div>
                <?php if($title): ?>
                <h5 class="InfoBox__title"><?php echo $title; ?></h5>
                <?php endif; ?>

                <?php if($desc): ?>
                <p class="InfoBox__desc"><?php echo $desc; ?></p>
                <?php endif; 

                if( $button ): 
                    $button_url = $button['url'];
                    $button_title = $button['title'];
                    $button_target = $button['target'] ? $button['target'] : '_self';
                    ?>
                <a class="btn--block InfoBox__btn" href="<?php echo esc_url( $button_url ); ?>"
                    target="<?php echo esc_attr( $button_target ); ?>"><?php echo esc_html( $button_title ); ?></a>
                <?php endif; ?>
            </div>
        </div>

        <?php endwhile; ?>
    </div>
    <?php endif; ?>
</section>