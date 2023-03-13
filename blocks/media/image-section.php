<?php

/**
 *  Image Section
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'imageSection-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'ImageSection';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }



// Load values and assign defaults.
$anchor = get_field('html_anchor');

?>

<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <?php if (have_rows( 'image_column' )) : ?>
    <div class="container ImageSection__inner" id="<?php echo sanitize_title($anchor); ?>">
        <?php while (have_rows( 'image_column' )) : the_row(); ?>
        <div class="ImageSection__column">
            <div class="ImageSection__column-inner">
                <?php if (have_rows( 'image_content' )) :   while (have_rows( 'image_content' )) : the_row();

            // Text Section
            if (get_row_layout() == 'text_section' ) : 

                $title = get_sub_field('title');
                $desc = get_sub_field('desc');
                $link = get_sub_field('button');
            ?>

                <div class="ImageSection__text-item">
                    <div class="ImageSection__text-inner">

                        <?php if ($title) : ?>
                        <h3 class="ImageSection__text-title"><?php echo $title; ?></h3>
                        <?php endif; ?>

                        <?php if ( $desc ): ?>
                        <p class='ImageSection__text-desc'><?php echo $desc; ?></p>
                        <?php endif; ?>

                        <?php if( $link ): 
                            $link_url = $link['url'];
                            $link_title = $link['title'];
                            $link_target = $link['target'] ? $link['target'] : '_self'; ?>

                        <a class="btn--main" href="<?php echo esc_url( $link_url ); ?>"
                            target="<?php echo esc_attr( $link_target ); ?>">
                            <?php echo esc_html( $link_title ); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <?php //  Image Section
            elseif (get_row_layout() == 'image_section' ) : 
            
                $image = get_sub_field('image');
                $title = get_sub_field('title');
                $desc = get_sub_field('desc');
            
            ?>

                <div class="ImageSection__image-item">
                    <?php echo wp_get_attachment_image( $image , 'full', '', array('loading' => 'lazy')); ?>

                    <?php if ($title) : ?>
                    <figure class="ImageSection__image-figure">
                        <h6 class="ImageSection__image-title"><?php echo $title; ?></h6>
                        <?php if ($desc) : ?>
                        <p class="ImageSection__image-desc">
                            <?php echo $desc; ?>
                        </p>
                        <?php endif; ?>
                    </figure>
                    <?php endif; ?>
                </div>

                <?php endif; ?>
                <?php endwhile; endif; ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    <?php endif; ?>
</section>