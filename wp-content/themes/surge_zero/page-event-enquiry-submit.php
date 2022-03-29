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
      $events = $data['data']['events'];
      $participants = filter_var( $data['data']['participants'], FILTER_SANITIZE_STRING );
      $source = filter_var( $data['data']['source'], FILTER_SANITIZE_STRING );

      error_log( 'events:'.$events );

      if( $name && $email ){
        $entry = array(
          'form_id' => $form_id,
          'created_by' => 'api',
          '1' => $name,
          '2' => $email,
          '8' => $phone,
          '11' => $date,
          '14' => implode(', ', $events),
          '6' => $message,
          '5' => $participants,
          '12' => $source
        );
        $form = GFAPI::get_form( $form_id );
        $entry_id = GFAPI::add_entries( array($entry), $form_id );
        $notifications = GFAPI::send_notifications( $form, $entry, 'form_submission' );
      }

    } else {

    }
  }


?>
