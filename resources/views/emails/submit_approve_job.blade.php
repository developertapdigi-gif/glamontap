use App\Models\Setting;
$model = Setting::setting();
@endphp
<!DOCTYPE html>
<html>
<body>
   <table cellspacing="0" cellpadding="0" border="0px" align="center"
      style="max-width: 600px; font-family:Verdana, Geneva, Tahoma, sans-serif; width: 100%;">
      <tr>
         <td style="text-align: center; padding-bottom:20px;">
            <a href="{{url('/')}}" target="blank">
            	<img src="{{ $model['website_logo'] }}" alt="logo"
                  style="display: block; margin: 0 auto;" />
              </a>
         </td>
      </tr>
      <tr>
         <td style="padding:0; text-align: center;">
            <a href="#" target="blank">
            	<img src="{{asset('images/email_header.png')}}" alt="banner" style="display: block; margin: 0 auto;" />
            </a>
         </td>
      </tr>
      <!-- content start here -->
      <tr>
        <td style="text-align: center;">
            <h3 style="font-size:26px; font-weight: normal; color:#000; margin-bottom:0px; padding-bottom:0px;">Hi, Admin</h3>
            <p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">Submit For approval<br>
               Agency : {{$name}}<br>
            Send a Request for job approval</p>
            <br>
            <br>
            <br>
        </td>
    </tr>
      <!-- Footer Start -->
      <tr>
         <td style="text-align: center; background:#e9e9e9;">
            <p
               style="font-size: 20px; text-align:center; line-height: 28px; font-weight: bold; margin:0; padding:0 0 25px;  padding:35px 35px 25px; color:#646464">
               Even though we are a bunch of introverts and love
               keeping it to ourselves, we don't mind socialising with
               our 'homies'!

            </p>
            <table cellspacing="0" cellpadding="0" border="0px" width="100%" align="center">
               <tr>
                  <td
                     style="text-align: center;  color:#ffffff; font-size:16px; line-height: 26px; letter-spacing: 0.5px;">
                     <a href="#" target="blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="#f4a620" d="M12.001 9a3 3 0 1 0 0 6a3 3 0 0 0 0-6Zm0-2a5 5 0 1 1 0 10a5 5 0 0 1 0-10Zm6.5-.25a1.25 1.25 0 0 1-2.5 0a1.25 1.25 0 0 1 2.5 0ZM12.001 4c-2.474 0-2.878.007-4.029.058c-.784.037-1.31.142-1.798.332a2.886 2.886 0 0 0-1.08.703a2.89 2.89 0 0 0-.704 1.08c-.19.49-.295 1.015-.331 1.798C4.007 9.075 4 9.461 4 12c0 2.475.007 2.878.058 4.029c.037.783.142 1.31.331 1.797c.17.435.37.748.702 1.08c.337.336.65.537 1.08.703c.494.191 1.02.297 1.8.333C9.075 19.994 9.461 20 12 20c2.475 0 2.878-.007 4.029-.058c.782-.037 1.308-.142 1.797-.331a2.91 2.91 0 0 0 1.08-.703c.337-.336.538-.649.704-1.08c.19-.492.296-1.018.332-1.8c.052-1.103.058-1.49.058-4.028c0-2.474-.007-2.878-.058-4.029c-.037-.782-.143-1.31-.332-1.798a2.912 2.912 0 0 0-.703-1.08a2.884 2.884 0 0 0-1.08-.704c-.49-.19-1.016-.295-1.798-.331C14.926 4.006 14.54 4 12 4Zm0-2c2.717 0 3.056.01 4.123.06c1.064.05 1.79.217 2.427.465c.66.254 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428c.047 1.066.06 1.405.06 4.122c0 2.717-.01 3.056-.06 4.122c-.05 1.065-.218 1.79-.465 2.428a4.884 4.884 0 0 1-1.153 1.772a4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.427.465c-1.067.047-1.406.06-4.123.06c-2.717 0-3.056-.01-4.123-.06c-1.064-.05-1.789-.218-2.427-.465a4.89 4.89 0 0 1-1.772-1.153a4.905 4.905 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428c-.048-1.066-.06-1.405-.06-4.122c0-2.717.01-3.056.06-4.122c.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772a4.897 4.897 0 0 1 1.772-1.153c.637-.248 1.362-.415 2.427-.465C8.945 2.013 9.284 2 12.001 2Z"/></svg>
                        </a>
                     <a href="#" target="blank">.
                       <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="#f4a620" d="M12 2.04c-5.5 0-10 4.49-10 10.02c0 5 3.66 9.15 8.44 9.9v-7H7.9v-2.9h2.54V9.85c0-2.51 1.49-3.89 3.78-3.89c1.09 0 2.23.19 2.23.19v2.47h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.45 2.9h-2.33v7a10 10 0 0 0 8.44-9.9c0-5.53-4.5-10.02-10-10.02Z"/></svg>
                     </a>
                     <a href="#" target="blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 15 15"><path fill="#f4a620" d="m14.478 1.5l.5-.033a.5.5 0 0 0-.871-.301l.371.334Zm-.498 2.959a.5.5 0 1 0-1 0h1Zm-6.49.082h-.5h.5Zm0 .959h.5h-.5Zm-6.99 7V12a.5.5 0 0 0-.278.916L.5 12.5Zm.998-11l.469-.175a.5.5 0 0 0-.916-.048l.447.223Zm3.994 9l.354.353a.5.5 0 0 0-.195-.827l-.159.474Zm7.224-8.027l-.37.336l.18.199l.265-.04l-.075-.495Zm1.264-.94c.051.778.003 1.25-.123 1.606c-.122.345-.336.629-.723 1l.692.722c.438-.42.776-.832.974-1.388c.193-.546.232-1.178.177-2.006l-.998.066Zm0 3.654V4.46h-1v.728h1Zm-6.99-.646V5.5h1v-.959h-1Zm0 .959V6h1v-.5h-1ZM10.525 1a3.539 3.539 0 0 0-3.537 3.541h1A2.539 2.539 0 0 1 10.526 2V1Zm2.454 4.187C12.98 9.503 9.487 13 5.18 13v1c4.86 0 8.8-3.946 8.8-8.813h-1ZM1.03 1.675C1.574 3.127 3.614 6 7.49 6V5C4.174 5 2.421 2.54 1.966 1.325l-.937.35Zm.021-.398C.004 3.373-.157 5.407.604 7.139c.759 1.727 2.392 3.055 4.73 3.835l.317-.948c-2.155-.72-3.518-1.892-4.132-3.29c-.612-1.393-.523-3.11.427-5.013l-.895-.446Zm4.087 8.87C4.536 10.75 2.726 12 .5 12v1c2.566 0 4.617-1.416 5.346-2.147l-.708-.706Zm7.949-8.009A3.445 3.445 0 0 0 10.526 1v1c.721 0 1.37.311 1.82.809l.74-.671Zm-.296.83a3.513 3.513 0 0 0 2.06-1.134l-.744-.668a2.514 2.514 0 0 1-1.466.813l.15.989ZM.222 12.916C1.863 14.01 3.583 14 5.18 14v-1c-1.63 0-3.048-.011-4.402-.916l-.556.832Z"/></svg>
                     </a>
                  </td>
               </tr>
            </table>
            <p style="font-size: 13px; text-align: center;  margin:0; padding:25px 105px 35px; color:#646464">
               You are receiving this email because you opted in at our website.
               Change how often I get email about referrals | <a href="#" style="color:#646464; text-decoration: none;"
                  target="blank">Unsubscribe</a>
            </p>
            <p style="font-size:22px; color:#241f20; letter-spacing:0.5px; margin-top:15px;margin-bottom:20px;">This is an automated email. Please do not reply to this message.</p>
         </td>
      </tr>
   </table>
</body>
</html>

