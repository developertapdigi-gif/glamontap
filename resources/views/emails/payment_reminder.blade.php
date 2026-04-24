@extends('emails.master')
@section('content')
<tr>
	<td style="text-align: center;">
		<h3 style="font-size:26px; font-weight: normal; color:#000; margin-bottom:0px; padding-bottom:0px;">Dear {{ucfirst($agencyName)}}</h3>
		<p>Your subscription payment of ${{$amount}} towards Tradehook is due on {{ucfirst($endDate)}} and will be debited from your Credit Card.</p>	
		<p>This is an automated email. Please do not reply to this message.</p>
		<br>
		<br>
		<br>
	</td>
</tr>
@endsection