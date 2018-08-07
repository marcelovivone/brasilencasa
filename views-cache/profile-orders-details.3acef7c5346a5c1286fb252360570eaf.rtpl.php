<?php if(!class_exists('Rain\Tpl')){exit;}?><style>
@media screen {
	.print-title {
		display: none;
	}
}

@media print {
	header,
	.screen,
	.menu,
	#payment,
	footer {
		display:none!important;
	}

	.print-title {
		display: block;
		padding-top: 60px;
	}

	.field {
		width: 100%!important;
		margin: 0 auto;
		margin-top: 20px;
	}
}
</style>

<section id="profile-orders-details" class="wow fadeInUp">
	<div class="container">
		<div class="row">
			<div class="section-header col-12 screen">
				<h2>Your Account</h2>
			</div>

			<div class="section-header col-12 print-title">
				<h2>Brasil en Casa</h2>
				<h4>Order #<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?> - Details</h4>
			</div>

			<div class="col-md-3 menu">
				<?php require $this->checkTemplate("profile-menu");?>

			</div>

			<div class="col-md-9 field">
					<table class="table ">
						<thead>
							<tr>
								<th scope="col">Product</th>
								<th scope="col" class="number">Price</th>
								<th scope="col" class="number">Quantity</th>
								<th scope="col" class="number">Total</th>
							</tr>
						</thead>
						<tbody>
							<?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>

							<tr>
								<td>
									<span><?php echo htmlspecialchars( $value1["nmproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
								</td>
								<td class="number">
									<span><?php echo formatEU($value1["vlprice"]); ?> €</span>
								</td>
								<td class="number">
									<span><?php echo htmlspecialchars( $value1["nrquantity"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
								</td>
								<td class="number">
									<span><?php echo formatEU($value1["vlprice"] * $value1["nrquantity"]); ?> €</span>
								</td>
							</tr>
							<?php } ?>

						</tbody>
						<tfoot>
							<tr>
								<th><span>Total before Shipping & Handling</span></th>
								<td></td>
								<td class="number"><span><?php echo htmlspecialchars( $cart["nrsubtotalquantity"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span></td>
								<td class="number"><span><?php echo formatEU($cart["vlsubtotal"]); ?> €</span></td>
							</tr>
							<tr>
								<th><span>Shipping & Handling</span></th>
								<td></td>
								<td></td>
								<td class="number">
									<span><?php echo formatEU($cart["vlfreight"]); ?> €</span>
									<input type="hidden" class="shipping_method" value="free_shipping" id="shipping_method_0" data-index="0" name="shipping_method[0]">
								</td>
							</tr>
							<tr class="order-total">
								<th><span>Total for This Order</span></th>
								<td></td>
								<td></td>
								<td class="number"><strong><span class="amount"><?php echo formatEU($cart["vltotal"]); ?> €</span></strong></td>
							</tr>
						</tfoot>
					</table>
					<div id="payment">
						<div class="form-row place-order">
							<div class="col-12 d-flex justify-content-center">
								<input type="submit" value="Print" class="btn btn-common col-3" onclick="window.print()">
							</div>
						</div>
					</div>

			</div>
		</div>
	</div>
</section>