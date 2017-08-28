@extends('emails.base')

@section('title', trans('messages.email.confirm.title', ['code' => $code = $user->getConfirmationCode()]))

@section('heading', trans('messages.email.confirm.heading'))

@section('message')
	@lang('messages.email.confirm.message', ['code' => $code, 'url' => route('confirm', ['token' => $code, 'email' => $user->email])])
	<br>
	<tr>
		<td align="center"
		    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; padding-top: 25px;">
			<!-- DO IT. YOU WON'T. -->
			<table cellspacing="0" cellpadding="0" border="0"
			       style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse;">
				<tr>
					<td bgcolor="#0b3152"
					    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-radius: 50px; -webkit-border-radius: 50px; -moz-border-radius: 50px;">
						<a href="{{ route('confirm', ['token' => $code, 'email' => $user->email]) }}"
						   style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: 'Raleway', 'PingFang SC', Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; display: inline-block; padding: 25px 35px; border: 1px solid #d75742; border-radius: 50px; -webkit-border-radius: 50px; -moz-border-radius: 50px; background-color: #d75742; font-size: 25px !important; font-weight: 800; box-shadow: 0 2px 20px -2px rgba(14,14,14,0.5); letter-spacing: 5px;"
						   target="_blank" class="cta">{{ $code }}</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<br>
	<small>@lang('messages.email.confirm.ignore')</small>
@stop