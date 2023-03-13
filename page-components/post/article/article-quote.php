<?php $quote = get_sub_field('quote');?>

<?php if ($quote): ?>
<section class="ArticleQuote">
    <article class="ArticleQuote--inner">
        <blockquote>
            <h3 class='ArticleQuote__text'><?php echo $quote; ?>
            </h3>
        </blockquote>
    </article>
</section>
<?php endif; ?>