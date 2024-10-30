<div class="loylap_options">
<?php
use loylap\LoylapHelper;
use loylap\LoylapConfig;
require_once LOYLAP_PLUGIN_PATH . "config.php";
require_once LOYLAP_PLUGIN_PATH . "helper.php";

if ( LoylapHelper::isLoggedIn() == false) {
?>


<div class="loy_business_details">
    <?php
        if ( LoylapHelper::HTTPSIsActive() == false ){
            echo '
                <div class="loylap-fail">
                    <img src="'. LOYLAP_PLUGIN_URL . '/assets/images/lock_icon.png" alt="Lock icon">
                    <i>Your website is not using https!</i>
                    <br><br>
                    In order to use this plugin you must have https active on your website.
                    Please configure your SSL certificates and try again.
                </div>
            ';

            if (LoylapConfig::shouldShowDebugInfo() == false)
                return;
        }
    ?>
    <form action="<?php echo \admin_url('admin-post.php')?>" method="POST" class="loylap-form"> 
            <input type="hidden" name="action" value="update_loylap_settings">
            <img src="<?php LOYLAP_PLUGIN_URL . '/assets/images/loylapFulltext_purple.png'?>" class="loylap-logo">
            <h2 class="dark-text">Merchant login </h2>
            <?php if ( LoylapHelper::hasGETParameterWithValue( "status","loginfailed")){
            ?>

            <div class="loylap-fail">
                <h4>Login failed</h4>
                <?php 
                    $reason = $_GET['reason'];
                    echo LoylapHelper::LoginFailMessage($reason);
                ?>
            </div>

            <?php
             }
            ?>
            <label for="email" class="dark-text">Email</label> 
            <input type="email" name="email" >
            <label for="password" class="dark-text">Password:</label>
            <input type="password" name="password" >
            <input type="submit" value="LOGIN" id="loy_login" class="btn-loylap">

            <p class="dark-text">Don't have a Merchant account? <a href="https://dashboard.loylap.com/#/sign-up" target="_blank">Register here.</a></p>


        </form>
       
</div>
<div class="loylap-warning">
        <h4>Why am I getting this screen?</h4>

        You must login with your LoyLap merchant account before you can configure the widget!
    
</div>
    <?php
}
else {
?>

    

<div class="loy_business_details">
    <img src="<?php echo LOYLAP_PLUGIN_URL . '/assets/images/loylapFulltext_purple.png'?>" alt="Loylap logo" class="loylap-logo" >
    
    <div class="dropdown">
        <img src="<?php echo \get_option("loy_groupPhoto") !== '' ? \esc_url(\get_option("loy_groupPhoto")) : LOYLAP_PLUGIN_PATH . "/assets/images/loylap_icon_green.png" ;?>" alt="Brand" class="brand-logo">
        <div class="dropdown-toggle" id="dropdown-toggle">
            Business details 
            <img src="<?php echo LOYLAP_PLUGIN_URL . '/assets/images/002-arrow-1.png' ?>" alt="Arrow" class="arrow">
        </div>

        <div class="dropdown-content" id="dropdown-content" >
            <p class="dropdown-item"> 
                <b>Name: </b>
                    <?php echo \esc_html(\get_option('loy_groupname')); ?>
            </p>
            <p class="dropdown-item">
                <b>User Name: </b>
                    <?php echo \esc_html(\get_option("loy_username")); ?>
            </p>
            <p class="dropdown-item">
                <b>Gender: </b>
                    <?php echo \esc_html(\get_option("loy_gender")); ?>
            </p>
        </div>  
    </div>
    
  
    <form action="<?php echo \admin_url('admin-post.php')?>" method="POST" class="logout-form">
        <input type="hidden" name="action" value="logout_loylap_settings">
        <div class="logout-button">
        <input type="submit" id="loy_logout">
        </div>
    </form>   
    

        <?php 
        if ( LoylapConfig::shouldShowDebugInfo()){
        ?>
        <div class="loy-user-info loylap-apikey">
            <b>api key:</b>
        <?php echo \esc_html(\get_option("loy_api_key"));?>
        </div>
        <?php
        }
        ?>
    </div>


<form  action="options.php" method="POST">
        <?php
            \settings_fields( 'Loy_options_page' );
            LoylapHelper::custom_loylap_settings_sections( 'Loy_options_page' ); 
       
        ?>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button button-primary loylap-button btn-right" value="Save">
        </p>
</form>
    
<?php    
}
?>


</div>
