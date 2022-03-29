<?php

  $products = wc_get_products( array(
    'category' => array( 'voucher' )
  ));

?>

<h1 class="page_header">E-Vouchers</h1>
<p class="large">Purchase an E-Voucher code for use when booking online on the Karting North East website.</p>

<h2>Choose a voucher value:</h2>
<form method="get" action="/cart/" >
  <select name="add-to-cart">
  <?php
  foreach( $products as $voucher ){
    echo '<pre>'.print_r($voucher, true).'</pre>';
    echo 'ID: '.$voucher->get_id();
    $cs_product_id = get_field('product_id', $voucher->get_id());
  ?>
    <option data-product-id="<?= $cs_product_id; ?>" value="<?= $voucher->get_id(); ?>">
      <?= $voucher->get_regular_price(); ?>
    </option>
  <?php
  }
  ?>
  </select>

  <label for="voucher-qty-input">Quantity</label>
  <input type="number" name="quantity" id="voucher-qty-input" min="1" value="1"  />

  <input class="next" type="submit" value="Add to cart" />
</form>
