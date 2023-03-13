<?php if( have_rows('details') ): ?>
<div class="footer_contact__group">
    <?php while ( have_rows('details') ) : the_row(); ?>
    <div class="footer__contact-item">

        <?php
            $icon = get_sub_field('contact_icon');
            $link = get_sub_field('contact_link');
            if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
            endif;
        ?>

        <?php if( $link_title ): ?>

        <?php if($icon):?>
        <div class="footer__contact-icon">
            <?php echo $icon; ?>
        </div>
        <?php endif; ?>

        <a class="btn--plain" href="<?php echo esc_url( $link_url ); ?>"
            target="<?php echo esc_attr( $link_target ); ?>" title="Social Link" rel="noopener"
            itemprop="sameAs"><?php echo esc_html( $link_title ); ?></a>

        <?php else: ?>

        <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"
            title="Social Link" rel="noopener" itemprop="sameAs">
            <?php if($icon):?>
            <div class="footer__contact-icon">
                <?php echo $icon; ?>
            </div>
            <?php endif; ?>
        </a>

        <?php endif; ?>

    </div>


    <?php endwhile; ?>

</div>

<?php endif; ?>