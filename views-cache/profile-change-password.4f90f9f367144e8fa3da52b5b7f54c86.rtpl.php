<?php if(!class_exists('Rain\Tpl')){exit;}?><script>
function submitForm() {
	'use strict';

	if (!validateForm(document.getElementById('current-password').form, true, 'hide-email', 'current-password', 'en', false)) {
		event.preventDefault();
	}
}
</script>

<section id="profile-change-password" class="wow fadeInUp">
	<div class="form">
		<div class="container">
			<div class="row">
				<div class="form-group col-12">
					<?php if( $changePassSuccess != '' ){ ?>

					<div id="success-message">
						<?php echo htmlspecialchars( $changePassSuccess, ENT_COMPAT, 'UTF-8', FALSE ); ?>

					</div>
					<?php } ?>


					<div id="error-message"></div>
					<?php if( $changePassError != '' ){ ?>

					<div id="error-message-2">
						<?php echo htmlspecialchars( $changePassError, ENT_COMPAT, 'UTF-8', FALSE ); ?>

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
					<form action="/en/profile/change-password" method="post" class="profile-change-password-form" id="profile-change-password-form">
						<input type="hidden" name="hide-email" id="hide-email" value="<?php echo htmlspecialchars( $user["dsemail"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						<div class="form-group">
							<input type="password" class="form-control" id="current-password" name="current-password" placeholder="Current Password">
						</div>
						<hr>
                    
						<div class="form-group">
							<input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password">
							<small id="passwordHelpBlock" class="form-text text-muted">
								Your password must be 8-20 characters long, contain at least one lowercase and one uppercase character and one number, and must not contain spaces or special characters.
							</small>
						</div>

						<div class="form-group">
							<input type="password" class="form-control" id="new-password-confirm" name="new-password-confirm" placeholder="Confirm New password">
						</div>
                  
						<div class="col-12 d-flex justify-content-center">
							<button type="button" class="btn btn-common col-2" onclick="submitForm()">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>