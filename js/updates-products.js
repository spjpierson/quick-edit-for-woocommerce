function upates_all_products(){
    const $ = jQuery;
    const product_count = $('#product_count').val();
    let batch_products_id = [];
    let batch_products_price = [];
    
    for(var i = 0; i < product_count; ++i){
        var id = "#"+i+"-index";
        var product_id = $(id).val();
        var price_id = "#"+product_id +"-price";
        var product_price = $(price_id).val();
        batch_products_id.push(product_id);
        batch_products_price.push(product_price);
    }

    alert("Price Data Was Sent You Should Get a Message In Less Then 30 Seconds");
  
    jQuery.ajax({
        type:'POST',
        dataType:'json',
        url:ajaxurl,
        data:{
            action:'update_batch_products',
            products_ids:batch_products_id,
            products_prices:batch_products_price
        },
        success:function(response){
            alert(response);
            window.location.reload();
        },
        fail:function(response){
            alert(response);
        }
    }); 

    
}