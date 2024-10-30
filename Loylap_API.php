<?php
namespace loylap;

require_once LOYLAP_PLUGIN_PATH . "/sanitizer.php" ;

class LoyLapAPI {
    //public static $instance ; 
    private $api_uri;

    private function __construct() {
            $this->api_uri = LoylapConfig::ApiURI();    
    }

    public static function factory (){
        return new LoyLapAPI();
    }

    /**
     * Make a login call
     * @param {String}  $email // The merchants email with which he wants to login 
     * @param {string} $password // The merchants password 
     */
    public function login ($email, $password) {
        $apiCall = ($this->api_uri . "/api/v2/auth/login/email");
        
        $appSecret = \get_option("loy_secret");
        
        $response = \wp_remote_post(
            $apiCall,
             [
            'body' => [
                'email' => Sanitizer::Email( $email ) ,
                'password' => Sanitizer::Password($password)
            ],
            'headers'=> [
                "AppSecret" => $appSecret
                 ]
            ]
        );

        $user = json_decode( \wp_remote_retrieve_body($response));
        return  $user != null ? $user : false  ; 
    }

    /**
     * Ask api for business details
     * @param {*} $auth // Authorization token 
     * @param {*} $business_id // Id of the business you want to get details off. 
     */
    public  function getBusinessDetails($auth , $business_id){
        $apiCall = ($this->api_uri . "/api/v2/merchants/" . Sanitizer::Number($business_id));
        $appSecret = \get_option("loy_secret");
        $response = \wp_remote_get(
            $apiCall,
             [
               "headers" => [
                    "Authorization" => $auth,
                    "AppSecret" => $appSecret
                ]
             ]
        );

        $business = json_decode( \wp_remote_retrieve_body($response));
        

        return  $business != null  ? $business : false  ; 
    }

    /**
     * Check for payment tokens
     * 
     * @param {*} $user // User object retrieved from login
     */
    public function hasPaymentToken($user){
      
    $merchantId = $user->merchant->id;
    if ( $merchantId == ''  || $merchantId == NULL) {
        return false;
    }


    $response = \wp_remote_get( $this->api_uri . "/api/v2/merchants/". $merchantId );
    
    $merchant = json_decode( \wp_remote_retrieve_body( $response ) )[0];
	$hasPaymentaccount = $this->canAcceptPayment($merchant); 


	if ( $hasPaymentaccount == false ) {
       
        return false;
	}
        return true;

    }

    /**
     *  Make sure the payment details are set.
     * 
     * @param {*} $merchant // Merchant object retrieved from login
     */
    private function canAcceptPayment($merchant) {
        return 
        empty($merchant->paymentAccounts[0]->account_number) == false 
        &&
        empty($merchant->paymentAccounts[0]->secret) == false;
    }


    // 90009796
    public function memberCall($memberId){
        $apiCall = $this->api_uri . "/api/v2/member/cards/" . $memberId;
        $data = [ 
            "headers" => [
                "Authorization"=> \get_option("loy_jwt"),
                "AppSecret"=> \get_option("loy_secret")
            ],
        ];
        $response = \wp_remote_get($apiCall, $data);
        $json = wp_remote_retrieve_body($response);

        $memberInfo = \json_decode($json);
        return $memberInfo;

    }

    // HANDLE JWT
    /**
     *  Ask for a new JWT with our refresh token 
     * 
     *  @param {String} $token  // refresh_token
     * 
     */
    public function refresh ($token) { 
        
        $apiCall = $this->api_uri . "/api/v2/auth/refresh";

        $data = [
            "body" => [
                "refresh_token" => $token
            ]
        ];

        $response = \wp_remote_post($apiCall, $data);
        $json  = \wp_remote_retrieve_body($response);
       

        $new_tokens = \json_decode($json);

        return $new_tokens; 
    }

}
