<?php if( have_rows('archive_hero') ): ?>
<div class="ArchiveHero">
    <?php while( have_rows('archive_hero') ) : the_row(); 
        $title = get_sub_field('title');
        $desc = get_sub_field('description');
        $link = get_sub_field('button');
        $subtitle = get_sub_field('subtitle');
    ?>
    <div class="ArchiveHero--inner container">
        <?php if( $title ):?>
        <h1 class="ArchiveHero__title"><?php echo $title; ?></h1>
        <?php endif; ?>

        <?php if( $desc ):?>
        <h4 class="ArchiveHero__desc"><?php echo $desc; ?></h4>
        <?php endif; ?>

        <?php if ($link):                    
            $link_url = $link['url'];
            $link_title = $link['title'];
            $link_target = $link['target'] ? $link['target'] : '_self';
            ?>
        <a class="btn--main ArchiveHero__btn" href="<?php echo esc_url( $link_url ); ?>"
            target="<?php echo esc_attr( $link_target ); ?>">
            <?php echo esc_html( $link_title ); ?>
        </a>
        <?php endif; ?>

        <div class="ArchiveHero__underline">
            <p class="ArchiveHero__underline-text"><?php echo $subtitle; ?></p>
            <div class="underline">
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>
<?php endif; ?>