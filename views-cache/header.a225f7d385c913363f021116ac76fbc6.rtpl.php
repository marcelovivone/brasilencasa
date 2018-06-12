<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- DOCTYPE -->
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<!-- Viewport Meta Tag -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>
			Brasil en Casa
		</title>
		<!-- Bootstrap -->
<!--    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css"> -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
<!--		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
-->
		<link href="/vendor/twbs/bootstrap/dist/css/bootstrap.css" rel="stylesheet"/>
		
		<!-- Main Style -->
		<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
		<!-- Responsive Style -->
		<link rel="stylesheet" type="text/css" href="/assets/css/responsive.css">
		<!--Fonts-->
		
		<!-- <link rel="stylesheet" media="screen" href="/assets/fonts/font-awesome/font-awesome.min.css"> -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

		<link rel="stylesheet" media="screen" href="/assets/fonts/simple-line-icons.css">    
		 
		<!-- Extras -->
		<link rel="stylesheet" type="text/css" href="/assets/extras/owl/owl.carousel.css">
<!--    <link rel="stylesheet" type="text/css" href="/assets/extras/owl/owl.theme.css"> -->
		<link rel="stylesheet" type="text/css" href="/assets/extras/owl/owl.theme.default.css">
		<link rel="stylesheet" type="text/css" href="/assets/extras/animate.css">
		<link rel="stylesheet" type="text/css" href="/assets/extras/normalize.css">
		<link rel="stylesheet" type="text/css" href="/assets/extras/settings.css">

		<!-- Color CSS Styles  -->
		<link rel="stylesheet" type="text/css" href="/assets/css/colors/greensea.css" media="screen" />       
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js">
		</script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js">
		</script>
		<![endif]-->

	</head>

	<body>
		<!-- <header id="header-wrap"> -->
		<!-- Roof area starts -->
		<section id="roof" class="roof-content">
			<!-- Navbar Starts -->
			<nav class="navbar navbar-expand navbar-light">
				<div class="container">
					<div class="navbar-nav roof-menu" id="roof-menu">
						<!-- Navbar Starts -->
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
								<a class="nav-link" href='<?php echo substring($route,0,3); ?>/profile'><i class="fa fa-user"></i> <span class="roof-description"> Account</span></a>
							</li>                                     
							<li class="nav-item">
								<a class="nav-link" href='<?php echo substring($route,0,3); ?>/wishlist'><i class="fa fa-heart"></i> <span class="roof-description"> Wishlist</span></a>
							</li>                                     
							<li class="nav-item">
								<a class="nav-link" href='<?php echo substring($route,0,3); ?>/cart'><i class="fa fa-shopping-cart"></i> <span class="roof-description"> Cart</span></a>
							</li>                                     
							<?php if( checkLogin(false) ){ ?>
							<li class="nav-item">
								<a class="nav-link" href='<?php echo substring($route,0,3); ?>/profile'><i class="fa fa-lock"></i> <span class="roof-description"><?php echo getUserName(); ?></span></a>
							</li>                                     
							<li class="nav-item">
								<a class="nav-link" href='<?php echo substring($route,0,3); ?>/logout'><i class="fa fa-close"></i> <span class="roof-description"> Logout</span></a>
							</li>                                     
							<?php }else{ ?>
							<li class="nav-item">
								<a class="nav-link" href='<?php echo substring($route,0,3); ?>/login'><i class="fa fa-lock"></i> <span class="roof-description">Login</span></a>
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
								<a class="nav-link" href="/profile"><i class="fa fa-lock"></i> <span class="roof-description"><?php echo getUserName(); ?></span></a>
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
				<form class="form">
					<nav class="navbar navbar-expand-lg navbar-light">
						<div class="container">
							<a class="navbar-brand ml-0 mr-auto" id="logo" href="#"><h1>br-<span>casa</span></h1></a>

							<button class="navbar-toggler mr-0 ml-auto" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation" onclick="xxx()">
								<span class="navbar-toggler-icon"></span>
							</button>

							<div class="collapse navbar-collapse ml-0 mr-auto" id="main-menu">
								<ul class="navbar-nav nav-inline ml-auto ml-4 pl-4">
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
												<button type="submit" class="btn btn-link" id=<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?> name=<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?> value=<?php echo htmlspecialchars( $menu["category-id"]["$key1"] . "#", ENT_COMPAT, 'UTF-8', FALSE ); ?>>
													All
												</button>
											</a>
						
											<?php $counter2=-1;  if( isset($menu['subCategory-name']["$key1"]) && ( is_array($menu['subCategory-name']["$key1"]) || $menu['subCategory-name']["$key1"] instanceof Traversable ) && sizeof($menu['subCategory-name']["$key1"]) ) foreach( $menu['subCategory-name']["$key1"] as $key2 => $value2 ){ $counter2++; ?>
											<a class="dropdown-item">
												<button type="submit" class="btn btn-link" id=<?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?> name=<?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?> value=<?php echo htmlspecialchars( $menu["category-id"]["$key1"] ."#@". $menu["subCategory-id"]["$key1"]["$key2"], ENT_COMPAT, 'UTF-8', FALSE ); ?>>
													<?php echo htmlspecialchars( $value2, ENT_COMPAT, 'UTF-8', FALSE ); ?>
												</button>
											</a>
											<?php } ?>
										</div>
									</li>
									<?php } ?>
				
									<li class="nav-item dropdown">
										<a class="nav-link" href='<?php echo substring($route,0,3); ?>/products' role="button" aria-haspopup="true" aria-expanded="false">
											All
										</a>
									</li>
								</ul>
		
	 						</div>
								<div class="top_search d-none d-lg-block col-lg-3 ml-lg-4 pl-lg-0 pr-lg-0">
									<div class="top_search_con">
										<input class="s" placeholder="Search Here ..." type="text">
										<span class="top_search_icon"><i class="icon-magnifier"></i></span>
										<input class="top_search_submit" type="submit">
									</div>
								</div>
						</div>
					</nav>
					<!-- Navbar Ends -->
				</form>
				<!-- Form for navbar search area -->
			</section> 
			<!-- Roof area Ends -->
		</div>
		<!-- </header> -->
<script type="text/javascript">
$(document).ready(function(){
  $('.navbar-toggler').click(function(){
  	confirm('oi');
    $('.nav').toggleClass('nav-view');
  });
});
function xxx() {
    $('#main-menu').toggleClass('reveal');
$('#main-menu').addClass('reveal');
}
</script>
  		<!-- head in front of the body -->
		<!-- avoid small vertical jump when scrolling -->
		<div class="noJumpVScroll">
