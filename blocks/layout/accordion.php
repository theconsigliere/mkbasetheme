<?php

/**
 *  Accordians
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'Accordion-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'Accordion';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }

// variables
$anchor = get_field('html_anchor');

?>


<section class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>"
    data-block="<?php echo esc_attr($className); ?>">
    <div class="container Accordion__inner" itemscope itemtype="https://schema.org/FAQPage"
        id="<?php echo sanitize_title($anchor); ?>">
        <?php if (have_rows('add_an_accordion')) : ?>
        <div class="Accordion__column">
            <?php while (have_rows('add_an_accordion')) : the_row(); 
                $question = get_sub_field('question');
                $answer = get_sub_field('answer');
                $new_url = sanitize_title($question);
                ?>

            <div class="Accordion__item js-accordion-item" id="<?php echo $new_url; ?>">
                <div class="Accordion__item--inner">
                    <?php if ($question): ?>
                    <h4 class='Accordion__item-title' itemprop="name"><?php echo $question; ?></h4>
                    <?php endif; ?>

                    <?php if ($answer): ?>
                    <div class="Accordion__item-icon js-icon">
                        <span class="Accordion__item-icon--left js-icon-left"></span>
                        <span class="Accordion__item-icon--right js-icon-right"></span>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if ($answer): ?>
                <div class="Accordian__item-desc js-desc" itemprop="acceptedAnswer" itemscope
                    itemtype="http://schema.org/Answer">
                    <p itemprop="text"><?php echo $answer; ?></p>
                </div>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
</section>