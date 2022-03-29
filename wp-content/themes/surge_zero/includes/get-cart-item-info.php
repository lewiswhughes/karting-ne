<?php
//retrieve dates and qtys for quicker links when booking another activity
$query_date = null;
$qty_total = null;
$qty_cadets = null;

//loop through cart to construct array
foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ){
  $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
  $product_obj = wc_get_product($product_id);
  $product_categories = wp_get_post_terms( $product_id, 'product_cat', array('fields'=>'slugs') );

  if( in_array( 'event', $product_categories )){
    $start = new DateTimeImmutable($cart_item['start']);
    $query_date = $start->format('Y-m-d');
    $qty_total = $cart_item['quantity'];
    $qty_cadets = $cart_item['qty-cadets'];
  }
}

?>
