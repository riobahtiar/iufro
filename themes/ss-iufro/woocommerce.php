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



    <div id="content" class="page woocommerce">

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
                    
                    <?php woocommerce_content(); ?>

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