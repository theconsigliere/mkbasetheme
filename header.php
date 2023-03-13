<!doctype html>
<html <?php html_schema(); ?> <?php language_attributes(); ?> class="no-js">

<head>
    <?php // Header Variables
        global $template; 
            
     if (is_plugin_active('advanced-custom-fields-pro/acf.php')) {
        $google = get_field('google_analytics', 'option');
        $fb = get_field('facebook_pixel', 'option');
        $dev = get_field('show_dev_tools', 'option');	
        $policy = get_field('activate_cookie_policy', 'option');
        $revealHeader = get_field('reveal_header', 'option'); 	
        $modal = get_field('activate_modal', 'option');	
        $activateCursor = get_field('activate_custom_cursor', 'option');
        $announcementBar = get_field('activate_header_bar', 'option');	
        $preloaderActivated = get_field('loading_activate', 'option');	
        $preloaderHomepage = get_field('show_on_homepage', 'option');	
        $appleTouchIcon  = get_field('apple_touch_icon', 'option');
        $favicon32  = get_field('favicon_32x32', 'option');
        $favicon16  = get_field('favicon_16x16', 'option');
    }
    ?>

    <?php // Analytics login to 'dashboard theme settings > analytics' to change values ?>

    <?php 
    
    if ($google): echo $google;
    endif; 

    if ($fb): echo $fb;
    endif;
   
     ?>

    <?php // See everything you need to know about the <head> here: https://github.com/joshbuchea/HEAD 
    ?>

    <meta charset='<?php bloginfo('charset'); ?>'>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php // favicons (for more: https://realfavicongenerator.net/); ?>

    <?php if ($appleTouchIcon): ?>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $appleTouchIcon; ?>">
    <?php else: ?>
    <link rel="apple-touch-icon" sizes="180x180"
        href="<?php echo get_theme_file_uri(); ?>/library/favicon/apple-touch-icon.png">
    <?php endif; ?>

    <?php if ($favicon32): ?>
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $favicon32; ?>">
    <link rel="shortcut icon" href="<?php echo $favicon32; ?>">
    <?php else: ?>
    <link rel="icon" type="image/png" sizes="32x32"
        href="<?php echo get_theme_file_uri(); ?>/library/favicon/favicon-32x32.png">
    <link rel="shortcut icon" href="<?php echo get_theme_file_uri(); ?>/library/favicon/favicon.ico">
    <?php endif; ?>

    <?php if ($favicon16): ?>
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $favicon16; ?>">
    <?php else: ?>
    <link rel="icon" type="image/png" sizes="16x16"
        href="<?php echo get_theme_file_uri(); ?>/library/favicon/favicon-16x16.png">
    <?php endif; ?>



    <?php // Update these using the favicon folder. ?>

    <link rel="mask-icon" href="<?php echo get_theme_file_uri(); ?>/library/favicon/safari-pinned-tab.svg"
        color="#5bbad5">

    <meta name="msapplication-TileColor" content="#da516c">
    <meta name="msapplication-config" content="<?php echo get_theme_file_uri(); ?>/library/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <?php // updated pingback. Thanks @HardeepAsrani https://github.com/HardeepAsrani  ?>
    <?php if (is_singular() && pings_open(get_queried_object())) : ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php endif; ?>

    <?php
    #twitter cards hack
    if(is_single() || is_page()) {
        $twitter_url    = get_permalink();
        $twitter_site   = get_site_url();
        $twitter_title  = get_the_title();
        $twitter_desc   = get_the_excerpt();
        $twitter_thumb  = get_field('twitter_image', 'option');
        $twitter_name   = str_replace('@', '', get_the_author_meta('twitter'));
        ?>

    <meta name="twitter:card" value="summary" />
    <meta name="twitter:site" content="<?php echo $twitter_site; ?>" />
    <meta name="twitter:creator" content="@dirtymartiniexe" />
    <meta property="og:url" value="<?php echo $twitter_url; ?>" />
    <meta property="og:title" value="<?php echo $twitter_title; ?>" />
    <meta property="og:description" value="<?php echo $twitter_desc; ?>" />
    <?php if ($twitter_thumb): ?>
    <meta name="twitter:image" value="<?php echo $twitter_thumb; ?>" />
    <?php else: ?>
    <meta name="twitter:image" value="<?php echo get_theme_file_uri() . '/library/favicon/favicon-16x16.png'; ?>" />
    <?php endif; ?>
    <?php } ?>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage"
    data-type="<?php echo basename( $template ); ?>">

    <?php // Page Transitions  ?>
    <div class="Header__fader js-header-fader"></div>

    <?php // ENABLE REPARENT ?>
    <div class="header__modalParent js-modal-parent"></div>
    <?php ?>

    <?php // DEV-TOOLS
    if($dev == 'show') {  
        if ( is_user_logged_in() ) : ?>
    <?php get_template_part( 'page-components/theme-settings/devtools' ); ?>
    <?php endif;
    } ?>


    <?php // COOKIE POLICY

    if($policy == 'yes'):  ?>
    <?php get_template_part( 'page-components/theme-settings/cookie-policy' ); ?>
    <?php endif; ?>


    <?php // PRE-LOADER 

    // check the selection
    if($preloaderActivated == 'show') { 
        if($preloaderHomepage == 'show') { ?>

    <?php if ( is_front_page() ) : ?>
    <?php get_template_part( 'page-components/theme-settings/preloader' ); ?>
    <?php endif; ?>

    <?php  } elseif ($preloaderHomepage == 'hide') { ?>
    <?php get_template_part( 'page-components/theme-settings/preloader' ); ?>
    <?php } else { } ?>
    <?php  } ?>


    <?php // ON ARTICLE PAGES
    
    if( is_single()): ?>

    <div class="Article__socials js-article-socials">
        <?php get_template_part( 'page-components/theme-settings/socials' ); ?>
    </div>

    <button class="Article__scroll-button js-article-button">
        <?php echo load_inline_svg('arrow-up.svg'); ?>
    </button>

    <?php endif; ?>

    <?php // ENABLE REVEAL HIDE HEADER ?>

    <header class="header js-header-<?php echo $revealHeader ?>" id="header" role="banner" itemscope
        itemtype="https://schema.org/WPHeader">

        <!-- Search Box -->
        <div id="#box" class="HeaderSearchBox js-search-box">
            <div class="HeaderSearchBox__close js-search-close"></div>
            <div class="HeaderSearchBox__inner">
                <h5 class='HeaderSearchBox__title'><?php echo esc_html('Type to search'); ?></h5>
                <form class="HeaderSearchBox__form">
                    <input type="text" id="js-search-input" class='HeaderSearchBox__input-btn' name="s">
                    <button type="submit" class='HeaderSearchBox__input-btn js-search-submit'>
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        <!-- End Search Box -->

        <?php // ANNOUNCEMENT BAR 
        if( $announcementBar == 'yes') : ?>
        <?php get_template_part( 'page-components/theme-settings/announcement-bar' ); ?>
        <?php endif; ?>

        <?php  // Header Template Loop 
        get_template_part( 'page-components/header/header-components' ); ?>
    </header>

    <?php // check we're on the front page
        if(is_front_page()) {	
            // check the selection
            if($modal == 'show') {
                // get the modal code
                get_template_part( 'page-components/theme-settings/modal' );
            } 
        }
        ?>

    <?php // CURSOR
    // check the selection
    if($activateCursor == 'activate') : ?>
    <?php get_template_part( 'page-components/theme-settings/custom-cursor' ); ?>
    <?php endif; ?>

    <div id="smooth-wrapper">
        <div id="smooth-content">