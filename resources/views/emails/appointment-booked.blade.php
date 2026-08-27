@extends('emails.master')

@section('content')

<body style="margin:0; padding:0; background:#f5f5f5; font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f5; padding:30px 0;">
    <tr>
        <td align="center">

            <table width="600" cellpadding="0" cellspacing="0"
                   style="max-width:600px; width:100%; background:#ffffff; border-radius:10px; overflow:hidden;">

                {{-- Header --}}
                <tr>
                    <td style="background:#8e44ad; padding:25px; text-align:center;">
                        <h1 style="margin:0; color:#ffffff; font-size:26px;">
                            New Appointment Booked
                        </h1>

                        <p style="margin:8px 0 0; color:#f3e5f5; font-size:14px;">
                            A new salon appointment has been successfully booked.
                        </p>
                    </td>
                </tr>

                {{-- Content --}}
                <tr>
                    <td style="padding:30px;">

                        <p style="margin:0 0 20px; color:#333333; font-size:16px;">
                            Hello <strong>Salon Team</strong>,
                        </p>

                        <p style="color:#555555; font-size:14px; line-height:1.6;">
                            You have received a new appointment booking.
                            Please find the customer and appointment details below.
                        </p>

                        {{-- Booking Details --}}
                        <table width="100%" cellpadding="0" cellspacing="0"
                               style="margin-top:20px; border:1px solid #eeeeee; border-radius:8px;">

                            <tr>
                                <td width="40%" style="padding:12px 15px; background:#fafafa; border-bottom:1px solid #eeeeee;">
                                    <strong>Booking ID</strong>
                                </td>
                                <td style="padding:12px 15px; border-bottom:1px solid #eeeeee;">
                                    #{{ $booking->id }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:12px 15px; background:#fafafa; border-bottom:1px solid #eeeeee;">
                                    <strong>Customer Name</strong>
                                </td>
                                <td style="padding:12px 15px; border-bottom:1px solid #eeeeee;">
                                    {{ $booking->name ?? 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:12px 15px; background:#fafafa; border-bottom:1px solid #eeeeee;">
                                    <strong>Customer Email</strong>
                                </td>
                                <td style="padding:12px 15px; border-bottom:1px solid #eeeeee;">
                                    {{ $booking->email ?? 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:12px 15px; background:#fafafa; border-bottom:1px solid #eeeeee;">
                                    <strong>Phone</strong>
                                </td>
                                <td style="padding:12px 15px; border-bottom:1px solid #eeeeee;">
                                    {{ $booking->phone ?? 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:12px 15px; background:#fafafa; border-bottom:1px solid #eeeeee;">
                                    <strong>Service</strong>
                                </td>
                                <td style="padding:12px 15px; border-bottom:1px solid #eeeeee;">
                                    {{ $booking->service ?? 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:12px 15px; background:#fafafa; border-bottom:1px solid #eeeeee;">
                                    <strong>Appointment Type</strong>
                                </td>
                                <td style="padding:12px 15px; border-bottom:1px solid #eeeeee;">
                                    {{ $booking->appointment_type ?? 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:12px 15px; background:#fafafa; border-bottom:1px solid #eeeeee;">
                                    <strong>Appointment Date</strong>
                                </td>
                                <td style="padding:12px 15px; border-bottom:1px solid #eeeeee;">
                                    {{ $booking->appointment_date ?? 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:12px 15px; background:#fafafa; border-bottom:1px solid #eeeeee;">
                                    <strong>Appointment Time</strong>
                                </td>
                                <td style="padding:12px 15px; border-bottom:1px solid #eeeeee;">
                                    {{ $booking->appointment_time ?? 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:12px 15px; background:#fafafa;">
                                    <strong>Status</strong>
                                </td>
                                <td style="padding:12px 15px;">
                                    <span style="color:#27ae60; font-weight:bold;">
                                        {{ ucfirst($booking->status ?? 'Confirmed') }}
                                    </span>
                                </td>
                            </tr>

                        </table>

                        {{-- Important Notice --}}
                        <div style="margin-top:25px; padding:15px; background:#f8f0fb; border-left:4px solid #8e44ad;">
                            <p style="margin:0; color:#555555; font-size:14px; line-height:1.6;">
                                Please review the appointment details and ensure that
                                the salon team is prepared for the scheduled appointment.
                            </p>
                        </div>

                        <p style="margin-top:25px; color:#555555; font-size:14px; line-height:1.6;">
                            If any changes are required, please contact the customer
                            using the contact details provided above.
                        </p>

                        <p style="margin-top:20px; color:#333333; font-size:14px;">
                            Regards,<br>
                            <strong>{{ config('app.name') }}</strong>
                        </p>

                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="background:#f8f8f8; padding:20px; text-align:center;">

                        <p style="margin:0; color:#777777; font-size:12px;">
                            This is an automated appointment notification.
                            Please do not reply directly to this email.
                        </p>

                        <p style="margin:8px 0 0; color:#999999; font-size:11px;">
                            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

@endsection