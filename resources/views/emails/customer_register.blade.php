@extends('emails.master')
@section('content')
	<h3 style="font-size:26px; font-weight:normal; color:#000; margin-bottom:0; padding-bottom:0;"> Dear {{$name}} </h3>

<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px; margin-bottom:20px;"> Welcome to {{config('app.name')}}! </p>

<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px; margin-bottom:20px;"> Thank you for registering with us. We're delighted to have you as a member of {{config('app.name')}}. </p>

<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px; margin-bottom:20px;"> Your account has been successfully created, and you can now enjoy all the features and benefits available to our members. </p>

<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px; margin-bottom:20px;"> If you have any questions or need assistance, please don't hesitate to contact our <a href="https://glamontap.tapdigi.com/contact" target="_blank">support team</a>. </p>

<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px; margin-bottom:20px;"> We look forward to having you with us! </p>

<p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px; margin-bottom:20px;"> This is an automated email. Please do not reply to this message. </p>
@endsection