<?php if(!class_exists('Rain\Tpl')){exit;}?><section id="forgot-reset" class="wow fadeInUp">
	<div class="form">
		<div class="container">
			<div class="row">
				<div class="form-group col-12">
					<div id="error-message"></div>
				</div>

				<form action="/en/forgot/reset" method="post" class="forgot-reset-form" id="forgot-reset-form">
					<input type="hidden" name="code" value="<?php echo htmlspecialchars( $code, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
					<input type="hidden" name="iv" value="<?php echo htmlspecialchars( $iv, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
					<div class="section-header">
						<h2>Password Assistance</h2>
						<p>Hello, <?php echo htmlspecialchars( $name, ENT_COMPAT, 'UTF-8', FALSE ); ?>. Please, enter a new password.</p>
					</div>

					<div class="container">
						<div class="row row-input mb-0">
							<div class="form-group input-group mb-0">
								<div class="row no-gutters input-group">
									<div class="col-12 labelled-div-input field">
										<input type="password" class="form-control labelled-input" id="password" name="password">
										<label for="reg-password">New Password*</label>
									</div>
								</div>
  							</div>
						</div>
						
						<div class="col-12 pt-1">
							<small id="passwordHelpBlock" class="form-text text-muted pt-0">
								Your password must be 8-20 characters long, contain at least one lowercase and one uppercase character and one number, and must not contain spaces or special characters.
							</small>
						</div>
					</div>

					<div class="col-12 d-flex justify-content-center mt-2">
						<button type="button" class="btn btn-common col-2" onclick="validateForm(this.form, true, '', 'password', 'en', false)">Save Password</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>