<?php

//CREATE CHECK FUNCTION
function createCheck( $total, $customerId ){
  $type = 1; //regular check
  $now = new DateTime();
  $openedDate = $now->format('Y-m-dTH:m:s');

  $url = 'https://knesunderland.clubspeedtiming.com/api/index.php/checks?key='.getenv('CLUBSPEED_API_KEY').'&customerId='.$customerId.'&type='.$type.'&status=0&name=MiscItemsCheck&openedDate='.$openedDate.'&userId=2&total='.$total.'&discount=0';

  error_log('curl url: '.$url);
  //open connection
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
  // curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //execute post
  $result = curl_exec($ch);

  return $result;
}

//CREATE CHECK DETAILS FUNCTION
function createCheckDetails( $checkId, $item ){

  $now = new DateTime();
  $createdDate = $now->format('Y-m-dTH:m:s');

  $url = 'https://knesunderland.clubspeedtiming.com/api/index.php/checkDetails?key='.getenv('CLUBSPEED_API_KEY').'&checkId='.$checkId.'&status=1&type=1&productId='.$item['productId'].'&createdDate='.$createdDate.'&qty='.$item['quantity'].'&unitPrice='.$item['unitPrice'].'&discountApplied=0&taxId=1&r_Points=null';

  error_log('curl url: '.$url);
  //open connection
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
  // curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //execute post
  $result = curl_exec($ch);

  return $result;

}

//PAY CHECKS FUNCTION
function payCheck( $check_id, $checkTotal ){

  error_log('check total: '.$checkTotal);
  // make payment
  $url = 'https://knesunderland.clubspeedtiming.com/api/index.php/payments?key='.getenv('CLUBSPEED_API_KEY').'&checkId='.$check_id.'&payAmount='.$checkTotal;
  error_log('curl url: '.$url);
  //open connection
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //execute post
  $result = curl_exec($ch);
  error_log('payment result: '.$result);

  return $result;
}

function updateEventReservation( $event_reservation_id, $notes ){
  //CURL SET EVENT RESERVATION STATUS TO ONLINE - 6 as appears at index 6 when listing event status in order of seq/status https://knesunderland.clubspeedtiming.com/api/index.php#event-reservations-update-event-status
  $url = 'https://knesunderland.clubspeedtiming.com/api/index.php/eventReservations/'.$event_reservation_id.'?key='.getenv('CLUBSPEED_API_KEY').'&status=6&notes='.urlencode($notes);
  error_log('event res update: '.$url);
  //open connection
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_CUSTOMREQUEST, 'PUT');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
  // curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //execute post
  $result = curl_exec($ch);
  error_log('event res update result '.$event_reservation_id.': '.$result);

  //close connection
  curl_close($ch);
}

function updateCheck( $check_id, $discount_value ){
  //CURL SET EVENT RESERVATION STATUS TO ONLINE - 6 as appears at index 6 when listing event status in order of seq/status https://knesunderland.clubspeedtiming.com/api/index.php#event-reservations-update-event-status
  $discount_note = 'Reduced by '.$discount_value;
  $url = 'https://knesunderland.clubspeedtiming.com/api/index.php/checks/'.$check_id.'?key='.getenv('CLUBSPEED_API_KEY').'&discountNotes='.urlencode($discount_note).'&discount='.$discount_value;
  error_log('check update: '.$url);
  //open connection
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_CUSTOMREQUEST, 'PUT');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
  // curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //execute post
  $result = curl_exec($ch);
  error_log('check update result '.$check_id.': '.$result);

  //close connection
  curl_close($ch);
}

function getCustomerId( $email, $firstname, $lastname ){
  $customer_id = checkCustomerExists( $email );
  error_log('retrieved customer id: ' . $customer_id );
  if( $customer_id ){
    return $customer_id;
  } else {
    return createCustomer( $email, $firstname, $lastname );
  }
}

function checkCustomerExists( $email ){
  $url = 'https://knesunderland.clubspeedtiming.com/api/index.php/customers/?key='.getenv('CLUBSPEED_API_KEY').'&select=customerId&where={"email":"'.$email.'"}';
  error_log('get user: '.$url);
  //open connection
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_CUSTOMREQUEST, 'GET');
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
  // curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //execute post
  $result = curl_exec($ch);
  error_log('get customer result '.$email.': '.$result);
  //close connection
  curl_close($ch);
  //chck reuslt
  $customers = json_decode( $result, true );
  if( count( $customers ) > 0 ){
    return $customers[0]['customerId']; //first result only
  } else {
    return null;
  }
}

function createCustomer( $email, $firstname, $lastname ){
  $now = new DateTimeImmutable();
  $url = 'https://knesunderland.clubspeedtiming.com/api/index.php/customers/?key='.getenv('CLUBSPEED_API_KEY').'&accountCreated='.$now->format('Y-m-dTH:i:s').'&email='.$email.'&firstname='.$firstname.'&lastname='.$lastname;

  error_log('curl url: '.$url);
  //open connection
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
  // curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  //execute post
  $result = curl_exec($ch);

  return $result;
}


//ADD ACTION
add_action( 'woocommerce_payment_complete', 'complete_reservation', 10, 1);

// add_action( 'woocommerce_order_status_processing', 'complete_reservation', 10, 1); //debugging purposes

