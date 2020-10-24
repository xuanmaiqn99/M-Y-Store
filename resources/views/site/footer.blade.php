<!-- Footer -->
<footer>
    <div class="footer-inner">
        <div class="news-letter" style="padding: 0px">

        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <h4>About</h4>
                    <div class="contacts-info">
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                        <address>
                            <i class="fa fa-location-arrow"></i>
                            <span>Company, 12/34 - West 21st Street,<br>New York, USA</span>
                        </address>
                        <div class="phone-footer"><i class="fa fa-phone"></i> +1 123 456 98765</div>
                        <div class="email-footer"><i class="fa fa-envelope"></i> <a href="mailto:support@example.com">support@example.com</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12">
                    <h4>Helpful Links</h4>
                    <ul class="links">
                        <li><a href="index.html#">Products</a></li>
                        <li><a href="index.html#">Find a Store</a></li>
                        <li><a href="index.html#">Features</a></li>
                        <li><a href="index.html#">Privacy Policy</a></li>
                        <li><a href="{{ route('site.news.index') }}">Blog</a></li>
                        <li><a href="index.html#">Site Map</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12">
                    <h4>Shop</h4>
                    <ul class="links">
                        <li><a href="index.html#">About Us</a></li>
                        <li><a href="index.html#">FAQs</a></li>
                        <li><a href="index.html#">Shipping Methods</a></li>
                        <li><a href="{{ route('site.contact.index') }}">Contact</a></li>
                        <li><a href="index.html#">Support</a></li>
                        <li><a href="index.html#">Retailer</a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-lg-3 col-md-4 col-sm-6">
                    <div class="social">
                        <h4>Follow Us</h4>
                        <ul>
                            <li><a href="index.html#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="index.html#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="index.html#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="index.html#"><i class="fa fa-rss"></i></a></li>
                            <li><a href="index.html#"><i class="fa fa-youtube"></i></a></li>
                            <li><a href="index.html#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="index.html#"><i class="fa fa-pinterest"></i></a></li>
                            <li><a href="index.html#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="index.html#"><i class="fa fa-skype"></i></a></li>
                            <li><a href="index.html#"><i class="fa fa-vimeo"></i></a></li>
                        </ul>
                    </div>
                    <div class="payment-accept">
                        <h4>Secure Payment</h4>
                        <div class="payment-icon">
                            <img src="{{ asset('source/site/version4/images/paypal.png') }}" alt="paypal">
                            <img src="{{ asset('source/site/version4/images/visa.png') }}" alt="visa">
                            <img src="{{ asset('source/site/version4/images/american-exp.png') }}" alt="american express">
                            <img src="{{ asset('source/site/version4/images/mastercard.png') }}" alt="mastercard">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-xs-12 coppyright text-center">© 2018 Fabulous, All rights reserved.</div>
            </div>
        </div>
    </div>
</footer>
</div>

<!-- JavaScript -->
<script src="{{ asset('source/site/version4/js/jquery.min.js') }}"></script>
<script src="{{ asset('source/site/version4/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('source/site/version4/js/revslider.js') }}"></script>
<script src="{{ asset('source/site/version4/js/main.js') }}"></script>
<script src="{{ asset('source/site/version4/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('source/site/version4/js/mob-menu.js') }}"></script>
<script src="{{ asset('source/site/version4/js/countdown.js') }}"></script>
<script src="{{ asset('source/site/version4/js/cloud-zoom.js') }}"></script>
<script src="{{ asset('source/site/version4/js/star-rating.js') }}"></script>
<script type="text/javascript" src="{{ asset('source/backend/js/select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('source/backend/js/add-select2.js') }}"></script>
@yield('script')
<script type="text/javascript" src="{{ asset('source/backend/js/jquery/jquery-confirm.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('source/backend/js/jquery/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('source/site/version4/js/typeahead.bundle.js') }}"></script>
<script type="text/javascript" src="{{ asset('source/site/version4/js/add-to-cart.js') }}"></script>
<script type="text/javascript" src="{{ asset('source/site/version4/js/segest-search.js') }}"></script>
<script type="text/javascript" src="{{ asset('source/site/version4/js/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('source/site/version4/js/add-toast.js') }}"></script>
</body>
<!-- Mirrored from htmlfabulous.justthemevalley.com/version4/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 03 May 2018 18:53:55 GMT -->
</html>