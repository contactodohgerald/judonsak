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
			<form enctype="multipart/form-data" action="{{ (null == $contract) ? 
			route('client.contract.store', ['client' => $client->slug]) : 
			route('client.contract.update', ['client' => $client->slug, 'contract' => $contract->slug]) }}"
			 method="POST" class="form-horizontal">
				@csrf
				@if(null !== $contract)
				    <input type="hidden" name="_method" value="PUT">
				@endif
				<section class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						</div>

						<h2 class="panel-title">{{(null == $contract) ?'Create Contract' : 'Edit Contract'}}</h2>
					</header>
					<div class="panel-body">
						@if(null != $clients)
						<div class="form-group">
							<label class="col-sm-2 control-label"> Client 
							</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-credit-card"></i>
									</span>
								<select id="client" class="form-control"  name="client">
									@if(null== $contract)
										<option disabled selected> Select Client</option>
									@endif
									@foreach($clients as $claint)
										@if(null !== old('client') )
											@if(old('client') == $claint->id)
												<option value="{{$claint->id}}" selected>
													{{$claint->name}}
												</option>
											@else
												<option value="{{$claint->id}}">
													{{$claint->name}} 
												</option>
											@endif
										@else
											@if($claint->id == $client->id)
												<option value="{{$claint->id}}" selected>
													{{$claint->name}}
												</option>
											@else
												<option value="{{$claint->id}}">
													{{$claint->name}} 
												</option>
											@endif
										@endif
									@endforeach

								</select>
								<label class="error" for="client"></label>
								</div>
								@if($errors->has('client'))
								<span class="text-danger"> {{$errors->first('client')}}</span>
								@endif
							</div>
						</div>
						@endif
						<div class="form-group">
							<label class="col-sm-2 control-label">Name <span class="required">*</span></label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-home"></i>
									</span>
									<input type="text" name="name" class="form-control" value ="{{ (null == $contract) ? old('name') : $contract->name}}" placeholder="Contract With Company-Name" required/>
								</div>
								@if($errors->has('name'))
								<span class="text-danger"> {{$errors->first('name')}}</span>
								@endif
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Services 
							</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
								<select id="service" multiple data-plugin-selectTwo class="form-control populate"  name="service[]" value ="{{ (null == $contract) ? old('service[]') : $contract->service}}">
									@if(null== $contract && null == old('service'))
										<option disabled selected> Choose One</option>
									@endif

									@if(null !== old('service'))
										@foreach($services as $service)
											@if( in_array( $service->id, old('service')) ) 
												<option value="{{$service->id}}" selected>{{$service->name}} 
												</option>
											@else
												<option value="{{$service->id}}">{{$service->name}}
											@endif
										@endforeach 
									@elseif( null !== $contract )
										@foreach($services as $service)
												@if(in_array(
													$service->id, 
													array_column(
														$contract->services->toArray(), 'id')
														))
													<option value="{{$service->id}}" selected>{{$service->name}}
													</option>
												@else
													<option value="{{$service->id}}">{{$service->name}} 
													</option>
												@endif
										@endforeach
									@else
										@foreach($services as $service)
											<option value="{{$service->id}}">{{$service->name}} 
											</option>
										@endforeach
									@endif

								</select>
								<label class="error" for="service"></label>
								</div>
								@if($errors->has('service'))
								<span class="text-danger"> {{$errors->first('service')}}</span>
								@endif
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"> Amount
							</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-money"></i>
									</span>
									<input type="text" min="1" name="amount" class="form-control" placeholder="Brief summary of the Contract" value ="{{ (null == $contract) ? old('amount') : number_format($contract->amount, 2)}}" />
								</div>
								@if($errors->has('amount'))
								<span class="text-danger"> {{$errors->first('amount')}}</span>
								@endif
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"> Currency 
							</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-credit-card"></i>
									</span>
								<select id="currency" class="form-control"  name="currency" value ="{{ (null == $contract) ? old('currency') : $contract->currency}}" >
									@if(null== $contract)
										<option disabled selected> Choose One</option>
									@endif
									@foreach($currencies as $currency)
										@if(null!== $contract)
											@if($currency->id == $contract->currency_id)
												<option value="{{$currency->id}}" selected>{{$currency->name}}</option>
											@else
												<option value="{{$currency->id}}">{{$currency->name}} 
												</option>
											@endif
										@elseif(null !== old('currency') )
											@if(old('currency') == $currency->id)
												<option value="{{$currency->id}}" selected>{{$currency->name}}</option>
											@else
												<option value="{{$currency->id}}">{{$currency->name}} 
												</option>
											@endif
										@else
											<option value="{{$currency->id}}">{{$currency->name}} 
											</option>
										@endif
									@endforeach

								</select>
								<label class="error" for="currency"></label>
								</div>
								@if($errors->has('currency'))
								<span class="text-danger"> {{$errors->first('currency')}}</span>
								@endif
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Start Date
							</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" data-plugin-datepicker name="startdate" class="form-control" placeholder="Start Date" value ="{{ (null == $contract) ? old('startdate') : $contract->start_date}}" />
								</div>
								@if($errors->has('startdate'))
								<span class="text-danger"> {{$errors->first('startdate')}}</span>
								@endif
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">End Date 
							</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</span>
									<input type="text" data-plugin-datepicker name="enddate" class="form-control" placeholder="End Date" value ="{{ (null == $contract) ? old('enddate') : $contract->end_date}}" />
								</div>
								@if($errors->has('enddate'))
								<span class="text-danger"> {{$errors->first('enddate')}}</span>
								@endif
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Contract SLA
							</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa contract"></i>
									</span>
									<input type="file" name="sla" class="form-control" />
								</div>
								@if($errors->has('sla'))
								<span class="text-danger"> {{$errors->first('sla')}}</span>
								@endif
							</div>
						</div>
						<br>
							<div class="col-sm-offset-5">
								<h4>
								<p class="btn" type="click" id="deletePayment"> <i class="fa fa-minus"></i></p>
									Payment Terms
								<p class="btn" type="click" id="addPayment"> <i class="fa fa-plus"></i></p>
								</h4>
								<br>
							</div>
							<div class="form-group">
							<div id="attachPayment">
							@if(null!== $contract)
							<input type="hidden" id="paymentCount" value="{{count($contract->payments)}}">
								@foreach($contract->payments as $payment)
									<div class="form-group" id="removePayment{{$loop->iteration}}">
										<div class="col-sm-6" id=>
											<label class="col-sm-2 col-sm-offset-2 control-label">Rate
											</label>											
												<div class="col-sm-7">
													<div class="input-group">
														<span class="input-group-addon">
															<i class="fa fa-clock-o"></i>
														</span>
														<input type="number" min="1" max="100" name="rate[]" class="form-control" placeholder="e.g 100" value ="{{ (null == $contract) ? old('rate') : $payment->percent}}"  />
													</div>
													@if($errors->has('rate'))
													<span class="text-danger"> {{$errors->first('rate')}}</span>
													@endif
												</div>													
										</div>
										<div class="col-sm-6">
											<label class="col-sm-2 control-label">Date
											</label>											
												<div class="col-sm-7">
													<div class="input-group">
														<span class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</span>
														<input type="text" data-plugin-datepicker name="paydate[]" class="form-control" placeholder="pay before" value ="{{ (null == $contract) ? old('paydate') : $payment->due_date}}" />
													</div>
													@if($errors->has('amount'))
													<span class="text-danger"> {{$errors->first('amount')}}</span>
													@endif
												</div>													
										</div>
									</div>
								@endforeach
							</div>
							@endif
							</div><br>
					</div>
					<footer class="panel-footer">
						<div class="row">
							<div class="col-sm-8 col-sm-offset-2">
								<button class="btn btn-success" style="width: 49%">Submit</button>
								<button type="reset" class="btn btn-default" style="width: 50%">Reset</button>
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
	<script src="{{asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js')}}">
	</script>
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
		$('body').on('focus',"#datepicker", function(){
		      $(this).datepicker({
		            format : 'yyyy-mm-dd',
		            // startDate : new Date(),
		            autoclose : true
		      });
		});
		var attachPayment = $('#attachPayment');
		var paymentCount = $('#paymentCount').val();
		var count = (paymentCount) ? paymentCount : 0;
		var arr = [];
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
			<div class="form-group" id="removePayment${clickCount}">
				<div class="col-sm-6" id=>
					<label class="col-sm-2 col-sm-offset-2 control-label">Rate
					</label>											
						<div class="col-sm-7">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-clock-o"></i>
								</span>
								<input type="number" min="1" max="100" name="rate[]" class="form-control" placeholder="e.g 100" value ="{{ (null == $contract) ? old('rate') : $contract->rate}}" />
							</div>
							@if($errors->has('rate'))
							<span class="text-danger"> {{$errors->first('rate')}}</span>
							@endif
						</div>													
				</div>
				<div class="col-sm-6">
					<label class="col-sm-2 control-label">Date
					</label>											
						<div class="col-sm-7">
							<div class="input-group">
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input type="text" data-plugin-datepicker id="datepicker" name="paydate[]" class="form-control" placeholder="pay before" value ="{{ (null == $contract) ? old('paydate') : $contract->paydate}}" />
							</div>
							@if($errors->has('amount'))
							<span class="text-danger"> {{$errors->first('amount')}}</span>
							@endif
						</div>													
				</div>
			</div>`;
			attachPayment.append(attachContent);
		}
		$('#addPayment').click(function(){
			funcAddPayment();
		})
		$('#deletePayment').click(function(){
			var ref = arr[arr.length -1];
			console.log(ref);
			$('#removePayment'+ref).remove();
			arr.pop();
		})			
	</script>
@endsection
