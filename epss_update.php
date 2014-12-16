<?php
/**
* If an update just occurred, display a notice 
* and reset update option.
*
**/


/**  
*   SETTINGS update
**/ 
function ep_simple_slideshow_settings_update_check() 
{
    global $ep_simple_slideshow_settings;

    if(isset($ep_simple_slideshow_settings['update'])) 
    {
        echo '<div class="updated fade" id="message"><p>Slideshow Settings <strong>'.$ep_simple_slideshow_settings['update'].'</strong></p></div>';

        unset($ep_simple_slideshow_settings['update']);

        update_option('ep_simple_slideshow_settings', $ep_simple_slideshow_settings);
    }
}


/**       
*   IMAGE update
**/ 
function ep_simple_slideshow_images_update_check() 
{
    global $ep_simple_slideshow_images;

    if(isset($ep_simple_slideshow_images['update']))
    {
        if($ep_simple_slideshow_images['update'] == 'Added' || $ep_simple_slideshow_images['update'] == 'Deleted' || $ep_simple_slideshow_images['update'] == 'Updated')
        {
            echo '<div class="updated fade" id="message"><p>Image(s) '.$ep_simple_slideshow_images['update'].' Successfully</p></div>';

            unset($ep_simple_slideshow_images['update']);

            update_option('ep_simple_slideshow_images', $ep_simple_slideshow_images);
        }

    }
}