<?php if(!class_exists('Rain\Tpl')){exit;}?><section id="forgot" class="wow fadeInUp">
	<div class="form">
		<div class="container">
			<div class="row">
				<div class="form-group col-12">
					<div id="error-message"></div>
				</div>

				<form action="/en/forgot" method="post" class="forgot-form" id="forgot-form">
					<div class="section-header">
						<h2>Password Assistance</h2>
					</div>

					<div class="container">
						<div class="form-group input-group">
							<div class="row no-gutters input-group">
								<div class="col-12 labelled-div-input field">
									<input type="text" class="form-control labelled-input" id="email" name="email">
									<label for="email">Email*</label>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-12 d-flex justify-content-center">
						<button type="button" class="btn btn-common col-2 mt-2" onclick="validateForm(this.form, true, 'email', '', 'en', false)">Send Message</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>