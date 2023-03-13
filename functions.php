<?php
/*------------------------------------
* Theme: Dirty Martini Theme by Dirty Martini
* File: Main functions file
* Author: Maxwell Kirwin
* URI: https://dirty-martini.com/
Version: 4.0
*------------------------------------
*
* We've moved all of the theme functions to this single
* file to keep things tidy. 
*
*
*/

/* Plate development and debug functions
(not required but helper stuff for debugging and development)
*/

/* WordPress Admin functions (for customizing the WP Admin)
(also not required so comment it out if you don't need it)
*/

// WordPress Customizer functions and enqueues

require_once('library/functions/admin.php');
require_once('library/functions/login.php');
require_once('library/functions/customizer.php');
require_once('library/functions/acf-gutenburg.php');
require_once('library/functions/post-types.php');
require_once('library/functions/wp-cleanup.php');
require_once('library/functions/welcome-banner.php');
require_once('library/functions/loom-widget.php');
require_once('library/functions/utils.php');
require_once('library/_plugins/required-plugins.php');


/**
* Change default gravatar.
*/

add_filter( 'avatar_defaults', 'new_gravatar' );
function new_gravatar ($avatar_defaults) {
$myavatar = 'https://pbs.twimg.com/profile_images/1402926768076603395/RH8L1ZgH_400x400.jpg';
$avatar_defaults[$myavatar] = "Default Gravatar";
return $avatar_defaults;
}



/************************************
 * DMTHEME LUNCH
 * 
 * Let's get everything on the plate. Mmmmmmmm.
 * 
 ************************************/

add_action('after_setup_theme', 'dmtheme_lunch');

function dmtheme_lunch() {

    // backend styles
    add_action('admin_enqueue_scripts', 'DM_admin_styles');

    // Removes Admin bar
    add_filter('show_admin_bar', '__return_false');

    // let's get language support going, if you need it
    load_theme_textdomain('dmtheme', get_template_directory() . '/library/translation');

    // remove pesky injected css for recent comments widget
    add_filter('wp_head', 'dmtheme_remove_wp_widget_recent_comments_style', 1);

    // clean up comment styles in the head
    add_action('wp_head', 'dmtheme_remove_recent_comments_style', 1);

    // clean up gallery output in wp
    add_filter('gallery_style', 'dmtheme_gallery_style');

    // enqueue the styles and scripts
    add_action('wp_enqueue_scripts', 'dmtheme_scripts_and_styles', 999);

    // support the theme stuffs
    dmtheme_theme_support();

    // adding sidebars to Wordpress
    add_action('widgets_init', 'dmtheme_register_sidebars');

    // cleaning up <p> tags around images
    add_filter('the_content', 'dmtheme_filter_ptags_on_images');

    // clean up the default WP excerpt
    add_filter('excerpt_more', 'dmtheme_excerpt_more');

    // new body_open() function added in WP 5.2
    // https://generatewp.com/wordpress-5-2-action-that-every-theme-should-use/
    if (!function_exists('wp_body_open')) {
        /**
         * Fire the wp_body_open action.
         *
         * Added for backwards compatibility to support WordPress versions prior to 5.2.0.
         */
        function wp_body_open()
        {
            /**
             * Triggered after the opening <body> tag.
             */
            do_action('wp_body_open');
        }
    }
} /* end dmtheme lunch */


// remove injected CSS for recent comments widget
function dmtheme_remove_wp_widget_recent_comments_style()
{

    if (has_filter('wp_head', 'wp_widget_recent_comments_style')) {

        remove_filter('wp_head', 'wp_widget_recent_comments_style');
    }
}

// remove injected CSS from recent comments widget
function dmtheme_remove_recent_comments_style()
{

    global $wp_widget_factory;

    if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {

        remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
    }
}

// DM styles
function DM_admin_styles() {
    wp_enqueue_style( 'dashboard-style', get_template_directory_uri() . '/build/styles/dashboard.css');
    wp_enqueue_style( 'login-style', get_template_directory_uri() . '/build/styles/login.css');
}

