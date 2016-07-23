<div clas="container">
	<div class="title pre-event col-md-12 text-center">
		<h2>Pre-Event Important Dates</h2>
	</div>
	<?php

	wp_reset_query();
    wp_reset_postdata();

    $custom_args = array(
        'post_type' => 'important_dates',
        'posts_per_page' => 4,
        'order' => 'ASC',
        'cat'=>'-26,-27,-35',
    );

	?>

	<?php $custom_query = new WP_Query( $custom_args ); ?>
	<?php if ( $custom_query->have_posts() ) : ?>
		<div class="container ">
		<?php while ( $custom_query->have_posts() ) : $custom_query->the_post();?>
			<div class="col-md-12 pre-event-item">
				<div class="col-md-12 text-center title">
					<?php echo the_title() ?>
				</div>
				<div class="content-wrap">
					<div class="col-md-3 dates">
					<?php
						echo '  <h2 class="date-day">'.date("d", strtotime( get_post_meta( get_the_ID(), 'rw_date', true ) )).'<span>'.date("S", strtotime( get_post_meta( get_the_ID(), 'rw_date', true ) )).'</span></h2>';
			        	if ((get_post_meta( get_the_ID(), 'rw_date_end', true ))){
		        		echo '  <h4>'.date("F", strtotime( get_post_meta( get_the_ID(), 'rw_date', true ) )).'</h4>';
			        	echo '  <h2> - </h2>';
			        	echo '  <h2 class="date-day">'.date("d", strtotime( get_post_meta( get_the_ID(), 'rw_date', true ) )).'<span>'.date("S", strtotime( get_post_meta( get_the_ID(), 'rw_date', true ) )).'</span></h2>';
			        	echo '  <h4>'.date("F Y", strtotime( get_post_meta( get_the_ID(), 'rw_date_end', true ) )).'</h4>';
			        	} else {
			        	echo '  <h4>'.date("F Y", strtotime( get_post_meta( get_the_ID(), 'rw_date', true ) )).'</h4>';
			        	}
		        	?>
					</div>
					<div class="col-md-9 content">
						<?php echo the_content() ?>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
		</div>
	<?php endif; ?>
	</div>
</div>

<div clas="container">
	<div class="title pre-event col-md-12 text-center">
		<h2>Event Rundown</h2>
	</div>
	<?php

	wp_reset_query();
    wp_reset_postdata();

    $custom_args = array(
        'post_type' => 'event_rundown',

        // 'orderby'='title',
        'order' => 'ASC',
        'cat'=>'-26,-27,-35',
    );

	?>

	<?php $custom_query = new WP_Query( $custom_args ); ?>
	<?php if ( $custom_query->have_posts() ) : ?>
		<div class="container">
		<?php while ( $custom_query->have_posts() ) : $custom_query->the_post();?>
			<div class="col-md-12 rundown-item">
				<div class="col-md-12 text-center title">
					<?php echo the_title() ?>
				</div>
				<div class="content-wrap">
					<div class="col-md-3 dates">
					<?php
						echo '  <h2 class="date-day">'.date("d", strtotime( get_post_meta( get_the_ID(), 'rw_date', true ) )).'<span>'.date("S", strtotime( get_post_meta( get_the_ID(), 'rw_date', true ) )).'</span></h2>';
		        		echo '  <h4>'.date("F Y", strtotime( get_post_meta( get_the_ID(), 'rw_event_date', true ) )).'</h4>';

		        	?>
					</div>
					<div class="col-md-9">
						<div class="col-md-12 time">
							<?php
								echo '<p>'.
								get_post_meta( get_the_ID(), 'rw_event_start', true )." - ".
								get_post_meta( get_the_ID(), 'rw_event_end', true )
								.' IWST</p>';  ?>
						</div>
						<div class="col-md-12 content">
							<?php echo the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
		</div>
	<?php endif; ?>
	</div>
</div>
