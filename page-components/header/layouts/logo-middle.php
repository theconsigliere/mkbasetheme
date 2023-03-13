<?php 
$logo = get_sub_field('logo');
$button = get_sub_field('button');
$select = get_sub_field('show_socials');
$showSearch = get_field('show_search', 'option');
?>

<div class="LogoMiddle" itemscope itemtype="https://schema.org/Organization" data-header="LogoMiddle">

    <div class="LogoMiddle__left">
        <?php // MENU TOGGLE
        get_template_part('page-components/header/menu', 'toggle'); ?>
    </div>

    <?php if ($logo): ?>
    <div class="LogoMiddle__middle" itemprop="logo">
        <a class="LogoMiddle__logo" href="<?php echo home_url(); ?>" itemprop="url" title="<?php bloginfo('name'); ?>">
            <?php echo wp_get_attachment_image($logo, 'full', "", array( "alt" => "Site Logo", "itemprop" => "logo", "id" => "logo" )); ?>
        </a>
    </div>
    <?php endif; ?>


    <div class="LogoMiddle__right">
        <?php // SEARCH ICON 
        if( $showSearch === 'show') : 
            $link = get_field('search_link', 'option');
        ?>
        <a class="LogoMiddle__Search" href="<?php echo esc_url( $link ); ?>">
            <i class="fa fa-search"></i>
        </a>
        <?php endif; ?>

        <?php if ($button): 

            $button_url = $button['url'];
            $button_title = $button['title'];
            $button_target = $button['target'] ? $button['target'] : '_self';
            ?>
        <a class='LogoMiddle__btn btn--block' href="<?php echo esc_url( $button_url ); ?>"
            target="<?php echo esc_attr( $button_target ); ?>"><?php echo esc_html( $button_title ); ?></a>

        <?php else: ?>

        <a class='LogoMiddle__btn btn--block' href="/contact" target="self"><?php echo esc_html( 'Contact' ); ?></a>

        <?php endif; ?>


    </div>
</div>


<div class="LogoMiddle__Fullscreen fullscreen-nav-js">
    <div class="LogoMiddle__Fullscreen__inner">

        <div class="LogoMiddle__nav-group">
            <?php // Menu Repeater ?>
            <?php if( have_rows('menu')): ?>
            <nav class="LogoMiddle__nav">
                <?php while( have_rows('menu') ) : the_row(); 
                
            $link = get_sub_field('menu_item');
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';

            $children = get_sub_field('has_children'); ?>

                <?php if ($children === 'yes'): ?>
                <button class="LogoMiddle__menu-item LogoMiddle__menu-item-has-children">
                    <div class="LogoMiddle__menu-item--mask">
                        <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"
                            class="LogoMiddle__link js-menu-item"><?php echo esc_html( $link_title ); ?>
                        </a>
                        <span class="LogoMiddle__item--toggle js-dropdown">
                            <?php echo load_inline_svg('menu-arrow.svg'); ?>
                        </span>
                    </div>


                    <?php // Sub menu
                if( have_rows('sub_menu')): ?>
                    <div class="LogoMiddle__SubMenu js-submenu">
                        <div class="LogoMiddle__SubMenu--inner js-inner">
                            <?php while( have_rows('sub_menu') ) : the_row();             
                        $link = get_sub_field('sub_menu_item');
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>

                            <a href="<?php echo esc_url( $link_url ); ?>"
                                target="<?php echo esc_attr( $link_target ); ?>"
                                class="LogoMiddle__SubMenu-link js-sub-link"><?php echo esc_html( $link_title ); ?>
                            </a>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </button>

                <?php else: ?>
                <div class="LogoMiddle__menu-item HeaderMenu__item-no-children">
                    <div class="LogoMiddle__menu-item--mask">
                        <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"
                            class="LogoMiddle__link js-menu-item"><?php echo esc_html( $link_title ); ?></a>
                    </div>
                </div>

                <?php endif; ?>

                <?php endwhile; ?>
            </nav>
            <?php endif; ?>
            <?php // End of Menu Repeater ?>
        </div>

        <?php if ($select === 'yes'): ?>
        <div class="LogoMiddle__socials">
            <?php // SOCIALS
         get_template_part( 'page-components/theme-settings/socials' ); ?>
        </div>
        <?php endif; ?>

    </div>
</div>