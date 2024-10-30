<?php
namespace loylap;

require_once LOYLAP_PLUGIN_PATH . "inc/options/loylapOptionsSection.php";
require_once LOYLAP_PLUGIN_PATH . "helper.php";

class LoylapOptions
{
    private $page_name = "Loylap Options";
    private $page_slug = "Loy_options_page";


    public function  __construct (){
          // register our page in the admin menu 
          add_action ('admin_menu', [$this, 'admin_menu']);

         add_action ("wp_enqueue_scripts", [$this, "register_localized_scripts"]);
         add_action ("admin_enqueue_scripts" , [$this, "register_admin_stylesheets"]);
         add_action("admin_enqueue_scripts", [$this, "load_wp_libraries"]);
         add_action ('admin_enqueue_scripts', [$this, "register_admin_scripts"]);

     
         // register loylap business login logic
         add_action ("admin_post_update_loylap_settings", [$this, "loylap_handle_save"] );
         add_action ("admin_post_logout_loylap_settings", [$this, 'loylap_handle_logout']);


          // register sections 
          $this->add_sections();
    }

    /**
     * load extra wordpress libraries
     */
    function load_wp_libraries (){
        
        // load wordpress media library
        \wp_enqueue_media();
    }

    /**
     * Do a loylap merchant logout
     */
    function loylap_handle_logout() {

        \update_option ("loy_groupid", null);
        \update_option("loy_username", null);
        \update_option ("loy_api_key", null);
        \update_option ("loy_groupPhoto", null );
        \update_option ("loy_groupname", null);
        \update_option ("loy_gender", null);
        \update_option( "loy_currency", null );
        \update_option( "loy_success_url", null );
        

        $redirect_url = \get_admin_url() . "/admin.php?page=Loy_options_page&status=success";
        header("Location:".$redirect_url);
    }

    /**
     * Do a loylap merchant login 
     */
    function loylap_handle_save (){
       
        $API = LoyLapAPI::factory();
       
        $email  = (!empty($_POST["email"])) ? $_POST["email"] : NULL;
        $password =(!empty($_POST["password"])) ? $_POST["password"] : NULL;

        if ( $email == null || $password == null ){
            $this->LoginFailed("NoCredentials");
            return;
        }
          
        $user = $API->login($email, $password);
        if (  $user == false ){
            $this->LoginFailed('wrongcredentials');
            return;
        }
     
        // make sure we have a payment token 
        // GET: <some api >
        if($API->hasPaymentToken($user) == false ) {
           $this->LoginFailed("NoPaymentToken");
            return;
        }

        $merchant = $API->getBusinessDetails($user->tokens->access_token, $user->merchant->id)[0];

   
        if ( $merchant) {
        
            $country = $merchant->location->country;
            
        }else{
            $country  = "";
        }
   

        \update_option ("loy_groupid", $user->merchant->id);
        \update_option("loy_username", $user->user->name);
        \update_option ("loy_api_key", $user->tokens->refresh_token);
        \update_option ("loy_groupPhoto", $user->user->photo );
        \update_option ("loy_groupname", $user->merchant->name);
        \update_option ("loy_gender", $user->user->gender);
        \update_option("loy_country", $country );
         \update_option( "loy_jwt" , $user->tokens->access_token );

        $redirect_url = \get_admin_url() . "admin.php?page=Loy_options_page&status=success";
        header("Location:".$redirect_url);

    }

    /** 
     * On login failed 
     */
    function LoginFailed ( $reason) {

        $redirect_url = \get_admin_url() . "admin.php?page=Loy_options_page&status=loginfailed&reason=".$reason;
        header("Location:".$redirect_url);
        return;
    }

    /**
     * register the menu option
     */
    function admin_menu (){

        add_menu_page(
            $this->page_name,
            $this->page_name,
            "manage_options",
            $this->page_slug,
            array($this,'show_page')
            // needs a data url
        );

    }

    /**
     * register the sections
     */
    function add_sections () {
        new loylap_section ();
      //  new wc_integration_section();
    }


    /**
     * show the settings page content
     */
    function show_page(){
        include LOYLAP_PLUGIN_PATH . 'views/options.php';
    }


    /**
     * include front-end files 
     */
    function register_admin_stylesheets ()
    {
        wp_enqueue_style( 'loylap-options-style', LOYLAP_PLUGIN_URL . "assets/css/admin/loy_admin.css" );
    }

    /** 
     * Register javascript files for admin pages
     */
    function register_admin_scripts(){
        
        wp_enqueue_script('jquery');

       \wp_enqueue_script('loylap-media-uploader', LOYLAP_PLUGIN_URL . "/assets/javascript/loylap-mediaUploader.js");
        \wp_enqueue_script('loylap-dropdown', LOYLAP_PLUGIN_URL . '/assets/javascript/loylap-dropdown.js');
    }

    function register_localized_scripts() {
        // insert generalized paths into javascript
        \wp_localize_script('loylap_paths', 'paths', array ('plugins_path' => LOYLAP_PLUGIN_PATH ) );  
    }
}