// remove injected CSS from gallery
function dmtheme_gallery_style($css)
{
    return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}


/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size('dmtheme-image-600', 600, 600, true);
add_image_size('dmtheme-image-300', 300, 300, true);
add_image_size('dmtheme-image-150', 150, 150, true);

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 100 sized image,
we would use the function:
<?php the_post_thumbnail( 'dmtheme-image-300' ); ?>
for the 600 x 150 image:
<?php the_post_thumbnail( 'dmtheme-image-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter('image_size_names_choose', 'dmtheme_custom_image_sizes');

function dmtheme_custom_image_sizes($sizes)
{

return array_merge(
$sizes,
array(

'dmtheme-image-600' => __('600px by 600px', 'dmtheme'),
'dmtheme-image-300' => __('300px by 300px', 'dmtheme'),
'dmtheme-image-150' => __('150px by 150px', 'dmtheme'),

)
);
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function dmtheme_register_sidebars()
{

register_sidebar(
array(

'id' => 'sidebar-blog',
'name' => __('Sidebar Blog', 'dmtheme'),
'description' => __('The first sidebar. For the blog page', 'dmtheme'),
'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',

)
);

/*
to add more sidebars or widgetized areas, just copy
and edit the above sidebar code. In order to call
your new sidebar just use the following code:

Just change the name to whatever your new
sidebar's id is, for example: */

register_sidebar(
array(

'id' => 'footer-info',
'name' => __('Footer Info', 'dmtheme'),
'description' => __('Input contact information for use in the footer.', 'dmtheme'),
'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',

)
);

/* To call the sidebar in your temdmtheme, you can just copy
the sidebar.php file and rename it to your sidebar's name.
So using the above example, it would be:
sidebar-sidebar2.php */
} // don't remove this bracket!


/*********************
COMMENTS
Blah blah blah.
*********************/



// Comment Layout
function dmtheme_comments($comment, $args, $depth)
{

$GLOBALS['comment'] = $comment; ?>

<div id="comment-<?php comment_ID(); ?>" <?php comment_class('comment-wrap'); ?>>

    <article class="article-comment">

        <header class="comment-author vcard">

            <?php
                        /*
                    this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
                    echo get_avatar($comment,$size='32',$default='<path_to_url>' );
                    */
                        ?>

            <?php // custom gravatar call 
                        ?>

            <?php
                        // create variable
                        $bgauthemail = get_comment_author_email();
                        ?>

            <!-- <img data-gravatar="//www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=256"
                    class="load-gravatar avatar avatar-48 photo" height="64" width="64"
                    src="<?php echo get_theme_file_uri(); ?>/library/images/custom-gravatar.png" /> -->

            <?php // end custom gravatar call 
                        ?>

            <div class="comment-meta">

                <?php printf(__('<cite class="fn">%1$s</cite> %2$s', 'dmtheme'), get_comment_author_link(), edit_comment_link(__('(Edit)', 'dmtheme'), '  ', '')) ?>

                <time datetime="<?php echo comment_time('Y-m-j'); ?>">

                    <a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)) ?>"><?php comment_time(__('F jS, Y', 'dmtheme')); ?>
                    </a>

                </time>

            </div>

        </header>

        <?php if ($comment->comment_approved == '0') : ?>

        <div class="alert alert-info">

            <p><?php _e('Your comment is awaiting moderation.', 'dmtheme') ?></p>

        </div>

        <?php endif; ?>

        <section class="comment-content">

            <?php comment_text() ?>

        </section>

        <div class="comment-reply">

            <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>

        </div>

    </article>

    <?php // </li> is added by WordPress automatically ?>

    <?php } // don't remove this bracket!




/****************************************
 * SCHEMA *
    http://www.longren.io/add-schema-org-markup-to-any-wordpress-theme/
    ****************************************/

function html_schema()
{

    $schema = 'https://schema.org/';

    // Is single post
    if (is_single()) {
        $type = "Article";
    }

    // Is blog home, archive or category
    else if (is_home() || is_archive() || is_category()) {
        $type = "Blog";
    }

    // Is static front page
    else if (is_front_page()) {
        $type = "Website";
    }

    // Is a general page
    else {
        $type = 'WebPage';
    }

    echo 'itemscope="itemscope" itemtype="' . $schema . $type . '"';
}


