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

        echo '<table>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Tumbnail</th>';
        echo '<th>Product</th>';
        echo '<th>Type</th>';
        echo '<th>Price</th>';
        echo '<tr>';
        // Loop through each product
        foreach( $products as $product ) {
           
          if(floatval($product->get_price()) != 0 ){  
                echo '<tr>';
                echo '<td>'.$product->get_id().'</td>';
                echo '<td>';
                echo '<img height="25px" width="25px" src="'.wp_get_attachment_url( $product->get_image_id() ).'"/>';
                echo'</td>';
                echo '<td>'.$product->get_name().'</td>';
                echo '<td>'.$product->get_type().'</td>';
                $product_price = number_format(floatval($product->get_price()),2,".",",");
                echo '<td>$<input type="number" step="0.01" value="'.$product_price.'"/></td>';
                echo '</tr>';
          }

            if($product->get_type() == "variable"){
                $children = $product->get_children();
                foreach($children as $child_id){
                    $child_product = wc_get_product($child_id);
                    if(floatval($child_product->get_price()) != 0 ){
                        echo '<tr>';
                        echo '<td>'.$child_product->get_id().'</td>';
                        echo '<td>';
                        echo '<img height="25px" width="25px" src="'.wp_get_attachment_url( $child_product->get_image_id() ).'"/>';
                        echo'</td>';
                        echo '<td>'.$child_product->get_name().'</td>';
                        echo '<td>'.$child_product->get_type().'</td>';
                        $child_product_price = number_format(floatval($child_product->get_price()),2,".",",");
                        echo '<td>$<input type="number" step="0.01" value="'.$child_product_price.'"/></td>';
                        echo '</tr>';
                    }
                }
            }
        }

        echo '<table>';
    }
}
?>