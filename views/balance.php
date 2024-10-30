<?php
require_once LOYLAP_PLUGIN_PATH . "/helper.php"; 
require_once LOYLAP_PLUGIN_PATH . "/Loylap_API.php"; 
/** 
 * Demo code 
 */
if( isset($_POST["balanceCheck_submit"])){
    $api =  loylap\LoyLapAPI::factory();

    // return random balance 
    $balance = random_int(0,40);
    $didRefreshToken = false;
    $jwtUsed1 = \get_option ("loy_jwt");
    $memberInfo = $api->memberCall($_POST["cardNumber"]);
    if ( isset($memberInfo->message)) {
        $new_tokens = $api->refresh(\get_option("loy_api_key"));
        
        echo $new_tokens->access_token;

        \update_option ("loy_jwt", $new_tokens->access_token);
        \update_option("loy_api_key", $new_tokens->refresh_token);
        $didRefreshToken = true;
        $memberInfo = $api->memberCall($_POST['cardNumber']);

    }

}

?>
<div class="loylap_balance_check" id="loylapBalance">
    <h3>Check your gift card balance</h3>
    <form action="#loylapBalance" method="POST" id="balanceCheckForm">
       
    
        <input type="text" name="cardNumber"  id="balance_cardnumber"  placeholder="Card number" required>
        <input type="text" name="cvv" pattern="\d{3}" id="balance_cvv" placeholder="3-digit cvv" required>

        <?php 
        if(isset($_POST["balanceCheck_submit"])){
            $balance = $memberInfo->balance;
            if ( isset($memberInfo->message) ){
             /*   $jwtUsed = \get_option("loy_jwt");
                echo "first JWT used " .substr($jwtUsed1, (strlen($jwtUsed1) - 8), 8 ). "</br>" ;        
                echo "second JWT used " .substr($jwtUsed, (strlen($jwtUsed) - 8), 8 ). "</br>" ;
                echo "Did refresh token " .( $didRefreshToken ? "Yes" : "No") . "</br>";
                echo $memberInfo->message;*/
                echo `Failed to get balance {$memberInfo->message}`;
            } else if ( $balance == NULL) {
                echo "Failed to get your balance";
            }else{
                echo "<div class='loylap_balance' > ";
                echo  "<p class='value'>". loylap\LoylapHelper::getCurrencySymbol(\get_option ("loy_country")) . " " .$balance->cash . " </p>";
                echo "<p class='smallText'>Your current balance</p>";
                echo "</div>" ;
            
            }
            
        }    
        ?>

        <input type="submit" name="balanceCheck_submit" value="Check">
    </form>



             
<div id="loylap-mark"> 
    <a href="https://www.loylap.com">
        <div id="loylap-logo">
        </div>
        </a>
    </div>
</div>
