<?php // updated with proper markup and wrapping div for organization 
$showSearch = get_field('show_search', 'option');

?>
<div class="HeaderDefault" itemscope itemtype="https://schema.org/Organization" data-header="default">

    <div class="HeaderDefault__logo-group">
        <?php if (has_custom_logo()): ?>

        <div class="HeaderDefault__logo" itemprop="logo">
            <a href="<?php echo home_url(); ?>" itemprop="url"
                title="<?php bloginfo('name'); ?>"><?php the_custom_logo(); ?></a>
        </div>

        <?php else: ?>

        <div class="HeaderDefault__logo" itemprop="logo">
            <a href="<?php echo home_url(); ?>" itemprop="url" title="<?php bloginfo('name'); ?>">
                <img src="<?php echo get_theme_file_uri(); ?>/build/images/dmbaseicon.svg" itemprop="logo"
                    alt="Website Logo" />
            </a>
        </div>
        <div class="HeaderDefault__site-title" itemprop="name">
            <a href="<?php echo home_url(); ?>" itemprop="url" title="<?php bloginfo('name'); ?>">
                <?php bloginfo('name'); ?>
            </a>
        </div>

        <?php endif; ?>
    </div>

    <div class="HeaderDefault__navigation">
        <nav class="nav" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement"
            aria-label="<?php _e('Primary Menu ', 'dmtheme'); ?>">
            <?php // added primary menu marker for accessibility ?>
            <h2 class="screen-reader-text"><?php _e('Primary Menu', 'dmtheme'); ?></h2>
            <?php // see all default args here: https://developer.wordpress.org/reference/functions/wp_nav_menu/ ?>
            <?php wp_nav_menu(
            array(
                'container' => '',                         // remove nav container 
                'menu' => __('The Main Menu', 'dmtheme'),  // nav name
                'menu_class' => 'HeaderDefault__nav-menu', // adding custom nav class
                'theme_location' => 'main-nav',            // where it's located in the theme
                'depth'         => 1,
            )
        ); ?>
        </nav>
    </div>

    <?php // SEARCH ICON 
        if( $showSearch === 'show') : 
            $searchLink = get_field('search_link', 'option');
            ?>
    <a class="HeaderDefault__Search" href="<?php echo esc_url( $searchLink ); ?>">
        <i class="fa fa-search"></i>
    </a>
    <?php endif; ?>

    <div class="HeaderDefault__toggle">
        <?php // MENU TOGGLE
        get_template_part('page-components/header/menu', 'toggle'); ?>
    </div>

    <?php // MOBILE MENU
     get_template_part('page-components/header/mobile', 'menu'); ?>
</div>