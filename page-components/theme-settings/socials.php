<?php if( have_rows('add_social', 'option') ): ?>

<div class="Socials">

    <?php while( have_rows('add_social', 'option') ): the_row(); ?>

    <?php
$link = get_sub_field('social_link');
$icon = get_sub_field('social_icon');

        if( $link ): 
    $link_url = $link['url'];
    $link_title = $link['title'];
    ?>

    <a href="<?php echo esc_url( $link_url ); ?>" target="new" title="<?php echo esc_html( $link_title ); ?>"
        class="social__link">

        <?php echo $icon; ?>

    </a>

    <?php endif; ?>

    <?php endwhile; ?>

</div>

<?php endif; ?>