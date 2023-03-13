<?php // cookie variables 
$speed = get_field('cookie_policy_range', 'option');
$text = get_field('cookie_policy_notice', 'option')
?>

<div class="js-cookie-policy CookiePolicy" data-duration="<?php echo $speed; ?>">
    <?php if ($text): ?>
    <div class="CookiePolicy__text-group">
        <p class="CookiePolicy__text"><?php echo $text; ?></p>
    </div>
    <?php endif; ?>

    <div class="CookiePolicy__button">
        <button class="btn--block js-button"><?php echo esc_html('Ok!'); ?></button>
    </div>
</div>