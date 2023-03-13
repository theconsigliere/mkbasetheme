<?php 
$logo = get_sub_field('logo');
$select = get_sub_field('show_socials');
$showSearch = get_field('show_search', 'option');
$searchLink = get_field('search_link', 'option');
?>

<div class="LogoLeft" itemscope itemtype="https://schema.org/Organization" data-header="LogoLeft">

    <?php if ($logo): ?>
    <div class="LogoLeft__logo-group" itemprop="logo">
        <a class="LogoLeft__logo" href="<?php echo home_url(); ?>" itemprop="url" title="<?php bloginfo('name'); ?>">
            <?php echo wp_get_attachment_image($logo, 'full', "", array( "alt" => "Site Logo", "itemprop" => "logo", "id" => "logo" )); ?>
        </a>
    </div>
    <?php endif; ?>

    <div class="LogoLeft__navigation">
        <?php // Menu Repeater ?>
        <?php if( have_rows('menu')): ?>
        <nav class="LogoLeft__nav-group HeaderMenu">
            <?php while( have_rows('menu') ) : the_row(); 
                
            $link = get_sub_field('menu_item');
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';

            $children = get_sub_field('has_children'); ?>

            <?php if ($children === 'yes'): ?>
            <button class="LogoLeft__menu-item HeaderMenu__item HeaderMenu__item-has-children">
                <div class="LogoLeft__item-has-children--inner">
                    <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"
                        class="LogoLeft__link HeaderMenu__has-children-link"><?php echo esc_html( $link_title ); ?>
                    </a>
                    <span class="HeaderMenu__item--toggle js-dropdown">
                        <?php echo load_inline_svg('menu-arrow.svg'); ?>
                    </span>
                </div>

                <?php // Sub menu
                if( have_rows('sub_menu')): ?>
                <div class="SubMenu js-submenu">
                    <div class="SubMenu--inner">
                        <?php while( have_rows('sub_menu') ) : the_row();             
                        $link = get_sub_field('sub_menu_item');
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>

                        <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"
                            class="SubMenu__link"><?php echo esc_html( $link_title ); ?>
                        </a>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php endif; ?>
            </button>

            <?php else: ?>
            <div class="LogoLeft__menu-item HeaderMenu__item HeaderMenu__item-no-children">
                <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"
                    class="LogoLeft__link HeaderMenu__link"><?php echo esc_html( $link_title ); ?></a>
            </div>

            <?php endif; ?>

            <?php endwhile; ?>
        </nav>
        <?php endif; ?>
        <?php // End of Menu Repeater ?>


        <?php if ($select === 'yes'): ?>
        <div class="LogoLeft__socials">
            <?php // SOCIALS
         get_template_part( 'page-components/theme-settings/socials' ); ?>
        </div>
        <?php endif; ?>

        <?php // SEARCH ICON 
        if( $showSearch === 'show') :  ?>
        <a class="LogoLeft__Search" href="<?php echo esc_url( $searchLink ); ?>">
            <i class="fa fa-search"></i>
        </a>
        <?php endif; ?>
    </div>

    <div class="LogoLeft__toggle">
        <?php // MENU TOGGLE
        get_template_part('page-components/header/menu', 'toggle'); ?>
    </div>

    <?php // MOBILE MENU
     get_template_part('page-components/header/mobile', 'menu'); ?>
</div>