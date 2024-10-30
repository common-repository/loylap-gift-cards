<?php
namespace loylap;

require_once LOYLAP_PLUGIN_PATH."inc/ISection.php";

class loylap_settings_section implements ISection {
    private $section_id ;
    private $title;
    private $page;


    public function __construct(){
     
        //register new section 
        add_action ('admin_init', [$this, 'register_fields']);
        
    }

    public function set_section_id($section_id){
        $this->section_id = $section_id;
    }

    public function set_title($title){
        $this->title = $title;
    }

    public function set_page($page){
        $this->page = $page;
    }

    public function get_section_id(){
        return $this->section_id;
    }

    public function get_title(){
       return $this->title;
    }

    public function get_page(){
        return $this->page;
    }

    function add_section (){
        
        \add_settings_section(
            $this->section_id,    // id     
            $this->title,    // title 
            [$this,'show_header'], // callback
            $this->page // page 
        );

    }

    /** 
     * register admin settings
     */
    function register_fields(){
        //NOTE: Order matters here!
        $this->add_section();
    }
    
    /**
     * What shows up first in the section 
     */
    function show_header() {
        echo \esc_html('empty header!');
    }
}