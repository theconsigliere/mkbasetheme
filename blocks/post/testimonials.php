<?php

/**
 *  Testimonials
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'Testimonials-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'Testimonials';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }


// Load values and assign defaults.
$title = get_field('title') ?: 'Enter your title';
$number = get_field('how_many_testimonials_do_you_want');
$button = get_field('button');
$anchor = get_field('html_anchor');
$speed = get_field('slideshow_speed');

?>

<section class='<?php echo esc_attr($className); ?>' id="<?php echo esc_attr($id); ?>"
    data-block="<?php echo esc_attr($className); ?>" data-duration="<?php echo $speed; ?>">

    <div class="Testimonials__inner container" id="<?php echo sanitize_title($anchor); ?>">

        <?php if($title): ?>
        <h2 class="Testimonials__title"><?php echo $title; ?></h2>
        <?php endif; ?>



        <?php 
            $args = array(  
                'post_type' => 'testimonials',
                'posts_per_page' => $number, 
            );

            $loop = new WP_Query( $args ); ?>

        <?php if ($loop): ?>
        <div class="testimonial__container swiper js-container">
            <div class="testimonial__wrapper swiper-wrapper">
                <?php while ( $loop->have_posts() ) : $loop->the_post();                            
                        // Load values and assign defaults.
                        $post_id = get_the_ID();
                        $star = get_field('star_rating', $post_id);
                        $jobTitle = get_field('job_title', $post_id);
                        $quote = get_field('quote', $post_id);
                        $name = get_field('name', $post_id);
                        $company = get_field('company', $post_id); 
                    ?>

                <div class="Testimonial__slide swiper-slide js-slide">
                    <div class="Testimonial__slide--inner">
                        <?php if ($star) : ?>
                        <div class="Testimonial__slide-rating"><?php echo $star; ?></div>
                        <?php endif; ?>
                        <?php if ($quote) : ?>
                        <div class="Testimonial__slide__quote-group">
                            <div class="Testimonial__slide-quote Testimonial__slide-quote--left">
                                <?php echo load_inline_svg('quote.svg'); ?>
                            </div>
                            <div class="Testimonial__slide-quote Testimonial__slide-quote--right">
                                <?php echo load_inline_svg('quote.svg'); ?>
                            </div>
                            <h5 class='Testimonial__slide-quote__title'><?php echo $quote; ?></h5>
                        </div>
                        <?php endif; ?>
                        <?php if ($name) : ?>
                        <p class="Testimonial__slide-name"><?php echo $name; ?></p>
                        <?php endif; ?>
                        <?php if ($jobTitle) : ?>
                        <p class="Testimonial__slide-job"><?php echo $jobTitle; ?></p>
                        <?php endif; ?>
                        <?php if ($company) : ?>
                        <p class="Testimonial__slide-company"><?php echo $company; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

            <div class="Testimonials__pagination swiper-pagination js-pagination"></div>
            <!-- If we need navigation buttons -->
            <div class="swiper-buttons Testimonials__buttons">
                <div class="Testimonials__selector Testimonials__selector--prev js-prev">
                    <?php echo load_inline_svg('down-arrow.svg'); ?>
                </div>
                <div class="Testimonials__selector Testimonials__selector--next js-next">
                    <?php echo load_inline_svg('down-arrow.svg'); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>


        <?php  if( $button ): 
                $button_url = $button['url'];
                $button_title = $button['title'];
                $button_target = $button['target'] ? $button['target'] : '_self';
                ?>
        <a class="btn--main Testimonials__btn" href="<?php echo esc_url( $button_url ); ?>"
            target="<?php echo esc_attr( $button_target ); ?>"><?php echo esc_html( $button_title ); ?></a>
        <?php endif; ?>

    </div>
</section>