@extends('emails.master')
@section('content')
	<tr>
		<td style="text-align: center;">
			<h3 style="font-size:26px; font-weight: normal; color:#000; margin-bottom:0px; padding-bottom:0px;">Dear {{$name}}</h3>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">Welcome to {{config('app.name')}}</p>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">To complete your account setup, please click on the link below to set your password:</p>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">
			<a href="{{ route('user.reset.token', ['token' => $token ]) }}" target="_blank" style="    color: #fff; text-decoration: none;font-size: 20px;background: #000;padding: 8px 20px;">Set Password
			</a>
			</p>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">Once you've set your password, you'll be able to access your account and enjoy all the benefits of being a {{config('app.name')}} member.</p>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">If you have any questions or encounter any issues, please don't hesitate to contact our <a href="https://tradehook.com.au/contact" target="_blank">support team.</a></p>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">This is an automated email. Please do not reply to this message.</p>
		</td>
	</tr>
@endsection