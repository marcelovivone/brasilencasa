<?php if(!class_exists('Rain\Tpl')){exit;}?><script>
function submitForm() {
	'use strict';

	if (validateForm(document.getElementById('email').form, false, '', '', 'en', false)) {
		let name = document.getElementById('name').value;
		let email = document.getElementById('email').value;
		let subject = document.getElementById('subject').value;
		let message = document.getElementById('message').value;

		$.ajax({
			type: "POST",
			url: "/views/en/contact/contactForm.php",
			data: {name: name, email: email, subject: subject, message: message},
			success: function(msg) {
				if (msg === 'OK') {
					document.getElementById('send-message').style.display = 'block';
					document.getElementById('error-message').style.display = 'none';
				} else {
					document.getElementById('send-message').style.display = 'none';
					document.getElementById('error-message').style.display = 'block';
					event.preventDefault();
				}
			}
		});

	} else {
		event.preventDefault();
	}
}
</script>

<section id="contact" class="wow fadeInUp">
	<div class="form">
		<div class="container">
			<div class="row">
				<div class="form-group col-12">
					<div id="send-message">Your message has been sent. Thank you!</div>
					<div id="error-message"></div>
				</div>

				<form action="" method="post" role="form" class="form-inline contact-form" id="contact-form">
					<div class="section-header" style="padding-left: 15px">
						<h2>Contact Us</h2>
						<p>Sed tamen tempor magna labore dolore dolor sint tempor duis magna elit veniam aliqua esse amet veniam enim export quid quid veniam aliqua eram noster malis nulla duis fugiat culpa esse aute nulla ipsum velit export irure minim illum fore</p>
					</div>

					<div class="form-group col-12 col-md-6">
						<input type="text" name="name" class="form-control col-12" id="name" placeholder="Your Name"/>
					</div>

					<div class="form-group col-12 col-md-6">
						<input type="email" class="form-control col-12" name="email" id="email" placeholder="Email Address"/>
					</div>

					<div class="form-group col-12">
						<input type="text" class="form-control col-12" name="subject" id="subject" placeholder="Subject"/>
					</div>

					<div class="form-group col-12">
						<textarea class="form-control col-12" name="message" id="message" rows="5" data-rule="required" data-msg="Please write something for us." placeholder="Message"></textarea>
					</div>
			
					<div class="col-12 d-flex justify-content-center">
						<button type="button" class="btn btn-common col-6" onclick="submitForm()">Send Message</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>