<?php 
    global $ss_theme_opt; 

    $is_sidebar = false;
    if ( is_active_sidebar( 'home-sidebar' ) ){
        $is_sidebar = true;
    }
?>
<?php get_header(); ?>
    
    <div id="content">

    <?php 

        if($is_sidebar){
            get_template_part('part-home-with-sidebar'); 
        }else{
            get_template_part('part-home'); 
        }

    ?>

    </div>
        
<?php get_footer(); ?>