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
										<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
									</div>							
									<h2 class="panel-title">All Clients</h2>
								</header>
							</div>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th width="5%">S/N</th>
											<th width="40%">Clients</th>
											<th width="5%">S/N</th>
											<th width="10%">Instruction</th>
											<th width="10%">Task</th>
											<th width="20%">Manager</th>
											<th width="10%">Actions</th>
											@if(
											\Auth::user()->person->id = \Auth::user()->person->department->person_id  || \Auth::user()->person->level_id > 4)
												<th width="15%">Actions</th>
											@endif
										</tr>
									</thead>
									<tbody>
										@foreach($clients as $client)
										<tr class="gradeA">
											<td>
												{{$loop->iteration}}
												</td>
											<td><a href="{{route('client.show', ['client'=>$client->slug])}}">
												{{$client->name}}
											</a>
											</td>
											<td>													
												<table>
													<tbody>
														@foreach($client->instructions as $instruction)
														<tr style="border-bottom: 1px solid #cee;">
															<td>
																{{($insCount = $insCount + 1)}}
															</td>
															<td>
																{{$instruction->name}}
															</td>
														</tr>
														@endforeach
													</tbody>
												</table>												
											</td>
											<td>{{$client->email ?? 'No Input Yet'}}</td>
											<td>{{$client->phone_num ?? 'No Input Yet'}}</td>
											<td>{{$client->tin ?? 'No Input Yet'}}</td>
											<td>{{$client->industry ?? 'No Input Yet'}}</td>
											@if(
											\Auth::user()->person->id = \Auth::user()->person->department->person_id  || \Auth::user()->person->level_id > 4)
											<td>
												<a href="{{route('client.show', ['client' => $client->slug] )}}" class="on-default view-row text-info" data-toggle="tooltip" data-placement="top" title="Client Details">
													<i class="fa fa-eye"></i>
												</a> &nbsp;
												<a href="{{route('client.contract.create', ['client' => $client->slug] )}}" class="on-default view-row text-info" data-toggle="tooltip" data-placement="top" title="Add Contract">
													<i class="fa fa-plus"></i>
												</a> &nbsp;
												<a href="{{route('client.edit', ['client' => $client->slug])}}" class="on-default edit-row text-success" data-toggle="tooltip" data-placement="top" title="Edit Client">
													<i class="fa fa-pencil"></i>
												</a> &nbsp;
												<a href="{{route('client.destroy', ['client' => $client->slug])}}"
													onclick="event.preventDefault();
                                                     document.getElementById('delete-form{{$loop->iteration}}').submit();"
												 class="on-default remove-row text-danger" data-toggle="tooltip" data-placement="top" title="Delete Client">
													<i class="fa fa-trash-o"></i>
												</a>
			                                    <form id="delete-form{{$loop->iteration}}" action="{{route('client.destroy', ['client' => $client->slug])}}" method="POST" style="display: none;">
												    <input type="hidden" name="_method" value="DELETE">
			                                        @csrf
			                                    </form>									
											</td>
											@endif
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
