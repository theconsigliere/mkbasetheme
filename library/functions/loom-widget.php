<?php

/**********************************
 * LOOM Widget *
 *********************************/
 // Create the function to output the contents of our Dashboard Widget.
 function dmtheme_loom_widget_init() { ?>

<div class="Dashboard__loomWidget">
    <div class="Dashboard__loomWidget-image">
        <?php      // helper vars for links and images and stuffs.
        $url = get_admin_url();
        $img = get_theme_file_uri() . '/build/images/dmbaseicon.svg'; 

         if (has_custom_logo()): ?>
        <a href="<?php echo home_url(); ?>" itemprop="url" class="dashboard-image"
            title="<?php bloginfo('name'); ?>"><?php the_custom_logo(); ?></a>
        <?php else: ?>

        <a href="<?php echo home_url(); ?>" itemprop="url" class="dashboard-image" title="<?php bloginfo('name'); ?>">
            <img src="<?php echo get_theme_file_uri(); ?>/build/images/dmbaseicon.svg" itemprop="logo"
                alt="Website Logo" width="96" height="96" />
        </a>

        <?php endif; ?>
    </div>
    <div class="Dashboard__loomWidget-text">
        <h3 class="Dashboard__loomWidget-title">
            <strong><?php echo esc_html('Need some support in maintaining and updating your website?'); ?><strong></h3>
        <p><?php echo esc_html('Check out the the links to quick easy to follow videos to show you how to maintain your brand new website.'); ?>
        </p>
    </div>
</div>

<?php } 
 
 function dmtheme_add_dashboard_widgets()
 {
 
     // Call the built-in dashboard widget function with our callback
     wp_add_dashboard_widget(
         'dmtheme_dashboard_widget', // Widget slug. Also the HTML id for styling in admin.scss.
         __('Welcome to your Website!', 'dirtymartini'), // Title.
         'dmtheme_loom_widget_init' // Display function (below)
     );
 }
 
 
 add_action('wp_dashboard_setup', 'dmtheme_add_dashboard_widgets');
 
 