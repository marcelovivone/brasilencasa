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

					<div class="form-group col-12">
						<input type="text" name="email" class="form-control col-12" id="email" placeholder="Email Address"/>
					</div>

					<div class="col-12 d-flex justify-content-center">
						<button type="button" class="btn btn-common col-6" onclick="validateForm(this.form, true, 'email', '', 'en', false)">Send Message</button>
					</div>
				</form>                    
			</div>
		</div>
	</div>
</section>