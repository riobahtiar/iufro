<?php /* Template Name: News */ ?>
<?php get_header(); ?>
<?php
	global $ss_theme_opt;
	global $post;

	//-----------PAGE HEADER-------------------
    if($ss_theme_opt['page-header-use-row-class']){
        $page_header_div_class = ' row';
    }

    if(isset($ss_theme_opt['page-header-background-color'])){
        $page_header_style = "background-color: ".$ss_theme_opt['page-header-background-color']."";
    }

    if(isset($ss_theme_opt['page-header-background']['url']) && $ss_theme_opt['page-header-background']['url'] != ''){
        $page_header_style = "background-image: url('".$ss_theme_opt['page-header-background']['url']."')";
    }

    if($ss_theme_opt['page-header-use-featured-image']){
        if(has_post_thumbnail()){
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
            $page_header_style = "background-image: url('".$image[0]."')";
        }
    }

    $page_header_custom_class = $ss_theme_opt['page-header-custom-class'];
    if($ss_theme_opt['page-header-overlay']){
        $page_header_custom_class .= ' overlay-bg';
    }
    if($ss_theme_opt['page-header-full-width']){
        $page_header_custom_class .= ' full-width';
    }


    //-----------PAGE FOOTER-------------------
    if($ss_theme_opt['page-footer-use-row-class']){
        $page_footer_div_class = ' row';
    }

    if(isset($ss_theme_opt['page-footer-background-color'])){
        $page_footer_style = "background-color: ".$ss_theme_opt['page-footer-background-color']."";
    }

    if(isset($ss_theme_opt['page-footer-background']['url']) && $ss_theme_opt['page-footer-background']['url'] != ''){
        $page_footer_style = "background-image: url('".$ss_theme_opt['page-footer-background']['url']."')";
    }

    $page_footer_custom_class = $ss_theme_opt['page-footer-custom-class'];
    if($ss_theme_opt['page-footer-overlay']){
        $page_footer_custom_class .= ' overlay-bg';
    }
    if($ss_theme_opt['page-footer-full-width']){
        $page_footer_custom_class .= ' full-width';
    }


    //---------SIDEBAR-----------------------
    $show_sidebar = true;

    //check if sidebar only show on certain page based on theme option
    if($ss_theme_opt['page-sidebar-page-id'] != ""){
        //get page list as array and remove empty space
        $str_page = str_replace(' ','',$ss_theme_opt['page-sidebar-page-id']);
        $arr_page = explode(',',$str_page); //convert to array

        if(!is_page($arr_page)){
            $show_sidebar = false;
        }
    }

    //---------CONTENT------------------------
    //prepare class for content
    $page_content_class = array();
    if(!empty($ss_theme_opt['page-content-custom-class'])){
        $page_content_class[] = $ss_theme_opt['page-content-custom-class'];
    }

    if($show_sidebar && is_active_sidebar( 'page-sidebar' ) ){
        $page_content_class[] = $ss_theme_opt['page-content-custom-class-sidebar-shown'];
    }

    $str_page_content_class = implode(' ',$page_content_class);

?>

<?php

	$args = array(
		'orderby' => 'date',
		'order' => 'DESC',
		'post_type' => 'post',
		'post_status' => 'publish',
		//'paged' => $paged,
		);
	$archivepost = new WP_Query( $args );
	?>

<div id="content" class="page">
	<div class="page-hero">
		<div class="container-custom">
			<h2 class="entry-title"><?php echo the_title(); ?></h2>
		</div>
		<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div id="page-content" class="page-recent">
			<?php if ($archivepost->have_posts()) : ?>
				<?php while ($archivepost->have_posts()) : $archivepost->the_post(); ?>
					<div class="post">
						<div class="col-md-12">
						<div class="col-md-3 news-thumbnail">
							<?php echo the_post_thumbnail('large') ?>
						</div>
						<div class="col-md-9 news-content">
							<div class="news-title">
								<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
							</div>
							<article class="entry">
								<div class="post-meta">
									<div class="left">
										<div class="category"><?php the_category(', ') ?> </div>
									</div>
									<div class="right">
										<div class="time left"><i class="fa fa-clock-o fa-fw"></i> <?php the_time('jS F, Y') ?> </div>
										<div class="like-post"><?php echo get_simple_likes_button( get_the_ID() ); ?></div>
										<div class="comments right"><i class="fa fa-comments fa-fw"></i> <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></div>
									</div>
									<div class="clear"></div>
								</div>
								<div class="excerpt">
									<?php
										iufro_excerpt('iufro_index','iufro_post_readmore');
									?>
								</div>
								<div class="clear"></div>
							</article>
						</div>
						</div>
					</div>

					<?php if ( is_active_sidebar( 'page-bottom' ) ) : ?>
						<div id="page-bottom" class="page-bottom-section <?php echo $ss_theme_opt['page-bottom-custom-class']; ?>" >
							<?php dynamic_sidebar( 'page-bottom' ); ?>
						</div>
					<?php endif; ?>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
			</div>
		</div>
	</div>

	<?php
		$popular_args = array(
			'posts_per_page' => 3,
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'post_type' => 'post',
			'meta_key' => 'wp_post_views_count',
			'post_status' => 'publish' );
		$popularpost = new WP_Query( $popular_args );
	?>
	<div class="container">
		<div class="page-popular-title center">
			<h2>Popular Post</h2>
		</div>
		<div id="popular-page-content" class="page-popular">
			<?php if ($popularpost->have_posts()) : ?>
				<div class="row">
				<?php while ($popularpost->have_posts()) : $popularpost->the_post(); ?>
						<div class="col-md-4 popular-entry">
							<div class="popular-thumbnail">
							<?php echo the_post_thumbnail('large') ?>
							</div>
							<div class="popular-title">
								<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
							</div>
							<div class="popular-excerpt">
								<?php //echo the_excerpt(); ?>
								<?php echo custom_excerpt(15); ?>
							</div>
						</div>
				<?php endwhile; ?>
				</div>
				<?php wp_reset_postdata(); ?>
			<?php endif; ?>
		</div>
	</div>
</div>


<?php get_footer(); ?>