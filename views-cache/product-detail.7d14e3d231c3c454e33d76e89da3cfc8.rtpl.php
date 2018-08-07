<?php if(!class_exists('Rain\Tpl')){exit;}?><script>
function onClick(star) {

	for (i=star+1; i<=5; i++) {
		document.getElementById('rating-'+i).style.color = "#50d8af";
	}

	for (i=1; i<=star; i++) {
		document.getElementById('rating-'+i).style.color = "#0c2e8a";
	}

	document.getElementById('rating').value = star;
}

function submitFormLink() {
	let form = '';
	form = document.getElementById('product-detail-link');

	form.method = 'post';
	form.action = '/en/profile/wishlist/include';

	$(form).submit();
}

function setQuantity(button) {
	let val = Number(document.getElementById('nrquantity').value);

	if (button === 'M') {

		if (val === 1) {
			alert('Value must be 1 or greater.');
		} else {
			document.getElementById('nrquantity').value = val - 1 ;
		}

	} else {
		document.getElementById('nrquantity').value = val + 1 ;
	}
}

function submitFormAddCart() {
	let form = '';
	form = document.getElementById('product-detail-addcart');

	form.method = 'post';
	form.action = '/en/checkout/cart/include';

	$(form).submit();
}
</script>
<section id="product-detail" class="wow fadeInUp">
	<div class="container">
		<div class="row">
			<div class="col-sm-10">
				<div class="row">
					<div class="col-sm-6">
						<div class="product-item wow fadeInUpQuick" data-wow-delay="1s">
							<figure>
								<a><img src="<?php echo htmlspecialchars( $product["dsphoto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"></a>
								<figcaption>
								  <form id="product-detail-link" method="post">
										<input name="idproduct" value="<?php echo htmlspecialchars( $product["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" style="display: none"/>
										<div class="d-flex justify-content-center social">
											<a class="nav-link" href="javascript:void(0);" onclick="submitFormAddCart()"><i class="fa fa-shopping-cart cart"></i></a>
											<a class="nav-link" href="javascript:void(0);" id="wishlist" onclick="submitFormLink();"><i class="fa fa-heart wishlist"></i></a>
											<input name="nrquantity" value="1" style="display: none">
											<a class="nav-link" href="/en/recipes/<?php echo htmlspecialchars( $product["dsurl"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-receipt recipe"></i></a>
										</div>
									</form>
								</figcaption>
							</figure>
						</div>
					</div>
					
					<div class="group-wrap col-sm-6">
						<div class="product-inner">
							<div class="section-header">
								<h2 class="product-name"><?php echo htmlspecialchars( $product["nmproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h2>
							</div>
							<div class="product-inner-price">
								<?php echo formatEU($product["vlprice"]); ?> €
							</div>
		<!--		  
							<form action="/cart/<?php echo htmlspecialchars( $product["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/plus" class="cart">
								<div class="quantity">
									<input type="number" size="4" class="input-text qty text" title="Qty" value="1" name="qtd" min="1" step="1">
								</div>

								<button class="add_to_cart_button" type="submit">Add to cart</button>
							</form>   
		-->

							<div class="product-availability">
								<p class="pb-0 mb-0"><span class="subtitle">Availability:</span>
								<?php if( $product["qtstock"]==0 ){ ?><span class="product-unavailable mb-3">Unavailable</span><?php }else{ ?><span class="product-available">In Stock</span><?php } ?></p>
							</div>

							<div class="product-reduced-description">
								<p class="pb-0 mb-0">
									<span class="subtitle">Details:</span>
									<span class="product-reduced"><?php echo htmlspecialchars( $product["dsproductred"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
								</p>
							</div>
<!--
							<div class="product-extended-description">
								<p class="subtitle pb-2 mb-0">Description</p>
								<p class="pb-0 mb-0"><?php echo htmlspecialchars( $product["dsproductext"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
							</div>
-->
							<div class="product-category">
								<p class="pb-2 mb-0">
									<span class="subtitle">Categories:</span>
									<?php $counter1=-1;  if( isset($categories) && ( is_array($categories) || $categories instanceof Traversable ) && sizeof($categories) ) foreach( $categories as $key1 => $value1 ){ $counter1++; ?>

									<a href="/en/categories/<?php echo htmlspecialchars( $value1["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["nmcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
									<?php } ?>

								</p>
							</div> 

		<!--
							<div class="product-availability">
								<p class="subtitle pb-2 mb-0">Availability</p>
								<?php if( $product["qtstock"]==0 ){ ?><p class="product-unavailable mb-3">Unavailable</p><?php }else{ ?><p class="product-available mb-3">In Stock</p><?php } ?>

							</div>

							<div class="product-reduced-description">
								<p class="subtitle pb-2 mb-0">Details</p>
								<p class="mb-3"><?php echo htmlspecialchars( $product["dsproductred"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
							</div>

							<div class="product-extended-description">
								<p class="subtitle pb-2 mb-0">Description</p>
								<p><?php echo htmlspecialchars( $product["dsproductext"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
							</div>
		-->
						</div>
					</div>
				</div>

				<div class="container py-3">
					<div class="row">
						<div class="col-12 mx-auto">
							<ul class="nav nav-tabs small justify-content-start" role="tablist">
								<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab1" role="tab">Description</a></li>
								<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab2" role="tab">History</a></li>
								<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab3" role="tab">Avaliation</a></li>
								<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab4" role="tab">Recipes</a></li>
							</ul>

							<div class="tab-content py-4">
								<div class="tab-pane active" id="tab1" role="tabpanel">
									<p><?php echo htmlspecialchars( $product["dsproductext"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
								</div>

								<div class="tab-pane" id="tab2" role="tabpanel">
									<p><?php echo htmlspecialchars( $product["dshistory"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
								</div>

								<div class="tab-pane" id="tab3" role="tabpanel">
									<h5>Your Review</h5>
									<form action="/en/products/review/save" method="post">
										<input name="idproduct" value="<?php echo htmlspecialchars( $product["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" style="display: none"/>
										<div class="form-group">
											<div class="row pt-0">
												<div class="col-12">
													<input type="text" class="form-control" id="name" name="name" placeholder="Name" value='' <?php if( '0'=='1' ){ ?>disabled<?php } ?>>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-12">
													<input type="text" class="form-control" id="email" name="email" placeholder="Email Address" value="" <?php if( '0'=='1' ){ ?>disabled<?php } ?>>
												</div>
											</div>
										</div>

										<div class="form-group">
											<div class="row">
												<div class="col-12">
													<input name="rating" id="rating" value="0" style="display: none"/>
													<span>Rating</span>
													<i class="fa fa-star" id="rating-1" onclick="onClick(1)"></i>
													<i class="fa fa-star" id="rating-2" onclick="onClick(2)"></i>
													<i class="fa fa-star" id="rating-3" onclick="onClick(3)"></i>
													<i class="fa fa-star" id="rating-4" onclick="onClick(4)"></i>
													<i class="fa fa-star" id="rating-5" onclick="onClick(5)"></i>
												</div>
											</div>
										</div>
										
										<div class="form-group">
											<div class="row">
												<div class="col-12">
													<textarea name="review" id="review" class="form-control" placeholder="Review"></textarea>
												</div>
											</div>
										</div>

										<div class="col-12 d-flex justify-content-center">
											<button type="submit" class="btn btn-common col-2">Save</button>
										</div>
									</form>

									<h5>All Reviews</h5>
									<p>There is no review for <?php echo htmlspecialchars( $product["nmproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
								</div>

								<div class="tab-pane" id="tab4" role="tabpanel">
									<?php $counter1=-1;  if( isset($recipes) && ( is_array($recipes) || $recipes instanceof Traversable ) && sizeof($recipes) ) foreach( $recipes as $key1 => $value1 ){ $counter1++; ?>

									<h5 class='<?php if( $counter1>0 ){ ?>mt-4<?php } ?>'><?php echo htmlspecialchars( $value1["nmrecipe"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h5>
									<p class="mb-3">Ingredients: <?php echo htmlspecialchars( $value1["dsingredient"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
									<p>Recipe: <?php echo htmlspecialchars( $value1["dsrecipe"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
									<?php }else{ ?>

									<p>There is no recipe for <?php echo htmlspecialchars( $product["nmproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
									<?php } ?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-2">
				<p><u>Quantity to buy:</u></p>
				  <form id="product-detail-addcart" method="post">
					<input name="idproduct" value="<?php echo htmlspecialchars( $product["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" style="display: none"/>
					<div class="count-input space-bottom d-flex justify-content-center">
						<button type="button" class="btn incr-btn col-1" onclick="setQuantity('M');">&minus;</button>
						<input class="quantity" type="number" name="nrquantity" id="nrquantity" value="1"/>
						<button type="button" class="btn incr-btn col-1" onclick="setQuantity('P');">&plus;</button>
					</div>

					<div class="col-12 d-flex justify-content-center mt-2">
						<button type="button"class="btn btn-common" onclick="submitFormAddCart()">Add to Cart</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>