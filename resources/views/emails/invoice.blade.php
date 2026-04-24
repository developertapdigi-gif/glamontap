<html>

<head>
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <title> Your Tradehook Invoice</title>
</head>

<body style="margin: 0px; background-color: #f3f3f3;padding: 80px 0px 30px 0px;">
    <table cellpadding="0" style="border-top-left-radius: 16px; border-top-right-radius: 16px; border: 0px; margin:auto; max-width: 600px; font-family: proxima nova; background-color:#ffffff;">
        <tbody>
            <tr>
                <td style="border: 0px; margin: 0px; padding: 0px;">


                    <div style="background-color:#f6f9fc;">
                        <table
                            style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; background-color: #ffffff; width: 100%;">
                            <tbody>
                                <tr>
                                    <td
                                        style="background-color: #525F7F; height:156px; width:252px; border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; line-height: 0px; background-size: 100% 100%; border-top-left-radius: 5px;">
                                        <div style="outline: 0px; text-decoration: none;">
                                            <img src="{{asset('images/Left.png')}}"
                                                style="border: 0px; line-height: 100%; height:156px; width:252px;">
                                        </div>
                                    </td>
                                    <td
                                        style="background-color: #525F7F; border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; line-height: 0px; background-size: 100% 100%; width: 96px; height:156px;">
                                        <div style="outline: 0px; text-decoration: none;">
                                            <img src="{{asset('images/Icon--empty.png')}}"
                                                style="border: 0px; line-height: 100%; height:156px; width:96px;">
                                        </div>
                                    </td>
                                    <td
                                        style="background-color: #525F7F; border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; line-height: 0px; background-size: 100% 100%; border-top-right-radius: 5px; height:156px; width:252px;">
                                        <div style="outline: 0px; text-decoration: none;">
                                            <img src="{{asset('images/Right.png')}}"
                                                style="border: 0px; line-height: 100%; width: 100%; height:156px; width:252px;">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table cellpadding="0" width="600" style="max-width: 600px; border: 0px;">
                        <tbody>
                            <tr>
                                <td
                                    style="border: 0px; border-collapse: collapse; margin: 0px; padding: 0px; width: 472px; vertical-align: middle; color: #32325d; font-size: 24px; text-align: center; line-height: 32px;">
                                    Receipt from Tradehook
                                </td>
                            </tr>
                            <tr>
                                <td align="center"
                                    style="border: 0px; border-collapse: collapse; margin: 0px; padding: 11px 0px 0px 0px; width: 472px; vertical-align: middle; color: #525f7f; font-size: 15px;">
                                    Transaction Id&nbsp;:-&nbsp;&nbsp; {{$data['transaction_id']}}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table border="0" cellpadding="0" width="100%">
                        <tbody>
                            <tr>
                                <td width="100%">
                                    <table border="0" cellpadding="0" width="100%" style="padding-top: 28px;">
                                        <thead>
                                            <tr>
                                                <th width="48"
                                                    style="border: 0px;border-collapse: collapse;margin: 0px;padding: 0px; color: #ffffff;font-size: 1px;line-height: 1px;">
                                                    &nbsp;
                                                </th>
                                                <th
                                                    style="border: 0px; text-align: left; border-collapse: collapse; margin: 0px; width: 45%; padding: 0px; vertical-align: middle; color: #525f7f;font-size: 12px;line-height: 16px;font-weight: bold;text-transform: uppercase;">
                                                    Amount paid
                                                </th>
                                                <th
                                                    style="border: 0px; text-align: left; border-collapse: collapse;margin: 0px;padding: 0px;vertical-align: middle;color: #525f7f;font-size: 12px;line-height: 16px;font-weight: bold;text-transform: uppercase;">
                                                    Date paid
                                                </th>
                                                <th width="48"
                                                    style="border: 0px;border-collapse: collapse;margin: 0px;padding: 0px;color: #ffffff;font-size: 1px;line-height: 1px;">
                                                    &nbsp;
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="48"
                                                    style="border: 0px;border-collapse: collapse;margin: 0px;padding: 0px; color: #ffffff;font-size: 1px;line-height: 1px;">
                                                    &nbsp;</td>
                                                <td
                                                    style="border: 0px;border-collapse: collapse;margin: 0px;padding: 0px;vertical-align: middle; color: #525f7f; font-size: 15px;line-height: 24px;">

                                                    A${{$data['amount_paid']}}

                                                </td>
                                                <td
                                                    style="border: 0px;border-collapse: collapse;margin: 0px;padding: 0px;vertical-align: middle;color: #525f7f;font-size: 15px;line-height: 24px;">

                                                    {{$data['paid_date']}}

                                                </td>
                                                <td width="48"
                                                    style="border: 0px;border-collapse: collapse;margin: 0px;padding: 0px;color: #ffffff;font-size: 1px;line-height: 1px;">
                                                    &nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table border="0" cellpadding="0" style="width: 600px; padding-top: 32px;">
                        <tbody>
                            <tr>
                                <td width="48"
                                    style="border: 0px; margin: 0px; padding: 0px; font-size: 1px; line-height: 1px;">
                                    &nbsp;
                                </td>
                                <td
                                    style="border: 0px; margin: 0px; padding: 0px; color: #687385;  font-weight:400; font-size: 12px; line-height: 16px; text-transform: uppercase;">
                                    <span style="border: 0px; margin: 0px; padding: 0px; font-weight: bold;">
                                        Summary
                                    </span>
                                </td>
                                <td width="48"
                                    style="border: 0px; margin: 0px; padding: 0px; font-size: 1px; line-height: 1px;">
                                    &nbsp;
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="width: 600px; padding-top: 32px;">
                        <tbody>
                            <tr>
                                <td width="48"
                                    style="border: 0px; margin: 0px; padding: 0px; font-size: 1px; line-height: 1px; ">
                                    &nbsp;
                                </td>
                                <td style="border: 0px; margin: 0px; background-color:#f3f3f3; padding: 15px 20px; border-radius: 8px;">
                                    <table border="0" cellpadding="0" style="padding: 0px; border-collapse: collapse;" width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="border-bottom: 1px solid #e6ebf1;border-collapse: collapse;margin: 0px;padding: 0px 0px 12px 0px;vertical-align: middle;color: #525f7f;font-size: 15px;line-height: 24px; width: 100%; ">
                                                {{$data['plan_name']}}
                                                </td>
                                                <td align="right" valign="top"  style="border-bottom: 1px solid #e6ebf1;border-collapse: collapse; text-align: end; margin: 0px;padding: 0px 0px 12px 0px;vertical-align: middle;color: #525f7f;font-size: 15px;line-height: 24px;">
                                                    A${{$data['amount_paid']}}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="border: 0px;border-collapse: collapse;margin: 0px;padding: 12px 0px 0px 0px;vertical-align: middle;color: #525f7f;font-size: 15px;line-height: 24px; width: 100%; ">
                                                    <strong>Amount paid</strong>
                                                </td>
                                                <td align="right" valign="top" style="border: 0px;border-collapse: collapse;margin: 0px;padding: 12px 0px 0px 0px;vertical-align: middle;color: #525f7f;font-size: 15px;line-height: 24px;">
                                                    <strong>A${{$data['amount_paid']}}</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td style="border: 0px; margin: 0px; padding: 0px; font-size: 1px; line-height: 1px; "
                                    width="48">
                                    &nbsp;
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <table border="0" cellpadding="0" width="600" style="width: 600px; padding-top: 45px;">
                        <tbody>
                            <tr>
                                <td style="border: 0px; margin: 0px; padding: 0px; font-size: 1px; line-height: 1px; "
                                    width="48">
                                    &nbsp;
                                </td>
                                <td
                                    style="border-top: 1px solid #e6ebf1; border-bottom: 1px solid #e6ebf1; margin: 0px; padding: 32px 0px; color: #414552;  font-weight:400; font-size: 16px; line-height: 24px;">
                                    If you have any questions or encounter any issues, please don't hesitate to contact our
                                    <a style="border: 0px; margin: 0px; padding: 0px; color: #625afa !important; font-weight: bold; text-decoration: none;  "
                                        href="https://tradehook.com.au/contact" target="_blank">support team.</a>

                                </td>
                                <td style="border: 0px; margin: 0px; padding: 0px; font-size: 1px; line-height: 1px; "
                                    width="48">
                                    &nbsp;
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table style="border: 0px;border-collapse: collapse;margin: 0px;padding: 0px; margin-bottom: 84px; background-color: #ffffff;text-align:center;">
                        <tbody>
                            <tr>
                                <td width="64"
                                    style="border: 0px;border-collapse: collapse;margin: 0px;padding: 0px;color: #ffffff;font-size: 1px;line-height: 1px;">
                                    &nbsp;</td>
                                <td style="border: 0px;border-collapse: collapse;margin: 0px;padding: 24px 0px 0px 0px;width: 472px;vertical-align: middle;color: #8898aa;font-size: 12px;line-height: 16px;">
                                    You're receiving this email because you made a purchase at
                                    Tradehook.
                                </td>
                            </tr>
                            <tr>
                                <td width="64"
                                    style="border: 0px;border-collapse: collapse;margin: 0px;padding: 0px;color: #ffffff;font-size: 1px;line-height: 1px;">
                                    &nbsp;</td>
                                <td style="border: 0px;border-collapse: collapse;margin: 0px;padding: 24px 0px 0px 0px;width: 472px;vertical-align: middle;color: #8898aa;font-size: 12px;line-height: 16px;">
                                    This is an automated email. Please do not reply to this message.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>