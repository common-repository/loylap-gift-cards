<?php
namespace loylap;
require_once LOYLAP_PLUGIN_PATH . 'inc/IField.php';

class header_image implements IField{
    private $page;
   
   public function __construct($page){
        $this->page = $page;
   }

    public function register(){
        \register_setting(
            $this->page, // option group
            'loy_hi', // option name
             [$this, 'validate_setting']     // validation callback :plausible
        );

        \add_settings_field(
            'loy_hi', // id
            'Choose your header image: <p class="light-text">This will appear as the cover image of your digital gift card page.
            </p>', // title
            [$this,'display_api_setting'], // callback
            $this->page, // page
            'Loylap_settings' // section
        );
    }
    /**
     * Validates setting
     */
    function validate_setting($input){
        return \esc_url_raw($input);
    }


    /**
     * Display the setting
     */
    function display_api_setting(){
        
        $setting_value = \get_option('loy_hi');


        $setting_isset = $setting_value  != "" ||  $setting_value  != null ;
        $img_url = $setting_isset ? $setting_value  : LOYLAP_PLUGIN_URL."assets/images/LoylapGifcardHeader.png";
        $can_remove_img = $setting_isset ? "" : "disabled";
        $img = "background-image:url('".$img_url."')";


        echo  '
          

            <div class="loy_preview">
                <input id="chosen_header" type="hidden" name="loy_hi" value="'.\esc_attr($img_url).'" />
                <div style="'.\esc_attr($img).'" id="header-preview" class="loy_preview" ></div>
            </div>

            <div class="btn-group loy_edit" >
                <input id="remove_header" type="button" class="loylap-button-text text-red" value="Remove" '.esc_attr($can_remove_img).'>
                <input id="upload_header_button" type="button" class="button-primary loylap-button-outline" value="Upload image" />
            </div>
           

        ';
    }

  

}