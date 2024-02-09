{{--@extends('layouts.admin')--}}
@extends("layouts.".\Auth::user()->person->department->slug )
 
@section('css')
		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />

		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/select2/select2.css" />
		<link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>
@endsection


@section('body')

		<section class="panel-featured panel-featured-success">
			<header class="panel-heading">
				<div class="panel-actions">
					<!-- <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a> -->
				</div>

				<h1 class="panel-title text-center"> <span class="text-primary"> Instruction :</span> {{$instruction->name}}</h1><br>
				<div class="row">
					<div class="col-sm-6">
						<p class="panel-subtitle"> Client : 
							<strong> 
								{{$instruction->contract->client->name}} 
							</strong>
						</p>
						<p class="panel-subtitle">
							Status : {{$instruction->status->name}}
						</p>
						<p class="panel-subtitle">
							<a 
							href="{{
							route('instruction.task.create',
							['instruction'=>$instruction->slug])}}" 
							class="btn btn-success btn-xs"> 
							<i class="fa fa-plus"></i> Add Task
							</a>
						</p>
					</div>
					<div class="col-sm-6">
						<p class="panel-subtitle"> Contract : 
							<strong> 
								{{$instruction->contract->name}} 
							</strong>
						</p>
						<p class="panel-subtitle">
							Service : {{$instruction->service->name}}
						</p>
						<p class="panel-subtitle">
							Remark : {{$instruction->name}}
						</p>
					</div>
				</div>
			</header>
		</section>
	<!-- start: page -->
		<section class="panel-featured panel-featured-primary">
			<header class="panel-heading">
				<div class="panel-actions">
					<a 
						href="{{
							route('instruction.task.create',
							['instruction'=>$instruction->slug])}}" 
						data-toggle="tooltip" 
						data-placement="top" 
						title="Add New Task" 
						class="btn btn-info btn-xs"> 
					<i class="fa fa-plus"></i></a>
				</div>				
				<h2 class="panel-title">Tasks</h2>
			</header>
			<div class="panel-body">
				<table class="table table-bordered table-striped mb-none" id="datatable-default">
					<thead>
						<tr>
							<th width="20%">Task</th>
							<th width="15%">Assigned</th>
							<th width="30%">Description</th>
							<th width="12%">Status</th>
							<th width="13%">Deadline</th>
							<th width="10%">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($instruction->tasks as $task)
						<tr class="gradeA">
							<td> 
								<a 
									href="{{route('instruction.task.show', ['instruction' => $instruction->slug, 'task' => $task->slug] )}}" 
									class="on-default view-row text-info" 
									data-toggle="tooltip" 
									data-placement="top" 
									title="View task Details"
								>
									{{$task->name}}
								</a>
							</td>
							<td>
								<table>
									<tbody>									
									@foreach($task->people as $person)
											<tr>
												<td>
													<a href="{{route('profile.show', ['profile'=>$person->slug])}}"
														data-toggle="tooltip" 
														data-placement="top" 
														title="View Proile Details">
														{{$person->first_name}} {{$person->last_name}}
													</a>
												</td>
											</tr>
									@endforeach
									</tbody>
								</table>
							</td>
							<td> {{$task->description}}</td>
							<td>{{$task->status->name}}</td>
							<td>{{$task->deadline}}</td>
							<td>								
								<a href="{{route('instruction.task.edit', ['instruction' => $instruction->slug, 'task' => $task->slug])}}" class="on-default edit-row text-success" data-toggle="tooltip" data-placement="top" title="Edit Task">
									<i class="fa fa-pencil"></i>
								</a> &nbsp;

								<a href="{{route('instruction.task.destroy', ['instruction' => $instruction->slug, 'task' => $task->slug]) }}"
									onclick="event.preventDefault();
								 	if(confirm('Are you sure you want to PERMANENTLY delete this Task')){
	                                 document.getElementById('delete-form-{{$loop->iteration}}').submit();
								 	}"
								 class="on-default remove-row text-danger" data-toggle="tooltip" data-placement="top" title="Delete task">
									<i class="fa fa-trash-o"></i>
								</a>
                                <form 
                                id="delete-form-{{$loop->iteration}}" 
                                action="{{route('instruction.task.destroy', ['instruction' => $instruction->slug, 'task' => $task->slug])}}" 
                                method="POST" 
                                style="display: none;">
								    <input 
								    type="hidden" 
								    name="_method" 
								    value="DELETE">
                                    @csrf
                                </form>									
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
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/select2/select2.js"></script>
		<script src="assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
		<script src="assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<script src="assets/javascripts/tables/examples.datatables.default.js"></script>
		<script src="assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
		<script src="assets/javascripts/tables/examples.datatables.tabletools.js"></script>

@endsection
