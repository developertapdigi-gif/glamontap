@extends($layout)
@section('title')
Terms & Conditions
@endsection
@section('content')


<div class="top-content banner-outer">
        <div class="row skill-title text-center">
            <h1>
            Terms & Conditions
            </h1>
            

            <ul class="skill-breadcrumbs d-flex justify-content-center">
                <li><a href="{{(session('employer_mode')?'/employer':'/')}}">Home</a> <i class="bi bi-arrow-right"></i></li>
                <li>Terms & Conditions</li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="mid-content skill-about-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="about-detail privacy_plcy">
                            <h4>Welcome to Cover House ! </h4>
                                <p>The terms apply to thecoverhouse.com/, Cover House apps, and web portal services that 
                                state that they are offered under this Contract (“Services”), including the offsite 
                                collection of data for those services operated by Cover House (“we,” “us,” or “our”). By 
                                using the App, you agree to these Terms. If you do not agree, do not create an account 
                                or access or otherwise use any of our services. </p>
                        </div>
                    
                        <div class="about-detail">
                            <h4>1. Services </h4>
                                <p>CoverHouse provides a digital platform where household service professionals(“helpers”) can:</p>
                                <ul>
                                    <li>Create and showcase a digital portfolio.</li>
                                    <li>Discover home-help job opportunities.</li>
                                    <li>Connect with homeowners and other service providers.</li>
                                    <li>Be featured or promoted via paid branding tools.</li>
                                </ul>
                                <p>Homeowners can subscribe to:</p>
                                <ul>
                                    <li>View helper profiles.</li>
                                    <li>Post jobs and connect directly with qualified professionals.</li>
                                    <li>Access features based on their chosen subscription plan.</li>
                                </ul>
                        </div>
                        <div class="about-detail">
                            <h4>2. Eligibility </h4>
                            <ul>
                                <li>CoverHouse services are for users 18 years or older.</li>
                                <li>Users must maintain one account in their real name.</li>
                                <li>Accounts with false information, accounts for minors, or accounts created on behalf of others are prohibited.</li>
                            </ul>
                        </div>
                        <div class="about-detail">
                            <h4>3. User Accounts</h4>
                            <p>As a member, you agree to: </p>
                            <ul>
                                <li>Keep your account secure with a strong password.</li>
                                <li>Not share, sell, or transfer your account.</li>
                                <li>Be responsible for all activity on your account until it is closed or reported. </li>
                            </ul>
                        </div>
                        <div class="about-detail">
                            <h4>4. User Conduct</h4>
                            <div class="service_content">
                                <p>You agree to:</p>
                                <ul>
                                    <li>Provide valid contact details (email, phone).</li>
                                    <li>Share correct details of qualifications, licenses, or certifications required for your service category. </li>
                                    <li>Keep your payment methods updated and maintain sufficient funds/credit. </li>
                                    <li>Only accept or perform jobs you are licensed and qualified to do.</li>
                                    <li>Maintain all licenses or qualifications and notify CoverHouse of any changes.</li>
                                    <li>Respond to job inquiries promptly and professionally.</li>
                                    <li>Post accurate job ads and authentic profile photos.</li>
                                </ul>
                                <p>You must NOT: </p>
                                <ul>
                                    <li>Post misleading, offensive, illegal, or harmful content.</li>
                                    <li>Engage in unlawful, unprofessional, or negligent behavior.</li>
                                    <li>Infringe on intellectual property rights.</li>
                                    <li>Violate licensing or employment laws. </li>
                                </ul>
                                <p>CoverHouse reserves the right to suspend or delete accounts violating these guidelines. </p>
                            </div>
                    </div>
                    <div class="about-detail">
                        <h4>5. Content Ownership</h4>
                        <ul>
                            <li>You retain ownership of uploaded content (portfolios, photos, etc.).</li>
                            <li>By posting, you grant CoverHouse a license to display and promote your content within the platform and related marketing materials. </li>
                        </ul>
                    </div>
                    <div class="about-detail">
                        <h4>6. Service Fees</h4>
                        <ul>
                            <li>Helpers may pay for profile branding if opted.</li>
                            <li>Homeowners pay subscription fees to access features.</li>
                            <li>Monthly or annual subscription fees are billed automatically.</li>
                            <li>Fees are non-refundable unless stated otherwise.</li>
                            <li>CoverHouse may recover overdue payments, including legal or debt recovery costs.</li>
                        </ul>
                        <p><b>Note:</b> Accepting a job means you waive the right to cancel that job for a refund.</p>
                    </div>
                    <div class="about-detail">
                    <h4>7. Termination </h4>
                        <p>CoverHouse may suspend or terminate access at any time for violations or harmful behavior. </p>
                    </div>
                    <div class="about-detail">
                        <h4>8. Privacy</h4>
                        <p>Your privacy is important. Please review our Privacy Policy to understand how we collect and use your information. </p>
                    </div>
                    
                    <div class="about-detail">
                    <h4>9. Limitation of Liability</h4>
                        <p>CoverHouse is provided “as is.” We are not responsible for loss, injury, or damage from using the platform, including job outcomes or financial transactions.</p>
                    </div>
                    <div class="about-detail">
                        <h4>10. Assignment</h4>
                        <p>You may not transfer your rights or obligations under these guidelines without written approval.</p>
                    </div>
                    <div class="about-detail">
                        <h4>11. Feedback</h4>
                        <ul>
                            <li>Users can leave feedback about helpers, which may be public.</li>
                            <li>Manipulating or falsifying feedback is prohibited.</li>
                            <li>You acknowledge feedback may impact your reputation and agree to hold CoverHouse harmless from related claims. </li>
                        </ul>
                    </div>
                    <div class="about-detail">
                        <h4>12. Payment Facilitator</h4>
                        <ul>
                            <li>CoverHouse uses Stripe for processing payments.</li>
                            <li>By paying through CoverHouse, you agree to Stripe’s privacy policy and terms.</li>
                            <li>You authorize CoverHouse and Stripe to share your information as needed to complete transactions. </li>
                        </ul>
                    </div>
                    <div class="about-detail">
                        <h4>13. Changes to Terms</h4>
                        <p>We may update these Terms occasionally. Continued use of the App after changes 
                        means you agree to the new Terms.</p>
                    </div>
                    <div class="about-detail">
                        <h4>14. Contact Us</h4>
                        <p>If you have any questions about these Terms, please contact us at:</p>
                        <p>Email: support@thecoverhouse.com</p>
                        <p>Company: Cover House</p>
                        {{-- <p>Location: Australia</p> --}}
                    </div>
                </div>       
            </div>
    </div>
</div>
   

  
    <section class="about-blue-footer about_skilled_trades mt-3">
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
                    <p>We encourage diversity in hiring of women and underrepresented groups </p>
                
                   
                        <div class="d-flex mt-md-5 mt-4 about-download">
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
                            <!--<a href="#"><img class="me-3 mb-2 social-media-banner" src="../images/googleplay-btn.svg"></a>-->
                  
                          </div>
                </div>
            </div>
        </div>

    </section>

@endsection