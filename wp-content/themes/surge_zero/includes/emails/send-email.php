<?php

function sendgrid_email($details, $email_subject, $body, $test_bcc = null){
  // using SendGrid's PHP Library
  // https://github.com/sendgrid/sendgrid-php
  require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php'; // If you're using Composer (recommended)

  //get header and footer for styling
  // require('email_template.php');

  $from = array('email'=>'noreply@kartingnortheast.com', 'name'=>'KNE');
  $subject = $email_subject;
  $content_value = $email_header.$body.$email_footer;
  $content = array();
  array_push($content, array('type'=>'text/html', 'value'=>$content_value));
  $personalizations = array();

  //ADD PERSONALIZATIONS/ADDRESSES
  if(is_array($details)){
    foreach($details as $key => $recipient){
      $to = array();
      array_push($to, array('name'=>$recipient['name'], 'email'=>$recipient['email']));
      $substitutions = array('{{recipient-name}}'=>$recipient['name']);
      $personalization = array('to'=>$to, 'substitutions'=>$substitutions);
      if ($test_bcc) {
        $bcc = array(
          array(
            'name'=>'Surge MS',
            'email'=>'chris.f@surgems.co.uk'
          )
        );
        $personalization['bcc'] = $bcc;
      }
      array_push($personalizations, $personalization);
    }
  } else {
    //$email->addTo($details['email'], $details['name']);
    //$email->addSubstitution("{{staff-member-name}}", $details['name']);
  }

  $request_body = array('personalizations'=>$personalizations, 'from'=>$from, 'subject'=>$subject, 'content'=>$content);

  $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
  try {
      //print $response->statusCode() . "\n";
      //print_r($response->headers());
      //print $response->body() . "\n";
      $response = $sendgrid->client->mail()->send()->post($request_body);
      return array('success'=>true, 'mail'=>$request_body, 'response'=>$response->statusCode(), 'response_body'=>$response->body());
  } catch (Exception $e) {
      // echo 'Caught exception: ',  $e->getMessage(), "\n";
      error_log('Email exception: '.$e->getMessage());
      return $e->getMessage();
  }
  //return array('success'=>true, 'sendgrid'=>$sendgrid, 'api_key'=>getenv('SENDGRID_API_KEY'));
}

?>
