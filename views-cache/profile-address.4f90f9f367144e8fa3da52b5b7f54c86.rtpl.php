<?php if(!class_exists('Rain\Tpl')){exit;}?><script>
function submitForm() {
	'use strict';

	if (!validateForm(document.getElementById('dsemail').form, true, 'dsemail', '', 'en', false)) {
		event.preventDefault();
	}
}
</script>

<section id="profile-address" class="wow fadeInUp">
	<div class="form">
		<div class="container">
			<div class="row">
				<div class="form-group col-12">
					<?php if( $profileAddressSuccess != '' ){ ?>

					<div id="success-message">
						<?php echo htmlspecialchars( $profileAddressSuccess, ENT_COMPAT, 'UTF-8', FALSE ); ?>

					</div>
					<?php } ?>

	                
					<?php if( $profileAddressError != '' ){ ?>

					<div id="error-message">
						<?php echo htmlspecialchars( $profileAddress, ENT_COMPAT, 'UTF-8', FALSE ); ?>

					</div>
					<?php } ?>                
            
				</div>

				<div class="section-header col-4">
					<h2>Your Account</h2>
				</div>

				<div class="section-header col-8 d-flex justify-content-end">
					<a class="btn btn-default" href="/en/profile/orders/<?php echo htmlspecialchars( $value["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" role="button">New Address</a>
				</div>

				<div class="col-md-3 menu">
					<?php require $this->checkTemplate("profile-menu");?>

				</div>
				
				<div class="col-md-9 field">
					<form action="/en/profile/address" method="post" class="profile-address-form" id="profile-address-form">
						<?php $counter1=-1;  if( isset($address) && ( is_array($address) || $address instanceof Traversable ) && sizeof($address) ) foreach( $address as $key1 => $value1 ){ $counter1++; ?>

						<input type="hidden" name="idperson" value="<?php echo htmlspecialchars( $addresses["idperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						<input type="hidden" name="iduser" value="<?php echo htmlspecialchars( $addresses["idaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						<div class="form-group">
							<input type="text" class="form-control" id="dsaddress" name="dsaddress" placeholder="Address" value="<?php echo htmlspecialchars( $addresses["dsaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						</div>

						<div class="form-group">
							<input type="text" class="form-control" id="nrnumber" name="nrnumber" placeholder="Number" value="<?php echo htmlspecialchars( $addresses["nrnumber"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						</div>

						<div class="form-group">
							<input type="text" class="form-control" id="cdzipcode" name="cdzipcode" placeholder="Postal Code" value="<?php echo htmlspecialchars( $addresses["cdzipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						</div>

						<div class="form-group">
							<input type="text" class="form-control" id="dscity" name="dscity" placeholder="City" value="<?php echo htmlspecialchars( $addresses["dscity"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						</div>

						<div class="form-group">
<!--							<input type="text" class="form-control" id="dscountry" name="dscountry" placeholder="Country" value="<?php echo htmlspecialchars( $addresses["dscountry"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"> -->
							<input type="text" class="form-control" id="dscountry" name="dscountry" placeholder="Country" value="Spain">
						</div>
						<?php }else{ ?>

						<div id="success-message" class="col-12">
							No registered address.
						</div>
						<?php } ?>

						<div class="col-12 d-flex justify-content-center">
							<button type="button" class="btn btn-common col-2" onclick="submitForm()">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>