<?php
/**
 * Plugin Name: WP_AjaxTest
 * Description: A super basic test to see if Ajax is working.  Creates a form in your wp_footer that returns a message if the ajax call.
 * Version: 0.1
 * Author: Katherine Semel
*/
if ( ! class_exists('WP_AjaxTest') ) {
class WP_AjaxTest {

    function WP_AjaxTest() {
        // Initialize the AJAX hooks
        add_action( 'init', array( $this, 'register_ajax' ) );

        // Print our test form in the footer
        add_action( 'wp_footer', array( $this, 'show_form' ) );
    }

    function register_ajax() {

        // Test Ajax Settings

        // Include a hidden field in your form called "action" with the value
        // "test_ajax_settings" to trigger these callbacks

        // These callbacks can be the same for both logged in and not logged in users
        // If you require the user to be logged in, use wp_ajax_ only.
        // If you want the same action regardless of login state you must implement both.

        // For authenticated visitors, trigger this one
        add_action( 'wp_ajax_test_ajax_settings', array( $this, 'ajax_test_ajax_settings' ) );

        // For unauthenticated visitors, trigger this one
        add_action( 'wp_ajax_nopriv_test_ajax_settings', array( $this, 'ajax_test_ajax_settings' ) );
    }

    function ajax_test_ajax_settings() {
        // If this expects POST data, cancel processing if we called this without POST
        if ( ! isset( $_POST ) ) {
            die();
        }

        // Do all your processing here and return the results
        $message = "Your ajax ran successfully!";

        // The results must be sent back to the browser as a javascript-readable string or JSON
        // Don't "return".  You need to "echo" or "print" the results
        echo $message;

        // Make sure we don't continue after sending back our data or messaging
        die();
    }

    function show_form() {
        ?>
        <!-- I am a demo form, you may set up your form and post however you please -->
        <form id="test_ajax_settings_form" action="" method="post">

        <!-- this field is how Wordpress knows what ajax callback to trigger -->
        <!-- You can also pass this via the data in your ajax call -->
        <input type="hidden" name="action" value="test_ajax_settings" />

        <div class="response"></div>

        <p class="submit">
            <input class="button-secondary" type="button" id="test_ajax_settings_button" name="test_ajax_settings" value="Test Ajax"  />
        </p>
        </form>

        <script type="text/javascript">
        //<!--
            jQuery( '#test_ajax_settings_button' ).bind('click', function() {
                // For this example we require POST, but GET will work as well.
                jQuery.post(
                    // This is the url to the ajax processing page in Wordpress
                    '<?php echo admin_url( 'admin-ajax.php' ) ?>',
                    // We can pass all the values of the form this way, or it can be defined explictly
                    jQuery( '#test_ajax_settings_form' ).serialize(),
                    function( response ){
                        jQuery( '#test_ajax_settings_form .response').html( response ).css( { "display" : "block" } );
                    }
                );
                return false;
            });
        // -->
        </script>

        <?php
    }
}

$WP_AjaxTest = new WP_AjaxTest();

}

?>
