<?php if( have_rows('footer_notices', 'option') ): ?>
<div class="footer__notice--inner">
    <?php while ( have_rows('footer_notices', 'option') ) : the_row(); ?>

    <?php // FLEXIBLE CONTENT IN COLUMNS ?>
    <?php if (have_rows('footer_notice_item')) : 
        while (have_rows('footer_notice_item')) : the_row();

        // Footer Menu
        if (get_row_layout() == 'title_desc') : 
            $title = get_sub_field('title');
            $desc = get_sub_field('desc');
            $link = get_sub_field('button');
            $color = get_sub_field('text_colour');
        ?>

    <div class="footer__notice-item">
        <?php if ($title) : ?>
        <h5 class="footer__notice-title" style="color:<?php echo $color; ?>"><?php echo $title; ?></h5>
        <?php endif; ?>

        <?php if ($desc) : ?>
        <p class="footer__notice-desc" style="color:<?php echo $color; ?>"><?php echo $desc; ?></p>
        <?php endif; ?>

        <?php
            if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
        ?>

        <a class='btn--main' href="<?php echo esc_url( $link_url ); ?>"
            target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
        <?php endif; ?>
    </div>

    <?php  // Footer Connect
        elseif (get_row_layout() == 'social_connect') : 
            $title = get_sub_field('title');
            $desc = get_sub_field('description');
            $link = get_sub_field('button');
            $socials = get_sub_field('show_socials');
            $color = get_sub_field('text_colour');
        ?>

    <div class="footer__notice-item FooterConnect">


        <?php if ($title) : ?>
        <h3 class="FooterConnect__title" style="color:<?php echo $color; ?>"><?php echo $title; ?></h3>
        <?php endif; ?>

        <?php if ($desc) : ?>
        <p class="FooterConnect__desc" style="color:<?php echo $color; ?>"><?php echo $desc; ?></p>
        <?php endif; ?>


        <?php if ($socials === 'show'): ?>
        <div class="FooterConnect__socials">
            <?php // SOCIALS
             get_template_part( 'page-components/theme-settings/socials' ); ?>
        </div>
        <?php endif; ?>

        <?php
            if( $link ): 
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
        ?>

        <a class='btn--main' href="<?php echo esc_url( $link_url ); ?>"
            target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
        <?php endif; ?>
    </div>

    <?php endif;
        
       endwhile; // close the loop of flexible content

   endif; ?>

    <?php endwhile; ?>
</div>
<?php endif; ?>
