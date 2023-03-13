<?php
$logo = get_field('modal_logo', 'option');
$title = get_field('modal_title', 'option');
$desc = get_field('modal_desc', 'option');
$link = get_field('modal_button', 'option');
$modalTime = get_field('show_modal', 'option');
?>

<div class="Modal js-hide js-main-modal" data-duration="<?php echo $modalTime; ?>">
    <div class="Modal__inner js-modal">
        <div class="Modal__close js-close">
            <?php echo load_inline_svg('close.svg'); ?>
        </div>

        <?php if (!empty($logo)) : ?>
        <div class="Modal__logo">
            <?php echo ( wp_get_attachment_image($logo, 'full', '', array('loading' => 'eager')) ); ?>
        </div>
        <?php endif; ?>

        <?php if( $title ):  ?>
        <h2 class="Modal__title"><?php echo $title; ?></h2>
        <?php endif; ?>

        <?php if( $desc ):  ?>
        <p class="Modal__desc"><?php echo $desc; ?></p>
        <?php endif; ?>

        <?php if( $link ): 
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self'; ?>

        <a class="btn--main" href="<?php echo esc_url( $link_url ); ?>"
            target="<?php echo esc_attr( $link_target ); ?>">
            <?php echo esc_html( $link_title ); ?>
        </a>

        <?php endif; ?>
    </div>
</div>