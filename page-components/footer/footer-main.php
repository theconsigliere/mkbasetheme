<div class="footer__main">

    <?php if( have_rows('footer_columns', 'option') ): ?>
    <div class="footer__main--inner">
        <?php while ( have_rows('footer_columns', 'option') ) : the_row(); ?>

        <div class="footer__column">
            <div class="footer__column--inner">
                <?php if (have_rows('footer_components')) : while (have_rows('footer_components')) : the_row();

                // Footer Menu
                if (get_row_layout() == 'footer_menu') : 
                $menuTitle = get_sub_field('menu_title');
                $menu = get_sub_field('menu');
                
                ?>

                <div class="footer__menu-group">
                    <?php if ($menuTitle) : ?>
                    <h5 class="footer__menu-title"><?php echo $menuTitle; ?></h5>
                    <?php endif; ?>

                    <?php // Sub menu
                    if( have_rows('footer_menu')): ?>
                    <div class="footer__menu">
                        <div class="footer__menu--inner">
                            <?php while( have_rows('footer_menu') ) : the_row();             
                            $link = get_sub_field('footer_menu_item');
                            $link_url = $link['url'];
                            $link_title = $link['title'];
                            $link_target = $link['target'] ? $link['target'] : '_self';
                        ?>

                            <a href="<?php echo esc_url( $link_url ); ?>"
                                target="<?php echo esc_attr( $link_target ); ?>"
                                class="footer__menu-link"><?php echo esc_html( $link_title ); ?>
                            </a>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>

                <?php //  Footer Socials
                
                elseif (get_row_layout() == 'footer_socials') : 
                    $socials = get_sub_field('show_socials');
                ?>

                <?php if ($socials === 'yes'): ?>
                <div class="Footer__socials">
                    <?php // SOCIALS
                        get_template_part( 'page-components/theme-settings/socials' ); ?>
                </div>
                <?php endif; ?>

                <?php //  Footer Logos
                  elseif (get_row_layout() == 'footer_logo') : 
                     $logo = get_sub_field('logo');
                  ?>

                <a href="<?php echo home_url(); ?>" itemprop="url" title="<?php bloginfo('name'); ?>">
                    <?php echo wp_get_attachment_image($logo, 'full', "", array( "alt" => "Site Logo", "itemprop" => "logo", "class" => "footer__logo" )); ?>
                </a>


                <?php //  Footer Contact
                 elseif (get_row_layout() == 'footer_contact_details') : 
                    $title = get_sub_field('details_title');
                 ?>

                <div class="footer__contact">

                    <?php if ($title) : ?>
                    <h5 class='footer__contact-title'><?php echo $title; ?></h5>
                    <?php endif; ?>

                    <?php get_template_part('page-components/footer/footer', 'contact-details'); ?>
                </div>

                <?php endif;
            
                        endwhile; // close the loop of flexible content

                    endif; ?>

            </div>
        </div>

        <?php endwhile; ?>
    </div>
    <?php endif; ?>
</div>