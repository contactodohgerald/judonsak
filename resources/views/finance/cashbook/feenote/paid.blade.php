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
	<section class="panel" id="feenote_section">
		<header class="panel-heading">
			<div class="panel-actions">
				<span class="label label-primary">Paid</span>
			</div>

			<h2 class="panel-title">Paid Feenotes</h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered table-striped mb-none" id="datatable-default">
				<thead>
					<tr>
						<th width="2%">S/N</th>
						<th width="15%">Client</th>
						<th width="20%">Contract</th>
						<th width="15%">Amount</th>
						<th width="15%">VAT</th>
						<th width="15%">Payable</th>
						<th width="15%">Bank</th>
						<th width="3%">Paid</th>
					</tr>
				</thead>				
				<tbody>
					@foreach($feenotes as $feenote)
					<tr>
						<td>
							{{$loop->iteration}}
						</td>
						<td>
							
							<a 
								href="
									{{route('client.show',[
										'client'=>$feenote->client->slug
									])}}">
								{{$feenote->client->name}}
							</a>
						</td>
						<td>
							<a 
								href="
									{{route('client.contract.show',[
										'client'=>$feenote->client->slug, 
										'contract'=>$feenote->payment->contract->slug
									])}}">
								{{$feenote->payment->contract->name}}
							</a>

						</td>
						<td>
							{{$feenote->payment->contract->currency->name. number_format($feenote->amount, 2)}}
						</td>
						<td>
							5%
						</td>
						<td>
							{{$feenote->payable ?? 'Not Available'}}
						</td>
						<td>
							{{'GTB'}}
						</td>
						<td>
							{{$feenote->payment->contract->currency->name. number_format($feenote->paid, 2)}}
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
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
@endsection
