<?php 
    global $ss_theme_opt;
    
    //theme options for widget area section
    
    //home top section
    if($ss_theme_opt['home-top-use-row-class']){
        $home_top_div_class = ' row';
    }
    
    if(isset($ss_theme_opt['home-top-background-color'])){
        $home_top_style = "background-color: ".$ss_theme_opt['home-top-background-color']."";
    }

    if(isset($ss_theme_opt['home-top-background']['url']) && '' != $ss_theme_opt['home-top-background']['url']){
        $home_top_style = "background-image: url('".$ss_theme_opt['home-top-background']['url']."')";
    }

    $home_top_custom_class = $ss_theme_opt['home-top-custom-class'];
    if($ss_theme_opt['home-top-overlay']){
        $home_top_custom_class .= ' overlay-bg';
    }

    //home middle section
    if($ss_theme_opt['home-middle-use-row-class']){
        $home_middle_div_class = ' row';
    }

    if(isset($ss_theme_opt['home-middle-background-color'])){
        $home_middle_style = "background-color: ".$ss_theme_opt['home-middle-background-color']."";
    }

    if(isset($ss_theme_opt['home-middle-background']['url']) && '' != $ss_theme_opt['home-middle-background']['url']){
        $home_middle_style = "background-image: url('".$ss_theme_opt['home-middle-background']['url']."')";
    }

    $home_middle_custom_class = $ss_theme_opt['home-middle-custom-class'];
    if($ss_theme_opt['home-middle-overlay']){
        $home_middle_custom_class .= ' overlay-bg';
    }

    //home bottom section
    if($ss_theme_opt['home-bottom-use-row-class']){
        $home_bottom_div_class = ' row';
    }
    
    if(isset($ss_theme_opt['home-bottom-background-color'])){
        $home_bottom_style = "background-color: ".$ss_theme_opt['home-bottom-background-color']."";
    }
    
    if(isset($ss_theme_opt['home-bottom-background']['url']) && '' != $ss_theme_opt['home-bottom-background']['url']){
        $home_bottom_style = "background-image: url('".$ss_theme_opt['home-bottom-background']['url']."')";
    }
    
    $home_bottom_custom_class = $ss_theme_opt['home-bottom-custom-class'];
    if($ss_theme_opt['home-bottom-overlay']){
        $home_bottom_custom_class .= ' overlay-bg';
    }
?>
                    
    <div class="container">
        <div class="row">

            <?php if($ss_theme_opt['home-sidebar-position'] == 'left'){ ?>
                <!-- HOME SIDEBAR -->
                <?php if ( is_active_sidebar( 'home-sidebar' ) ) : ?>
                    <div id="home-sidebar" class="sidebar <?php echo $ss_theme_opt['home-sidebar-custom-class']; ?>">
                        <?php dynamic_sidebar( 'home-sidebar' ); ?>
                    </div>
                <?php endif; ?>
                <!-- END HOME SIDEBAR -->
            <?php } ?>


            <!-- HOME CONTENT -->
            <div id="home-content" class="<?php echo $ss_theme_opt['home-content-custom-class']; ?>">

                <!-- HOME TOP SECTION -->
                <?php if ( is_active_sidebar( 'home-top' ) ) : ?>
                    <section id="section-home-top" class="theme-section <?php echo $home_top_custom_class; ?>" style="<?php echo $home_top_style; ?>" >
                        <div id="home-top" class="home-wrapper<?php echo $home_top_div_class; ?>">
                            <?php dynamic_sidebar( 'home-top' ); ?>
                        </div>
                    </section>
                <?php endif; ?>
                <!-- END HOME TOP SECTION -->

                <!-- HOME MIDDLE SECTION -->
                <?php if ( is_active_sidebar( 'home-middle' ) ) : ?>
                    <section id="section-home-middle" class="theme-section <?php echo $home_middle_custom_class; ?>" style="<?php echo $home_middle_style; ?>" >
                        <div id="home-middle" class="home-wrapper<?php echo $home_middle_div_class; ?>">
                            <?php dynamic_sidebar( 'home-middle' ); ?>
                        </div>
                    </section>
                <?php endif; ?>
                <!-- END HOME MIDDLE SECTION -->

                <!-- HOME BOTTOM SECTION -->
                <?php if ( is_active_sidebar( 'home-bottom' ) ) : ?>
                    <section id="section-home-bottom" class="theme-section <?php echo $home_bottom_custom_class; ?>" style="<?php echo $home_bottom_style; ?>" >
                        <div id="home-bottom" class="home-wrapper<?php echo $home_bottom_div_class; ?>">
                            <?php dynamic_sidebar( 'home-bottom' ); ?>
                        </div>
                    </section>
                <?php endif; ?>
                <!-- END HOME BOTTOM SECTION -->

            </div>
            <!-- END HOME CONTENT -->


            <?php if($ss_theme_opt['home-sidebar-position'] != 'left'){ ?>
                <!-- HOME SIDEBAR -->
                <?php if ( is_active_sidebar( 'home-sidebar' ) ) : ?>
                    <div id="home-sidebar" class="sidebar <?php echo $ss_theme_opt['home-sidebar-custom-class']; ?>">
                        <?php dynamic_sidebar( 'home-sidebar' ); ?>
                    </div>
                <?php endif; ?>
                <!-- END HOME SIDEBAR -->
            <?php } ?>

        </div>
    </div>