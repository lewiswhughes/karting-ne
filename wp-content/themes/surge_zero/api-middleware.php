<?php

  $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

  // if ($contentType === 'application/json') {
    //Receive the RAW post data
    $sent = trim(file_get_contents('php://input'));

    error_log( 'sent: '.json_encode($_POST) );

    $data = json_decode($sent, true);
    //If json_decoded
    if( is_array($data) ) {

      $wb_api_key = getenv('WORKBOOKS_API_KEY');

      require '../../../vendor/autoload.php';

      $client = new GuzzleHttp\Client();
      $res = $client->request('GET', 'https://secure.workbooks.com/crm/people.api?api_key='.$wb_api_key.'&_ff[]=id&_ft[]=eq&_fc[]=52191&_select_columns[]=name&_select_columns[]=email');
      $body = $res->getBody();
      echo json_encode( array( 'body' => $body ));
    } else {
      echo json_encode( array('error'=>'Error: There was a problem reading the data you sent'));
    }
  // } else {
    // echo json_encode( array('error'=>'Error: Content type not json'));
  // }

?>
