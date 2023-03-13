<?php


        /**
        * Load an inline SVG.
        * https://enshrined.co.uk/2018/09/19/how-to-properly-include-inline-svgs-in-a-wordpress-theme/
        * @param string $filename The filename of the SVG you want to load.
        *
        * @return string The content of the SVG you want to load.
        */
        function load_inline_svg( $filename ) {
        
            // Add the path to your SVG directory inside your theme.
            $svg_path = '/build/images/';
        
            // Check the SVG file exists
            if ( file_exists( get_stylesheet_directory() . $svg_path . $filename ) ) {
        
                // Load and return the contents of the file
                return file_get_contents( get_template_directory() . $svg_path . $filename );
            }
        
            // Return a blank string if we can't find the file.
            return '';
        }



?>