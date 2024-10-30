jQuery( function (){
   
    jQuery('#upload_fab_button').click(function (e) {  e.preventDefault(); uploadImageAction('#fab-preview','#chosen_fab'); });
    jQuery('#remove_fab').click( function (e) { e.preventDefault(); removeImageAction('#fab-preview', '#chosen_fab', 'loylap_icon_purple.png'); });


    jQuery('#upload_header_button').click(function (e) {  e.preventDefault(); uploadImageAction('#header-preview','#chosen_header'); });
    jQuery('#remove_header').click(function (e) { e.preventDefault(); removeImageAction('#header-preview','#chosen_header', 'LoylapGiftcardHeader.png'); });






    let imageFolder =  './../assets/images/';

let uploadImageAction = function (previewId, FieldId){
    let mediaUploader;
    if(mediaUploader){
        mediaUploader.open();
        return;
    }
    mediaUploader = wp.media.frames.file_frame = wp.media({
        title: 'Pick an image',
        button: {
            text: 'Choose'
        },
        multiple: false
    });

    mediaUploader.on("select", function () {
        let attachment = mediaUploader.state().get('selection').first().toJSON();
        jQuery(FieldId).val(attachment.url);
        let tagname = jQuery(previewId).prop("tagName");
        switch(tagname){
            case "DIV":
                jQuery(previewId).attr ('style', 'background-image: url(' + attachment.url + ')');
            default:
                jQuery(previewId).attr('src', attachment.url); 
            break;
            }
        jQuery(previewId).attr('src', attachment.url);
    });

    mediaUploader.open();
}

let removeImageAction = function (previewId, FieldId, defaultImage){
    let PreviewSrc = imageFolder + defaultImage;
    let tagname = jQuery(previewId).prop("tagName");
    switch(tagname){
        case "DIV":
                jQuery(FieldId).val("");
                jQuery(previewId).attr('style', 'background-image: url(' + PreviewSrc + ")");
        default:
                jQuery(FieldId).val("");
                jQuery(previewId).attr('src', PreviewSrc);
        break;
        }
    
}

});

