<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<meta name="keywords" content="HTML5 Admin Template" />
		<meta name="description" content="Porto Admin - Responsive HTML5 Template">
		<meta name="author" content="okler.net">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.css')}}" />

		<link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/vendor/magnific-popup/magnific-popup.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-datepicker/css/datepicker3.css')}}" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="{{asset('assets/stylesheets/theme.css')}}" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="{{asset('assets/stylesheets/skins/default.css')}}" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="{{asset('assets/stylesheets/theme-custom.css')}}">

		<!-- Head Libs -->
		<script src="{{asset('assets/vendor/modernizr/modernizr.js')}}"></script>
	</head>
	<body>
		<!-- start: page -->
			<section class="body-error error-outside">
				<div class="center-error">

					<div class="error-header">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-8">
										<a href="/" class="logo">
											<img src="{{asset('imgs/logo.png')}}" height="54" alt="TaxitManager" />
										</a>
									</div>
									<div class="col-md-4">
										<form class="form">
											<div class="input-group input-search">
												<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
												<span class="input-group-btn">
													<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
												</span>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<div class="main-error mb-xlg">
								<h2 class="error-code text-dark text-center text-weight-semibold m-none">403 <i class="fa fa-file"></i></h2>
								<p class="error-explanation text-center">{{ $exception->getMessage() }}</p>
							</div>
						</div>
						<div class="col-md-4">
							<h4 class="text">Here are some useful links</h4>
							<ul class="nav nav-list primary">
								<li>
									<a href="{{route('dashboard')}}"><i class="fa fa-caret-right text-dark"></i> Dashboard</a>
								</li>
								<li>
									<a href="{{ url()->previous() }}"><i class="fa fa-caret-right text-dark"></i> Back</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</section>
		<!-- end: page -->

		<!-- Vendor -->
		<script src="{{asset('assets/vendor/jquery/jquery.js')}}"></script>
		<script src="{{asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>
		<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.js')}}"></script>
		<script src="{{asset('assets/vendor/nanoscroller/nanoscroller.js')}}"></script>
		<script src="{{asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
		<script src="{{asset('assets/vendor/magnific-popup/magnific-popup.js')}}"></script>
		<script src="{{asset('assets/vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="{{asset('assets/javascripts/theme.js')}}"></script>
		
		<!-- Theme Custom -->
		<script src="{{asset('assets/javascripts/theme.custom.js')}}"></script>
		
		<!-- Theme Initialization Files -->
		<script src="{{asset('assets/javascripts/theme.init.js')}}"></script>

	</body>
</html>