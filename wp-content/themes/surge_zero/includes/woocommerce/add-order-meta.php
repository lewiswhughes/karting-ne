<?php

//update meta from cart items on submit checkout
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {

  $discounts = array();
  //reservations
  $reservations = array();
  foreach(WC()->cart->get_cart() as $cart_item){

    $product = wc_get_product( $cart_item['data']->get_id() );

    //discount amounts
    $price = $product->get_price();
    $regular_price = $product->get_regular_price();
    $discount = $cart_item['quantity'] * ($regular_price - $price);
    if( $discount > 0 ){
      if( array_key_exists( $cart_item['check-id'], $discounts )){
        $discounts[$cart_item['check-id']] = $discounts[$cart_item['check-id']] + $discount;
      } else {
        $discounts[$cart_item['check-id']] = $discount;
      }
    }

    if( (int) $cart_item['reservation-id'] > 0 ){
      $reservation = array(
        'event-title' => $product->get_title(),
        'reservation-id' => $cart_item['reservation-id'],
        'event-reservation-id' => $cart_item['event-reservation-id'],
        'check-id' => $cart_item['check-id'],
        'start' => $cart_item['start'],
        'quantity' => $cart_item['quantity'],
        'qty-cadets' => $cart_item['qty-cadets'],
        'qty-inductions' => $cart_item['qty-inductions'],
        'customer-id' => $cart_item['customer-id'],
        'wc-product-id' => $cart_item['data']->get_id(),
        'price' => $product->get_price(),
        'regular-price' => $product->get_regular_price()
      );
      array_push($reservations, $reservation);
      //customer id
      update_post_meta( $order_id, 'customer-id', $cart_item['customer-id'] );

    }
  }

  if( count( $reservations) > 0 ){
    update_post_meta( $order_id, 'reservations', $reservations );
  }

  update_post_meta( $order_id, 'discounts', $discounts );
}

//display fields in dashboard
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta( $order ){
  //customer id
  $customer_id = get_post_meta( $order->get_id(), 'customer-id', true );
  echo '<h3>Customer ID</h3>';
  echo '<p>'.$customer_id.'</p>';
  
  //discount notes
  $discounts = get_post_meta( $order->get_id(), 'discounts', true );
  $fees = $order->get_fees();
  //discounts
  echo '<h3>Discounts</h3>';
  foreach( $discounts as $check_id => $discount_value ){
    echo '<p>Check Id: '.$check_id.'</p>';
    echo '<p>Check Discount Amount: '.$discount_value.'</p>';
  }
  //fees
  foreach ($fees as $key => $fee) {
    //check less than 0
    if( $fee->get_total() < 0 ){
      echo '<p><h4>Cart Fees<h4></p>';
      echo '<p>'.$fee->get_name().': '.$fee->get_total() * (-1).'</p>' ;
    }
  }

  //reservation details
  $reservations = get_post_meta( $order->get_id(), 'reservations', true );
  echo '<h3>Reservations</h3>';
  echo '<div>';
  if( is_array( $reservations) ){
    foreach( $reservations as $reservation ){
      //display date/time
      $start = new DateTime($reservation['start']);
      //cadet only?
      $cadets_only = get_field( 'cadets_only', $reservation['wc-product-id'] );
      $qty_cadets = ( $cadets_only > 0 ) ? $reservation['quantity'] : $reservation['qty-cadets'] ;

      echo '<div style="border-bottom: 1px solid grey; border-top: 1px solid grey;">';
      echo '<p>';
      echo '<strong>Event Title: </strong>';
      echo $reservation['event-title'];
      echo '</p>';
      echo '<p>';
      echo '<strong>Reservation ID: </strong>';
      echo $reservation['reservation-id'];
      echo '</p>';
      echo '<p>';
      echo '<strong>Event Reservation ID: </strong>';
      echo $reservation['event-reservation-id'];
      echo '</p>';
      echo '<p>';
      echo '<strong>Check ID: </strong>';
      echo $reservation['check-id'];
      echo '</p>';
      echo '<strong>Customer ID: </strong>';
      echo $reservation['customer-id'];
      echo '</p>';
      echo '<p>';
      echo '<strong>Start Date/Time: </strong>';
      if($start){
        echo $start->format('l, jS F Y, H:i');
      }
      echo '</p>';
      echo '<p>';
      echo '<strong>Total Quantity: </strong>';
      echo $reservation['quantity'];
      echo '</p>';
      echo '<p>';
      echo '<strong>Qty Cadets: </strong>';
      echo $qty_cadets;
      echo '</p>';
      echo '<p>';
      echo '<strong>Qty Inductions: </strong>';
      echo $reservation['qty-inductions'];
      echo '</p>';
      echo '<p>';
      echo '<strong>WC Product ID: </strong>';
      echo $reservation['wc-product-id'];
      echo '</p>';
      echo '<p>';
      echo '<strong>Price Paid: </strong>';
      echo $reservation['price'];
      echo '</p>';
      echo '<p>';
      echo '<strong>Regular Price: </strong>';
      echo $reservation['regular-price'];
      echo '</p>';
      echo '</div>';
    }
  }
  echo '</div>';

}



?>
