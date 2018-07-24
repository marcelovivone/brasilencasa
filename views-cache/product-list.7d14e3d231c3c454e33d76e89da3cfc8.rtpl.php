<?php if(!class_exists('Rain\Tpl')){exit;}?></div>

<script>
function submitForm(element, idproduct) {
	let form = '';

	form = document.getElementById(`product-social${idproduct}`);

	form.method = 'post';
	form.action = '/en/profile/wishlist/include';

	$(form).submit();
}
</script>

<!-- first section (produto)-->
<section id="service-block-main" class="wow fadeInUp section">
	<!-- Container Starts -->
	<div class="container">
		<div class="row">
			<div class="col-2 col-sm-3 col-md-2">
				<!-- Service-Block-1 Item Starts -->
				<div class="service-item wow fadeInUpQuick animated" data-wow-delay=".5s">
					<div class="icon-wrapper">
						<i class="pulse-shrink">
							<img src="/assets/img/categories/stew-64.png">
						</i>   
					</div>
				</div>
				<!-- Service-Block-1 Item Ends -->
			</div>

			<div class="d-none d-md-block col-md-2">
				<!-- Service-Block-1 Item Starts -->
				<div class="service-item wow fadeInUpQuick animated" data-wow-delay=".8s">
					<div class="icon-wrapper">
						<i class="pulse-shrink">
							<img src="/assets/img/categories/water-64.png">
						</i>   
					</div>
				</div>
				<!-- Service-Block-1 Item Ends -->
			</div>

			<div class="col-8 col-sm-6 col-md-4">
				<div class="service-item wow fadeInUpQuick animated" data-wow-delay=".8s">
					<h2 class="section-title wow fadeIn animated" data-wow-delay=".2s">
					 Products
					</h2>
				</div>
			</div>

			<div class="d-none d-md-block col-md-2">
				<!-- Service-Block-1 Item Starts -->
				<div class="service-item wow fadeInUpQuick animated" data-wow-delay="1.1s">
					<div class="icon-wrapper">
						<i class="pulse-shrink">
							<img src="/assets/img/categories/tea-64.png">
						</i>   
					</div>
				</div>
				<!-- Service-Block-1 Item Ends -->
			</div>

			<div class="col-2 col-sm-3 col-md-2">
				<!-- Service-Block-1 Item Starts -->
				<div class="service-item wow fadeInUpQuick animated" data-wow-delay="1.1s">
					<div class="icon-wrapper">
						<i class="pulse-shrink">
							<img src="/assets/img/categories/grain-64.png">
						</i>   
					</div>
				</div>
				<!-- Categories Item Ends -->
			</div>
		</div><!-- Row Ends -->
	</div><!-- Container Ends -->
</section><!-- Categories Section Ends -->

