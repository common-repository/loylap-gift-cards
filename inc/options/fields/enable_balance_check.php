<?php
namespace loylap;
require_once LOYLAP_PLUGIN_PATH . 'inc/IField.php';

class enable_balance_field implements IField{
   private $page;
   public function __construct($page){
        $this->page = $page;
   }

    public function register(){

        \register_setting(
            $this->page, // option group
            'loy_balance_check', // option name
             [$this, 'validate_setting']     // validation callback :plausible
        );


        \add_settings_field(
            'loy_balance_check', // id
            'Loylap Balance check', // title
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
        $value = \get_option('loy_balance_check');

        echo  '
        
        <div class="loy_edit">
           <input type="checkbox" id="loy_balance_check" name="loy_balance_check"  ' .  ( $value ? "checked" : "" ) . '/>
        </div>
            ';

    }

  

}