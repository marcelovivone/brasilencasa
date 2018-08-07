<?php if(!class_exists('Rain\Tpl')){exit;}?><script>
function submitForm(element, idproduct) {
	console.log(idproduct);
	let form = '';
	form = document.getElementById(`checkout-cart-form${idproduct}`);

	if ($(element).attr('name') === 'delete-link') {
		let el = '';

		for (var i = form.elements.length - 1; i >= 0; i--) {
			el = form.elements[i];

			if ($(el).attr('name') === 'nrquantity') {
				$(el).val(0);
			}
		}
	}

	form.method = 'post';
	form.action = '/en/checkout/cart/input';

	$(form).submit();
}
</script>

<section id="checkout-cart" class="wow fadeInUp">
	<div class="form">
		<div class="container">
			<div class="row">
				<div class="form-group col-12">
					<div id="error-message"></div>
					<?php if( $error != '' ){ ?>

					<div id="error-message-2">
						<?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>

					</div>
					<?php } ?>                
				</div>

				<div class="section-header col-6">
					<h2>Shopping Cart</h2>
				</div>

				<div class="col-6 d-flex justify-content-end" style="height: 60px;">
					<button type="button" class="btn btn-common col-6" onclick="window.location.href='/en/products'">Continue Shopping</button>
					<button type="button" class="btn btn-common col-6 mr-0" onclick="window.location.href='/en/checkout'">Proceed to Checkout</button>
				</div>

				<div class="col-md-12">
					<div class="product-content-right">
						<div class="woocommerce">
							<table class="table">
								<thead>
									<tr>
										<th scope="col" style="width:20%">Product</th>
										<th scope="col" style="width:11%">Name</th>
										<th scope="col" class="number" style="width:23%">Price</th>
										<th scope="col" class="number" style="width:23%">QTY</th>
										<th scope="col" class="number" style="width:23%">Subtotal</th>
									</tr>
								</thead>

								<tbody>
									<?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>

									<form action="" method="post" class="checkout-cart-form" id="checkout-cart-form<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
									<input type="text" name="idproduct" id="idproduct" value="<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" hidden/>
										<tr>
											<th scope="row">
												<div class="product-item wow fadeInUpQuick" data-wow-delay="1s">
													<figure class="m-0 p-0">
														<a><img alt="<?php echo htmlspecialchars( $value1["nmproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" src="/assets/img/products/product<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>.jpg"></a>
														<figcaption>
															<div class="d-flex justify-content-center social">
																<a class="nav-link" href="/en/products/<?php echo htmlspecialchars( $value1["dsurl"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-info info"></i></a>
<!--
					        									<a class="nav-link" href="javascript:void(0);" name="delete-link" onclick="submitForm(this, <?php echo htmlspecialchars( $cart["idcart"], ENT_COMPAT, 'UTF-8', FALSE ); ?>);"><i class="fa fa-trash trash"></i></a>
-->
					        									<a class="nav-link" href="javascript:void(0);" name="delete-link" onclick="submitForm(this, <?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>);"><i class="fa fa-trash trash"></i></a>
															</div>
														</figcaption>
													</figure>
												</div>
											</th>

											<td><?php echo htmlspecialchars( $value1["nmproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>

											<td class="number">
												<?php echo formatEU($value1["vlprice"]); ?> €
											</td>

											<td class="number">
												<div class="count-input space-bottom">
													<button type="submit" class="btn incr-btn col-1" formaction="/en/checkout/cart/minus">&minus;</button>
<!--
													<input class="quantity" type="number" name="nrquantity" id="nrquantity" value="<?php echo htmlspecialchars( $value1["nrquantity"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" onblur="submitForm(this, <?php echo htmlspecialchars( $cart["idcart"], ENT_COMPAT, 'UTF-8', FALSE ); ?>);"/>
-->
													<input class="quantity" type="number" name="nrquantity" id="nrquantity" value="<?php echo htmlspecialchars( $value1["nrquantity"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" onblur="submitForm(this, <?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>);"/>
													<button type="submit" class="btn incr-btn col-1" formaction="/en/checkout/cart/plus">&plus;</button>
												</div>
											</td>

											<td class="number">
												<?php echo formatEU($value1["nrquantity"]*$value1["vlprice"]); ?> €
											</td>
										</tr>
									</form>
									<?php } ?>

									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td class="number">Subtotal</td>
										<td class="number">
											<?php echo formatEU($cart["vlsubtotal"]); ?> €
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td class="number">Shipping (free if over 50 €)</td>
										<td class="number">
											<?php if( $cart["vlsubtotal"] < 50 ){ ?>5,99<?php }else{ ?>0,00<?php } ?> €
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td class="number"><b>Total</b></td>
										<td class="number">
											<b><?php echo formatEU($cart["vltotal"]); ?> €</b>
										</td>
									</tr>
								</tbody>
							</table>

							<div class="col-12 d-flex justify-content-end checkout-button">
								<button type="button" class="btn btn-common col-3" onclick="window.location.href='/en/products'">Continue Shopping</button>
								<button type="button" class="btn btn-common col-3 mr-0" onclick="window.location.href='/en/checkout'">Proceed to Checkout</button>
							</div>
						</div>                        
					</div>                    
				</div>
			</div>
		</div>
	</div>
</section>