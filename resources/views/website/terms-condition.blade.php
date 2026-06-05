@extends($layout)

@section('title')
Terms & Conditions
@endsection

@section('content')

<div class="top-content banner-outer">
    <div class="row skill-title text-center">
        <h1>Terms & Conditions</h1>

        <ul class="skill-breadcrumbs d-flex justify-content-center">
            <li>
                <a href="{{ (session('employer_mode') ? '/employer' : '/') }}">Home</a>
                <i class="bi bi-arrow-right"></i>
            </li>
            <li>Terms & Conditions</li>
        </ul>
    </div>
</div>

<div class="container">
    <div class="mid-content skill-about-content">
        <div class="row">
            <div class="col-md-12">

                <div class="about-detail privacy_plcy">
                    <h4>Welcome to GlamOnTap!</h4>
                    <p>
                        These Terms & Conditions apply to the GlamOnTap website, mobile applications,
                        and related services ("Services") operated by GlamOnTap ("we," "us," or "our").
                        By accessing or using our Services, you agree to be bound by these Terms &
                        Conditions. If you do not agree, please do not use our Services.
                    </p>
                </div>

                <div class="about-detail">
                    <h4>1. Our Services</h4>

                    <p>
                        GlamOnTap provides a platform that connects customers with beauty professionals,
                        salons, and independent service providers.
                    </p>

                    <p><strong>Beauty professionals and salon partners can:</strong></p>

                    <ul>
                        <li>Create and manage professional profiles.</li>
                        <li>Showcase their services, pricing, and portfolios.</li>
                        <li>Receive and manage appointment bookings.</li>
                        <li>Promote their profiles through available marketing features.</li>
                    </ul>

                    <p><strong>Customers can:</strong></p>

                    <ul>
                        <li>Browse beauty professionals and salons.</li>
                        <li>Book beauty and wellness services.</li>
                        <li>Manage appointments through the platform.</li>
                        <li>Leave reviews and ratings based on completed services.</li>
                    </ul>
                </div>

                <div class="about-detail">
                    <h4>2. Eligibility</h4>

                    <p>To use GlamOnTap, you must:</p>

                    <ul>
                        <li>Be at least 18 years old.</li>
                        <li>Provide accurate and complete registration information.</li>
                        <li>Maintain only one active account unless otherwise approved by GlamOnTap.</li>
                    </ul>

                    <p>
                        We reserve the right to suspend or terminate accounts that provide false
                        information.
                    </p>
                </div>

                <div class="about-detail">
                    <h4>3. User Accounts</h4>

                    <p>You are responsible for:</p>

                    <ul>
                        <li>Keeping your login credentials secure.</li>
                        <li>Maintaining accurate account information.</li>
                        <li>All activities conducted through your account.</li>
                    </ul>

                    <p>
                        You may not sell, transfer, or share your account with another person.
                    </p>
                </div>

                <div class="about-detail">
                    <h4>4. User Responsibilities</h4>

                    <p>Users agree to:</p>

                    <ul>
                        <li>Provide accurate personal and business information.</li>
                        <li>Maintain valid licenses, certifications, and qualifications where required.</li>
                        <li>Conduct themselves professionally and respectfully.</li>
                        <li>Attend appointments as scheduled.</li>
                        <li>Provide accurate service descriptions, pricing, and availability.</li>
                    </ul>

                    <p>Users must not:</p>

                    <ul>
                        <li>Post false, misleading, or fraudulent information.</li>
                        <li>Upload offensive, abusive, or illegal content.</li>
                        <li>Harass, threaten, or discriminate against other users.</li>
                        <li>Violate any applicable laws or regulations.</li>
                        <li>Attempt to interfere with the operation or security of the platform.</li>
                    </ul>

                    <p>
                        GlamOnTap reserves the right to remove content or suspend accounts that violate
                        these Terms.
                    </p>
                </div>

                <div class="about-detail">
                    <h4>5. Bookings and Appointments</h4>

                    <ul>
                        <li>All bookings are subject to availability.</li>
                        <li>Customers are responsible for providing accurate booking details.</li>
                        <li>Beauty professionals and salons are responsible for delivering booked services.</li>
                        <li>Cancellation and refund policies may vary depending on the service provider and booking terms.</li>
                    </ul>
                </div>

                <div class="about-detail">
                    <h4>6. Payments and Fees</h4>

                    <ul>
                        <li>Payments may be processed through third-party payment providers.</li>
                        <li>Service providers may be charged platform or subscription fees where applicable.</li>
                        <li>Customers agree to pay all applicable service charges at the time of booking.</li>
                        <li>Fees and pricing may change at any time with notice.</li>
                    </ul>

                    <p>
                        Unless required by law, completed services and subscription fees are non-refundable.
                    </p>
                </div>

                <div class="about-detail">
                    <h4>7. Content Ownership</h4>

                    <ul>
                        <li>
                            You retain ownership of the content you upload, including profile information,
                            portfolio images, reviews, comments, and marketing content.
                        </li>
                        <li>
                            By uploading content, you grant GlamOnTap a non-exclusive, worldwide license
                            to display, promote, and use such content for operating and marketing the platform.
                        </li>
                    </ul>
                </div>

                <div class="about-detail">
                    <h4>8. Reviews and Feedback</h4>

                    <p>
                        Customers may leave reviews and ratings based on genuine service experiences.
                    </p>

                    <ul>
                        <li>Post false or misleading reviews.</li>
                        <li>Manipulate ratings or feedback.</li>
                        <li>Use reviews to harass or defame others.</li>
                    </ul>

                    <p>
                        GlamOnTap may remove reviews that violate these guidelines.
                    </p>
                </div>

                <div class="about-detail">
                    <h4>9. Privacy</h4>

                    <p>
                        Your use of GlamOnTap is also governed by our Privacy Policy, which explains how
                        we collect, use, and protect your information.
                    </p>
                </div>

                <div class="about-detail">
                    <h4>10. Limitation of Liability</h4>

                    <p>
                        GlamOnTap acts solely as a marketplace connecting customers with beauty
                        professionals and salons.
                    </p>

                    <p>We do not guarantee:</p>

                    <ul>
                        <li>The quality of services provided.</li>
                        <li>The accuracy of user-generated content.</li>
                        <li>Continuous or error-free access to the platform.</li>
                    </ul>

                    <p>
                        To the maximum extent permitted by law, GlamOnTap is not liable for any loss,
                        damage, injury, dispute, or claim arising from services booked through the platform.
                    </p>
                </div>

                <div class="about-detail">
                    <h4>11. Suspension and Termination</h4>

                    <p>
                        We may suspend or terminate your account if you:
                    </p>

                    <ul>
                        <li>Violate these Terms & Conditions.</li>
                        <li>Engage in fraudulent or harmful activity.</li>
                        <li>Misuse the platform or its services.</li>
                    </ul>

                    <p>
                        We reserve the right to take appropriate action without prior notice when necessary.
                    </p>
                </div>

                <div class="about-detail">
                    <h4>12. Third-Party Services</h4>

                    <p>GlamOnTap may use third-party providers for:</p>

                    <ul>
                        <li>Payment processing.</li>
                        <li>Hosting and infrastructure.</li>
                        <li>Analytics and marketing services.</li>
                    </ul>

                    <p>
                        Your use of such services may also be subject to their terms and privacy policies.
                    </p>
                </div>

                <div class="about-detail">
                    <h4>13. Changes to Terms</h4>

                    <p>
                        We may update these Terms & Conditions from time to time. Continued use of
                        GlamOnTap after changes are published constitutes acceptance of the revised Terms.
                    </p>
                </div>

                <div class="about-detail">
                    <h4>14. Contact Us</h4>

                    <p>
                        If you have any questions regarding these Terms & Conditions, please contact us:
                    </p>

                    <p>Email: support@glamontap.com</p>
                    <p>Website: www.glamontap.com</p>
                </div>

            </div>
        </div>
    </div>
</div>

<section class="about-blue-footer about_skilled_trades mt-3">
    <div class="container">
        <div class="row about-blue-footer-right">

            <div class="col-xl-5 col-lg-4 col-md-0">
                <div class="abt-img-box">
                    <img class="abt-mob-img" src="../images/psd-images/mobile1.png" />
                    <img class="abt-arrow-img" src="../images/psd-images/roll-arrow.png" />
                </div>
            </div>

            <div class="col-xl-7 col-lg-8 col-md-12 abt-blue-desc">
                <h3>Connecting Clients with Trusted Beauty Professionals</h3>

                <p>
                    Discover, book, and enjoy professional beauty services from trusted salons
                    and beauty experts anytime, anywhere.
                </p>

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
                </div>

            </div>

        </div>
    </div>
</section>

@endsection