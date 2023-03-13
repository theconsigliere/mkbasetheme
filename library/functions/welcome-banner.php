<?php

/**********************************
 * Custom DM Admin Welcome Banner *
 *********************************/
function dm_welcome_panel() { ?>
<div class="WelcomePanel">
    <div class="WelcomePanel__header">
        <img src="<?php echo get_theme_file_uri(); ?>/build/images/DM-black.svg" />
    </div>
    <div class="WelcomePanel__column-group">
        <div class="WelcomePanel__column">
            <div class="welcome-panel-icon-pages"></div>
            <div class="WelcomePanel__column-content">
                <h3><?php _e( 'Start Customizing' ); ?></h3>
                <p><?php _e( 'Update text, images and more in the page editor.' ); ?></p>
                <a
                    href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>"><?php _e( 'View pages' ); ?></a>
            </div>
        </div>
        <div class="WelcomePanel__column">
            <div class="welcome-panel-icon-layout"></div>
            <div class="WelcomePanel__column-content">
                <h3><?php _e( 'Start Creating' ); ?></h3>
                <p><?php _e( 'Explore your pre-configured block layouts.' ); ?></p>
                <a
                    href="<?php echo esc_url( admin_url( 'post-new.php?post_type=page' ) ); ?>"><?php _e( 'Add a new page' ); ?></a>
            </div>
        </div>
        <div class="WelcomePanel__column">
            <div class="welcome-panel-icon-styles"></div>
            <div class="WelcomePanel__column-content">
                <h3><?php _e( 'Need more guidance?' ); ?></h3>
                <p><?php _e( "We're more than happy to show you the ropes." ); ?></p>
                <a href="<?php echo esc_url( __( 'https://dirty-martini.com/#contact' ) ); ?>"
                    target="_blank"><?php _e( "Let's talk." ); ?></a>
            </div>
        </div>
    </div>
</div>
<?php
}

    add_action( 'welcome_panel', 'dm_welcome_panel' );
    
?>