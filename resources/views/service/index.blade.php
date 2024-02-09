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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" style="margin: 120px auto; role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalTaskTitle"></h4>
      </div>
      <div class="modal-body">
      	<div id="taskModalTable">
      		
      	</div>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myContractModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" style="margin: 120px auto; role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalContractTitle"></h4>
      </div>
      <div class="modal-body">
      	<div id="contractModalTable">
      		
      	</div>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myInstructionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" style="margin: 120px auto; role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalInstructionTitle"></h4>
      </div>
      <div class="modal-body">
      	<div id="instructionModalTable">
      		
      	</div>
      </div>
    </div>
  </div>
</div>


	<!-- start: page -->
	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
				<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
			</div>

			<h2 class="panel-title">Desks Insights</h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered table-striped mb-none" id="datatable-default">
				<thead>
					<tr>
						<th width="5%">S/N</th>
						<th width="40%">Desks</th>
						<th width="10%">Contracts</th>
						<th width="15%">Instructions</th>
						<th width="15%">Tasks</th>
						<th width="15%">Generated</th>
					</tr>
				</thead>				
				<tbody>
					@foreach($services as $service)
					<tr>
						<td>
							{{$loop->iteration}}
						</td>

						<td>
							{{$service->name}}
						</td>
						<td>
							<a style="cursor: pointer;"
								id="clickContractModal" 
								class="on-default view-row text-info"
								data-target="#clickContractModal" 
								data-id= "{{$service->id}}"
								data-toggle="tooltip" 
								data-placement="top">							
								{{ $service->contracts->count(). ' Contract(s)' }}
							</a>
						</td>
						<td>
							<a style="cursor: pointer;"
								id="clickInstructionModal" 
								class="on-default view-row text-info"
								data-target="#myInstructionModal" 
								data-id= "{{$service->id}}"
								data-toggle="tooltip" 
								data-placement="top">
									{{$service->instructions->count(). ' Instruction(s)'}}
								</a>
						</td>
						<td>
							<a style="cursor: pointer;"
								id="clickTaskModal" 
								class="on-default view-row text-info"
								data-target="#myModal" 
								data-id= "{{$service->id}}"
								data-toggle="tooltip" 
								data-placement="top">
								{{$service->tasks->count(). ' Task(s)'}}
							</a>
						</td>
						<td>{{$service->contracts()->sum('amount')}}</td>
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
		<script type="text/javascript">


			$(document).on("click", "#clickTaskModal", function () {
			    var id  = $(this).attr('data-id');
				$.ajax({
					url: "/admin/desk/task/api/"+id,
					type: "get",
					success: function (response) {
						if (response.status = 'success') {
							console.log(response);
							let row ='';
							for (var i = 0; i < response.task.length; i++ ) {
								row += 	`<tr>
											<td> ${i + 1}</td>
											<td> <a href="/admin/service/task/${response.task[i].slug}">${response.task[i].name}</a></td>
											<td> ${response.task[i].description}</td>
										</tr>`;
							}
							let table = `
							<div id="removeTaskModal">
							<header class="panel-heading">
								<h2 class="panel-title">Task Details</h2>
							</header>							
							<table class="table table-bordered table-striped mb-none" id="datatable-default">
								<thead>
									<tr>
										<th width="5%">S/N</th>
										<th width="40%">Name</th>
										<th width="55%">Description</th>
									</tr>
								</thead>				
								<tbody>
									${row}
								</tbody>
							</table>`;

							$('#taskModalTable').append(table);
			     			$('#myModal').modal('show');

						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
					 console.log(textStatus, errorThrown);
					}


				});
			});

			$("#myModal").on("hidden.bs.modal", function () {
			    $('#removeTaskModal').remove();
			});

			$("#myInstructionModal").on("hidden.bs.modal", function () {
			    $('#removeInstructionModal').remove();
			});

			$("#myContractModal").on("hidden.bs.modal", function () {
			    $('#removeContractModal').remove();
			});

			$(document).on("click", "#clickInstructionModal", function () {
			    var id  = $(this).attr('data-id');
				$.ajax({
					url: "/admin/desk/instruction/api/"+id,
					type: "get",
					success: function (response) {
						console.log(response);
						if (response.status = 'success') {
							let row ='';
							for (var i = 0; i < response.instructions.length; i++ ) {
								row += 	`<tr>
											<td> ${i + 1}</td>
											<td> <a href="/admin/service/task/${response.instructions[i].slug}">${response.instructions[i].name}</a></td>
											<td> ${response.instructions[i].remark}</td>
										</tr>`;
							}
							let table = `
							<div id="removeInstructionModal">
							<header class="panel-heading">
								<h2 class="panel-title">Instruction Details</h2>
							</header>							
							<table class="table table-bordered table-striped mb-none" id="datatable-default">
								<thead>
									<tr>
										<th width="5%">S/N</th>
										<th width="40%">Name</th>
										<th width="55%">Remark</th>
									</tr>
								</thead>				
								<tbody>
									${row}
								</tbody>
							</table>`;

							$('#instructionModalTable').append(table);
			     			$('#myInstructionModal').modal('show');
						}
					},
					error: function(response){
					}
				});

			});


			$(document).on("click", "#clickContractModal", function () {
			    var id  = $(this).attr('data-id');
				$.ajax({
					url: "/admin/desk/contract/api/"+id,
					type: "get",
					success: function (response) {
						console.log(response.contracts.contracts[0].client.name, response.contracts);
						if (response.status = 'success') {
							let row ='';
							for (var i = 0; i < response.contracts.contracts.length; i++ ) {
								row += 	`<tr>
											<td> ${i + 1}</td>
											<td> <a href="/client/${response.contracts.contracts[i].client.slug}/contract/${response.contracts.contracts[i].slug}">${response.contracts.contracts[0].name}</a></td>
											<td> <a href="/client/${response.contracts.contracts[i].client.slug}">${response.contracts.contracts[i].client.name}</a></td>
										</tr>`;
							}
							console.log(row)
							let table = `
							<div id="removeContractModal">
							<header class="panel-heading">
								<h2 class="panel-title">Contract Details</h2>
							</header>							
							<table class="table table-bordered table-striped mb-none" id="datatable-default">
								<thead>
									<tr>
										<th width="5%">S/N</th>
										<th width="70%">Name</th>
										<th width="25%">Client</th>
									</tr>
								</thead>				
								<tbody>
									${row}
								</tbody>
							</table>`;

							$('#contractModalTable').append(table);
			     			$('#myContractModal').modal('show');
						}
					},
					error: function(response){
					}
				});

			});


		</script>


@endsection
