<?php
namespace loylap;
require_once LOYLAP_PLUGIN_PATH . 'inc/IField.php';

class usage_field implements IField{
   private $page;
   public function __construct($page){
        $this->page = $page;
   }

    public function register(){
        $usage_type = \get_option('loy_usage');

        switch($usage_type){
            case "shortcode":
            $notice = '
            <p class="light-text">
            Copy and paste the below shortcode into a Text or HTML section of the page where you want to display a floating button. 
            </br>
             Floating action button: [short_loylap]
             </br>
            Add to page: [short_loylap_inline]
                        </br>
            Balance Checker: [loylap_balance_check]
            </p>
            
            '; 
            break;
            case "wp_page":
            $notice = '
                <p class="light-text">
                    After selecting "Create a new page" you can add the page to a menu bar and it will be available at yourdomain/giftcard.
                </p>
                <p class="light-text">
                    Navigate to Appearance->Menus to add the page to your main navigation menu.
                </p>
            ';
            break;

            default: 
            $notice = '';
            break;
        } 


        \register_setting(
            $this->page, // option group
            'loy_usage', // option name
             [$this, 'validate_setting']     // validation callback :plausible
        );


        \add_settings_field(
            'loy_usage', // id
            'How would you like to add the digital gift card widget on your website?</br>'.$notice, // title
            [$this,'display_api_setting'], // callback
            $this->page, // page
            'Loylap_settings' // section
        );
    }
    /**
     * Validates setting
     */
    function validate_setting($input) {
        $attr = \esc_attr($input);
        if ( $attr == "shortcode" || $attr == "wp_page" ){
            return $attr;
        }
        else {
            return "";
        }
    }


    /**
     * Display the setting
     */
    function display_api_setting(){
        $usage_type = \get_option('loy_usage');

        echo  '
        
        <div class="loy_edit">
            <select name="loy_usage" class="loylap-select">
                <option value="shortcode" '.($usage_type == "shortcode" ? "selected" : "").'>Add a shortcode</option>
                <option value="wp_page" '.($usage_type == "wp_page" ? "selected" : "").'>Create a new page</option>
                <option value="" '.($usage_type == "" ? "selected" : "").'>Please select a method</option>
            </select>
        </div>
            ';

    }

  

}