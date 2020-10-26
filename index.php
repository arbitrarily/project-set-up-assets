<?php
// Home
get_header();
?>

	<main role="main" aria-label="Content">

		<?php

		// Section One
		get_template_part( 'template-parts/home', 'intro' );

		// Section Two
		get_template_part( 'template-parts/home', 'mission' );

		// Section Three
		get_template_part( 'template-parts/home', 'about' );

		// Section Four
		get_template_part( 'template-parts/home', 'features' );

		// Section Five
		get_template_part( 'template-parts/home', 'loop' );

		?>

	</main>

<?php
get_footer();
?>
