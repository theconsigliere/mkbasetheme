<?php 
    $text = get_sub_field('article_text');
    ?>

<?php if ($text): ?>
<div class="ArticleText">
    <p itemprop="articleBody" class='ArticleText__desc'><?php echo $text; ?></p>
</div>
<?php endif; ?>