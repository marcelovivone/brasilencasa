<?php if(!class_exists('Rain\Tpl')){exit;}?><script>
function displayAddress() {
	let el = document.getElementById('shipping-itens');

	if (el.style.display === 'none' || el.style.display === '') {
		el.style.display = 'block';
	} else {
		el.style.display = 'none';
    }

    document.getElementById('difAddresshidden').checked = document.getElementById('difAddress').checked;
}

function Payment(creditCardDisplay, paymentButtonDisplay) {
	// Credit card fields
	let el = document.getElementById('credit-card-itens');
	el.style.display = creditCardDisplay;

	// If it's credit card adjusts shipping position
	el = document.getElementById('shipping-itens');
	if (creditCardDisplay === 'block') {
		el.style.marginTop = "-46px";
	} else {
		el.style.marginTop = "-25px";
	}

	// Payment buttons (general and paypal)
	el = document.getElementById('general-button');
	el.style.display = (paymentButtonDisplay === 'block' ? 'none' : 'block');
	el = document.getElementById('paypal-button');
	el.style.display = paymentButtonDisplay;

	// If payment method validation message was visible
	el = document.getElementById('validate');
	el.style.display = 'none';
}

function submitForm() {

	// user must choose one payment method
	if (!document.querySelector('input[name="payment-method"]:checked')) {
		alert('Please, choose one payment method.')		
		event.preventDefault();
		return
	}

	let form = document.getElementById('checkout-billing-address-form');
	if (!validateForm(form, false, '', '', 'en', true)) {
		event.preventDefault();
		return
	}

	form = document.getElementById('checkout-shipping-address-form');
	if (!validateForm(form, false, '', '', 'en', true)) {
		event.preventDefault();
		return
	}

	form = document.getElementById('checkout-creditcard-form');
	if (!validateForm(form, false, '', '', 'en', true)) {
		event.preventDefault();
		return
	}

/*
	form.method = "post";
	form.action = "/en/checkout/save";
	$(form).submit();
*/
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
					<form action="" method="post" id="checkout-billing-address-form">
						<div class="row no-gutters">
							<div class="form-group col-12 input-group">
								<div class="row no-gutters input-group">
									<div class="col-6 labelled-div-input first-column">
										<input type="text" class="form-control labelled-input" id="nmfirst-billing" name="nmfirst-billing" value="<?php echo htmlspecialchars( $user["nmfirst"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" maxlength="30">
										<label for="nmfirst-billing">First Name*</label>
									</div>
							
									<div class="col-6 labelled-div-input second-column">
										<input type="text" class="form-control labelled-input" id="nmlast-billing" name="nmlast-billing" value="<?php echo htmlspecialchars( $user["nmlast"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" maxlength="90">
										<label for="nmlast-billing">Last Name*</label>
									</div>
								</div>
							</div>

							<div class="form-group input-group">
								<div class="row no-gutters input-group">
									<div class="col-12 labelled-div-input">
										<input type="text" class="form-control labelled-input" id="dsaddress-billing" name="dsaddress-billing" value='<?php echo utf8encode($addressBilling["dsaddress"]); ?>' maxlength="128">
										<label for="dsaddress-billing">Address*</label>
									</div>
								</div>
							</div>

							<div class="form-group input-group">
								<div class="row no-gutters input-group">
									<div class="col-6 labelled-div-input first-column">
										<input type="text" class="form-control labelled-input" id="dsnumber-billing" name="dsnumber-billing"  value="<?php echo htmlspecialchars( $addressBilling["dsnumber"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" maxlength="6">
										<label for="dsnumber-billing">Number*</label>
									</div>

									<div class="col-6 labelled-div-input second-column">
										<input type="text" class="form-control labelled-input" id="cdzipcode-billing" name="cdzipcode-billing" value="<?php echo htmlspecialchars( $addressBilling["cdzipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" maxlength="5">
										<label for="cdzipcode-billing">Postal Code*</label>
									</div>
								</div>
							</div>

							<div class="form-group input-group">
								<div class="row no-gutters input-group">
									<div class="col-12 labelled-div-input">
										<input type="text" class="form-control labelled-input" id="dscity-billing" name="dscity-billing" value="<?php echo htmlspecialchars( $addressBilling["dscity"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" maxlength="32">
										<label for="dscity-billing">City*</label>
									</div>
								</div>
							</div>

							<div class="form-group input-group">
								<div class="row no-gutters input-group">
									<div class="col-6 labelled-div-input first-column">
										<input type="text" class="form-control labelled-input" id="nrphone-billing" name="nrphone-billing" value="<?php echo htmlspecialchars( $user["nrphone"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" maxlength="15">
										<label for="nrphone-billing" name='id'>Phone*</label>
									</div>

									<div class="col-6 labelled-div-input second-column disabled">
										<input type="text" class="form-control labelled-input" id="dscountry-billing" name="dscountry-billing" value="España" maxlength="32" disabled>
										<label for="dscountry-billing" class="disabled">Country*</label>
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
					</form>
				</div>
				
				<div class="group-wrap col-md-4">
					<div class="form-group">
						<div class="row no-gutters method-row">
							<div class="form-check form-check-inline custom-checkbox checkbox-greensea checkbox-circle d-flex justify-content-start col-5">
								<input class="form-check-input" type="radio" name="payment-method" id="flpaypal-method" value="P" onchange="Payment('none', 'block')">
								<label class="form-check-label" for="flpaypal-method">
									<span>PayPal</span>
								</label>
							</div>
							
							<div class="d-flex justify-content-end img col-5">
									<img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-100px.png" height="4%" width="55%" alt="PayPal Logo">
							</div>
							
							<div>
								<a class="nav-link info mt-1 ml-3" href="javascript:void(0)"><i class="fa fa-info info mr-0" data-toggle="modal" data-target="#payPalModal"></i></a>
							</div>

							<!-- PayPal Modal -->
							<div class="modal fade" id="payPalModal" tabindex="-1" role="dialog" aria-labelledby="payPalModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="payPalModalLabel">Payment by PayPal</h5>
										
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>

										<div class="modal-body">
											<span>When you choose to pay by PayPal, a Pop-Up will open on this page. You can log in directly with your PayPal user data and then confirm the payment. PayPal handles the process of debiting the amount from your account, and we ship your products immediately.</span>
										</div>

										<div class="modal-footer">
											<button type="button" class="btn btn-common" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
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
								<input class="form-check-input" type="radio" name="payment-method" id="credit-card-method" value="T" onchange="Payment('block', 'none')">
								<label class="form-check-label" for="credit-card-method">
									<span>Credit Card</span>
								</label>
							</div>
							
							<div class="d-flex justify-content-end img col-5">
									<img src="/assets/img/checkout/credit-card-all.png" height="4%" width="79%" alt="PayPal Logo">
							</div>
							
							<div>
								<a class="nav-link info mt-1 ml-3" href="javascript:void(0)"><i class="fa fa-info info mr-0" data-toggle="modal" data-target="#creditCardModal"></i></a>
							</div>

							<!-- PayPal Modal -->
							<div class="modal fade" id="creditCardModal" tabindex="-1" role="dialog" aria-labelledby="creditCardModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="creditCardModalLabel">Payment by Credit Card</h5>
										
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>

										<div class="modal-body">
											<span>Shopping with us and paying by credit card is simple and secure. We accept Visa and Mastercard.
											<br/>
											Your credit card data is encrypted and transmitted using the SSL process. This method guarantees maximum security for payments. We ship your products immediately.</span>
										</div>

										<div class="modal-footer">
											<button type="button" class="btn btn-common" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</div>

							<form action="" class="mb-0" method="post" id="checkout-creditcard-form">
								<div class="form-group credit-card-method" id="credit-card-itens">
									<div class="card-js" data-icon-colour="#50d8af">
										<input class="form-control card-number my-custom-class" name="card-number">
										<input class="form-control name" id="the-card-name-id" name="card-holders-name" placeholder="Name on card">
										<input class="form-control expiry-month" name="expiry-month">
										<input class="form-control expiry-year" name="expiry-year">
										<input class="form-control cvc" name="cvc">
									</div>
								</div>
							</form>
<!--
							<div class="form-group credit-card-method" id="credit-card-itens">
								<div class="row">
									<div class="col-12 credit-card-item">
										<label for="card-number" class="pl-0 mb-0">
											<span>Card Number*</span>
										</label>
										<input class="form-control card-number cc-number identified card-image" type="text" name="card-number" id="card-number" value="" placeholder="0000 0000 0000 0000"/>
									</div>

									<div class="col-6 credit-card-item">
										<label for="card-date-month" class="pl-0 mt-2 mb-0">
											<span>Expiration Date*</span>
										</label>
	
										<div class="row no-gutters">
											<div class="col-4">
												<input class="form-control center-align pl-1 pr-1" type="text" name="card-date-month" id="card-date-month" value="" placeholder="MM" maxlength="2">
											</div>

											<div class="col-2 center-align">
												<span>/</span>
											</div>

											<div class="col-4">
												<input class="form-control center-align" type="text" name="card-date-year" id="card-date-year" value="" placeholder="YY" maxlength="2">
											</div>
										</div>
									</div>

									<div class="col-4 credit-card-item cvv">
										<label for="card-cvv" class="pl-0 mt-2 mb-0">
											<span>CVV*</span>
										</label>
										<input class="form-control card-cvv" type="text" name="card-cvv" id="card-cvv" value="" maxlength="4">
									</div>

									<div class="d-flex justify-content-end img-cvv col-2">
											<img src="/assets/img/checkout/credit-card-cvv-24.png" height=24 width=24 alt="Credit Card Logo">
									</div>
								</div>
							</div>
-->
						</div>

						<div class="row no-gutters method-row">
							<div class="form-check form-check-inline custom-checkbox checkbox-greensea checkbox-circle d-flex justify-content-start col-6">
								<input class="form-check-input" type="radio" name="payment-method" id="cash-method" value="H" onchange="Payment('none', 'none')">
								<label class="form-check-label" for="cash-method">
									<span>Cash On Delivery</span>
								</label>
							</div>
						
							<div class="d-flex justify-content-end img col-4" style="height: 20px">
									<img src="/assets/img/checkout/euro.jpg" height=100% width=44% alt="Euro Logo">
							</div>
							
							<div>
								<a class="nav-link info mt-1 ml-3" href="javascript:void(0)"><i class="fa fa-info info mr-0" data-toggle="modal" data-target="#cashModal"></i></a>
							</div>

							<!-- PayPal Modal -->
							<div class="modal fade" id="cashModal" tabindex="-1" role="dialog" aria-labelledby="cashModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="cashModalLabel">Cash on Delivery</h5>
										
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>

										<div class="modal-body">
											<span>Brasil en Casa allows a collect on delivery service. You can only pay in cash, and the exact amount must be provided, because the delivery assistants cannot carry change with them due to safety reasons.</span>
										</div>

										<div class="modal-footer">
											<button type="button" class="btn btn-common" data-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
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
							<input type="text" name="idproduct" id="idproduct" value="<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" hidden/>
							<tr>
								<td class="no-border"><span><?php echo htmlspecialchars( $value1["nrquantity"], ENT_COMPAT, 'UTF-8', FALSE ); ?> x <?php echo htmlspecialchars( $value1["nmproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span></td>

								<td class="no-border number">
									<span><?php echo formatEU($value1["nrquantity"]*$value1["vlprice"]); ?> €</span>
								</td>
							</tr>
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

					<div class="col-12 d-flex justify-content-center checkout-buttons">
						<button type="button" class="btn btn-common col-12 mt-2 mr-0" id="general-button" onclick="submitForm()">Buy Now</button>

						<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="938B7KQRXTYH8">
							<input type="image" src="https://www.sandbox.paypal.com/es_ES/ES/i/btn/btn_buynowCC_LG.gif" id="paypal-button" border="0" name="submit" alt="PayPal, la forma rápida y segura de pagar en Internet.">
							<img alt="" border="0" src="https://www.sandbox.paypal.com/es_ES/i/scr/pixel.gif" width="1" height="1">
						</form>

<!--
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<form action="/en/checkout/paypal" method="post" target="_top">
							<input type="hidden" name="cmd" value="_s-xclick">
							<input type="hidden" name="hosted_button_id" value="MR7DP8L52MUJY">
							<input type="image" src="https://www.paypalobjects.com/en_US/ES/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" id="paypal-button">
							<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">

							<input type="text" name="summary" id="summary" value="Purchase" hidden/>
							<input type="text" name="total" id="total" value="<?php echo htmlspecialchars( $cart["vltotal"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" hidden/>		
						</form>
-->

					</div>
				</div>
				
				<div class="col-md-4" id="shipping-itens">
					<div class="section-header col-6 pl-0">
						<h5>Shipping Address</h5>
					</div>

					<form action="" method="post" id="checkout-shipping-address-form">
						<input class="form-check-input" type="checkbox" name="difAddresshidden" id="difAddresshidden" value="N" hidden>
						<div class="row no-gutters">
							<div class="form-group col-12 input-group">
								<div class="row no-gutters input-group">
									<div class="col-6 labelled-div-input first-column">
										<input type="text" class="form-control labelled-input" id="nmfirst-shipping" name="nmfirst-shipping" value="<?php echo htmlspecialchars( $user["nmfirst"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" maxlength="30">
										<label for="nmfirst-shipping">First Name*</label>
									</div>
					
									<div class="col-6 labelled-div-input second-column">
										<input type="text" class="form-control labelled-input" id="nmlast-shipping" name="nmlast-shipping" value="<?php echo htmlspecialchars( $user["nmlast"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" maxlength="90">
										<label for="nmlast-shipping">Last Name*</label>
									</div>
								</div>
							</div>

							<div class="form-group input-group">
								<div class="row no-gutters input-group">
									<div class="col-12 labelled-div-input">
										<input type="text" class="form-control labelled-input" id="dsaddress-shipping" name="dsaddress-shipping" value='<?php echo utf8encode($addressShipping["dsaddress"]); ?>' maxlength="128">
										<label for="dsaddress-shipping">Address*</label>
									</div>
								</div>
							</div>

							<div class="form-group input-group">
								<div class="row no-gutters input-group">
									<div class="col-6 labelled-div-input first-column">
										<input type="text" class="form-control labelled-input" id="dsnumber-shipping" name="dsnumber-shipping"  value="<?php echo htmlspecialchars( $addressShipping["dsnumber"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" maxlength="6">
										<label for="dsnumber-shipping">Number*</label>
									</div>
									<div class="col-6 labelled-div-input second-column">
										<input type="text" class="form-control labelled-input" id="cdzipcode-shipping" name="cdzipcode-shipping" value="<?php echo htmlspecialchars( $addressShipping["cdzipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" maxlength="5">
										<label for="cdzipcode-shipping">Postal Code*</label>
									</div>
								</div>
							</div>

							<div class="form-group input-group">
								<div class="row no-gutters input-group">
									<div class="col-12 labelled-div-input">
										<input type="text" class="form-control labelled-input" id="dscity-shipping" name="dscity-shipping" value="<?php echo htmlspecialchars( $addressShipping["dscity"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" maxlength="32">
										<label for="dscity-shipping">City*</label>
									</div>
								</div>
							</div>

							<div class="form-group input-group">
								<div class="row no-gutters input-group">
									<div class="col-6 labelled-div-input first-column">
										<input type="text" class="form-control labelled-input" id="nrphone-shipping" name="nrphone-shipping" value="<?php echo htmlspecialchars( $user["nrphone"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" maxlength="15">
										<label for="nrphone-shipping">Phone*</label>
									</div>
									<div class="col-6 labelled-div-input second-column disabled">
										<input type="text" class="form-control labelled-input" id="dscountry-shipping" name="dscountry-shipping" value="España" maxlength="32" disabled>
										<label for="dscountry-shipping" class="disabled">Country*</label>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>