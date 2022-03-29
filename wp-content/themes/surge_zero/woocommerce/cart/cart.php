<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

//create object for cross-sells
$cart_cross_sells = array(
	'max_event_qty' => 0,
	'cross-sells' => array()
);

$cart_qty = 0; //will update throughout the cart
$cart_date = null;

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<h4>You have <?= count( WC()->cart->get_cart()) . ' items in your cart.'; ?></h4>
	<p><a href="/checkout/">Go to Checkout>></a></p>

	<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
		<thead>
			<tr>
				<th class="product-remove">&nbsp;</th>
				<th class="product-thumbnail">&nbsp;</th>
				<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th class="product-price"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
				<th class="product-quantity"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="product-subtotal"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>

			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				$product_obj = wc_get_product($product_id);
				$cross_sell_ids = $product_obj->get_cross_sell_ids();
				foreach( $cross_sell_ids as $cross_sell_id ){
					$cross_sell_product = wc_get_product($cross_sell_id);
					$cart_cross_sells['cross-sells'][$cross_sell_id] = $cross_sell_product;
				}
				$cadets_only = get_field('cadets_only', $product_id);
				$product_categories = wp_get_post_terms( $product_id, 'product_cat', array('fields'=>'slugs') );
			  $party = ( in_array('party', $product_categories) || in_array('extra-guest', $product_categories) ) ? true : false ;
				$extra_guest = ( in_array('extra-guest', $product_categories) ) ? true : false ;
			  $karting = ( in_array('karting', $product_categories) ) ? true : false ;
				$participant_term = ( $karting ) ? 'Racers' : 'Participants' ;
				if( $party ){
					$participant_term = 'Guests';
				}

				//check if event product
				$event_product = false;
				$terms = get_the_terms( $product_id, 'product_cat' );
				foreach( $terms as $term ){
					if($term->name == 'Event'){
						$event_product = true;
					}
				}

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>" id="<?= $cart_item['reservation-id']; ?>"  data-check-id="<?= $cart_item['check-id']; ?>" data-event-reservation="<?= $cart_item['event-reservation-id']; ?>" data-key="<?= $cart_item_key; ?>" data-unique-key="<?= $cart_item['unique_key']; ?>">

						<td class="product-remove">
							<!--woocommerce remove button-->
							<?php
								if( $event_product ){
							?>
									<!--KNE Custom remove Button-->
									<button type="button" class="kne-remove-cart-item" data-reservation-id="<?= $cart_item['reservation-id']; ?>" data-remove-url="<?= esc_url( wc_get_cart_remove_url( $cart_item_key )); ?>" >Remove</button>
							<?php
								} else {
							?>
									<a class="link_button" href="<?= esc_url( wc_get_cart_remove_url( $cart_item_key )); ?>" aria-label="remove this item from the cart">Remove</a>
							<?php
								}
								// @codingStandardsIgnoreLine
								// echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								// 	'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
								// 	esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								// 	__( 'Remove this item', 'woocommerce' ),
								// 	esc_attr( $product_id ),
								// 	esc_attr( $_product->get_sku() )
								// ), $cart_item_key );
							?>
						</td>

						<td class="product-thumbnail">
						<?php
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

						if ( ! $product_permalink ) {
							echo $thumbnail; // PHPCS: XSS ok.
						} else {
							printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
						}
						?>
						</td>

						<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
						<?php
						if ( ! $product_permalink ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
						} else {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
						}

						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

						// Meta data.
						echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

						// Backorder notification.
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
						}
						?>
						</td>

						<!--hiding this and showing later on-->
						<td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
							<?php
								// if($event_product){
								//
								// } else{
								// 	echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
								// }
							?>
						</td>

						<!--event details-->
						<?php
						if( $event_product ){

							//total racers
							$total_racers = ( $cadets_only ) ? $cart_item['qty-cadets'] : $cart_item['quantity'] ;
							//if party
							if( $party && ! $extra_guest ){
								$total_racers = $cart_item['party-guests'];
							}
						?>
						<td class="product-event-details">
							<div class="event-date">
								<?php
									$start_datetime = new DateTime($cart_item['start']);
									echo '<p>'.$start_datetime->format('l, jS F Y').'</p>';
									echo '<p>'.$start_datetime->format('H:i').'</p>';
									$cart_date = $start_datetime->format('Y-m-d');
								?>
							</div>
							<div class="event-racers">
								<!--Total-->
								<div>
									<label>Total <?= $participant_term; ?></label>
									<?php
										if( $karting ){
											get_template_part('templates/icons/helmet');
										} else {
											get_template_part('templates/icons/person');
										}
									?>
									<p>&nbsp;x<?= $total_racers; ?></p>
								</div>
								<?php
								if( $cart_item['qty-cadets'] > 0 && !$cadets_only ){
								?>
									<!--Adults-->
									<div>
										<label>14+</label>
										<?php get_template_part('templates/icons/helmet'); ?>
										<p>x<?= ($cart_item['quantity'] - $cart_item['qty-cadets']); ?></p>
									</div>
									<!--Cadets-->
									<div>
										<label>8-13</label>
										<?php get_template_part('templates/icons/helmet'); ?>
										<p>x<?= $cart_item['qty-cadets']; ?></p>
									</div>
								<?php
								}
								?>
							</div>
						</td>
						<?php
						}
						?>

						<!--hidden qty if event category-->
						<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
						<?php
						if($event_product){
							//get qty and set max event qty
							if($cart_item['quantity'] > $cart_cross_sells['$max_event_qty']){
								$cart_cross_sells['$max_event_qty'] = $cart_item['quantity'];
								$cart_qty = $cart_item['quantity'];
							}
						} else {
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								// $product_quantity = woocommerce_quantity_input( array(
								// 	'input_name'   => "cart[{$cart_item_key}][qty]",
								// 	'input_value'  => $cart_item['quantity'],
								// 	'max_value'    => $_product->get_max_purchase_quantity(),
								// 	'min_value'    => '0',
								// 	'product_name' => $_product->get_name(),
								// ), $_product, false );

								//custom input code that triggers form update on change
								$max = ($_product->get_max_purchase_quantity() > 1 ) ? $_product->get_max_purchase_quantity() : 100 ;
								echo '<label>Quantity</label>';
								echo '<input type="number" name="'."cart[{$cart_item_key}][qty]".'" value="'.$cart_item['quantity'].'" min="1" max="'.$max.'" size="6" onchange="{ var updateButton = document.getElementsByName(\'update_cart\')[0]; updateButton.click(); console.log(updateButton) }" />';
							}
							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
						}
						?>
						</td>

						<td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
							<?php
								echo '<p class="total-price">';
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
								echo '</p>';
								echo '<p class="breakdown">';
								echo ' (';
								echo $cart_item['quantity'] .'x ';
								if( $product_obj->is_on_sale() ){
									echo '<strike>'.wc_price( $product_obj->get_regular_price() ).'</strike>';
								}
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								if($event_product){
									echo ' per person';
								} else {
									echo ' each';
								}
								echo ')';
								echo '</p>';
							?>
						</td>
					</tr>
					<?php
				}
			}
			?>

			<?php do_action( 'woocommerce_cart_contents' ); ?>

			<tr class="add-activity-link">
				<td><a href="/booking-start/?query_date=<?= $cart_date; ?>&qty_total=<?= $cart_qty; ?>">Add another activity&gt;&gt;</a></td>
			</tr>

			<tr>
				<td colspan="6" class="actions">

					<?php if ( wc_coupons_enabled() ) { ?>
						<details class="coupon">
							<summary for="coupon_code"><?php esc_html_e( 'Click here if you have a voucher code', 'woocommerce' ); ?></summary> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
							<?php do_action( 'woocommerce_cart_coupon' ); ?>
						</details>
					<?php } ?>

					<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

					<?php do_action( 'woocommerce_cart_actions' ); ?>

					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</td>
			</tr>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>


