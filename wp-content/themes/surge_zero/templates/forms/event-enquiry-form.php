<?php

  $now = new DateTimeImmutable();

  $event_term = get_term_by('slug', 'event', 'product_cat');
  $args = array(
   'taxonomy'     => 'product_cat',
   'orderby'      => 'name',
   'hierarchical' => 1,
   'hide_empty'   => 1,
   'parent'       => $event_term->term_id
  );
  $categories = get_categories( $args );

?>

<section class="event-enquiry-form-cont">
  <form id="event-enquiry" class="fancy js-submit" method="post" action="" data-form-id="4">
    <h3>Send us an enquiry</h3>

    <div class="message-container"></div>

    <div>
      <p>Tell us your requirements and the events your are interested in and we will be in touch!</p>

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
          <input type="date" name="date" id="date" value="<?= $now->format('Y-m-d'); ?>" min="<?= $now->format('Y-m-d'); ?>" max="<?= $now->modify('+2 years')->format('Y-m-d'); ?>" />
          <label for="date">Date I am interested in</label>
        </div>

        <div>
          <input type="text" name="participants" id="participants" placeholder="Size of your group" />
          <label for="participants">Size of your group</label>
        </div>

        <div>
          <h4>Events I am interested in:</h4>
          <?php
            foreach( $categories as $category ){
          ?>
            <div>
              <input type="checkbox" name="events-of-interest" id="events-of-interest-<?= $category->term_id; ?>" value="<?= $category->name; ?>" />
              <label for="events-of-interest-<?= $category->term_id; ?>"><?= $category->name; ?></label>
            </div>
          <?php
            }
          ?>
        </div>
      </div>

      <div class="right">
        <div class="message-cont">
          <textarea name="message" id="message" placeholder="Your message"></textarea>
          <label for="message">Message</label>
        </div>
      </div>
    </div>

    <input type="hidden" name="source-page" value="<?= $_SERVER['REQUEST_URI']; ?>" />


    <input class="event-enquiry-submit" type="submit" name="submit" value="submit" />
  </form>
</section>
