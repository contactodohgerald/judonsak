<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description"
              content="Nigeria, Client Management System, Nigeria tax consultant, Tax Software, Tax management, Payroll management, Africa, taxtech, Payroll products">
        <meta name="keywords"
              content="Tax software in Nigeria, Client Management in Nigeria, Tax Management in Nigeria, Tax, Taxes, Tax in Nigeria, Nigeria, Tax Technology, Tax Management, Tax Solutions, Solution Providers, Tax Professionals, Tax Advisory, Tax Consultants, Tax Managers, Tax Computations, Disbursement, Tax Returns, Tax filings, Auditing, Accounting, Payroll, Payroll Managers, Payroll Software, Taxaide, TaxTech, TaxiTPayroll, Taxaide Professional Services, Taxaide Technologies, Technology for Tax Management, Efficiency, Payroll Obligations Manager, Making Taxation fun, Company Income Tax, Personal Income Tax, PAYE, , Relevant tax Authorities, RTAs, Services, Products, Projects, Data Security, , Mobile Compatibility, Cloud-based technology, User Intelligence, Experience, Expertise, Simplified processes, Sustainable solutions, Olumide Bidemi Daniel, CITN, ANTEA, Direct Disbursement, Scalable Payroll Management, Automatic Payment Software, Tax Fraud Control">
        <meta name="author" content="Taxtech">
        <meta name="robots" content="index,follow">
        <meta name="ROBOTS" content="NOYDIR">
        <meta name="ROBOTS" content="NOODP">
        <meta name="publisher" content="www.taxtech.com.ng"/>
        <meta name="company" content="Taxaide Technologies Limited"/>

        <title> TaxiTManager | Home
    	</title>
        
    <link rel="shortcut icon" type="image/png" href="https://taxitpayroll.com.ng/favicon.png" />
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/bootsnav/css/bootsnav.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}">

    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('vendor/custom-icon/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/magnific-popup/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/animate.css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.min.css')}}">
    <!-- endinject -->

    </head>
    <body>
    <!--header start-->
    <header id="header" class="Sticky">
        <!-- Start Navigation -->
        <nav class="navbar navbar-default navbar-fixed white no-background bootsnav">

            <div class="container">
                <!-- Start Atribute Navigation -->
                <div class="attr-nav">
                    <ul>                        
                        <li class="buy-btn hidden-xs hidden-sm">
                        	@guest
	                            <a href="{{route('login')}}">
	                                <span class="btn btn-sm btn-success n-MarginTop5 text-uppercase">
	                                    Login
	                                </span>
	                            </a>
                            @else
	                            <a href="{{route('dashboard')}}">
	                                <span class="btn btn-sm btn-success n-MarginTop5 text-uppercase">
	                                    dashboard
	                                </span>
	                            </a>
                            @endguest
                        </li>
                    </ul>
                </div>
                <!-- End Atribute Navigation -->

                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="/" style="max-width: 150px">
                        <img src="{{asset('imgs/taxit_logo.png')}}" class="img img-responsive" alt="" style="margin-top: -35px">
<!--                         <img src="https://taxitpayroll.com.ng/assets/img/logo2.png" class="img img-responsive logo logo-scrolled" alt=""> -->
                    </a>

                    <a href="{{route('login')}}" class="navbar-toggle buy-btn pull-right" style="margin-right:0px;">
                        <span class="btn btn-sm btn-success n-MarginTop5 text-uppercase">
                            Login
                        </span>
                    </a>
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav navbar-right" data-in="" data-out="">
                        <li class="dropdown">
                            <a href="#home">Home</a>
                        </li>
                        <li class="dropdown">
                            <a href="#about">Features</a>
                        </li>
                        
                        <li class="dropdown">
                            <a href="#pricing">Pricing</a>
                        </li>

                        <li class="dropdown">
                            <a href="#contact">Contact</a>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>

        </nav>
        <!-- End Navigation -->
        <div class="clearfix"></div>
    </header>
    <!--header end-->


