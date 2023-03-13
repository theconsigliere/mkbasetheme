<?php $width = get_field('header_width', 'option'); ?>
<div class='Header__inner' style='--header-width:<?php echo $width . '%'; ?>'>
    <?php if (have_rows('header_layouts', 'option')) :
		while (have_rows('header_layouts', 'option')) : the_row();
		
			// Logo Left
			if (get_row_layout() == 'logo_left'):
				get_template_part('page-components/header/layouts/logo', 'left');
			// Logo Middle
			elseif (get_row_layout() == 'logo_middle'):
				get_template_part('page-components/header/layouts/logo', 'middle');
			// Mega Menu
			elseif (get_row_layout() == 'mega_menu'):
				get_template_part('page-components/header/layouts/mega', 'menu');

			else :
				get_template_part('page-components/header/layouts/header', 'default');
			endif;
	endwhile;

	else:
		get_template_part('page-components/header/layouts/header', 'default');
	endif; ?>
</div>