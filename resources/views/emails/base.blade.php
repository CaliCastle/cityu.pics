<html lang="{{ app()->getLocale() }}">
<head>
	<meta http-equiv="Content-Type" content="text/html;" charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>@yield('title')</title>
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css?family=Raleway:300,400,700,800');

		a {
			text-decoration: underline;
			color: #3f7baf;
			font-weight: 700;
		}
		
		.fadeInDown {
			animation-name: fadeInDown;
			-webkit-animation-name: fadeInDown;
			animation-duration: 1.2s;
			-webkit-animation-duration: 1.2s;
		}
		@keyframes fadeInDown {
			0% {opacity: 0;transform: translateY(30px);}
			40% {opacity: 0;transform: translateY(30px);}
			100% {opacity: 1;transform: translateY(0);}
		}
		@-webkit-keyframes fadeInDown {
			0% {opacity: 0;-webkit-transform: translateY(30px);}
			40% {opacity: 0;-webkit-transform: translateY(30px);}
			100% {opacity: 1;-webkit-transform: translateY(0);}
		}

		@media only screen and (-webkit-min-device-pixel-ratio: 1) {
			table[id="container"] {
				width: 800px !important;
				height: 400px !important;
				position: relative;
				text-align: left;
				display: block;
				overflow: hidden;
				background: url({{ asset('images/feed-screenshot.jpg') }}) top center no-repeat;
				background-size: cover;
			}

			table[class="canvas"] {
				width: 800px !important;
				height: 400px !important;
			}

			table[class="canvas"] {
				display: block;
				position: absolute;
				top: 0;
				left: 0;
				width: 800px;
				height: 400px;
				background-color: rgba(150, 150, 150, 0.75);
			}
		}

		@media only screen and (-webkit-min-device-pixel-ratio: 0) and (min-width: 800px) {
			td[id="builder-bg"] {
				background-image: url('{{ asset('images/feed-screenshot.jpg') }}') !important;
				background-position: top left;
				background-repeat: no-repeat;
				background-size: cover;
				height: 400px;
				overflow: hidden;
				display: block !important;
			}

			td[class="webkit-hide"] {
				display: none !important;
			}

			div[class="gmail-hide"] {
				height: 400px !important;
				width: 800px !important;
				max-width: none !important;
				max-height: none !important;
			}

			input[type=checkbox] {
				position: absolute;
				top: -9999px;
				left: -9999px;
				opacity: 0;
			}

			label {
				cursor: pointer;
				z-index: 4;
				display: block;
				position: relative;
				background-color: #d75742;
				color: #ffffff;
				line-height: 25px;
				text-align: center;
				font-size: 16px;
				text-decoration: none;
			}
		}

		@media screen and (max-width: 800px) {
			table[class="responsive-table"] {
				width: 100% !important;
				height: auto !important;
			}

			table[class="responsive-quote"] {
				width: 100% !important;
				height: auto !important;
				margin: 8px 0 !important;
				display: block !important;
			}

			td[class="responsive-table"] {
				width: 100% !important;
			}

			table[class="hide-table"] {
				display: none !important;
			}

			td[class="no-pad"] {
				padding: 0 !important;
			}

			td[class="section-padding"] {
				padding: 35px 5% !important;
			}

			td[class="section-padding2"] {
				padding: 35px 5% 0 5% !important;
			}

			td[class="responsive-carver"] {
				padding: 25px 25px 125px 25px !important;
			}

			td[class="hide-table"] {
				display: none !important;
			}

			td[class="text-center"] {
				text-align: center !important;
			}

			table[class="mobile-pad"] {
				margin: 15px 0 !important;
			}

			td[class="outlook-padding"] {
				padding: 0 !important;
			}

			td[class="webkit-hide"] {
				width: 100% !important;
				height: auto !important;
			}

			td[class="table-hide"] {
				display: none !important;
			}

			img[class="img-max"] {
				max-width: 100% !important;
				width: 100% !important;
				height: auto !important;
			}

			img[class="hero-shot"] {
				max-width: 100% !important;
				width: 100% !important;
				height: auto !important;
			}

			td[class="mobile-hide"] {
				display: none !important;
			}
		}

		@media screen and (max-width: 480px) {
			td[class="ben-top-quote"] {
				padding-top: 25px !important;
			}

			td[class="responsive-carver"] {
				padding-bottom: 225px !important;
			}

			a[class="cta"] {
				font-size: 16px !important;
				padding: 20px 25px !important;
			}

			td[class="pbot15"] {
				padding-bottom: 15px !important;
			}

			br[class="mobile-hide"] {
				display: none !important;
			}
		}
	</style>
	<!-- OUTLOOK 07-13 SPECIFIC CSS -->
	<!--[if gte mso 9]>
	<style type="text/css">
		.outlook-padding {
			padding: 0 10px !important;
		}

		.table-hide {
			display: none !important;
			mso-hide: all !important;
		}
	</style>
	<![endif]-->
