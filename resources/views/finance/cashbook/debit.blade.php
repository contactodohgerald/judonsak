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

					<!-- start: page -->
					<div class="row">
						<div class="col-md-12">
							<form action="{{ (null == $cashbook) ? route('cashbook.store') : route('cashbook.update', ['cashbook' => $cashbook->id]) }} " method="POST" class="form-horizontal">
								@csrf
								@if(null !== $cashbook)
								    <input type="hidden" name="_method" value="PUT">
								@endif
								<input type="hidden" name="group" value="1">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="" class="panel-action panel-action-toggle" data-panel-toggle></a>
										</div>
										<h2 class="panel-title">
											New Debit Entry
										</h2>
									</header>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-2 control-label">Client </label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-user"></i>
													</span>
													<select name="client" class="form-control" required>
														<option disabled selected> Select a Client </option>
														@foreach($clients as $client)
														<option value="{{$client->id}}"> {{$client->name}} </option>
														@endforeach
													</select>
												</div>
												@if($errors->has('client'))
												<span class="text-danger"> {{$errors->first('client')}}</span>
												@endif
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Bank <span class="required">*</span></label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-home"></i>
													</span>
													<select name="bank" class="form-control" >
														<option disabled selected> Select a Bank </option>
														@foreach($banks as $bank)
															<option value="{{$bank->id}}">
																{{
																	$bank->name.' '. $bank->label.' '. $bank->currency->name
																}}</option>
														@endforeach
													</select>
												</div>
												@if($errors->has('bank'))
												<span class="text-danger"> {{$errors->first('bank')}}</span>
												@endif
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Currency <span class="required">*</span></label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-home"></i>
													</span>
													<select name="currency" class="form-control" >
														<option disabled selected> Select a Currency </option>
														@foreach($currencies as $currency)
															@if($currency->id > 2)
															@break
															@endif
															<option value="{{$currency->id}}">{{$currency->name}}</option>
														@endforeach
													</select>
												</div>
												@if($errors->has('currency'))
												<span class="text-danger"> {{$errors->first('currency')}}</span>
												@endif
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Category <span class="required">*</span></label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-home"></i>
													</span>
													<select name="category" class="form-control" >
														<option disabled selected> Select a Category </option>
															<option value="1">Corprate</option>
															<option value="2">Client Account</option>
													</select>
												</div>
												@if($errors->has('category'))
												<span class="text-danger"> {{$errors->first('category')}}</span>
												@endif
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Label <span class="required">*</span></label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-home"></i>
													</span>
													<select name="label" class="form-control" required >
														<option disabled selected> Select a Label </option>
														@foreach ($labels as $label)
															<option value="{{$label->id}}">
																 {{$label->name}}
															</option>
														@endforeach
													</select>
												</div>
												@if($errors->has('label'))
												<span class="text-danger"> {{$errors->first('label')}}</span>
												@endif
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Amount <span class="required">*</span></label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-home"></i>
													</span>
													<input type="text" name="amount" class="form-control" placeholder="enter amount without commas or alphabets" value ="{{ (null == $cashbook) ? old('amount') : $cashbook->amount}}">
												</div>
												@if($errors->has('amount'))
												<span class="text-danger"> {{$errors->first('amount')}}</span>
												@endif
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label">Description <span class="required">*</span></label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-envelope"></i>
													</span>
													<input type="text" name="description" class="form-control" placeholder="eg.: Payment for Payroll Management" value ="{{ (null == $cashbook) ? old('description') : $cashbook->description}}" />
												</div>
												@if($errors->has('description'))
												<span class="text-danger"> {{$errors->first('description')}}</span>
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
		<script src="assets/vendor/select2/select2.js"></script>

@endsection
