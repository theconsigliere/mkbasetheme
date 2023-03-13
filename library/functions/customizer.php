<?php
/*--------------------------------------------
/*------------------------------------
 * Theme: Starter Theme by Dirty Martini
 * File: Admin custom functions
 * Author: Maxwell Kirwin
 * URI: https://dirty-martini.com/
 *------------------------------------
*
* We've moved all of the customizer stuffs here 
* so if you don't need it, remove the include 
* statement at the top of `functions.php`.
*
*/

/****************************************
WordPress Theme Customizer 

Plate includes full support for some of 
the core controls for the WP Customizer.

Edit these or add your own. The customizer
has come a long way in the past couple years
but good developer documentation is sparse.

Some good info here if you want to go deep: 
https://maddisondesigns.com/2017/05/the-wordpress-customizer-a-developers-guide-part-1/
https://maddisondesigns.com/2017/05/the-wordpress-customizer-a-developers-guide-part-2/

 ****************************************/

add_action('customize_register', 'dmtheme_register_theme_customizer');

function dmtheme_register_theme_customizer($wp_customize)
{

  // Uncomment this to see what's going on if you make a lot of changes
  // echo '<pre>';
  // var_dump( $wp_customize );  
  // echo '</pre>';

  // Customize title and tagline sections and labels
  $wp_customize->get_section('title_tagline')->title = __('Site Name and Description', 'dmtheme');
  $wp_customize->get_control('blogname')->label = __('Site Name', 'dmtheme');
  $wp_customize->get_control('blogdescription')->label = __('Site Description', 'dmtheme');
  $wp_customize->get_setting('blogname')->transport = 'postMessage';
  $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';

  // Customize the Front Page Settings
  $wp_customize->get_section('static_front_page')->title = __('Homepage Preferences', 'dmtheme');
  $wp_customize->get_section('static_front_page')->priority = 20;
  $wp_customize->get_control('show_on_front')->label = __('Choose Homepage Preference:', 'dmtheme');
  $wp_customize->get_control('page_on_front')->label = __('Select Homepage:', 'dmtheme');
  $wp_customize->get_control('page_for_posts')->label = __('Select Blog Homepage:', 'dmtheme');

  // Customize Background Settings
  $wp_customize->get_section('background_image')->title = __('Background Styles', 'dmtheme');
  $wp_customize->get_control('background_color')->section = 'background_image';

  // Customize Header Image Settings  
  $wp_customize->add_section(
    'header_text_styles',
    array(

      'title'      => __('Header Text Styles', 'dmtheme'),
      'priority'   => 30

    )
  );

  $wp_customize->get_control('display_header_text')->section = 'header_text_styles';
  $wp_customize->get_control('header_textcolor')->section = 'header_text_styles';
  $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
}


// Custom scripts + styles for theme customizer
add_action('customize_preview_init', 'dmtheme_customizer_scripts');

function dmtheme_customizer_scripts()
{

//  wp_enqueue_script('dmtheme_theme_customizer', get_temdmtheme_directory_uri() . '/library/js/theme-customizer.js', array('jquery', 'customize-preview'), '', true);

  // register customizer stylesheet
  wp_register_style('dmtheme-customizer', get_theme_file_uri() . '/build/styles/customizer.css', array(), '', 'all');

  wp_enqueue_style('dmtheme-customizer');
}


// Callback function for updating header styles
function dmtheme_style_header()
{

  $text_color = get_header_textcolor();
  
  
  // Hide appearance header & footer & customizer
  
  function remove_header_and_bg(){
      global $submenu;
      unset($submenu['themes.php'][6]); // customize
      unset($submenu['themes.php'][15]); // header_image
      unset($submenu['themes.php'][20]); // background_image
    }
    add_action( 'admin_menu', 'remove_header_and_bg', 999 );

  ?>

<style type="text/css">
header.header .site-title a {
    color: #<?php echo esc_attr($text_color);
    ?>;
}

<?php if (display_header_text() !=true) : ?>.site-title,
.site-description {
    display: none;
}

<?php endif;

?>#banner .header-image {
    max-width: 100%;
    height: auto;
}

.customize-control-description {
    font-style: normal;
}
</style>

<?php

}
