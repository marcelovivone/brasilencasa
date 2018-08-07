<?php if(!class_exists('Rain\Tpl')){exit;}?><script>
function submitForm(element, idwishlist) {
	let form = '';
	form = document.getElementById(`profile-wishlist-form${idwishlist}`);

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
	form.action = '/en/profile/wishlist/input';

	$(form).submit();
}

function addCart(element, idwishlist) {
	let form = '';
	form = document.getElementById(`profile-wishlist-form${idwishlist}`);
	form.method = 'post';
	form.action = '/en/checkout/cart/input';

	$(form).submit();
}
</script>

<section id="profile-wishlist" class="wow fadeInUp">
	<div class="container">
		<div class="row">
			<div class="section-header col-12">
				<h2>Your Account</h2>
			</div>

			<div class="col-md-3 profile-menu">
				<?php require $this->checkTemplate("profile-menu");?>

			</div>
             
			<div class="col-md-9 profile-field">
				<?php $counter1=-1;  if( isset($wishlist) && ( is_array($wishlist) || $wishlist instanceof Traversable ) && sizeof($wishlist) ) foreach( $wishlist as $key1 => $value1 ){ $counter1++; ?>

				<table class="table">
					<?php if( $counter1==0 ){ ?>

					<thead>
						<tr>
							<th scope="col" style="width:20%">Product</th>
							<th scope="col" style="width:45%">Details</th>
							<th scope="col" class="number" style="width:20%">QTY</th>
							<th scope="col" class="number" style="width:15%">Value</th>
						</tr>
					</thead>
					<?php } ?>


					<form action="" method="post" class="profile-wishlist-form" id="profile-wishlist-form<?php echo htmlspecialchars( $value1["idwishlist"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						<input type="text" name="idwishlist" id="idwishlist" value="<?php echo htmlspecialchars( $value1["idwishlist"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" hidden/>
						<input type="text" name="idproduct" id="idproduct" value="<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" hidden/>
						<tbody>
							<tr>
								<th scope="row" style="width:20%">
									<div class="product-item wow fadeInUpQuick" data-wow-delay="1s">
										<figure class="m-0 p-0">
											<a><img alt="<?php echo htmlspecialchars( $value1["nmproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" src="/assets/img/products/product<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>.jpg"></a>
											<figcaption>
		        								<div class="d-flex justify-content-center social">
		        									<a class="nav-link" href="javascript:void(0);" onclick="addCart(this, <?php echo htmlspecialchars( $value1["idwishlist"], ENT_COMPAT, 'UTF-8', FALSE ); ?>);"><i class="fa fa-shopping-cart cart"></i></a>
		        									<a class="nav-link" href="/en/products/<?php echo htmlspecialchars( $value1["dsurl"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-info info"></i></a>
		        									<a class="nav-link" href="javascript:void(0);" name="delete-link" onclick="submitForm(this, <?php echo htmlspecialchars( $value1["idwishlist"], ENT_COMPAT, 'UTF-8', FALSE ); ?>);"><i class="fa fa-trash trash"></i></a>
		        								</div>
											</figcaption>
										</figure>
									</div>
								</th>
								<td style="width:45%"><?php echo htmlspecialchars( $value1["nmproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?><br/><?php echo htmlspecialchars( $value1["dsproductext"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
								<td class="number" style="width:20%">
									<div class="count-input space-bottom">
										<button type="submit" class="btn incr-btn col-1" formaction="/en/profile/wishlist/minus">&minus;</button>
										<input class="quantity" type="number" name="nrquantity" id="nrquantity" value="<?php echo htmlspecialchars( $value1["nrquantity"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" onblur="submitForm(this, <?php echo htmlspecialchars( $value1["idwishlist"], ENT_COMPAT, 'UTF-8', FALSE ); ?>);"/>
										<button type="submit" class="btn incr-btn col-1" formaction="/en/profile/wishlist/plus">&plus;</button>
									</div>
								</td>
								<td class="number" style="width:15%"><?php echo formatEU($value1["nrquantity"]*$value1["vlprice"]); ?> €</td>
							</tr>
						</tbody>
					</form>
				</table>
				<?php }else{ ?>

				<div id="success-message">
					No products in wishlist.
				</div>
				<?php } ?>

			</div>
		</div>
	</div>
</section>