<?php if(!class_exists('Rain\Tpl')){exit;}?><script>
function submitHeaderForm(form) {
	form.method = 'post';

	let searchString = document.getElementById('top_search').value;
	if (searchString === '') {
		form.action = '/en/products';
	} else {
		form.action = `/en/products/catalogsearch/${searchString}`;
	}

	$(form).submit();
}

function keyPress(form, value) {

	if (event.keyCode === 13) {
		if (value !== '') {
			submitHeaderForm(form);
		}
		event.preventDefault();
	}
}

function keyUp(value) {

//	if (value.length <= 2) { 
	if (value.length === 0) { 
		document.getElementById("livesearchdropdown").style.display = 'none';
		document.getElementById("livesearch").style.display = 'none';
		document.getElementById("livesearch").innerHTML = '';
		return;
	}

 	// AJAX is called.
	$.ajax({
		type: "POST",
		url: `/en/products/livesearch/${value}`,
 		data: {
			search: value,
			language: 'EN'
		},
 
		// If result found
		success: function(html) {

			if (html === '') {
				document.getElementById("livesearchdropdown").style.display = 'none';
				document.getElementById("livesearch").style.display = 'none';
				document.getElementById("livesearch").innerHTML = '';
			} else {
				document.getElementById("livesearch").innerHTML = html;
				document.getElementById("livesearch").style.display = 'block';
				document.getElementById("livesearchdropdown").style.display = 'block';
			}
 		}

	});
}

function submitSearchForm() {
	let form = document.getElementById('formHeader');
	let el = document.getElementById('top_search');

	form.method = 'post';
	form.action = `/en/products/catalogsearch/${el.value}`;

	$(form).submit();
}
</script>

<!-- DOCTYPE -->
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<!-- Viewport Meta Tag -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			Brasil en Casa
		</title>

		<!-- Google Font -->
		<link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Condensed" rel="stylesheet">

		<!-- Bootstrap -->
		<link href="/vendor/twbs/bootstrap/dist/css/bootstrap.css" rel="stylesheet"/>
		
		<!-- Main Style -->
		<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
		<!-- Responsive Style -->
		<link rel="stylesheet" type="text/css" href="/assets/css/responsive.css">
		<!--Fonts-->
		
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<!--
		<link rel="stylesheet" href="/assets/css/fontawesome/fontawesome.5.1.1.css">
-->
		<link rel="stylesheet" media="screen" href="/assets/fonts/simple-line-icons.css">    
		 
		<!-- Extras -->
		<link rel="stylesheet" type="text/css" href="/assets/extras/owl/owl.carousel.css">
		<link rel="stylesheet" type="text/css" href="/assets/extras/owl/owl.theme.default.css">
		<link rel="stylesheet" type="text/css" href="/assets/extras/animate.css">
		<link rel="stylesheet" type="text/css" href="/assets/extras/normalize.css">
		<link rel="stylesheet" type="text/css" href="/assets/extras/settings.css">

		<!-- Credit Card Validator -->
		<link rel="stylesheet" type="text/css" href="/assets/css/card-js.min.css">

		<!-- Color CSS Styles -->
		<link rel="stylesheet" type="text/css" href="/assets/css/colors/greensea.css" media="screen" />       
	</head>

	<body>
		<!-- Heder - Start  -->
		<!-- Roof - Start -->
		<section id="roof" class="roof-content">
			<!-- Navbar - Start -->
			<nav class="navbar navbar-expand navbar-light">
				<div class="container-fluid">
					<div class="navbar-nav roof-menu" id="roof-menu">
						<!-- Navbar - Start -->
						<ul class="navbar-nav mr-auto">
							<li class="nav-item">
								<a class="nav-link" href='<?php echo substring($route,0,3); ?>/contact' style="text-transform: lowercase !important;"><i class="fa fa-envelope"></i> <span class="roof-description">contact@brasilencasa.com</span></a>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-globe"></i>
									<span class="roof-description">English</span>
								</a>
								<div class="dropdown-menu">
									<a class="dropdown-item" href='/es<?php echo substring($route,3,20); ?>'>Español</a>
									<a class="dropdown-item" href='/pt<?php echo substring($route,3,20); ?>'>Português</a>
								</div>
							</li>             
						</ul>

						<ul class="navbar-nav ml-auto">
							<li class="nav-item">
								<a class="nav-link" href='<?php echo substring($route,0,3); ?>/profile/wishlist'><i class="fa fa-heart"></i> <span class="roof-description"> Wishlist</span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href='<?php echo substring($route,0,3); ?>/checkout'><i class="fa fa-truck"></i> <span class="roof-description"> Checkout</span></a>
							</li>
							<?php if( checkLogin(false) ){ ?>
							<li class="nav-item">
								<a class="nav-link" href='<?php echo substring($route,0,3); ?>/profile'><i class="fa fa-lock"></i> <span class="roof-description"><?php echo getUserName('en'); ?></span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href='<?php echo substring($route,0,3); ?>/logout'><i class="fas fa-sign-out-alt"></i> <span class="roof-description"> Logout</span></a>
							</li>
							<?php }else{ ?>
							<li class="nav-item ml-xs-0">
								<a class="nav-link" href='<?php echo substring($route,0,3); ?>/profile'><i class="fa fa-user"></i> <span class="roof-description"> Account</span></a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href='<?php echo substring($route,0,3); ?>/login'><i class="fas fa-sign-in-alt"></i> <span class="roof-description">Login</span></a>
							</li>
							<?php } ?>
						</ul>
