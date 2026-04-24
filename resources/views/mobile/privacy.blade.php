@php
use App\Models\Setting;
$model = Setting::setting();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link href="{{ $model['favicon'] }}" rel="icon" type="image/x-icon">
  <title>Privacy Policy | {{$model['name_of_website']}}</title>
  <meta name="robots" content="noindex, nofollow, noarchive">
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
  <link href="{{ asset('css/slider.css') }}" rel="stylesheet">
  <link href="{{ asset('fortawesome/css/all.min.css') }}" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="{{ asset('css/slick.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/slick-theme.css') }}">
  @yield('css')

</head>

<body class="index-page">
 
<div class="top-content">
    <div class="row skill-title text-center pb-4">
        <h1>
            Privacy Policy
        </h1>
    </div>
</div>
<div class="container">
        <div class="mid-content skill-about-content no-side-padding">
            <div class="row">              
                <div class="col-md-12">   
                    <div class="about-detail">
                    <h4>Introduction </h4>
                        <p>This Privacy Policy applies to all personal information collected by Tradehook 
                        (“we” or “our”). By accessing Tradehook’s websites or apps or using 
                        Tradehook’s products or services, including beta versions of those products and 
                        services, you consent to the terms of this policy and and agree to be bound by 
                        them. This policy is also incorporated by reference into the Tradehook’s terms 
                        and conditions, including any Tradehook’s Beta Tester Agreement, that apply to 
                        products and services provided by Tradehook.</p>
                        
                    </div>                    
                    <div class="about-detail">
                    <h4>What information do we collect? </h4>
                        <p>The kind of Personal Information that we collect from you will depend on how 
                        you use the products of Tradehook. The Personal Information which we collect 
                        and hold about you may include:</p>
                        <ul>
                            <li>Users (Tradespeople and Companies): Name, contact details, business 
                            information and qualifications.</li>
                            <li>Job Listings and Interactions: Details about job postings, applications and 
                            communications. </li>
                            <li>Technical Data: IP address, device information, and usage statistics through 
                            cookies and analytics tools.</li>
                            <li>Financial details: bank account details or credit card information.</li>
                            <li>Pictures: Pictures posted by users on the app and web pages.</li>
                        </ul>
                        
                    </div>
                    <div class="about-detail">
                    <h4>How we collect and hold your personal information </h4>
                        <p>Personal information about you may be collected by us in a number of ways, 
                        including over the phone and via email, from devices or browsers which you 
                        use to access our apps and webpages, other webpages, where we keep a record 
                        and a copy of your contact with us, where you submit information through web 
                        forms, by logging your IP address, collecting GPS data, by use of cookies, by 
                        recording phone numbers and email addresses from which you contact us, by 
                        any smart phone, browser plugin or other application we use which might 
                        collect information from the device or browser used by you and in other ways 
                        which rely on technical access to information available from devices and 
                        operating systems that you might use.</p>
                        <p>We may also obtain your personal information from our affiliates or advertising 
                        partners, clients, contractors, customers and other third parties such as survey or 
                        competition websites, marketing websites, any other websites accessible via our 
                        website that we consider helps us to deliver or advertise our services, 
                        understand online activity and collect information that we consider important to 
                        managing the quality or content of the services that we deliver. </p>
                        <p>Once we have collected your personal information, we may hold it 
                        electronically or in paper files. </p>
                    </div>
                    <div class="about-detail">
                    <h4>Why we collect, hold, use and disclose your personal 
                    information </h4>
                        <ul>
                            <li> To perform and manage our business functions or activities, including 
                            providing our products or services to you; </li>
                            <li>to manage invoicing and payment systems and services;</li>
                            <li> to manage our relationship with you as a user or customer; </li>
                            <li>to manage risks and identify or investigate illegal activities or activities in 
                            breach of our terms and conditions, including by verifying your identity, 
                            ABN/ACN and/or your professional licences and documents;</li>
                            <li>to review, process and assess your applications; </li>
                            <li> to market and advertise our services and the services of other entities with 
                            whom we have relationships, including entities that market and promote 
                            goods and services unrelated to those which we market and promote, and 
                            for the operation of the businesses of third parties including the supply of 
                            products or services by those third parties; </li>
                            <li>to research, design, develop, manage, provide and improve our products 
                            and services;  </li>
                            <li> to contact you;</li>
                            <li>to comply with laws and assist government, licensing or law enforcement 
                            agencies; and </li>
                            <li>to undertake acts or practices related to the matters described above. 
                            </li>
                            <li>We may also collect, hold, use and disclose your personal information for 
                            other reasons where the law allows or requires us to do so. </li>
                        </ul>
                        <p>We retain the right to use or disclose personal information about you that is 
                        required in the provision of information about or the promotion or delivery of 
                        Tradehook services (including by way of direct marketing through mail, email, 
                        SMS and any other electronic means) to our users and customers, such as 
                        newsletters, promotional materials or direct marketing campaigns relevant to 
                        the products and services that we offer. If you no longer wish to receive our 
                        direct marketing emails or SMS, please follow the Unsubscribe link or 
                        statement located in all emails or SMS that we send to you, or let us know by 
                        using the details provided in the section titled "Contact us" on the website 
                        Tradehook.com.au. </p>
                    </div>
                    <div class="about-detail">
                    <h4>Who we disclose your personal information to </h4>
                        <p>Your information may be disclosed to persons within Tradehook or any of its 
                        related bodies corporate for the purposes noted in the ‘Why we collect hold, use 
                        and disclose your personal information” section above.</p><p>
                        We may also disclose your personal information to people or organisations 
                        outside of Tradehook for the purposes noted in the ‘Why we collect hold, use 
                        and disclose your personal information” section above and to other parties and 
                        for other purposes as specified below:</p>
                        <p>This may include: </p>
                        <ul>
                            <li>organisations who manage some of our business activities and functions, 
                            including call centre services, marketing, corporate administration and 
                            corporate strategies; </li>
                            <li> service providers, including share registry service providers, IT service 
                            providers and sponsors and/or promoters; </li>
                            <li>organisations with whom Tradehook or any of its related bodies corporate 
                            has a business relationship (e.g. partners, joint venture entities, agents, 
                            contractors or external service providers) for the operation of their 
                            businesses;</li>
                            <li> third party payment processing providers or debt recovery agencies in 
                            connection with billing or payment for the provision of services to 
                            Tradehook users or customers; 
                            </li>
                            <li>the police or other relevant authorities, licensing or enforcement bodies;</li>
                            <li>government and regulatory authorities or as otherwise required or 
                            authorised by law; </li>
                            <li>internet service providers or network administrators, including, if we have 
                            reason to suspect you have committed a breach of our terms and 
                            conditions or have otherwise been engaged in any unlawful activity and 
                            we reasonably believe such disclosure is necessary.</li>
                        </ul>                  
                    </div>
                    <div class="about-detail">
                    <h4>Security and storage </h4>
                        <p>Tradehook places a great importance on the security of all information 
                        associated with our customers and contractors. We have security measures in 
                        place to protect against the misuse, interference, loss and unauthorised access, 
                        modification or disclosure of personal information under our control. 
                        Tradehook retains the information you provide to us (including possibly your 
                        contact or bank account details) to enable us to provide our services to you, to 
                        assist you to provide services to your customers and to enable us to verify 
                        transactions and customer details and to retain adequate records for legal and 
                        accounting purposes. This information is held on secure servers in controlled 
                        facilities.</p>
                        <p>No data transmission over the Internet can be guaranteed to be 100 per cent 
                        secure. As a result, while we strive to protect user's personal information, 
                        Tradehook cannot ensure or warrant the security of any information transmitted 
                        to it or from its online products or services, and users do so at their own risk.</p>
                        <p>We note that you are solely responsible for keeping your passwords and/or 
                        account information secret. You should be careful and responsible whenever 
                        you are online. </p>
                    </div>
                    <div class="about-detail">
                    <h4>Access to and correction of personal information</h4>
                        <p>Tradehook is committed to maintaining accurate, timely, relevant, and 
                        appropriate information about our customers and web-site users.</p>
                        <p>To obtain access or seek correction of your personal information that we hold, 
                        please contact us using the details set out below in the section titled "Contact 
                        us". So long as your request for your personal information is in accordance with 
                        the Australian Privacy Principles, then we will give you access to that 
                        information. </p>
                        <p>You may request that inaccurate information will be corrected. To ensure 
                        confidentiality, details of your personal information will be passed on to you 
                        only if we are satisfied that the information relates to you. </p>
                        <p>If we refuse to provide you with access or correct the personal information held 
                        about you by us, then we will provide reasons for such refusal.</p>
                    </div>
                    <div class="about-detail">
                    <h4>Complaints </h4>
                        <p> If you have a complaint about our Privacy Policy or the collection, use or safe 
                        disposal or destruction of your personal information, your complaint should be 
                        directed in the first instance to us at E-mail: support@tradehook.com.au .</p>
                        <p>We will investigate your complaint and attempt to resolve, within 30 days, any 
                        breach that might have occurred in relation to the collection, use or destruction 
                        of personal information held by us about you in accordance with the 
                        Commonwealth Privacy legislation. If you are not satisfied with the outcome of 
                        this procedure then you may request that an independent person investigate 
                        your complaint. </p>
                    </div>
                    <div class="about-detail">
                    <h4>Changes to Privacy Policy </h4>
                        <p> If Tradehook changes its Privacy Policy, it will post changes on this Privacy 
                        Policy page so that users are always aware of what information is collected, 
                        how it is used and the way in which information may be disclosed. As a result, 
                        please remember to refer back to this Privacy Policy regularly to review any 
                        amendments. The privacy policy was last updated on the 10 April 2025.</p>
                    </div>
                    <div class="about-detail">
                    <h4>Contacting us </h4>
                        <p> If you require further information regarding our Privacy Policy, please contact 
                        us through the following means: Email us at support@tradehook.com.au. </p>
                    </div>
                </div>   
            </div>
        </div>
</div>
 
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
<script src="{{ asset('js/slick.min.js') }}" type="text/javascript" charset="utf-8"></script>
@yield('script')
<div class="loader" style="display: none;"></div>
<script>
$(document).on('ready', function() {
 $(".center_slider").slick({
      dots: true,
      infinite: true,
      centerMode: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      variableWidth: true
    });
});
setTimeout(function() { $(".alert").alert('close'); },5000);
</script>
</body>
</html>

