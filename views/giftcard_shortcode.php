<?php
require_once LOYLAP_PLUGIN_PATH . "config.php";
$height = \get_option("loy_header_visible") === 'on' ? 975 : 825;
?>
<span class="loylap-circle" id="loylap_toggle" style="background-image: url(<?php echo \get_option('loy_fbi');?>)" ></span>

<iframe src="<?php echo loylap\LoylapConfig::BuildIframeURI() ; ?>" frameborder="0" id="loylap_widget" height=<?php echo $height ?> class="loylap_giftcards">
</iframe>