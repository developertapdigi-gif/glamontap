@extends('emails.master')
@section('content')
	<tr>
		<td style="text-align: center;">
			<h3 style="font-size:26px; font-weight: normal; color:#000; margin-bottom:0px; padding-bottom:0px;">Greetings from Tradehook,</h3>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">Your upcoming job {{$data['job_name']}} starting from {{$data['start_date']}} has been cancelled by {{$data['agency']}}. </p>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">Please login to your tradehook app to see more details.</a></p>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">This is an automated email. Please do not reply to this message.</p>
		</td>
	</tr>
@endsection
