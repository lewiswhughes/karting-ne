<?php

  $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

  if ($contentType === 'application/json') {
    //Receive the RAW post data
    $sent = trim(file_get_contents('php://input'));
    $data = json_decode($sent, true);
    //If json_decoded
    if( is_array($data) ) {

      $form_id = (int) $data['data']['formid'];
      $name = filter_var( $data['data']['name'], FILTER_SANITIZE_STRING );
      $email = filter_var( $data['data']['email'], FILTER_SANITIZE_EMAIL );
      $phone = filter_var( $data['data']['phone'], FILTER_SANITIZE_STRING );
      $date = $data['data']['date'];
      $message = filter_var( $data['data']['message'], FILTER_SANITIZE_STRING );
      $event = filter_var( $data['data']['event'], FILTER_SANITIZE_STRING );
      $qty_total = (int) $data['data']['qtytotal'];
      $qty_cadets = (int) $data['data']['qtycadets'];


      if( $name && $email ){
        $entry = array(
          'form_id' => $form_id,
          'created_by' => 'api',
          '1' => $name,
          '2' => $email,
          '8' => $phone,
          '11' => $date,
          '4' => $event,
          '5' => $qty_total,
          '9' => $qty_cadets,
          '6' => $message
        );
        $form = GFAPI::get_form( $form_id );
        $entry_id = GFAPI::add_entries( array($entry), $form_id );
        $notifications = GFAPI::send_notifications( $form, $entry, 'form_submission' );
      }

    } else {

    }
  }


?>
