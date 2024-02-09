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
		{{--<section class="panel-featured panel-featured-success">
			<header class="panel-heading">
				<div class="panel-actions">
					<!-- <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a> -->
				</div>

				<h1 class="panel-title text-center"><span class="text-primary">{{$budget->name}} </span></h1><br>
				<div class="row">
					<div class="col-sm-6 ">
						<div class="panel-body">
							<div class="table table-responsive">
								<h4 style="text-align: center; font-weight: 2px; font-style: italic;"> Proposed Summary</h4>
								<table class="table table-bordered table-striped mb-none">
									<thead>
										<tr>
											<th width="40%"></th>
											<th width="30%">NGN</th>
											<th width="30%">USD</th>
										</tr>
									</thead>
									<tbody>
											<tr>
												<td>
													<strong>{{'Revenue Projections'}}</strong>
												</td>
											<td>{{number_format($budget->revenues->where('category_id','=',1)->where('currency_id','=',1)->sum('total'), 2) }}</td>
											<td>{{number_format($budget->revenues->where('category_id','=',1)->where('currency_id','=',2)->sum('total'), 2) }}</td>
											</tr>
											<tr>
												<td>
													<strong>{{'Current Receivables'}}</strong>
												</td>
											<td>{{number_format($budget->revenues->where('category_id','=',2)->where('currency_id','=',1)->sum('total'), 2) }}</td>
											<td>{{number_format($budget->revenues->where('category_id','=',2)->where('currency_id','=',2)->sum('total'), 2) }}</td>
											</tr>
											<tr>
												<td>
													<strong>{{'Expenditures'}}</strong>
												</td>
											<td>{{number_format($budget->expenditures->where('status_id','=',22)->sum('total'), 2) }}</td>
											<td>-----</td>
											</tr>
											<tr>
												<td>
													<strong>{{'Current Liabilities'}}</strong>
												</td>
											<td>{{number_format($budget->expenditures->whereIn('status_id',[22,4])->sum('total'), 2) }}</td>
											<td>-----</td>
											</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-sm-6 ">
						<div class="panel-body">
							<div class="table table-responsive">
								<h4 style="text-align: center; font-weight: 2px; font-style: italic;">Accepted Summary</h4>
								<table class="table table-bordered table-striped mb-none">
									<thead>
										<tr>
											<th width="40%"></th>
											<th width="30%">NGN</th>
											<th width="30%">USD</th>
										</tr>
									</thead>
									<tbody>
											<tr>
												<td>
													<strong>{{'Revenue Projections'}}</strong>
												</td>
											<td>{{number_format($budget->revenues->where('category_id','=',1)->where('currency_id','=',1)->sum('total'), 2) }}</td>
											<td>{{number_format($budget->revenues->where('category_id','=',1)->where('currency_id','=',2)->sum('total'), 2) }}</td>
											</tr>
											<tr>
												<td>
													<strong>{{'Current Receivables'}}</strong>
												</td>
											<td>{{number_format($budget->revenues->where('category_id','=',2)->where('currency_id','=',1)->sum('total'), 2) }}</td>
											<td>{{number_format($budget->revenues->where('category_id','=',2)->where('currency_id','=',2)->sum('total'), 2) }}</td>
											</tr>
											<tr>
												<td>
													<strong>{{'Expenditures'}}</strong>
												</td>
											<td>{{number_format($budget->expenditures->where('status_id','=',23)->sum('total'), 2) }}</td>
											<td>-----</td>
											</tr>
											<tr>
												<td>
													<strong>{{'Current Liabilities'}}</strong>
												</td>
											<td>{{number_format($budget->expenditures->where('status_id','=',4)->sum('total'), 2) }}</td>
											<td>-----</td>
											</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</header>
		</section>
		<br>--}}
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" style="margin: 120px auto; role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <h4 class="modal-title"> New Expenditure</h4>
			</div>
			<div class="modal-body">
				  <form class="form-horizontal form-bordered" method="post" action="{{route(
					  'budget.update', 
					  ['budget' => $budget->slug]
					)}}">
					  @csrf()
					  <input type="hidden" name="_method" value="put" required>
					  <div class="form-group">
						<div class="col-sm-12">
								<label class="col-sm-2 control-label">Description
								</label>
									<div class="col-sm-9">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-book"></i>
											</span>
											<input type="text" id="description" name="description" class="form-control" placeholder="Description Of The budget Entry" value ="{{ (null == $budget) ? old('description') : $budget->paydate}}" />
										</div>
										@if($errors->has('description'))
										<span class="text-danger"> {{$errors->first('description')}}</span>
										@endif
									</div>													
							</div><br><br>
							<div class="col-sm-12">
								<label class="col-sm-2 control-label">Category
								</label>
									<div class="col-sm-9">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-list"></i>
											</span>
											<select 
												name="category_id" 
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
									<div class="col-sm-9">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-money"></i>
											</span>
											<input type="text" name="gross" class="form-control" placeholder="gross" value ="{{ (null == $budget) ? old('gross') : $budget->gross}}" />
										</div>
										@if($errors->has('gross'))
										<span class="text-danger"> {{$errors->first('gross')}}</span>
										@endif
									</div>													
							</div><br><br>
							<div class="col-sm-12">
								<label class="col-sm-2 control-label">Employer's Cost
								</label>											
									<div class="col-sm-9">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-credit-card"></i>
											</span>
											<input type="text" name="employers" class="form-control" placeholder="employer's cost" value ="{{ (null == $budget) ? old('employers') : $budget->employers}}" />
										</div>
										@if($errors->has('employers'))
										<span class="text-danger"> {{$errors->first('employers')}}</span>
										@endif
									</div>													
							</div><br><br>
							<div class="col-sm-12">
								<label class="col-sm-2 control-label">Total Cost
								</label>											
									<div class="col-sm-9">
										<div class="input-group">
											<span class="input-group-addon">
												<i class="fa fa-money"></i>
											</span>
											<input type="text" name="total" class="form-control" placeholder="total cost" value ="{{ (null == $budget) ? old('total') : $budget->total}}" />
										</div>
										@if($errors->has('total'))
										<span class="text-danger"> {{$errors->first('total')}}</span>
										@endif
									</div>													
							</div>
					  </div>
						<div class="modal-footer">
							<div class=" col-md-12">
							  <button 
							  type="submit" 
							  class="btn btn-success btn-block" >Create</button>>
							</div>
						</div>
				  </form>
			</div>
		  </div>
		</div>
	  </div>
	  

