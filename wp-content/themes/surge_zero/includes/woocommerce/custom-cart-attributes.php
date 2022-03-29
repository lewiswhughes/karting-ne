<?php

//CUSTOM CART ITEM PARAMETERS
function add_custom_cart_attributes( $cart_item_data, $product_id, $variation_id ) {

  $now = new DateTime();

  $reservationId = (isset($_GET['resid'])) ? $_GET['resid'] : null ;
  $checkId = (isset($_GET['checkid'])) ? $_GET['checkid'] : null ;
  $itemCheckId = (isset($_REQUEST['itemcheckid'])) ? $_REQUEST['itemcheckid'] : null ;
  $checkDetailsId = (isset($_GET['checkdetailsid'])) ? $_GET['checkdetailsid'] : null ;
  $start = (isset($_GET['start'])) ? $_GET['start'] : null ;
  $itemStart = (isset($_REQUEST['itemstart'])) ? $_REQUEST['itemstart'] : null ;
  $qtyCadets = (isset($_GET['qtyCadets'])) ? $_GET['qtyCadets'] : null ;
  $qtyInduction = (isset($_GET['qtyInduction'])) ? $_GET['qtyInduction'] : null ;
  $eventResId = (isset($_GET['eventResId'])) ? $_GET['eventResId'] : null ;
  $itemEventResId = (isset($_REQUEST['itemeventres'])) ? $_REQUEST['itemeventres'] : null ;
  $customerId = (isset($_GET['customer'])) ? $_GET['customer'] : null ;
  $partyGuests = (isset($_GET['partyguests'])) ? $_GET['partyguests'] : null ;

  $cart_item_data['unique_key'] = $reservationId.$eventResId;
  $cart_item_data['reservation-id'] = $reservationId;
  $cart_item_data['added-to-cart'] = (isset($_GET['addedtocart'])) ? $_GET['addedtocart'] : null ;
  //event reservation
  $cart_item_data['event-reservation-id'] = ($itemEventResId > 0) ? $itemEventResId : $eventResId ;
  //check id
  $cart_item_data['check-id'] = ($itemCheckId > 0) ? $itemCheckId : $checkId ;
  //start time
  $cart_item_data['start'] = ($itemStart > 0) ? $itemStart : $start ;
  $cart_item_data['check-details-id'] = $checkDetailsId;
  $cart_item_data['qty-cadets'] = $qtyCadets;
  $cart_item_data['qty-inductions'] = $qtyInduction;

  $cart_item_data['customer-id'] = $customerId;
  $cart_item_data['party-guests'] = $partyGuests;
  return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'add_custom_cart_attributes', 10, 3 );

?>
