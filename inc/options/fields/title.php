<?php
namespace loylap;
require_once LOYLAP_PLUGIN_PATH . 'inc/IField.php';

class title_field implements IField{
   private $page;
   public function __construct($page){
        $this->page = $page;
   }

    public function register(){

        \register_setting(
            $this->page, // option group
            'loy_title', // option name
             [$this, 'validate_setting']     // validation callback :plausible
        );


        \add_settings_field(
            'loy_title', // id
            'custom title', // title
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
        $title = \get_option('loy_title');

        echo  '
        
        <div class="loy_edit">
           <input type="text" id="loy_title" name="loy_title"  ' .  ( $title != null || $title != "" ? "value='".$title."'" : "" ) . '/>
        </div>
            ';

    }

  

}