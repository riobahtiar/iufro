
<?php
	wp_reset_query();
	wp_reset_postdata();

	$custom_args = array(
	    'post_type' => 'presenter',
	    'posts_per_page' => 10,
	    'order' => 'DESC',
	    'category_name'=>'1',
	);
?>

<?php $custom_query = new WP_Query( $custom_args ); ?>
<?php if ( $custom_query->have_posts() ) : ?>
	<div class="container">
	<?php while ( $custom_query->have_posts() ) : $custom_query->the_post();?>	
			<div class="col-md-12 presenter-detail">
				<div class="content-wrap">
					<div class="col-md-4 thumbnail">
						<?php echo get_the_post_thumbnail(get_the_ID()); ?>
					</div>
					<div class="col-md-8 content">
							<div class="name col-md-8">
								<h4><?php echo the_title() ?></h4>
								<h5><?php echo get_post_meta(get_the_ID(), 'rw_position', true );?></h5>
							</div>
							<div class="social-media col-md-4">
								<?php if ($facebook = get_post_meta(get_the_ID(), 'rw_facebook', true )){?>
										<a href="<?php echo $facebook; ?>" target="_blank">
											<span class="fa-stack">
												<i class="fa fa-circle fa-stack-2x"></i>
												<i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
											</span></i></a>
								<?php } ?>
								<?php if ($twitter = get_post_meta(get_the_ID(), 'rw_twitter', true )){?>
										<a href="<?php echo $twitter; ?>" target="_blank">
											<span class="fa-stack">
												<i class="fa fa-circle fa-stack-2x"></i>
												<i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
											</span></i></a>
								<?php } ?>
								<?php if ($linkedin = get_post_meta(get_the_ID(), 'rw_linkedin', true )){?>
										<a href="<?php echo $linkedin; ?>" target="_blank">
											<span class="fa-stack">
												<i class="fa fa-circle fa-stack-2x"></i>
												<i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
											</span></i></a>
								<?php } ?>
							</div>
										
							<!-- <hr class="col-md-12"> -->
							<div class="detail col-md-12">
								<?php echo the_content() ?>
							</div>
					</div>
				</div>
			</div>	
	<?php endwhile; ?>
	</div>	
<?php endif; ?>


