<?php

/**
 *  Card Section
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'CardSection-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'CardSection';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}


// Block preview
if( !empty( $block['data']['is_preview'] ) ) { ?>
<img src="<?php echo get_theme_file_uri(); ?>/blocks/preview/Button.jpg" alt="">
<?php } 

// Load values and assign defaults.
$title = get_field('title');
$anchor = get_field('html_anchor');
?>

<section id="<?php echo esc_attr($id); ?>" class='<?php echo esc_attr($className); ?>'>
    <div class="container CardSection__inner" id="<?php echo sanitize_title($anchor); ?>">

        <?php if ($title): ?>
        <h2 class="CardSection__title"><?php echo $title; ?></h2>
        <?php endif; ?>

        <?php if (have_rows('add_card')) : ?>
        <div class="CardSection__holder">
            <?php while (have_rows('add_card')) : the_row();
            
                $image = get_sub_field('card_image');
                $title = get_sub_field('card_title');
                $desc = get_sub_field('card_desc');
                $button = get_sub_field('card_button');
                ?>

            <article class="CardItem">
                <div class="CardItem__inner">
                    <?php if (!empty($image)) : ?>
                    <div class="CardItem__image">
                        <?php echo wp_get_attachment_image( $image, 'full' ,'', array('loading' => 'lazy')); ?>
                    </div>
                    <?php endif; ?>

                    <?php if ( $title ) : ?>
                    <h4 class="CardItem__title">
                        <?php echo $title; ?></h4>
                    <?php endif; ?>

                    <?php if ( $desc ) : ?>
                    <p class='CardItem__desc'>
                        <?php echo $desc; ?></p>
                    <?php endif; ?>

                    <?php 
                    if( $button ): 
                        $button_url = $button['url'];
                        $button_title = $button['title'];
                        $button_target = $button['target'] ? $button['target'] : '_self';
                        ?>
                    <a class="btn--main CardItem__btn" href="<?php echo esc_url( $button_url ); ?>"
                        target="<?php echo esc_attr( $button_target ); ?>"><?php echo esc_html( $button_title ); ?></a>
                    <?php endif; ?>
                </div>
            </article>

            <?php endwhile; ?>
        </div>
        <?php endif; ?>

    </div>
</section>