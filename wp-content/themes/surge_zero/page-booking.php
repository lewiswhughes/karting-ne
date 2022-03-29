<?php

namespace KNE\Booking;

use DateInterval;
use WP_Query;

require_once 'classes/calendar.php';

  //declare get start times by id function
  function getAllowedStartTimes($wc_product_id)
  {
      $monday = get_field('monday', $wc_product_id);
      $tuesday = get_field('tuesday', $wc_product_id);
      $wednesday = get_field('wednesday', $wc_product_id);
      $thursday = get_field('thursday', $wc_product_id);
      $friday = get_field('friday', $wc_product_id);
      $saturday = get_field('saturday', $wc_product_id);
      $sunday = get_field('sunday', $wc_product_id);

      return [
          'monday' => $monday,
          'tuesday' => $tuesday,
          'wednesday' => $wednesday,
          'thursday' => $thursday,
          'friday' => $friday,
          'saturday' => $saturday,
          'sunday' => $sunday,
      ];
  }

  //GET PARAMS
  $wc_product_id = (isset($_GET['prod'])) ? $_GET['prod'] : false;
  $event_type = ($wc_product_id) ? get_field('event_type_id', $wc_product_id) : null;

  $sibling_event_types = ($wc_product_id) ? explode(',', get_field('sibling_event_types', $wc_product_id)) : null;
  $product_id = ($wc_product_id) ? get_field('product_id', $wc_product_id) : null;
  $single_reservation = ($wc_product_id) ? get_field('single_reservation_only', $wc_product_id) : null;
  $set_times_only = ($wc_product_id) ? get_field('set_times_only', $wc_product_id) : null;

  $other_product_ids = ($wc_product_id) ? explode(',', get_field('other_product_ids', $wc_product_id)) : null;
  $event_duration = ($wc_product_id) ? get_field('duration', $wc_product_id) : 60;
  $qty_total = (isset($_GET['qty_total'])) ? $_GET['qty_total'] : 0;
  $qty_cadets = (isset($_GET['qty_cadets'])) ? $_GET['qty_cadets'] : 0;
  if ('' == $qty_cadets) {
      $qty_cadets = 0;
  }
  $qty_induction = (isset($_GET['qty_induction'])) ? $_GET['qty_induction'] : 0;
  if ('' == $qty_induction) {
      $qty_induction = 0;
  }
  $qty_extra = (isset($_GET['qty_extra'])) ? $_GET['qty_extra'] : 0;
  $qty_party_guests = (isset($_GET['qty_party_guests'])) ? $_GET['qty_party_guests'] : 0;
  $date = (isset($_GET['query_date'])) ? $_GET['query_date'] : false;
  $view_type = (isset($_GET['view'])) ? $_GET['view'] : 'calendar';

  $event_reservation_id_from_url = (isset($_GET['res_id'])) ? $_GET['res_id'] : 0;

  //price
  $product = wc_get_product($wc_product_id);
  $price = $product->get_price();
  $regular_price = $product->get_regular_price();
  $on_sale = ($product->is_on_sale()) ? true : false;

  //get track
  $product_track = get_field('track', $wc_product_id);
  $track = get_field('track_id', $product_track->ID);

  //new reservation allowed?
  $min_num_for_new_reservation = ($wc_product_id) ? get_field('min_for_new_reservation', $wc_product_id) : 1;
  if (!$min_num_for_new_reservation > 0) {
      $min_num_for_new_reservation = 1;
  }
  $new_reservations = ((int) $qty_total >= (int) $min_num_for_new_reservation) ? 1 : 0;
  //if party set new reservarions always allowed
  if ($qty_party_guests > 0) {
      $new_reservations = 1;
  }

  //check cadets only and modify qtys accordingly
  $cadets_only = get_field('cadets_only', $wc_product_id);
  if ($cadets_only > 0) {
      $qty_cadets = $qty_total;
  }

  //categories
  $product_categories = wp_get_post_terms($wc_product_id, 'product_cat', ['fields' => 'slugs']);

  //family event check
  $family = (in_array('family-event', $product_categories)) ? true : false;

  //party check
  $party = (in_array('party', $product_categories)) ? true : false;

  //get party info
  $extra_guest_product_post = ($party) ? get_field('extra_guest_product', $wc_product_id) : null;
  $extra_guest_product = wc_get_product($extra_guest_product_post->ID);
  $extra_guest_product_price = ($extra_guest_product) ? (int) $extra_guest_product->get_price() : null;
  $extra_guest_product_id = ($party) ? get_field('product_id', $extra_guest_product_post->ID) : null;

  $partyInfo = [
      'guests' => (int) $qty_party_guests,
      'extra_guest_wc_product_id' => $extra_guest_product_post->ID,
      'extra_guest_product_id' => (int) $extra_guest_product_id,
      'extra_guest_price' => $extra_guest_product_price,
      'extra_guests' => (int) $qty_extra,
  ];

  //check date
  $now = new DateTime('now');
  $today = $now->setTime(0, 0);
  $query_date = new DateTime($date);
  if ($query_date < $today) {
      $date = $today->format('Y-m-d');
  }

  // If selected date is further than 3 months in advance, set it to 3 months thus disbling booking so far in future.
  if ($query_date > $now->add(new DateInterval('P3M'))) {
      //back to calendar button
      $params = $_GET;
      // replace parameter(s)
      $params['query_date'] = $now->format('Y-m-d');
      // rebuild url
      $current_uri = explode('?', $_SERVER['REQUEST_URI'])[0];
      $calendar_link = $current_uri.'?'.http_build_query($params);

      wp_redirect($calendar_link);
  }

  //get product time variations & day info
  $time_variations = get_field('time_variations', $wc_product_id);
  if (is_array($time_variations)) {
      //get and set clubspeed product ids and other product ids
      foreach ($time_variations as $index => $time_variation) {
          $cs_product_id = get_field('product_id', $time_variation['linked_product']->ID);
          $cs_other_product_ids = explode(',', get_field('other_product_ids', $time_variation['linked_product']->ID));
          $product_time_variations = getAllowedStartTimes($time_variation['linked_product']->ID);
          $product = wc_get_product($time_variation['linked_product']->ID);

          $time_variations[$index]['wc_product_id'] = $time_variation['linked_product']->ID;
          $time_variations[$index]['product_id'] = (int) $cs_product_id;
          $time_variations[$index]['price'] = $product->get_price();
          $time_variations[$index]['regular_price'] = $product->get_regular_price();
          $time_variations[$index]['on_sale'] = ($product->is_on_sale() > 0) ? 1 : 0;
          $time_variations[$index]['other_product_ids'] = $cs_other_product_ids;
          $time_variations[$index]['product_start_times'] = $product_time_variations;
          $time_variations[$index]['included_periods'] = $time_variation['included_periods'];
      }
  }

  $event_day_info = getAllowedStartTimes($wc_product_id);
  //get start times for inductions

  //obtain the event type and product ids for all wc products that have karting category
  $args = [
      'post_type' => 'product',
      'posts_per_page' => -1,
      'tax_query' => [
          [
              'taxonomy' => 'product_cat',
              'terms' => 'karting', // limit this to karting products only
              'field' => 'slug',
          ],
      ],
  ];

  // populate our array from the wc products with just the info that we need
  $karting_products = [];

  // check current product to see if it's a family event
  $family_event = false;
  foreach ($product_categories as $category) {
      if ('family-event' == $category) {
          $family_event = true;

          break;
      }
  }

  // if current product is a family event...
  if ($family_event) {
      foreach (get_posts($args) as $product) {
          // ...only book on events where min age is less than 14
          if (get_field('minimum_age', $product->ID) < 14) {
              $wc_product = wc_get_product($product->ID);
              $karting_products[] = [
                  'productId' => (int) $product->ID,
                  'eventTitle' => $product->post_title,
                  'eventTypeId' => (int) get_field('event_type_id', $product->ID),
                  'duration' => (int) get_field('duration', $product->ID),
                  'price' => $wc_product->get_price(),
                  'regularPrice' => $wc_product->get_regular_price(),
                  'onSale' => $wc_product->is_on_sale(),
              ];
          }
      }
  } else {
      // don't check age - just populate our array
      // however exclude family events
      foreach (get_posts($args) as $product) {
          $wc_product = wc_get_product($product->ID);
          $wc_product_cats = $wc_product->get_category_ids();

          if (!in_array('18', $wc_product_cats)) {
              $karting_products[] = [
                  'productId' => (int) $product->ID,
                  'eventTitle' => $product->post_title,
                  'eventTypeId' => (int) get_field('event_type_id', $product->ID),
                  'duration' => (int) get_field('duration', $product->ID),
                  'price' => $wc_product->get_price(),
                  'regularPrice' => $wc_product->get_regular_price(),
                  'onSale' => $wc_product->is_on_sale(),
              ];
          }
      }
  }

  //get induction product id
  $induction_query_args = [
      'post_type' => 'product',
      'name' => 'induction session',
  ];

  $induction_query = new WP_Query($induction_query_args);
  $induction_wc_product = $induction_query->posts[0];
  $induction_wc_product_id = $induction_wc_product->ID;
  $induction_product = wc_get_product($induction_wc_product_id);

  //get track id
  $postId = get_field('track', $induction_wc_product_id);
  $inductionTrackId = (int) get_field('track_id', $postId);

  $induction_info = [
      'induction_wc_product' => $induction_wc_product_id,
      'event_type_id' => (int) get_field('event_type_id', $induction_wc_product_id),
      'product_id' => (int) get_field('product_id', $induction_wc_product_id),
      'duration' => (int) get_field('duration', $induction_wc_product_id),
      'wcPrice' => $induction_product->get_price(),
      'track' => $inductionTrackId,
      'event_day_info' => [
          'monday' => get_field('monday', $induction_wc_product_id),
          'tuesday' => get_field('tuesday', $induction_wc_product_id),
          'wednesday' => get_field('wednesday', $induction_wc_product_id),
          'thursday' => get_field('thursday', $induction_wc_product_id),
          'friday' => get_field('friday', $induction_wc_product_id),
          'saturday' => get_field('saturday', $induction_wc_product_id),
          'sunday' => get_field('sunday', $induction_wc_product_id),
      ],
  ];

  //get cart items, my current events and tracks
  $cart = WC()->cart->get_cart();
  $cart_tracks = [];
  $my_events = [];
  foreach ($cart as $cart_item_key => $cart_item) {
      $product = wc_get_product($cart_item['product_id']);
      //get track id
      $postId = get_field('track', $cart_item['product_id']);
      if ($postId > 0) {
          $cart_item_track_id = (int) get_field('track_id', $postId);
          if ((int) $cart_item_track_id !== (int) $track) {
              if (!in_array((int) $cart_item_track_id, $cart_tracks)) {
                  array_push($cart_tracks, (int) $cart_item_track_id);
              }
          }
      }
      //get event reservation id
      if ((int) $cart_item['event-reservation-id'] > 0) {
          $my_events[(int) $cart_item['event-reservation-id']] = [
              'title' => $product->get_title(),
          ];
      }
  }

  //other tracks
  $other_tracks = $cart_tracks;
  if ($qty_induction > 0) {
      if (!in_array((int) $inductionTrackId, $other_tracks)) {
          array_push($other_tracks, (int) $inductionTrackId);
      }
  }

  //get track info
  $tracks = [
      'main' => (int) $track,
      'other_tracks' => $other_tracks,
      'track_info' => null,
  ];
  $trackQuery = new WP_Query(['post_type' => 'track']);
  $trackDetails = $trackQuery->posts;
  //get track info into array
  foreach ($trackDetails as $trackInfo) {
      $postId = $trackInfo->ID;
      $trackId = get_field('track_id', $postId);
      //add full details for chosen tracks
      $tracks['track_info'][$trackId] = [
          'track_id' => $trackId,
          'track_name' => get_the_title($postId),
          'track_closures' => get_field('track_closures', $postId),
          'opening_hours' => [
              'monday' => get_field('monday', $postId),
              'tuesday' => get_field('tuesday', $postId),
              'wednesday' => get_field('wednesday', $postId),
              'thursday' => get_field('thursday', $postId),
              'friday' => get_field('friday', $postId),
              'saturday' => get_field('saturday', $postId),
              'sunday' => get_field('sunday', $postId),
          ],
      ];
  }
  //get appropriate track info
  $day = strtolower($query_date->format('l'));
  $closed = $tracks['track_info'][$track]['opening_hours'][$day]['closed'];
  $opening_time = ($tracks['track_info'][$track]['opening_hours'][$day]['open']) ? str_replace(':', '', $tracks['track_info'][$track]['opening_hours'][$day]['open']) : '0800';
  $closing_time = ($tracks['track_info'][$track]['opening_hours'][$day]['close']) ? str_replace(':', '', $tracks['track_info'][$track]['opening_hours'][$day]['close']) : '2200';

  //get duration if variable
  $variable_duration = get_field('variable_duration', $wc_product_id);
  if ($variable_duration > 0) {
      $duration_variations = get_field('duration_variations', $wc_product_id);
      //loop through duration variations
      foreach ($duration_variations as $duration_variation) {
          //by group size
          if ('groupsize' == $duration_variation['compare_to']) {
              foreach ($duration_variation['duration_variation_details'] as $variation) {
                  //greater than comparison
                  if ('greaterthan' == $variation['comparison_operator']) {
                      $event_duration = ($qty_total > (int) $variation['comparison_value']) ? $variation['duration_value'] : $event_duration;
                  }
              }
          }
      }
  }

  //settings var for both
  $scheduleSettings = [
      'start' => $opening_time,
      'end' => $closing_time,
      'period' => 30,
  ];

  //get user
  $user = wp_get_current_user();
  $current_user = [
      'name' => $user->user_firstname.' '.$user->user_lastname,
      'email' => $user->user_email,
  ];

  if ($wc_product_id && $qty_total || $event_reservation_id_from_url > 0) {
      //calendar view
      if ('calendar' == $view_type) {
          echo '<section class="main_booking title">';
          echo '<h1 class="page_header">Choose a date for your booking</h1>';
          echo '</section>';

          echo '<section class="main_booking title">';
          echo '<h2 class="page_header">Call to reserve your place on 0191 5214050 or book online now.</h2>';
          echo '</section>';

          echo '<section class="main_booking_calendar month_view">';
          //display calendar
          $calendar = new Calendar();
          $calendar->drawMonthCalendar($date, 'main_booking');
          //get first and last day to set in js
          $start_date = $calendar->start_date->format('Y-m-d');
          $end_date = $calendar->end_date->format('Y-m-d');
          echo '</section>';
      }
      //day view
      if ('day' == $view_type) {
          echo '<section class="main_booking title">';
          echo '<h1 class="page_header">Choose a time for your booking</h1>';
          echo '</section>';

          echo '<section class="main_booking title">';
          echo '<h2 class="page_header">Call to reserve your place on 0191 5214050 or book online now.</h2>';
          echo '</section>';

          echo '<section class="day_view">';
          //show `day view `
          $schedule = new Calendar();
          $schedule->drawDayCalendar($date, $scheduleSettings['start'], $scheduleSettings['end'], $scheduleSettings['period'], $tracks, true);

          echo '</section>';

          //back to calendar button
          $params = $_GET;
          // replace parameter(s)
          $params['view'] = 'calendar';
          // rebuild url
          $current_uri = explode('?', $_SERVER['REQUEST_URI'])[0];
          $calendar_link = $current_uri.'?'.http_build_query($params);

          echo '<div class="actions">';
          // echo '<button type="button" aria-label="Schedule settings.">';
          // get_template_part('templates/icons/settings');
          // echo '</button>';
          echo '<a href="'.$calendar_link.'" aria-label="Back to calendar">';
          get_template_part('templates/icons/calendar');
          echo '</a>';
          echo '</div>';

          //get first and last day to set in js
          $start_date = $schedule->start_date->format('Y-m-d');
          $end_date = $schedule->end_date->format('Y-m-d');
      }

      //include enquiry form
      get_template_part('/templates/forms/booking-enquiry');

      //include booking bar
      get_template_part('/templates/bookings/info-bar');

      function getTotalPrice($inductions, $induction_info, $price)
      {
          if ($inductions > 0) {
              return $price + ($inductions * $induction_info['wcPrice']);
          }

          return $price;
      } ?>

    <script>
      var wcProductId = <?php echo $wc_product_id; ?>;
      var wcEventTitle = '<?php echo html_entity_decode(get_the_title($wc_product_id)); ?>';
      var viewType = '<?php echo $view_type; ?>';
      var qtyTotal = <?php echo $qty_total; ?>;
      var qtyCadets = <?php echo $qty_cadets; ?>;
      var qtyInduction = <?php echo $qty_induction; ?>;
      var inductionInfo = <?php echo json_encode($induction_info); ?>;
      var eventTypeId = <?php echo $event_type; ?>;
      var siblingEventTypeIds = <?php echo json_encode($sibling_event_types); ?>;
      var productId = <?php echo $product_id; ?>;
      var otherProductIds = <?php echo json_encode($other_product_ids); ?>;
      var eventDuration = <?php echo $event_duration; ?>;
      var startDate = '<?php echo $start_date; ?>';
      var endDate = '<?php echo $end_date; ?>';
      var tracks = <?php echo json_encode($tracks); ?>;
      var productTimeVariations = <?php echo json_encode($time_variations); ?>;
      var eventDayInfo = <?php echo json_encode($event_day_info); ?>;
      var currentUser = <?php echo json_encode($current_user); ?>;;
      var customerId = null;
      var scheduleSettings = <?php echo json_encode($scheduleSettings); ?>;
      var partyInfo = <?php echo json_encode($partyInfo); ?>;
      var singleReservation = <?php echo ($single_reservation > 0) ? 'true' : 'false'; ?>;
      var setTimesOnly = <?php echo ($set_times_only > 0) ? 'true' : 'false'; ?>;
      var newReservations = <?php echo ($new_reservations > 0) ? 'true' : 'false'; ?>;
      var myEvents = <?php echo json_encode($my_events); ?>;
      var totalPrice = <?php echo getTotalPrice($inductions, $induction_info, $price); ?>;
      var wcPrice = <?php echo $price; ?>;
      var wcRegularPrice = <?php echo $regular_price; ?>;
      var onSale = <?php echo ($on_sale) ? 1 : 0; ?>;
      var eventReservationIdFromURL = <?php echo ($event_reservation_id_from_url) ? $event_reservation_id_from_url : 0; ?>;
      var isFamilyEvent = <?php echo ($family) ? 1 : 0; ?>;
    </script>

<?php
  } else {
      echo '<section class="error"><h1>No product and/or number of participants selected</h1><p>You have not selected a Product and number of participants to book.</p><p><a href="/">&lt;&lt; Back to Home Page</a></p></section>';
  }

?>
