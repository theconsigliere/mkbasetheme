<?php

// ACF OPTIONS PAGE
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' 	=> 'Theme Settings',
        'menu_title'	=> 'Theme Settings',
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));

    acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Display Settings',
		'menu_title'	=> 'Display',
		'parent_slug'	=> 'theme-general-settings',
	));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Social Settings',
        'menu_title'	=> 'Socials',
        'parent_slug'	=> 'theme-general-settings',
    ));
    
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Header Settings',
        'menu_title'	=> 'Header',
        'parent_slug'	=> 'theme-general-settings',
    ));
    
    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Footer Settings',
        'menu_title'	=> 'Footer',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Search Settings',
        'menu_title'	=> 'Search',
        'parent_slug'	=> 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title' 	=> 'Theme Analytics Settings',
        'menu_title'	=> 'Analytics',
        'parent_slug'	=> 'theme-general-settings',
    ));
}

// ACF admin Styles
function my_acf_admin_head() { ?>
    <style type="text/css">
    .acf-settings-wrap .acf-postbox .postbox-header {
        background: black;
    }

    .acf-settings-wrap .acf-postbox .inside {
        background: #f7f7f7;
    }

    .acf-settings-wrap .acf-postbox {
        border: none;
    }

    .acf-settings-wrap .acf-postbox .postbox-header h2,
    .acf-settings-wrap .postbox .handle-order-higher,
    .acf-settings-wrap .postbox .handle-order-lower,
    .acf-settings-wrap .postbox .handlediv,
    .acf-settings-wrap .postbox .acf-hndle-cog,
    .acf-settings-wrap .postbox .toggle-indicator {
        color: white;
    }
    </style>
    <?php
}

add_action('acf/input/admin_head', 'my_acf_admin_head');

/*********************
GUTENBERG 
*********************/

// REMOVE ALL BLOCK PATTERNS

remove_theme_support( 'core-block-patterns' );

//ADDING CUSTOM STYLESHEET FOR ALL BLOCKS
add_action( 'enqueue_block_editor_assets', 'dm_gutenberg_css' );

function dm_gutenberg_css(){
    wp_enqueue_style( 'gutenbergthemeblocks-style', get_template_directory_uri() . '/build/styles/gutenberg-styles.css');
}

// ALLOW WIDE IN GUTENBERG
add_theme_support( 'align-wide' );

// FILTER GUTENBERG BLOCKS WE DONT NEED
add_filter( 'allowed_block_types', 'dirtymartini_allowed_block_types' );

function dirtymartini_allowed_block_types( $allowed_blocks ) {

    return array(
        /* WP Blocks */
        // 'core/embed',
        // 'core/image',
        // 'core/heading',
        // 'core/list',

        // Hero Blocks
        'acf/hero-fullwidth',
        'acf/hero-slideshow',
        'acf/hero-imageside-textside',
        'acf/hero-video',
        
        // Layout Blocks
        'acf/card-section',
        'acf/faq-section',
        'acf/info-boxes',
        'acf/accordion',
        'acf/icon-grid',

        // Media Blocks
        'acf/image-section',
        'acf/logo-credentials',
        'acf/slideshow',
        'acf/gallery',
        'acf/full-width-image',
        'acf/video-embed',
        'acf/imageside-textside',

        // Post Blocks
        'acf/author',
        'acf/post-display',
        'acf/testimonials',

        // Text Blocks
        'acf/title-section',
        'acf/content-section',
        'acf/contact-section',
        'acf/quote',

        // Util Blocks
        'acf/pricing-table',
    );

}

// CUSTOM BLOCK CATEGORY
function my_category( $categories, $post ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'hero-blocks',
                'title' => __( 'Hero Blocks', 'hero-blocks' ),
            ),
            array(
                'slug' => 'text-blocks',
                'title' => __( 'Text', 'text-blocks' ),
            ),
            array(
                'slug' => 'layout-blocks',
                'title' => __( 'Layout', 'layout-blocks' ),
            ),
            array(
                'slug' => 'media-blocks',
                'title' => __( 'Media', 'media-blocks' ),
            ),
            array(
                'slug' => 'post-blocks',
                'title' => __( 'Post Blocks', 'post-blocks' ),
            ),
            array(
                'slug' => 'util-blocks',
                'title' => __( 'Util Blocks', 'util-blocks' ),
            ),
        )
    );
}
add_filter( 'block_categories', 'my_category', 10, 2);


// REGISTER GUTENBERG BLOCKS

