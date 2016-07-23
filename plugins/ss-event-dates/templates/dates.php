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
		        		echo '  <h4>'.date("F Y", strtotime( get_post_meta( get_the_ID(), 'rw_date', true ) )).'</h4>';
			        	echo '  <h2> - </h2>';
			        	echo '  <h2 class="date-day">'.date("d", strtotime( get_post_meta( get_the_ID(), 'rw_date_end', true ) )).'<span>'.date("S", strtotime( get_post_meta( get_the_ID(), 'rw_date_end', true ) )).'</span></h2>';
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

	$rundown_terms = get_terms('ss_event_rundown_category');

	foreach($rundown_terms as $custom_term): ?>
		<?php
			wp_reset_query();
			$args = array('post_type' => 'event_rundown',
				'tax_query' => array(
					array(
						'taxonomy' => 'ss_event_rundown_category',
						'field' => 'slug',
						'terms' => $custom_term->slug,
					),
				),
				'orderby' => 'modified',
				'order' => 'ASC',
				'posts_per_page'=> -1
			 );

			 $loop = new WP_Query($args);

		?>

		<?php if($loop->have_posts()) : ?>
			<div class="container">
				<div class="row rundown-item">
					<div class="col-md-12 text-center title">
						<?php echo $custom_term->name ?>
					</div>
					<div class="col-md-12 text-center date">
						<?php
							echo '  <h3 class="date-day">'.date("d", strtotime( $custom_term->description )).'<span>'.date("S", strtotime( $custom_term->description )).'</span></h3>';
							echo '  <h3>'.date("F Y", strtotime( $custom_term->description )).'</h3>';

						?>
					</div>
					<div class="content-wrap">
						<div class="col-md-3 time">
							<ul class="nav nav-pills nav-stacked" role="tablist">
								<?php	$i = 1;
										while($loop->have_posts()) : $loop->the_post();  ?>

								<li role="presentation"<?php echo ( $i == 1 ? ' class="active"' : '') ?>><a href="#date-<?php echo get_the_ID() ?>" aria-controls="date-<?php echo get_the_ID() ?>" role="tab" data-toggle="pill">							<?php
																  echo '<p>'.
																  get_post_meta( get_the_ID(), 'rw_event_start', true )." - ".
																  get_post_meta( get_the_ID(), 'rw_event_end', true )
																  .' IWST</p>';  ?></a>
										</li>

								<?php
									$i++;
									endwhile;
								?>
							</ul>
						</div>

						<div class="col-md-9">
							<div class="col-md-12 time">

							</div>
							<div class="col-md-12 content">
								<div class="tab-content">
									<?php
										$i = 1;
										while($loop->have_posts()) : $loop->the_post();  ?>

											<div role="tabpanel" class="tab-pane <?php echo ( $i == 1 ? 'active' : '') ?>" id="date-<?php echo get_the_ID() ?>"><?php echo the_content(); ?></div>

									<?php
										$i++;
										endwhile;
									?>

								 </div>
							</div>
						</div>
					</div>

				</div>
			</div>
		<?php endif; ?>
	<?php endforeach;?>

</div>
