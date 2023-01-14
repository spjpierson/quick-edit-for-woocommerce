<?php
class CreateAdminPage{
 

    public function __construct(){
        add_action( 'init', array($this,'script_enqueuer') );
        add_action( "admin_menu", array($this,"quick_edit_page"));
        add_action( 'wp_ajax_update_batch_products', array($this,'update_batch_products_callbacks') );    
        add_action( 'wp_ajax_nopriv_update_batch_products', array($this,'update_batch_products_callbacks') );  
    }

    

   public function script_enqueuer() {
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'updates-products', plugins_url('js/updates-products.js', __FILE__), array(), '1.0', true );
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
        ?>
        <style>
            table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 98%;
            margin-top:1%;
        
        }
  
        td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
  }
  
        tr:nth-child(even) {
         background-color: #dddddd;
  }
       </style> 
        <?php

        
        // Get all products
        $products = wc_get_products( array('limit' => -1) );
        $total_products = 0;
        echo '<table>';
        echo '<tr>';
        echo '<th>Idex</th>';
        echo '<th>ID</th>';
        echo '<th>Tumbnail</th>';
        echo '<th>Product</th>';
        echo '<th>Type</th>';
        echo '<th>Price</th>';
        echo '<th>Edit Price</th>';
        echo '<th><button class="button-primary" onclick="upates_all_products()">Update All Products</button></th>';
        echo '<tr>';
        // Loop through each product
        foreach( $products as $product ) {
           
          if(floatval($product->get_price()) != 0 ){  
                echo '<tr>';
                echo '<td>'.$total_products.'</td>';
                echo '<td>'.$product->get_id().'</td>';
                echo '<td>';
                echo '<img height="25px" width="25px" src="'.wp_get_attachment_url( $product->get_image_id() ).'"/>';
                echo'</td>';
                echo '<td>'.$product->get_name().'</td>';
                echo '<td>'.$product->get_type().'</td>';
                $product_price = number_format(floatval($product->get_price()),2,".",",");
                echo '<td>$'.$product_price.'</td>';
                echo '<td><input id="'.$product->get_id().'-price" type="number" step="0.01" value="'.$product_price.'"/></td>';
                echo '<td> <input id="'.$total_products.'-index" value="'.$product->get_id().'" /></td>';
                echo '</tr>';
                $total_products++;
          }

            if($product->get_type() == "variable"){
                $children = $product->get_children();
                foreach($children as $child_id){
                    $child_product = wc_get_product($child_id);
                    if(floatval($child_product->get_price()) != 0 ){
                        echo '<tr>';
                        echo '<td>'.$total_products.'</td>';
                        echo '<td>'.$child_product->get_id().'</td>';
                        echo '<td>';
                        echo '<img height="25px" width="25px" src="'.wp_get_attachment_url( $child_product->get_image_id() ).'"/>';
                        echo'</td>';
                        echo '<td>'.$child_product->get_name().'</td>';
                        echo '<td>'.$child_product->get_type().'</td>';
                        $child_product_price = number_format(floatval($child_product->get_price()),2,".",",");
                        echo '<td>$'.$child_product_price.'</td>';
                        echo '<td><input id="'.$child_product->get_id().'-price" type="number" step="0.01" value="'.$child_product_price.'"/></td>';
                        echo '<td> <input id="'.$total_products.'-index" value="'.$child_product->get_id().'" /></td>';
                        echo '</tr>';
                        $total_products++;
                    }
                }
            }
        }
        echo '<tr>';
        echo '<th>Idex</th>';
        echo '<th>ID</th>';
        echo '<th>Tumbnail</th>';
        echo '<th>Product</th>';
        echo '<th>Type</th>';
        echo '<th>Price</th>';
        echo '<th>Edit Price</th>';
        echo '<th><button class="button-primary" onclick="upates_all_products()">Update All Products</button></th>';
        echo '<tr>';
        echo '<table>';
        echo '<input id="product_count" type="hidden" value="'.$total_products.'"/>';

    }

    public function update_batch_products_callbacks(){
        $product_ids = $_POST['products_ids'];
        $products_prices = $_POST['products_prices'];

        if(count($product_ids) === count($products_prices) ){
            
            // This is necessary for WC 3.0+
            if ( is_admin() && ! defined( 'DOING_AJAX' ) )
                    return;

            for($i = 0; $i < count($product_ids); $i++){
                update_post_meta($product_ids[$i],'_price',$products_prices[$i]);
        }
            echo json_encode("All Product has been updated");
            wp_die();
        }else{
            echo json_encode("something went wrong");
            wp_die();
        }
        
    }
}
?>