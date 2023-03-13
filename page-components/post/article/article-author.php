<?php if( have_rows('author_section') ):  ?>
<div class="ArticleAuthor">
    <?php while( have_rows('author_section') ): the_row();             
    $text = get_sub_field('written_by_title'); 
    ?>

    <div class="ArticleAuthor--inner">
        <div class="ArticleAuthor__single-image-group">
            <?php if( have_rows('add_an_author') ): ?>
            <div class="ArticleAuthor__image-group">
                <?php while( have_rows('add_an_author') ): the_row(); 
                         $image = get_sub_field('author_image'); ?>

                <?php echo wp_get_attachment_image($image, 'full', '', array('loading' => 'lazy', 'class' => 'ArticleAuthor__image')); ?>
                <?php endwhile; ?>
            </div>

            <?php endif; ?>

            <?php $count = count(get_sub_field('add_an_author'));

            if( have_rows('add_an_author') ):  $counter = 0; ?>
            <div class="ArticleAuthor__details">

                <?php if ($text):?>
                <h6 class="ArticleAuthor__written-by"><?php echo $text; ?></h6>
                <?php endif; ?>

                <p class="ArticleAuthor__authors">
                    <?php echo esc_html('By '); ?>

                    <?php while( have_rows('add_an_author') ): the_row(); 
                         $name = get_sub_field('author_name'); ?>

                    <?php if ($name): ?>
                    <span class="ArticleAuthor__single-author">
                        <?php echo $name; ?>
                    </span>
                    <?php endif; ?>

                    <?php $counter++; ?>

                    <?php if ($counter < $count): ?>
                    <?php echo esc_html('& '); ?>
                    <?php endif; ?>

                    <?php endwhile; ?>
                </p>
            </div>
            <?php endif; ?>
        </div>


        <div class="ArticleAuthor__buttons">
            <?php 
                
                $link = get_field('link_to_archive_page', 'option'); 
                if ($link): 
                   
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>
            <a class="ArticleAuthor__btn btn--main" href="<?php echo esc_url( $link_url ); ?>"
                target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
            <?php endif; 
                
                
                $permalink = get_permalink();
                $find = array( 'http://', 'https://' );
                $replace = '';
                $output = str_replace( $find, $replace, $permalink );
                
                ?>

            <a class="ArticleAuthor__btn btn--block"
                href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $output; ?>" target="new">Share
                on Linkedin</a>

        </div>

    </div>
    <?php endwhile; ?>
</div>
<?php endif; ?>