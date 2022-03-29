<?php

global $woocommerce;

//GET PARAMS
$wc_product_id = (isset($_GET['prod'])) ? $_GET['prod'] : null ;
$event_type = ( $wc_product_id ) ? get_field('event_type_id', $wc_product_id) : null ; //retrieved now so js can cache event info

//get existing parameters for redirect to calendar/schedule if come from there
$qty_total = (isset($_GET['qty_total'])) ? $_GET['qty_total'] : null ;
$qty_cadets = (isset($_GET['qty_cadets'])) ? $_GET['qty_cadets'] : null ;
$twelve_or_below = (isset($_GET['twelve_or_below'])) ? $_GET['twelve_or_below'] : null ;
$qty_induction = (isset($_GET['qty_induction'])) ? $_GET['qty_induction'] : null ;
$view = (isset($_GET['view'])) ? $_GET['view'] : null ;
$query_date = (isset($_GET['query_date'])) ? $_GET['query_date'] : null ;

//get track
$track = get_field('track', $wc_product_id);
$track_id = get_field('track_id', $track->ID);

$product_categories = wp_get_post_terms( $wc_product_id, 'product_cat', array('fields'=>'slugs') );
//check family event category (for cadet qty)
$family = ( in_array('family-event', $product_categories) ) ? true : false ;
$family_required = ( $family ) ? 'required' : '' ;
//check karting category (for inductions)
$karting = ( in_array('karting', $product_categories) ) ? true : false ;
//set induction eventTypeID
$induction_event_type_id = 19;
//check cadets only
$cadets_only = get_field('cadets_only', $wc_product_id);

//get min max numbers
$min_number = ($wc_product_id) ? get_field('min_number', $wc_product_id) : 1 ;
$max_number = ($wc_product_id) ? get_field('max_number', $wc_product_id) : 35 ;
//enforce defaults if field returns blank
if($min_number < 1){
  $min_number = 1;
}
if($max_number < 1){
  $max_number = 35;
}
$min_num_for_new_reservation = ( $wc_product_id ) ? get_field('min_for_new_reservation', $wc_product_id) : 1 ;
if( ! $min_num_for_new_reservation > 0 ){
  $min_num_for_new_reservation = 1;
}

//check if party
$party = ( in_array('party', $product_categories) ) ? true : false ;
//extra guest product
$max_extra_guests = ( $party ) ? get_field('maximum_extra_guests', $wc_product_id) : 0 ;

