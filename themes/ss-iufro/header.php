<?php 
    global $ss_theme_opt; 

    //theme options for widget area section
    //header top section
    if($ss_theme_opt['header-top-use-row-class']){
        $header_top_div_class = ' row';
    }
    
    if(isset($ss_theme_opt['header-top-background-color'])){
    	$header_top_style = "background-color: ".$ss_theme_opt['header-top-background-color']."";
    }

    if(isset($ss_theme_opt['header-top-background']['url']) && $ss_theme_opt['header-top-background']['url'] != ''){
        $header_top_style = "background-image: url('".$ss_theme_opt['header-top-background']['url']."')";
    }

    $header_top_custom_class = $ss_theme_opt['header-top-custom-class'];
    if($ss_theme_opt['header-top-overlay']){
        $header_top_custom_class .= ' overlay-bg';
    }
    if($ss_theme_opt['header-top-full-width']){
        $header_top_custom_class .= ' full-width';
    }
    if($ss_theme_opt['header-top-sticky']){
        $header_top_custom_class .= ' sticky-header';
    }

    //header middle section
    if($ss_theme_opt['header-middle-use-row-class']){
        $header_middle_div_class = ' row';
    }
    
    if(isset($ss_theme_opt['header-middle-background-color'])){
	    $header_middle_style = "background-color: ".$ss_theme_opt['header-middle-background-color']."";
	}

    if(isset($ss_theme_opt['header-middle-background']['url']) && $ss_theme_opt['header-middle-background']['url'] != ''){
        $header_middle_style = "background-image: url('".$ss_theme_opt['header-middle-background']['url']."')";
    }

    $header_middle_custom_class = $ss_theme_opt['header-middle-custom-class'];
    if($ss_theme_opt['header-middle-overlay']){
        $header_middle_custom_class .= ' overlay-bg';
    }
    if($ss_theme_opt['header-middle-full-width']){
        $header_middle_custom_class .= ' full-width';
    }

    //header bottom section
    if($ss_theme_opt['header-bottom-use-row-class']){
        $header_bottom_div_class = ' row';
    }
    
    if(isset($ss_theme_opt['header-bottom-background-color'])){
	    $header_bottom_style = "background-color: ".$ss_theme_opt['header-bottom-background-color']."";
	}
	
    if(isset($ss_theme_opt['header-bottom-background']['url']) && '' != $ss_theme_opt['header-bottom-background']['url']){
        $header_bottom_style = "background-image: url('".$ss_theme_opt['header-bottom-background']['url']."')";
    }
    
    $header_bottom_custom_class = $ss_theme_opt['header-bottom-custom-class'];
    if($ss_theme_opt['header-bottom-overlay']){
        $header_bottom_custom_class .= ' overlay-bg';
    }
    if($ss_theme_opt['header-bottom-full-width']){
        $header_bottom_custom_class .= ' full-width';
    }
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0," />
    <?php if( is_front_page() ) : ?>
        <meta name="description" content="<?php bloginfo('description'); ?>">
    <?php endif; ?>
    
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.png" />
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/icon-touch.png"/> 
    <link rel="icon" type="image/png" href="<?php echo (isset($ss_theme_opt['favicon']['url']) ? $ss_theme_opt['favicon']['url'] : ''); ?>" />

    <!--Make Microsoft Internet Explorer behave like a standards-compliant browser. http://code.google.com/p/ie7-js/-->
    <!--[if lt IE 9]>
        <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
    <![endif]-->
    <?php wp_head();?>
</head>
<body <?php body_class(); ?>>
<div id="header">
    
    <?php if( is_front_page() || $ss_theme_opt['header-top-show-on-page'] ) { ?>
        <?php if ( is_active_sidebar( 'header-top' ) ) { ?>
            <section id="section-header-top" class="theme-section <?php echo $header_top_custom_class; ?>" style="<?php echo $header_top_style; ?>" >
                <div class="container">
                    <div id="header-top" class="header-wrapper<?php echo $header_top_div_class; ?>">
                        <?php dynamic_sidebar( 'header-top' ); ?>
                    </div>
                </div>
            </section>
        <?php } ?>
    <?php } ?>


    <?php if( is_front_page() || $ss_theme_opt['header-middle-show-on-page'] ) { ?>
        <?php if ( is_active_sidebar( 'header-middle' ) ) { ?>
            <section id="section-header-middle" class="theme-section <?php echo $header_middle_custom_class; ?>" style="<?php echo $header_middle_style; ?>" >
                <div class="container">
                    <div id="header-middle" class="header-wrapper<?php echo $header_middle_div_class; ?>">
                        <?php dynamic_sidebar( 'header-middle' ); ?>
                    </div>
                </div>
            </section>
        <?php } ?>
    <?php } ?>


    <?php if( is_front_page() || $ss_theme_opt['header-bottom-show-on-page'] ) { ?>
        <?php if ( is_active_sidebar( 'header-bottom' ) ) { ?>
            <section id="section-header-bottom" class="theme-section <?php echo $header_bottom_custom_class; ?>" style="<?php echo $header_bottom_style; ?>" >
                <div class="container">
                    <div id="header-bottom" class="header-wrapper<?php echo $header_bottom_div_class; ?>">
                        <?php dynamic_sidebar( 'header-bottom' ); ?>
                    </div>
                </div>
            </section>
        <?php } ?>
    <?php } ?>

</div>