</head>
<body bgcolor="#f6f8f8"
      style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; min-width: 100%; font-family: Raleway, PingFang SC, Helvetica Neue, sans-serif; margin: 0; padding: 0; background-color: #f6f8f8; width: 100%;">


<!-- HEADER, LOGO -->
<table border="0" cellpadding="0" cellspacing="0" width="100%"
       style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; table-layout: fixed; border-collapse: collapse;"
       class="responsive-table">
	<tr>
		<td bgcolor="#0b3152"
		    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
			<!-- PREHEADER -->
			<div align="center" style="padding: 20px;">
				<table border="0" cellpadding="0" cellspacing="0" width="700" class="responsive-table"
				       style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse;">
					<!-- LOGO + LINKS -->
					<tr>
						<td style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; padding: 0;">
							<table border="0" cellpadding="0" cellspacing="0" width="100%"
							       style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse;">
								<tr>
									<td bgcolor="#0b3152" align="center" width="100%"
									    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
										<a href="{{ url('/') }}"
										   style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;"><img
													alt="{{ config('app.name') }}" src="{{ asset('logo-light.png') }}"
													width="50"
													style="-ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; color: #ca4a45; font-size: 16px;"
													border="0"></a></td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</td>
	</tr>
</table>

<!-- HERO SECTION -->
<table width="100%"
       style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; margin: 0 auto; table-layout: fixed; border-collapse: collapse;"
       border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center"
		    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #555555 url({{ asset('images/cityu-background.jpg') }}) top center no-repeat; background-size: cover; padding-top: 70px; overflow: hidden;"
		    background="{{ asset('images/cityu-background.jpg') }}" bgcolor="#555555" class="section-padding2">
			<table cellpadding="0" cellspacing="0" align="center" width="100%" border="0"
			       style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; table-layout: fixed; margin: 0 auto; border-collapse: collapse;">
				<tr>
					<td align="center"
					    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
						<table cellpadding="0" cellspacing="0" align="center" width="800" border="0"
						       class="responsive-table"
						       style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse;">
							<tr>
								<td align="center"
								    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
									<table cellpadding="0" cellspacing="0" align="center" width="100%"
									       style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; table-layout: fixed; margin: 0 auto; border-collapse: collapse;"
									       border="0">
										<tr>
											<td align="center"
											    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-family: 'Raleway', Helvetica, Arial, sans-serif; font-size: 36px; line-height: 36px; font-weight: bold; color: #ffffff;"
											    colspan="2">@yield('heading')<br>&nbsp;
											</td>
										</tr>
										<tr>
											<td align="center" class="table-hide"
											    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
												<!-- HIDE IN GMAIL BY DEFAULT -->
												<div style="width: 0px; max-width: 0px; height: 0px; max-width: 0px; overflow: hidden; display: block; margin: 0;"
												     class="gmail-hide">
													<div class="fadeInDown"
													     style="animation-name: fadeInDown; -webkit-animation-name: fadeInDown; animation-duration: 1.2s; -webkit-animation-duration: 1.2s;">
														<table width="100%" cellpadding="0" cellspacing="0" border="0"
														       class="table-hide"
														       style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse;">
															<tr>
																<td align="center" valign="top"
																    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
																	<table id="container" width="800" bgcolor="#fffffe"
																	       cellpadding="0" cellspacing="0"
																	       class="table-hide"
																	       background="url({{ asset('images/feed-screenshot.jpg') }})"
																	       style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse;background: url({{ asset('images/feed-screenshot.jpg') }}) no-repeat top center;background-size: cover;">
																	</table>
																</td>
															</tr>
														</table>
													</div>
												</div>
											</td>
										</tr>
										<!-- NON-WEBKIT HERO IMAGE -->
										<tr>
											<td colspan="2" width="800" class="table-hide" align="center"
											    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
												<a href="{{ url('/feed') }}" target="_blank"
												   style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;"><img
															src="{{ asset('images/feed-screenshot.jpg') }}" width="800"
															height="461" class="hero-shot"
															style="-ms-interpolation-mode: bicubic; border: 0; line-height: 100%; outline: none; text-decoration: none; width: 800px; height: 461px; display: block; color: #ffffff; font-size: 20px;"
															alt="CityU Pics" border="0"></a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" border="0"
       style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; undefined: table-layout-fixed; border-collapse: collapse;"
       class="responsive-table">
	<tr>
		<td align="center" bgcolor="#f6f8f8"
		    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; padding: 70px 0;"
		    class="section-padding">
			<table width="750" cellspacing="0" cellpadding="0" border="0" class="responsive-table"
			       style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse;">
				<tr>
					<td align="left"
					    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-size: 24px; font-family: 'Raleway', Helvetica, Arial, sans-serif; padding: 0 0 12px 0; color: #514e4c;">
						Hi, {{ $user->name }}
					</td>
				</tr>
				<tr>
					<td align="left"
					    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
						<table cellspacing="0" cellpadding="0" border="0" class="responsive-table" width="100%"
						       style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse;">
							<tr>
								<td align="left"
								    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-size: 16px; line-height: 20px; font-family: 'Raleway', Helvetica, Arial, sans-serif; padding: 50px 0 0 0; color: #7b8186;">
									@yield('message')
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<!-- FOOTER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%"
       style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; table-layout: fixed; border-collapse: collapse;">
	<tr>
		<td bgcolor="#f6f8f8" align="center"
		    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"
			       style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse;">
				<tr>
					<td style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; padding: 0 0 20px 0;"
					    align="center" class="section-padding">
						<table width="600" border="0" cellspacing="0" cellpadding="0" align="center"
						       class="responsive-table"
						       style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse;">
							<tr>
								<td align="center" valign="middle"
								    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-size: 13px; line-height: 18px; font-family: 'Raleway', Helvetica, Arial, sans-serif; color: #999999;">
									<a href="{{ url('/') }}" target="_blank"
									   style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;"><img
												src="{{ asset('logo.png') }}" width="30" height="30" border="0"
												style="-ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; display: block;"
												alt="Logo"></a>
								</td>
							</tr>
							<tr>
								<td align="center" valign="middle"
								    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-size: 13px; line-height: 18px; font-family: 'Raleway', Helvetica, Arial, sans-serif; color: #999999; padding-top: 15px;">
									<a href="{{ url('/') }}" target="_blank"
									   style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; color: #999999;text-decoration: none;">&copy; {{ date('Y') }}
										- CityU Pics</a>
									<br>
									<p>@lang('messages.email.base.sent-from') CityU Pics</p>
								</td>
							</tr>
							<tr>
								<td align="center"
								    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-size: 13px; line-height: 18px; font-family: 'Raleway', Helvetica, Arial, sans-serif; color: #999999; padding-top: 25px;"
								    class="block-padding">
									@lang('messages.email.base.unsubscribe-tips')
									<a href="{{ url('/settings#privacy') }}" style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; color: #999999;">@lang('messages.email.base.unsubscribe')</a>.
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</body>
</html>