<?php

	wp_reset_query();

    wp_reset_postdata();

    $custom_args = array(
        'post_type' => 'programme',
        'posts_per_page' => 4,
		'order_by' => 'ID',
        'order' => 'ASC',
        'cat'=>'-26,-27,-35',
    );

	?>

	<?php $custom_query = new WP_Query( $custom_args ); ?>
	<?php if ( $custom_query->have_posts() ) : ?>
		<div class="container">
		<?php while ( $custom_query->have_posts() ) : $custom_query->the_post();?>
			<div class="col-md-12 text-center programme-head green">
				<h3><?php echo the_title() ?></h3>
			</div>
			<div class="col-md-12 programme-body">
				<?php echo the_content() ?>
			</div>
		<?php endwhile; ?>
		</div>
	<?php endif; ?>