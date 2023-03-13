<?php

/**
 *  Hero Video
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'HeroVideo-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'HeroVideo';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }



// Load values and assign defaults.
$video = get_field('video') ?: "https://player.vimeo.com/video/340438724";
$overlayColor = get_field('overlay') ?: '#0000001A';
$title = get_field('title');
$position = get_field('text_position');
$select = get_field('image_on_mobile');
$mobileImage = get_field('mobile_image');
$link = get_field('button');
?>


<div class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>">

    <div class="HeroVideo__embed HeroVideo__mobile-image--<?php echo $select; ?>">
        <?php

        // Use preg_match to find iframe src.
        preg_match('/src="(.+?)"/', $video, $matches);
        $src = $matches[1];

        // Add extra parameters to src and replcae HTML.
        $params = array(
            'controls'  => 0,
            'hd'        => 1,
            'autohide'  => 1,
            'autoplay' => 1,
            'loop' => 1,
            // mutes vimeo
            'background' => 1,
            // mutes youtube
            'mute' => 1
        );
        $new_src = add_query_arg($params, $src);
        $video = str_replace($src, $new_src, $video);

        // Add extra attributes to iframe HTML.
        $attributes = 'frameborder="0"';
        $video = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $video);

        // Display customized HTML.
        echo $video;
        ?>
        <div class="HeroVideo__overlay" style="background-color:<?php echo $overlayColor; ?>"></div>
    </div>

    <?php if ($select === 'yes'): ?>
    <?php if( $mobileImage ): ?>
    <div class="HeroVideo__mobile-image">
        <?php echo wp_get_attachment_image( $mobileImage , 'full', '', array('loading' => 'lazy')); ?>
    </div>
    <?php endif; ?>
    <?php endif; ?>

    <div class="HeroVideo__text-group HeroVideo__text-group--<?php echo $position; ?>">
        <div class="HeroVideo__text-inner">
            <?php if ($title) : ?>
            <h1 class="HeroVideo__title"><?php echo $title; ?></h1>
            <?php endif; ?>

            <?php if( have_rows('add_text') ): ?>
            <div class="HeroVideo__desc-group">
                <?php while( have_rows('add_text') ) : the_row();                 
                    $desc = get_sub_field('description'); ?>
                <p class='HeroVideo__desc'><?php echo $desc; ?></p>
                <?php endwhile; ?>
            </div>
            <?php endif;?>

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


</div>