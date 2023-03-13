<?php

/**
 *  Pricing Table
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'PricingTable-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'PricingTable';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
// if( !empty($block['align']) ) {
//     $className .= ' align' . $block['align'];
// }

$anchor = get_field('html_anchor');
$table = get_field( 'pricing_table' );

?>


<section class="<?php echo esc_attr($className); ?>" id="<?php echo esc_attr($id); ?>"
    data-block="<?php echo esc_attr($className); ?>">

    <div class="container PricingTable__inner" id="<?php echo sanitize_title($anchor); ?>">
        <?php 
            if ( ! empty ( $table ) ) {
            
                echo '<table border="0">';
            
                    if ( ! empty( $table['caption'] ) ) {
            
                        echo '<caption>' . $table['caption'] . '</caption>';
                    }
            
                    if ( ! empty( $table['header'] ) ) {
            
                        echo '<thead>';
            
                            echo '<tr>';
            
                                foreach ( $table['header'] as $th ) {
            
                                    echo '<th>';
                                        echo $th['c'];
                                    echo '</th>';
                                }
            
                            echo '</tr>';
            
                        echo '</thead>';
                    }
            
                    echo '<tbody>';
            
                        foreach ( $table['body'] as $tr ) {
            
                            echo '<tr>';
            
                                foreach ( $tr as $td ) {
            
                                    echo '<td>';
                                        echo $td['c'];
                                    echo '</td>';
                                }
            
                            echo '</tr>';
                        }
            
                    echo '</tbody>';
            
                echo '</table>';
            }

            ?>
    </div>

</section>