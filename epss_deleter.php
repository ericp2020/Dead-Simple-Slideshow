<?php
/**
*
*   deletes the image, and removes the image data from the db
*
**/ 
function ep_simple_slideshow_delete_upload($id) 
{
    global $ep_simple_slideshow_images;

    
    if ( ! isset($ep_simple_slideshow_images[$id]) )
    {
        return;
    }

    else
    {    
        $epss_img = $ep_simple_slideshow_images[$id];

    }

    //  if the ID is invalid, don't try to delete.
    if (isset($epss_img['id']))
    {
        $id_length = strlen( ($epss_img['id']) );
    
        if ($id_length !== 14 )
        {   
            return;
        }
    }
    
    
    //  delete the image and thumbnail img 
    if ( isset($epss_img['file']) && is_file($epss_img['file']) )
    {
        // image
        unlink($epss_img['file']);
    }

    if ( isset($epss_img['thumbnail']) && is_file($epss_img['thumbnail']) )
    {
        // thumbnail
        unlink($epss_img['thumbnail']);
    }


    // indicate that the image was deleted, set update option
    $ep_simple_slideshow_images['update'] = 'Deleted';

    // remove the image data from the db
    unset($ep_simple_slideshow_images[$id]);

    // update the db
    update_option('ep_simple_slideshow_images', $ep_simple_slideshow_images);

} // end delete function