<?php 
namespace loylap;
/**
 *  Nigel Barink 14/05/2019
 *  
 *  Helpfull links 
 *  https://codex.wordpress.org/Function_Reference/get_page_by_title
 *  https://codex.wordpress.org/Plugin_API/Action_Reference
 *  https://wordpress.stackexchange.com/questions/29430/get-menu-object-from-theme-location
 *  https://codex.wordpress.org/Function_Reference/wp_delete_post
 *  https://developer.wordpress.org/reference/functions/wp_insert_post/
 *
 */
require_once LOYLAP_PLUGIN_PATH . 'helper.php';


class WP_Loylap {

    public static $page_id ;

    private $title;
    private $content;
    private $template; 

    // look at loylap usage setting here and initialize accordingly 
    public function __construct ($usage){
        switch($usage){
            case "shortcode": 
            // Initialize shortcode 
            $this->InitShortcode();
            break;
    
            case "wp_page": 
            // Initialize Giftcard pages
            $this->InitGiftCardPage ();
            break;
    
            default:
            // Do nothing
            break;
        }
    }

    /**
     *  Sets up the page content
     *  Was: __construct
     */
    private function InitGiftCardPage(){
        $this->title = "Gift Cards";
        $this->content =  '';
        $this->template = '';
        $this->content = $this->renderGiftCardPage();
    
        add_action ('wp_loaded', [$this, 'insertGiftCardPage']);
    }

    /**
     *  Creates a page if it doesn't already exist
     *  Was: init
     */
    public function insertGiftCardPage(){
        $page_check = \get_page_by_title($this->title);
        if(!isset($page_check->ID)){
            $new_page = array(
                'post_type' => 'page',
                'post_title' => $this->title,
                'post_content' => $this->content,
                'post_status' => 'publish',
                'post_author' => 1,
            );
            $new_page_id = \wp_insert_post($new_page);
        
            WP_Loylap::$page_id = $new_page_id;
        
            /* if(!empty($new_page_template)){
                    \update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
            }*/

            $new_page_link = ''; // \get_permalink ($new_page_id); 
        }
    }

    /**
     *  Function will render the content of the gift card page
     * Was: Render 
     */
    private function renderGiftCardPage(){
        $baseURI = 'https://www.loylap.com';
    
        if(\get_option("loy_api_key") != null && \get_option("loy_api_key") != "" )
        $apikeyOption = "apikey=" . \get_option("loy_api_key");
        
        $titleOption = "";
        if ( \get_option("loy_title") != null && \get_option("loy_title") != ""){
            $titleOption = "&title=".\get_option("loy_title");
        }   
        $subtitleOption = "";
        if ( \get_option("loy_subtitle") != null && \get_option("loy_subtitle") != ""){
            $subtitleOption = "&subtitle=".\get_option("loy_subtitle");
        }  
        $primaryColourOption = "";
        if ( \get_option("loy_primary_colour") != null && \get_option("loy_primary_colour") != ""){
            $primaryColourOption = "&primary_colour=".\get_option("loy_primary_colour");
        } 

        $headerOption = "";
        if ( \get_option("loy_hi") != null && \get_option("loy_hi") != ""){
            $headerOption = "&header=".\get_option("loy_hi");
        }   
        $nameOption = '';
        if( \get_option('loy_groupname') != null && \get_option('loy_groupname') != "") {
            $nameOption = '&business_name='.\get_option('loy_groupname');
        }
        $img_mode = '';
        if ( \get_option("loy_img_mode") != null && \get_option('loy_img_mode') != "" ){
            $img_mode  = "&img_mode=".\get_option("loy_img_mode");
        }
        $successUrlOption = '';
        if ( \get_option("loy_success_url") != null && \get_option('loy_success_url') != "" ){
            $success_url  = "&redirect_url=".\get_option("loy_success_url");
        }
        
        $uri = $baseURI."/external/widgets/wordpressWidget.php?".$apikeyOption.$titleOption.$subtitleOption.$primaryColourOption.$headerOption.$img_mode.$nameOption.$successUrlOption;
        return "<iframe src='".($uri)."' width='100%' height=720em' frameBorder='0' ></iframe>";
    }

    /**
     * Should get the menu slug 
     */
    function getMenuSlug ($theme_location ){
        $theme_locations = \get_nav_menu_locations();
        $menu_obj = \get_term( $theme_locations[$theme_location], 'nav_menu' );
      
        return $menu_obj->slug;
    }

    /**
    *   Function will inject handlers for the custom loylap shortcode(s) 
    *   Was: __construct
    */
    private function InitShortcode (){
        add_action("init", [$this,"EnableShortcode"]);
        add_action ("wp_enqueue_scripts", [$this, 'registerAssets']);
       
     
    }

    /**
    *   Function will add the shortcode(s) to wordpress
    *   Was: loy_shortcode 
    */
    public function EnableShortcode (){
        add_shortcode('short_loylap', [$this,'renderShortCode']);
        add_shortcode('short_loylap_inline', [$this, 'renderShortCode2']);
        add_shortcode("loylap_balance_check", [$this, 'renderBalanceChecker' ]);
    }

    /**
     *  Function to render the correct html for this shortcode(s) 
     *  Was: show_shortcode
     */
    public function renderBalanceChecker (){
        ob_start();
        include LOYLAP_PLUGIN_PATH . 'views/balance.php';
        return ob_get_clean();
   }

    /**
     *  Function to render the correct html for this shortcode(s) 
     *  Was: show_shortcode
     */
    public function renderShortCode (){
         $valuta_symbol = LoylapHelper::getCurrencySymbol(\get_option ("loy_currency"));
         ob_start();
         include LOYLAP_PLUGIN_PATH . 'views/giftcard_shortcode.php';
         return ob_get_clean();
    }

        /**
     *  Function to render the correct html for the second shortcode(s) 
     *  Was: show_shortcode
     */
    public function renderShortCode2 (){
        ob_start();
        include LOYLAP_PLUGIN_PATH . 'views/giftcard2_shortcode.php';
        return ob_get_clean();
   }

    /**
     *  function registers necessary assets to be loaded
     * Was: register_styles & register_scripts
     */
    public function registerAssets(){

        wp_enqueue_script('jquery');
        
        \wp_localize_script('loylap_paths', 'paths', array ('plugins_path' => LOYLAP_PLUGIN_PATH ) );
        
        // Javascript 
        \wp_enqueue_script('loylap', LOYLAP_PLUGIN_URL . 'assets/javascript/loylap.js');
        
        // Inject PHP variables into Javascript 
        $API_Key = \get_option('loy_api_key');
        $employee_email = \get_option('loy_employee_email');
        \wp_localize_script( 'loylap','settings', array('api_key'=> $API_Key, 'employee_email' => $employee_email));

        // CSS
        \wp_enqueue_style('loylap_style', LOYLAP_PLUGIN_URL . 'assets/css/loylap.css');
    
    }

}