<!-- português 
						<ul class="navbar-nav ml-auto">
							<li class="nav-item">
								<a class="nav-link" href="/profile"><i class="fa fa-user"></i> <span class="roof-description">Minha Conta</span></a>
							</li>                                     
							<li class="nav-item">
								<a class="nav-link" href="#"><i class="fa fa-heart"></i> <span class="roof-description">Lista de Desejos</span></a>
							</li>                                     
							<li class="nav-item">
								<a class="nav-link" href="/cart"><i class="fa fa-shopping-cart"></i> <span class="roof-description">Meu Carrinho</span></a>
							</li>                                     
							<?php if( checkLogin(false) ){ ?>
							<li class="nav-item">
								<a class="nav-link" href="/profile"><i class="fa fa-lock"></i> <span class="roof-description"><?php echo getUserName('en'); ?></span></a>
							</li>                                     
							<li class="nav-item">
								<a class="nav-link" href="/logout"><i class="fa fa-close"></i> <span class="roof-description">Sair</span></a>
							</li>                                     
							<?php }else{ ?>
							<li class="nav-item">
								<a class="nav-link" href="/login"><i class="fa fa-lock"></i> <span class="roof-description">Login</span></a>
							</li>
							<?php } ?>
						</ul>
-->
					</div>
				</div>
			</nav>
			<!-- Navbar Ends -->
		</section>
		<!-- roof area ends -->

		<!-- head in front of body -->
		<!-- avoid small vertical jump when scrolling -->
		<div id="navbar">
			<section id="header">
				<form class="form" action='<?php echo substring($route,0,3); ?>/products' method="post" id="formHeader">
					<nav class="navbar navbar-expand-lg navbar-light">
						<div class="container mt-xs-4 pt-xs-4 my-xs-4 mt-lg-0 pt-lg-0 my-lg-0">
							<a class="navbar-brand ml-0 mr-auto" id="logo" href="#"><h1>br-<span>casa</span></h1></a>
<!--
							<button class="navbar-toggler mr-0 ml-auto" type="button" id="mobile-nav-toggle" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation" onclick="xxx()">
								<span class="navbar-toggler-icon"></span>
							</button>
