<?php 
if( !defined('WP_UNINSTALL_PLUGIN') ) {
    die;
}

// specify which options to be removed from the wpdb
$options = [
    'loy_api_key',
    'loy_currency',
    'loy_employee_email',
    'loy_fbi',
    'loy_gender',
    'loy_groupid',
    'loy_groupname',
    'loy_groupPhoto',
    'loy_hi',
    'loy_usage',
    'loy_username',
    'loy_WC_integration',
    'loy_img_mode',
    'loy_secret',
    'loy_balance_check',
    'loy_header_visible',
    'loy_success_url'
];





// Remove all options from the database

foreach($options as $option_name ){
    delete_option ($option_name);
}   