function complete_reservation( $order_id ){
  $order = wc_get_order( $order_id );
  $total = $order->get_total();
  $order_items = $order->get_items();
  $email = $order->get_billing_email();
  $firstname = $order->get_billing_first_name();
  $lastname = $order->get_billing_last_name();
  $misc_items = array();
  $voucher_items = array();
  $reservations = get_post_meta( $order_id, 'reservations', true );
  $check_id = $reservations[0]['check-id'];
  $customer_id = get_post_meta( $order_id, 'customer-id', true );
  $discounts = get_post_meta( $order_id, 'discounts', true );
  $fees = $order->get_fees();
  $item_checks = array();
  $now = new DateTime();
  $date = $now->format('d-m-Y H:m:s');

  $notes = '===========';
  $notes.= $date.' || ';
  $notes.= 'Part of WC Order: '.$order_id.' || ';

  $reservation_notes = 'RESERVATION ITEMS IN ORDER:  ';
  $misc_item_notes = 'OTHER ITEMS:  ';
  $cart_fee_notes = '';

  //CREATE CHECK FOR MISC ITEMS
  if( is_array($order_items)){

    foreach( $order_items as $order_item ){

      $product = wc_get_product( $order_item['product_id'] );
      $price = $product->get_price();
      $product_id = get_field( 'product_id', $order_item['product_id']);
      $title = $product->get_title();

      //construct misc items array
      if( has_term('miscellaneous', 'product_cat', $order_item['product_id'])){

        $misc_item_notes.= $title.' x'.$order_item['quantity'].' || ';

        $item_details = array(
          'productId' => $product_id,
          'quantity' => $order_item['quantity'],
          'unitPrice' => $price
        );

        array_push( $misc_items, $item_details );
      }

      //if voucher
      if( has_term('voucher', 'product_cat', $order_item['product_id'])){
        $item_details = array(
          'productId' => $product_id,
          'quantity' => $order_item['quantity'],
          'unitPrice' => $price
        );
        array_push( $voucher_items, $item_details );
      }

      //create check detailseses for misc items - attach to event check
      $subtotal = $order_item['quantity'] * $price;
    }

    //loop through misc items
    foreach( $misc_items as $misc_item ){
      $newCheckDetailsId = createCheckdetails( $check_id, $misc_item );
      error_log('New check details: '.$newCheckDetailsId);
      if( array_key_exists( $check_id, $item_checks )){
        $item_checks[$check_id] = $item_checks[$check_id] + $subtotal;
      } else {
        $item_checks[$check_id] = (double) $subtotal;
      }
    }

    //loop through vouchers
    foreach( $voucher_items as $voucher_item ){
      $total = $voucher_item['quantity'] * $voucher_item['unit_price'];
      createCheckdetails( createCheck( $total, getCustomerId( $email, $firstname, $lastname ) ), $voucher_item );
    }
  }

  //LOOP THROUGH RESERVATIONS
  if( is_array( $reservations ) ){
    //LOPP THROUGH TO CONSTRUCT NOTES AND ADD CHECK ID TO ARRAY
    foreach( $reservations as $reservation ){
      //CHECK IF ITEM DISCOUNTED / ON SALE
      //ADD CHECK ID TO ARRAY
      $check_id = $reservation['check-id'];
      $qty = $reservation['quantity'];
      $price = (double) $reservation['price'];
      $subtotal = $qty * $price;
      if( array_key_exists( $check_id, $item_checks )){
        $item_checks[$check_id] = $item_checks[$check_id] + $subtotal;
      } else {
        $item_checks[$check_id] = (double) $subtotal;
      }
      //construct reservation notes
      $reservation_notes.= $reservation['event-title'].':  || ';
      $reservation_notes.= $reservation['start'].' ||  ';
      $reservation_notes.= 'Event Res - '.$reservation['event-reservation-id'].' ||  || ';
    }
  }

  //if fees set notes and calculate total to add to discounts
  if( count($fees) > 0 ){
    $cart_fee_notes = 'CART FEES:  ' ;
    $fee_total = 0;
    foreach( $fees as $fee ){
      $fee_total = $fee_total + $fee->get_total() * (-1);
    }
    $cart_fee_notes = ' || Total cart fee: £'.$fee_total.' || ';
    //remove cart fee by applying to reservation checks
    $remaining_fee_to_remove = $fee_total;
    foreach( $reservations as $reservation ){
      //check check amount big enough
      $check_id = $reservation['check-id'];
      $check_amount = $item_checks[$check_id];
      if( array_key_exists($check_id, $discounts) ){
        $check_amount = $check_amount - $discounts[$check_id];
      }
      if( $check_amount < $remaining_fee_to_remove ){
        $discounts[$check_id] = $check_amount;
        $remaining_fee_to_remove = $remaining_fee_to_remove - $check_amount;
        $cart_fee_notes .= ' £'.$check_amount.' of cart fee discount applied to check no. '.$check_id;
      } else {
        $discounts[$check_id] = $discounts[$check_id] + $remaining_fee_to_remove;
        $cart_fee_notes .= ' £'.$check_amount.' of cart fee discount applied to check no. '.$check_id;
        break;
      }
    }
  }

  //LOOP THROUGH RESERVATIONS TO UPDATE STATUS AND NOTES
  $notes.= $reservation_notes;
  $notes.= $misc_item_notes;
  $notes.= $cart_fee_notes;
  if( is_array($reservations) ){
    foreach( $reservations as $reservation ){
      $event_res_update = updateEventReservation( $reservation['event-reservation-id'], $notes );
    }
  }

  //PAY CHECKS
  foreach( $item_checks as $check_id => $subtotal ){
    $result = payCheck( $check_id, $subtotal );
    error_log( 'check payed: '.$result );
  }

  //ADD DISCOUNTS TO CHECK
  foreach( $discounts as $check_id => $discount_value ){
    $result = updateCheck( $check_id, $discount_value );
    error_log('update check: '.$result );
  }

}

?>
