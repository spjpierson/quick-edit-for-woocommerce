<?php
class CreateAdminPage{


    public function __construct(){
        add_action( "admin_menu", array($this,"quick_edit_page"));
    }

    public function quick_edit_page(){
        add_submenu_page( 
            'woocommerce', 
            "Product Price Quick Edit", 
            "Quick Edit", 
            "manage_options", 
            "product-quick-edit", 
            array($this,"display_page_content")
        );
    }

    public function display_page_content(){
        echo "test";
    }

}
?>