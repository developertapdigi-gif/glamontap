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
  <title>Terms & Conditions | {{$model['name_of_website']}}</title>
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
        <div class="row skill-title text-center mb-4">
            <h1 class="mb-4">
                Terms & Conditions Of Use
            </h1>   
        </div>
    </div>

    <div class="container">
        <div class="mid-content outer_content skill-about-content no-side-padding">
            <div class="row">
                <div class="col-md-12">
                <div class="col-md-12">
                    <p></p>
                    <div class="about-detail">
                            <h4>Welcome to Tradehook ! </h4>
                                <p>The terms apply to Tradehook.com.au, Tradehook apps, and web portal services that 
                                state that they are offered under this Contract (“Services”), including the offsite 
                                collection of data for those services operated by Tradehook (“we,” “us,” or “our”). By 
                                using the App, you agree to these Terms. If you do not agree, do not create an account 
                                or access or otherwise use any of our services. </p>
                    </div>
                    
                    <div class="about-detail">
                    <h4>1. Services </h4>
                                <p>I. Tradehook provides a digital platform where trade professionals ("tradies") can: </p>
                                <p>A. create and showcase a digital portfolio,</p>
                                <p>B. discover job opportunities,</p>
                                <p>C. connect with other tradies and construction companies,</p>
                                <p>D. be featured or promoted via paid branding tools.</p>
                                <p>II. Employers can subscribe to : </p>
                                <p>A. view tradie profiles, </p>
                                <p>B. post jobs and connect directly with skilled professionals, </p>
                                <p>A. get access to features on website based on subscription models. </p>
                    </div>                    
                    <div class="about-detail">
                            <h4>2. Eligibility </h4>
                            <p>The Services are not for use by anyone under the age of 18. </p>
                            <p>To use the Services, you agree that: </p>
                            <p>I. you must be the "Minimum Age" (described below) or older;</p>
                            <p>II. you will only have one Tradehook account, which must be in your real name; </p>
                            <p>III. you are not already restricted by Tradehook from using the Services.</p>
                            <p>Creating an account with false information is a violation of our terms, including 
                            accounts registered on behalf of others or persons under the age of 18.</p>
                            <p>“Minimum Age” means 18 years old.</p>
                    </div>
                    <div class="about-detail">
                            <h4>3. User Accounts </h4>
                            <p>Members are account holders. You agree to:</p>
                            <p>I. protect against wrongful access to your account (e.g., use a strong password and 
                            keep it confidential);</p>
                            <p>II. not share or transfer your account or any part of it (e.g., sell or transfer the 
                            personal data of others by transferring your connections).</p>
                            <p>You are responsible for anything that happens through your account unless you close 
                            it or report misuse. </p>
                    </div>
                    <div class="about-detail">
                            <h4>4. User Conduct</h4>
                            <div class="service_content">
                                <p>I. You agree to :</p>
                                <p>A. provide us with an active email address for us to direct emails to and for you to 
                                receive emails;</p>
                                <p>B. provide us with the current, valid ABN/ACN for your business;</p>
                                <p>C. provide us with details of all licences or qualifications you hold that are required for 
                                you to accept and perform Jobs in your selected Lead categories;</p>
                                <p>D. provide us with accurate and current details for the bank account or credit card you 
                                have selected to use to make all payments required to be made by you in 
                                accordance with the Agreement and ensure that you maintain sufficient funds and/
                                or credit in that account/on that credit card to enable you to do so;</p>
                                <p>E. promptly notify us of any relevant changes to your contact details including your 
                                Enquiry Email, Enquiry Number, or of any changes to your ABN, licensing status, 
                                bank account or credit card details and any other information you are required to 
                                maintain with us. You can notify us by contacting us directly or updating the 
                                relevant details via the App where applicable;</p>
                                <p>F. only accept or perform Jobs that you are licensed and qualified to carry out (where 
                                any such licences or qualifications apply);</p>
                                <p>G. maintain all licences or qualifications required for you to accept and/or perform 
                                Jobs in the categories you have selected to accept Leads, and promptly notify us of 
                                any changes to, or expiry of your current licences or qualifications; and</p>
                                <p>H. make contact with employers in response to a job ad promptly and professionally 
                                and carry out all Jobs with due skill and care.</p>
                                <p>I. post job ads only that are true and carried on;</p>
                                <p>J. post photos on profile that are authentic and true.</p>
                                <p>II. You agree not to:</pgit>
                                <p>A. make any statement or representation to any person, or advertise, post or publish 
                                any content that is false, misleading or likely to mislead, or is otherwise illegal, 
                                offensive, vulgar or unacceptable, or which could expose us or a third party to 
                                liability of any kind;</p>
                                <p>B. engage in any unlawful, offensive or unacceptable conduct, or behave in an 
                                unprofessional or negligent manner;</p>
                                <p>C. reproduce without lawful authority in any manner or form any copyright material or 
                                other intellectual property; or</p>
                                <p>D. violate trade licensing or employment laws.</p>
                                <p>We reserve the right to suspend or delete accounts that violate these Terms.</p>
                            </div>
                    </div>
                    <div class="about-detail">
                        <h4>5. Content Ownership</h4>
                        <p>You retain ownership of your uploaded content (e.g., portfolios, photos). </p>
                        <p>By posting, you grant us a license to display and promote your content within the App 
                        and related marketing materials.</p>
                    </div>
                    <div class="about-detail">
                        <h4>6. Service Fees</h4>
                        <p>I. For Tradespeople, Tradehook charges fees for branding of individual profiles, if 
                        opted;</p>
                        <p>II. For employers, Tradehook charges for the subscriptions to get individual web 
                        portals and avail features.</p>
                        <p>A. once you subscribe, Tradehook will automatically process your Monthly 
                        Subscription fee in the next billing cycle.</p>
                        <p>B. Tradehook will continue to automatically process your Monthly Subscription fee 
                        each month at the then- current Monthly Subscription rate, until you cancel your 
                        subscription. We will notify you before the renewal fee is billed.</p>
                        <p>C. by purchasing an Annual Subscription, you agree to an initial pre-payment for one 
                        full year of service. After one year and annually thereafter, you will be billed a 
                        recurring Annual Subscription renewal fee at the then-current Annual Subscription 
                        rate. We will notify you before the renewal fee is billed. You may cancel your 
                        Annual Subscription anytime before the next billing cycle, subject to the terms.</p>
                        <p>All fees will be clearly stated before purchase and are non-refundable unless otherwise 
                        stated. All the payments are securely processed via third party.</p>
                        <p>Unless otherwise specified, charges for our Products are payable in advance for the 
                        agreed billing period or, if not specified, monthly in advance.</p>
                        <p>In addition to any other amounts payable by you, we may recover all fees and charges 
                        reasonably incurred in recovering overdue payments from you, including legal and 
                        debt recovery charges.</p>
                        <p>If you accept a job and you acknowledge that you waive your right to cancel the jobs 
                        after accepting it, you will be not be entitled to any refund of fees you have paid in 
                        respect of that Term of the Agreement.</p>
                    </div>
                    <div class="about-detail">
                        <h4>7. Privacy</h4>
                        <p>Your privacy is important to us. Please review our Privacy policy to understand how we 
                        collect and use your information.</p>
                    </div>
                    <div class="about-detail">
                    <h4>8. Termination </h4>
                        <p>We reserve the right to terminate or suspend your access to the App at our discretion, 
                        with or without notice, if you violate these Terms or engage in behaviour we deem 
                        harmful to the platform or its users.</p>
                    </div>
                    <div class="about-detail">
                    <h4>9. Limitation of Liability</h4>
                        <p>Tradehook is provided “as is” without warranties of any kind. We are not responsible 
                        for any loss, injury, or damage resulting from your use of the App, including job 
                        outcomes or financial transactions. </p>
                    </div>
                    <div class="about-detail">
                        <h4>10. Feedback</h4>
                        <p>I. We may, from time to time, allow users who engage with a tradie to provide 
                        feedback about their experience with that tradie, which feedback may be made 
                        public. You consent to that and acknowledge that we may make that feedback 
                        public.</p>
                        <p>II. You agree not to do anything which might damage the integrity of or manipulate our 
                        feedback process, including without limitation, contributing or soliciting any other 
                        person to contribute false, misleading or inauthentic content.</p>
                        <p>You acknowledge that the way we gather and publish feedback may have negative 
                        consequences for your business, including by publication of statements or the 
                        publication of a rating score and you indemnify us and hold us harmless against any 
                        claim associated with any adverse consequences relating to our feedback system.</p>
                    </div>
                    <div class="about-detail">
                        <h4>11. Assignment</h4>
                        <p>You must not transfer or assign any of your rights or obligations under the Agreement 
                        to a third party without our written approval, and any such purported transaction is 
                        void.</p>
                    </div>
                    <div class="about-detail">
                        <h4>12. Payment Facilitator</h4>
                        <p>We use Stripe (Stripe Payment Australia Pty Ltd) as a third party service provider for 
                        internet based payment services to facilitate payments for subscriptions and all other 
                        mentioned services. If we have offered to make payment services available to you, and 
                        you have accepted our offer, you agree to be bound by Stripe which is located at 
                        https://stripe.com/au/privacy and hereby consent and authorise us and Stripe to share 
                        any information and payment instructions you provide to the extent required to 
                        complete your transactions with us. You also agree to be bound by Assembly 
                        Payments User Terms which are located at https://stripe.com/au/legal/ssa.</p>
                    </div>
                    <div class="about-detail">
                        <h4>13. Changes to Terms</h4>
                        <p>We may update these Terms occasionally. Continued use of the App after changes 
                        means you agree to the new Terms.</p>
                    </div>
                    <div class="about-detail">
                        <h4>14. Contact Us</h4>
                        <p>If you have any questions about these Terms, please contact us at:</p>
                        <p>Email: support@tradehook.com.au</p>
                        <p>Company: Tradehook</p>
                        <p>Location: Australia</p>
                    </div>
                </div>

            </div>

          
              
                
            </div>
        </div>
    </div>
   

  
    <!-- <section class="about-blue-footer mt-3">
        <div class="container">
        <div class="row about-blue-footer-right">
                <div class="col-xl-5 col-lg-4  col-md-0">
                  <div class="abt-img-box">
                  <img class="abt-mob-img" src="../images/psd-images/mobile1.png"/>
                  <img class="abt-arrow-img" src="../images/psd-images/roll-arrow.png"/>
                </div>
                    </div>
                    <div class="col-xl-7 col-lg-8 col-md-12 abt-blue-desc">
                    <h3>Connecting Skilled trades of Australia to their Community</h3>
                    <p>Share your skills and get paid </p>
                
                   
                        <div class="d-md-flex mt-5">
                            <a href="#">
                              <div class="applestore whitestore social-media-banners d-flex me-3 me-xs-0 mb-xs-3">
                                <i class="bi bi-apple blue-icn"></i>
                                <div>
                                  <p>Download on the</p>
                                  <b>Apple Store</b>
                                </div>
                              </div>
                  
                            </a>
                  
                            <a href="#">
                              <div class="googlestore social-media-banners d-flex">
                                <i class="bi bi-google-play white-icn"></i>
                                <div>
                                  <p>Get it on</p>
                                  <b>Google Play</b>
                                </div>
                              </div>
                  
                            </a>
                           
                            <a href="#"><img class="me-3 mb-2 social-media-banner" src="../images/googleplay-btn.svg"></a>
                  
                          </div>
                </div>
            </div>
        </div>

    </section> -->


 
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

