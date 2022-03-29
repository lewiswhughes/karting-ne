<?php
//get cart
$cart = WC()->cart->get_cart();

?>

<script>
  var cartObj = <?= json_encode($cart); ?>;
  var countdownTimer = true;
</script>