if ( !$wc_product_id ) {
  //product selector form
  //get categories
  $event_term = get_term_by('slug', 'event', 'product_cat');
  $args = array(
   'taxonomy'     => 'product_cat',
   'orderby'      => 'name',
   'hierarchical' => 1,
   'hide_empty'   => 1,
   'parent'       => $event_term->term_id
  );
  $categories = get_categories( $args );

  $product_args = array(
    'orderby' => 'ID',
    'order' => 'ASC',
    'limit' => -1,
    'status' => 'publish'
  );
  $products = wc_get_products( $product_args );


?>
  <section>
    <h1 class="page_header">Start your booking</h1>

    <?php

    //testing

    $order_id = 2134;
    $order_obj = new WC_Order($order_id);
    $order_data = $order_obj->get_data();
    $reservation = get_post_meta( $order_id, 'reservations', true )[0];
    $start_datetime = new DateTime($reservation['start']);

    // echo "<pre style='text-align:left; padding-left: 14rem; padding-right: 12rem;'>".print_r($order_data, true)."</pre>";
    // echo "<pre style='text-align:left; padding-left: 14rem; padding-right: 12rem;'>".print_r($reservations, true)."</pre>";
    
    $qty_total = $reservations['quantity'];
    $qty_cadets = $reservations['qty-cadets'];
    // $twelve_or_below = ""; - NOT NEEDED HERE
    $qty_induction = $reservations['qty-induction']; // TO TEST
    $prod = $reservations['wc-product-id'];
    $view = "day";
    $query_date = $start_datetime->format('Y-m-d');
    $res_id = $reservations['event-reservation-id'];

    ?>

    <form id="booking-choose-event" method="get" action="">
      <h3>Please choose your activity:</h3>
      <div class="categories">
        <?php
          foreach( $categories as $category ){
            echo '<input type="radio" class="category-radio" name="event_category" id="'.$category->slug.'-cat-input" value="'.$category->slug.'" required />';
            echo '<label for="'.$category->slug.'-cat-input">';
            echo '<div class="icon">';
            get_template_part('/templates/icons/'.$category->slug.'-small');
            echo '</div>';
            echo '<p>';
            echo $category->name;
            // if( strtolower($category->name) == 'karting' ){
            //   echo '<span class="flag">20% Off!</span>';
            // }
            echo '</p>';
            echo '</label>';
          }
        ?>
      </div>

      <h3 id="choose-event-header">Please choose your event:</h3>
      <div class="events">
        <?php
          foreach( $products as $product ){
            //get categories and generate class
            $terms = wp_get_post_terms( $product->get_id(), 'product_cat', array('fields'=>'slugs') );
            $terms_class = implode(' ', $terms);
            //hide
            $hide = get_field( 'not-bookable', $product->get_id() );
            //ages
            $min_age =  get_field( 'minimum_age', $product->get_id() );
            $max_age =  get_field( 'maximum_age', $product->get_id() );
            $age_text = null;
            if( $min_age ){
              if( $max_age ){
                $age_text = $min_age.' - '.$max_age.'Yrs.';
              } else {
                $age_text = $min_age.'+ Yrs.';
              }
            }
            if( !$hide ){
              echo '<input class="event event-radio" type="radio" name="prod" id="'.$product->slug.'-input" value="'.$product->get_id().'" data-product-name="'.$product->name.'" />';
              echo '<label class="'.$terms_class.'" for="'.$product->slug.'-input">';
              echo '<p>'.$product->name.'</p>';
              echo '<p>'.$product->get_short_description().'</p>';
              if( $age_text ){
                echo '<p class="ages">'.$age_text.'</p>';
              }
              echo '</label>';
            }
          }
        ?>
      </div>

      <?php
        //hidden input values if exist
        if( $view ){
          echo '<input type="hidden" name="view" value="'.$view.'" />';
        }
        if( $query_date ){
          echo '<input type="hidden" name="query_date" value="'.$query_date.'" />';
        }
        if( $qty_total ){
          echo '<input type="hidden" name="qty_total" value="'.$qty_total.'" />';
        }
        if( $qty_cadets ){
          echo '<input type="hidden" name="qty_cadets" value="'.$qty_cadets.'" />';
        }
        if( $twelve_or_below ){
          echo '<input type="hidden" name="twelve_or_below" value="'.$twelve_or_below.'" />';
        }
        if( $qty_induction ){
          echo '<input type="hidden" name="qty_induction" value="'.$qty_induction.'" />';
        }
      ?>

      <input type="submit" class="next" value="next" />

    </form>
  </section>
<?php
} else {
?>
  <section>
    <h1 class="page_header">Participants</h1>
    <form id="booking-start" method="get" action="/booking" class="<?= ($family) ? 'family-form' : '' ;?>">

      <div class="quantities">

        <?php
        if( $party ){
        ?>
          <!-- total must be 1-->
          <input type="hidden" id="qty_total" name="qty_total" value="1" />

          <label for="qty_party_guests">How many party guests are there? (Maximum <?= $max_number; ?>)</label>
          <input type="number" id="qty_party_guests" name="qty_party_guests" min="<?= $min_number; ?>" max="<?= $max_number; ?>" value="<?= $min_number; ?>" required />

          <label class="party_extra_guests" for="qty_extra">Would you like to add any extra guests? (Maximum <?= $max_extra_guests; ?>)</label>
          <input class="party_extra_guests" type="number" id="qty_extra" name="qty_extra" min="0" max="<?= $max_extra_guests; ?>" value="0" required disabled />
        <?php
        } else {
        ?>
          <label for="qty_total">How many people will be taking part <span class="strong">in total</span>? (Maximum <?= $max_number; ?>)</label>
          <input type="number" id="qty_total" name="qty_total" min="<?= $min_number; ?>" max="<?= $max_number; ?>" value="<?= ( $qty_total ) ? $qty_total : $min_num_for_new_reservation ?>" data-min-new="<?= $min_num_for_new_reservation; ?>" required />
          <p class="start-hidden qty-total-notice">Please note: You can still join existing events, but the minimum number of participants required to create a new event is <?= $min_num_for_new_reservation; ?></p>
        <?php
        }
        ?>

        <?php
        if ($family) {
        ?>
          <!--only show if family event-->
          <label class="family qty_cadets" for="qty_cadets">How many drivers are aged 8-13?</label>
          <input class="family qty_cadets" type="number" id="qty_cadets" name="qty_cadets" min="1" max="<?= $max_number; ?>" value="<?= ( $qty_cadets ) ? $qty_cadets : 0 ; ?>" <?= $family_required; ?> />
          <p class="qty-validation qty-cadet-validation">This number should not be greater than your total. Please amend to continue.</p>

          <!--only show if cadets-->
          <p class="family twelve_or_below">Are any of these drivers aged 11 or below?</p>
          <input class="family" type="radio" id="twelve_below_yes" name="twelve_or_below" value="yes" required <?= ( $twelve_or_below=='yes' ) ? 'checked' : '' ; ?> />
          <label class="family twelve_or_below" for="twelve_below_yes">Yes</label>
          <input class="family" type="radio" id="twelve_below_no" name="twelve_or_below" value="no" />
          <label class="family twelve_or_below" for="twelve_below_no">No</label>

          <!--only show if below twelve-->
          <p class="family qty_induction">Drivers aged 8-11 who have not driven at the track before will require an induction session prior to your Karting event. Inductions cost <span class="induction_cost"></span> per person.</p>
          <label class="family qty_induction" for="qty_induction">Please enter the number of drivers who will require an induction</label>
          <input class="family qty_induction" type="number" id="qty_induction" name="qty_induction" min="0" max="<?= $max_number; ?>" value="<?= ( $qty_induction ) ? $qty_induction : 0 ; ?>" />
          <p class="qty-validation qty-induction-validation">This number should not be greater than your number of drivers aged 8-13. Please amend to continue.</p>
        <?php
        }
        ?>
      </div>

      <input type="hidden" name="prod" value="<?= $wc_product_id; ?>">

      <input type="hidden" name="view" value="<?= ( $view ) ? $view : 'calendar' ; ?>">
      <input type="hidden" name="query_date" value="<?= ( $query_date ) ? $query_date : '' ; ?>">

      <input id="booking-start-form-submit" type="submit" class="next" value="Next">
    </form>
  </section>

  <?php
  //include booking bar
  get_template_part('/templates/bookings/info-bar');
  ?>

  <!--JS VARS-->
  <script>
    var wcProductId = <?= $wc_product_id; ?>;
    var eventTypeId = <?= $event_type; ?>;
    var inductionEventTypeId = <?= $induction_event_type_id; ?>;
    var viewType = 'booking-start';
  </script>

<?php
}
?>