<!--CUSTOM CROSS-SELLS-->
<?php
//get cart for check id
$items = WC()->cart->get_cart();
$existingCheckId = null;
$checkWarning = false;
if( count($items) > 0 ){
	foreach( $items as $cart_item ){
		//get only first check id encountered
		if( !$existingCheckId && (int) $cart_item['check-id'] > 0 ){
			$existingCheckId = (int) $cart_item['check-id'];
		}
		if( $cart_item['check-id'] != $existingCheckId && (int) $cart_item['check-id'] > 0 ){
			$checkWarning = true;
		}
	}
}
if($checkWarning){
	error_log('Warning; more than one check id in cart.');
}
?>

<script>
	var cart = <?= json_encode($items); ?>;
</script>

<?php
if( count($cart_cross_sells['cross-sells']) > 0 ){
?>
	<section class="cross-sells">
		<h2>Enhance your experience with these items...</h2>
		<div class="cross-sells-cont">
		<?php
			foreach( $cart_cross_sells['cross-sells'] as $cross_sell_id => $cart_cross_sell ){

				$this_qty = $cart_cross_sells['$max_event_qty'];
				$product_id = get_field( 'product_id', $cross_sell_id );
				$recommended_number = get_field( 'recommended_number', $cross_sell_id );
				if( $recommended_number == '' ){
					$start_qty = $this_qty;
				} else {
					if( $recommended_number == 'single' ){
						$start_qty = 1;
					} else {
						$multiplier = str_replace('', 'per_', $recommended_number);
						$start_qty = $multiplier * $this_qty;
					}
				}

				echo '<div class="cross-sell" data-cross-sell-id="'.$cross_sell_id.'" data-product-id="'.$product_id.'" data-check-id="'.$existingCheckId.'" >';
				echo '<h3>'.$cart_cross_sell->get_title().'</h3>';
				// echo '<div class="img-cont">';
				// echo wp_get_attachment_image( $cart_cross_sell->get_image_id(), 'small' );
				// echo '</div>';
				echo '<p>'.$cart_cross_sell->get_short_description().'</p>';
				echo '<p>'. wc_price( $cart_cross_sell->get_price() ).' each</p>';
				echo '<div class="inputs">';
				echo '<label>Quantity</label>';
				echo '<input type="number" id="cs_qty_input_'.$cross_sell_id.'" value="'.$start_qty.'" onchange="{ document.getElementById(\'cs-add-to-cart-'.$cross_sell_id.'\').href = \'/cart/?add-to-cart='.$cross_sell_id.'&quantity=\' + this.value }" min="1" max="100" size="5" />';
				echo '<a class="link_button cs-add-to-cart" id="cs-add-to-cart-'.$cross_sell_id.'"  href="/cart/?add-to-cart='.$cross_sell_id.'&quantity='.$start_qty.'">Add to cart</a>';
				echo '</div>'; //close inputs div
				echo '</div>';
			}
		?>
	</div>
	</section>
<?php
}
?>

<div class="cart-collaterals">
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action( 'woocommerce_cart_collaterals' );
	?>
</div>


<?php do_action( 'woocommerce_after_cart' ); ?>
