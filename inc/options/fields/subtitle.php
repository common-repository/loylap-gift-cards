<?php
namespace loylap;
require_once LOYLAP_PLUGIN_PATH . 'inc/IField.php';

class subtitle_field implements IField{
   private $page;
   public function __construct($page){
        $this->page = $page;
   }

    public function register(){

        \register_setting(
            $this->page, // option group
            'loy_subtitle', // option name
             [$this, 'validate_setting']     // validation callback :plausible
        );


        \add_settings_field(
            'loy_subtitle', // id
            'custom subtitle', // title
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
        $title = \get_option('loy_subtitle');

        echo  '
        
        <div class="loy_edit">
           <input type="text" id="loy_subtitle" name="loy_subtitle"  ' .  ( $title != null || $title != "" ? "value='".$title."'" : "" ) . '/>
        </div>
            ';

    }

  

}