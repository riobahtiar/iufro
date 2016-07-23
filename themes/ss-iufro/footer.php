<?php 
    global $ss_theme_opt; 

    //theme options for widget area section
    //footer top section
    if($ss_theme_opt['footer-top-use-row-class']){
        $footer_top_div_class = ' row';
    }

    if(isset($ss_theme_opt['footer-top-background-color'])){
    	$footer_top_style = "background-color: ".$ss_theme_opt['footer-top-background-color']."";
    }

    if(isset($ss_theme_opt['footer-top-background']['url']) && '' != $ss_theme_opt['footer-top-background']['url']){
        $footer_top_style = "background-image: url('".$ss_theme_opt['footer-top-background']['url']."')";
    }

    $footer_top_custom_class = $ss_theme_opt['footer-top-custom-class'];
    if($ss_theme_opt['footer-top-overlay']){
        $footer_top_custom_class .= ' overlay-bg';
    }

    if($ss_theme_opt['footer-top-full-width']){
        $footer_top_custom_class .= ' full-width';
    }

    //footer middle section
    if($ss_theme_opt['footer-middle-use-row-class']){
        $footer_middle_div_class = ' row';
    }

    if(isset($ss_theme_opt['footer-middle-background-color'])){
    	$footer_middle_style = "background-color: ".$ss_theme_opt['footer-middle-background-color']."";
    }

    if(isset($ss_theme_opt['footer-middle-background']['url']) && '' != $ss_theme_opt['footer-middle-background']['url']){
        $footer_middle_style = "background-image: url('".$ss_theme_opt['footer-middle-background']['url']."')";
    }

    $footer_middle_custom_class = $ss_theme_opt['footer-middle-custom-class'];
    if($ss_theme_opt['footer-middle-overlay']){
        $footer_middle_custom_class .= ' overlay-bg';
    }

    if($ss_theme_opt['footer-middle-full-width']){
        $footer_middle_custom_class .= ' full-width';
    }
    

    //footer bottom section
    if($ss_theme_opt['footer-bottom-use-row-class']){
        $footer_bottom_div_class = ' row';
    }

    if(isset($ss_theme_opt['footer-bottom-background-color'])){
    	$footer_bottom_style = "background-color: ".$ss_theme_opt['footer-bottom-background-color']."";
    }
    
    if(isset($ss_theme_opt['footer-bottom-background']['url']) && '' != $ss_theme_opt['footer-bottom-background']['url']){
        $footer_bottom_style = "background-image: url('".$ss_theme_opt['footer-bottom-background']['url']."')";
    }

    $footer_bottom_custom_class = $ss_theme_opt['footer-bottom-custom-class'];
    if($ss_theme_opt['footer-bottom-overlay']){
        $footer_bottom_custom_class .= ' overlay-bg';
    }
    
    if($ss_theme_opt['footer-bottom-full-width']){
        $footer_bottom_custom_class .= ' full-width';
    }
?>
<div id="footer">

    <?php if( is_front_page() || $ss_theme_opt['footer-top-show-on-page'] ) { ?>
    	<?php if ( is_active_sidebar( 'footer-top' ) ){ ?>
            <section id="section-footer-top" class="theme-section <?php echo $footer_top_custom_class; ?>" style="<?php echo $footer_top_style; ?>" >
                <div class="container">
                    <div id="footer-top" class="footer-wrapper<?php echo $footer_top_div_class; ?>">
                        <?php dynamic_sidebar( 'footer-top' ); ?>
                    </div>
                </div>
            </section>
        <?php } ?>
    <?php } ?>


    <?php if( is_front_page() || $ss_theme_opt['footer-middle-show-on-page'] ) { ?>
        <?php if ( is_active_sidebar( 'footer-middle' ) ){ ?>
            <section id="section-footer-middle" class="theme-section <?php echo $footer_middle_custom_class; ?>" style="<?php echo $footer_middle_style; ?>" >
                <div class="container">
                    <div id="footer-middle" class="footer-wrapper<?php echo $footer_middle_div_class; ?>">
                        <?php dynamic_sidebar( 'footer-middle' ); ?>
                    </div>
                </div>
            </section>
        <?php } ?>
    <?php } ?>


    <?php if( is_front_page() || $ss_theme_opt['footer-bottom-show-on-page'] ) { ?>
        <?php if ( is_active_sidebar( 'footer-bottom' ) ){ ?>
            <section id="section-footer-bottom" class="theme-section <?php echo $footer_bottom_custom_class; ?>" style="<?php echo $footer_bottom_style; ?>" >
                <div class="container">
                    <div id="footer-bottom" class="footer-wrapper<?php echo $footer_bottom_div_class; ?>">
                        <?php dynamic_sidebar( 'footer-bottom' ); ?>
                    </div>
                </div>
            </section>
        <?php } ?>
    <?php } ?>
    
</div>

<!-- Back to top link -->
<span id="back-to-top"></span>
<span id="phone-detection"></span>

<?php wp_footer();?>
</body>
</html>