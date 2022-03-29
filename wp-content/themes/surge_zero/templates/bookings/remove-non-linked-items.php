<?php

//get linked items for all event items in cart
$linked_products = array();

//loop through cart to construct array
foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ){
  $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
  $product_obj = wc_get_product($product_id);
  $product_categories = wp_get_post_terms( $product_id, 'product_cat', array('fields'=>'slugs') );

  if( in_array( 'event', $product_categories )){
    //get cross-sells and add id to array
    $cross_sell_ids = $product_obj->get_cross_sell_ids();
    foreach( $cross_sell_ids as $cross_sell_id ){
      if( ! in_array( $cross_sell_id, $linked_products )){
        array_push( $linked_products, $cross_sell_id );
      }
    }
  }
}

//loop through again to remove items
foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ){
  $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
  $product_categories = wp_get_post_terms( $product_id, 'product_cat', array('fields'=>'slugs') );
  //remove if not in array
  if( in_array( 'miscellaneous', $product_categories )){
    if( ! in_array( $product_id, $linked_products )){
      WC()->cart->remove_cart_item( $cart_item_key );
    }
  }
}

?>
