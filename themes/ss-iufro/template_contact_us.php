<?php /* Template Name: Contact Us */ ?>
<?php get_header(); ?>
<?php 
    global $ss_theme_opt; 
    
    //-----------PAGE HEADER-------------------
    if($ss_theme_opt['contact-header-use-row-class']){
        $contact_header_div_class = ' row';
    }
    
    if(isset($ss_theme_opt['contact-header-background-color'])){
        $contact_header_style = "background-color: ".$ss_theme_opt['contact-header-background-color']."";
    }

    if(isset($ss_theme_opt['contact-header-background']['url']) && $ss_theme_opt['contact-header-background']['url'] != ''){
        $contact_header_style = "background-image: url('".$ss_theme_opt['contact-header-background']['url']."')";
    }

    if($ss_theme_opt['contact-header-use-featured-image']){
        if(has_post_thumbnail()){
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
            $contact_header_style = "background-image: url('".$image[0]."')";
        }
    }

    $contact_header_custom_class = $ss_theme_opt['contact-header-custom-class'];
    if($ss_theme_opt['contact-header-overlay']){
        $contact_header_custom_class .= ' overlay-bg';
    }
    if($ss_theme_opt['contact-header-full-width']){
        $contact_header_custom_class .= ' full-width';
    }


    //-----------PAGE FOOTER-------------------
    if($ss_theme_opt['contact-footer-use-row-class']){
        $contact_footer_div_class = ' row';
    }
    
    if(isset($ss_theme_opt['contact-footer-background-color'])){
        $contact_footer_style = "background-color: ".$ss_theme_opt['contact-footer-background-color']."";
    }

    if(isset($ss_theme_opt['contact-footer-background']['url']) && $ss_theme_opt['contact-footer-background']['url'] != ''){
        $contact_footer_style = "background-image: url('".$ss_theme_opt['contact-footer-background']['url']."')";
    }

    if($ss_theme_opt['contact-footer-use-featured-image']){
        if(has_post_thumbnail()){
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
            $contact_footer_style = "background-image: url('".$image[0]."')";
        }
    }

    $contact_footer_custom_class = $ss_theme_opt['contact-footer-custom-class'];
    if($ss_theme_opt['contact-footer-overlay']){
        $contact_footer_custom_class .= ' overlay-bg';
    }
    if($ss_theme_opt['contact-footer-full-width']){
        $contact_footer_custom_class .= ' full-width';
    }



    //---------SIDEBAR-----------------------
    $show_sidebar = true;

    //check if sidebar only show on certain page based on theme option
    if($ss_theme_opt['contact-sidebar-page-id'] != ""){
        //get page list as array and remove empty space
        $str_page = str_replace(' ','',$ss_theme_opt['contact-sidebar-page-id']);
        $arr_page = explode(',',$str_page); //convert to array

        if(!is_page($arr_page)){
            $show_sidebar = false;
        }
    }

    //---------CONTENT------------------------
    //prepare class for content
    $contact_content_class = array();
    if(!empty($ss_theme_opt['contact-content-custom-class'])){
        $contact_content_class[] = $ss_theme_opt['contact-content-custom-class'];
    }
    
    if($show_sidebar && is_active_sidebar( 'contact-sidebar' ) ){
        $contact_content_class[] = $ss_theme_opt['contact-content-custom-class-sidebar-shown'];
    }

    $str_contact_content_class = implode(' ',$contact_content_class);

?>


    <?php if ( is_active_sidebar( 'contact-header' ) ) { ?>
        <section id="section-contact-header" class="theme-section <?php echo $contact_header_custom_class; ?>" style="<?php echo $contact_header_style; ?>" >
            <div class="container">
                <div id="contact-header" class="header-wrapper<?php echo $contact_header_div_class; ?>">
                    <?php dynamic_sidebar( 'contact-header' ); ?>
                </div>
            </div>
        </section>
    <?php } ?>



    <div id="content" class="page">

        <div class="container">

            <div class="row">

                <?php if($ss_theme_opt['contact-sidebar-position'] == 'left'){ ?>
                    <?php if ( $show_sidebar && is_active_sidebar( 'contact-sidebar' ) ) { ?>
                        <div id="contact-sidebar" class="sidebar <?php echo $ss_theme_opt['contact-sidebar-custom-class']; ?>">
                            <?php dynamic_sidebar( 'contact-sidebar' ); ?>
                        </div>
                    <?php } ?>
                <?php } ?>


                <div id="contact-content" class="<?php echo $str_contact_content_class; ?>">
                    
                    <?php if (have_posts()) : ?>
                        <?php while (have_posts()) : the_post(); ?>


                            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>            
                                
                                <?php if($ss_theme_opt['contact-show-title']){ ?>
                                    <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
                                <?php } ?>

                                <?php if($ss_theme_opt['contact-show-author']){ ?>
                                    <span class="entry-author">
                                        <?php the_author(); ?>
                                    </span>
                                <?php } ?>

                                <?php if($ss_theme_opt['contact-show-date']){ ?>
                                    <span class="entry-date">
                                        <?php the_date(); ?>
                                    </span>
                                <?php } ?>

                                <?php if($ss_theme_opt['contact-show-comments-number']){ ?>
                                    <span class="entry-comments-number">
                                        <?php comments_number(); ?>
                                    </span>
                                <?php } ?>

                                <?php if($ss_theme_opt['contact-image'] != 'no'){ ?>
                                    <div class="post-thumbnail">
                                        <?php the_post_thumbnail($ss_theme_opt['contact-image']); ?>
                                    </div>
                                <?php } ?>                                
                                
                                <?php if($ss_theme_opt['contact-show-content']){ ?>
                                    <div class="entry">
                                        <?php the_content(); ?>
                                    </div>
                                <?php } ?>

                                <?php if($ss_theme_opt['contact-show-comment']){ ?>
                                    <div class="comment">
                                        <?php
                                            // If comments are open or we have at least one comment, load up the comment template.
                                            if ( comments_open() || get_comments_number() ) :
                                                comments_template();
                                            endif;
                                        ?>
                                    </div>
                                <?php } ?>

                            </div>
                        
                        <?php endwhile; ?>

                    <?php endif; ?>

                </div>


                <?php if($ss_theme_opt['contact-sidebar-position'] != 'left'){ ?>
                    <?php if ( $show_sidebar && is_active_sidebar( 'contact-sidebar' ) ) { ?>
                        <div id="contact-sidebar" class="sidebar <?php echo $ss_theme_opt['contact-sidebar-custom-class']; ?>">
                            <?php dynamic_sidebar( 'contact-sidebar' ); ?>
                        </div>
                    <?php } ?>
                <?php } ?>

            </div>

        </div>

    </div>

    <?php if ( is_active_sidebar( 'contact-footer' ) ) { ?>
        <section id="section-contact-footer" class="theme-section <?php echo $contact_footer_custom_class; ?>" style="<?php echo $contact_footer_style; ?>" >
            <div class="container">
                <div id="contact-footer" class="footer-wrapper<?php echo $contact_footer_div_class; ?>">
                    <?php dynamic_sidebar( 'contact-footer' ); ?>
                </div>
            </div>
        </section>
    <?php } ?>
        
<?php get_footer(); ?>