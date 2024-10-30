<?php
 /**
 * @wordpress-plugin
 * Plugin Name:       Loylap Gift Cards
 * Plugin URI:        https://www.loylap.com/gift-cards
 * Description:       This plugin makes it easy for you to integrate loylap giftcards into your wordpress website.
 * Version:           1.5.2
 * Author:            LoyLap
 * Author URI:        https://www.loylap.com/
 * Text Domain:       Loylap
 * Domain Path:       /languages
 **/

namespace loylap;

define("LOYLAP_PLUGIN_PATH", \plugin_dir_path(__FILE__));
define("LOYLAP_PLUGIN_URL" , \plugin_dir_url(__FILE__));
define("LOYLAP_DEBUG",  false);
define("LOYLAP_LIVE", true);

require_once LOYLAP_PLUGIN_PATH."config.php";
require_once LOYLAP_PLUGIN_PATH."helper.php";
require_once LOYLAP_PLUGIN_PATH."inc/loylap_integration.php";
require_once LOYLAP_PLUGIN_PATH."inc/options/LoylapOptions.php";
require_once LOYLAP_PLUGIN_PATH."Loylap_API.php";


$environment = ( LOYLAP_LIVE? "Live" : $_SERVER["HTTP_HOST"] == "localhost" ? "Local" : "Dev" );


new LoylapOptions();

// Make sure we are using ssl 
if ( LoylapHelper::HTTPSIsActive() ){
    new WP_Loylap(\get_option('loy_usage'));
} else {
     // the website is not using ssl 
}
