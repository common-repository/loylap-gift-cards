<?php 
namespace loylap;
class LoylapConfig {

    public static function BuildIframeURI () {
        
        $baseURI = LoylapConfig::loylapURI();

        $apiKey = \get_option("loy_api_key");
        $headerImage = \get_option("loy_hi");
        $BusinessName = \get_option("loy_groupname");
        $country = \get_option("loy_country");
        $title = \get_option ("loy_title");
        $subtitle = \get_option ("loy_subtitle");
        $primary_colour = \get_option ("loy_primary_colour");
        $headervisible = \get_option("loy_header_visible");
        $successUrl = \get_option("loy_success_url");

        $apikeyOption = "";
        if( $apiKey != null && $apiKey  != "" ){
            $apikeyOption = "apikey=" . $apiKey;
        }
        
        $headerOption = "";
        if ( $headerImage != null && $headerImage != ""){
            $headerOption = "&header=" . $headerImage;
        }   

        $headerEnabledOption = "";
        if ( $headervisible != null && $headervisible != ""){
            $headerEnabledOption = "&header_enabled=" . $headervisible;
        }   



        $nameOption = "";
        if( $BusinessName != null && $BusinessName != "") {
            $nameOption = '&business_name='. $BusinessName;
        }

        $countryOption = "";
        if (  $country != null &&  $country != ""){
            $countryOption =  '&country=' . $country;
        }
        
        
        $titleOption = "";
        if (  $title != null &&  $title != ""){
            $titleOption =  '&title=' . $title;
        }
        
        $subtitleOption = "";
        if (  $subtitle != null &&  $subtitle != ""){
            $subtitleOption =  '&subtitle=' . $subtitle;
        }

        $primaryColourOption = "";
        if (  $primary_colour != null &&  $primary_colour != ""){
            $primaryColourOption =  '&primary_colour=' . $primary_colour;
        }

        $successUrlOption = "";
        if (  $successUrl != null &&  $successUrl != ""){
            $successUrlOption =  '&redirect_url=' . $successUrl;
        }
        


        return $baseURI."/external/widgets/wordpressWidget.php?".$apikeyOption.$headerOption.$countryOption.$titleOption.$subtitleOption.$primaryColourOption.$headerEnabledOption.$successUrlOption;
    
    }


    public static function ApiURI(){
        $Api = 'https://api.loylap.com';
        return \esc_url($Api);
    }

    public static function loylapURI (){
        $URI = 'https://www.loylap.com';
         return \esc_url($URI);
    }

    public static function  shouldShowDebugInfo(){
        return WP_DEBUG || LOYLAP_DEBUG && ! LOYLAP_LIVE;
    }

    
}