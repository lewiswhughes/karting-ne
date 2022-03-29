<?php
/*
Booking confirmation page template
*/
$reservationId = ( isset($_GET['resid']) ) ? $_GET['resid'] : null ;

include_once('includes/get-cart-item-info.php');

//construct book activity link parameters
$link_params_arr = array();
if( $query_date ){
  $link_params_arr['query_date'] = $query_date;
}
if( $qty_total ){
  $link_params_arr['qty_total'] = $qty_total;
}
if( $qty_cadets ){
  $link_params_arr['qty_cadets'] = $qty_cadets;
}
$link_params = http_build_query($link_params_arr);
?>

<script>
  fbq('track', 'Purchase', {
    value: 25.00,
    currency: 'GBP',
    contents: [
        {
            quantity: 1
        }
    ],
    content_ids: 'Book Now',
  });
</script>

<!--<section class="page-title-cont booking-confirmation-title">
  <h1 class="page_header">RESERVATION PLACED</h1>
</section>-->

<section class="reservation-details-cont">
  <div id="reservation-details"></div>
</section>

<section class="reservation-actions">
  <p>Your reservation has been made and will be held for 10 minutes.</p>
  <p>Your booking is <strong>not confirmed</strong> until payment has been made</p>
  <!--<a href="/booking-start/?<?php // echo $link_params; ?>" class="link_button">Book another activity</a>
  <p>or</p>-->
  <a href="/cart/" class="link_button next">Go to Cart/Checkout</a>
</section>

<script>
  var reservationId = <?= $reservationId; ?>;
</script>
