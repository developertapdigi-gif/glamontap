@extends('emails.master')
@section('content')
	<tr>
		<td style="text-align: center;">
		
			<h3 style="font-size:26px; font-weight: normal; color:#000; margin-bottom:0px; padding-bottom:0px;">Dear {{$data['name']}}</h3>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">We are pleased to inform you that your Tradehook account, associated with the email address {{$data['email']}}, has been successfully unblocked. </p>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">You should now be able to log in to your account as usual.</p>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">If you experience any further issues logging in, please do not hesitate to contact our support team at <a href="mailto:support@tradehook.com.au">support@tradehook.com.au</a> or visit our <a href="https://tradehook.com.au/contact" target="_blank">help center</a>.</p>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">Thank you for your patience and understanding.</p>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">Sincerely,</p>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">The {{config('app.name')}} Team</p>
			<p>This is an automated email. Please do not reply to this message.</p>
		</td>
	</tr>
@endsection
