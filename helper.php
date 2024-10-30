<?php
namespace loylap;
class LoylapHelper{

    public static function LoginFailMessage( $reason ){
        $message = '';

        switch ($reason)  {
            case "NoCredentials":
                $message = 'You must login with your mercahnt credentials';
            break;
            case "wrongcredentials":
                $message = 'Incorrect email or password';
            break;
            case "NoPaymentToken":
                $message = '
                 You need to connect your bank account to LoyLap to recieve payments for Gift Card Sales. </br></br>
                 Login at <a href="https://dashboard.loylap.com/" target="_blank">dashboard.loylap.com</a> with your email and password and connect your merchant account in the Settings Page under the "Get Paid" section.</br></br>
                 Contact <a href="mailto:support@loylap.com">support@loylap.com</a> for help.'; 
            break;
            default: 
                $message = 'Could not log you in, try again later.' ;
            break;
        }

        return $message;
    }

    public static function hasGetParameterWithValue ($parameter , $value ){
        return isset($_GET[$parameter]) && $_GET[$parameter] == $value;
    }

    public static function isLoggedIn(){
        return \get_option("loy_api_key") != null || \get_option("loy_api_key") != "";
    }
    
    public static function HTTPSIsActive (){
        return \is_ssl();
    }

    public static function getCurrencySymbol ($country_code ) {
        
        switch($country_code){
            case 'IE':
            case 'DE':
            case 'NL':
            case 'FR': 
                return '€';
                break;


            case 'GB':
            case 'UK':
                return  '£';
                break;

            case 'US':
                return '$';
                break;
           
            default:
                return '';
                break;
        }
    
    }  
    

/**
 * Prints out all settings sections added to a particular settings page
 *
 * Part of the Settings API. Use this in a settings page callback function
 * to output all the sections and fields that were added to that $page with
 * add_settings_section() and add_settings_field()
 *
 * @global $wp_settings_sections Storage array of all settings sections added to admin pages.
 * @global $wp_settings_fields Storage array of settings fields and info about their pages/sections.
 * @since 2.7.0
 *
 * @param string $page The slug name of the page whose settings sections you want to output.
 */
public static function custom_loylap_settings_sections( $page ) {
global $wp_settings_sections, $wp_settings_fields;
    if ( ! isset( $wp_settings_sections[ $page ] ) ) {
        return;
    }
    foreach ( $wp_settings_sections[ $page ] as $section ) {
        if ( $section['title'] ) {
                echo "<h2>{$section['title']}</h2>\n";
        }
            if ( $section['callback'] ) {
                call_user_func( $section['callback'], $section );
        }
            if ( ! isset( $wp_settings_fields ) || ! isset( $wp_settings_fields[ $page ] ) || ! isset( $wp_settings_fields[ $page ][ $section['id'] ] ) ) {
                continue;
        }
        echo '<table class="form-table loylap-table">';
        do_settings_fields( $page, $section['id'] );
        echo '</table>';
        }
    }
    	
}