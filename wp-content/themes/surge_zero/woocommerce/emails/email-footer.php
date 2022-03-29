<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @package 	WooCommerce/Templates/Emails
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
															</div>
														</td>
													</tr>
												</table>
												<!-- End Content -->
											</td>
										</tr>
									</table>
									<!-- End Body -->
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<!-- Footer -->
									<table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
										<tr>
											<td>
												<div class="body_content_inner">
													<h3><a href="https://kartingnortheast.com/wp-content/uploads/2019/03/KNE-TERMS-AND-CONDITIONS-2019.pdf" target="_blank">Please read our terms and conditions</a></h3>
													<p>Under no circumstances are alcohol, drugs or other intoxicating substances allowed on the premises. You will not be allowed to take part in an event if you have, or appear to have, consumed such substances and your event will be deemed cancelled and no refund given.</p>
													<p>Please ensure you arrive promptly for your booking. If you arrive too late to take part in the safety briefing your event will be deemed cancelled and no refund given.</p>
													<p>You will be asked to sign a disclaimer before taking part in the Event to confirm that you are medically fit and well.  If you are in doubt you must check with your GP and speak to KNE prior to attending an event.</p>
												</div>
											</td>
										</tr>
										<tr style="background-color: #ffcc00;">
											<td><h3>Follow us:</h3></td>
										</tr>
										<tr class="social" style="background-color: #ffcc00;">
											<td>
												<a href="https://twitter.com/KNE_Official"><img src="https://kartingnortheast.com/wp-content/themes/surge_zero/assets/images/twitter_black_logo.png" /></a>
												<a href="https://www.facebook.com/knekartingnortheast/"><img src="https://kartingnortheast.com/wp-content/themes/surge_zero/assets/images/fb_black_logo.png" /></a>
												<a href="https://uk.pinterest.com/KNE_Official/"><img src="https://kartingnortheast.com/wp-content/themes/surge_zero/assets/images/pinterest_black_logo.png" /></a>
												<a href="https://www.instagram.com/kne_official/"><img src="https://kartingnortheast.com/wp-content/themes/surge_zero/assets/images/insta_black_logo.png" /></a>
											</td>
										</tr>
										<tr style="background-color: black;" class="subfooter">
											<td colspan="2" valign="middle" id="credit" style="border-radius: 0 !important; -webkit-border-radius: 0 !important;">
												<table>
													<tr>
														<td colspan="2"><?php echo wpautop( wp_kses_post( wptexturize( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) ) ) ); ?></td>
													</tr>
													<tr>
														<td class="contact-info">
															<p>tel: <a href="tel:01915214050">0191 521 40 50</a> &nbsp;&nbsp;&nbsp; e-mail:
															<a href="mailto:info@kartingnortheast.com">info@kartingnortheast.com</a></p>
															<p>Karting North East, Warden Law Motorsports Centre, Sunderland, Tyne & Wear, SR3 2PR</p>
														</td>
													</tr>
													<tr>
														<td class="co-reg-info"><p>Manor House Leisure Ltd T/A Karting North East, Reg. Office: Cardiff No: 2120865, VAT Reg No: 441696632</p></td>
													</tr>
											</table>
											</td>
										</tr>
									</table>
									<!-- End Footer -->
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
