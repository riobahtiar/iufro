<?php get_header(); ?>
<?php 
    global $ss_theme_opt; 
    
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


    <?php if ( is_active_sidebar( 'page-header' ) ) { ?>
        <section id="section-page-header" class="theme-section <?php echo $page_header_custom_class; ?>" style="<?php echo $page_header_style; ?>" >
            <div class="container">
                <div id="page-header" class="header-wrapper<?php echo $page_header_div_class; ?>">
                    <?php dynamic_sidebar( 'page-header' ); ?>
                </div>
            </div>
        </section>
    <?php } ?>



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

                    <?php if(isset($ss_theme_opt['page-not-found-title']) && $ss_theme_opt['page-not-found-title'] != ''){ ?>
                        <div id="post-<?php the_ID(); ?>" class="page page-not-found"> 
                            <h2 class="entry-title"><?php echo $ss_theme_opt['page-not-found-title']; ?></h2>
                        </div>
                    <?php }else{ ?>
                        <div class="page page-not-found"> 
                            <h2 class="entry-title">Oops! That page can&rsquo;t be found.</h2>
                        </div>
                    <?php } ?>

                    <?php if(isset($ss_theme_opt['page-not-found-image']['url']) && $ss_theme_opt['page-not-found-image']['url'] != ''){ ?>
                        <div class="post-thumbnail">
                            <img src="<?php echo $ss_theme_opt['page-not-found-image']['url']; ?>">
                        </div>
                    <?php } ?>

                    <?php if(isset($ss_theme_opt['page-not-found-text']) && $ss_theme_opt['page-not-found-text'] != ''){ ?>
                        <div class="entry">
                            <?php echo $ss_theme_opt['page-not-found-text']; ?>
                        </div>
                    <?php }else{ ?>
                        <div class="entry">
                            It looks like nothing was found at this location.
                        </div>
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

    <?php if ( is_active_sidebar( 'page-footer' ) ) { ?>
        <section id="section-page-footer" class="theme-section <?php echo $page_footer_custom_class; ?>" style="<?php echo $page_footer_style; ?>" >
            <div class="container">
                <div id="page-footer" class="footer-wrapper<?php echo $page_footer_div_class; ?>">
                    <?php dynamic_sidebar( 'page-footer' ); ?>
                </div>
            </div>
        </section>
    <?php } ?>
        
<?php get_footer(); ?>