<div id="navbar-submenu">
	<section id="produto" class="wow fadeInUp">
		<form action="/en/products" class="top_search clearfix d-none d-lg-block" method="post" name="productsForm">
			<nav class="navbar navbar-expand navbar-light">
				<div class="container">
					<div class="collapse navbar-collapse navbar-toggleable-sm" id="sub-menu">
						<!-- Navbar Starts -->
						<ul class="navbar-nav nav-inline mr-auto">
							<?php $counter1=-1;  if( isset($menu['category-name']) && ( is_array($menu['category-name']) || $menu['category-name'] instanceof Traversable ) && sizeof($menu['category-name']) ) foreach( $menu['category-name'] as $key1 => $value1 ){ $counter1++; ?>
							<li class="nav-item dropdown">
						    	<div class="dropdown-item checkbox-greensea">
									<a class="nav-link dropdown-toggle no-after" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
										<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>
									</a>                    
								</div>
								<div class="dropdown-menu">
								<?php $counter2=-1;  if( isset($menu['subCategory-name']["$key1"]) && ( is_array($menu['subCategory-name']["$key1"]) || $menu['subCategory-name']["$key1"] instanceof Traversable ) && sizeof($menu['subCategory-name']["$key1"]) ) foreach( $menu['subCategory-name']["$key1"] as $key2 => $value2 ){ $counter2++; ?>
									<div class="dropdown-item custom-control custom-checkbox checkbox-greensea">
										<input class="form-check-input" type="checkbox" id=<?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?> name=<?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?> 
										value=<?php echo htmlspecialchars( $menu["category-id"]["$key1"] ."#@". $menu["subCategory-id"]["$key1"]["$key2"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <?php echo ($menu["checkbox"]["$key1"]["$key2"] === $value2 ? "checked" : ""); ?> onchange="this.form.submit()">
										<label class="form-check-label" for=<?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?>>
											<?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?>
										</label>
									</div>
								<?php } ?>
								</div>
							</li>
							<?php } ?>
							<li class="nav-item dropdown">
						    	<div class="dropdown-item checkbox-greensea">
									<a class="nav-link dropdown-toggle no-after" data-toggle="dropdown" href="/en/products" role="button" aria-haspopup="true" aria-expanded="false">
										All 
									</a>
								</div>
							</li>
						</ul>
						<ul class="navbar-nav nav-inline ml-0 ml-auto mt-lg-0">
							<li class="nav-item dropdown">
						    	<div class="dropdown-item checkbox-greensea">
									<a class="nav-link dropdown-toggle no-after" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
									Sort by
									</a>
								</div>
								<div class="dropdown-menu sort">
									<div class="dropdown-item custom-control custom-checkbox checkbox-greensea">
										<input class="form-check-input" type="radio" id="a-z" name="sort" value="AZ" <?php echo ($sort === 'AZ' ? 'checked' : ''); ?> onchange="this.form.submit()">
										<label class="form-check-label" for="a-z">
											A - Z
										</label>
									</div>
									<div class="dropdown-item custom-control custom-checkbox checkbox-greensea dropdown-item-last">
										<input class="form-check-input" type="radio" id="z-a" name="sort" value="ZA" <?php echo ($sort === 'ZA' ? 'checked' : ''); ?> onchange="this.form.submit()">
										<label class="form-check-label" for="z-a">
											Z - A
										</label>
									</div>
									<div class="dropdown-item custom-control custom-checkbox checkbox-greensea">
										<input class="form-check-input" type="radio" id="lowest-price" name="sort" value="LP" <?php echo ($sort === 'LP' ? 'checked' : ''); ?> onchange="this.form.submit()">
										<label class="form-check-label" for="lowest-price">
											Price (lowest)
										</label>
									</div>
									<div class="dropdown-item custom-control custom-checkbox checkbox-greensea dropdown-item-last">
										<input class="form-check-input" type="radio" id="highest-price" name="sort" value="HP" <?php echo ($sort === 'HP' ? 'checked' : ''); ?> onchange="this.form.submit()">
										<label class="form-check-label" for="highest-price">
											Price (highest)
										</label>
									</div>
									<div class="dropdown-item custom-control custom-checkbox checkbox-greensea">
										<input class="form-check-input" type="radio" id="best-seller" name="sort" value="BS" <?php echo ($sort === 'BS' ? 'checked' : ''); ?> onchange="this.form.submit()">
										<label class="form-check-label" for="best-seller">
											Best Seller
										</label>
									</div>
									<div class="dropdown-item custom-control custom-checkbox checkbox-greensea dropdown-item-last">
										<input class="form-check-input" type="radio" id="less-sold" name="sort" value="LS" <?php echo ($sort === 'LS' ? 'checked' : ''); ?> onchange="this.form.submit()">
										<label class="form-check-label" for="less-sold">
											Less Sold
										</label>
									</div>
								</div>                   
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</form>
	</section>
</div>

<div class="noJumpVScroll">
	<section id="product" class="wow fadeInUp" style="background: white;">
		<div class="container">
			<div class="row">
				<?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>
				<div class="col-sm-6 col-md-3">
					<div class="product-item wow fadeInUpQuick" data-wow-delay="1s">
						<figure class="product-profile">
							<a><img alt="$value.idproduct" src="/assets/img/products/product<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>.jpg"></a>
							<figcaption class="our-product">
								<form id="product-social<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
	 								<div class="d-flex justify-content-center social">
										<input name="idproduct" value="<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" style="display: none">
										<input name="nrquantity" value="1" style="display: none">
	 									<a class="nav-link" href="/en/checkout/cart"><i class="fa fa-shopping-cart cart"></i></a>
										<a class="nav-link" href="javascript:void(0);" id="wishlist" onclick="submitForm(this, <?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>);"><i class="fa fa-heart wishlist"></i></a>
	 									<a class="nav-link" href="/en/products/<?php echo htmlspecialchars( $value1["dsurl"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-info info"></i></a>
 									</div>
								</form>
							</figcaption>
						</figure>

						<div class="info-name">
							<h3 class="mb-0 pb-0">
								<?php echo htmlspecialchars( $value1["nmproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>
							</h3>
							<p class="pb-1">
								<?php echo formatEU($value1["vlprice"]); ?> € 
							</p>
						</div>

						<div class="info-detail">
							<div class="orange-line	"></div>
							<p class="pb-1">
								<?php echo htmlspecialchars( $value1["dsproductred"], ENT_COMPAT, 'UTF-8', FALSE ); ?>
							</p>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<!-- Row Ends -->
		</div>
	</section>
</div>