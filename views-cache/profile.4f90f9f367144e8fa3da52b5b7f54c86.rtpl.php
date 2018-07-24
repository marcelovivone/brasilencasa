<?php if(!class_exists('Rain\Tpl')){exit;}?><style type="text/css">

/*
div.parents-elm{
  position: relative;
}
.blocking-span{
  display: block;
}
.blocking-span input{
  border: 1px solid #eaeaea;
  padding-top: 30px;
  padding-left: 20px;
  padding-right: 20px;
  width: 100%;
}
.floating-label{
  display: inline-block;
  font-size: 15px;
  left: 1em;
  line-height: 20px;
  position: absolute;
  top: -webkit-calc(50% - 10px);
  top: -moz-calc(50% - 10px);
  top: calc(50% - 10px);
  transition: top 0.3s ease-in-out 0s;
}
.focus-content .floating-label{
  font-size: 11px;
  top: 0.05em;
  left: 1.5em;
  all: -webkit-calc(50% - 10px);
  all: -moz-calc(50% - 10px);
  all: calc(50% - 10px);
  transition: all 0.3s ease-in-out 0s;
}
*/
</style>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->

<script>
function submitForm() {
	'use strict';

	if (!validateForm(document.getElementById('dsemail').form, true, 'dsemail', '', 'en', false)) {
		event.preventDefault();
	}
}
/*
$(function(){
  $('.blocking-span input').on('focus', function(){
    $(this).parents('.parents-elm').addClass('focus-content'); // When focus the input area
  });
  $('.blocking-span input').blur(function(e){
  	if ($(this).val() === '') {
//		if($(e.target).parents('.blocking-span input').length==0 && !$(e.target).is('.blocking-span input')){
			$('.parents-elm').removeClass('focus-content');
//		}
	}
	});
});
*/
</script>
<!--
<div class="parents-elm">
  <span class='blocking-span'>
  <input type="text" class="inputText" />
  </span>
  <span class="floating-label">Your email address</span>
</div>
-->

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
						<div class="form-group field">
							<input type="text" class="form-control" id="nmfirst" name="nmfirst" placeholder="First Name" value="<?php echo htmlspecialchars( $user["nmfirst"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
  						</div>

						<div class="form-group">
							<input type="text" class="form-control" id="nmlast" name="nmlast" placeholder="Last Name" value="<?php echo htmlspecialchars( $user["nmlast"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						</div>

						<div class="form-group">
							<input type="email" class="form-control" id="dsemail" name="dsemail" placeholder="Email Address" value="<?php echo htmlspecialchars( $user["dsemail"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
						</div>

						<div class="form-group">
							<span class="validate">
								<div class="form-check form-check-inline custom-checkbox checkbox-greensea p-1">
									<input class="form-check-input" type="radio" name="tptitle" id="mister" value="M" <?php echo htmlspecialchars( $user["tptitle"], ENT_COMPAT, 'UTF-8', FALSE ); ?> === "M" ? checked : "">
									<label class="form-check-label" for="mister">
										Mr.
									</label>
								</div>

								<div class="form-check form-check-inline custom-checkbox checkbox-greensea">
									<input class="form-check-input" type="radio" name="tptitle" id="missus" value="W" <?php echo htmlspecialchars( $user["tptitle"], ENT_COMPAT, 'UTF-8', FALSE ); ?> === "W" ? checked : "">
									<label class="form-check-label" for="missus">
										Mrs.
									</label>
								</div>
							</span>
						</div>

						<div class="form-group">
							<input type="tel" class="form-control" id="nrphone" name="nrphone" placeholder="Phone Number" value="<?php echo htmlspecialchars( $user["nrphone"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
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