<section class="panel">
	<header class="panel-heading">
		<div class="panel-actions">
			<a href="#" class="panel-action panel-action-toggle pull-right" data-panel-toggle></a>
			<button id="clickUploadModal" 
				class="btn-success mb-xs mt-xs mr-xs btn btn-xs pull-right" 
				data-toggle="tooltip" 
				data-placement="top" 
				title="Confirm All Expenditures">
					<i class="fa fa-check"></i> Confirm All
			</button>
			<button id="clickModal" 
				class="btn-primary mb-xs mt-xs mr-xs btn btn-xs pull-right" 
				data-toggle="tooltip" 
				data-placement="top" 
				title="Add More Expenditures">
					<i class="fa fa-plus"></i> Add more
			</button>		
		</div>

		<h2 class="panel-title">
			{{$budget->name}}</h2>
	</header>
	<div class="panel-body">
		<table class="table table-bordered table-striped mb-none" id="datatable-default">
			<thead>
				<tr>
					<th width="5%">S/N</th>
					<th width="35%" >Description</th>
					<th width="15%" >Type</th>
					<th width="25%" >Amount</th>
					<th width="15%" >Status</th>
					<th width="5%" >Actions</th>
				</tr>
			</thead>		
			<tbody>
				@foreach($budget->expenditures as $expenditure)
				<tr>
					<td>
					</td>

				<td>
					{{$expenditure->description}}
				</td>
				<td>
					{{$expenditure->expenditure_category->name}}
				</td>
				<td>
					NGN {{number_format($expenditure->total, 2)}}
				</td>
				<td>
				@switch($expenditure->status->id)
					@case(4)
						<span 
						class="label label-info"
						data-toggle="tooltip" 
						data-placement="top" 
						title="Shows up in next budget">
						@break

					@case(7)
						<span 
						class="label label-success"
						data-toggle="tooltip" 
						data-placement="top" 
						title="Completed/Accepted">
						@break

					@case(22)
						<span 
						class="label label-warning"
						data-toggle="tooltip" 
						data-placement="top" 
						title="Must Review, Doesn't show up in next budget">
						@break

					@case(23)
						<span 
						class="label label-success"
						data-toggle="tooltip" 
						data-placement="top" 
						title="Adds up to Accepted Budget">
						@break

					@case(24)
						<span 
						class="label label-danger"
						data-toggle="tooltip" 
						data-placement="top" 
						title="Declined. Deletes Expenditure">
						@break

					@default

				@endswitch						
					{{$expenditure->status->name}}</span>
				</td>
				<td>
					<a href="#"
						onclick="event.preventDefault();
						if(confirm('Are you sure you want to confirm this'))
							document.getElementById('accept-expenditure-form-{{$loop->iteration}}').submit();"
						class="on-default remove-row text-success" 
						data-toggle="tooltip" 
						data-placement="top" 
						title="Accept">
						<i class="fa fa-check"></i>
					</a>
					<a href="#"
						onclick="event.preventDefault();
						if(confirm('Are you sure you want to put this in pending'))
							document.getElementById('pend-expenditure-form-{{$loop->iteration}}').submit();"
						class="on-default remove-row text-info" 
						data-toggle="tooltip" 
						data-placement="top" 
						title="Pending">
						<i class="fa fa-clock-o"></i>
					</a>
					<a href="#"
						onclick="event.preventDefault();
						if(confirm('Are you sure you want to reject this Expenditure'))
							document.getElementById('delete-expenditure-form-{{$loop->iteration}}').submit();"
						class="on-default remove-row text-danger" 
						data-toggle="tooltip" 
						data-placement="top" 
						title="Reject">
						<i class="fa fa-remove"></i>
					</a>
					<form id="accept-expenditure-form-{{$loop->iteration}}" action="{{route('expenditure.accept', ['expenditure' => $expenditure->id, 'budget'=> $budget->slug])}}" method="POST" style="display: none;">
						<input type="hidden" name="_method" value="POST">
						@csrf
					</form>
					<form id="pend-expenditure-form-{{$loop->iteration}}" action="{{route('expenditure.pend', ['expenditure' => $expenditure->id, 'budget'=> $budget->slug])}}" method="POST" style="display: none;">
						<input type="hidden" name="_method" value="put">
						@csrf
					</form>
					<form id="delete-expenditure-form-{{$loop->iteration}}" action="{{route('expenditure.destroy', ['expenditure' => $expenditure->id, 'budget'=> $budget->slug])}}" method="POST" style="display: none;">
						<input type="hidden" name="_method" value="delete">
						@csrf
					</form>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
