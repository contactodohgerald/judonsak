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
							<form action="{{ (null == $task) ? 
							route('instruction.task.store', ['instruction' => $instruction->slug]) : route('instruction.task.update', ['instruction' => $instruction->slug, 'task' => $task->slug]) }} " method="POST" class="form-horizontal">
								@csrf
								@if(null !== $task)
								    <input type="hidden" name="_method" value="PUT">
								@endif
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										</div>

										<h2 class="panel-title">{{(null == $task) ?'Create New Task' : 'Edit Task'}}</h2>
									</header>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-2 control-label">Task <span class="required">*</span></label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-book"></i>
													</span>
													<input type="text" name="task" class="form-control" placeholder="eg.: Pay Client Tax" value ="{{(null == $task) ? old('task') : $task->name}} " required/>
												</div>
												@if($errors->has('task'))
												<span class="text-danger"> {{$errors->first('task')}}</span>
												@endif
											</div>
										</div>



										<div class="form-group">
											<label class="col-sm-2 control-label">Assign To <span class="required">*</span></label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-user"></i>
													</span>
												<select id="people" name="people[]" multiple data-plugin-selectTwo class="form-control populate" required>
													@if(null!== old('people'))
														@foreach($people as $person)
															@if( in_array( $person->id, old('people')) )
																<option value="{{$person->id}}" selected>{{$person->first_name .' '. $person->last_name}}
																</option>
															@else
																<option value="{{$person->id}}">{{$person->first_name .' '. $person->last_name}}</option>
															@endif
														@endforeach
													@else
														<option disabled selected> Add a Staff</option>
														@foreach($people as $person)
														<option value="{{$person->id}}">
															{{$person->first_name .' '. $person->last_name}}</option>
														@endforeach
													@endif

												</select>
												<label class="error" for="people"></label>
												</div>
												@if($errors->has('people'))
												<span class="text-danger"> {{$errors->first('people')}}</span>
												@endif
											</div>
										</div>




										<div class="form-group">
											<label class="col-sm-2 control-label">Description <span class="required">*</span></label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-suitcase"></i>
													</span>
													<textarea name="description" rows="5"  class="form-control" placeholder="Add more Description to Task" required>{{ (null === $task) ? old('description') : $task->description}}</textarea>
												</div>
												@if($errors->has('description'))
												<span class="text-danger"> {{$errors->first('description')}}</span>
												@endif
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Deadline 
											</label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</span>
													<input type="text" data-plugin-datepicker name="deadline" class="form-control" placeholder="Deadline" value ="{{ (null == $task) ? old('deadline') : $task->deadline}}" />
												</div>
												@if($errors->has('deadline'))
												<span class="text-danger"> {{$errors->first('deadline')}}</span>
												@endif
											</div>
										</div>

									@if(null !== $task)
										<div class="form-group">
											<label class="col-sm-2 control-label">Status 
											</label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</span>

												<select id="status" name="status" class="form-control" 
												value ="{{ (null == $task) ? 
													old('status') : $task->status_id}}"
													required >
													@if(null== $task)
														<option disabled selected> Select Tas Status</option>
													@endif
													@if(null!== old('status'))
														@foreach($status as $stats)
															@if( $stats->id ==  old('status') )
																<option value="{{$stats->id}}" selected>
																	{{$stats->name}}
																</option>
															@else
																<option value="{{$stats->id}}">
																	{{$stats->name}}
																</option>
															@endif
														@endforeach
													@elseif(null !== $task)
														@foreach($status as $stats)
															@if($stats->id == $task->status_id)
																<option value="{{$stats->id}}" selected>
																	{{$stats->name}}
																</option>
															@else
																<option value="{{$stats->id}}">
																	{{$stats->name}}
																</option>
															@endif
														@endforeach
													@else
														@foreach($status as $stats)
															<option value="{{$stats->id}}">
																{{$stats->name}}
															</option>
														@endforeach
													@endif

												</select>
												</div>
												@if($errors->has('status'))
												<span class="text-danger"> {{$errors->first('status')}}</span>
												@endif
											</div>
										</div>
									@endif
									
									</div>
									<footer class="panel-footer">
										<div class="row">
											<div class="col-sm-8 col-sm-offset-2">
												<button class="btn btn-success" style="width: 49%">Submit</button>
												<a href="{{route('instruction.task.index', ['instruction' => $instruction->slug] )}}" class="btn btn-default" style="width: 50%">Instructions</a>
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