-->
							<div class="collapse navbar-collapse ml-0 mr-auto" id="main-menu">
								<ul class="navbar-nav nav-inline ml-auto ml-4 pl-4" id="navbar-nav">
									<li class="nav-item dropdown">
										<a class="nav-link active" href='<?php echo substring($route,0,3); ?>' role="button" aria-haspopup="true" aria-expanded="false">Home</a>
									</li>

									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
											Pages
										</a>
										
										<div class="dropdown-menu">
											<a class="dropdown-item" href='<?php echo substring($route,0,3); ?>/about'>About Us</a>
											<a class="dropdown-item" href='<?php echo substring($route,0,3); ?>/contact'>Contact Us</a>
											<a class="dropdown-item" href='<?php echo substring($route,0,3); ?>/products'>Products</a>
											<a class="dropdown-item" href='<?php echo substring($route,0,3); ?>/recipes'>Recipes</a>
											<a class="dropdown-item" href='<?php echo substring($route,0,3); ?>/shop'>Shop</a>
										</div>
									</li>
				
									<?php $counter1=-1;  if( isset($menu['category-name']) && ( is_array($menu['category-name']) || $menu['category-name'] instanceof Traversable ) && sizeof($menu['category-name']) ) foreach( $menu['category-name'] as $key1 => $value1 ){ $counter1++; ?>	
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
											<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>
										</a>                    
										
										<div class="dropdown-menu">
											<a class="dropdown-item">
												<button type="submit" class="btn btn-link" id=<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?> name=<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?> value='<?php echo htmlspecialchars( $menu["category-id"]["$key1"] . "#", ENT_COMPAT, 'UTF-8', FALSE ); ?>' onclick="document.getElementById('formHeader').submit()">
													All
												</button>
											</a>
						
											<?php $counter2=-1;  if( isset($menu['subCategory-name']["$key1"]) && ( is_array($menu['subCategory-name']["$key1"]) || $menu['subCategory-name']["$key1"] instanceof Traversable ) && sizeof($menu['subCategory-name']["$key1"]) ) foreach( $menu['subCategory-name']["$key1"] as $key2 => $value2 ){ $counter2++; ?>
											<a class="dropdown-item">
												<button type="submit" class="btn btn-link" id=<?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?> name=<?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?> value='<?php echo htmlspecialchars( $menu["category-id"]["$key1"] ."#@". $menu["subCategory-id"]["$key1"]["$key2"], ENT_COMPAT, 'UTF-8', FALSE ); ?>' onclick="document.getElementById('formHeader').submit()">
													<?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?>
												</button>
											</a>
											<?php } ?>
										</div>
									</li>
									<?php } ?>
				
									<li class="nav-item dropdown">
										<a class="nav-link last" href='<?php echo substring($route,0,3); ?>/products' role="button" aria-haspopup="true" aria-expanded="false">
											All
										</a>
									</li>
<!--
									<div class="top_search d-lg-none">
										<div class="top_search_con">
											<span class="top_search_icon"><i class="icon-magnifier"></i></span>
											<input class="s" placeholder="Search Here ..." type="text">
											<input class="top_search_submit" type="submit">
										</div>
									</div>
