<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- DOCTYPE -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>Airmail Ping</title>
	<style type="text/css">
	
	@import url(https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700);

	* {
		margin:0;
		padding:0;
		font-family: Helvetica, Arial, sans-serif;
	}

	body {
		text-align: center;
		color: #747474;
		background-color: #ffffff;
		width: 100%!important;
		height: 100%;
		-webkit-font-smoothing:antialiased;
		-webkit-text-size-adjust:none;
	}

	h2 {
		font-weight:200;
		font-size: 32px;
	}

	p {
		margin-bottom: 10px;
		font-weight: normal;
		font-size:14px;
		line-height:1.6;
	}

	a {
		color: #50d8af;
		text-decoration: none;
		-webkit-transition: 0.5s;
		-moz-transition: 0.5s;
		-o-transition: 0.5s;
		transition: 0.5s;
	}

	.head-wrap {
		max-width: 505px;
		margin: 0 auto;
		background-color: #f9f8f8;
		border-bottom: 1px solid #d8d8d8;
	}

	.head-wrap * {
		margin: 0;
		padding: 0;
	}

	.header {
		height: 35px;
		padding: 0 12px;
	}

	.header .content {
		padding: 0;
	}

	.header-background {
		background: #fff;
	}

	.header .brand h2 {
		font-family: "Montserrat", sans-serif;
		font-weight: 700;
		color: #0c2e8a;
	}

	#logo h2 {
		margin: 0;
		padding: 0;
		line-height: 1;
		font-family: "Montserrat", sans-serif;
		font-weight: 700;
	}

	#logo h2 a,
	#logo h2 {
		color: #0c2e8a;
		line-height: 1;
		display: inline-block;
		text-align: left;
	}

	#logo h2 span, 
	#logo h2 a span {
		color: #50d8af;
	}

	.body-wrap {
		width: 505px;
		margin: 0 auto;
		background-color: #ffffff;
	}

	.body-wrap .container td, .body-wrap .container div {
		font-family: Helvetica, Arial, sans-serif;
		text-align: center;
	}

	.body .body-padded {
		padding: 14px 10px 0;
	}

	.body-padded,
	.body-title {
		text-align: left;
	}

	.body .body-title {
		font-weight: bold;
		font-size: 17px;
		color: #464646;
	}

	.body .body-text .body-text-cell {
		text-align: left;
		font-size: 14px;
		line-height: 1.6;
		padding: 4px 0 7px;
	}

	.body .body-text-cell a {
		color: #464646;
		text-decoration: underline;
	}

	.body .body-signature-block .body-signature-cell {
		padding: 5px 0;
		text-align: left;
	}

	.container {
		display: block !important;
		margin: 0 auto !important;
		width: 100% !important;
		clear: both !important;
	}

	.content {
		display: block;
		width: 100%;
		padding: 0;
		margin: 0 auto;
	}

	.content table {
		width: 100%;
	}

	table.full-width-gmail-android {
		width: 100% !important;
	}
	
	.btn-link {
		display: inline-block;
		font-family: "Raleway", sans-serif;
		font-size: 15px;
		font-weight: bold;
		letter-spacing: 1px;
		text-align:center;
		text-decoration: none;
		text-shadow: -1px -1px #47A54B;
		line-height: 38px;
		color: #fff !important;
		background-color: #50d8af;
		width: 240px;
		border: 1px solid #fff;
		border-radius: 4px;
		margin: 10px 0;
		-webkit-text-size-adjust: none;
		mso-hide: all;
	}

	</style>

	<style type="text/css" media="only screen">

	@media only screen {
		table[class*="head-wrap"],
		table[class*="body-wrap"] {
			width: 100% !important;
		}

		td[class*="container"] {
			margin: 0 auto !important;
		}
	}

	@media only screen and (max-width: 505px) {
		*[class*="w320"] {
			width: 320px !important;
		}

		#logo h2 {
			font-size: 20px;
			padding-top: 7px;
		}

		#logo img {
			max-height: 40px;
		}

		.soapbox-title {
			font-size: 16px;
			color: #0c2e8a;
			text-align: right;
			padding-top: 0px;
			padding-right: 12px;
		}
	}

	@media (min-width: 506px) {
		.soapbox-title {
			font-size: 21px;
			color: #0c2e8a;
			text-align: right;
			padding-top: 4px;
			padding-right: 12px;
		}
	}
	
	</style>
</head>

<body>
	<div align="center">
		<table class="head-wrap w320 full-width-gmail-android" bgcolor="#d1ecf1" cellpadding="0" cellspacing="0" border="0">
			<tr class="header-background">
				<td class="header container">
					<div class="content">
						<span class="brand">
							<a id="logo" href="#"><h2>br-<span>casa</span></h2></a>
						</span>
					</div>
				</td>
				<td class="soapbox-title">
						Password Assistance
				</td>
			</tr>
		</table>

		<table class="body-wrap w320">
			<tr>
				<td class="container">
					<div class="content">
						<table class="body">
							<tr>
								<td class="body-padded">
									<table class="body-text">
										<tr>
											<td class="body-text-cell">
												Hello, <?php echo htmlspecialchars( $name, ENT_COMPAT, 'UTF-8', FALSE ); ?>.
											</td>
										</tr>

										<tr>
											<td class="body-text-cell">
												Brasil en Casa takes your account security very seriously. Brasil en Casa will never email you and ask you to disclose or verify your Brasil en Casa password, credit card, or banking account number. If you receive a suspicious email with a link to update your account information, do not click on the link. Instead, report the email to Brasil en Casa for investigation.
											</td>
										</tr>

										<tr>
											<td class="body-text-cell">
												To reset your password, click on the button below.
											</td>
										</tr>

									</table>

									<div>
                        		<a class="btn-link" href="<?php echo htmlspecialchars( $link, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                        			Redefine Password
                        		</a>
									</div>

									<table class="body-signature-block">
										<tr>
											<td class="body-signature-cell">
												<p>We hope to see you again soon!</p>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
	</div>
</body>
</html>
