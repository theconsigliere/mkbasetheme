<?php 
$title = get_sub_field('title');
$desc = get_sub_field('description'); ?>

<aside class="ArticleTip">
    <div class="ArticleTip__svg">
        <?php echo load_inline_svg('article-tip.svg'); ?>
    </div>
    <?php if ($title): ?>
    <h4 class="ArticleTip__title">
        <?php echo $title; ?>
    </h4>
    <?php endif; ?>

    <?php if ($desc): ?>
    <p class="ArticleTip__desc">
        <?php echo $desc; ?>
    </p>
    <?php endif; ?>
</aside>