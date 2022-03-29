<?php
/**
 * Change several of the breadcrumb defaults
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'modfy_wc_breadcrumb' );
function modfy_wc_breadcrumb() {
  return array(
    'delimiter'   => ' &#47; ',
    'wrap_before' => '<div class="woocommerce-breadcrumb">',
    'wrap_after'  => '</div>',
    'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
  );
}
?>
