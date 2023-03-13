<?php 
/*********************
CUSTOM LOGIN PAGE
Customize it, we don't criticize it.
*********************/


function my_login() { ?>
<style type="text/css">
<?php if(get_field('add_login_logo', 'option')): ?>#login h1 a,
.login h1 a {
    background: url(<?php echo get_field('add_login_logo', 'option');
    ?>);
    background-position: center;
    background-size: 150px 65px;
    background-repeat: no-repeat;
}

<?php else: ?>#login h1 a,
.login h1 a {
    background: url(<?php echo get_stylesheet_directory_uri() . '/build/images/DM.svg';
    ?>) no-repeat top center;
}

<?php endif;

?><?php if(get_field('background_colour', 'option')): ?>body.login {
    background: <?php echo get_field('background_colour', 'option');
    ?>;
}


#wp-auth-check-wrap #wp-auth-check {
    background: <?php echo get_field('background_colour', 'option');
    ?>;
}

.login .message,
.login .success {
    background: <?php echo get_field('background_colour', 'option');
    ?>;
}

<?php else: ?>body.login {
    background: #131313;
}


.login .message,
.login .success {
    background-color: #232323;
}

<?php endif;

?><?php if(get_field('form_background_colour', 'option')): ?>.login form {
    background-color: <?php echo get_field('form_background_colour', 'option');
    ?> !important;
    ;
}

<?php else: ?>.login form {
    background-color: #232323;
}

<?php endif;

?><?php if(get_field('text_colour', 'option')): ?>.login label,
.forgetmenot label,
#login #nav a,
#login #backtoblog a {
    color: <?php echo get_field('text_colour', 'option');
    ?>;
}

<?php endif;

?><?php if(get_field('button_colour', 'option')): ?>input#wp-submit {
    background: <?php echo get_field('button_colour', 'option');
    ?>;
}

<?php endif;
?>
</style>

<?php } 


// calling your own login css so you can style it

// Updated to proper 'enqueue' method
// http://codex.wordpress.org/Plugin_API/Action_Reference/login_enqueue_scripts
function dmtheme_login_css() {
	wp_enqueue_style( 'dmtheme_login_css', get_template_directory_uri() . '/build/styles/login.css', false );
}


// changing the logo link from wordpress.org to your site
function dmtheme_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function dmtheme_login_title() { return get_option( 'blogname' ); }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'my_login' );
add_action( 'login_enqueue_scripts', 'dmtheme_login_css', 10 );
add_filter( 'login_headerurl', 'dmtheme_login_url' );
add_filter( 'login_headertitle', 'dmtheme_login_title' );



?>