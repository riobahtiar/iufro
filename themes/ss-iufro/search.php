<?php
/**
 * The template for displaying search results pages.
 */

get_header(); ?>

<?php 
    global $ss_theme_opt; 
    
    $show_sidebar = true;

    //check if sidebar only show on certain page based on theme option
    if($ss_theme_opt['page-sidebar-page-id'] != ""){
        if(!is_page(array($ss_theme_opt['page-sidebar-page-id']))){
            $show_sidebar = false;
        }
    }

    //prepare class for content
    $page_content_class = array();
    if(!empty($ss_theme_opt['page-content-custom-class'])){
        $page_content_class[] = $ss_theme_opt['page-content-custom-class'];
    }
    
    if($show_sidebar){
        $page_content_class[] = $ss_theme_opt['page-content-custom-class-sidebar-shown'];
    }

    $str_page_content_class = implode(' ',$page_content_class);

?>
    
    <div id="content" class="page">

        <div class="container">

            <div class="row">

                <?php if($ss_theme_opt['page-sidebar-position'] == 'left'){ ?>
                    <?php if ( $show_sidebar && is_active_sidebar( 'page-sidebar' ) ) { ?>
                        <div id="page-sidebar" class="sidebar <?php echo $ss_theme_opt['page-sidebar-custom-class']; ?>">
                            <?php dynamic_sidebar( 'page-sidebar' ); ?>
                        </div>
                    <?php } ?>
                <?php } ?>


                <div id="page-content" class="<?php echo $str_page_content_class; ?>">
                    
                    <header class="page-header">
						<h1 class="page-title"><?php printf( 'Search Results for: %s', get_search_query() ); ?></h1>
					</header>
                    
                    <?php if (have_posts() && $_GET['s'] != "") { ?>
                    	
                        <?php while (have_posts()) : the_post(); ?>

                            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>            

                                <div class="row">
                                    <?php $str_class_entry = "col-md-12"; ?>

                                    <?php if( $ss_theme_opt['search-image'] != 'no' && has_post_thumbnail() ){ ?>
                                        <?php $str_class_entry = "col-md-9"; ?>

                                        <div class="post-thumbnail col-md-3">
                                            <?php the_post_thumbnail($ss_theme_opt['search-image']); ?>
                                        </div>
                                    <?php } ?>

                                    <div class="<?php echo $str_class_entry; ?>">
                                        <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                                        <div class="entry">
                                            <?php the_excerpt(); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        
                        <?php endwhile; ?>
                        
                        <?php 
                        	// Previous/next page navigation.
							the_posts_pagination( array(
								'prev_text'          => 'Previous',
								'next_text'          => 'Next',
								'screen_reader_text' => ' '
							) );
                        ?>

                    <?php }else{ ?>

                    	<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'twentyfifteen' ); ?></p>
						<br/>
                        <?php //get_search_form(); ?>

                    <?php } ?>

                </div>


                <?php if($ss_theme_opt['page-sidebar-position'] != 'left'){ ?>
                    <?php if ( $show_sidebar && is_active_sidebar( 'page-sidebar' ) ) { ?>
                        <div id="page-sidebar" class="sidebar <?php echo $ss_theme_opt['page-sidebar-custom-class']; ?>">
                            <?php dynamic_sidebar( 'page-sidebar' ); ?>
                        </div>
                    <?php } ?>
                <?php } ?>

            </div>

        </div>

    </div>
        
<?php get_footer(); ?>
