<?php if(!class_exists('Rain\Tpl')){exit;}?><section id="login" class="wow fadeInUp">
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
						
						<div class="form-group">
							<input type="text" name="reg-email" class="form-control" id="reg-email" placeholder="Email Address *"/>
						</div>

						<div class="form-group">
							<input type="password" class="form-control" placeholder="Password *" id="reg-password" name="reg-password">
						</div>

						<div class="row">
							<div class="form-group col-12">
								<div class="d-flex">
									<div class="col-6 pl-4 custom-control custom-checkbox checkbox-greensea d-flex justify-content-start">
										<input class="form-check-input" type="checkbox" id="remember" name="remember" value="0">
										<label class="form-check-label" for="remember">
											Remember Me
										</label>
									</div>

									<div class="col-6 pr-0 d-flex justify-content-end">
										<a class="nav-link active p-0" href='<?php echo substring($route,0,3); ?>/forgot' role="button" aria-haspopup="true" aria-expanded="false">Forgot Password</a>
									</div>
								</div>
							</div>

							<div class="col-12 d-flex justify-content-center">
								<button type="button" class="btn btn-common col-12" onclick="validateForm(this.form, true, 'reg-email', 'reg-password', 'en', false)">Sign In</button>
							</div>
						</div>
					</form>
				</div>
				<div class="newuser col-6">
					<form action="/en/login" method="post" id="new-user-form">
						<div class="section-header">
							<h2>New Customer</h2>
						</div>

						<div class="form-group">
							<input type="text" name="new-firstname" class="form-control" id="new-firstname" placeholder="First Name *"/>
							<div class="validation"></div>
						</div>

						<div class="form-group">
							<input type="text" name="new-lastname" class="form-control" id="new-lastname" placeholder="Last Name *"/>
							<div class="validation"></div>
						</div>

						<div class="form-group">
							<input type="text" name="new-email" class="form-control" id="new-email" placeholder="Email Address *"/>
							<div class="validation"></div>
						</div>
						
						<div class="row">
							<div class="col">
								<input type="password" class="form-control" placeholder="Password *" id="new-password" name="new-password">
								<div class="validation"></div>
							</div>
							<div class="col">
								<input type="password" class="form-control" placeholder="Confirm Password *" id="new-password-confirm" name="new-password-confirm">
								<div class="validation"></div>
							</div>
							<div class="col-12">
								<small id="passwordHelpBlock" class="form-text text-muted">
										Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
								</small>
							</div>
						</div>

						<div class="form-group">
							<div class="form-check form-check-inline custom-checkbox checkbox-greensea p-1 mt-2 mb-0">
								<input class="form-check-input" type="radio" id="mister" name="title" value="mr">
								<label class="form-check-label" for="mister">
									Mr.
								</label>
							</div>
							
							<div class="form-check form-check-inline custom-checkbox checkbox-greensea">
								<input class="form-check-input" type="radio" id="missus" name="title" value="mrs">
								<label class="form-check-label" for="missus">
									Mrs.
								</label>
							</div>
						</div>

						<div class="col-12 pl-0 pr-0 d-flex justify-content-center">
							<button type="submit" class="btn btn-common col-12">Register</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>