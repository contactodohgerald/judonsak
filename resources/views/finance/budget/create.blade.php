 {{--@extends('layouts.admin')--}}
@extends("layouts.".\Auth::user()->person->department->slug )
 
@section('css')
		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="{{asset('assets/vendor/select2/select2.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css')}}" />
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
	<div class="modal fade" id="newBudgetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" style="margin: 120px auto; role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      </div>
	      <div class="modal-body">
			<form 
			action="{{route('expenditure.upload')}}" 
			method="POST" 
			enctype="multipart/form-data" 
			class="form-horizontal">
				@csrf
				<section class="panel">
					<header class="panel-heading">
						<h2 class="panel-title">{{'Upload Budget'}}</h2>
					</header>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="uploadName">Name <span class="required">*</span></label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-book"></i>
									</span>
									<input type="text" name="name" id="uploadName" class="form-control" placeholder="eg.: January 2019 Budget" value ="" required/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="uploadMonth"> Month <span class="required">*</span>
							</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
								<select 
								name="month" 
								id="uploadMonth" 
								class="form-control" 
								required>
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">August</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">November</option>
										<option value="12">December</option>
								</select>
								<label class="error" for="selectClient"></label>
								</div>
								@if($errors->has('month'))
									<span class="text-danger"> {{$errors->first('month')}}</span>
								@endif
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="uploadBudgetFile">File <span class="required">*</span></label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-file"></i>
									</span>
									<input type="file" name="budget" id="uploadBudgetFile" class="form-control" required/>
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
	<div class="row">
		<div class="col-xs-12">
			<section class="panel form-wizard" id="w4">
				<header class="panel-heading">
					<div class="panel-actions">
						<button id="clickUploadModal" 
							class="btn-success mb-xs mt-xs mr-xs btn btn-xs pull-right" 
							data-toggle="tooltip" 
							data-placement="top" 
							title="Upload Spreadsheet">
								<i class="fa fa-plus"></i> Upload Budget</button>
						<button id="clickDownloadModal" 
							class="btn-success mb-xs mt-xs mr-xs btn btn-xs pull-right" 
							data-toggle="tooltip" 
							data-placement="top" 
							title="Download Spreadsheet Sample">
								<i class="fa fa-download"></i> Download Sample</button>
					</div>
	
					<h2 class="panel-title">New Budget</h2>
				</header>
				<div class="panel-body">
					<div class="wizard-progress wizard-progress-lg">
						<div class="steps-progress">
							<div class="progress-indicator"></div>
						</div>
						<ul class="wizard-steps">
							<li class="active">
								<a href="#w4-months" data-toggle="tab"><span>1</span>Month</a>
							</li>
							<li>
								<a href="#w4-expenditures" data-toggle="tab"><span>2</span>Expenditure</a>
							</li>
						</ul>
					</div>
	
					<form action="{{route('budget.store')  }} " method="POST" class="form-horizontal"  novalidate="novalidate">
						@csrf
						<div class="tab-content">
							<div id="w4-months" class="tab-pane active">
								<div class="form-group">
									<label class="col-sm-2 control-label" for="budget_name"> Name <span class="required">*</span>
									</label>
									<div class="col-sm-8">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-book"></i>
											</span>
										<input 
										name="name" 
										id="budget_name" 
										class="form-control" 
										placeholder="Budget Name"
										required />
										<label class="error" for="budget_name"></label>
										</div>
										@if($errors->has('name'))
											<span class="text-danger"> {{$errors->first('name')}}</span>
										@endif
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label"> Month <span class="required">*</span>
									</label>
									<div class="col-sm-8">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</span>
										<select 
										name="month" 
										id="selectClient" 
										class="form-control" 
										required>
												<option value="1">January</option>
												<option value="2">February</option>
												<option value="3">March</option>
												<option value="4">April</option>
												<option value="5">May</option>
												<option value="6">June</option>
												<option value="7">July</option>
												<option value="8">August</option>
												<option value="9">September</option>
												<option value="10">October</option>
												<option value="11">November</option>
												<option value="12">December</option>
										</select>
										<label class="error" for="selectClient"></label>
										</div>
										@if($errors->has('month'))
											<span class="text-danger"> {{$errors->first('month')}}</span>
										@endif
									</div>
								</div>
							</div>
							<div id="w4-expenditures" class="tab-pane">
								<div class="col-sm-offset-5">
									<h5>
									<p class="btn" type="click" id="deleteWages"> <i class="fa fa-minus"></i></p>
										Manage
									<p class="btn" type="click" id="addPayment"> <i class="fa fa-plus"></i></p>
									</h5>
									<br>
								</div>
							<div id="attachPayment">
								<div class="col-sm-12">
									<label class="col-sm-2 control-label">Description
									</label>											
										<div class="col-sm-7">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-book"></i>
												</span>
												<input type="text" id="description" name="description[]" class="form-control" placeholder="Description Of The budget Entry" value ="{{ (null == $budget) ? old('description') : $budget->paydate}}" />
											</div>
											@if($errors->has('description'))
											<span class="text-danger"> {{$errors->first('description')}}</span>
											@endif
										</div>													
								</div><br><br>
								<div class="col-sm-12">
									<label class="col-sm-2 control-label">Category
									</label>
										<div class="col-sm-7">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-list"></i>
												</span>
												<select 
													name="category_id[]" 
													id="categoryid" 
													class="form-control" 
													required>
													<option disabled="">Select Category</option>
													@foreach ($categories as $category)
														<option 
														value="{{$category->id}}">
														{{$category->name}}
														</option>
												@endforeach
												</select>
											</div>
											@if($errors->has('categoryid'))
											<span class="text-danger"> {{$errors->first('categoryid')}}</span>
											@endif
										</div>			
								</div><br><br>
								<div class="col-sm-12">
									<label class="col-sm-2 control-label">Gross
									</label>
										<div class="col-sm-7">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-money"></i>
												</span>
												<input type="text" name="gross[]" class="form-control" placeholder="gross" value ="{{ (null == $budget) ? old('gross') : $budget->gross}}" />
											</div>
											@if($errors->has('gross'))
											<span class="text-danger"> {{$errors->first('gross')}}</span>
											@endif
										</div>													
								</div><br><br>
								<div class="col-sm-12">
									<label class="col-sm-2 control-label">Employer's Cost
									</label>											
										<div class="col-sm-7">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-credit-card"></i>
												</span>
												<input type="text" name="employers[]" class="form-control" placeholder="employer's cost" value ="{{ (null == $budget) ? old('employers') : $budget->employers}}" />
											</div>
											@if($errors->has('employers'))
											<span class="text-danger"> {{$errors->first('employers')}}</span>
											@endif
										</div>													
								</div><br><br>
								<div class="col-sm-12">
									<label class="col-sm-2 control-label">Total Cost
									</label>											
										<div class="col-sm-7">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="fa fa-money"></i>
												</span>
												<input type="text" name="total[]" class="form-control" placeholder="total cost" value ="{{ (null == $budget) ? old('total') : $budget->total}}" />
											</div>
											@if($errors->has('total'))
											<span class="text-danger"> {{$errors->first('total')}}</span>
											@endif
										</div>													
								</div>
								<hr>
							</div>
							<button class="btn btn-success btn-circle pull-right">Submit</button>
							</div>
						</div>
					</form>
				</div>
				<div class="panel-footer">
					<ul class="pager">
						<li class="previous disabled">
							<a><i class="fa fa-angle-left"></i> Previous</a>
						</li>
						{{-- <li class="finish hidden pull-right">			
							<a>Finish</a>
						</li> --}}
						<li class="next">
							<a>Next <i class="fa fa-angle-right"></i></a>
						</li>
					</ul>
				</div>
			</section>
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

	<script src="{{asset('assets/vendor/jquery-validation/jquery.validate.js')}}"></script>
	<script src="{{asset('assets/vendor/bootstrap-wizard/jquery.bootstrap.wizard.js')}}"></script>
	<script src="{{asset('assets/vendor/pnotify/pnotify.custom.js')}}"></script>
	<script src="{{asset('assets/javascripts/forms/examples.wizard.js')}}"></script>
	<script type="text/javascript">
		$(document).on("click", "#clickUploadModal", function () {
			console.log('clicked');
		     $('#newBudgetModal').modal('show');
		});
		$(document).on("click", "#clickDownloadModal", function () {
		     $('#downloadBudgetModal').modal('show');
		});

		$('body').on('focus',"#datepicker", function(){
		      $(this).datepicker({
		            format : 'yyyy-mm-dd',
		            startDate : new Date(),
		            autoclose : true
		      });
		});
		var attachPayment = $('#attachPayment');
		var paymentCount = 1;
		var count = (paymentCount) ? paymentCount : 0;
		var arr = [];
		var categories = JSON.parse('{!!$categories!!}');

		var categoryOptions = categories.map((category, index)=>{
			return `<option 
				value="${category.id}">
				${category.name}
				</option>`
		});

		if (paymentCount) {
			// --paymentCount;
			for (var i = 1; i <= paymentCount; i++) {
				arr.push(i);
			}
		}
		var funcAddPayment = function(){
			clickCount = ++count;
			arr.push(clickCount);
			var attachContent = `
			<div class="form-group" id="removePayment${clickCount}" style="border-top: 1px #cee solid; padding-top:10px">
				<div class="col-sm-12">
					<label class="col-sm-2 control-label">Description
					</label>											
						<div class="col-sm-7">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-book"></i>
								</span>
								<input type="text" id="description" name="description[]" class="form-control" placeholder="Description of budget entry" value ="{{ (null == $budget) ? old('description') : $budget->paydate}}" />
							</div>
							@if($errors->has('description'))
							<span class="text-danger"> {{$errors->first('description')}}</span>
							@endif
						</div>													
				</div><br><br>
				<div class="col-sm-12">
					<label class="col-sm-2 control-label">Category
					</label>											
						<div class="col-sm-7">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-list"></i>
								</span>
								<select 
									name="category_id[]" 
									id="categoryid" 
									class="form-control" 
									required>
									<option disabled="">Select Category</option>
									${categoryOptions}
								</select>
							</div>
							@if($errors->has('categoryid'))
							<span class="text-danger"> {{$errors->first('categoryid')}}</span>
							@endif
						</div>													
				</div><br><br>
				<div class="col-sm-12">
					<label class="col-sm-2 control-label">Gross
					</label>											
						<div class="col-sm-7">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-money"></i>
								</span>
								<input type="text" name="gross[]" class="form-control" placeholder="gross" value ="{{ (null == $budget) ? old('gross') : $budget->gross}}" />
							</div>
							@if($errors->has('gross'))
							<span class="text-danger"> {{$errors->first('gross')}}</span>
							@endif
						</div>													
				</div><br><br>
				<div class="col-sm-12">
					<label class="col-sm-2 control-label">Employer's Cost
					</label>											
						<div class="col-sm-7">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-credit-card"></i>
								</span>
								<input type="text" name="employers[]" class="form-control" placeholder="employer's cost" value ="{{ (null == $budget) ? old('employers') : $budget->employers}}" />
							</div>
							@if($errors->has('employers'))
							<span class="text-danger"> {{$errors->first('employers')}}</span>
							@endif
						</div>													
				</div><br><br>
				<div class="col-sm-12">
					<label class="col-sm-2 control-label">Total Cost
					</label>											
						<div class="col-sm-7">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-money"></i>
								</span>
								<input type="text" name="total[]" class="form-control" placeholder="total cost" value ="{{ (null == $budget) ? old('total') : $budget->total}}" />
							</div>
							@if($errors->has('total'))
							<span class="text-danger"> {{$errors->first('total')}}</span>
							@endif
						</div>													
				</div>
				<hr>
			</div>`;
			attachPayment.append(attachContent);
		}
		$('#addPayment').click(function(){
			funcAddPayment();

		})
		$('#deleteWages').click(function(){
			var ref = arr[arr.length -1];
			$('#removePayment'+ref).remove();
			arr.pop();
		})			
	</script>

@endsection		