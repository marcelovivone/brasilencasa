<?php if(!class_exists('Rain\Tpl')){exit;}?><script>
function submitForm() {
	'use strict';

	if (!validateForm(document.getElementById('new-email').form, true, 'new-email', '', 'en', true)) {
		event.preventDefault();
	}
}
</script>

<section id="login" class="wow fadeInUp">
	<div class="form">
		<div class="container">
			<div class="row">
				<div class="form-group col-12">
					<div id="error-message"></div>
				</div>

				<div class="registereduser col-6">
					<form action="/en/login" method="post" class="login-form" id="reg-user-form">
						<div class="section-header">
							<h2>Registered Customer</h2>
						</div>
						
						<div class="form-group input-group">
							<div class="row no-gutters input-group">
								<div class="col-12 labelled-div-input field">
									<input type="text" class="form-control labelled-input" id="reg-email" name="reg-email">
									<label for="reg-email">Email*</label>
								</div>
							</div>
  						</div>

						<div class="form-group input-group">
							<div class="row no-gutters input-group">
								<div class="col-12 labelled-div-input field">
									<input type="password" class="form-control labelled-input" id="reg-password" name="reg-password">
									<label for="reg-password">Password*</label>
								</div>
							</div>
  						</div>

						<div class="row">
							<div class="form-group col-12 mb-2">
								<div class="d-flex">
									<div class="col-12 pr-0 d-flex justify-content-end">
										<a class="nav-link active p-0" href='<?php echo substring($route,0,3); ?>/forgot' role="button" aria-haspopup="true" aria-expanded="false" style="font-size: 13px">Forgot Your Password?</a>
									</div>
								</div>
							</div>

							<div class="col-12 d-flex justify-content-center">
								<button type="button" class="btn btn-common col-4 mt-0" onclick="validateForm(this.form, true, 'reg-email', 'reg-password', 'en', false)">Sign In</button>
							</div>
						</div>
					</form>
				</div>
				
				<div class="newuser col-6">
					<form action="/en/register" method="post" class="login-form" id="new-user-form">
						<div class="section-header">
							<h2>New Customer</h2>
						</div>

						<div class="form-group input-group">
							<div class="row no-gutters input-group">
								<div class="col-6 labelled-div-input first-column">
									<input type="text" class="form-control labelled-input" id="new-firstname" name="new-firstname">
									<label for="new-firstname">First Name*</label>
								</div>

								<div class="col-6 labelled-div-input second-column">
									<input type="text" class="form-control labelled-input" id="new-lastname" name="new-lastname">
									<label for="new-lastname">Last Name*</label>
								</div>
							</div>
						</div>

						<div class="form-group input-group">
							<div class="row no-gutters input-group">
								<div class="col-6 labelled-div-input first-column">
									<input type="text" class="form-control labelled-input" id="new-email" name="new-email">
									<label for="new-email">Email*</label>
								</div>

								<div class="col-6 labelled-div-input second-column">
									<input type="text" class="form-control labelled-input" id="new-phone" name="new-phone">
									<label for="new-phone">Phone</label>
								</div>
							</div>
						</div>

						<div class="container">
							<div class="row">
								<div class="form-group input-group">
									<div class="row no-gutters input-group">
										<div class="col-6 labelled-div-input first-column">
											<input type="password" class="form-control labelled-input" id="new-password" name="new-password">
											<label for="new-password">Password*</label>
										</div>

										<div class="col-6 labelled-div-input second-column">
											<input type="password" class="form-control labelled-input" id="new-password-confirm" name="new-password-confirm">
											<label for="new-password-confirm">Confirm Password*</label>
										</div>
									</div>
								</div>

								<div class="col-12">
									<small id="passwordHelpBlock" class="form-text text-muted mt-0">
										Your password must be 8-20 characters long, contain at least one lowercase and one uppercase character and one number, and must not contain spaces or special characters.
									</small>
								</div>
							</div>
						</div>
						
						<div class="form-group mb-1">
							<span class='validate'>
								<div class="form-check form-check-inline custom-checkbox checkbox-greensea checkbox-circle p-1 mt-2 mb-0">
									<input class="form-check-input" type="radio" name="title" id="mister" value="mr">
									<label class="form-check-label" for="mister">
										Mr.
									</label>
								</div>
							
								<div class="form-check form-check-inline custom-checkbox checkbox-greensea checkbox-circle">
									<input class="form-check-input" type="radio" name="title" id="missus" value="mrs">
									<label class="form-check-label" for="missus">
										Mrs.
									</label>
								</div>
							</span>
						</div>
						
						<div class="row">
							<div class="col-12 d-flex justify-content-center">
								<button type="button" class="btn btn-common col-4 mt-0" onclick="submitForm()">Register</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>