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
			<form 
			action="{{route('change.password.store')}} " 
			method="POST" 
			class="form-horizontal" 
			id="changePasswordForm">
				@csrf
				<section class="panel">
					<header class="panel-heading">
						<div class="panel-actions">
							<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
						</div>

						<h2 class="panel-title">Change Password</h2>
					</header>
					<div class="panel-body">
						<div class="form-group">
							<label class="col-sm-2 control-label">Password <span class="required">*</span></label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-lock"></i>
									</span>
									<input 
									type="password" 
									name="password" 
									id="password" 
									class="form-control" 
									placeholder="Current Password" 
									value ="{{old('password')}}" 
									required/>
								</div>
								@if($errors->has('password'))
								<span class="text-danger"> {{$errors->first('password')}}</span>
								@endif
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">New Password <span class="required">*</span></label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-lock"></i>
									</span>
									<input 
									type="password" 
									name="new_password" 
									id="new_password" 
									class="form-control" 
									placeholder="New Password (min 6 characters)"
									minlength="6" 
									value ="{{old('new_password')}}" 
									required/>
								</div>
								@if($errors->has('new_password'))
								<span class="text-danger"> {{$errors->first('new_password')}}</span>
								@endif
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Confirm Password <span class="required">*</span></label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">
										<i class="fa fa-lock"></i>
									</span>
									<input 
									type="password" 
									name="confirm_password" 
									id="confirm_password" 
									class="form-control" 
									placeholder="Confirm Password" 
									value ="{{old('confirm_password')}}" 
									required/>
								</div>
								@if($errors->has('confirm_password'))
								<span class="text-danger"> {{$errors->first('confirm_password')}}</span>
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

	<script type="text/javascript">
		$(document).ready( function (){
			$("#changePasswordForm").submit(function(e){
				// e.preventDefault();
				let password = $('#password').val();
				let new_password = $('#new_password').val();
				let confirm_password = $('#confirm_password').val();
				if(new_password == confirm_password && (new_password.length >= 6)){
					return true;
				}
	            toastr.error(
                'Ensure your New Password is more than six characters and is the same with the Confirmed Password', 'Error');
                return false;
			});
		})

	</script>


@endsection
