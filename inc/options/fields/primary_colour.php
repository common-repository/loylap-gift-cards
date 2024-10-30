<?php
namespace loylap;
require_once LOYLAP_PLUGIN_PATH . 'inc/IField.php';

class primary_colour implements IField{
   private $page;
   public function __construct($page){
        $this->page = $page;
   }

    public function register(){

        $notice = '
                <p class="light-text">
                    Please enter the 6 character hex colour value e.g. for black, please enter 000000
                </p>
            ';

        \register_setting(
            $this->page, // option group
            'loy_primary_colour', // option name
             [$this, 'validate_setting']     // validation callback :plausible
        );


        \add_settings_field(
            'loy_primary_colour', // id
            'primary colour</br>'.$notice, // title
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
        $title = \get_option('loy_primary_colour');

        echo  '
        
        <div class="loy_edit">
           <input type="text" id="loy_primary_colour" name="loy_primary_colour"  pattern="[A-Za-z0-9]{6}" maxlength="6" title="6 digit alphanumeric only"' .  ( $title != null || $title != "" ? "value='".$title."'" : "" ) . '/>
        </div>
            ';

    }

  

}