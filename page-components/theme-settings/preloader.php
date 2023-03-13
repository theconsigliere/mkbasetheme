<div class="Preloader js-preloader">
    <div class="Preloader__inner">
        <?php $logo = get_field('loading_logo', 'option');
        
            if (!empty($logo)) :
                echo ( wp_get_attachment_image($logo, 'full', '', array('loading' => 'eager')) );
            endif; ?>

        <svg class='Preloader__circle' viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <circle cx="50" cy="50" r="50" />
        </svg>

        <div class="Preloader__text">
            <span class="Preloader__number js-text">0</span>
            <span class="Preloader__unit">%</span>
        </div>
    </div>
</div>