<!-- block body -->

    <!--hero section start-->
    <section class="ImageBackground ImageBackground--overlay js-FullHeight js-Parallax" data-overlay="5" id="home">
        <div class="ImageBackground__holder">
            <img src=" {{asset('imgs/home_background.jpg')}}" alt=""/>
        </div>
        <div class="container u-vCenter">
            <div class="row text-center text-left- text-white">
                <div class="col-md-12">
                    <!--<h1 class="u-FontSize75 u-xs-FontSize40 u-Weight700 u-MarginTop0 u-MarginBottom0">International</h1>-->
                    <h1 class="u-FontSize75 u-xs-FontSize40 u-Weight700 u-MarginBottom0">Handle Your Payroll With Class & Ease</h1>
                    @guest
                    <a class="btn btn-gradient- btn--alien- btn-success text-uppercase u-MarginBottom10 u-LetterSpacing2" href="{{ route('register') }}">Get Started</a>
                    @endguest
                </div>
            </div>
        </div>
        <div class="container u-vCenter">
            <div class="row text-center text-left- text-white">
                <a class="text-uppercase MarginTop100 u-MarginBottom10 u-LetterSpacing2" href="#about">
                    <h1 class="u-FontSize75 u-xs-FontSize40 u-Weight700 u-MarginBottom0">
                        {{-- <i class="fa fa-arrow-circle-down home_arrow" aria-hidden="true" style="color:#5db146;"></i> --}}
                    </h1>
                    <i class="home_arrow"></i>
                </a>
            </div>
        </div>
    </section>
