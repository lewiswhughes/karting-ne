<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//construct reservations array
$order_reservations = array();

$reservations = get_post_meta( $order->ID, 'reservations', true );

foreach( $reservations as $reservation ){
	$reservation_id = $reservation['reservation-id'];
	$start = new DateTimeImmutable( $reservation['start'] );
	$start_day = $start->format('Y-m-d');

	if( ! array_key_exists( $start_day,$order_reservations ) ){
		$order_reservations[$start_day] = array(
			'earliest' => $start,
			'reservations' => array()
		);
	}

	$order_reservations[$start_day]['reservations'][$start->format('YmdHis')] = $reservation;

	//modify earliest start
	if( $start < $order_reservations[$start_day]['earliest'] ){
		$order_reservations[$start_day]['earliest'] = $start;
	}

}

?>

<div class="woocommerce-order checkout-confirmation">

	<?php if ( $order ) : ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<h2>You're all set!</h2>
			<h3>Your order number: <?= $order->get_order_number(); ?></h3>

			<?php
				//loop through days and reservations
				ksort( $order_reservations );
				foreach( $order_reservations as $date => $date_info){
					echo '<div class="reservation-day">';
					$date_display = $date_info['earliest']->format('l, jS F Y');
					$arrive_by = $date_info['earliest']->modify('-40 minutes')->format('H:i');
					echo '<h3>'.$date_display.'</h3>';
					echo '<p class="arrive-by">Please arrive by '.$arrive_by.' for your first event.</p>';
					ksort($date_info['reservations']); //sort by start time

					foreach( $date_info['reservations'] as $index => $reservation ){
						$start = new DateTimeImmutable( $reservation['start'] );
						$cadets_only = get_field( 'cadets_only', $reservation['wc-product-id'] );
						$product_categories = wp_get_post_terms( $reservation['wc-product-id'], 'product_cat', array('fields'=>'slugs') );
						$karting = ( in_array('karting', $product_categories) ) ? true : false ;
						$participant_term = ( $karting ) ? 'Racers' : 'Participants' ;
						if( $party ){
							$participant_term = 'Guests';
						}
			?>
						<article class="reservation-item">
							<h4><?= $reservation['event-title']; ?></h4>
							<p class="time"><?= $start->format('H:i'); ?></p>

							<div class="participants">

								<div>
									<p>Total <?= $participant_term; ?></p>
									<p>
										<?php
											if( $karting ){
												get_template_part('templates/icons/helmet');
											} else {
												get_template_part('templates/icons/person');
											}
											echo ' x'.$reservation['quantity'];
										?>
									</p>
								</div>

								<?php if( $karting && $reservation['qty-cadets'] > 0 && ! $cadets_only ){ ?>
									<div>
										<p>14+</p>
										<p><?php get_template_part('templates/icons/helmet'); ?> x<?= $reservation['quantity'] - $reservation['qty-cadets']; ?></p>
									</div>
									<div>
										<p>8-13</p>
										<p><?php get_template_part('templates/icons/helmet'); ?> x<?= $reservation['qty-cadets']; ?></p>
									</div>
								<?php } ?>

							</div>

							<?php
							$qty_total = $reservation['quantity'] + $reservation['qty-cadets'];
							$qty_cadets = $reservation['qty-cadets'];
							$twelve_or_below = ($reservation['qty-induction'] > 1) ? 'yes' : 'no';
							$qty_inductions = $reservation['qty-inductions'];
							$product_id = $reservation['wc-product-id'];
							$query_date = new DateTime($reservation['start']);
							$res_id = $reservation['event-reservation-id'];

							// hide on induction
							if ($reservation['event-title'] !== "Induction Session") {
								?>
								<div class="share_link">
									<h4>Share this unique link with your friends to let them join in on the fun and book alongside you!</h4>
									<p>http://localhost:8081/booking/?qty_total=<?= $qty_total; ?>&qty_cadets=<?= $qty_cadets; ?>&twelve_or_below=<?= $twelve_or_below; ?>&qty_induction=<?= $qty_inductions; ?>&prod=<?= $product_id; ?>&view=day&query_date=<?= $query_date->format('Y-m-d'); ?>&res_id=<?= $res_id; ?></p>
								</div>
								<?php
							}
							?>

						</article>
			<?php
					}
					echo '</div>';
				}

			?>

			<p>You will receive a confirmation e-mail shortly, in the meantime if you have any further questions check out our FAQs or call us on <a href="tel:01915214050">0191 521 40 50</a>.</p>
			<p><a class="link_button next" href="/">Back to home</a></p>

			<h2>Order Summary</h2>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

				<li class="woocommerce-order-overview__order order">
					<?php _e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_order_number(); ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date">
					<?php _e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<?php _e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo $order->get_billing_email(); ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total">
					<?php _e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo $order->get_formatted_order_total(); ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
						<?php _e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

	<?php endif; ?>

</div>
