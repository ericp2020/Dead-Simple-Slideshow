<?php    
//  SETTINGS admin section
function ep_simple_slideshow_settings_admin() 
{
    ep_simple_slideshow_settings_update_check(); ?>

    <h2>
        <?php _e('Slideshow Settings', 'ep-simple-slideshow'); ?>
    </h2>

    <!-- SETTINGS form -->
    <form method="post" action="options.php">

        <?php settings_fields('ep_simple_slideshow_settings');

        global $ep_simple_slideshow_settings;

        $options = $ep_simple_slideshow_settings; ?>


        <table class="form-table">

            <tr>

                <th scope="row">Fade Speed</th>

                <td>The speed at which the images will fade in/out. Enter the time in milliseconds, default is 750 (0.75 seconds):<br />

                    <input type="text" name="ep_simple_slideshow_settings[fade]" value="<?php echo $options['fade'] ?>" size="4" />

                    <label for="ep_simple_slideshow_settings[fade]">milliseconds</label>

                </td>

            </tr>
            
            
            <tr>

                <th scope="row">Duration Between Slides</th>

                <td>Time between slides, or how long each slide will display, in milliseconds, default is 3500 (3.5 seconds):<br />

                    <input type="text" name="ep_simple_slideshow_settings[duration]" value="<?php echo $options['duration'] ?>" size="4" />

                    <label for="ep_simple_slideshow_settings[duration]">milliseconds</label>

                </td>

            </tr>
            
            <tr>
                <th scope="row">Slideshow Placement</th>

                <td>Enter the <strong>.classname</strong> or <strong>#id</strong> of the container that you want the slideshow to appear in (default is <strong>.simple-slideshow</strong>):<br />

                    <input type="text" name="ep_simple_slideshow_settings[div]" value="<?php echo $options['div'] ?>" />

                </td>

            </tr>


        </table>


        <p class="submit">

            <!-- the SAVE SETTINGS button -->
            <input type="submit" class="button-primary" value="<?php _e('Save Settings') ?>" />
            <input type="hidden" name="ep_simple_slideshow_settings[update]" value="Updated" />
        </p>

    </form> <!-- ends the settings fields section -->
        

    <!--  SETTINGS RESET button -->
    <form method="post" action="options.php">

        <?php settings_fields('ep_simple_slideshow_settings'); ?>

        <?php global $ep_simple_slideshow_defaults; // use the defaults ?>

            <?php foreach((array)$ep_simple_slideshow_defaults as $key => $value) : ?>

                <input type="hidden" name="ep_simple_slideshow_settings[<?php echo $key; ?>]" value="<?php echo $value; ?>" />

            <?php endforeach; ?>

        

            <!-- the settings reset button -->
            <input type="submit" class="button" value="<?php _e('Reset Settings') ?>" />
            <input type="hidden" name="ep_simple_slideshow_settings[update]" value="reset" />
        

    </form> <!-- ends Reset form -->

<?php
} // end SETTINGS admin function