@extends('emails.master')
@section('content')
<tr>
	<td style="text-align: center;">
		<h3 style="font-size:26px; font-weight: normal; color:#000; margin-bottom:0px; padding-bottom:0px;">Hi, {{$name}}</h3>
		<p>Please enter the below verification code on your {{config('app.name')}} app to validate your email.</p>	
		<p><strong>{{$otp}}</strong> <br></p>	
		<p>This is an automated email. Please do not reply to this message.</p>
		<br>
		<br>
		<br>
	</td>
</tr>
@endsection