@extends('emails.master')
@section('content')
<tr>
	<td style="text-align: center;">
		<h3 style="font-size:26px;font-weight: normal;color:#000;margin-bottom:0px;padding-bottom:0px;">Dear {{$name}}</h3>
		<p style="font-size:20px; color:#241f20;letter-spacing:0.5px;margin-top:15px;margin-bottom:10px;">You recently requested a password reset for your {{config('app.name')}} account.</p>
		<p style="font-size:20px;color:#241f20;letter-spacing:0.5px;margin-top:15px;margin-bottom:20px;">To reset your password, please click on the following link:
			<br>
			<br>
			<a href="{{ route('user.reset.token', ['token' => $token ]) }}" target="_blank" style="color: #fff; text-decoration: none;font-size: 20px;background: #000;padding: 8px 20px;">Reset Password
			</a>
		</p>		
		<p style="font-size:20px;color:#241f20;letter-spacing:0.5px;margin-top:15px;margin-bottom:20px;">If you did not request a password reset, please ignore this email.</p>
		<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">This is an automated email. Please do not reply to this message.</p>
		<br>
		<br>
		<br>
	</td>
</tr>
@endsection