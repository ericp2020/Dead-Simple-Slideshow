<?php
/**
*   Display the admin front-end.
**/

//  IMAGES admin section
function ep_simple_slideshow_images_admin() 
{
    global $ep_simple_slideshow_images;

    ep_simple_slideshow_images_update_check(); ?>

    <h2>
        <?php _e('Slideshow Images', 'ep_simple_slideshow'); ?>
    </h2>
    

    <table class="form-table">
        <tr valign="top">
            <th scope="row">Upload New Image</th>
            <td>
                <form enctype="multipart/form-data" method="post" action="?page=ep-simple-slideshow">
                    <input type="hidden" name="post_id" id="post_id" value="0" />

                    <input type="hidden" name="action" id="action" value="wp_handle_upload" />
                    
                    <label for="ep_simple_slideshow">Select a File: </label>

                    <input type="file" name="ep_simple_slideshow" id="ep_simple_slideshow" />

                    <input type="submit" class="button-primary" name="html-upload" value="Upload" />
                </form>
            </td>
        </tr>
    </table>

    <br />


    <?php if( count($ep_simple_slideshow_images) > 0 ) : ?>

    <form method="post" action="options.php">

        <?php settings_fields('ep_simple_slideshow_images');

        // loop thru the thumbnails, and catch any missing images
        foreach( (array)$ep_simple_slideshow_images as $image => $data )
        { ?>
            
            <input type="hidden" name="ep_simple_slideshow_images['id']" value="<?php echo $data['id']; ?>" />

            <input type="hidden" name="ep_simple_slideshow_images[<?php echo $image; ?>]['file']" value="<?php echo $data['file']; ?>" />

            <input type="hidden" name="ep_simple_slideshow_images[<?php echo $image; ?>]['file_url']" value="<?php echo $data['file_url']; ?>" />

            <input type="hidden" name="ep_simple_slideshow_images[<?php echo $image; ?>]['thumbnail']" value="<?php echo $data['thumbnail']; ?>" />

            <input type="hidden" name="ep_simple_slideshow_images[<?php echo $image; ?>]['thumbnail_url']" value="<?php echo $data['thumbnail_url']; ?>" />


            

            <!-- show the THUMBNAIL -->
            <div class="widefat">
                <img src="<?php echo $data['thumbnail_url']; ?>" />
            </div>

            <?php // update the db
            $ep_simple_slideshow_images['update'] = 'Updated';
            update_option('ep_simple_slideshow_images', $ep_simple_slideshow_images);

            // the delete button
            if ( isset($image) ) 
            { ?>
                <p>
                    <a href="?page=ep-simple-slideshow&amp;delete=<?php echo $image; ?>" class="button">Delete</a>
                </p>
            <?php 
            } ?>


            <input type="hidden" name="ep_simple_slideshow_images[update]" value="Updated" />


        <?php 
        } //ends foreach loop ?>


    </form>


    <?php endif; // end if ebs images not empty ?>

<?php
} // end IMAGES admin function