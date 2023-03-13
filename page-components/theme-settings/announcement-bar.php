<?php // Announcement variables
       $colour =  get_field('announcement_colour', 'option');
       $textColour =  get_field('announcement_text_colour', 'option');
?>

<div class="AnnouncementBar" style='background-color:<?php echo $colour; ?>'>
    <?php if (have_rows('announcement_content', 'option')) : ?>
    <div class="AnnouncementBar__inner">
        <?php while (have_rows('announcement_content', 'option')) : the_row(); 

                $link = get_sub_field('link');

                if( $link ): 
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    ?>

        <a class="AnnouncementBar__link" href="<?php echo esc_url( $link_url ); ?>" target="new"
            style='color:<?php echo $textColour; ?>'>
            <?php echo esc_html( $link_title ); ?>
        </a>

        <?php endif; ?>

        <?php endwhile; ?>
    </div>
    <?php endif; ?>
</div>