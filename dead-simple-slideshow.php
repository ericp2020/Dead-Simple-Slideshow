<?php
/*
Plugin Name: Dead Simple Slideshow
Description: Simple home page image slideshow for WordPress websites.
Version: 2.0
Author: Eric P

This plugin uses the Backstretch jQuery plugin by Scott Robbin:
http://srobbin.com/jquery-plugins/backstretch/ .
This plugin based on Wp-Cycle by Nathan Rice.
This plugin inherits the GPL license from it's parent system, WordPress.
*/


/**
*   Define plugin vars and defaults.
**/

$ep_simple_slideshow_defaults = apply_filters('ep_simple_slideshow_defaults',
    array(
    'div' => '.epebs-slideshow',
    'fade' => 750,
    'duration' => 3500
    ));

//  pull the images and settings from the db
$ep_simple_slideshow_settings = get_option('ep_simple_slideshow_settings');

$ep_simple_slideshow_images = get_option('ep_simple_slideshow_images');

//  fallback
$ep_simple_slideshow_settings = wp_parse_args(
    $ep_simple_slideshow_settings, $ep_simple_slideshow_defaults
    );



//  registers our settings and image data in the db
add_action('admin_init', 'ep_simple_slideshow_register_settings');

function ep_simple_slideshow_register_settings() 
{
    register_setting('ep_simple_slideshow_images', 'ep_simple_slideshow_images', 'ep_simple_slideshow_images_validate');

    register_setting('ep_simple_slideshow_settings', 'ep_simple_slideshow_settings', 'ep_simple_slideshow_settings_validate');
}


//  adds the plugin settings page link to the theme Appearance menu
add_action('admin_menu', 'add_ep_simple_slideshow_menu');

function add_ep_simple_slideshow_menu() 
{
    add_submenu_page('themes.php', 'Slideshow Settings', 'Homepage Slideshow', 'upload_files', 'ep-simple-slideshow', 'ep_simple_slideshow_admin_page');
}


//  adds the plugin settings page link to theme Plugins page listing
add_filter('plugin_action_links_' . plugin_basename(__FILE__) , 'ep_simple_slideshow_plugin_action_links');

function ep_simple_slideshow_plugin_action_links($links) 
{
    $ep_simple_slideshow_settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'themes.php?page=ep-simple-slideshow' ), __('Slideshow Settings') );

    array_unshift($links, $ep_simple_slideshow_settings_link);

    return $links;
}


/**
*   Outputs the settings page.
**/

function ep_simple_slideshow_admin_page() 
{
    echo '<div class="wrap">';
    
        //  handle image upload, if necessary
        $servercall = ( array_key_exists( 'action', $_REQUEST) ? $_REQUEST['action'] : "" );

        if(isset($servercall) && $servercall == 'wp_handle_upload')
            ep_simple_slideshow_handle_upload();
        
        //  delete an image, if necessary
        if(isset($_REQUEST['delete']))
            ep_simple_slideshow_delete_upload($_REQUEST['delete']);
        
        //  the image management form
        ep_simple_slideshow_images_admin();
        
        //  the settings management form
        ep_simple_slideshow_settings_admin();

    echo '</div>';
}



//  sanitize SETTINGS data
function ep_simple_slideshow_settings_validate($input) 
{
    $input['fade'] = wp_filter_nohtml_kses($input['fade']); 
    $input['duration'] = wp_filter_nohtml_kses($input['duration']);
    $input['div'] = wp_filter_nohtml_kses($input['div']);

    return $input;
}

//  sanitize IMAGE data
function ep_simple_slideshow_images_validate($input) 
{
    foreach( (array)$input as $key => $value ) 
    {
        if($key != 'update') 
        {
            $input[$key]['file_url'] = esc_url( $value['file_url'] );
            $input[$key]['thumbnail_url'] = esc_url( $value['thumbnail_url'] );
        }
    }

    return $input;
}



// get necessary files
require_once('epss_uploader.php');
require_once('epss_update.php');
require_once('epss_settings_admin.php');
require_once('epss_deleter.php');
require_once('epss_images_admin.php');
require_once('epss_output.php');
