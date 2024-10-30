<?php
namespace loylap;
require_once LOYLAP_PLUGIN_PATH . 'inc/IField.php';

class secret_option implements IField{
    private $page;
   
   public function __construct($page){
        $this->page = $page;
   }

    public function register(){
        \register_setting(
            $this->page, // option group
            'loy_secret', // option name
             [$this, 'validate_setting']     // validation callback :plausible
        );
      
        \add_settings_field(
            'loy_secret', // id
            'Fill in your LoyLap Secret:', // title
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
        
        $setting_value = \get_option('loy_secret');
        $setting_isset = $setting_value  != "" ||  $setting_value  != null ;
       
        echo '
        <div class="btn-group loy_edit" >
            <input type="text" name="loy_secret" value="'.\esc_attr($setting_value).'"/>
        </div>
    ';
    }

  

}