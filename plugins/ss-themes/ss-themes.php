<?php
	/* 
	Plugin Name: WP Themes Component
	Description: Plugin to provide various kind of widget and custom post type
	Version: 1.1.7
	Author: Wordpress
	*/

	//including other components
	//include_once('includes/ss-links.php');
	include_once('includes/ss-function.php');
	include_once('includes/ss-logo.php');
	include_once('includes/ss-menu.php');
	
	include_once('includes/ss-part.php');
	include_once('includes/ss-parts.php'); //dependent on ss-part.php
	include_once('includes/ss-parts-slider.php'); //dependent on ss-part.php
	include_once('includes/ss-parts-accordion.php'); //dependent on ss-part.php

	include_once('includes/ss-page.php');
	include_once('includes/ss-ypnz-footer.php');
	include_once('includes/ss-parent-child-links.php');

	include_once('includes/ss-dev.php');
	include_once('includes/ss-editor.php');
	include_once('includes/ss-header.php');

	//include 'includes/ss-social-media-widget/ss-social-media-widget.php';

	add_shortcode('home_url','home_url');
	
	function has_children() {
	    global $post;

	    if(!$post){
	    	return false;
	    }
	    
	    $children = get_pages( array( 'child_of' => $post->ID ) );
	    if( count( $children ) == 0 ) {
	        return false;
	    } else {
	        return true;
	    }
	}
?>