<?php 
    $logo = get_sub_field('logo');
    $select = get_sub_field('show_socials');
    $showSearch = get_field('show_search', 'option');
    
    // MEGA MENU
    // How it Works

    // Header bar includes logo & all menu-items
    // master header includes all mega menu drop downs
    // if menu item has an associated dropdown we pair the menu item 
    // with the dropdown using the data-menu attribute
?>

<div class='MegaMenu' itemscope itemtype="https://schema.org/Organization" data-header="MegaMenu">

    <?php if ($logo): ?>
    <div class="MegaMenu__logo-group" itemprop="logo">
        <a class="MegaMenu__logo" href="<?php echo home_url(); ?>" itemprop="url" title="<?php bloginfo('name'); ?>">
            <?php echo wp_get_attachment_image($logo, 'full', "", array( "alt" => "Site Logo", "itemprop" => "logo", "id" => "logo" )); ?>
        </a>
    </div>
    <?php endif; ?>

    <div class="MegaMenu__navigation">
        <?php // Menu Repeater ?>
        <?php if( have_rows('menu')):  $counter = 0; ?>
        <nav class="MegaMenu__nav-group HeaderMenu">
            <?php while( have_rows('menu') ) : the_row(); 
                
            $link = get_sub_field('menu_item');
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';

            // create handelization
            $data_menu = sanitize_title($link_title);

            $children = get_sub_field('has_children'); ?>

            <?php if ($children === 'yes'): ?>
            <button class="MegaMenu__menu-item HeaderMenu__item HeaderMenu__item-has-children">
                <div class="MegaMenu__item-has-children--inner" data-menu="<?php echo $data_menu . '-' . $counter; ?>">
                    <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"
                        class="MegaMenu__has-children-link HeaderMenu__link"><?php echo esc_html( $link_title ); ?>
                    </a>
                    <span class="HeaderMenu__item--toggle js-dropdown">
                        <?php echo load_inline_svg('menu-arrow.svg'); ?>
                    </span>
                </div>

            </button>

            <?php else: ?>
            <div class="MegaMenu__menu-item HeaderMenu__item HeaderMenu__item-no-children">
                <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"
                    class="MegaMenu__link HeaderMenu__link"><?php echo esc_html( $link_title ); ?></a>
            </div>

            <?php endif; ?>

            <?php 
            $counter++;
            endwhile; ?>
        </nav>
        <?php endif; ?>
        <?php // End of Menu Repeater ?>

    </div>

    <?php // SEARCH ICON 
        if( $showSearch === 'show') : 
            $searchLink = get_field('search_link', 'option');
            ?>
    <a class="MegaMenu__Search" href="<?php echo esc_url( $searchLink ); ?>">
        <i class="fa fa-search"></i>
    </a>
    <?php endif; ?>


    <?php if ($select === 'yes'): ?>
    <div class="MegaMenu__socials">
        <?php // SOCIALS
         get_template_part( 'page-components/theme-settings/socials' ); ?>
    </div>
    <?php endif; ?>

    <div class="MegaMenu__toggle">
        <?php // MENU TOGGLE
        get_template_part('page-components/header/menu', 'toggle'); ?>
    </div>

    <?php // MOBILE MENU
     get_template_part('page-components/header/mobile', 'menu'); ?>
</div>

<?php // HEADER DROPDOWNS ?>

<?php if (have_rows('menu')) : $counter = 0;?>
<section class="MegaMenu__MasterTab js-master-tab">
    <?php while (have_rows('menu')) : the_row();
        $link = get_sub_field('menu_item');
        $link_url = $link['url'];
        $link_title = $link['title'];
        $link_target = $link['target'] ? $link['target'] : '_self';

        // create handelization
        $data_menu = sanitize_title($link_title);

        $children = get_sub_field('has_children'); ?>

    <?php if ($children === 'yes'): ?>
    <div class="MegaMenu__tab js-tab" data-menu="<?php echo $data_menu . '-' . $counter; ?>">
        <?php if (have_rows('mega_menu_dropdown')) : ?>
        <div class="MegaMenu__tab--inner">
            <?php while (have_rows('mega_menu_dropdown')) : the_row(); 
            
            $image = get_sub_field('mega_menu_image');
            $link = get_sub_field('mega_menu_image_link');

            if($link):
                $link_url = $link['url'];
                $link_title = $link['title'];
                $link_target = $link['target'] ? $link['target'] : '_self';
            endif;
            ?>

            <?php // image & link ?>
            <?php if ($image): ?>
            <div class="MegaMenu__image">
                <?php echo wp_get_attachment_image( $image , array('450', '450')); ?>

                <?php if ($link): ?>
                <div class="MegaMenu__image-link-group">
                    <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"
                        class="MegaMenu__image-link"><?php echo esc_html( $link_title ); ?></a>
                </div>
                <?php endif; ?>

            </div>

            <?php endif; ?>

            <?php // flexible content: columns ?>
            <?php if (have_rows('mega_menu_columns')) : ?>
            <?php while (have_rows('mega_menu_columns')) : the_row(); 
            
                // column
                if (get_row_layout() == 'column'): 
                $title = get_sub_field('column_title'); 
                ?>
            <div class="MegaMenu__column">
                <div class="MegaMenu__column--inner">

                    <?php if ($title): ?>
                    <h4 class="MegaMenu__column-title"><?php echo $title; ?></h4>
                    <?php if (have_rows('menu')) : ?>
                    <ul class="MegaMenu__column-menu">
                        <?php while (have_rows('menu')) : the_row(); 
                    $link = get_sub_field('menu_item');
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self'; ?>

                        <?php if ($link): ?>
                        <li class="MegaMenu__column-item">
                            <a href="<?php echo esc_url( $link_url ); ?>"
                                target="<?php echo esc_attr( $link_target ); ?>"
                                class="MegaMenu__column-menu-link"><?php echo esc_html( $link_title ); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>



            <?php endif; ?>
            <?php endwhile; ?>
            <?php endif; ?>



            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>


    <?php 
$counter++;
 endwhile; ?>
</section>
<?php endif; ?>