<?php
  global $date;
  global $now;
  global $wc_product_id;
  global $qty_total;
  global $qty_cadets;

  $event = ( $wc_product_id ) ? html_entity_decode(get_the_title($wc_product_id)) : 'No event specified' ;

?>

<section class="booking-enquiry-form-cont">
  <form id="booking-enquiry" class="fancy js-submit" method="post" action="" data-form-id="3">
    <h3>Can't find a date or time to suit you?</h3>

    <div class="message-container"></div>

    <div>
      <p>Tell us your requirements and we will see if we can fit you in!</p>

      <div class="left">
        <div>
          <input type="text" name="name" id="name" placeholder="Your name" required />
          <label for="name">Your Name</label>
        </div>

        <div>
          <input type="email" name="email" id="email" placeholder="Your email" required />
          <label for="email">Your E-mail</label>
        </div>

        <div>
          <input type="tel" name="phone" id="phone" placeholder="Contact phone number" />
          <label for="phone">Contact phone number</label>
        </div>

        <div>
          <input type="date" name="date" id="date" value="<?= $date; ?>" min="<?= $now->format('Y-m-d'); ?>" max="<?= $now->modify('+2 years')->format('Y-m-d'); ?>" />
          <label for="date">Date I am interested in</label>
        </div>
      </div>

      <div class="right">
        <div class="message-cont">
          <textarea name="message" id="message" placeholder="Your message"></textarea>
          <label for="message">Message</label>
        </div>
      </div>
    </div>

    <input type="hidden" name="event" value="<?= $event; ?>" />
    <input type="hidden" name="qty-total" value="<?= $qty_total; ?>" />
    <input type="hidden" name="qty-cadets" value="<?= $qty_cadets; ?>" />

    <input class="booking-enquiry-submit" type="submit" name="submit" value="submit" />
  </form>
</section>
