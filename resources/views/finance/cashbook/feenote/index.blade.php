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
	<div class="modal fade" id="generateFeenoteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" style="margin: 120px auto; role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalTaskTitle"> Generate Feenote</h4>
	      </div>
	      <div class="modal-body">
				<form class="form-horizontal form-bordered" id="generateFeenoteForm" method="post" action="{{route('feenote.store')}}">
					<input type="hidden" name="inputfeenotetId" id="inputfeenotetId" required>
					<input type="hidden" name="inputClientId" id="inputClientId" required>
					<div class="form-group">
						<label class="col-md-3 control-label" for="inputClientName">Client</label>
						<div class="col-md-6">
							<input type="text" name="inputClientId" id="inputClientName" class="form-control" readonly placeholder="subject">
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="inputSubject">Subject</label>
						<div class="col-md-6">
							<input type="text" name="inputSubject" id="inputSubject" class="form-control" placeholder="subject">
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="inputBankId">Bank</label>
						<div class="col-md-6">
							<select class="form-control" name="inputBankId" id="inputBankId" required>
								<option disabled=""> Select Bank</option>
								@foreach($banks as $bank)
									<option selected value="$bank->id"> {{$bank->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="inputAmount">Amount</label>
						<div class="col-md-6">
							<input type="text" name="inputAmount" id="inputAmount" class="form-control">
							</select>
						</div>
					</div>
				    <div class="modal-footer">
				    	<div class=" col-md-10 offset-md-1">
					      <button type="submit" class="btn btn-success btn-block">Remit</button>
				     	</div>
				    </div>
				</form>
	      </div>
	    </div>
	  </div>
	</div>


	<!-- start: page -->
	<section class="panel" id="feenote_section">
		<header class="panel-heading">
			<div class="panel-actions">
				<span class="label label-primary">Pending</span>
			</div>

			<h2 class="panel-title">Pending Feenotes</h2>
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
						<th width="3%">Actions</th>
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
						<a 
							id="clickTaskModal" 
							class="on-default view-row text-info" 
							data-target="#myFeeNoteModal" 
							data-id= "{{$feenote->id}}"
							data-client_id= "{{$feenote->client->id}}"
							data-client_name= "{{$feenote->client->name}}"
							data-subject= "{{$feenote->subject}}"
							data-amount= "{{ $feenote->payable}}"
							data-toggle="tooltip" 
							data-placement="top"
							title="Remit Feenote"
							href="#">
								<i class="fa fa-check"></i>
						</a> &nbsp;							
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
		<script type="text/javascript">

			$(document).on("click", "#clickTaskModal", function () {
			     var feenote_id = $(this).attr('data-id');
			     var client_id = $(this).attr('data-client_id');
			     var client_name = $(this).attr('data-client_name');
			     var subject = $(this).attr('data-subject');
			     var amount = $(this).attr('data-amount');

			     $(".modal-body #inputfeenotetId").val(feenote_id);
			     $(".modal-body #inputClientId").val(client_id);
			     $(".modal-body #inputClientName").val(client_name);
			     $(".modal-body #inputSubject").val(subject);
			     $(".modal-body #inputAmount").val(amount);
			     $('#generateFeenoteModal').modal('show');
			});

			$('#generateFeenoteForm').submit(function(e){
				e.preventDefault();
				values = {
					"_token": "{{ csrf_token() }}",
					'feenote_id': $('#inputfeenotetId').val(),
					'client_id': $('#inputClientId').val(),
					'subject': $('#inputSubject').val(),
					'amount': $('#inputAmount').val(),
					'bank_id': $('#inputBankId').val()
				};
				$.ajax({
					url: "/admin/feenote/"+$('#inputfeenotetId').val()+"/generate",
					type: "post",
					data: values ,
					success: function (response) {
						console.log(response.id);
						if (response.status == 'success') {
							$('#generateFeenoteModal').modal('toggle');
							$('#feenote_section').load( "/admin/feenote/pending #feenote_section" )
				             toastr["success"]("Feenote Remmited Successfully", "Success");
						} else {
							$('#generateFeenoteModal').modal('toggle');
				             toastr["error"](response.message, "Error");
						}
					},
					error: function(error) {
						$('#generateFeenoteModal').modal('toggle');
			             toastr["error"](error.responseJSON.message ," Error Generating Feenotes");
					}
				});				
		})
	</script>
@endsection
