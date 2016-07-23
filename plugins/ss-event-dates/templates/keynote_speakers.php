<?php if (isset($_GET['speaker'])): ?>
<?php

	$speaker_id = $_GET['speaker'];

	$speaker = get_post($speaker_id,ARRAY_A);

?>
	<div class="container">
		<div class="col-md-12 keynote-speaker-detail">
			<div class="row">
			<div class="col-md-4">
				<?php echo get_the_post_thumbnail($speaker_id); ?>
			</div>
			<div class="col-md-8">
					<div class="row">
				<div class="name col-md-8">
					<h4><?php echo $speaker['post_title'];?></h4>
					<h5><?php echo get_post_meta($speaker_id, 'rw_company', true );?></h5>
				</div>
				<div class="social-media col-md-4">
					<?php if ($facebook = get_post_meta($speaker_id, 'rw_facebook', true )){?>
						<a href="<?php echo $facebook; ?>" target="_blank">
								<span class="fa-stack">
								<i class="fa fa-circle fa-stack-2x"></i>
  							<i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
							</span></i></a>
					<?php } ?>
					<?php if ($twitter = get_post_meta($speaker_id, 'rw_twitter', true )){?>
						<a href="<?php echo $twitter; ?>" target="_blank">
							<span class="fa-stack">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
						</span></i></a>
					<?php } ?>
					<?php if ($linkedin = get_post_meta($speaker_id, 'rw_linkedin', true )){?>
						<a href="<?php echo $linkedin; ?>" target="_blank">
							<span class="fa-stack">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
						</span></i></a>
					<?php } ?>
				</div>
				<!-- <hr class="col-md-12"> -->
				<div class="detail col-md-12">
					<p>
					<?php echo $speaker['post_content'];?>
				</p>
				</div>
			</div>
</div>
		</div>
	</div>
		<div class="nav-keynote-speaker col-md-12">
			<div class="row">
			<?php

				function get_previous_post_id( $post_id ) {

			    	global $post;

		  	    	$oldGlobal = $post;
  			    	$post = get_post( $post_id );
  			    	$previous_post = get_previous_post();
		  	    	$post = $oldGlobal;

			    	if ( '' == $previous_post )
			        	return 0;

			    	return $previous_post->ID;

				}

				function get_next_post_id( $post_id ) {

			    	global $post;

		  	    	$oldGlobal = $post;
  			    	$post = get_post( $post_id );
  			    	$next_post = get_next_post();
		  	    	$post = $oldGlobal;

			    	if ( '' == $next_post )
			        	return 0;

			    	return $next_post->ID;
				}

			$current_url = explode('?', $_SERVER['REQUEST_URI'], 2);
			$prev = get_previous_post_id($speaker_id);
			$next = get_next_post_id($speaker_id);

			?>
			<?php if($prev){?>
				<div class="pull-left"><a href="?speaker=<?php echo $prev;?>"> << Previous speaker</a></div>
			<?php }?>
			<?php if($next){?>
				<div class="pull-right"><a href="?speaker=<?php echo $next;?>"> Next speaker >> </a></div>
			<?php }?>
		</div>
	</div>
	</div>
<?php else: ?>
	<?php

		wp_reset_query();

	    wp_reset_postdata();

	    $custom_args = array(
	        'post_type' => 'keynote_speakers',
	        'posts_per_page' => 4,
	        'order' => 'ASC',
	        'cat'=>'-26,-27,-35',
	    );

	?>

	<?php $custom_query = new WP_Query( $custom_args ); ?>
	<?php if ( $custom_query->have_posts() ) : ?>
		<?php while ( $custom_query->have_posts() ) : $custom_query->the_post();?>
			<div class="keynote_speaker <?php echo $post->ID; ?> col-md-4">
				<div class="thumbnail_photo"><?php the_post_thumbnail(); ?></div>
				<div class="detail">
					<div class="name"><?php the_title(); ?></div>
					<div class="company"><?php echo get_post_meta( get_the_ID(), 'rw_company', true ); ?></div>
				</div>
				<?php $current_url = $_SERVER["REQUEST_URI"]; ?>
				<div class="more_detail"> <a href="<?php echo $current_url; ?>?speaker=<?php echo get_the_ID(); ?>">View Profile</a></div>
			</div>
		<?php endwhile; ?>
	<?php endif; ?>
<?php endif;?>
