<?php if(!class_exists('Rain\Tpl')){exit;}?><script>
function displayAddress() {
	let el = document.getElementById('shipping-itens');

	if (el.style.display === 'none' || el.style.display === '') {
		el.style.display = 'block';
	} else {
		el.style.display = 'none';
    }

}

function creditCard(display) {
	let el = document.getElementById('credit-card-itens');
	el.style.display = display;

	// if payment method validation message was visible
	el = document.getElementById('validate');
	el.style.display = 'none';
}

function submitForm(form) {

	if (validateForm(form, false, '', '', 'en', true)) {
		form.method = "post";
		form.action = "/en/checkout/save";
		$(form).submit();
	} else {
		event.preventDefault();
	}
}

/*
paypal.Button.render({
  env: 'sandbox',
  client: {
    sandbox: 'demo_sandbox_client_id'
  },
  style: {
    color: 'gold',   // 'gold, 'blue', 'silver', 'black'
    size:  'medium', // 'medium', 'small', 'large', 'responsive'
    shape: 'rect'    // 'rect', 'pill'
  },
  payment: function (data, actions) {
    return actions.payment.create({
      transactions: [{
        amount: {
          total: '0.01',
          currency: 'USD'
        }
      }]
    });
  },
  onAuthorize: function (data, actions) {
    return actions.payment.execute()
      .then(function () {
        window.alert('Thank you for your purchase!');
      });
  }
}, '#paypal-button');
*/
</script>

<section id="checkout" class="wow fadeInUp">
	<div class="form">
		<div class="container">
			<form action="" method="post" id="checkout-form">
				<div class="row">
					<div class="form-group col-12">
						<div id="error-message"></div>
						<?php if( $error != '' ){ ?>
						<div id="error-message-2">
							<?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>
						</div>
						<?php } ?>
					</div>

					<div class="section-header col-12">
						<h2>Checkout</h2>
					</div>

					<div class="section-header col-4">
						<h5>Billing Address</h5>
					</div>

					<div class="section-header col-4">
						<h5>Payment Method</h5>
					</div>

					<div class="section-header col-4">
						<h5>Your Summary</h5>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<div class="row">
								<div class="col-6">
									<input type="text" class="form-control" id="nmfirst-billing" name="nmfirst-billing" placeholder="Fisrt Name" value="<?php echo htmlspecialchars( $user["nmfirst"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								</div>
								<div class="col-6">
									<input type="text" class="form-control" id="nmlast-billing" name="nmlast-billing" placeholder="Last Name" value="<?php echo htmlspecialchars( $user["nmlast"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-12">
									<input type="text" class="form-control" id="dsaddress-billing" name="dsaddress-billing" placeholder="Address" value='<?php echo utf8encode($address["dsaddress"]); ?>'>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-6">
									<input type="text" class="form-control" id="dsnumber-billing" name="dsnumber-billing" placeholder="Number" value="<?php echo htmlspecialchars( $address["dsnumber"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								</div>
								<div class="col-6">
									<input type="text" class="form-control" id="cdzipcode-billing" name="cdzipcode-billing" placeholder="Postal Code" value="<?php echo htmlspecialchars( $address["cdzipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-12">
									<input type="text" class="form-control" id="dscity-billing" name="dscity-billing" placeholder="City" value="<?php echo htmlspecialchars( $address["dscity"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-6">
									<input type="text" class="form-control" id="nrphone-billing" name="nrphone-billing" placeholder="Phone Number" value="<?php echo htmlspecialchars( $user["nrphone"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								</div>
								<div class="col-6">
									<input type="text" class="form-control" id="dscountry-billing" name="dscountry-billing" placeholder="Country" value="España" disabled>
								</div>
							</div>

							<div class="form-group">
								<div class="form-check form-check-inline custom-checkbox checkbox-greensea col-12 p-1 mt-2 mb-0">
									<input class="form-check-input" type="checkbox" name="difAddress" id="difAddress" value="N" onchange="displayAddress()">
									<label class="form-check-label" for="difAddress">
										<span>Ship to a different address</span>
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="group-wrap col-md-4">
						<div class="form-group">
							<div class="row no-gutters method-row">
								<div class="form-check form-check-inline custom-checkbox checkbox-greensea checkbox-circle d-flex justify-content-start col-5">
									<input class="form-check-input" type="radio" name="payment-method" id="flpaypal-method" value="P" onchange="creditCard('none')">
									<label class="form-check-label" for="flpaypal-method">
										<span>PayPal</span>
									</label>
								</div>
								
								<div class="d-flex justify-content-end img col-5">
 									<img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-100px.png" height=90% width=55% alt="PayPal Logo">
								</div>
								
								<div>
									<a class="nav-link info mt-1 ml-3" href="/en/products/<?php echo htmlspecialchars( $value["dsurl"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-info info mr-0"></i></a>
								</div>
