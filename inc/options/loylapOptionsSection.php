<?php
namespace loylap;

// require the abstraction layer
require_once LOYLAP_PLUGIN_PATH . "inc/options/optionSection.php" ;

// requires different fields
require_once LOYLAP_PLUGIN_PATH . "inc/options/fields/title.php";
require_once LOYLAP_PLUGIN_PATH . "inc/options/fields/subtitle.php";
require_once LOYLAP_PLUGIN_PATH . "inc/options/fields/primary_colour.php";
require_once LOYLAP_PLUGIN_PATH . "inc/options/fields/floating_button_image.php";
require_once LOYLAP_PLUGIN_PATH . "inc/options/fields/header_image.php";
require_once LOYLAP_PLUGIN_PATH . "inc/options/fields/usage_field.php";
require_once LOYLAP_PLUGIN_PATH . "inc/options/fields/secret_option.php";
// require_once LOYLAP_PLUGIN_PATH . "inc/options/fields/enable_balance_check.php";
require_once LOYLAP_PLUGIN_PATH . "inc/options/fields/disable_header.php";
require_once LOYLAP_PLUGIN_PATH . "inc/options/fields/success_url.php";


class loylap_section extends loylap_settings_section {

    function __construct(){
        $this->set_section_id("Loylap_settings");
        $this->set_title("Loylap wordpress configuration");
        $this->set_page("Loy_options_page");


        parent::__construct();
    }

    /** 
     * register admin settings
     */
    function register_fields(){
        //NOTE: Order matters here!
        (new title_field($this->get_page()))->register();        
        (new subtitle_field($this->get_page()))->register();
        (new primary_colour($this->get_page()))->register();
        (new usage_field($this->get_page()))->register();
        (new floating_button_image($this->get_page()))->register();
        (new header_image($this->get_page()))->register();
        (new secret_option($this->get_page()))->register();
        // (new enable_balance_field($this->get_page()))->register();
        (new disable_header_field($this->get_page()))->register();
        (new success_url($this->get_page()))->register();

        parent::register_fields();
    }
    

    /**
     * What shows up first in the section 
     */
    function show_header(){
        echo "<p>
        You can fill in your loylap information and configure the plugin.
      
        </p>";
    }

}




       

    