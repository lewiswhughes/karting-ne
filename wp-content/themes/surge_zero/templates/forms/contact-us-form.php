<?php
if( isset($_POST['contact-name']) ){

  $name = ( isset($_POST['contact-name'])) ? filter_var($_POST['contact-name'], FILTER_SANITIZE_STRING) : null ;
  $honeypot = ( isset($_POST['email'])) ? filter_var($_POST['email'], FILTER_SANITIZE_STRING) : null ;
  $email = ( isset($_POST['contact-email'])) ? filter_var($_POST['contact-email'], FILTER_SANITIZE_EMAIL) : null ;
  $message = ( isset($_POST['contact-message'])) ? filter_var($_POST['contact-message'], FILTER_SANITIZE_STRING) : null ;
  $consent = ( isset($_POST['contact-consent'])) ? $_POST['contact-consent'] : null ;

  if(strlen($honeypot) < 1 ){
    if( $name && $email && $message && $consent ){
      $entry = array(
        'form_id' => 1,
        'created_by' => 'api',
        '1' => $name,
        '2' => $email,
        '3' => $message,
        '4' => $consent
      );
      $form = GFAPI::get_form( 1 );
      $entry_id = GFAPI::add_entries( array($entry), 1 );
      $notifications = GFAPI::send_notifications( $form, $entry, 'form_submission' );
  ?>
      <section class="contact-us-form-cont">
        <h2>Thank you!</h2>
        <p>We will respond as soon as we can, in the meantime, why not take a look at our <a href="/faqs">FAQs</a></p>
      </section>
  <?php
    }
  } else {
  ?>
    <section class="contact-us-form-cont">
      <h2>Uh-oh!</h2>
      <p>Sorry, there was a problem with your submission! Please call us on <a href="tel:01915214050">0191 521 40 50</a></p>
    </section>
  <?php
  }
} else {
  //POST NOT SET YET
?>
  <section class="contact-us-form-cont">
    <form class="fancy contact-us" method="post" action="">
      <h3>Leave us a message</h3>

      <div>
        <div class="left">
          <div>
            <input type="text" name="contact-name" id="contact-name" placeholder="Your name" required />
            <label for="contact-name">Your Name</label>
          </div>

          <div>
            <input class="hp" type="email" name="email" id="hp-email" placeholder="Your email" />
            <input type="email" name="contact-email" id="contact-email" placeholder="Your email" required />
            <label for="contact-email">Your E-mail</label>
          </div>

          <div>
            <input type="checkbox" name="contact-consent" id="contact-consent" required />
            <label for="contact-consent"><p>I understand that KNE may from time to time send me e-mails regarding offers and events at KNE, and I have read and agree with the terms set out in the KNE <a href="/privacy-policy">privacy policy</a>.</p></label>
          </div>
        </div>
        <div class="right">
          <div class="message-cont">
            <textarea name="contact-message" id="contact-message" placeholder="Your message" required></textarea>
            <label for="contact-message">Message</label>
          </div>
        </div>
      </div>

      <input class="contact-form-submit" type="submit" value="submit" />
    </form>
  </section>
<?php
}
?>
