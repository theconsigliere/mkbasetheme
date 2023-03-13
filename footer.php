                    <!-- </main>
                    </section> -->

                    </section>

                    <?php // footer variables
                    $mailchimp = get_field('show_mailchimp_section', 'option');		
                    $footernotices = get_field('show_footer_notices', 'option');
                    $noticeColour = get_field('notice_background_colour', 'option');
                    $width = get_field('footer_width', 'option')
                    ?>

                    <?php // FOOTER Mailchimp
                    if( $mailchimp == 'show' ) { ?>
                    <?php get_template_part( 'page-components/footer/footer-mailchimp' ); ?>
                    <?php   } ?>


                    <?php // FOOTER NOTICES
                    if($footernotices == 'yes') { ?>
                    <div class="footer__notices" style='background-color:<?php echo $noticeColour; ?>'>
                        <?php get_template_part( 'page-components/footer/footer-notices' ); ?>
                    </div>
                    <?php } ?>


                    <footer id="footer" class="footer" role="contentinfo" itemscope
                        itemtype="https://schema.org/WPFooter">
                        <div class="footer__inner" style='width:<?php echo $width; ?>%'>
                            <?php //Footer Main 
                            get_template_part( 'page-components/footer/footer-main' ); ?>

                            <?php // Footer Bottom  
                            get_template_part( 'page-components/footer/footer-bottom' ); ?>

                        </div>
                    </footer>

                    </div>


                    <?php // all js scripts are loaded in library/functions.php ?>

                    <?php wp_footer(); ?>

                    </div>
                    </div><?php // smooth content ?>
                    </div> <?php // smoth wrapper ?>
                    </body>

                    </html> <!-- This is the end. My only friend. -->