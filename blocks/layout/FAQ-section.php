<?php

/**
 *  FAQ Section
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'FAQSection-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'FAQSection';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$title = get_field('title');
$anchor = get_field('html_anchor');
?>


<section class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>"
    data-block="<?php echo esc_attr($className); ?>">
    <div class="FAQSection__inner" id="<?php echo sanitize_title($anchor); ?>">

        <?php if($title): ?>
        <h2 class="FAQSection__title"><?php echo $title; ?></h2>
        <?php endif; ?>

        <div class="FAQSection__main">
            <?php // FAQ Navigation ?>
            <?php if( have_rows('add_faq_section') ): ?>
            <div class="FAQSection__item FAQSection__item--nav js-nav-group">
                <ul class="FAQSection__nav js-nav">
                    <?php while( have_rows('add_faq_section') ): the_row(); 
                    $title = get_sub_field('section_title'); ?>

                    <?php if($title): ?>
                    <li class="FAQSection__nav-item">
                        <details class='FAQSection__nav-detail js-detail'>
                            <summary class='FAQSection__nav-summary'><?php echo $title; ?></summary>

                            <?php if( have_rows('add_faq_item') ): ?>
                            <div class="FAQSection__sub-nav">

                                <?php while( have_rows('add_faq_item') ): the_row(); 
                                    $question = get_sub_field('question');
                                    ?>

                                <?php if($question): ?>
                                <a class="FAQSection__sub-item js-item"
                                    href="#<?php echo sanitize_title($question); ?>">
                                    <?php echo $question; ?>
                                </a>
                                <?php endif; ?>


                                <?php endwhile; ?>
                            </div>
                            <?php endif; ?>

                        </details>
                    </li>
                    <?php endif; ?>
                    <?php endwhile; ?>
                </ul>
            </div>
            <?php endif; ?>
            <?php // End of FAQ Navigation ?>

            <?php // FAQ Main ?>
            <?php if( have_rows('add_faq_section') ): ?>
            <div class="FAQSection__item FAQSection__item--questions js-question-section" itemscope
                itemtype="https://schema.org/FAQPage">
                <?php while( have_rows('add_faq_section') ): the_row();
                
                      $title = get_sub_field('section_title'); ?>

                <?php if($title): ?>
                <p class="FAQSectionn__section-title"><?php echo $title; ?></p>
                <?php endif; ?>

                <?php if( have_rows('add_faq_item') ): ?>
                <?php while( have_rows('add_faq_item') ): the_row(); 
                    $question = get_sub_field('question');
                    $answer = get_sub_field('answer'); ?>

                <div class="FAQSection__section-item js-section-item" id="<?php echo sanitize_title($question); ?>">
                    <?php if($question): ?>
                    <h4 class="FAQSection__section-question" itemprop="name"><?php echo $question; ?></h4>
                    <?php endif; ?>
                    <?php if($answer): ?>
                    <p class="FAQSection__section-answer" itemprop="acceptedAnswer" itemscope
                        itemtype="http://schema.org/Answer"><?php echo $answer; ?></p>
                    <?php endif; ?>
                </div>

                <?php endwhile; ?>
                <?php endif; ?>

                <?php endwhile; ?>
            </div>
            <?php endif; ?>
            <?php // End of FAQ Main ?>
        </div>
    </div>
</section>