-->
								</ul>
							</div>

							<div class="top_search d-none d-lg-block col-lg-3 ml-lg-4 pl-lg-0 pr-lg-0">
								<div class="top_search_con">
									<input class="s" placeholder="Search Here ..." type="text" id="top_search" onkeypress="keyPress(this.form, this.value)" onkeyUp="keyUp(this.value)" autocomplete="off" value="<?php echo htmlspecialchars( $searchFilter, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
									<span class="top_search_icon"><i class="icon-magnifier"></i></span>
									<input class="top_search_submit" type="button" onclick="submitHeaderForm(this.form)">
								</div>

								<ul class="navbar-nav nav-inline" id="navbar-nav">
									<li class="nav-item dropdown">
										<div class="dropdown-menu" id="livesearchdropdown">
											<div id="livesearch"></div>
										</div>
									</li>
								</ul>
							</div>

							<?php if( checkLogin(false) ){ ?>
							<div class="shopping-item ml-4">
								<ul class="navbar-nav nav-inline" id="navbar-nav">
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-shopping-cart"></i> <span class="product-count"><?php echo getCartNrQty('en'); ?></span></a>

										<div class="dropdown-menu">
											<div class="row no-gutters">
												<?php $counter1=-1;  if( isset($cartProducts) && ( is_array($cartProducts) || $cartProducts instanceof Traversable ) && sizeof($cartProducts) ) foreach( $cartProducts as $key1 => $value1 ){ $counter1++; ?>
												<div class="col-4">
													<a class="dropdown-item" href="/en/products/<?php echo htmlspecialchars( $value1["dsurl"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" <?php if( $counter1 == 0 ){ ?>style="border-top: none"<?php } ?>><img alt="<?php echo htmlspecialchars( $value1["nmproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" src="/assets/img/products/product<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>.jpg"></a>
												</div>

												<div class="col-6">
													<a class="dropdown-item" href="/en/products/<?php echo htmlspecialchars( $value1["dsurl"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" <?php if( $counter1 == 0 ){ ?>style="border-top: none"<?php } ?>><?php echo htmlspecialchars( $value1["nrquantity"], ENT_COMPAT, 'UTF-8', FALSE ); ?> x <?php echo htmlspecialchars( $value1["nmproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
												</div>

												<div class="col-2">
													<div class="row no-gutters">
														<div class="col-12">
							        						<a class="nav-link" href="javascript:void(0);" name="delete-link" onclick="submitForm(this, <?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>);" <?php if( $counter1 == 0 ){ ?>style="border-top: none"<?php } ?>><i class="fa fa-trash trash"></i></a>
														</div>

														<div class="col-12">
															<a class="dropdown-item d-flex justify-content-end pt-0 pr-3" href="/en/products/<?php echo htmlspecialchars( $value1["dsurl"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" style="border-top: none"><?php echo formatEU($value1["nrquantity"]*$value1["vlprice"]); ?> €</a>
														</div>
													</div>
												</div>
												<?php } ?>

												<div class="col-12 d-flex">
													<div class="row pt-2" style="border-top: 1px solid #e2e6e7;">
														<div class="col-6 d-flex justify-content-start">
															<span>Subtotal</span>
														</div>

														<div class="col-6 d-flex justify-content-end mb-2">
															<span><?php echo formatEU($cart["vlsubtotal"]); ?> €</span>
														</div>
													</div>
												</div>

												<div class="col-12 d-flex">
													<div class="row pt-2" style="border-top: 1px solid #e2e6e7;">
														<div class="col-9 d-flex justify-content-start">
															<span>Shipping (free if over 50 €)</span>
														</div>

														<div class="col-3 d-flex justify-content-end mb-2">
															<span><?php if( $cart["vlsubtotal"] < 50 ){ ?>5,99<?php }else{ ?>0,00<?php } ?> €</span>
														</div>
													</div>
												</div>

												<div class="col-12 d-flex">
													<div class="row pt-2" style="border-top: 1px solid #e2e6e7;">
														<div class="col-6 d-flex justify-content-start">
															<span><b>Total</b></span>
														</div>

														<div class="col-6 d-flex justify-content-end mb-2">
															<span><b><?php echo formatEU($cart["vltotal"]); ?> €</b></span>
														</div>
													</div>
												</div>

												<div class="col-12 d-flex justify-content-end checkout-button">
													<div class="row no-gutters">
														<div class="col-6">
															<button type="button" class="btn btn-common col-12 mt-0 ml-0" onclick="window.location.href='/en/checkout/cart'">Got to Cart</button>
														</div>
				
														<div class="col-6">
															<button type="button" class="btn btn-common col-12 mt-0 ml-1 mr-0" onclick="window.location.href='/en/checkout'">Checkout</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
							<?php } ?>
						</div>
					</nav>
					<!-- Navbar - End -->
				</form>
				<!-- Form - End -->
			</section> 
			<!-- Head - End -->
		</div>
		<!-- Header - End -->

  		<!-- Head in front of the body -->
		<!-- Avoid small vertical jump when scrolling -->
		<div class="noJumpVScroll">
