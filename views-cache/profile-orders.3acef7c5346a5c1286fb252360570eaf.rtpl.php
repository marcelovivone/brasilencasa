<?php if(!class_exists('Rain\Tpl')){exit;}?><section id="profile-orders" class="wow fadeInUp">
	<div class="container">
		<div class="row">
			<div class="section-header col-12">
				<h2>Your Account</h2>
			</div>

			<div class="col-md-3 profile-menu">
				<?php require $this->checkTemplate("profile-menu");?>

			</div>
             
			<div class="col-md-9 profile-field">
				<table class="table">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col" class="number">Total</th>
							<th scope="col">Status</th>
							<th scope="col">Address</th>
							<th scope="col">&nbsp;</th>
						</tr>
					</thead>

					<tbody>
						<?php $counter1=-1;  if( isset($orders) && ( is_array($orders) || $orders instanceof Traversable ) && sizeof($orders) ) foreach( $orders as $key1 => $value1 ){ $counter1++; ?>

						<tr>
							<th scope="row"><?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
							<td class="number" style="width:98px;"><?php echo formatEU($value1["vltotal"]); ?> €</td>
							<td><?php echo htmlspecialchars( $value1["dsstatus"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
							<td><?php echo utf8encode($value1["dsaddress"]); ?>, <?php echo htmlspecialchars( $value1["dsnumber"], ENT_COMPAT, 'UTF-8', FALSE ); ?>, <?php echo htmlspecialchars( $value1["cdzipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?><br/><?php echo htmlspecialchars( $value1["dscity"], ENT_COMPAT, 'UTF-8', FALSE ); ?> <?php echo htmlspecialchars( $value1["dscountry"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
							<td style="width:210px;">
								<a class="btn btn-common col-6" href="/en/order/<?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" role="button">Ticket</a>
								<a class="btn btn-default" href="/en/profile/orders/<?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" role="button">Details</a>
							</td>
						</tr>
						<?php }else{ ?>

						<tr>
							<td colspan="5">
								<div id="success-message">
									No orders found.
								</div>
							</td>
						</tr>
						<?php } ?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>