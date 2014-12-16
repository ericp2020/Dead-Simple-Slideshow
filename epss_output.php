<?php
/**
*
*   generates the slideshow on the front end of the site 
*
**/

add_action('wp_print_scripts', 'ep_simple_slideshow_scripts');

function ep_simple_slideshow_scripts() 
{
    if(!is_admin())

    wp_enqueue_script('backstretch', plugins_url( 'jquery.backstretch.min.js' , __FILE__ ) , array('jquery'), '2.0.4', true);
    wp_enqueue_style( 'epss_style', plugins_url( 'css/style.css' , __FILE__ ), FALSE, FALSE, 'all' );
}


// dynamically generate the script at the bottom of <body>
add_action('wp_footer', 'ep_simple_slideshow_args', 20);

function ep_simple_slideshow_args() 
{
    global $ep_simple_slideshow_settings, $ep_simple_slideshow_images; ?>

    <script type="text/javascript">
        jQuery(document).ready(function($) 
        {
            var images = [];

            <?php
            if(!empty($ep_simple_slideshow_images))
            {
                foreach($ep_simple_slideshow_images as $image => $data):

                    //var_dump("Image: ".$image);
                    //var_dump($data);
                    
                    // make sure we're dealing with an image url         
                    if ( is_array($data) && array_key_exists('file', $data) )
                    { ?>

                        images.push('<?php
                            {
                                echo $data['file_url'];
                            } ?>');

                    <?php
                    } // end file check ?>

                <?php 
                endforeach; // end image push loop

            } // end images ?>

            var index = 0;

            var backstretchSettings = 
            { 
                fade: <?php echo $ep_simple_slideshow_settings['fade']; ?>, 
                duration:<?php echo $ep_simple_slideshow_settings['duration'];?>
            };

            var len = images.length;

            var totalDuration = (backstretchSettings.fade + backstretchSettings.duration);

            var timer = null;


            var rotate = function() 
            {
                $('<?php echo $ep_simple_slideshow_settings["div"]; ?>').backstretch(images[0], backstretchSettings);

                timer = setInterval(function() 
                {
                    index++;

                    if(index == len) 
                    {
                        index = 0;
                    }

                    $('<?php echo $ep_simple_slideshow_settings["div"]; ?>').backstretch(images[index], backstretchSettings);

                }, totalDuration);

            };

            rotate();

        });

    </script>

<?php
} // ends func simple ss args