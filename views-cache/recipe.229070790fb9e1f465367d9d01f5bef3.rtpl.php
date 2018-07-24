<?php if(!class_exists('Rain\Tpl')){exit;}?><section id="recipes">
	<div class="container">
		<div class="section-header">
			<h2>Recipes</h2>
			<?php $counter1=-1;  if( isset($recipes) && ( is_array($recipes) || $recipes instanceof Traversable ) && sizeof($recipes) ) foreach( $recipes as $key1 => $value1 ){ $counter1++; ?>
			<h5><?php echo htmlspecialchars( $value1["nmrecipe"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h5>
			<p>Ingredients: <?php echo htmlspecialchars( $value1["dsingredient"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
			<p>Recipe: <?php echo htmlspecialchars( $value1["dsrecipe"], ENT_COMPAT, 'UTF-8', FALSE ); ?></p>
			<?php }else{ ?>
			<p>Sed tamen tempor magna labore dolore dolor sint tempor duis magna elit veniam aliqua esse amet veniam enim export quid quid veniam aliqua eram noster malis nulla duis fugiat culpa esse aute nulla ipsum velit export irure minim illum fore</p>
			<?php } ?>
		</div>
			
		<div class="row">
			<div class="col-lg-6">
				<div class="box wow fadeInLeft">
					<div class="icon"><img src="/assets/img/recipes/salad-64px.png" alt="Salad"></div>
					<h4 class="title"><a href="">Salad</a></h4>
					<p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident etiro rabeta lingo.</p>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="box wow fadeInRight">
					<div class="icon"><img src="/assets/img/recipes/breakfast-64px.png" alt="Breakfast"></div>
					<h4 class="title"><a href="">Breakfast</a></h4>
					<p class="description">Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat tarad limino ata nodera clas.</p>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="box wow fadeInLeft" data-wow-delay="0.2s">
					<div class="icon"><img src="/assets/img/recipes/dinner-64px.png" alt="Bread"></div>
					<h4 class="title"><a href="">Lunch & Dinner</a></h4>
					<p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur trinige zareta lobur trade.</p>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="box wow fadeInRight" data-wow-delay="0.2s">
					<div class="icon"><img src="/assets/img/recipes/fruit-64px.png" alt="Vegetables"></div>
					<h4 class="title"><a href="">Fruits & Juices</a></h4>
					<p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum rideta zanox satirente madera</p>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="box wow fadeInLeft" data-wow-delay="0.4s">
					<div class="icon"><img src="/assets/img/recipes/groceries-64px.png" alt="Bread"></div>
					<h4 class="title"><a href="">Bread</a></h4>
					<p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur trinige zareta lobur trade.</p>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="box wow fadeInRight" data-wow-delay="0.4s">
					<div class="icon"><img src="/assets/img/recipes/vegetables-64px.png" alt="Vegetables"></div>
					<h4 class="title"><a href="">Vegetables</a></h4>
					<p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum rideta zanox satirente madera</p>
				</div>
			</div>
		</div>
	</div>
</section>