</section>


	{{--<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
			</div>

			<h2 class="panel-title">{{'Revenue Projections & Current Recievables'}}</h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered table-striped mb-none" id="datatable-revenue">
				<thead>
					<tr>
						<th width="5%">S/N</th>
						<th width="20%" >Client</th>
						<th width="35%" >Description</th>
						<th width="15%" >Category</th>
						<th width="25%" >Amount</th>
					</tr>
				</thead>		
				<tbody>
					@foreach($budget->revenues as $revenue)
					<tr>
						<td>
						</td>

						<td>
							{{$revenue->client->name}}
						</td>
						<td>
							{{$revenue->description}}
						</td>
						<td>
							<span 
								class="label label-info"
								data-toggle="tooltip" 
								data-placement="top" 
								title="Shows up in next budget">
							{{($revenue->category_id == 1) ? 'Revenue': 'Recievables'}}
							</span>
						</td>
						<td>
							{{$revenue->currency->name.' '. number_format($revenue->total, 2)}}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</section>--}}

@endsection

@section('js')
		<!-- Examples -->
		<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>


		<!-- Specific Page Vendor -->
		<script type="text/javascript">

			$(document).ready(function() {
			    var t = $('#datatable-default').DataTable( {
			        "columnDefs": [ {
			            "searchable": false,
			            "orderable": false,
			            "targets": 0
			        } ],
			        "order": [[ 4, 'asc' ]],
				    "pageLength":100
			    } );
			 
			    t.on( 'order.dt search.dt', function () {
			        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			            cell.innerHTML = i+1;
			        } );
			    } ).draw();
			} );

		</script>
		<script type="text/javascript">

			$(document).on("click", "#clickTaskModal", function (event) {
				event.preventDefault();
			     
			    var statusId = $(this).attr('data-statusId');
			    var budgetId = $(this).attr('data-budgetId');
				var values = {
					"_token": "{{ csrf_token() }}",
					'status_id': statusId,
					'budget_id': budgetId
				}
				console.log(values);
			});

			$(document).on("click", "#clickModal", function () {
			     $('#myModal').modal('show');
			});

		</script>


@endsection
