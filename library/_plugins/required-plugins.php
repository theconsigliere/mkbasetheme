<?php
/** 
* TGM_Plugin_Activation class.
* 
* 
*/

/**
 * Include the TGM_Plugin_Activation class.
 */

include_once dirname(__FILE__) . '/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'dmtheme_register_required_plugins');

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function dmtheme_register_required_plugins()
{
/*
* Array of plugin arrays. Required keys are name and slug.
* If the source is NOT from the .org repo, then source is also required.
*/
    $plugins = array(

        // Including ACF PRO with the theme
        array(
            'name'               => 'Advanced Custom Fields Pro', // The plugin name.
            'slug'               => 'advanced-custom-fields-pro', // The plugin slug (typically the folder name).
            'source'             => get_template_directory() . '/library/_plugins/advanced-custom-fields-pro.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
            'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
        ),

        // Including All in One Wp Migration with the theme
        array(
            'name'               => 'All-in-One WP Migration Unlimited Extension', // The plugin name.
            'slug'               => 'all-in-one-wp-migration-unlimited-extension', // The plugin slug (typically the folder name).
            'source'             => get_template_directory() . '/library/_plugins/all-in-one-wp-migration-unlimited-extension.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
            'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
        ),

         // how to include a plugin from the WordPress Plugin Repository.
        // Lazy load Images
        array(
            'name'      => 'All in One WP Migration',
            'slug'      => 'all-in-one-wp-migration',
            'required'  => true,
        ),

        // Gravity Forms
        array(
            'name'      => 'Gravity Forms',
            'slug'      => 'gravity-forms',
            'source'             => get_template_directory() . '/library/_plugins/gravityforms_2.6.4.3.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
            'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
        ),

        // Advanced Custom Fields: Font Awesome Field
        array(
            'name'      => 'Advanced Custom Fields: Font Awesome Field',
            'slug'      => 'advanced-custom-fields-font-awesome',
            'required'  => true,
        ),

        // Advanced Custom Fields: Star Rating Field
        array(
            'name'      => 'Advanced Custom Fields: Star Rating Field',
            'slug'      => 'acf-star-rating-field',
            'source'             => get_template_directory() . '/library/_plugins/acf-star-rating-field.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
            'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
        ),


        // SVG Support
        array(
            'name'      => 'SVG Support',
            'slug'      => 'svg-support',
            'required'  => true,
        ),

        // ACF Pricing Table
        array(
            'name'      => 'Advanced Custom Fields: Table Field',
            'slug'      => 'advanced-custom-fields-table-field',
            'required'  => true,
        ),


        // This is an example of the use of 'is_callable' functionality. A user could - for instance -
        // have WPSEO installed *or* WPSEO Premium. The slug would in that last case be different, i.e.
        // 'wordpress-seo-premium'.
        // By setting 'is_callable' to either a function from that plugin or a class method
        // `array( 'class', 'method' )` similar to how you hook in to actions and filters, TGMPA can still
        // recognize the plugin as being installed.
        array(
            'name'        => 'WordPress SEO by Yoast',
            'slug'        => 'wordpress-seo',
            'is_callable' => 'wpseo_init',
        ),

        // ACF Content Analysis

        array(
            'name'      => 'ACF Content Analysis for Yoast SEO',
            'slug'      => 'acf-content-analysis-for-yoast-seo',
            'required'  => false,
        ),

    );

    /*
    * Array of configuration settings. Amend each line as needed.
    *
    * TGMPA will start providing localized text strings soon. If you already have translations of our standard
    * strings available, please help us make TGMPA even better by giving us access to these translations or by
    * sending in a pull-request with .po file(s) with the translations.
    *
    * Only uncomment the strings in the config array if you want to customize the strings.
    */
        $config = array(
            'id'           => 'dmtheme',                 // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                      // Default absolute path to bundled plugins.
            'menu'         => 'tgmpa-install-plugins', // Menu slug.
            'parent_slug'  => 'themes.php',            // Parent menu slug.
            'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.

        );

        tgmpa($plugins, $config);
    }

?>