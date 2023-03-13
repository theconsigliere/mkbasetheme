<?php
$mailchimp = get_field('mailchimp_code', 'option');
if ($mailchimp) : 

    $title = get_field('title', 'option');
    $desc = get_field('description', 'option');
    $code =  get_field('mailchimp_code', 'option'); 

?>
<section class="footer__mailchimp">
    <div class="footer__mailchimp--inner">
        <div class="footer__mailchimp__title-group">
            <?php if ($title): ?>
            <h4 class='footer__mailchimp__title'><?php echo $title; ?></h4>
            <?php endif; ?>
            <?php if ($desc): ?>
            <p class='footer__mailchimp__desc'><?php echo $desc; ?></p>
            <?php endif; ?>
        </div>
        <?php if ($code): ?>
        <div class="footer__mailchimp__code">
            <?php echo $code; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>