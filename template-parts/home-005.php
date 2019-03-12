<?php
// Homepage 005: ### With Loop with ACF Fields

$args = array(
	'post_type' => 'post',
	'posts_per_page' => 4
);
$loop = new WP_Query( $args );
?>

<section class="section section-home">
	<div class="row">
		<div class="columns small-10 medium-5 large-6 small-centered section-home__content">

			<?php
			if ( $loop->have_posts() ) {
				$count = 0;
				while ( $loop->have_posts() ) : $loop->the_post();

					$acf = get_fields();
					$title = get_the_title();
					$image = ( has_post_thumbnail() ? get_the_post_thumbnail_url() : false );
					$excerpt = truncate_by_word(get_the_excerpt(), 240, '');
					$url = ( isset($acf['#####']) ? esc_url($acf['#####']) : false );
					?>

						<article class="article">

							<div class="article__featured-image">

								<?php if ($url): ?>
									<a href="<?php echo $url; ?>" target="_blank">
								<?php endif; ?>

								<?php
								if ( $image ) {
									echo '<div class="twobyone" style="background-image:url(' . esc_html( $image ) . ');"></div>';
								} else {
									echo '<div class="twobyone" style="background-image:url(' . get_template_directory_uri() . '/img/fallback.jpg);"></div>';
								}
								?>

								<?php if ($url): ?>
									</a>
								<?php endif; ?>

							</div>

							<div class="article__title-wrapper">

								<div class="equal">
									<?php if ($url): ?>
										<a href="<?php echo $url; ?>" target="_blank">
									<?php endif; ?>
									<h3 class="article__title"><?php echo $title; ?></h3>
									<?php if ($url): ?>
										</a>
									<?php endif; ?>
									<p class="article__paragraph"><?php echo $excerpt; ?></p>
								</div>

								<div class="article__featured-link">
									<a href="<?php echo $url; ?>">
										<i class="fa fa-arrow-right"></i>
										Read More
									</a>
								</div>

							</div>
						</article>

					<?php
					$count++;
				endwhile;
			}
			wp_reset_postdata();
			?>

		</div>
	</div>
</section>
