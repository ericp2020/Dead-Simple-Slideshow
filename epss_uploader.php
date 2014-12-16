<?php
/**
*   handles the file upload, and adds the image data to the db
**/

function ep_simple_slideshow_handle_upload() 
{

    if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );

    global $ep_simple_slideshow_settings, $ep_simple_slideshow_images;
        
    //  upload the image
    $upload = wp_handle_upload($_FILES['ep_simple_slideshow'], 0);
        
    //  extract the $upload array
    extract($upload);


    // don't do anything if there is no image selected
    if ( array_key_exists('error', $upload) )
    {
        echo '<div class="error"><p style="color:red;">No file was uploaded.</p></div>';
        return;
    }


    //  the wp upload directory array
    $upload_dir_url = wp_upload_dir();
        

    //  get the image dimensions
    if( !empty($file) )
    {
        list($width, $height) = getimagesize($file);
    }
    

    //  if the uploaded file is NOT an image, or if there is no file
    if( $file && (strpos($type, 'image') === FALSE) || empty($file) ) 
    {
        // if there is a file, but it's not an image, delete it.
        if( !empty($file) )
        {
            unlink($file); // delete the file
        }

        echo '<div class="error" id="message"><p>Sorry, but the file you uploaded does not seem to be a valid image. Please try again.</p></div>';

        return;
    }
        
        
    //  make the thumbnail, and set the data
    if(isset($upload['file'])) 
    {
        // path to uploaded file
        $bsfilepath = $upload['file'];
        
        // check if server can do the resize job
        $arg = array(
            'methods' => array(
                'resize',
                'save'
            )
        );

        $img_editor_test = wp_image_editor_supports($arg);

        if ($img_editor_test !== false) 
        {
            $baseimg = wp_get_image_editor($bsfilepath);

            // if all is well, resize the image, generate a filename, and save the thumbnail.
            if ( ! is_wp_error($baseimg) )
            {
                $baseimg -> resize(300, 200, false);

                $thumbfile = $baseimg -> generate_filename(
                'thumb', NULL, NULL
                );

                $baseimg -> save( $thumbfile );

                $thumbnail_url = $upload_dir_url['url'] . '/' . basename($thumbfile);
            } 


            //  use the timestamp as the array key, AND the id of the image.
            $time = date('YmdHis');
            
            //  add the image data to the array
            $ep_simple_slideshow_images[$time] = array(
            'id' => $time,
            'file' => $file,
            'file_url' => $url,
            'thumbnail' => $thumbfile,
            'thumbnail_url' => $thumbnail_url
            );
            
            //  add the image data to the database, and update the db
            $ep_simple_slideshow_images['update'] = 'Added';
            update_option('ep_simple_slideshow_images', $ep_simple_slideshow_images);


        } // end server image editor test

    } // end $upload

} // end upload function