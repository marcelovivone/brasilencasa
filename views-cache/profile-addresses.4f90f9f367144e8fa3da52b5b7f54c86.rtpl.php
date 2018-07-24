<?php if(!class_exists('Rain\Tpl')){exit;}?><script>
function submitForm(form) {

	if (validateForm(form, false, '', '', 'en', true)) {
		form.method = "post";
		form.action = "/en/profile/addresses/<?php echo htmlspecialchars( $type, ENT_COMPAT, 'UTF-8', FALSE ); ?>/save";
		$(form).submit();;	
	} else {
		event.preventDefault();
	}
}

function remove(form) {
	if (!confirm("Do you really want to delete this address?")) {
		event.preventDefault();
		return;
	}

	form.method = "post";
	form.action = `/en/profile/addresses/<?php echo htmlspecialchars( $type, ENT_COMPAT, 'UTF-8', FALSE ); ?>/delete`;
console.log(form);
	$(form).submit();;	
}
</script>

<?php if( $action=='read' ){ ?>

<section id="profile-<?php echo htmlspecialchars( $type, ENT_COMPAT, 'UTF-8', FALSE ); ?>-addresses" class="wow fadeInUp">
<?php }else{ ?>

<section id="profile-<?php echo htmlspecialchars( $type, ENT_COMPAT, 'UTF-8', FALSE ); ?>-addresses-<?php echo htmlspecialchars( $action, ENT_COMPAT, 'UTF-8', FALSE ); ?>" class="wow fadeInUp">
<?php } ?>

	<div class="form mb-4">
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
						<?php echo htmlspecialchars( $profileAddressError, ENT_COMPAT, 'UTF-8', FALSE ); ?>

					</div>
					<?php } ?>

				</div>

				<div class="section-header col-12">
					<h2>Your Account</h2>
				</div>

				<div class="col-md-3 menu">
					<?php require $this->checkTemplate("profile-menu");?>

				</div>

				<div class="col-md-9 field">
					<?php $counter1=-1;  if( isset($addresses) && ( is_array($addresses) || $addresses instanceof Traversable ) && sizeof($addresses) ) foreach( $addresses as $key1 => $value1 ){ $counter1++; ?>

					<form action="" method="post" class="profile-addresses-form" id="profile-addresses-form<?php echo htmlspecialchars( $value1["idaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						<div class="row row<?php echo htmlspecialchars( $counter1+1, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
							<?php if( $action=='read' ){ ?>

							<div class="section-header col-6 d-flex justify-content-start mt-0 mb-0">
								<h6>#<?php echo htmlspecialchars( $counter1+1, ENT_COMPAT, 'UTF-8', FALSE ); ?></h6>
								<?php if( $value1["fldefault"]=='S' ){ ?>

								<span>&nbsp (Default <?php if( $type=='billing' ){ ?>Billing<?php }else{ ?>Shipping<?php } ?> Address)</span>
								<?php } ?>

							</div>

							<div class="col-6 d-flex justify-content-end">

								<?php if( $counter1==0 || $action=='edit' ){ ?>

								<a class="btn btn-default pt-0" href=/en/profile/addresses/<?php if( $type=='billing' ){ ?>shipping<?php }else{ ?>billing<?php } ?> role="button"> <?php if( $type=='billing' ){ ?>Shipping<?php }else{ ?>Billing<?php } ?> Addresses</a>
								<a class="btn btn-default pt-0" href="/en/profile/addresses/<?php echo htmlspecialchars( $type, ENT_COMPAT, 'UTF-8', FALSE ); ?>/new" role="button">New</a>
								<?php } ?>

								<a class="btn btn-default pt-0" href="/en/profile/addresses/<?php echo htmlspecialchars( $type, ENT_COMPAT, 'UTF-8', FALSE ); ?>/edit/<?php echo htmlspecialchars( $value1["idaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $counter1+1, ENT_COMPAT, 'UTF-8', FALSE ); ?>" role="button">Edit</a>
								<a class="btn btn-default pt-0" href="javascript:void;" onclick="remove(document.getElementById('profile-addresses-form<?php echo htmlspecialchars( $value1["idaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>'));" role="button">Delete</a>
							</div>
							<?php }else{ ?>

							<div class="col-12 d-flex justify-content-end mt-0" style="margin-bottom: 12px">
								<a class="btn btn-default pt-0" href="/en/profile/addresses/billing" role="button">Billing Addresses</a>
								<a class="btn btn-default pt-0" href="/en/profile/addresses/shipping" role="button">Shipping Addresses</a>
							</div>
							<?php } ?>

						</div>

						<input type="hidden" name="idperson" value="<?php echo htmlspecialchars( $value1["idperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						<input type="hidden" name="idaddress" value="<?php echo htmlspecialchars( $value1["idaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						<input type="hidden" name="tpaddress" value="<?php echo htmlspecialchars( $value1["tpaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">

						<div class="form-group">
							<div class="row pt-0">
								<div class="col-12">
									<input type="text" class="form-control" id="dsaddress" name="dsaddress" placeholder="Address" value='<?php echo utf8encode($value1["dsaddress"]); ?>' <?php if( $action=='read' ){ ?>disabled<?php } ?>>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-6">
									<input type="text" class="form-control" id="dsnumber" name="dsnumber" placeholder="Number" value="<?php echo htmlspecialchars( $value1["dsnumber"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" <?php if( $action=='read' ){ ?>disabled<?php } ?>>
								</div>
								<div class="col-6">
									<input type="text" class="form-control" id="cdzipcode" name="cdzipcode" placeholder="Postal Code" value="<?php echo htmlspecialchars( $value1["cdzipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" <?php if( $action=='read' ){ ?>disabled<?php } ?>>
								</div>
							</div>
						</div>

						<div class="form-group pb-2">
							<div class="row">
								<div class="col-6">
									<input type="text" class="form-control" id="dscity" name="dscity" placeholder="City" value="<?php echo htmlspecialchars( $value1["dscity"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" <?php if( $action=='read' ){ ?>disabled<?php } ?>>
								</div>
								<div class="col-6">
	<!--								<input type="text" class="form-control" id="dscountry" name="dscountry" placeholder="Country" value="<?php echo htmlspecialchars( $value1["dscountry"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"> -->
									<input type="text" class="form-control" id="dscountry" name="dscountry" placeholder="Country" value="España" disabled>
								</div>
							</div>

							<?php if( $action=='edit' ){ ?>

							<div class="form-group">
								<div class="form-check form-check-inline custom-checkbox checkbox-greensea p-1 mt-4 mb-0">
									<input class="form-check-input" type="checkbox" name="fldefault" id="fldefault" value="S" <?php if( $value1["fldefault"]=='S' ){ ?>checked<?php } ?>>
									<label class="form-check-label" for="fldefault">
										Default <span class="legend">(if you want to use this address to billing and shipping)</span>
									</label>
								</div>
							</div>

							<div class="col-12 d-flex justify-content-center">
								<button type="button" class="btn btn-common col-2" formaction="/en/profile/addresses/<?php echo htmlspecialchars( $type, ENT_COMPAT, 'UTF-8', FALSE ); ?>/save" onclick="submitForm(this.form)">Save</button>
								<?php break; ?>

							</div>
							<?php } ?>

						</div>
					</form>
					<?php }else{ ?>

					<div class="row row1">
						<div class="section-header col-6 d-flex justify-content-start mt-0 mb-0">
							<h6>New</h6>
						</div>

						<div class="col-6 d-flex justify-content-end pt-0 mt-0" style="margin-bottom: 12px">
							<a class="btn btn-default pt-0" href="/en/profile/addresses/billing" role="button">Billing Addresses</a>
							<a class="btn btn-default pt-0" href="/en/profile/addresses/shipping" role="button">Shipping Addresses</a>
						</div>
					</div>

					<form action="" method="post" class="profile-addresses-form" id="profile-addresses-form">
						<input type="hidden" name="idperson" value="<?php echo htmlspecialchars( $idperson, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						<input type="hidden" name="tpaddress" value=<?php if( $type=='billing' ){ ?>B<?php }else{ ?>S<?php } ?>>

						<div class="form-group">
							<div class="row pt-0">
								<div class="col-12">
									<input type="text" class="form-control" id="dsaddress" name="dsaddress" placeholder="Address">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-6">
									<input type="text" class="form-control" id="dsnumber" name="dsnumber" placeholder="Number">
								</div>
								<div class="col-6">
									<input type="text" class="form-control" id="cdzipcode" name="cdzipcode" placeholder="Postal Code">
								</div>
							</div>
						</div>

						<div class="form-group pb-2">
							<div class="row">
								<div class="col-6">
									<input type="text" class="form-control" id="dscity" name="dscity" placeholder="City">
								</div>
								<div class="col-6">
	<!--								<input type="text" class="form-control" id="dscountry" name="dscountry" placeholder="Country" value="<?php echo htmlspecialchars( $value1["dscountry"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"> -->
									<input type="text" class="form-control" id="dscountry" name="dscountry" placeholder="Country" value="Spain" disabled>
								</div>
							</div>

							<div class="form-group">
								<div class="row">
									<div class="form-check form-check-inline custom-checkbox checkbox-greensea d-flex justify-content-start p-1 mt-2 mb-0 ml-4">
										<input class="form-check-input" type="checkbox" name="fldefault" id="fldefault" value="S">
										<label class="form-check-label" for="fldefault">
											Default <span class="legend">(if you want to use this address to billing and shipping)</span>
										</label>
									</div>
	
									<div class="form-check form-check-inline custom-checkbox checkbox-greensea d-flex justify-content-end pr-0 mt-2 mb-0 ml-1">
										<input class="form-check-input" type="checkbox" name="flreplicate" id="flreplicate" value="S">
										<label class="form-check-label" for="flreplicate">
											 <?php if( $type=='billing' ){ ?>Shipping<?php }else{ ?>Billing<?php } ?> <span class="legend">(if you want to create this address for <?php if( $type=='billing' ){ ?>Shipping<?php }else{ ?>Billing<?php } ?> too)</span>
										</label>
									</div>
								</div>
							</div>

							<div class="col-12 d-flex justify-content-center">
								<button type="button" class="btn btn-common col-2" formaction="/en/profile/addresses/<?php echo htmlspecialchars( $type, ENT_COMPAT, 'UTF-8', FALSE ); ?>/save" onclick="submitForm(this.form)">Save</button>
							</div>
						</div>
					</form>
					<?php } ?>

				</div>
			</div>
		</div>
	</div>
</section>