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
							<form action="{{ (null == $instruction) ? 
							route('contract.instruction.store', ['contract' => $contract->slug]) : route('contract.instruction.update', ['contract' => $contract->slug, 'instruction' => $instruction->slug]) }} " method="POST" class="form-horizontal">
								@csrf
								@if(null !== $instruction)
								    <input type="hidden" name="_method" value="PUT">
								@endif
								    <input type="hidden" name="contract" value="{{$contract->id}}">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										</div>

										<h2 class="panel-title">{{(null == $instruction) ?'Create New Instruction' : 'Edit Instruction'}}</h2>
									</header>
									<div class="panel-body">
										@if(null != $instruction)
										<div class="form-group">
											<label class="col-sm-2 control-label"> Contract 
												<span class="required">*</span>
											</label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-book"></i>
													</span>
													<select name="selectcontract" class="form-control">
													@if(null == $instruction)
														<option disabled selected> Select Contract</option>
													@endif
													@foreach($otherContracts as $contract)
														@if(null!== $instruction)
															@if($contract->id == $instruction->contract_id)
																<option value="{{$contract->id}}" selected>{{$contract->name}}</option>
															@else
																<option value="{{$contract->id}}">{{$contract->name}}</option>
															@endif
														@elseif(null !== old('contract'))
															@if($contract->id == old('contract'))
																<option value="{{$contract->id}}" selected>{{$contract->name}}</option>
															@else
																<option value="{{$contract->id}}">{{$contract->name}}</option>
															@endif
														@else
															<option value="{{$contract->id}}">{{$contract->name}}</option>
														@endif
													@endforeach
													</select>
												</div>
												@if($errors->has('instruction'))
												<span class="text-danger"> {{$errors->first('instruction')}}</span>
												@endif
											</div>
										</div>
										@endif
										<div class="form-group">
											<label class="col-sm-2 control-label"> Services <span class="required">*</span>
											</label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-user"></i>
													</span>
												<select id="service" name="service" class="form-control" required>
													@if(null == $instruction)
														<option disabled selected> Select Service</option>
													@endif
													@foreach($services as $service)
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
													@endforeach
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
											<label class="col-sm-2 control-label">Add Managers <span class="required">*</span></label>
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
																<option 
																value="{{$person->id}}" 
																selected>
																{{ $person->first_name . ' '.
																	$person->last_name
																}}
																</option>
															@else
																<option value="{{$person->id}}">
																	{{ $person->first_name . ' ' 
																	.$person->last_name
																	}}
																</option>
															@endif
														@endforeach
													@elseif(null !== $instruction)
														@foreach($people as $person)
															@if(in_array(
																$person->id, 
																array_column(
																	$instruction->person->toArray(), 'id')
																	))
																<option value="{{$person->id}}" selected>{{$person->first_name.' '.$person->last_name}}</option>
																@endif
															{{--@endforeach--}}

															<option value="{{$person->id}}">{{$person->first_name. ''. $person->last_name}}</option>

														@endforeach
													@else
														@foreach($people as $person)
														<option value="{{$person->id}}">{{$person->first_name.' '. $person->last_name}}</option>
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
												<button 
												class="btn btn-success btn-block">
												{{(null == $instruction) ?'Create' : 'Update'}}
												</button>
												{{--<a 
												href="{{route('instruction.index')}}" 
												class="btn btn-info" 
												style="width: 50%">
													Instructions
												</a>--}}
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

@endsection
