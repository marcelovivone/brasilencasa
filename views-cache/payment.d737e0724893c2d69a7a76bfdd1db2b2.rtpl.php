<?php if(!class_exists('Rain\Tpl')){exit;}?><section id="payment" class="wow fadeInUp">
	<div class="container">
		<div class="row">
			<div class="section-header col-12">
				<h2>Pagamento N°<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h2>
			</div>

			<div class="col-12 d-flex justify-content-center">
				<input type="submit" value="Print" class="btn btn-common col-2">
			</div>

			<div class="col-md-12">
				<iframe src="/en/boleto/<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" name="boleto" frameborder="0" style="width:100%; min-height:1000px; border:1px solid #CCC; padding:20px;"></iframe>

				<script>
					document.querySelector("#btn-print").addEventListener("click", function(event){
						event.preventDefault();

						window.frames["boleto"].focus();
						window.frames["boleto"].print();

					});                
				</script>
			</div>
		</div>
	</div>
</section>>