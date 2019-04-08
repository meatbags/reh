				</main>
			</div> <?php // end of container?>

			<footer class="main-wrapper container">

				<?php wp_nav_menu('Footer Links'); ?>

				<div class="footer-usps">
					<?php echo do_shortcode('[static_block_content id="301"]');?>
				</div>

			</footer>

			<?php // newsletter popup ?>
				<div class="modal newsletter">
					<div class="modal__close">×</div>
					<div class="modal__wrapper">
						<?php echo do_shortcode('[static_block_content id="442"]'); // local?>
						<?php echo do_shortcode('[static_block_content id="654"]'); // live ?>
					</div>
				</div>
			<?php // end newsletter popup ?>

			<?php // follow popup ?>
				<div class="modal flw">
					<div class="modal__close">×</div>
					<div class="modal__wrapper">
						<?php echo do_shortcode('[static_block_content id="441"]'); // local?>
						<?php echo do_shortcode('[static_block_content id="655"]'); // live ?>
					</div>
				</div>
			<?php // end follow popup ?>

			<?php // dynamic cart start ?>
			<div class="dynamic-cart">
				<div class="dynamic-cart__close" id="btn-close-cart">×</div>
				<div class="dynamic-cart__wrapper">
					<?php if ( ! WC()->cart->is_empty() ) : ?>
						<?php do_action( 'woocommerce_before_cart' ); ?>

						<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

						<?php do_action( 'woocommerce_before_cart_table' ); ?>

						<table class="shop_table shop_table_responsive cart" cellspacing="0">
							<thead>
								<tr>
									<th class="product-remove">&nbsp;</th>
									<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
									<th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
									<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php do_action( 'woocommerce_before_cart_contents' ); ?>

								<?php
								foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
									$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
									$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

									if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
										$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
										?>
										<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

											<td class="product-remove">
												<?php
													echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
														'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
														esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
														__( 'Remove this item', 'woocommerce' ),
														esc_attr( $product_id ),
														esc_attr( $_product->get_sku() )
													), $cart_item_key );
												?>
											</td>

											<td class="product-name" data-title="<?php _e( 'Product', 'woocommerce' ); ?>">
												<?php
													if ( ! $product_permalink ) {
														echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
													} else {
														echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title() ), $cart_item, $cart_item_key );
													}

													// Meta data
													echo WC()->cart->get_item_data( $cart_item );

													// Backorder notification
													if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
														echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
													}
												?>
											</td>

											<td class="product-price" data-title="<?php _e( 'Price', 'woocommerce' ); ?>">
												<?php
													echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
												?>
											</td>

											<td class="product-quantity" data-title="<?php _e( 'Quantity', 'woocommerce' ); ?>">
												<?php
													if ( $_product->is_sold_individually() ) {
														$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
													} else {
														$product_quantity = woocommerce_quantity_input( array(
															'input_name'  => "cart[{$cart_item_key}][qty]",
															'input_value' => $cart_item['quantity'],
															'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
															'min_value'   => '0'
														), $_product, false );
													}

													echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
												?>
											</td>
										</tr>
										<?php
									}
								}

								do_action( 'woocommerce_cart_contents' );
								?>
								<tr>
									<td colspan="6" class="actions">

										<?php /*<?php if ( wc_coupons_enabled() ) { ?>
											<div class="coupon">

												<label for="coupon_code"><?php _e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'woocommerce' ); ?>" />

												<?php do_action( 'woocommerce_cart_coupon' ); ?>
											</div>
										<?php } ?> */?>

										<input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?>" />

										<?php do_action( 'woocommerce_cart_actions' ); ?>

										<?php wp_nonce_field( 'woocommerce-cart' ); ?>
									</td>
								</tr>

								<?php do_action( 'woocommerce_after_cart_contents' ); ?>
							</tbody>
						</table>

						<?php do_action( 'woocommerce_after_cart_table' ); ?>

					</form>

					<div class="cart-collaterals clearfix">

						<?php //do_action( 'woocommerce_cart_collaterals' ); ?>

						<div class="cart_totals <?php if ( WC()->customer->has_calculated_shipping() ) echo 'calculated_shipping'; ?>">

							<?php do_action( 'woocommerce_before_cart_totals' ); ?>

							<table cellspacing="0" class="shop_table shop_table_responsive">

								<tr class="cart-subtotal">
									<th><?php _e( 'Subtotal', 'woocommerce' ); ?></th>
									<td data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></td>
								</tr>

								<?php /*<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
									<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
										<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
										<td data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
									</tr>
								<?php endforeach; ?>*/?>

								<?php /* <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

									<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

									<?php wc_cart_totals_shipping_html(); ?>

									<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

								<?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>

									<tr class="shipping">
										<th><?php _e( 'Shipping', 'woocommerce' ); ?></th>
										<td data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>"><?php woocommerce_shipping_calculator(); ?></td>
									</tr>

								<?php endif; ?>

								<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
									<tr class="fee">
										<th><?php echo esc_html( $fee->name ); ?></th>
										<td data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></td>
									</tr>
								<?php endforeach; ?>

								<?php if ( wc_tax_enabled() && 'excl' === WC()->cart->tax_display_cart ) :
									$taxable_address = WC()->customer->get_taxable_address();
									$estimated_text  = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
											? sprintf( ' <small>(' . __( 'estimated for %s', 'woocommerce' ) . ')</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] )
											: '';

									if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
										<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
											<tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
												<th><?php echo esc_html( $tax->label ) . $estimated_text; ?></th>
												<td data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
											</tr>
										<?php endforeach; ?>
									<?php else : ?>
										<tr class="tax-total">
											<th><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; ?></th>
											<td data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
										</tr>
									<?php endif; ?>
								<?php endif; ?>*/?>

								<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

								<tr class="order-total">
									<th><?php _e( 'Total', 'woocommerce' ); ?></th>
									<td data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_order_total_html(); ?></td>
								</tr>

								<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

							</table>

							<div class="wc-proceed-to-checkout clearfix">
								<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
							</div>

							<?php do_action( 'woocommerce_after_cart_totals' ); ?>

						</div>

					</div>

					<?php do_action( 'woocommerce_after_cart' ); ?>

				<?php else: ?>
					<p>Your cart is currently empty.</p>
				<?php endif; ?>

				</div>

			</div>
			<?php // dynamic cart end ?>

		<?php wp_footer(); ?>

	</body>

</html>
