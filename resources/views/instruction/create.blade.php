{{--@extends('layouts.admin')--}}
@extends("layouts.".\Auth::user()->person->department->slug )
 
@section('css')
		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="{{asset('assets/vendor/select2/select2.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css')}}" />
		<link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

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
					<div class="row">
						<div class="col-md-12">
							<form action="{{route('instruction.store')  }} " method="POST" class="form-horizontal">
								@csrf
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										</div>

										<h2 class="panel-title">Create New Instruction</h2>
									</header>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-2 control-label"> Client <span class="required">*</span>
											</label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-user"></i>
													</span>
												<select name="client" id="selectClient" class="form-control" required>
													<option disabled selected> Select Client</option>
													@foreach($clients as $client)
														<option value="{{$client->id}}"> 
															{{$client->name }} 
														</option>
													@endforeach
												</select>
												<label class="error" for="selectClient"></label>
												</div>
												@if($errors->has('service'))
													<span class="text-danger"> {{$errors->first('service')}}</span>
												@endif
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label"> Contract <span class="required">*</span>
											</label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-user"></i>
													</span>
												<select id="selectContract" name="contract" class="form-control" required>
													<option disabled selected> Select Contract</option>
													{{--@if(null == $instruction)
													@endif
													@foreach($contract->services as $service)
														@if(null!== $instruction)
															@if($service->id == $instruction->service_id)
																<option value="{{$service->id}}" selected>{{$service->name}}</option>
															@else
																<option value="{{$service->id}}">{{$service->name}}</option>
															@endif
														@elseif(null !== old('service'))
															@if($service->id == old('service'))
																<option value="{{$service->id}}" selected>{{$service->name}}</option>
															@else
																<option value="{{$service->id}}">{{$service->name}}</option>
															@endif
														@else
															<option value="{{$service->id}}">{{$service->name}}</option>
														@endif
													@endforeach--}}

												</select>
												<label class="error" for="service"></label>
												</div>
												@if($errors->has('service'))
													<span class="text-danger"> {{$errors->first('service')}}</span>
												@endif
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label"> Services <span class="required">*</span>
											</label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-user"></i>
													</span>
												<select id="selectService" name="service" class="form-control" required>
													<option disabled selected> Select Service</option>
												</select>
												<label class="error" for="service"></label>
												</div>
												@if($errors->has('service'))
													<span class="text-danger"> {{$errors->first('service')}}</span>
												@endif
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Instruction <span class="required">*</span></label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-book"></i>
													</span>
													<input type="text" name="instruction" class="form-control" placeholder="eg.: General Advisory Service" value ="{{ (null == $instruction) ? old('instruction') : $instruction->name}} " required/>
												</div>
												@if($errors->has('instruction'))
												<span class="text-danger"> {{$errors->first('instruction')}}</span>
												@endif
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label">Add Members <span class="required">*</span></label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-user"></i>
													</span>
												<select id="person" name="people[]" multiple data-plugin-selectTwo class="form-control populate"  value ="{{ (null == $contract) ? old('person') : $contract->person}}" required>
													@if(null== $instruction)
														<option disabled selected> Add a Staff</option>
													@endif
													@if(null!== old('people'))
														@foreach($people as $person)
															@if( in_array( $person->id, old('people')) )
																<option value="{{$person->id}}" selected>{{$person->first_name .' '. $person->last_name}}
																</option>
															@else
																<option value="{{$person->id}}">{{$person->first_name .' '. $person->last_name}}</option>
															@endif
														@endforeach
													@elseif(null !== $instruction)
														@foreach($people as $person)
															@if(in_array(
																$person->id, 
																array_column(
																	$instruction->person->toArray(), 'id')
																	))
																<option value="{{$person->id}}" selected>{{$person->first_name .' '. $person->last_name}}</option>
																@endif
															{{--@endforeach--}}

															<option value="{{$person->id}}">{{$person->first_name .' '. $person->last_name}}</option>

														@endforeach
													@else
														@foreach($people as $person)
														<option value="{{$person->id}}">
															{{$person->first_name .' '. $person->last_name}}</option>
														@endforeach
													@endif

												</select>
												<label class="error" for="person"></label>
												</div>
												@if($errors->has('person'))
												<span class="text-danger"> {{$errors->first('person')}}</span>
												@endif
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Remark <span class="required">*</span></label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-suitcase"></i>
													</span>
													<input type="text" name="remark" class="form-control" placeholder="Add remark to instruction" value ="{{ (null === $instruction) ? old('remark') : $instruction->remark}}" required/>
												</div>
												@if($errors->has('remark'))
												<span class="text-danger"> {{$errors->first('remark')}}</span>
												@endif
											</div>
										</div>
									</div>
									<footer class="panel-footer">
										<div class="row">
											<div class="col-sm-8 col-sm-offset-2">
												<button class="btn btn-success btn-block">Submit</button>
											</div>
										</div>
									</footer>
								</section>
							</form>
						</div>
					</div>


@endsection

@section('js')
	<!-- Specific Page Vendor -->
	<script src="{{asset('assets/vendor/select2/select2.js')}}"></script>
	<script src="{{asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js')}}"></script>
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

	<script type="text/javascript">
		$(document).ready( function (){
			$("#selectClient").change(function(){
				let attachContract = $('#selectContract');
				$('#selectContract option').remove();
				let clientId = $("#selectClient").val();
				let selectClientURL = 'new/select/client/api/'+clientId;
				let setContract = `<option selected> Select Contract </option>`
				attachContract.append(setContract);
				$.ajax({
					url : selectClientURL,
					type : 'GET',
					success : function (res){
						for(let attach of res){
							let contract = `<option value="${attach.id}"> ${attach.name}</option>`
							attachContract.append(contract);
						}
					},
					error : function (res){
						console.log(res);
					}
				});
			});

			$("#selectContract").change(function(){
				let selectService = $('#selectService');
				$('#selectService option').remove();
				let contractId = $("#selectContract").val();
				let selectContractURL = 'new/select/contract/api/'+contractId;
				let setService = `<option selected> Select Contract </option>`
				selectService.append(setService);
				$.ajax({
					url : selectContractURL,
					type : 'GET',
					success : function (res){
						for(let attach of res){
							let service = `<option value="${attach.id}"> ${attach.name}</option>`
							selectService.append(service);
						}
					},
					error : function (res){
						console.log(res);
					}
				});
			});

		})

	</script>


@endsection
