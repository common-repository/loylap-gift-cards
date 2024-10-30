<?php

namespace loylap;

class Sanitizer {

        public static function Email($email ){
                return \sanitize_email($email);
        }

        public static function Password($password){
                return \sanitize_text_field( trim($password) ); 
        }

        public static function Number ($n){
                if (!  is_numeric($n)){
                        return 0;
                }
                return \sanitize_text_field($n);
        }
        

}