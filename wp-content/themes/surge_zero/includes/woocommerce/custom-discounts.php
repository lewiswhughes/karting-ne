<?php
// Handle the group discounts
add_action('woocommerce_cart_calculate_fees', 'multi_activity_discount', 10, 1);
function multi_activity_discount($cart) {

  if (is_admin() && !defined('DOING_AJAX')) {
		return;
	}

  $discount = 0;
  //get child categories of event category
  $event_child_categories = array();

  $event_category = get_term_by('name', 'event', 'product_cat');
  $product_categories = get_terms( 'product_cat', $cat_args );
  $categories_array = array();

  //setup event categories array
  foreach( $product_categories as $category ){
    if( $category->parent == (int) $event_category->term_id ){
      $categories_array[ $category->slug ] = false;
    }
  }

	// Loop through cart items
	foreach ($cart->get_cart() as $cart_item) {
    //date
    $start = new DateTimeImmutable( $cart_item['start'] );
    $date = $start->format('Ymd');
    if( ! array_key_exists($date, $event_child_categories) ){
      //construct array for date - add categories array
      $event_child_categories[$date]['categories'] = $categories_array;
      //...add event items so can calculate discounts
      $event_child_categories[$date]['items'] = array();
    }
    //loop through cart item terms and set true if found
		$terms = get_the_terms($cart_item['product_id'], 'product_cat');
    if( is_array( $terms ) ){
      foreach( $terms as $term ){
        if( array_key_exists( $term->slug, $event_child_categories[$date]['categories'] ) ){
          $event_child_categories[$date]['categories'][$term->slug] = true;
        }
      }
    }
    //add cart item to date if event
    $term_slugs = wp_get_post_terms($cart_item['product_id'], 'product_cat', array('fields'=>'slugs'));
    if( in_array( 'event', $term_slugs ) ){
      array_push( $event_child_categories[$date]['items'], $cart_item );
    }
	}

  //COUNT TRUE IN EVENT CATEGORIES
  $apply_discount = false;
  foreach( $event_child_categories as $date ){
    $date_total = 0;
    if( ! $apply_discount && array_sum( $date['categories'] ) >= 3 ){
      $apply_discount = true;
    }
    //calculate discount to apply
    if( array_sum( $date['categories'] ) >= 3 ){
      $date_total = 0;
      foreach( $date['items'] as $cart_item ){
        $date_total = $date_total + (float) $cart_item['data']->get_price() * $cart_item['quantity'];
      }
    }
    $discount = $discount + $date_total * 0.1;
  }

  if( $apply_discount ){
    $cart->add_fee( __('Multi-Activity Discount (10% off activities booked)', 'woocommerce'), $discount * (-1), false, '');
  }
}

//Half off karting with induction
add_action('woocommerce_cart_calculate_fees', 'half_off_karting_with_induction', 10, 1);
function half_off_karting_with_induction($cart){

  if (is_admin() && !defined('DOING_AJAX')) {
		return;
	}

  $reservations = array();
  $discount = 0;

  //loop through cart  items once to set up reservations array
  foreach ($cart->get_cart() as $cart_item) {
    if( ! array_key_exists( $cart_item['reservation-id'],$reservations ) ){
      $reservations[$cart_item['reservation-id']] = array(
        'items' => array(),
        'induction' => false,
        'karting' => false,
      );
    }
    // array_push( $reservations[$cart_item['reservation-id']]['items'], $cart_item );

    $terms = wp_get_post_terms($cart_item['product_id'], 'product_cat', array('fields'=>'slugs'));
    if( in_array('karting', $terms ) ){
      $reservations[$cart_item['reservation-id']]['karting'] = true;
    }
    if( in_array('induction', $terms ) ){
      $reservations[$cart_item['reservation-id']]['induction'] = true;
      $reservations[$cart_item['reservation-id']]['induction_qty'] = $cart_item['quantity'];
    }
  }

  //loop through again and calculate cart fee
  foreach ($cart->get_cart() as $cart_item) {
    if( $reservations[$cart_item['reservation-id']]['karting'] && $reservations[$cart_item['reservation-id']]['induction'] ){
      //if karting get price, half and add to discount
      $terms = wp_get_post_terms($cart_item['product_id'], 'product_cat', array('fields'=>'slugs'));
      if( in_array('karting', $terms ) && ! in_array('induction', $terms ) ){
        //do not include discounts in discount - discounted price should be 50% of regular price
        $induction_qty = $reservations[$cart_item['reservation-id']]['induction_qty'];
        $karting_regular_price = $cart_item['data']->get_regular_price();
        $karting_price = $cart_item['data']->get_price();
        $target_price = $karting_regular_price / 2;
        $discount = $discount + ($karting_price - $target_price) * $induction_qty;
      }
    }
  }

  //apply discount if greater than 0
  if( $discount > 0 ){
    $cart->add_fee( __('50% off track time when booking induction (based on regular price)', 'woocommerce'), $discount * (-1), false, '');
  }

}

?>
