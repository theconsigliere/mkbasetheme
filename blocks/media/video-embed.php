<?php

/**
 *  Video Section
 * 
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'VideoEmbed-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'VideoEmbed';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}


$iframe = get_field('video_link');
$anchor = get_field('html_anchor');

?>

<section class='<?php echo esc_attr($className); ?>' id="<?php echo esc_attr($id); ?>">
    <div class="container VideoEmbed__inner" id="<?php echo sanitize_title($anchor); ?>">
        <?php
        // Use preg_match to find iframe src.
        preg_match('/src="(.+?)"/', $iframe, $matches);
        $src = $matches[1];

        // Add extra parameters to src and replcae HTML.
        $params = array(
            'controls'  => 1,
            'hd'        => 1
        );
        $new_src = add_query_arg($params, $src);
        $iframe = str_replace($src, $new_src, $iframe);

        // Add extra attributes to iframe HTML.
        $attributes = 'frameborder="0"';
        $iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);

        // Display customized HTML.
        echo $iframe;
        ?>
    </div>
</section>