<!--
									<img src="https://www.paypalobjects.com/webstatic/mktg/logo-center/logotipo_paypal_pagos_seguros.png" alt="Seguro con PayPal" />

<table border="0" cellpadding="10" cellspacing="0" align="center"><tbody><tr><td align="center"></td></tr><tr><td align="center"><a href="https://www.paypal.com/es/webapps/mpp/paypal-popup" title="Cómo funciona PayPal" onclick="javascript:window.open('https://www.paypal.com/es/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img src="https://www.paypalobjects.com/webstatic/mktg/logo-center/logotipo_paypal_pagos_seguros.png" border="0" alt="Seguro con PayPal" /></a><div style="text-align:center"><a href="https://www.paypal.com/es/webapps/mpp/why" target="_blank"><font size="2" face="Arial" color="#0079CD"></font></a></div></td></tr></tbody></table>

									<img  src="https://www.paypal-brasil.com.br/logocenter/util/img/compra_segura_horizontal.png" border="0" alt="Imagens de solução" />

									<img  src="https://www.paypal-brasil.com.br/logocenter/util/img/selo_aceitacao_horizontal.png" border="0" alt="Imagens de solução" />
-->
							</div>

							<div class="row no-gutters method-row">
								<div class="form-check form-check-inline custom-checkbox checkbox-greensea checkbox-circle d-flex justify-content-start col-5">
									<input class="form-check-input" type="radio" name="payment-method" id="credit-card-method" value="T" onchange="creditCard('block')">
									<label class="form-check-label" for="credit-card-method">
										<span>Credit Card</span>
									</label>
								</div>
								
								<div class="d-flex justify-content-end img col-5">
 									<img src="/assets/img/checkout/credit-card-all.png" height=91% width=79% alt="PayPal Logo">
								</div>
								
								<div>
									<a class="nav-link info mt-1 ml-3" href="/en/products/<?php echo htmlspecialchars( $value["dsurl"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-info info"></i></a>
								</div>

								<div class="form-group credit-card-method" id="credit-card-itens">
									<div class="row">
										<div class="col-12 credit-card-item">
											<label for="card-number" class="pl-0 mb-0">
												<span>Card Number*</span>
											</label>
											<input class="form-control card-number cc-number identified card-image" type="text" name="card-number" id="card-number" value="" placeholder="0000 0000 0000 0000">
										</div>

										<div class="col-6 credit-card-item">
											<label for="card-date-month" class="pl-0 mt-2 mb-0">
												<span>Expiration Date*</span>
											</label>
		
											<div class="row no-gutters">
												<div class="col-4">
													<input class="form-control date pl-1 pr-1" type="text" name="card-date-month" id="card-date-month" value="" placeholder="MM">
												</div>

												<div class="col-2 date">
													<span>/</span>
												</div>

												<div class="col-4">
													<input class="form-control date" type="text" name="card-date-year" id="card-date-year" value="" placeholder="YY">
												</div>
											</div>
										</div>

										<div class="col-4 credit-card-item cvv">
											<label for="card-cvv" class="pl-0 mt-2 mb-0">
												<span>CVV*</span>
											</label>
											<input class="form-control card-cvv" type="text" name="card-cvv" id="card-cvv" value="">
										</div>

										<div class="d-flex justify-content-end img-cvv col-2">
 											<img src="/assets/img/checkout/credit-card-cvv-24.png" height=24 width=24 alt="Credit Card Logo">
										</div>
									</div>
								</div>
							</div>

							<div class="row no-gutters method-row">
								<div class="form-check form-check-inline custom-checkbox checkbox-greensea checkbox-circle d-flex justify-content-start col-6">
									<input class="form-check-input" type="radio" name="payment-method" id="cash-method" value="H" onchange="creditCard('none')">
									<label class="form-check-label" for="cash-method">
										<span>Cash On Delivery</span>
									</label>
								</div>
							
								<div class="d-flex justify-content-end img col-4">
								</div>
								
								<div>
									<a class="nav-link info mt-1 ml-3" href="/en/products/<?php echo htmlspecialchars( $value["dsurl"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-info info"></i></a>
								</div>
							</div>

							<div class="row no-gutters">
								<div class="col-12">
										<span>Delivery:</span>
								</div>

								<div class="col-12">
										<span>Our deliveries are made within five business days.</span>
								</div>
							</div>
						</div>
						<div class="validate" id="validate">
							<span></span>
						</div>
					</div>

					<div class="col-md-4">
						<table class="table table-sm">
							<thead>
								<tr>
									<th scope="col" style="width:50%">Product</th>
									<th scope="col" class="number" style="width:50%">Subtotal</th>
								</tr>
							</thead>

							<tbody>
								<?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>
								<form action="" method="post" class="checkout-cart-form" id="checkout-cart-form<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
									<input type="text" name="idproduct" id="idproduct" value="<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" hidden/>
									<tr>
										<td class="no-border"><span><?php echo htmlspecialchars( $value1["nrquantity"], ENT_COMPAT, 'UTF-8', FALSE ); ?> x <?php echo htmlspecialchars( $value1["nmproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span></td>

										<td class="no-border number">
											<span><?php echo formatEU($value1["nrquantity"]*$value1["vlprice"]); ?> €</span>
										</td>
									</tr>
								</form>
								<?php } ?>
								<tr>
									<td><span>Subtotal</span></td>
									<td class="number">
										<span><?php echo formatEU($cart["vlsubtotal"]); ?> €</span>
									</td>
								</tr>

								<tr>
									<td><span>Shipping</span></td>
									<td class="number">
										<span><?php if( $cart["vlsubtotal"] < 50 ){ ?>5,99<?php }else{ ?>0,00<?php } ?> €</span>
									</td>
								</tr>

								<tr>
									<td><span><b>Total</b></span></td>
									<td class="number">
										<span><b><?php echo formatEU($cart["vltotal"]); ?> €</b></span>
									</td>
								</tr>
							</tbody>
						</table>

						<div class="col-12 d-flex justify-content-end checkout-button">
							<button type="button" class="btn btn-common col-12 mr-0" onclick="submitForm(this.form)">Buy Now</button>
						</div>
					</div>

					<div class="col-md-4" id="shipping-itens">
						<div class="section-header col-12 pl-0">
							<h5>Shipping Address</h5>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-6">
									<input type="text" class="form-control" id="nmfirst-shipping" name="nmfirst-shipping" placeholder="Fisrt Name" value="<?php echo htmlspecialchars( $user["nmfirst"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								</div>
								<div class="col-6">
									<input type="text" class="form-control" id="nmlast-shipping" name="nmlast-shipping" placeholder="Last Name" value="<?php echo htmlspecialchars( $user["nmlast"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-12">
									<input type="text" class="form-control" id="dsaddress-shipping" name="dsaddress-shipping" placeholder="Address" value='<?php echo utf8encode($address["dsaddress"]); ?>'>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-6">
									<input type="text" class="form-control" id="dsnumber-shipping" name="dsnumber-shipping" placeholder="Number" value="<?php echo htmlspecialchars( $address["dsnumber"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								</div>
								<div class="col-6">
									<input type="text" class="form-control" id="cdzipcode-shipping" name="cdzipcode-shipping" placeholder="Postal Code" value="<?php echo htmlspecialchars( $address["cdzipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-12">
									<input type="text" class="form-control" id="dscity-shipping" name="dscity-shipping" placeholder="City" value="<?php echo htmlspecialchars( $address["dscity"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-6">
									<input type="text" class="form-control" id="nrphone-shipping" name="nrphone-shipping" placeholder="Phone Number" value="<?php echo htmlspecialchars( $user["nrphone"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
								</div>
								<div class="col-6">
									<input type="text" class="form-control" id="dscountry-shipping" name="dscountry-shipping" placeholder="Country" value="España" disabled>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>