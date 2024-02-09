{{--@extends('layouts.admin')--}}
@extends("layouts.".\Auth::user()->person->department->slug )
@section('css')
	<!-- Vendor CSS -->
	<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.css')}}" />

	<link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/vendor/magnific-popup/magnific-popup.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-datepicker/css/datepicker3.css')}}" />

	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="{{asset('assets/vendor/select2/select2.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />

	<!-- Theme CSS -->
	<link rel="stylesheet" href="{{asset('assets/stylesheets/theme.css')}}" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="{{asset('assets/stylesheets/skins/default.css')}}" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="{{asset('assets/stylesheets/theme-custom.css')}}">

	<!-- Head Libs -->
	<script src="{{asset('assets/vendor/modernizr/modernizr.js')}}"></script>
	<style type="text/css">
		.document-link :hover .panel-heading-icon{ 
			color: #cee !important;
		}
		.document-link :hover .panel-body{ 
			color: #5db146 !important;
		}
		
	</style>
@endsection
@section('body')
	<!-- start: page -->
	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
				<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
			</div>

			<h2 class="panel-title">{{$client->name.' Documents'}}</h2>
		</header>
		<div class="panel-body">
			<div class="row" id="app-vue">
				@foreach($folders as $folder)
				<div class="col-md-4">
					<a href="{{route('document.client.document', ['client' => $client->slug, 'folder' => $folder->id])}}" class="document-link" style="text-decoration: none">
						<section class="panel">
							<header class="panel-heading bg-info">
								<div class="panel-heading-icon">
									<i class="fa fa-file-text-o"></i>
								</div>
								<div class="text-center">
									<i>{{$folder->documents->count().' document'}}</i>
								</div>
							</header>
							<div class="panel-body text-center" style="border: 1px solid #cee">
								<h4 class="text-weight-semibold mt-sm text-center" style="min-height: 70px;">{{$folder->name}}</h4>
							</div>
						</section>
					</a>
				</div>
				@endforeach
			</div>
		</div>
	</section>

@endsection

@section('js')
				<!-- Specific Page Vendor -->
		<script src="{{asset('assets/vendor/select2/select2.js')}}"></script>
		<script src="{{asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js')}}"></script>
		<script src="{{asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js')}}"></script>
		<script src="{{asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js')}}"></script>

		<!-- Examples -->
		<script src="{{asset('assets/javascripts/tables/examples.datatables.default.js')}}"></script>
		<script src="{{asset('assets/javascripts/tables/examples.datatables.row.with.details.js')}}"></script>
		<script src="{{asset('assets/javascripts/tables/examples.datatables.tabletools.js')}}"></script>


		<!-- Specific Page Vendor -->
		<script src="{{asset('assets/vendor/pnotify/pnotify.custom.js')}}"></script>
@endsection
