<?php

function add_to_basket_reminders_table() {

  global $woocommerce;

  // get email from cookie set
  $user_email = null;
  if (isset($_COOKIE['emailAddr'])) {
    $user_email = $_COOKIE['emailAddr'];
  }

  $now = new DateTime();

  // create post for cart instance
  $post_id = wp_insert_post(array(
    'post_title' => $user_email." - ".$now->format('d-m-Y H:i:s'),
    'post_status' => 'publish',
    'post_type' => 'basket_logs',
    'post_author' => 1
  ));

  // fields to update
  update_field('email_address', $user_email, $post_id);
  update_field('timestamp', time(), $post_id);

  // get cart items
  $cart_items = $woocommerce->cart->get_cart();
  
  foreach ($cart_items as $item) {

    $start = new DateTime($item['start']);
    
    $row = array(
      'unique_key' => $item['unique_key'],
      'reservation_id' => $item['reservation-id'],
      'event_reservation_id' => $item['event-reservation-id'],
      'check_id' => $item['check-id'],
      'product_id' => $item['product_id'],
      'start' => $start->format('Y-m-d H:i:s'),
      'total_racers' => $item['quantity'],
      'qty_cadets' => $item['qty-cadets'],
      'qty_inductions' => $item['qty-inductions']
    );
    
    add_row('cart_items', $row, $post_id);
  }
}
add_action( 'woocommerce_add_to_cart', 'add_to_basket_reminders_table', 10, 3 );

function see_if_user_checked_out($order_id) {

  if (!$order_id) {
    return;
  }

  // Get an instance of the WC_Order object
  $order = wc_get_order( $order_id );
  
  // Get the reservations
  $reservations = get_post_meta( $order->ID, 'reservations', true );

  // Loop through todays order logs to find the matching res id
  $args = array(
    'post_type' => 'basket_logs',
    'posts_per_page' => -1,
    'date_query' => array(
      array(
        'after' => '2 hours ago'
      )
    )
  );

  $basket_logs = get_posts($args);

  foreach ($basket_logs as $log) {
    $log_id = $log->ID;
    $log_cart_items = get_field('cart_items', $log_id);
    foreach ($log_cart_items as $item) {
      $item_res_id = $item['reservation_id'];

      // match cart log to completed order here
      foreach ($reservations as $reservation) {
        $reservation_id = $reservation['reservation-id'];
        
        if ($reservation_id == $item_res_id) {
          update_field('checked_out', true, $log_id);
        }
      }

    }
  }
}
add_action('woocommerce_thankyou', 'see_if_user_checked_out', 10, 1);

?>