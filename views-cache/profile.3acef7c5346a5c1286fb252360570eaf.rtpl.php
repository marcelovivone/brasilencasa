<?php if(!class_exists('Rain\Tpl')){exit;}?><script>
function submitForm() {
	'use strict';

	if (!validateForm(document.getElementById('dsemail').form, true, 'dsemail', '', 'en', false)) {
		event.preventDefault();
	}
}
</script>

<section id="profile" class="wow fadeInUp">
	<div class="form">
		<div class="container">
			<div class="row">
				<div class="form-group col-12">
					<?php if( $profileMsg != '' ){ ?>

					<div id="success-message">
						<?php echo htmlspecialchars( $profileMsg, ENT_COMPAT, 'UTF-8', FALSE ); ?>

					</div>
					<?php } ?>

	                
					<?php if( $profileError != '' ){ ?>

					<div id="error-message">
						<?php echo htmlspecialchars( $profileError, ENT_COMPAT, 'UTF-8', FALSE ); ?>

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
					<form action="/en/profile" method="post" class="profile-form" id="profile-form">
						<input type="hidden" name="iduser" value="<?php echo htmlspecialchars( $user["iduser"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						<div class="form-group input-group">
							<div class="row no-gutters input-group">
								<div class="col-12 labelled-div-input field">
									<input type="text" class="form-control labelled-input" id="nmfirst" name="nmfirst" value="<?php echo htmlspecialchars( $user["nmfirst"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
									<label for="nmfirst">First Name*</label>
								</div>
							</div>
  						</div>

						<div class="form-group input-group">
							<div class="row no-gutters input-group">
								<div class="col-12 labelled-div-input">
									<input type="text" class="form-control labelled-input" id="nmlast" name="nmlast" value="<?php echo htmlspecialchars( $user["nmlast"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
									<label for="nmlast">Last Name*</label>
								</div>
							</div>
						</div>

						<div class="form-group input-group">
							<div class="row no-gutters input-group">
								<div class="col-12 labelled-div-input">
									<input type="email" class="form-control labelled-input" id="dsemail" name="dsemail" value="<?php echo htmlspecialchars( $user["dsemail"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
									<label for="dsemail">Email Address*</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<span class="validate">
								<div class="form-check form-check-inline custom-checkbox checkbox-greensea checkbox-circle pt-1 pl-1 m-0">
									<input class="form-check-input" type="radio" name="tptitle" id="mister" value="M" <?php echo htmlspecialchars( $user["tptitle"], ENT_COMPAT, 'UTF-8', FALSE ); ?> === "M" ? checked : "">
									<label class="form-check-label" for="mister">
										Mr.
									</label>
								</div>

								<div class="form-check form-check-inline custom-checkbox checkbox-greensea checkbox-circle">
									<input class="form-check-input" type="radio" name="tptitle" id="missus" value="W" <?php echo htmlspecialchars( $user["tptitle"], ENT_COMPAT, 'UTF-8', FALSE ); ?> === "W" ? checked : "">
									<label class="form-check-label" for="missus">
										Mrs.
									</label>
								</div>
							</span>
						</div>

						<div class="form-group input-group">
							<div class="row no-gutters input-group">
								<div class="col-12 labelled-div-input">
									<input type="tel" class="form-control labelled-input" id="nrphone" name="nrphone" value="<?php echo htmlspecialchars( $user["nrphone"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
									<label for="nrphone">Phone Number</label>
								</div>
							</div>
						</div>

						<div class="col-12 d-flex justify-content-center">
							<button type="button" class="btn btn-common col-2" onclick="submitForm()">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>