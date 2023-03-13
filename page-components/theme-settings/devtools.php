<?php 
$preloaderActivated = get_field('loading_activate', 'option');	
$preloaderHomepage = get_field('show_on_homepage', 'option');		
$modal = get_field('activate_modal', 'option');	
?>

<div class="DevTools js-devtools">
    <details class="DevTools__inner">
        <summary class='DevTools__title'><?php echo esc_html( 'DM Dev Tools' ); ?></summary>

        <div class="DevTools__item">
            <?php echo esc_html( 'Grid:' ); ?>
            <label class="DevTools__switch">
                <input id='griddevtools' class='js-grid-selector DevTools__switch--input' type="checkbox">
                <span class="DevTools__switch--slider"></span>
            </label>
        </div>


        <?php // PRE-LOADER 

        // check the selection
        if($preloaderActivated == 'show') { 
            if($preloaderHomepage == 'show') { ?>

        <?php if ( is_front_page() ) : ?>
        <div class="DevTools__item">
            <?php echo esc_html( 'Preloader:' ); ?>
            <label class="DevTools__switch">
                <input class='js-preloader-selector DevTools__switch--input' type="checkbox">
                <span class="DevTools__switch--slider"></span>
            </label>
        </div>
        <?php endif; ?>

        <?php  } elseif ($preloaderHomepage == 'hide') { ?>
        <div class="DevTools__item">
            <?php echo esc_html( 'Preloader:' ); ?>
            <label class="DevTools__switch">
                <input class='js-preloader-selector DevTools__switch--input' type="checkbox">
                <span class="DevTools__switch--slider"></span>
            </label>
        </div>
        <?php } else { } ?>
        <?php  } ?>

        <?php // Modal only shows on homepage
        if(is_front_page()) {	
        if($modal == 'show') : ?>
        <div class="DevTools__item">
            <?php echo esc_html( 'Modal:' ); ?>
            <label class="DevTools__switch">
                <input class='js-modal-selector DevTools__switch--input' type="checkbox">
                <span class="DevTools__switch--slider"></span>
            </label>
        </div>
        <?php endif; ?>
        <?php } ?>

        <div class="DevTools__admin">
            <a href="/wp-admin" class="DevTools__admin-link">
                <span class="DevTools__icon">
                    <?php echo load_inline_svg('dashboard.svg'); ?>
                </span>
                <?php echo esc_html( 'Dashboard' ); ?>
            </a>
        </div>
    </details>
</div>

<div class="DevTools__grid js-grid">
    <div class="DevTools__grid--inner">
        <div class="DevTools__grid-column DevTools__grid-column--mobile"></div>
        <div class="DevTools__grid-column DevTools__grid-column--mobile"></div>
        <div class="DevTools__grid-column DevTools__grid-column--mobile"></div>
        <div class="DevTools__grid-column DevTools__grid-column--mobile"></div>
        <div class="DevTools__grid-column DevTools__grid-column--tablet"></div>
        <div class="DevTools__grid-column DevTools__grid-column--tablet"></div>
        <div class="DevTools__grid-column DevTools__grid-column--desktop"></div>
        <div class="DevTools__grid-column DevTools__grid-column--desktop"></div>
        <div class="DevTools__grid-column DevTools__grid-column--desktop"></div>
        <div class="DevTools__grid-column DevTools__grid-column--desktop"></div>
        <div class="DevTools__grid-column DevTools__grid-column--bg-desktop"></div>
        <div class="DevTools__grid-column DevTools__grid-column--bg-desktop"></div>
    </div>
</div>