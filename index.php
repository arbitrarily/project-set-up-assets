<?php
// Home
get_header();
?>

	<main role="main" aria-label="Content">

		<?php

		// Section One
		get_template_part( 'template-parts/home', '001' );

		// Section Two
		get_template_part( 'template-parts/home', '002' );

		// Section Three
		get_template_part( 'template-parts/home', '003' );

		// Section Four
		get_template_part( 'template-parts/home', '004' );

		// Section Five
		get_template_part( 'template-parts/home', '005' );

		?>

	</main>

<?php
get_footer();
?>
