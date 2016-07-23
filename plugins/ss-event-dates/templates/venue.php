	<?php

	wp_reset_query();
    wp_reset_postdata();

    $custom_args = array(
        'post_type' => 'venue',
        'posts_per_page' => 4,
        'order' => 'DESC',
        'cat'=>'-26,-27,-35',
    );

	?>

	<?php $custom_query = new WP_Query( $custom_args ); ?>
	<?php if ( $custom_query->have_posts() ) : ?>
		<div class="container ">
		<?php while ( $custom_query->have_posts() ) : $custom_query->the_post();?>
			<div class="col-md-12 venue-item">
				<div class="col-md-12 text-center title">
					<?php echo the_title() ?>
				</div>
				<div class="content-wrap">
					<div class="col-md-3 thumbnail">
						<?php echo the_post_thumbnail('medium') ?>
					</div>
					<div class="col-md-9 content">
						<?php echo the_content() ?>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
		</div>
	<?php endif; ?>