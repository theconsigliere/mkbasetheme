<?php 
$select = get_sub_field('select_menu');
$socials = get_sub_field('show_socials');
$showSearch = get_field('show_search', 'option');
?>


<aside class="MobileMenu js-mobile-menu">
    <div class="MobileMenu__inner">
        <div class="MobileMenu__inner-top">


            <?php if ($select === 'yes'): 
        // with logo-left layout selected show desktop menu    
        ?>

            <?php // Menu Repeater ?>
            <?php if( have_rows('menu')): ?>
            <nav class="MobileMenu__nav-group">
                <?php while( have_rows('menu') ) : the_row(); 
                
            $link = get_sub_field('menu_item');
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';

            $children = get_sub_field('has_children'); ?>

                <?php if ($children === 'yes'): ?>
                <button class="MobileMenu__menu-item MobileMenu__item-has-children">
                    <div class="MobileMenu__item-has-children--inner">
                        <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"
                            class="MobileMenu__has-children-link">
                            <?php echo esc_html( $link_title ); ?>
                        </a>
                        <span class="MobileMenu__item--toggle js-mobile-dropdown">
                            <?php echo load_inline_svg('menu-arrow.svg'); ?>
                        </span>
                    </div>


                    <?php // Sub menu
                if( have_rows('sub_menu')): ?>
                    <div class="MobileMenu__SubMenu js-mobile-submenu">
                        <div class="MobileMenu__SubMenu--inner js-mobile-inner">
                            <?php while( have_rows('sub_menu') ) : the_row();             
                        $link = get_sub_field('sub_menu_item');
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>

                            <a href="<?php echo esc_url( $link_url ); ?>"
                                target="<?php echo esc_attr( $link_target ); ?>"
                                class="MobileMenu__link SubMenuMobile__link"><?php echo esc_html( $link_title ); ?>
                            </a>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </button>

                <?php else: ?>
                <div class="MobileMenu__menu-item MobileMenu__item-no-children">
                    <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"
                        class="MobileMenu__link"><?php echo esc_html( $link_title ); ?></a>
                </div>

                <?php endif; ?>

                <?php endwhile; ?>
            </nav>
            <?php endif; ?>
            <?php // End of Menu Repeater ?>


            <?php elseif($select === 'no' || get_row_layout() == 'mega_menu' ) : 
        // with logo-left layout selected show mobile menu 
        // or you have mega menu selected   
        ?>

            <?php // Menu Repeater ?>
            <?php if( have_rows('mobile_menu')): ?>
            <nav class="MobileMenu__nav-group">
                <?php while( have_rows('mobile_menu') ) : the_row(); 
                
                    $link = get_sub_field('menu_item');
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';

                    $children = get_sub_field('has_children'); ?>

                <?php if ($children === 'yes'): ?>
                <button class="MobileMenu__menu-item MobileMenu__item-has-children">
                    <div class="MobileMenu__item-has-children--inner">
                        <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"
                            class="MobileMenu__has-children-link">
                            <?php echo esc_html( $link_title ); ?>
                        </a>
                        <span class="MobileMenu__item--toggle js-mobile-dropdown">
                            <?php echo load_inline_svg('menu-arrow.svg'); ?>
                        </span>
                    </div>


                    <?php // Sub menu
                if( have_rows('sub_menu')): ?>
                    <div class="MobileMenu__SubMenu js-mobile-submenu">
                        <div class="MobileMenu__SubMenu--inner js-mobile-inner">
                            <?php while( have_rows('sub_menu') ) : the_row();             
                        $link = get_sub_field('sub_menu_item');
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>

                            <a href="<?php echo esc_url( $link_url ); ?>"
                                target="<?php echo esc_attr( $link_target ); ?>"
                                class="MobileMenu__link SubMenuMobile__link"><?php echo esc_html( $link_title ); ?>
                            </a>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </button>

                <?php else: ?>
                <div class="MobileMenu__menu-item MobileMenu__item-no-children">
                    <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"
                        class="MobileMenu__link"><?php echo esc_html( $link_title ); ?></a>
                </div>

                <?php endif; ?>

                <?php endwhile; ?>
            </nav>
            <?php endif; ?>
            <?php // End of Menu Repeater ?>


            <?php else: 
                // with header default show default menu 
            ?>
            <nav class="nav" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement"
                aria-label="<?php _e('Primary Menu ', 'dmtheme'); ?>">
                <?php // added primary menu marker for accessibility ?>
                <h2 class="screen-reader-text"><?php _e('Primary Menu', 'dmtheme'); ?></h2>
                <?php // see all default args here: https://developer.wordpress.org/reference/functions/wp_nav_menu/ ?>
                <?php wp_nav_menu(
                array(
                    'container' => '',                         // remove nav container 
                    'menu' => __('The Main Menu', 'dmtheme'),  // nav name
                    'menu_class' => 'MobileMenu__nav-menu', // adding custom nav class
                    'theme_location' => 'main-nav',            // where it's located in the theme
                    'depth'         => 1,
                )
            ); ?>
            </nav>

            <?php endif; ?>

        </div>

        <div class="MobileMenu__inner-bottom">
            <?php // SEARCH ICON 
        if( $showSearch === 'show') :
            $searchLink = get_field('search_link', 'option');
            ?>
            <div class="MobileMenu__Search">
                <a class="MobileMenu__Search-link" href="<?php echo esc_url( $searchLink ); ?>"><i
                        class="fa fa-search"></i>
                    <?php echo esc_html('Search...'); ?></a>
            </div>
            <?php endif; ?>



            <?php if ($socials === 'yes'): ?>
            <div class="MobileMenu__socials">
                <?php // SOCIALS
                 get_template_part( 'page-components/theme-settings/socials' ); ?>
            </div>

            <?php endif; ?>

        </div>
    </div>
</aside>