<div id="about" class="MarginBottom10"></div>
    <!--hero section end-->
    <!--about start-->
    <section class=" u-PaddingTop50 u-PaddingBottom50  u-xs-PaddingBottom30 u-xs-PaddingTop30 u-sm-PaddingTop50 u-MarginBottom0 u-zIndex10 position-relative">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center u-MarginBottom50 u-xs-MarginBottom30 u-sm-MarginBottom30">
                    {{-- <h1 class="u-MarginTop5 u-MarginBottom10 u-Weight700">About</h1> --}}
                    {{-- <div class="Split Split--height2"></div> --}}
                </div>
            </div>

            <div class="row">
                <div class="col-md-5 adjust_pad">
                    <p>
                        We provide the most robust solution for payroll taxes and related obligations in Nigeria. 
                    </p>
                    <br>

                    <div class="row">
                        <div class="col-sm-6 ">
                            <p><i class="fa fa-home Icon--32px text-primary" aria-hidden="true"></i></p>
                            <h4>Payment made easy</h4>
                            <p>
                                Net Salaries, Pensions &amp; more
                            </p>
                        </div>
                        <div class="col-sm-6 ">
                            <p><i class="Icon Icon-clock Icon--32px text-primary" aria-hidden="true"></i></p>
                            <h4>Secure &amp; Fast</h4>
                            <p>
                                Built With Best Practices.
                            </p>
                        </div>
                    </div>

                    <div class="u-MarginTop10">
                        {{--<a class="btn btn-success text-uppercase u-MarginBottom10 u-LetterSpacing2 " href="#">Learn More</a>--}}
                    </div>
                </div>
                <div class="col-md-7 adjust_pad">
                    <img src="{{asset('imgs/dashboard.png')}}" class="img img-responsive ">
                </div>
            </div>
        </div>
    </section>
    <!--about end-->

    <!--schedule short info start-->
    <section class="bg-primary bg-primary--gradient u-PaddingTop50 u-PaddingBottom50" id="schedule">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 u-sm-MarginBottom30">
                    <div class="media u-OverflowVisible">
                        <div class="media-left">
                            <div class="Thumb">
                                <i class="fa fa-magic Icon--32px" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="media-body">
                    {{-- <span class="home_arrow"></span> --}}
                            <h4 class="u-MarginTop0 u-MarginBottom5 u-Weight700">Automatic Processing</h4>
                            <small>Retains & sorts out all statutory pauroll obligatopns, computes payroll taxess and remits to the relevant agencies and agents as payments fall due. </small>
                    {{-- <span class="home_arrow"></span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 u-sm-MarginBottom30">
                    <div class="media u-OverflowVisible">
                        <div class="media-left">
                            <div class="Thumb">
                                <i class="fa fa-balance-scale Icon--32px" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="media-body">
                            <h4 class="u-MarginTop0 u-MarginBottom5 u-Weight700">Audit Compliance</h4>
                            <small>All payroll documentations are securely stored and retrievable for compliance and audits thereby allowing electronic audits by tax administrators. </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 u-sm-MarginBottom30">
                    <div class="media u-OverflowVisible">
                        <div class="media-left">
                            <div class="Thumb">
                                <i class="fa fa-money Icon--32px" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="media-body">
                            <h4 class="u-MarginTop0 u-MarginBottom5 u-Weight700">Direct Deposit</h4>
                            <small>Sorts out the remuneration information of employees and disburses payments directly to their individual bank accounts. </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 u-sm-MarginBottom30">
                    <div class="media u-OverflowVisible">
                        <div class="media-left">
                            <div class="Thumb">
                                <i class="fa fa-download Icon--32px" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="media-body">
                            <h4 class="u-MarginTop0 u-MarginBottom5 u-Weight700">Instant Data Import</h4>
                            <small>The built in data import tools make data migration into TaxIT Payroll painless thereby giving you a smooth on-boarding experience. </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--schedule short info end-->

    <!--video & slides start-->
    <section class="u-PaddingTop50 u-xs-PaddingTop30 u-PaddingBottom50 u-xs-PaddingBottom30 u-BoxShadow40">
        <div class="container">
            <div class="row media">
                <div class="col-md-6 media-left media-middle u-sm-MarginBottom30">
                    <img class="img-responsive" src="imgs/you_vid.png" alt="...">
                    <a href="https://www.youtube.com/watch?v=vi4Wbcxkiyk" class="btn btn-play popup-youtube btn-play--hoverPrimary u-Rounded u-Center"><i class="btn__iconCenter fa fa-play"></i></a>
                </div>
                {{--<div class="col-md-6 media-body media-middle">--}}
                    {{--<div class="u-PaddingLeft50 u-PaddingRight50 u-xs-Padding0">--}}
                        {{--<!--<span class="label label-primary u-block">social net</span>-->--}}
                        {{--<h3 class="u-MarginTop0 u-MarginBottom20 u-Weight700">--}}
                            {{--Just A Button Away--}}
                        {{--</h3>--}}
                        {{--<p class="">--}}
                            {{--Lid est laborum dolo rumes fugats untras. Etharums ser quidem rerum facilis dolores nemis omnis fugats vitaes nemo minima rerums unsers sadips amets.--}}
                        {{--</p>--}}
                        {{--<h4>Download Files</h4>--}}
                        {{--<ul class="list-unstyled u-LineHeight2 ">--}}
                            {{--<li><i class="fa fa-file-powerpoint-o u-MarginRight5" aria-hidden="true"></i>--}}
                                {{--<a href="#" class="text-gray">WordPress Plugins</a>--}}
                            {{--</li>--}}
                            {{--<li><i class="fa fa-file-word-o u-MarginRight5" aria-hidden="true"></i>--}}
                                {{--<a href="#" class="text-gray">Business Analysis</a>--}}
                            {{--</li>--}}
                            {{--<li><i class="fa fa-file-pdf-o u-MarginRight5" aria-hidden="true"></i>--}}
                                {{--<a href="#" class="text-gray">Future Gaming</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                        {{--<p class="u-MarginTop35 u-MarginBottom0">--}}
                            {{--<a class="btn-go" href="#" role="button">Download More Files <i class="fa fa-angle-right" aria-hidden="true"></i></a>--}}
                        {{--</p>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </section>
    <!--video & slides end-->

    <!--map start-->
                    <div class="position-relative" id="contact">
                        <div id="map" class="map-area"></div>
                        <div class="location-address u-BoxShadow40 hidden-xs hidden-sm">
                            <h2>
                                Taxaide Technologies Limited
                            </h2>
                            <p><i class="fa fa-map-marker"> </i> 68 Molade Okoya-Thomas Street, <br>off Ajose Adeogun Street, Victoria Island, <br>Lagos, Nigeria.</p>
                            <p> 
                                <i class="fa fa-phone"></i>
                                <a href="tel:+23414605564">+234 1460 5564</a><br>
                                <i class="fa fa-envelope"></i>
                                <a href="mailto:support@taxtech.com.ng">support@taxtech.com.ng</a>
                            </p>
                        </div>
                    </div>
    <!--map end-->
    <section class="container u-PaddingTop50 u-PaddingBottom50  u-xs-PaddingBottom30 u-xs-PaddingTop30 u-sm-PaddingTop50 u-MarginBottom03e visible-xs visible-sm">
        <div class="row">
            <div class="col-sm-12">
                <h2>
                    Taxaide Technologies Limited
                </h2>
                <p><i class="fa fa-map-marker"> </i> 68 Molade Okoya-Thomas Street, off Ajose Adeogun Street, Victoria Island, Lagos Nigeria.</p>
                <p> 
                    <i class="fa fa-phone"></i>
                    <a href="tel:+23414605564">+234 1460 5564</a><br>
                    <i class="fa fa-envelope"></i>
                    <a href="mailto:support@taxtech.com.ng">support@taxtech.com.ng</a>
                </p>
            </div>
        </div>
    </section>
    <!--footer start-->
    <footer class="bg-darker u-PaddingTop50 u-sm-PaddingTop30 u-PaddingBottom50 u-sm-PaddingBottom30 ">
        <div class="container text-center text-sm">
            <div class="row">
                <div class="col-md-4">
                    <h3 class="u-MarginTop0 u-MarginBottom30 u-Weight700">Sign Up For Our Newsletter </h3>
                    <!--<p class="u-Margin0">Subscribe to get all newsletter and publication.</p>-->
                    <form class="form-inline">
                        <div class="input-group">
                            <input class="form-control footer-form" placeholder="Enter your email address" type="email">
                        </div>
                        <button type="submit" class="btn btn-success "><i class="fa fa-send"></i></button>
                    </form>
                </div>
                <div class="col-md-4">
                    <h3 class="u-MarginTop0 u-MarginBottom20 footer-img u-Weight700">Follow us</h3>
                    <div class="social-links sl-default light-link solid-link circle-link colored-hover">
                        <a href="https://web.facebook.com/TaxTechNG/" target="_blank" class="facebook">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="https://twitter.com/TaxTechNG" target="_blank" class="twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="https://www.youtube.com/channel/UCRRjyZUO-aRb5zf84xxRQhQ" target="_blank" class="youtube">
                            <i class="fa fa-youtube"></i>
                        </a>
                        <a href="https://www.linkedin.com/company/taxtech/" target="_blank" class="twitter">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </div>                    
                </div>
                <div class="col-md-4">
                    <img class="footer-img img img-responsive" src="imgs/logo.png" alt="" style="width:150px">
                    <p class="footer-text">
                        TaxiTPayroll® provides the most robust solution for payroll taxes and related obligations in Nigeria. TaxiTPayroll® puts your mind to rest in dealing with employees' monthly salary payment expectations as well as those of the RTAs and also saves your time and costs.
                    </p>
                </div>
            </div>
            <p class="u-MarginBottom5 u-MarginTop20">© 2015 - {{ "now"|date("Y") }} Taxaide Technologies Limited.</p>
        </div>
        </div>
    </footer>
    <!--footer end-->

	<!-- end of block body -->


    <script src="{{asset('vendor/jquery/jquery-1.12.0.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('vendor/bootsnav/js/bootsnav.js')}}"></script>

    <!-- inject:js -->
    <script src="{{asset('vendor/bootsnav/js/bootsnav.js')}}"></script>
    <script src="{{asset('vendor/waypoints/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('vendor/waypoints/sticky.min.js')}}"></script>
    <script src="{{asset('vendor/headroom/headroom.min.js')}}"></script>
    <script src="{{asset('vendor/jquery.countTo/jquery.countTo.min.js')}}"></script>
    <script src="{{asset('vendor/owl.carousel2/owl.carousel.min.js')}}"></script>
    <script src="{{asset('vendor/jquery.appear/jquery.appear.js')}}"></script>
    <script src="{{asset('vendor/isotope/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('vendor/imagesloaded/imagesloaded.js')}}"></script>
    <script src="{{asset('vendor/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <!-- endinject -->

    <!--google map-->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrd_6YdReCebsIzVpS527_gAmZCK7GwHQ&amp;callback=initMap"> </script>
	<!-- AIzaSyCjCVkU7YnGfown4_i_sm6X36HP2jWTv54 -->
    <script>
        function initMap() {
            var location, map, marker;

            location = {lat: 6.4302456, lng: 3.4321778};
            map = new google.maps.Map(document.getElementById('map'), {
                center: location,
                zoom: 15,
                scrollwheel:false
            });
            marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }
    </script>
	<script type="text/javascript">

	$(document).on('click', 'a[href^="#"]', function(e) {
	    // target element id
	    var id = $(this).attr('href');

	    // target element
	    var $id = $(id);
	    if ($id.length === 0) {
	        return;
	    }

	    // prevent standard hash navigation (avoid blinking in IE)
	    e.preventDefault();

	    // top position relative to the document
	    var pos = $id.offset().top;

	    // animated top scrolling
	    $('body, html').animate({scrollTop: pos});
	});
	</script>


    </body>
</html>
