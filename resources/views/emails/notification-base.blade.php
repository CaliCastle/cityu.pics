<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="{{ app()->getLocale() }}">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="robots" content="noindex, nofollow">
	<link href='https://fonts.googleapis.com/css?family=Raleway:300,600,800' rel='stylesheet' type='text/css'>

	<title>@yield('title')</title>

	<style type="text/css">
		@import url(https://fonts.googleapis.com/css?family=Raleway:300,600,800);
		body, table, td, a{-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;}
		table, td{mso-table-lspace: 0pt; mso-table-rspace: 0pt;}
		img{border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
		table{border-collapse: collapse !important;}
		body{font-family: 'Raleway', Arial, sans-serif; height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important;}
		div[style*="margin: 16px 0;"] { margin:0 !important; }
		a[x-apple-data-detectors] {
			color: inherit !important;
			text-decoration: none !important;
			font-size: inherit !important;
			font-family: inherit !important;
			font-weight: inherit !important;
			line-height: inherit !important;
		}
	</style>

	<!--[if mso]>
	<style type="text/css">
		.body-text {
			font-family: Arial, sans-serif !important;
		}
	</style>
	<![endif]-->

</head>
<body style="margin:0; padding:0;">
<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#F1F1F1">
	<tr>
		<td width="100%" valign="top" align="center">

			<center>
				<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">

					<!-- START HERO -->
					<tr>
						<td align="center" height="100%" valign="top" width="100%">
							<!--[if (gte mso 9)|(IE)]>
							<table align="center" border="0" cellspacing="0" cellpadding="0" width="660">
								<tr>
									<td align="center" valign="top" width="660">
							<![endif]-->
							<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;">
								<tr>
									<td background="{{ asset('images/cityu-background.jpg') }}" bgcolor="#222222" width="660" height="442" valign="top" style="background-position: top center;background-size: cover">
										<!--[if gte mso 9]>
										<v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="width:600px;height:442px;">
											<v:fill type="tile" src="hero.png" color="#FFFFFF" />
											<v:textbox inset="0,0,0,0">
										<![endif]-->
										<div>
											<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
												<tr>
													<td align="center" height="100%" valign="top" width="100%" style="padding:0 20px;">
														<!--[if (gte mso 9)|(IE)]>
														<table align="center" border="0" cellspacing="0" cellpadding="0" width="660">
															<tr>
																<td align="center" valign="top" width="660">
														<![endif]-->
														<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;">
															<tr>
																<td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
															</tr>
															<tr>
																<td align="center" valign="top">
																	<a href="{{ url('/') }}" target="_blank"><img src="{{ asset('logo-light.png') }}" width="57" height="13" style="margin:0; padding:0; border:none; display:block;" border="0" alt="Logo"></a>
																</td>
															</tr>
															<tr>
																<td height="35" style="font-size: 35px; line-height: 35px;">&nbsp;</td>
															</tr>
															<tr>
																<td align="center">
																	<table width="300" cellpadding="0" cellspacing="0" border="0">
																		<tr>
																			<td width="75" align="center" class="body-text">
																				<a href="{{ url('feed') }}" target="_blank" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#ffffff; text-decoration:none;" class="body-text">@lang('messages.titles.feed')</a>
																			</td>
																			<td width="75" align="center" class="body-text">
																				<a href="{{ url('about') }}" target="_blank" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#ffffff; text-decoration:none;" class="body-text">@lang('messages.footer.info.about')</a>
																			</td>
																			<td width="75" align="center" class="body-text">
																				<a href="{{ url('contribute') }}" target="_blank" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#ffffff; text-decoration:none;" class="body-text">@lang('messages.footer.dev.contribute')</a>
																			</td>
																			<td width="75" align="center" class="body-text">
																				<a href="{{ url('/login') }}" target="_blank" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#26a4d3; text-decoration:none;" class="body-text">@lang('auth.login')</a>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr>
																<td height="60" style="font-size: 60px; line-height: 60px;">&nbsp;</td>
															</tr>
															<tr>
																<td align="center" style="font-family: 'Raleway', Arial, sans-serif; font-size:30px; line-height:36px; font-weight:bold; color:#ffffff; text-transform:uppercase;" class="body-text">
																	<h1 style="font-family: 'Raleway', Arial, sans-serif; font-size:30px; line-height:36px; font-weight:bold; color:#ffffff; text-transform:uppercase; padding:0; margin:0;" class="body-text">Latest Updates</h1>
																</td>
															</tr>
															<tr>
																<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
															</tr>
															<tr>
																<td align="center">
																	<table cellpadding="0" cellspacing="0" border="0">
																		<tr>
																			<td class="mobile" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#757575;" align="center" class="body-text">
																				<p style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#d0d0d0; padding:0; margin:0;" align="center" class="body-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet nulla
																					quis risus porttitor molestie. Nunc est nunc, fringilla sit amet tempus ac.
																				</p>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr>
																<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
															</tr>
															<tr>
																<td align="center">
																	<table border="0" cellspacing="0" cellpadding="0" align="center">
																		<tr>
																			<td>
																				<table border="0" cellspacing="0" cellpadding="0" align="center">
																					<tr>
																						<td align="center" style="-webkit-border-radius: 50px; -moz-border-radius: 50px; border-radius: 50px;" bgcolor="#26a4d3" class="body-text">
																							<a href="https://litmus.com" target="_blank" style="font-size: 14px; font-family: 'Raleway', Arial, sans-serif; color: #ffffff; text-decoration: none; text-decoration: none; border-radius: 50px; padding: 12px 22px; border: 1px solid #26a4d3; display: inline-block; text-transform:uppercase; font-weight:bold;" class="body-text">View Updates</a>
																						</td>
																					</tr>
																				</table>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr>
																<td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
															</tr>
														</table>
														<!--[if (gte mso 9)|(IE)]>
														</td>
														</tr>
														</table>
														<![endif]-->
													</td>
												</tr>
											</table>
										</div>
										<!--[if gte mso 9]>
										</v:textbox>
										</v:rect>
										<![endif]-->
									</td>
								</tr>
							</table>
							<!--[if (gte mso 9)|(IE)]>
							</td>
							</tr>
							</table>
							<![endif]-->
						</td>
					</tr>
					<!-- END HERO -->

					<!-- START INTRO -->
					<tr>
						<td>
							<table cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" width="100%" style="max-width: 660px;" align="center">
								<tr>
									<td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
								</tr>
								<tr>
									<td align="left" valign="top" style="font-family: 'Raleway', Arial, sans-serif; font-size:20px; line-height:26px; color:#222222; font-weight:bold; text-transform:uppercase;" class="body-text">
										<h2 style="font-family: 'Raleway', Arial, sans-serif; font-size:20px; line-height:26px; color:#222222; font-weight:bold; text-transform:uppercase; padding:0 20px; margin:0;" class="body-text">We've made some new updates to our system</h2>
									</td>
								</tr>
								<tr>
									<td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
								</tr>
								<tr>
									<td align="left" valign="top" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#222222; font-weight:bold;" class="body-text">
										<p style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:24px; color:#222222; font-weight:bold; padding:0 20px; margin:0;" class="body-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet nulla titor molestie. Nunc est nunc, fringilla sit amet tempus ac, sollicitudin non as at odio scelerisque mauris tempus efficitur. Phasellus ac turpis justo.</p>
									</td>
								</tr>
								<tr>
									<td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
								</tr>
								<tr>
									<td align="left" valign="top" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#666666;" class="body-text">
										<p style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:24px; color:#666666; padding:0 20px; margin:0;" class="body-text">Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilmus vitae molestie libero, commodo suscipit quam. Donec et ipsum velit. tis nulla. In non dui nec enim imperdiet mattis.</p>
									</td>
								</tr>
								<tr>
									<td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
								</tr>
								<tr>
									<td align="left" valign="top" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#666666;" class="body-text">
										<p style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:24px; color:#666666; padding:0 20px; margin:0;" class="body-text">Yours sincerely,</p>
									</td>
								</tr>
								<tr>
									<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
								</tr>
								<tr>
									<td align="left" style="padding:0 20px;">
										<table width="190">
											<tr>
												<td width="70">
													<img src="profile-picture.png" width="62" height="62" style="margin:0; padding:0; border:none; display:block;" border="0" alt="">
												</td>
												<td width="120">
													<table width="" cellpadding="0" cellspacing="0" border="0">
														<tr>
															<td align="left" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#222222; font-weight:bold;" class="body-text">
																<p style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#222222; font-weight:bold; padding:0; margin:0;" class="body-text">Anna Bella</p>
															</td>
														</tr>
														<tr>
															<td align="left" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#666666;" class="body-text">
																<p style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#666666; padding:0; margin:0;" class="body-text">CEO | Vision</p>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
											</tr>
										</table>
									</td>
								</tr>
								<!-- END INTRO -->

								<!-- START FEATURE ROW 1 -->
								<tr>
									<td align="center" height="100%" valign="top" width="100%">
										<!--[if mso]>
										<table align="center" border="0" cellspacing="0" cellpadding="0" width="660">
											<tr>
												<td align="center" valign="top" width="660">
										<![endif]-->
										<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;" bgcolor="#292828">
											<tr>
												<td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
											</tr>
											<tr>
												<td align="center" valign="top" style="font-size:0;">
													<!--// DEVELOPER NOTES:
													  1. Setting font-size:0; is necessary to ensure
														 that there is no extra spacing introduced
														 between the centering divs that wrap each
														 of the columns. //-->

													<!--[if mso]>
													<table align="center" border="0" cellspacing="0" cellpadding="0" width="660">
														<tr>
															<td align="left" valign="top" width="330">
													<![endif]-->
													<div style="display:inline-block; max-width:330px; vertical-align:top; width:100%;">
														<!--// DEVELOPER NOTES:
														  1. To have each column center upon stacking,
															 wrap them in individual divs, set the same
															 max-width and width as the table within it,
															 and set display to inline-block; using
															 vertical-align is optional. //-->

														<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:330px;">
															<tr>
																<td align="center" valign="top">

																	<table width="280" cellpadding="0" cellspacing="0" border="0">
																		<tr>
																			<td width="40">
																				<img src="icon-1.png" width="" height="" style="margin:0; padding:0; border:none; display:block;" border="0" class="center" alt="Vision">
																			</td>
																			<td width="240" align="left" class="mobile" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#ffffff; padding:0; margin:0; text-transform:uppercase; font-weight:bold;" class="body-text">
																				Feature #1
																			</td>
																		</tr>
																	</table>
																	<table width="280" cellpadding="0" cellspacing="0" border="0">
																		<tr>
																			<td width="40">
																				&nbsp;
																			</td>
																			<td width="240" align="left" class="mobile" style="font-family: 'Raleway', Arial, sans-serif; font-size:12px; line-height:18px; color:#666666; padding:0; margin:0;" class="body-text">
																				Lorem ipsum dolor sit amet, consectetur adipis
																			</td>
																		</tr>
																	</table>

																</td>
															</tr>
															<tr>
																<td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
															</tr>
														</table>
													</div>
													<!--[if mso]>
													</td>
													<td align="left" valign="top" width="330">
													<![endif]-->
													<div style="display:inline-block; max-width:330px; vertical-align:top; width:100%;">
														<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:330px;">
															<tr>
																<td align="center" valign="top">

																	<table width="280" cellpadding="0" cellspacing="0" border="0">
																		<tr>
																			<td width="40">
																				<img src="icon-2.png" width="" height="" style="margin:0; padding:0; border:none; display:block;" border="0" class="center" alt="Vision">
																			</td>
																			<td width="240" align="left" class="mobile" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#ffffff; padding:0; margin:0; text-transform:uppercase; font-weight:bold;" class="body-text">
																				Feature #2
																			</td>
																		</tr>
																	</table>
																	<table width="280" cellpadding="0" cellspacing="0" border="0">
																		<tr>
																			<td width="40">
																				&nbsp;
																			</td>
																			<td width="240" align="left" class="mobile" style="font-family: 'Raleway', Arial, sans-serif; font-size:12px; line-height:18px; color:#666666; padding:0; margin:0;" class="body-text">
																				Lorem ipsum dolor sit amet, consectetur adipis
																			</td>
																		</tr>
																	</table>

																</td>
															</tr>
														</table>
													</div>
													<!--[if mso]>
													</td>
													</tr>
													</table>
													<![endif]-->
												</td>
											</tr>
											<tr>
												<td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
											</tr>
										</table>
										<!--[if mso]>
										</td>
										</tr>
										</table>
										<![endif]-->
									</td>
								</tr>
								<!-- END FEATURE ROW 1 -->

								<!-- START FEATURE ROW 2 -->
								<tr>
									<td align="center" height="100%" valign="top" width="100%">
										<!--[if mso]>
										<table align="center" border="0" cellspacing="0" cellpadding="0" width="660">
											<tr>
												<td align="center" valign="top" width="660">
										<![endif]-->
										<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;" bgcolor="#292828">
											<tr>
												<td align="center" valign="top" style="font-size:0;">
													<!--// DEVELOPER NOTES:
													  1. Setting font-size:0; is necessary to ensure
														 that there is no extra spacing introduced
														 between the centering divs that wrap each
														 of the columns. //-->

													<!--[if mso]>
													<table align="center" border="0" cellspacing="0" cellpadding="0" width="660">
														<tr>
															<td align="left" valign="top" width="330">
													<![endif]-->
													<div style="display:inline-block; max-width:330px; vertical-align:top; width:100%;">
														<!--// DEVELOPER NOTES:
														  1. To have each column center upon stacking,
															 wrap them in individual divs, set the same
															 max-width and width as the table within it,
															 and set display to inline-block; using
															 vertical-align is optional. //-->

														<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:330px;">
															<tr>
																<td align="center" valign="top">

																	<table width="280" cellpadding="0" cellspacing="0" border="0">
																		<tr>
																			<td width="40">
																				<img src="icon-3.png" width="" height="" style="margin:0; padding:0; border:none; display:block;" border="0" class="center" alt="Vision">
																			</td>
																			<td width="240" align="left" class="mobile" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#ffffff; padding:0; margin:0; text-transform:uppercase; font-weight:bold;" class="body-text">
																				Feature #3
																			</td>
																		</tr>
																	</table>
																	<table width="280" cellpadding="0" cellspacing="0" border="0">
																		<tr>
																			<td width="40">
																				&nbsp;
																			</td>
																			<td width="240" align="left" class="mobile" style="font-family: 'Raleway', Arial, sans-serif; font-size:12px; line-height:18px; color:#666666; padding:0; margin:0;" class="body-text">
																				Lorem ipsum dolor sit amet, consectetur adipis
																			</td>
																		</tr>
																	</table>

																</td>
															</tr>
															<tr>
																<td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
															</tr>
														</table>
													</div>
													<!--[if mso]>
													</td>
													<td align="left" valign="top" width="330">
													<![endif]-->
													<div style="display:inline-block; max-width:330px; vertical-align:top; width:100%;">
														<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:330px;">
															<tr>
																<td align="center" valign="top">

																	<table width="280" cellpadding="0" cellspacing="0" border="0">
																		<tr>
																			<td width="40">
																				<img src="icon-4.png" width="" height="" style="margin:0; padding:0; border:none; display:block;" border="0" class="center" alt="Vision">
																			</td>
																			<td width="240" align="left" class="mobile" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#ffffff; padding:0; margin:0; text-transform:uppercase; font-weight:bold;" class="body-text">
																				Feature #4
																			</td>
																		</tr>
																	</table>
																	<table width="280" cellpadding="0" cellspacing="0" border="0">
																		<tr>
																			<td width="40">
																				&nbsp;
																			</td>
																			<td width="240" align="left" class="mobile" style="font-family: 'Raleway', Arial, sans-serif; font-size:12px; line-height:18px; color:#666666; padding:0; margin:0;" class="body-text">
																				Lorem ipsum dolor sit amet, consectetur adipis
																			</td>
																		</tr>
																	</table>

																</td>
															</tr>
														</table>
													</div>
													<!--[if mso]>
													</td>
													</tr>
													</table>
													<![endif]-->
												</td>
											</tr>
											<tr>
												<td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
											</tr>
										</table>
										<!--[if mso]>
										</td>
										</tr>
										</table>
										<![endif]-->
									</td>
								</tr>
								<!-- END FEATURE ROW 2 -->

								<!-- START BLOG 1 -->
								<tr>
									<td align="center" height="100%" valign="top" width="100%">
										<!--[if mso]>
										<table align="center" border="0" cellspacing="0" cellpadding="0" width="660">
											<tr>
												<td align="center" valign="top" width="660">
										<![endif]-->
										<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;" bgcolor="#f7fafc">
											<tr>
												<td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
											</tr>
											<tr>
												<td align="center" valign="top" style="font-size:0;">
													<!--// DEVELOPER NOTES:
													  1. Setting font-size:0; is necessary to ensure
														 that there is no extra spacing introduced
														 between the centering divs that wrap each
														 of the columns. //-->

													<!--[if mso]>
													<table align="center" border="0" cellspacing="0" cellpadding="0" width="660">
														<tr>
															<td align="left" valign="top" width="330">
													<![endif]-->
													<div style="display:inline-block; max-width:330px; vertical-align:top; width:100%;">
														<!--// DEVELOPER NOTES:
														  1. To have each column center upon stacking,
															 wrap them in individual divs, set the same
															 max-width and width as the table within it,
															 and set display to inline-block; using
															 vertical-align is optional. //-->

														<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:330px;">
															<tr>
																<td align="center" valign="top">

																	<img src="update-1.png" width="" height="" style="margin:0; padding:0; border:none; display:block; color:; font-size:" border="0" class="image" alt="">

																</td>
															</tr>
															<tr>
																<td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
															</tr>
														</table>
													</div>
													<!--[if mso]>
													</td>
													<td align="left" valign="top" width="330">
													<![endif]-->
													<div style="display:inline-block; max-width:330px; vertical-align:top; width:100%;">
														<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:330px;">
															<tr>
																<td align="center" valign="top">

																	<table cellpadding="0" cellspacing="0" border="0" width="260">
																		<tr>
																			<td align="left" class="mobile" style="font-family: 'Raleway', Arial, sans-serif; font-size:18px; line-height:24px; color:#222222; padding:0; margin:0; text-transform:uppercase; font-weight:bold;" class="body-text">
																				Blog Post #1
																			</td>
																		</tr>
																		<tr>
																			<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
																		</tr>
																		<tr>
																			<td align="left" class="mobile" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:22px; color:#666666; padding:0; margin:0;" class="body-text">
																				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet nulla titor molestie. Nunc est nunc, fringilla sit amet tempus ac,
																			</td>
																		</tr>
																		<tr>
																			<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
																		</tr>
																		<tr>
																			<td align="center">
																				<table border="0" cellspacing="0" cellpadding="0" align="left">
																					<tr>
																						<td>
																							<table border="0" cellspacing="0" cellpadding="0" align="center">
																								<tr>
																									<td align="center" style="-webkit-border-radius: 50px; -moz-border-radius: 50px; border-radius: 50px;" bgcolor="#26a4d3" class="body-text">
																										<a href="https://litmus.com" target="_blank" style="font-size: 14px; font-family: 'Raleway', Arial, sans-serif; color: #ffffff; text-decoration: none; text-decoration: none; border-radius: 50px; padding: 12px 22px; border: 1px solid #26a4d3; display: inline-block; text-transform:uppercase; font-weight:bold;" class="body-text">Read More</a>
																									</td>
																								</tr>
																							</table>
																						</td>
																					</tr>
																				</table>
																			</td>
																		</tr>
																		<tr>
																			<td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
																		</tr>
																	</table>

																</td>
															</tr>
														</table>
													</div>
													<!--[if mso]>
													</td>
													</tr>
													</table>
													<![endif]-->
												</td>
											</tr>
											<tr>
												<td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
											</tr>
										</table>
										<!--[if mso]>
										</td>
										</tr>
										</table>
										<![endif]-->
									</td>
								</tr>
								<!-- END BLOG 1 -->

								<!-- START BLOG 2 -->
								<tr>
									<td align="center" height="100%" valign="top" width="100%">
										<!--[if mso]>
										<table align="center" border="0" cellspacing="0" cellpadding="0" width="660">
											<tr>
												<td align="center" valign="top" width="660">
										<![endif]-->
										<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;" bgcolor="#ffffff">
											<tr>
												<td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
											</tr>
											<tr>
												<td align="center" valign="top" style="font-size:0;">
													<!--// DEVELOPER NOTES:
													  1. Setting font-size:0; is necessary to ensure
														 that there is no extra spacing introduced
														 between the centering divs that wrap each
														 of the columns. //-->

													<!--[if mso]>
													<table align="center" border="0" cellspacing="0" cellpadding="0" width="660">
														<tr>
															<td align="left" valign="top" width="330">
													<![endif]-->
													<div style="display:inline-block; max-width:330px; vertical-align:top; width:100%;">
														<!--// DEVELOPER NOTES:
														  1. To have each column center upon stacking,
															 wrap them in individual divs, set the same
															 max-width and width as the table within it,
															 and set display to inline-block; using
															 vertical-align is optional. //-->

														<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:330px;">
															<tr>
																<td align="center" valign="top">

																	<img src="update-2.png" width="" height="" style="margin:0; padding:0; border:none; display:block; color:; font-size:" border="0" class="image" alt="">

																</td>
															</tr>
															<tr>
																<td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
															</tr>
														</table>
													</div>
													<!--[if mso]>
													</td>
													<td align="left" valign="top" width="330">
													<![endif]-->
													<div style="display:inline-block; max-width:330px; vertical-align:top; width:100%;">
														<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:330px;">
															<tr>
																<td align="center" valign="top">

																	<table cellpadding="0" cellspacing="0" border="0" width="260">
																		<tr>
																			<td align="left" class="mobile" style="font-family: 'Raleway', Arial, sans-serif; font-size:18px; line-height:24px; color:#222222; padding:0; margin:0; text-transform:uppercase; font-weight:bold;" class="body-text">
																				Blog Post #2
																			</td>
																		</tr>
																		<tr>
																			<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
																		</tr>
																		<tr>
																			<td align="left" class="mobile" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:22px; color:#666666; padding:0; margin:0;" class="body-text">
																				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet nulla titor molestie. Nunc est nunc, fringilla sit amet tempus ac,
																			</td>
																		</tr>
																		<tr>
																			<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
																		</tr>
																		<tr>
																			<td align="center">
																				<table border="0" cellspacing="0" cellpadding="0" align="left">
																					<tr>
																						<td>
																							<table border="0" cellspacing="0" cellpadding="0" align="center">
																								<tr>
																									<td align="center" style="-webkit-border-radius: 50px; -moz-border-radius: 50px; border-radius: 50px;" bgcolor="#26a4d3" class="body-text">
																										<a href="https://litmus.com" target="_blank" style="font-size: 14px; font-family: 'Raleway', Arial, sans-serif; color: #ffffff; text-decoration: none; text-decoration: none; border-radius: 50px; padding: 12px 22px; border: 1px solid #26a4d3; display: inline-block; text-transform:uppercase; font-weight:bold;" class="body-text">Read More</a>
																									</td>
																								</tr>
																							</table>
																						</td>
																					</tr>
																				</table>
																			</td>
																		</tr>
																		<tr>
																			<td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
																		</tr>
																	</table>

																</td>
															</tr>
														</table>
													</div>
													<!--[if mso]>
													</td>
													</tr>
													</table>
													<![endif]-->
												</td>
											</tr>
											<tr>
												<td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
											</tr>
										</table>
										<!--[if mso]>
										</td>
										</tr>
										</table>
										<![endif]-->
									</td>
								</tr>
								<!-- END BLOG 2 -->

								<!-- START CTA -->
								<tr>
									<td align="center" height="100%" valign="top" width="100%" bgcolor="#26a4d3">
										<!--[if (gte mso 9)|(IE)]>
										<table align="center" border="0" cellspacing="0" cellpadding="0" width="640">
											<tr>
												<td align="center" valign="top" width="640">
										<![endif]-->
										<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px; padding:0 20px;">
											<tr>
												<td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
											</tr>
											<tr>
												<td align="center" align="center" style="font-family: 'Raleway', Arial, sans-serif; font-size:16px; line-height:22px; font-weight:bold; color:#ffffff; text-transform:uppercase;" class="center body-text">
													<h3 style="font-family: 'Raleway', Arial, sans-serif; font-size:16px; line-height:22px; font-weight:bold; color:#ffffff; text-transform:uppercase; padding:0; margin:0;" class="body-text">We've been working on some updates</h3>
												</td>
											</tr>
											<tr>
												<td align="center" align="center" style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#aad4ea; text-transform:uppercase;" class="center bodytext">
													<p style="font-family: 'Raleway', Arial, sans-serif; font-size:14px; line-height:20px; color:#aad4ea; text-transform:uppercase; padding:0; margin:0;" class="body-text">We're about to launch version 2.0</p>
												</td>
											</tr>
											<tr>
												<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
											</tr>
											<tr>
												<td align="center" valign="top">
													<table border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td>
																<table border="0" cellspacing="0" cellpadding="0">
																	<tr>
																		<td align="center" style="-webkit-border-radius: 50px; -moz-border-radius: 50px; border-radius: 50px;" bgcolor="#ffffff" class="body-text"><a href="https://litmus.com" target="_blank" style="font-size: 14px; font-family: 'Raleway', Arial, sans-serif; color: #26a4d3; text-decoration: none; text-decoration: none; border-radius: 50px; padding: 12px 28px; border: 1px solid #ffffff; display: inline-block; text-transform:uppercase; font-weight:bold;" class="body-text">View Updates</a></td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
											</tr>
										</table>
										<!--[if (gte mso 9)|(IE)]>
										</td>
										</tr>
										</table>
										<![endif]-->
									</td>
								</tr>
								<!-- START CTA -->

								<!-- START FOOTER BAR -->
								<tr>
									<td align="center" height="100%" valign="top" width="100%" bgcolor="#292828">
										<!--[if (gte mso 9)|(IE)]>
										<table align="center" border="0" cellspacing="0" cellpadding="0" width="660">
											<tr>
												<td align="center" valign="top" width="660">
										<![endif]-->
										<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;">
											<tr>
												<td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
											</tr>
											<tr>
												<td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
											</tr>
										</table>
										<!--[if (gte mso 9)|(IE)]>
										</td>
										</tr>
										</table>
										<![endif]-->
									</td>
								</tr>
								<!-- END FOOTER BAR -->

								<!-- START FOOTER INFO -->
								<tr>
									<td align="center" height="100%" valign="top" width="100%" bgcolor="#FFFFFF">
										<!--[if (gte mso 9)|(IE)]>
										<table align="center" border="0" cellspacing="0" cellpadding="0" width="660">
											<tr>
												<td align="center" valign="top" width="660">
										<![endif]-->
										<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;">
											<tr>
												<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
											</tr>
											<tr>
												<td align="center" style="font-family: 'Raleway', Arial, sans-serif; font-size:12px; line-height:18px; color:#666666;" class="body-text">
													<p style="font-family: 'Raleway', Arial, sans-serif; font-size:12px; line-height:18px; color:#666666; padding:0 20px; margin:0;" class="body-text">675 Massachusetts Avenue, 11th floor Cambridge, MA 02139</p>
												</td>
											</tr>
											<tr>
												<td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
											</tr>
											<tr>
												<td align="center" style="font-family: 'Raleway', Arial, sans-serif; font-size:12px; line-height:18px; color:#666666; padding:0 20px;" class="body-text">
													<a href="http://litmus.com" target="_blank" style="color:#666666; text-decoration:underline;" class="body-text">hello@litmus.com</a>
													<span style="font-family:arial, sans-serif; font-size:14px; line-height:20px; color:#dddddd;">&nbsp;|&nbsp;</span>
													<a href="http://litmus.com" target="_blank" style="color:#666666; text-decoration:underline;" class="body-text">View in browser</a>
													<span style="font-family:arial, sans-serif; font-size:14px; line-height:20px; color:#dddddd;">&nbsp;|&nbsp;</span>
													<a href="http://litmus.com" target="_blank" style="color:#666666; text-decoration:underline;" class="body-text">Unsubscribe</a>
												</td>
											</tr>
											<tr>
												<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
											</tr>
										</table>
										<!--[if (gte mso 9)|(IE)]>
										</td>
										</tr>
										</table>
										<![endif]-->
									</td>
								</tr>
								<!-- END FOOTER INFO -->

								<!-- START COPYRIGHT -->
								<tr>
									<td align="center" height="100%" valign="top" width="100%" bgcolor="#FFFFFF" style="border-top:1px solid #dddddd;">
										<!--[if (gte mso 9)|(IE)]>
										<table align="center" border="0" cellspacing="0" cellpadding="0" width="660">
											<tr>
												<td align="center" valign="top" width="660">
										<![endif]-->
										<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;">
											<tr>
												<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
											</tr>
											<tr>
												<td align="center" style="font-family: 'Raleway', Arial, sans-serif; font-size:12px; line-height:18px; color:#666666;" class="body-text">
													<p style="font-family: 'Raleway', Arial, sans-serif; font-size:12px; line-height:18px; color:#666666; padding:0; margin:0;" class="body-text">&copy; {{ date('Y') }} CityU Pics - All Rights Reserved.</p>
												</td>
											</tr>
											<tr>
												<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
											</tr>
										</table>
										<!--[if (gte mso 9)|(IE)]>
										</td>
										</tr>
										</table>
										<![endif]-->
									</td>
								</tr>
								<!-- END COPYRIGHT -->

							</table>
			</center>
		</td>
	</tr>
</table>
<!-- END LITMUS ATTRIBUTION -->
<div style="display:none; white-space:nowrap; font:15px courier; line-height:0;">
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
</div>
</body>
</html>