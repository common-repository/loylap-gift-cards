<?php
namespace loylap;
require_once LOYLAP_PLUGIN_PATH . 'inc/IField.php';

class success_url implements IField{
   private $page;
   public function __construct($page){
        $this->page = $page;
   }

    public function register(){

        $notice = '
                <p class="light-text">
                    Please enter a valid URL to redirect your customers to after a successful purchase
                </p>
            ';

        \register_setting(
            $this->page, // option group
            'loy_success_url', // option name
             [$this, 'validate_setting']     // validation callback :plausible
        );


        \add_settings_field(
            'loy_success_url', // id
            'success url</br>'.$notice, // title
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
        $title = \get_option('loy_success_url');

        echo  '
        
        <div class="loy_edit">
           <input type="url" id="loy_success_url" name="loy_success_url"  pattern="https?://.+" placeholder="https://example.com" title="Valid URLs only beginning with https://"' .  ( $title != null || $title != "" ? "value='".$title."'" : "" ) . '/>
        </div>
            ';
    }
}