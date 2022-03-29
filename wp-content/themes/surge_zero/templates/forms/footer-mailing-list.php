<?php
if( isset($_POST['mailing-list-name']) ){

  $mailing_list_name = ( isset($_POST['mailing-list-name'])) ? filter_var($_POST['mailing-list-name'], FILTER_SANITIZE_STRING) : null ;
  $mailing_list_email = ( isset($_POST['mailing-list-email'])) ? filter_var($_POST['mailing-list-email'], FILTER_SANITIZE_EMAIL) : null ;
  $mailing_list_consent = ( isset($_POST['mailing-list-consent'])) ? $_POST['mailing-list-consent'] : null ;

  if( $mailing_list_name && $mailing_list_email && $mailing_list_consent ){
    $mailing_list_entry = array(
      'form_id' => 2,
      'created_by' => 'api',
      '1' => $mailing_list_name,
      '2' => $mailing_list_email,
      '4' => $mailing_list_consent
    );

    $mailing_list_form = GFAPI::get_form( 2 );
    $mailing_list_entry_id = GFAPI::add_entries( array($mailing_list_entry), 2 );
    $mailing_list_notifications = GFAPI::send_notifications( $mailing_list_form, $mailing_list_entry, 'form_submission' );
  ?>
    <section class="mailing-list-form-cont">
      <h2>Thank you!</h2>
      <p>We will respond as soon as we can, in the meantime, why not take a look at our <a href="/faqs">FAQs</a></p>
    </section>
  <?php
  } else {
  ?>
    <section class="mailing-list-form-cont">
      <h2>Uh-oh!</h2>
      <p>Sorry, there was a problem with your submission! </p>
    </section>
  <?php
  }
} else {
  //POST NOT SET YET
?>
  <section class="mailing-list-form-cont">
    <form class="fancy mailing-list" method="post" action="">

      <h3>Join Our Mailing List</h3>

      <div>
        <div>
          <input type="text" name="mailing-list-name" id="mailing-list-name" placeholder="Your name" required />
          <label for="mailing-list-name">Your Name</label>
        </div>

        <div>
          <input type="email" name="mailing-list-email" id="mailing-list-email" placeholder="Your email" required />
          <label for="mailing-list-email">Your E-mail</label>
        </div>

        <div>
          <input type="checkbox" name="mailing-list-consent" id="mailing-list-consent" required />
          <label for="mailing-list-consent"><p>I understand that KNE will send me e-mails regarding offers and events at KNE, and have read and agree with the terms set out in the KNE <a href="/privacy-policy">Privacy Policy</a>.</p></label>
        </div>
      </div>

      <input class="mailing-list-submit" type="submit" value="submit" onlcick="if(typeof _gaq !== 'undefined'){ _gaq.push(['_trackEvent', 'Button Click Tracking', 'Join Our Mailing List', 'Submit']); }" />
    </form>
  </section>
<?php
}
?>
