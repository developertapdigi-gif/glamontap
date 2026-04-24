@extends('emails.master')
@section('content')
	<tr>
		<td style="text-align: center;">
			<h3 style="font-size:26px; font-weight: normal; color:#000; margin-bottom:0px; padding-bottom:0px;">Greetings from Glam on Tap,</h3>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">Your application for {{$data['job_name']}} starting from {{$data['start_date']}} has been approved by {{$data['agency']}}. </p>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">Please login to your tradehook app to see more details.</a></p>
			<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">This is an automated email. Please do not reply to this message.</p>
		</td>
	</tr>
@endsection
