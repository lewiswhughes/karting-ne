<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//check if reservations in cart
$order_reservations = array();
//check ids to display in e-mail
$check_ids = array();

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

	//check ids
	array_push( $check_ids, $reservation['check-id'] );

}

$text_align = is_rtl() ? 'right' : 'left';

do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email );
?>

<h2>
	<?php
	if ( $sent_to_admin ) {
		$before = '<a class="link" href="' . esc_url( $order->get_edit_order_url() ) . '">';
		$after  = '</a>';
	} else {
		$before = '';
		$after  = '';
	}
	/* translators: %s: Order ID. */
	echo wp_kses_post( $before . sprintf( __( '[Order #%s]', 'woocommerce' ) . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format( 'c' ), wc_format_datetime( $order->get_date_created() ) ) );
	?>
</h2>
<h4 class="check-ids">KNE Order references: <?= implode( ', ', $check_ids ); ?></h4>

<!--RESERVATION INFO-->
<?php
if( count($order_reservations)  > 0 ){
	ksort( $order_reservations );
	foreach( $order_reservations as $date => $date_info){
		echo '<div class="reservation-day">';
		$date_display = $date_info['earliest']->format('l, jS F Y');
		$arrive_by = $date_info['earliest']->modify('-40 minutes')->format('H:i');
		echo '<h3 class="reservation-date">'.$date_display.'</h3>';
		echo '<p class="arrive-by">Please arrive by '.$arrive_by.' for your first event.</p>';
		ksort($date_info['reservations']); //sort by start time

		echo '<table class="reservation-item">';

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
			<tr>
				<td>
					<h4 class="event-title"><?= $reservation['event-title']; ?></h4>
					<p class="time"><?= $start->format('H:i'); ?></p>

					<!--SHARING-->
					<?php
					$qty_total = $reservation['quantity'] + $reservation['qty-cadets'];
					$qty_cadets = $reservation['qty-cadets'];
					$twelve_or_below = ($reservation['qty-induction'] > 1) ? 'yes' : 'no';
					$qty_induction = $reservation['qty-induction'];
					$product_id = $reservation['wc-product-id'];
					$query_date = new DateTime($reservation['start']);
					$res_id = $reservation['event-reservation-id'];
					?>

					<?php
					// hide on induction
					if ($reservation['event-title'] !== "Induction Session") {
						
						$full_url = "https://kartingnortheast.com/booking/?qty_total=".$qty_total."&qty_cadets=".$qty_cadets."&twelve_or_below=".$twelve_or_below."&qty_induction=".$qty_induction."&prod=".$product_id."&view=day&query_date=".$query_date->format('Y-m-d')."&res_id=".$res_id;
						?>

						<p>Share the fun with friends and family - use our buttons below to let them book alongside you!</p>

						<a href="https://www.facebook.com/sharer/sharer.php?u=<?= $full_url; ?>" class="share_btn facebook_btn" style="width:2.5rem;height:auto;display:inline-block;margin-right:.25rem;">
							<img src="<?= get_template_directory_uri(); ?>/assets/images/fb-blue.png" alt="Facebook button" title="Facebook button" style="width:100%;height:auto;">
						</a>
						<a href="https://twitter.com/home?status=<?= $full_url; ?>" class="share_btn twitter_btn" style="width:2.5rem;height:auto;display:inline-block;margin-right:.25rem;">
							<img src="<?= get_template_directory_uri(); ?>/assets/images/tw-blue.png" alt="Twitter button" title="Twitter button" style="width:100%;height:auto;">
						</a>
						<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= $full_url; ?>&title=&summary=&source=" class="share_btn linkedin_btn" style="width:2.5rem;height:auto;display:inline-block;margin-right:.25rem;">
							<img src="<?= get_template_directory_uri(); ?>/assets/images/li-blue.png" alt="LinkedIn button" title="LinkedIn button" style="width:100%;height:auto;">
						</a>
						<a href="mailto:?subject=&body=<?= $full_url; ?>" class="share_btn email_btn" style="width:2.5rem;height:auto;display:inline-block;margin-right:.25rem;">
							<img src="<?= get_template_directory_uri(); ?>/assets/images/mail_share.png" alt="LinkedIn button" title="LinkedIn button" style="width:100%;height:auto;">
						</a>

						<p style="margin:0 0 16px;font-size:12px;line-height:1.4;margin-top:2rem;">(or share this link directly: <?= $full_url; ?>)</p>
						
						<?php
					}
					?>

				</td>

				<td class="participants">
					<table>
						<tr>
							<td><p><strong>Total <?= $participant_term; ?></strong></p></td>
							<td><p><?= ' x'.$reservation['quantity']; ?></p></td>
						</tr>
						<?php
							if( $karting && $reservation['qty-cadets'] > 0 && ! $cadets_only ){
						?>
								<tr>
									<td><strong><p>14+</p></strong></td>
									<td><p>x<?= $reservation['quantity'] - $reservation['qty-cadets']; ?></p></td>
								</tr>
								<tr>
									<td><strong><p>8-13</p></strong></td>
									<td><p><?php get_template_part('templates/icons/helmet'); ?> x<?= $reservation['qty-cadets']; ?></p></td>
								</tr>
						<?php
							}
						?>
					</table>
				</td>
			</tr>
<?php
		}
		echo '</table>';
		echo '</div>';
	}
}
?>

<!--GENERAL ORDER INFO-->

<h3>Order summary</h3>
<div style="margin-bottom: 40px;">
	<table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="1">
		<thead>
			<tr>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></th>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Price', 'woocommerce' ); ?></th>
				<th class="td" scope="col" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<?php
			echo wc_get_email_order_items( $order, array( // WPCS: XSS ok.
				'show_sku'      => $sent_to_admin,
				'show_image'    => false,
				'image_size'    => array( 32, 32 ),
				'plain_text'    => $plain_text,
				'sent_to_admin' => $sent_to_admin,
			) );
			?>
		</tbody>
		<tfoot>
			<?php
			$totals = $order->get_order_item_totals();

			if ( $totals ) {
				$i = 0;
				foreach ( $totals as $total ) {
					$i++;
					?>
					<tr>
						<th class="td" scope="row" colspan="3" style="text-align:<?php echo esc_attr( $text_align ); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 4px;' : ''; ?>"><?php echo wp_kses_post( $total['label'] ); ?></th>
						<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 4px;' : ''; ?>"><?php echo wp_kses_post( $total['value'] ); ?></td>
					</tr>
					<?php
				}
			}
			//VAT
			$vat = get_field('vat','option');
			$vat_total = number_format( $order->get_total() * ($vat/100), 2, '.', ',' );
			?>
			<tr>
				<th class="td" scope="row" colspan="3" style="text-align:<?php echo esc_attr( $text_align ); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 4px;' : ''; ?>">VAT at <?= $vat; ?>% (included in total)</th>
				<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>; <?php echo ( 1 === $i ) ? 'border-top-width: 4px;' : ''; ?>"><?= '£'.$vat_total; ?></td>
			</tr>
			<?php
			if ( $order->get_customer_note() ) {
				?>
				<tr>
					<th class="td" scope="row" colspan="3" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
					<td class="td" style="text-align:<?php echo esc_attr( $text_align ); ?>;"><?php echo wp_kses_post( wptexturize( $order->get_customer_note() ) ); ?></td>
				</tr>
				<?php
			}
			?>
		</tfoot>
	</table>
</div>

<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