/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, comment reply and custom scripts
function dmtheme_scripts_and_styles() {
    global $wp_styles; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
    if (!is_admin()) {
        // STYLES
        /*********************/
        // register main stylesheet
        wp_enqueue_style('styles', get_theme_file_uri() . '/build/styles/style.css', array(), '', 'all');

        // JavaScript
        /*********************/
        wp_enqueue_script('javascript', get_template_directory_uri() . '/build/js/index.js', array(), false, true);
        $wp_styles->add_data('dmtheme-ie-only', 'conditional', 'lt IE 9'); // add conditional wrapper around ie stylesheet

        // Fonts
        /*********************/

        // Include the file.
        require_once( 'library/functions/wptt-webfont-loader.php' );
        
        // Load the webfont.
        wp_add_inline_style(
            'dmtheme',
            wptt_get_webfont_styles( 'https://fonts.googleapis.com/css2?family=Roboto+Flex:opsz,wght@8..144,400;8..144,500;8..144,700&display=swap' )
        );

        // SCRIPTS
        /*********************/
        // comment reply script for threaded comments
        if (is_singular() and comments_open() and (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

function my_admin_enqueue_scripts() {
    wp_enqueue_script('admin-javascript', get_template_directory_uri() . '/build/js/index.js', array(), false, true);
}

add_action('acf/input/admin_enqueue_scripts', 'my_admin_enqueue_scripts');


// Remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
// This only works for the main content box, not using ACF or other page builders.
// Added small bit of javascript in scripts.js that will work everywhere. 
// Keeping this in in case people are still using it.
add_filter('the_content', 'dmtheme_filter_ptags_on_images');

function dmtheme_filter_ptags_on_images($content)
{

    return preg_replace('/<pp>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}


// Simple function to remove the [...] from excerpt and add a 'Read More �' link.
function dmtheme_excerpt_more($more)
{
    global $post;
    // edit here if you like
    return '...  <a class="excerpt-read-more" href="' . get_permalink($post->ID) . '" title="' . __('Read ', 'dmtheme') . esc_attr(get_the_title($post->ID)) . '">' . __('Read more &raquo;', 'dmtheme') . '</a>';
}



/*********************
THEME SUPPORT
    *********************/

// support all of the theme things
function dmtheme_theme_support()
{

    // wp thumbnails (see sizes above)
    add_theme_support('post-thumbnails');

    // default thumb size
    set_post_thumbnail_size(125, 125, true);

    // wp custom background (thx to @bransonwerner for update)
    add_theme_support(
        'custom-background',
        array(

            'default-image' => '',    // background image default
            'default-color' => '',    // background color default (dont add the #)
            'wp-head-callback' => '_custom_background_cb',
            'admin-head-callback' => '',
            'admin-preview-callback' => '',

        )
    );

    // Custom Header Image
    add_theme_support(
        'custom-header',
        array(

            'default-image'      => get_template_directory_uri() . '/build/images/header-image.png',
            'default-text-color' => '000',
            'width'              => 1440,
            'height'             => 220,
            'flex-width'         => true,
            'flex-height'        => true,
            'header-text'        => true,
            'uploads'            => true,
            'wp-head-callback'   => 'dmtheme_style_header',

        )
    );

    // Custom Logo
    add_theme_support(
        'custom-logo',
        array(

            'height'      => 100,
            'width'       => 100,
            'flex-height' => true,
            'flex-width'  => true,
            'header-text' => array('site-title', 'site-description'),

        )
    );

    // rss thingy
    add_theme_support('automatic-feed-links');

    // To add another menu, uncomment the second line and change it to whatever you want. You can have even more menus.
    register_nav_menus(
        array(

            'main-nav' => __('The Main Menu', 'dmtheme'),   // main nav in header
            'footer-links' => __('Footer Links', 'dmtheme') // secondary nav in footer. Uncomment to use or edit.

        )
    );

    // Title tag. Note: this still isn't working with Yoast SEO
    add_theme_support('title-tag');

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    // Enable support for HTML5 markup.
    add_theme_support(
        'html5',
        array(

            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption'

        )
    );

/* 
* POST FORMATS
* Ahhhh yes, the wild and wonderful world of Post Formats. 
* I've never really gotten into them but I could see some
* situations where they would come in handy. Here's a few
* examples: https://www.competethemes.com/blog/wordpress-post-format-examples/
* 
* This theme doesn't use post formats per se but we need this 
* to pass the theme check.
* 
* We may add better support for post formats in the future.
* 
* If you want to use them in your project, do so by all means. 
* We won't judge you. Ok, maybe a little bit.
*
*/

    add_theme_support(
        'post-formats',
        array(

            'aside',             // title less blurb
            'gallery',           // gallery of images
            'link',              // quick link to other site
            'image',             // an image
            'quote',             // a quick quote
            'status',            // a Facebook like status update
            'video',             // video
            'audio',             // audio
            'chat'               // chat transcript

        )
    );



    } /* end plate theme support */


/** 
 * $content_width.
 * 
 * We need this to pass the theme check. Massive eye roll.
 * IT DOESN'T MAKE SENSE WITH RESPONSIVE LAYOUTS.
 * I'm looking at you, WordPress Trac peoples.
 * 
 * Probably best to not touch this unless you really want to
 * assign a maximum content width.
 * 
 * https://codex.wordpress.org/Content_Width
 * 
 */

if (!isset($content_width)) {
    $content_width = '100%';
}


/* 


/*********************
RELATED POSTS FUNCTION
    *********************/

/**
 * Plate Related Posts.
 * 
 * Adapted from this gist:
 * https://gist.github.com/claudiosanches/3167825
 * 
 * Replaced old related posts function from Bones.
 * Added: 2018-05-03
 *
 * Usage:
 * To show related by categories:
 * Add in single.php <?php plate_related_posts(); ?>.
    * To show related by tags:
    * Add in single.php <?php plate_related_posts('tag'); ?>.
    *
    * @global array $post
    * WP global post.
    * @param string $display
    * Set category or tag.
    * @param int $qty
    * Number of posts to be displayed.
    * @param bool $images
    * Enable or disable displaying images.
    * @param string $title
    * Set the widget title.
    */

    function dmtheme_related_posts($display = 'category', $qty = 5, $images = true, $title = 'Related Posts')
    {
    global $post;
    $show = false;
    $post_qty = (int) $qty;
    switch ($display):
    case 'tag':
    $tags = wp_get_post_tags($post->ID);
    if ($tags) {
    $show = true;
    $tag_ids = array();
    foreach ($tags as $individual_tag) {
    $tag_ids[] = $individual_tag->term_id;
    }
    $args = array(
    'tag__in' => $tag_ids,
    'post__not_in' => array($post->ID),
    'posts_per_page' => $post_qty,
    'ignore_sticky_posts' => 1
    );
    }
    break;
    default:
    $categories = get_the_category($post->ID);
    if ($categories) {
    $show = true;
    $category_ids = array();
    foreach ($categories as $individual_category) {
    $category_ids[] = $individual_category->term_id;
    }
    $args = array(
    'category__in' => $category_ids,
    'post__not_in' => array($post->ID),
    'showposts' => $post_qty,
    'ignore_sticky_posts' => 1
    );
    }
    endswitch;
    if ($show == true) {
    $related = new wp_query($args);
    if ($related->have_posts()) {
    $layout = '<div class="related-posts">';
        $layout .= '<h3>' . strip_tags($title) . '</h3>';
        $layout .= '<ul class="nostyle related-posts-list">';
            while ($related->have_posts()) {
            $related->the_post();
            $layout .= '<li class="related-post">';
                if ($images == true) {
                $layout .= '<span class="related-thumb">';
                    $layout .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '">' .
                        get_the_post_thumbnail() . '</a>';
                    $layout .= '</span>';
                }
                $layout .= '<span class="related-title">';
                    $layout .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() .
                        '</a>';
                    $layout .= '</span>';
                $layout .= '</li>';
            }
            $layout .= '</ul>';
        $layout .= '</div>';
    echo $layout;
    }
    wp_reset_query();
    }
    }


    /*********************
    PAGE NAVI
    *********************/

    /*
    * Numeric Page Navi (built into the theme by default).
    * (Updated 2018-05-17)
    *
    * If you're using this with a custom WP_Query, make sure
    * to add your query variable as an argument and this
    * function will play nice. Example:
    *
    * dmtheme_page_navi( $query );
    *
    * Also make sure your query has pagination set, e.g.:
    * $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    * (or something similar)
    * See the codex: https://codex.wordpress.org/Pagination
    *
    */

    function dmtheme_page_navi($wp_query)
    {
    $pages = $wp_query->max_num_pages;
    $big = 999999999; // need an unlikely integer

    if ($pages > 1) {
    $page_current = max(1, get_query_var('paged'));

    echo '<nav class="pagination">';

        echo paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => $page_current,
        'total' => $pages,
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
        'type' => 'list',
        'end_size' => 3,
        'mid_size' => 3
        ));

        echo '</nav>';
    }
    }


    /*
    ****************************************
    * dmtheme SPECIAL FUNCTIONS *
    ****************************************
    */

    // Body Class functions
    // Adds more slugs to body class so we can style individual pages + posts.
    add_filter('body_class', 'dmtheme_body_class');

    function dmtheme_body_class($classes)
    {

    // Adds new classes for blogroll page (list of blog posts)
    // good for containing full-width images from Gutenberg
    // Added: 2018-12-07
    global $wp_query;

    if (isset($wp_query) && (bool) $wp_query->is_posts_page) {
    $classes[] = 'blogroll page-blog';
    }

    global $post;

    if (isset($post)) {

    /* Un comment below if you want the post_type-post_name body class */
    /* $classes[] = $post->post_type . '-' . $post->post_name; */

    $pagetemplate = get_post_meta($post->ID, '_wp_page_template', true);
    $classes[] = sanitize_html_class(str_replace('.', '-', $pagetemplate), '');
    $classes[] = $post->post_name;
    }

    if (is_page()) {

    global $post;

    if ($post->post_parent) {

    // Parent post name/slug
    $parent = get_post($post->post_parent);
    $classes[] = $parent->post_name;

    // Parent template name
    $parent_template = get_post_meta($parent->ID, '_wp_page_template', true);

    if (!empty($parent_template))
    $classes[] = 'template-' . sanitize_html_class(str_replace('.', '-', $parent_template), '');
    }

    // If we *do* have an ancestors list, process it
    // http://codex.wordpress.org/Function_Reference/get_post_ancestors
    if ($parents = get_post_ancestors($post->ID)) {

    foreach ((array) $parents as $parent) {

    // As the array contains IDs only, we need to get each page
    if ($page = get_page($parent)) {
    // Add the current ancestor to the body class array
    $classes[] = "{$page->post_type}-{$page->post_name}";
    }
    }
    }

    // Add the current page to our body class array
    $classes[] = "{$post->post_type}-{$post->post_name}";
    }

    if (is_page_template('single-full.php')) {
    $classes[] = 'single-full';
    }

    return $classes;
    }


    /*
    * QUICKTAGS
    *
    * Let's add some extra Quicktags for clients who aren't HTML masters
    * They are pretty handy for HTML masters too.
    *
    * Hook into the 'admin_print_footer_scripts' action
    *
    */
    add_action('admin_print_footer_scripts', 'dmtheme_custom_quicktags');

    function dmtheme_custom_quicktags()
    {

    if (wp_script_is('quicktags')) { ?>

    <script type="text/javascript">
    QTags.addButton('qt-p', 'p', '<p>', '</p>', '', '', 1);
    QTags.addButton('qt-br', 'br', '<br>', '', '', '', 9);
    QTags.addButton('qt-span', 'span', '<span>', '</span>', '', '', 11);
    QTags.addButton('qt-h2', 'h2', '<h2>', '</h2>', '', '', 12);
    QTags.addButton('qt-h3', 'h3', '<h3>', '</h3>', '', '', 13);
    QTags.addButton('qt-h4', 'h4', '<h4>', '</h4>', '', '', 14);
    QTags.addButton('qt-h5', 'h5', '<h5>', '</h5>', '', '', 15);
    </script>

    <?php }
    }

    // Load dashicons on the front end
    // To use, go here and copy the css/html for the dashicon you want: https://developer.wordpress.org/resource/dashicons/
    // Example: <span class="dashicons dashicons-wordpress"></span>

    // add_action( 'wp_enqueue_scripts', 'template_load_dashicons' );
    // function template_load_dashicons() {
    //     wp_enqueue_style( 'dashicons' );
    // }


// Post Author function (from WP Twenty Seventeen theme)
// We use this in the byline template part but included here in case you want to use it elsewhere.
if (!function_exists('dmtheme_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function dmtheme_posted_on()
    {

        // Get the author name; wrap it in a link.
        $byline = sprintf(

            /* translators: %s: post author */
            __('by %s', 'dmtheme'),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . get_the_author() . '</a></span>'

        );

        // Finally, let's write all of this to the page.
        echo '<span class="posted-on">' . dmtheme_time_link() . '</span><span class="byline"> ' . $byline . '</span>';
    }
endif;


// Post Time function (from WP Twenty Seventeen theme)
if (!function_exists('dmtheme_time_link')) :
    /**
     * Gets a nicely formatted string for the published date.
     */
    function dmtheme_time_link()
    {

        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        // if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        //   $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        // }

        $time_string = sprintf(
            $time_string,
            get_the_date(DATE_W3C),
            get_the_date(),
            get_the_modified_date(DATE_W3C),
            get_the_modified_date()
        );

        // Wrap the time string in a link, and preface it with 'Posted on'.
        return sprintf(

            /* translators: %s: post date */
            __('<span class="screen-reader-text">Posted on</span> %s', 'dmtheme'),
            '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'

        );
    }
endif;


/** 
 * Dashboard Widget
 * 
 * Add a widget to the dashboard in the WP Admin.
 * Great to add instructions or info for clients.
 *  
 * If you don't need/want this, just remove it or 
 * comment it out.
 * 
 * Customize it...yeaaaahhh...but don't criticize it.
 * 
 * 
 */






        // REMOVE P TAGS FROM CONTACT FORM 7
        add_filter('wpcf7_autop_or_not', '__return_false'); 

        // REMOVE FORMATING FROM WYSIWYG 

        function acf_wysiwyg_remove_wpautop() {
            remove_filter('acf_the_content', 'wpautop' );
        }
        add_action('acf/init', 'acf_wysiwyg_remove_wpautop', 15);

        // changes the theme background UI Colours
        // wpadmincolors.com

        function dm_admin_color_scheme() {
            //Get the theme directory
            $theme_dir = get_template_directory_uri();
           
            //DM Colour Scheme
            wp_admin_css_color( 'dm-colour-scheme', __( 'DM Colour Scheme' ),
              $theme_dir . '/build/styles/UI-colour-scheme.css',
              array( '#000000', '#fff', '#757575' , '#2b2b2b')
            );
          }
          add_action('admin_init', 'dm_admin_color_scheme');

          // set default color scheme
          add_filter('get_user_option_admin_color', 'set_default_admin_color');
            function set_default_admin_color($result)
            {
                // set new default admin color scheme
                $result = 'dm-colour-scheme';

                // return the new default color
                return $result;
           }



                // ADDS CATEGORY NAME TO WP REST API RESPONSE

                add_action( 'rest_api_init', 'add_category_to_JSON' );
                function add_category_to_JSON(){
                register_rest_field( 'post',
                'categories',
                array(
                'get_callback' => 'wpse_287931_get_categories_names',
                'update_callback' => null,
                'schema' => null,
                )
                );
                }
                
                function wpse_287931_get_categories_names( $object, $field_name, $request ) {
                
                $formatted_categories[] = array();
                
                $categories = get_the_category( $object['id'] );
                $i = 0;
                foreach ($categories as $category) {
                
                $formatted_categories[$i]['category_link'] = get_category_link($category->term_id);
                $formatted_categories[$i]['category_name'] = $category->name;
                $i++;
                }
                
                return $formatted_categories;
                }
              

                // add image to rest api
                
                function post_featured_image_json( $data, $post, $context ) {
                $featured_image_id = $data->data['featured_media']; // get featured image id
                $featured_image_url = wp_get_attachment_image_src( $featured_image_id, 'original' ); // get url of the original size

                if( $featured_image_url ) {
                    $data->data['featured_image_url'] = $featured_image_url[0];
                }

                return $data;
                }
                add_filter( 'rest_prepare_post', 'post_featured_image_json', 10, 3 );



                /* Function for post duplication. Dups appear as drafts. User is redirected to the edit screen */
function rd_duplicate_post_as_draft(){
    global $wpdb;
    if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'rd_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
      wp_die('No post to duplicate has been supplied!');
    }
   
    /* Nonce verification */
    if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
      return;
   
    /* Get the original post id */
    $post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );
   
    /* and all the original post data then */
    $post = get_post( $post_id );
   
    /* If you don't want current user to be the new post author, then change next couple of lines to this: $new_post_author = $post->post_author; */
    $current_user = wp_get_current_user();
    $new_post_author = $current_user->ID;
   
    /* If post data exists, create the post duplicate */
    if (isset( $post ) && $post != null) {
   
      /* New post data array */
      $args = array(
        'comment_status' => $post->comment_status,
        'ping_status'    => $post->ping_status,
        'post_author'    => $new_post_author,
        'post_content'   => $post->post_content,
        'post_excerpt'   => $post->post_excerpt,
        'post_name'      => $post->post_name,
        'post_parent'    => $post->post_parent,
        'post_password'  => $post->post_password,
        'post_status'    => 'draft',
        'post_title'     => $post->post_title,
        'post_type'      => $post->post_type,
        'to_ping'        => $post->to_ping,
        'menu_order'     => $post->menu_order
      );
   
      /* Insert the post by wp_insert_post() function */
      $new_post_id = wp_insert_post( $args );
   
      /* Get all current post terms ad set them to the new post draft */
      $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
      foreach ($taxonomies as $taxonomy) {
        $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
        wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
      }
   
      /* Duplicate all post meta just in two SQL queries */
      $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
      if (count($post_meta_infos)!=0) {
        $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
        foreach ($post_meta_infos as $meta_info) {
          $meta_key = $meta_info->meta_key;
          if( $meta_key == '_wp_old_slug' ) continue;
          $meta_value = addslashes($meta_info->meta_value);
          $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
        }
        $sql_query.= implode(" UNION ALL ", $sql_query_sel);
        $wpdb->query($sql_query);
      }
   
   
      /* Finally, redirect to the edit post screen for the new draft */
      wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
      exit;
    } else {
      wp_die('Post creation failed, could not find original post: ' . $post_id);
    }
  }
  add_action( 'admin_action_rd_duplicate_post_as_draft', 'rd_duplicate_post_as_draft' );
   
  /* Add the duplicate link to action list for post_row_actions */
  function rd_duplicate_post_link( $actions, $post ) {
    if (current_user_can('edit_posts')) {
      $actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=rd_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Duplicate this item" rel="permalink">Duplicate</a>';
    }
    return $actions;
  }
         
  add_filter('page_row_actions', 'rd_duplicate_post_link', 10, 2);
  add_filter( 'post_row_actions', 'rd_duplicate_post_link', 10, 2 );


// remove the hello word post programmatically
 wp_delete_post(1); 


// Find and delete the WP default 'Sample Page'
$defaultPage = get_page_by_title( 'Sample Page' );
if ($defaultPage) {
    wp_delete_post( $defaultPage->ID );
}

// shove YOAST settings panel in editor to bottom 
add_filter( 'wpseo_metabox_prio', function() { return 'low'; } );



// ADD DEFAULT GRAVATAR

function change_avatar($avatar, $id_or_email, $size, $default, $alt) {
    $new_admin_image = get_stylesheet_directory_uri() . '/build/images/avatar.svg';
    $avatar = "<img alt='{$alt}' src='{$new_admin_image}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";

    return $avatar;
}

add_filter('get_avatar', 'change_avatar', 10, 5);



    // add tag names to WPREST API RESPONSE
    function ag_filter_post_json($response, $post, $context) {
        $tags = get_the_tags($post->ID);
        $response->data['tag_names'] = [];

        if ($tags) {
            foreach ($tags as $tag) {
                $response->data['tag_names'][] = $tag->name;
            }
        }


        return $response;
    }

    add_filter( 'rest_prepare_post', 'ag_filter_post_json', 10, 3 );


    // add anchor classes to wp_nav_menu to work with link manager

    function add_link_atts($atts) {
        $atts['class'] = "js-nav-link";
        return $atts;
        }
        add_filter( 'nav_menu_link_attributes', 'add_link_atts');


      // get maximum removed for endpoints

    add_filter( 'rest_endpoints', function( $endpoints ){
        if ( ! isset( $endpoints['/wp/v2/posts'] ) ) {
            return $endpoints;
        }
        unset( $endpoints['/wp/v2/posts'][0]['args']['per_page']['maximum'] );
        return $endpoints;
    });


    /**
     * Templates and Page IDs without editor
     *
     */
    function ea_disable_editor( $id = false ) {

        $excluded_templates = array(
            'archive.php',
        );

        $excluded_ids = array(
            // get_option( 'page_on_front' )
        );

        if( empty( $id ) )
            return false;

        $id = intval( $id );
        $template = get_page_template_slug( $id );

        return in_array( $id, $excluded_ids ) || in_array( $template, $excluded_templates );
    }

  // Remove gutenberg on chosen page tempaltes and post types
  
  function mgc_gutenberg_filter( $use_block_editor, $post_type ) {
    if ( 'post' === $post_type || 'testimonials' === $post_type  ) {
        $use_block_editor = false;
    }
    if( ea_disable_editor( $_GET['post'] ) ) {
        $use_block_editor = false;
    }
    return $use_block_editor;
  }
    add_filter( 'use_block_editor_for_post_type', 'mgc_gutenberg_filter', 10, 2 );


    // Or you use the trick from PHP Debug to console.

    function debug_to_console($data) {

    // Buffering to solve problems frameworks, like header() in this and not a solid return.
    ob_start();

    $output  = 'console.info(\'' . $context . ':\');';
    $output .= 'console.log(' . json_encode($data) . ');';
    $output  = sprintf('<script>%s</script>', $output);

    echo $output;
    }

      // get maximum removed for exndpoints


        add_filter( 'rest_endpoints', function( $endpoints ){
            if ( ! isset( $endpoints['/wp/v2/posts'] ) ) {
                return $endpoints;
            }
            unset( $endpoints['/wp/v2/posts'][0]['args']['per_page']['maximum'] );
            return $endpoints;
        });


    // update $screenshot to new ACF field value


    add_filter( 'wp_prepare_themes_for_js', function( $themes ) {

        if (is_plugin_active('advanced-custom-fields-pro/acf.php')) {
        $themeImage = get_field('theme_image', 'option');
        $themeName = get_field('theme_name', 'option');
        $themeDesc = get_field('theme_desc', 'option');
        }
    
        if ($themeImage) {
         $themes['dmtheme']['screenshot'] = [$themeImage];
        };   
   
         if ($themeName) {
            $themes['dmtheme']['name'] = $themeName;
        };

        if ($themeDesc) {
            $themes['dmtheme']['description'] = $themeDesc;
        };
            
        return $themes;
    });
    

    
    // get formatted Date in rest api
    add_action('rest_api_init', function() {
        register_rest_field(
            array('post'),
            'formatted_date',
            array(
                'get_callback'    => function() {
                    return get_the_date();
                },
                'update_callback' => null,
                'schema'          => null,
            )
        );
    });
   

?>