add_action('acf/init', 'my_acf_init_block_types');


function my_acf_init_block_types() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        //* Hero Blocks
        // *********************/

        acf_register_block_type(array(
            'name'              => 'hero-slideshow',
            'title'             => __('Hero: Slideshow'),
            'description'       => __('A Custom Hero Section.'),
            'render_template'   => 'blocks/hero/hero-slideshow.php',
            'category'          => 'hero-blocks',
            'icon'              => 'desktop',
            'mode' => 'edit',
            'keywords'          => array( 'hero', 'slideshow', 'full', 'full-width', 'width' ),
            'align' => 'full',
            'supports'          => [
                // customize alignment toolbar
            'align' => array( 'full' ),
                // This property allows the block to be added multiple times. Defaults to true.
                'multiple'      => false,

            ]
        ));

        acf_register_block_type(array(
            'name'              => 'hero-video',
            'title'             => __('Hero: Video'),
            'description'       => __('A Custom Hero Section.'),
            'render_template'   => 'blocks/hero/hero-video.php',
            'category'          => 'hero-blocks',
            'icon'              => 'desktop',
            'mode' => 'edit',
            'keywords'          => array( 'hero', 'video' ),
                                        'example'           => array(
                'attributes' => array(
                    'mode' => 'preview',
                    'data' => array(                        
                        'is_preview'    => true
                    )
                )
                ),
                'align' => 'full',
                'supports'          => [
                    // customize alignment toolbar
                    'align' => array( 'full' ),
                    // This property allows the block to be added multiple times. Defaults to true.
                    'multiple'      => false,

                    ],
    ));

        acf_register_block_type(array(
            'name'              => 'hero-imageside-textside',
            'title'             => __('Hero: Image Side Text Side'),
            'description'       => __('Image side + Text side Hero Section.'),
            'render_template'   => 'blocks/hero/hero-imageside-textside.php',
            'category'          => 'hero-blocks',
            'icon'              => 'desktop',
            'keywords'          => array( 'hero', 'text', 'image', '50-50' ),
            'align' => 'full',
            'mode' => 'edit',
            'supports'          => [
                // customize alignment toolbar
            'align' => array( 'full' ),
                // This property allows the block to be added multiple times. Defaults to true.
                'multiple'      => false,

            ]
    ));

        acf_register_block_type(array(
            'name'              => 'hero-fullwidth',
            'title'             => __('Hero: Full-Width'),
            'description'       => __('A Custom Hero Section.'),
            'render_template'   => 'blocks/hero/hero-fullwidth.php',
            'category'          => 'hero-blocks',
            'icon'              => 'desktop',
            'mode' => 'edit',
            'keywords'          => array( 'hero', 'fullwidth', 'full', 'width' ),
            'align' => 'full',
            'supports'          => [
                // customize alignment toolbar
            'align' => array( 'full' ),
                // This property allows the block to be added multiple times. Defaults to true.
                'multiple'      => false,
            ]
        ));

        //* Layout Blocks
        // *********************/

        acf_register_block_type(array(
            'name'              => 'accordion',
            'title'             => __('Accordion'),
            'description'       => __('A Custom Accordion section.'),
            'render_template'   => 'blocks/layout/accordion.php',
            'category'          => 'layout-blocks',
            'icon'              => 'editor-table',
            'mode' => 'edit',
            'align'             => false,
            'keywords'          => array( 'accordian', 'list', 'questions'),
            'supports'          => [
                'align' => ['full'],
            ]
        ));

        acf_register_block_type(array(
            'name'              => 'info-boxes',
            'title'             => __('Info Boxes'),
            'description'       => __('Displays info boxes.'),
            'render_template'   => 'blocks/layout/info-boxes.php',
            'category'          => 'layout-blocks',
            'icon'              => 'grid-view',
            'mode' => 'edit',
            'keywords'          => array( 'boxes', 'info', 'box' ),
            'align' => 'full',
            'supports'          => [
                // customize alignment toolbar
                'align' => array( 'full' ),  
                ],
        ));


        acf_register_block_type(array(
            'name'              => 'card-section',
            'title'             => __('Card Section'),
            'description'       => __('A Custom Card Section.'),
            'render_template'   => 'blocks/layout/card-section.php',
            'category'          => 'layout-blocks',
            'mode' => 'edit',
            'icon'              => 'admin-page',
            'keywords'          => array( 'card', 'section', 'options' ),
            'align' => 'full',
            'supports'          => [
                // customize alignment toolbar
                'align' => array( 'full' ),

                ],
        ));

        acf_register_block_type(array(
            'name'              => 'faq-section',
            'title'             => __('FAQ Section'),
            'description'       => __('A Custom FAQ Section.'),
            'render_template'   => 'blocks/layout/FAQ-section.php',
            'category'          => 'layout-blocks',
            'mode' => 'edit',
            'icon'              => 'list-view',
            'keywords'          => array( 'FAQ', 'list', 'layout' ),
            'align' => 'full',
            'supports'          => [
                // customize alignment toolbar
                'align' => array( 'full' ),

                ]
        ));

        acf_register_block_type(array(
            'name'              => 'icon-grid',
            'title'             => __('Icon Grid Section'),
            'description'       => __('Displays icon grid.'),
            'render_template'   => 'blocks/layout/icon-grid.php',
            'category'          => 'layout-blocks',
            'icon'              => 'grid-view',
            'mode' => 'edit',
            'keywords'          => array( 'boxes', 'icon', 'grid' ),
            'align' => 'full',
            'supports'          => [
                // customize alignment toolbar
                'align' => array( 'full' ),  
                ],
        ));

        acf_register_block_type(array(
            'name'              => 'contact-section',
            'title'             => __('Contact Section'),
            'description'       => __('A Custom contact Section.'),
            'render_template'   => 'blocks/text/contact-section.php',
            'category'          => 'layout-blocks',
            'icon'              => 'admin-comments',
            'mode' => 'edit',
            'align' => 'full',
            'supports'          => [
                // customize alignment toolbar
                'align' => array( 'full' ),

                ]
        ));

        //* Media Blocks
        // *********************/

        acf_register_block_type(array(
            'name'              => 'gallery',
            'title'             => __('Gallery'),
            'description'       => __('A Custom Gallery Section.'),
            'render_template'   => 'blocks/media/gallery.php',
            'category'          => 'media-blocks',
            'mode' => 'edit',
            'icon'              => 'embed-photo',
            'keywords'          => array( 'image', 'section', 'images', 'gallery' ),
            'align' => 'full',
            'supports'          => [
                // customize alignment toolbar
                'align' => array( 'full' ),
                ],
        ));

        acf_register_block_type(array(
            'name'              => 'logo-credentials',
            'title'             => __('Logo Credentials'),
            'description'       => __('A Custom Logo Section.'),
            'render_template'   => 'blocks/media/logo-credentials.php',
            'category'          => 'media-blocks',
            'mode' => 'edit',
            'icon'              => 'images-alt2',
            'keywords'          => array( 'image', 'section', 'logo', 'credientials' ),
            'align' => 'full',
            'supports'          => [
                // customize alignment toolbar
                'align' => array( 'full' ),
                ],
        ));

        acf_register_block_type(array(
            'name'              => 'image-section',
            'title'             => __('Image Section'),
            'description'       => __('A Custom Image Section.'),
            'render_template'   => 'blocks/media/image-section.php',
            'category'          => 'media-blocks',
            'mode' => 'edit',
            'icon'              => 'images-alt2',
            'keywords'          => array( 'image', 'section', 'images' ),
            'align' => 'full',
            'supports'          => [
                // customize alignment toolbar
                'align' => array( 'full' ),

                ],
        ));

        
        acf_register_block_type(array(
            'name'              => 'full-width-image',
            'title'             => __('Full Width Image'),
            'description'       => __('A Full Width Image Section'),
            'render_template'   => 'blocks/media/full-width-image.php',
            'category'          => 'media-blocks',
            'icon'              => 'format-image',
            'mode' => 'edit',
            'keywords'          => array( 'image', 'full', 'link'),
            'supports'          => [
                'align' => ['full'],
            ]
        ));

        acf_register_block_type(array(
            'name'              => 'slideshow',
            'title'             => __('Slideshow'),
            'description'       => __('A Custom Slideshow.'),
            'render_template'   => 'blocks/media/slideshow.php',
            'category'          => 'media-blocks',
            'icon'              => 'slides',
            'mode' => 'edit',
            'align' => 'full',
            'supports'          => [
                // customize alignment toolbar
                'align' => array( 'full' ),

                ]
        ));

        acf_register_block_type(array(
            'name'              => 'video-embed',
            'title'             => __('Video Embed'),
            'description'       => __('A Custom Testimonial.'),
            'render_template'   => 'blocks/media/video-embed.php',
            'category'          => 'media-blocks',
            'icon'              => 'text',
            'mode' => 'edit',
            'keywords'          => array( 'video', 'embed', 'vimeo'),
            'supports'          => [
                'align' => ['full'],
            ]
        ));

    
        acf_register_block_type(array(
            'name'              => 'imageside-textside',
            'title'             => __('Image Side Text Side'),
            'description'       => __('A Custom Testimonial.'),
            'render_template'   => 'blocks/media/imageside-textside.php',
            'category'          => 'media-blocks',
            'icon'              => 'cover-image',
            'mode' => 'edit',
            'keywords'          => array( 'image', 'text', 'media'),
            'supports'          => [
                'align' => ['full'],
            ]
        ));

        //* Post Blocks
        // *********************/

        
        acf_register_block_type(array(
            'name'              => 'testimonials',
            'title'             => __('Testimonials'),
            'description'       => __('A Custom Testimonial.'),
            'render_template'   => 'blocks/post/testimonials.php',
            'category'          => 'post-blocks',
            'icon'              => 'text',
            'mode' => 'edit',
            'keywords'          => array( 'testimonial', 'carousel'),
            'supports'          => [
                'align' => ['full'],
            ]
        ));

        acf_register_block_type(array(
            'name'              => 'author',
            'title'             => __('Author'),
            'description'       => __('A Custom Author Block.'),
            'render_template'   => 'blocks/post/author.php',
            'category'          => 'post-blocks',
            'icon'              => 'admin-users',
            'mode' => 'edit',
            'keywords'          => array( 'author', 'post' ),
            'align' => 'full',
            'supports'          => [
                // customize alignment toolbar
                'align' => array( 'full' ),  
                ],
        ));

        acf_register_block_type(array(
            'name'              => 'post-display',
            'title'             => __('Post Display'),
            'description'       => __('Displays all of your chosen articles.'),
            'render_template'   => 'blocks/post/post-display.php',
            'category'          => 'post-blocks',
            'icon'              => 'admin-post',
            'mode' => 'edit',
            'keywords'          => array( 'display', 'post', 'blogs', 'article' ),
            // 'enqueue_script' => get_template_directory_uri() . '/template-parts/gutenberg/testimonial/testimonial.js',
            'align' => 'full',
            'supports'          => [
                // customize alignment toolbar
                'align' => array( 'full' ),  
                ],
        ));

        
        //* Text Blocks
        // *********************/

        acf_register_block_type(array(
            'name'              => 'title-section',
            'title'             => __('Title Section'),
            'description'       => __('A Custom Title Section.'),
            'render_template'   => 'blocks/text/title-section.php',
            'category'          => 'text-blocks',
            'mode' => 'edit',
            'icon'              => 'editor-textcolor',
            'keywords'          => array( 'title', 'text' ),
            'align' => 'full',
            'supports'          => [
                // customize alignment toolbar
            'align' => array( 'full' ),

            ]  
        ));

        acf_register_block_type(array(
            'name'              => 'content-section',
            'title'             => __('Content Section'),
            'description'       => __('A Custom Content Section.'),
            'render_template'   => 'blocks/text/content-section.php',
            'category'          => 'text-blocks',
            'mode' => 'edit',
            'icon'              => 'editor-contract',
            'keywords'          => array( 'content', 'text', 'html', 'raw' ),
            'align' => 'full',
            'supports'          => [
                // customize alignment toolbar
                'align' => array( 'full' ),

                ],
        ));

        acf_register_block_type(array(
            'name'              => 'quote',
            'title'             => __('Quote'),
            'description'       => __('A Custom Quote Block.'),
            'render_template'   => 'blocks/text/quote.php',
            'category'          => 'text-blocks',
            'icon'              => 'format-quote',
            'mode' => 'edit',
            'keywords'          => array( 'quote', 'post', 'text'),
            'align' => 'full',
            'supports'          => [
                // customize alignment toolbar
                'align' => array( 'full' ),  
                ],
        ));


        //* Util Blocks
        // *********************/

        acf_register_block_type(array(
            'name'              => 'pricing-table',
            'title'             => __('Pricing Table'),
            'description'       => __('A Custom Pircing Table.'),
            'render_template'   => 'blocks/utils/pricing-table.php',
            'category'          => 'util-blocks',
            'mode' => 'edit',
            'icon'              => 'table-row-after',
            'keywords'          => array( 'Pricing', 'table'),
            'supports'          => [
                'align' => ['full'],
            ]
        ));
    }
}

        ?>
