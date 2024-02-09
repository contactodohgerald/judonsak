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
	<div class="modal fade" id="newBankModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" style="margin: 10px auto; role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalBankTitle">
				<h2 class="panel-title">{{'Create Bank'}}</h2>	        	
	        </h4>
	      </div>
	      <div class="modal-body">
			<form 
			action="/admin/modal/save/task" 
			method="POST" 
			class="form-horizontal">
				@csrf
				<input type="hidden" name="bank" id="inputbank">
				<section class="panel">
					<div class="panel-body">
						<div class="form-group">
							<label class="col-sm-2 control-label">Name <span class="required">*</span></label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-book"></i>
									</span>
									<input type="text" name="name" id="inputName" class="form-control" placeholder="eg.: Central Bank" value ="" required/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Label <span class="required">*</span></label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-book"></i>
									</span>
									<input type="text" name="label" id="inputLabel" class="form-control" placeholder="eg.: 001" value ="" required/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Account <span class="required">*</span></label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-book"></i>
									</span>
									<input type="text" name="account" id="inputAccount" class="form-control" placeholder="eg.: 0123456789" value ="" required/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Currency <span class="required">*</span></label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-book"></i>
									</span>
									<select name="currency" class="form-control" id="inputCurrency" required>
										<option value="1">NGN</option>
										<option value="2">USD</option>
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Balance <span class="required">*</span></label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-book"></i>
									</span>
									<input type="text" name="balance" id="inputBalance" class="form-control" placeholder="eg.: 500000 do not add commas" value ="" required/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Account Officer</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-user"></i>
									</span>
									<input type="text" name="officer" id="inputOfficer" class="form-control" placeholder="eg.: Sholotan Joseph" value ="" required/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Officer Number</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-book"></i>
									</span>
									<input type="text" name="officer_number" id="inputOfficerNumber" class="form-control" placeholder="eg.: Sholotan Joseph" value ="" required/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Officer Mail </label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-envelope"></i>
									</span>
									<input type="email" name="officer_email" id="inputOfficerMail" class="form-control" placeholder="eg.: s.joseph@taxaide.com.ng" value ="" required/>
								</div>
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
	  </div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="updateBankModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" style="margin: 120px auto; role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="updateModalBankTitle"></h4>
	      </div>
	      <div class="modal-body update-modal-body">
			<form  action="" method="post" 
			class="form-horizontal">
				@csrf
				<input type="hidden" name="updateBankId" id="updateBankId" value="">
				<section class="panel">
					<header class="panel-heading">
						<h2 class="panel-title">{{'Update Bank Balance'}}</h2>
					</header>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-sm-2 control-label">Name <span class="required">*</span></label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-book"></i>
									</span>
									<input type="text" readonly name="updateName" id="updateName" class="form-control" placeholder="eg.: Central Bank" value ="" required/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Account Officer <span class="required">*</span></label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-book"></i>
									</span>
									<input type="text" name="officer" id="updateOfficerModal" class="form-control" placeholder="Officer Name" value ="" required/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Officer Number <span class="required">*</span></label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-book"></i>
									</span>
									<input type="text" name="officer_number" id="updateOfficerNumberModal" class="form-control" placeholder="Officer's number" value ="" required/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Officer Email <span class="required">*</span></label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-book"></i>
									</span>
									<input type="text" name="officer_email" id="updateOfficerEmailModal" class="form-control" placeholder="Officer's email" value ="" required/>
								</div>
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
	  </div>
	</div>

	<!-- start: page -->
	<section class="panel" id="sectionBody">
		<header class="panel-heading">
			<div class="panel-actions">
						<button id="clickBankModal" 
							class="btn-success mb-xs mt-xs mr-xs btn btn-xs pull-right" 
							data-target="#newBankModal" 
							data-toggle="tooltip" 
							data-placement="top" 
							title="Add New Bank">
								<i class="fa fa-plus"></i> Add New</button>
			</div>
			<h2 class="panel-title">Banks</h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered table-striped mb-none" id="datatable-default">
				<thead>
					<tr>
						<th width="5%">S/N</th>
						<th width="10%">Name</th>
						<th width="15%">Account</th>
						<th width="15%">Balance</th>
						<th width="15%">Officer</th>
						<th width="10%">Number</th>
						<th width="15%">Email</th>
						<th width="15%">Update</th>
					</tr>
				</thead>				
				<tbody>
					@foreach($banks as $bank)
					<tr>
						<td>
							{{$loop->iteration}}
						</td>

						<td>					
							{{$bank->name}} {{$bank->label}} {{$bank->currency->name}}
						</td>
						<td>					
							{{$bank->acc_number}}
						</td>
						<td>					
							{{$bank->currency->name.number_format($bank->balance,2)}}
						</td>
						<td>					
							{{$bank->acc_officer}}
						</td>
						<td>					
							{{$bank->acc_officer_number}}
						</td>
						<td>					
							{{$bank->acc_officer_email}}
						</td>
						<td>
							<button 
							id="clickUpdateBankModal" 
							class="mb-xs mt-xs mr-xs btn btn-xs btn-info" 
							data-target="#updateBankModal" 
							data-id= "{{$bank->id}}"
							data-name= "{{$bank->name}}"
							data-officer= "{{$bank->acc_officer}}"
							data-number= "{{$bank->acc_officer_number}}"
							data-email= "{{$bank->acc_officer_email}}"
							data-toggle="tooltip" 
							data-placement="top" 
							title="Update Bank Balance">
								<i class="fa fa-edit"></i>
							</button> &nbsp;
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

			$(document).on("click", "#clickBankModal", function () {
			     var taskSlug = $(this).attr('data-id');
			     $(".modal-body #inputTask").val(taskSlug);
			     $('#newBankModal').modal('show');
			});
			$(document).on("click", "#clickUpdateBankModal", function () {
			     var bankId = $(this).attr('data-id');
			     var bankName = $(this).attr('data-name');
			     var officer = $(this).attr('data-officer');
			     var officer_number = $(this).attr('data-number');
			     var officer_email = $(this).attr('data-email');
			     $(".update-modal-body #updateBankId").val(bankId);
			     $(".update-modal-body #updateName").val(bankName);
			     $(".update-modal-body #updateOfficerModal").val(officer);
			     $(".update-modal-body #updateOfficerNumberModal").val(officer_number);
			     $(".update-modal-body #updateOfficerEmailModal").val(officer_email);
			     $('#updateBankModal').modal('show');
			});

			$('#newBankModal').submit(function(e){
				e.preventDefault();
				let url = "{{route('bank.store')}}"
				let pageUrl = "{{route('bank.create'). ' #sectionBody'}}"
				values = {
					"_token": "{{ csrf_token() }}",
					'name': $('#inputName').val(),
					'label': $('#inputLabel').val(),
					'account': $('#inputAccount').val(),
					'currency': $('#inputCurrency').val(),
					'balance': $('#inputBalance').val(),
					'officer': $('#inputOfficer').val(),
					'officer_number': $('#inputOfficerNumber').val(),
					'officer_email': $('#inputOfficerMail').val()
				};
				console.log(values);
				alert('touch');
				$.ajax({
					url: url,
					type: "POST",
					data: values ,
					success: function (response) {
						if (response.status == 'success') {
							$('#inputName').val(''),
							$('#inputLabel').val(''),
							$('#inputAccount').val(''),
							$('#inputCurrency').val(''),
							$('#inputBalance').val('')
							$('#newBankModal').modal('toggle');
				             toastr["success"]("Status Updated Successfully", "Success");
				             location.reload();
							return true;
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
			             toastr["error"]("Error Creating Bank", "Error");
						console.log(textStatus, errorThrown);
					}


				});				
			})

			$('#updateBankModal').submit(function(e){
				e.preventDefault();
				let id = $('input[name="updateBankId"]').val();
				let url = "/admin/bank/"+id;
				let pageUrl = "{{route('bank.create'). ' #sectionBody'}}";
				values = {
					"_token": "{{ csrf_token() }}",
					'bank_id': id,
					'officer' : $('#updateOfficerEmailModal').val(),
					'officer_number' : $('#updateOfficerEmailModal').val(),
					'officer_email' : $('#updateOfficerEmailModal').val(),
				};
				$.ajax({
					url: url,
					type: "PUT",
					data: values,
					success: function (response) {
						if (response.status == 'success') {
							$('#updateBankId').val(''),
							$('#updateBalance').val('')
							$('#updateBankModal').modal('toggle');
				             toastr["success"]("Balance Updated Successfully", "Success");
				             location.reload();
							return true;
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
			             toastr["error"]("Error Updating Balance", "Error");
						console.log(jqXHR, textStatus, errorThrown);
					}


				});				
			})
		</script>


@endsection
