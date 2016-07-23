
<?php
	wp_reset_query();
	wp_reset_postdata();

	$custom_args = array(
	    'post_type' => 'ss_paper',
	    'posts_per_page' => 3,
		'order_by' => 'ID',
	    'order' => 'DESC',
	    'cat'=>'-26,-27,-35',
	);
?>

<?php $custom_query = new WP_Query( $custom_args ); ?>
<?php if ( $custom_query->have_posts() ) : ?>
	<div class="container">
		<div class="row">
			<?php while ( $custom_query->have_posts() ) : $custom_query->the_post();?>
				<div class="col-md-4 ss-paper-detail">
					<div class="content-wrap">
						<div class="col-md-12 thumbnail">
							<?php echo get_the_post_thumbnail(get_the_ID()); ?>
						</div>
						<div class="col-md-12 content">
							<h4><a href="<?php echo the_permalink() ?>"><?php echo the_title() ?></a></h4>
							<span>By <?php echo get_post_meta(get_the_ID(), 'rw_paper_author', true );?></span>
						</div>

						<div class="detail-pdf col-md-12">
							<?php
								$id_file = get_post_meta(get_the_ID(), 'rw_paper_pdf_file', true );
							?>
							<div class="text-left">
								<span class="pfd-viewer-<?php echo get_the_ID(); ?>">
									<a class="btn btn-default" onclick="popupCenter('<?php echo wp_get_attachment_url( $id_file ) ?>', 'myPop1',800,600);" href="javascript:void(0);" >Pdf Viewer</a>
								</span>
							</div>

							<div class="text-right">

								<a class="pfd-download-<?php echo get_the_ID(); ?>" target="_blank" href="<?php echo wp_get_attachment_url( $id_file );?>"><i class="fa fa-download" aria-hidden="true"></i></a>
								<span class="comment"><i class="fa fa-comment-o" aria-hidden="true"></i></span>

							</div>

						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
<?php endif; ?>


<script>
function popupCenter(url, title, w, h) {
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}
</script>