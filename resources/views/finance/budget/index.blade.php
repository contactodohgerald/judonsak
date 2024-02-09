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
@endsection


@section('body')

					<!-- start: page -->
						<section class="panel">
							<div class="panel-heading">
								<header>
									<div class="panel-actions">
										<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										{{-- <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a> --}}
									</div>							
									<h2 class="panel-title">Latest Budgets</h2>
								</header>
							</div>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th width="4%">S/N</th>
											<th width="20%">Name</th>
											<th width="20%">Revenue</th>
											<th width="25%">Recievables</th>
											<th width="10%">Expenditures</th>
											<th width="13%">Liabilities</th>
											<th width="15%">Status</th>
										</tr>
									</thead>
									<tbody>
										@foreach($budgets as $budget)
										<tr class="gradeA">
											<td>
												{{$loop->iteration}}
												</td>
											<td><a href="{{route('budget.show', ['budget'=>$budget->slug])}}">
												{{$budget->name}}
											</a>
											</td>
											<td>NGN {{number_format($budget->revenues->where('category_id','=',1)->sum('total')) }}</td>
											<td>NGN {{number_format($budget->revenues->where('category_id','=',2)->sum('total')) }}</td>
											<td>NGN {{number_format($budget->expenditures->where('status_id','=',22)->sum('total')) }}</td>
											<td>NGN {{number_format($budget->expenditures->where('status_id','=',4)->sum('total')) }}</td>
											<td>
												{{$budget->status->name}}		
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</section>

@endsection

@section('js')
		<!-- Vendor -->
		<script src="{{asset('assets/vendor/jquery/jquery.js')}}"></script>
		<script src="{{asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js')}}"></script>
		<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.js')}}"></script>
		<script src="{{asset('assets/vendor/nanoscroller/nanoscroller.js')}}"></script>
		<script src="{{asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
		<script src="{{asset('assets/vendor/magnific-popup/magnific-popup.js')}}"></script>
		<script src="{{asset('assets/vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>
		
		<!-- Specific Page Vendor -->
		<script src="{{asset('assets/vendor/select2/select2.js')}}"></script>
		<script src="{{asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js')}}"></script>
		<script src="{{asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js')}}"></script>
		<script src="{{asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js')}}"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="{{asset('assets/javascripts/theme.js')}}"></script>
		
		<!-- Theme Custom -->
		<script src="{{asset('assets/javascripts/theme.custom.js')}}"></script>
		
		<!-- Theme Initialization Files -->
		<script src="{{asset('assets/javascripts/theme.init.js')}}"></script>


		<!-- Examples -->
		<script src="{{asset('assets/javascripts/tables/examples.datatables.default.js')}}"></script>
		<script src="{{asset('assets/javascripts/tables/examples.datatables.row.with.details.js')}}"></script>
		<script src="{{asset('assets/javascripts/tables/examples.datatables.tabletools.js')}}"></script>

@endsection
