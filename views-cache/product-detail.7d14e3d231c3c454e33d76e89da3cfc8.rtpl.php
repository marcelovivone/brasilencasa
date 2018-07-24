<?php if(!class_exists('Rain\Tpl')){exit;}?><script>
function submitForm(element, idproduct) {
	let form = '';
	form = document.getElementById(`product-detail-social${idproduct}`);

	form.method = 'post';
	form.action = '/en/profile/wishlist/include';

	$(form).submit();
}
</script>
<section id="product-detail" class="wow fadeInUp">
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<div class="product-item wow fadeInUpQuick" data-wow-delay="1s">
					<figure>
						<a><img src="<?php echo htmlspecialchars( $product["dsphoto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"></a>
						<figcaption>
						  <form id="product-detail-social" method="post">
								<div class="d-flex justify-content-center social">
									<a class="nav-link" href="/en/checkout/cart"><i class="fa fa-shopping-cart cart"></i></a>
									<a class="nav-link" href="javascript:void(0);" id="wishlist" onclick="submitForm(this, <?php echo htmlspecialchars( $value["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>);"><i class="fa fa-heart wishlist"></i></a>
									<input name="nrquantity" value="1" style="display: none">
									<a class="nav-link" href="/en/recipes/<?php echo htmlspecialchars( $product["dsurl"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><i class="fa fa-receipt recipe"></i></a>
								</div>
							</form>
						</figcaption>
					</figure>
				</div>



			</div>
			<div class="col-sm-6">
				<div class="product-inner">
				  <h2 class="product-name"><?php echo htmlspecialchars( $product["nmproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h2>
				  <div class="product-inner-price">
				      <ins>R$<?php echo formatEU($product["vlprice"]); ?></ins>
				  </div>    
				  
				  <form action="/cart/<?php echo htmlspecialchars( $product["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/plus" class="cart">
				      <div class="quantity">
				          <input type="number" size="4" class="input-text qty text" title="Qty" value="1" name="qtd" min="1" step="1">
				      </div>
				      <button class="add_to_cart_button" type="submit">Add to cart</button>
				  </form>   
				  
				  <div class="product-inner-category">
				      <p>Categorias<?php $counter1=-1;  if( isset($categories) && ( is_array($categories) || $categories instanceof Traversable ) && sizeof($categories) ) foreach( $categories as $key1 => $value1 ){ $counter1++; ?> <a href="/categories/<?php echo htmlspecialchars( $value1["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["nmcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a><?php } ?>.
				  </div> 
				  
				  <div role="tabpanel">
				      <ul class="product-tab" role="tablist">
				          <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Descrição</a></li>
				          <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Avaliações</a></li>
				      </ul>
				      <div class="tab-content">
				          <div role="tabpanel" class="tab-pane fade in active" id="home">
				              <h2>Descrição do Produto</h2>  
				              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam tristique, diam in consequat iaculis, est purus iaculis mauris, imperdiet facilisis ante ligula at nulla. Quisque volutpat nulla risus, id maximus ex aliquet ut. Suspendisse potenti. Nulla varius lectus id turpis dignissim porta. Quisque magna arcu, blandit quis felis vehicula, feugiat gravida diam. Nullam nec turpis ligula. Aliquam quis blandit elit, ac sodales nisl. Aliquam eget dolor eget elit malesuada aliquet. In varius lorem lorem, semper bibendum lectus lobortis ac.</p>

				              <p>Mauris placerat vitae lorem gravida viverra. Mauris in fringilla ex. Nulla facilisi. Etiam scelerisque tincidunt quam facilisis lobortis. In malesuada pulvinar neque a consectetur. Nunc aliquam gravida purus, non malesuada sem accumsan in. Morbi vel sodales libero.</p>
				          </div>
				          <div role="tabpanel" class="tab-pane fade" id="profile">
				              <h2>Reviews</h2>
				              <div class="submit-review">
				                  <p><label for="name">Name</label> <input name="name" type="text"></p>
				                  <p><label for="email">Email</label> <input name="email" type="email"></p>
				                  <div class="rating-chooser">
				                      <p>Your rating</p>

				                      <div class="rating-wrap-post">
				                          <i class="fa fa-star"></i>
				                          <i class="fa fa-star"></i>
				                          <i class="fa fa-star"></i>
				                          <i class="fa fa-star"></i>
				                          <i class="fa fa-star"></i>
				                      </div>
				                  </div>
				                  <p><label for="review">Your review</label> <textarea name="review" id="" cols="30" rows="10"></textarea></p>
				                  <p><input type="submit" value="Submit"></p>
				              </div>
				          </div>
				      </div>
				  </div>
				</div>
			</div>
		</div>
	</div>                    
</section>