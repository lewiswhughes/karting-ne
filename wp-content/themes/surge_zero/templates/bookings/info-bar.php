<section class="booking-info-bar">
  <div>
    <?php
      //get event name
      $product_id = ( isset($_GET['prod']) ) ? $_GET['prod'] : null ;
      $product = wc_get_product( $product_id );
      $event_name = $product->get_title();
      //numbers of participants
      $qty_total = (isset($_GET['qty_total'])) ? $_GET['qty_total'] : false ;
      $qty_cadets = (isset($_GET['qty_cadets'])) ? $_GET['qty_cadets'] : 0 ;
      if ( $qty_cadets == '' ){
        $qty_cadets = 0;
      }
      $qty_induction = (isset($_GET['qty_induction'])) ? $_GET['qty_induction'] : 0 ;
      if ( $qty_induction == '' ){
        $qty_induction = 0;
      }

      global $party;
      global $qty_party_guests;
      global $qty_extra;
      global $view;
      global $query_date;

      $change_event_params_arr = $_GET;
      unset( $change_event_params_arr['prod'] );
      $change_event_params = http_build_query($change_event_params_arr);

      //create change event link
      $change_event_link = '/booking-start/?'.$change_event_params;
      //create change participant number link

    ?>


    <!--product name-->
    <div class="product_name">
      <p>You are booking:&nbsp;
      <?= $event_name; ?>
      <?= ($qty_induction > 0) ? '(and Inductions)' : '' ; ?>
      &nbsp;<a href="<?= $change_event_link; ?>">Change</a></p>
    </div>

    <!--No. of People-->
    <?php
      $qty_to_display = $qty_total;
      if ($party) {
        $qty_to_display = $qty_party_guests + $qty_extra;
      }
    ?>
    <div class="no_of_adults">
      <?php get_template_part('templates/icons/helmet'); ?> x <?= $qty_to_display; ?>
    </div>

  </div>
</section>
