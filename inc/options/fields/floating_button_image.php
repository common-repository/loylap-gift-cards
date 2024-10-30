<?php
namespace loylap;
require_once LOYLAP_PLUGIN_PATH . 'inc/IField.php';

class floating_button_image implements IField{
    private $page;
   
   public function __construct($page){
        $this->page = $page;
   }

    public function register(){
        \register_setting(
            $this->page, // option group
            'loy_fbi', // option name
             [$this, 'validate_setting']     // validation callback :plausible
        );


        \add_settings_field(
            'loy_fbi', // id
            'Choose your floating button image: <p class="light-text" > This button will be displayed in the bottom right corner of your webpage</p>', // title
            [$this,'display_api_setting'], // callback
            $this->page, // page
            'Loylap_settings' // section
        );
    }
    /**
     * Validates setting
     */
    function validate_setting($input){
        return \esc_url_raw ($input);
    }


    /**
     * Display the setting
     */
    function display_api_setting(){

        $setting_value = \get_option('loy_fbi');
        $setting_isset = $setting_value  != "" ||  $setting_value  != null ;
        $img_url = $setting_isset ? $setting_value  : LOYLAP_PLUGIN_URL."assets/images/loylap_icon_purple.png";
        $can_remove_img = $setting_isset ? "" : "disabled";
        
        echo '
            <div class="loy_preview">
                <input id="chosen_fab" type="hidden" name="loy_fbi" value="'.\esc_attr($img_url).'" />
                <img src="'.\esc_attr($img_url).'" id="fab-preview" class="loy_preview_circle">
            </div>
           
            <div class="btn-group loy_edit" >
                <input id="remove_fab" type="button" class="loylap-button-text text-red" value="Remove" '.\esc_attr($can_remove_img).'>
                <input id="upload_fab_button" type="button" class="button-primary loylap-button-outline" value="Upload image" />
            </div>
        ';
    }

  

}