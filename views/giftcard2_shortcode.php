<?php 
    $height = \get_option("loy_header_visible") === 'on' ? 975 : 825;
?>
<iframe src="<?php echo loylap\LoylapConfig::BuildIframeURI() ; ?>" frameborder="0" scrolling="no" width="100%"  id="inline_loylap_giftcards" height=<?php echo $height ?> >
</iframe>
