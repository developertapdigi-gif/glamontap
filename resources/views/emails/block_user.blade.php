@extends('emails.master')
@section('content')
	<tr>
		<td style="text-align: center;">
			<h3 style="font-size:26px; font-weight: normal; color:#000; margin-bottom:0px; padding-bottom:0px;">Dear {{$data['name']}}</h3>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">This email is to inform you that your account has been temporarily blocked. </p>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">We will be happy to assist you in resolving this issue and restoring your account access, you can contact  our <a href="https://tradehook.com.au/contact" target="_blank">support team.</a></p>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">This is an automated email. Please do not reply to this message.</p>
		</td>
	</tr>
@endsection
