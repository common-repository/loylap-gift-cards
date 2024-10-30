<?php
namespace loylap;
require_once LOYLAP_PLUGIN_PATH . 'inc/IField.php';

class disable_header_field implements IField{
   private $page;
   public function __construct($page){
        $this->page = $page;
   }

    public function register(){

        \register_setting(
            $this->page, // option group
            'loy_header_visible', // option name
             [$this, 'validate_setting']     // validation callback :plausible
        );


        \add_settings_field(
            'loy_header_visible', // id
            'Loylap header is visible', // title
            [$this,'display_api_setting'], // callback
            $this->page, // page
            'Loylap_settings' // section
        );
    }
    /**
     * Validates setting
     */
    function validate_setting($input){
        return \sanitize_text_field($input);
    }


    /**
     * Display the setting
     */
    function display_api_setting(){
        $value = \get_option('loy_header_visible');

        echo  '
        
        <div class="loy_edit">
           <input type="checkbox" id="loy_header_visible" name="loy_header_visible"  ' .  ( $value ? "checked" : "" ) . '/>
        </div>
            ';

    }

  

}