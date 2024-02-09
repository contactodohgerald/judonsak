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
							<form action="{{route('document.store')  }} " method="POST" class="form-horizontal" enctype="multipart/form-data">
								@csrf
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
										</div>

										<h2 class="panel-title">Upload New File</h2>
									</header>
									<div class="panel-body">
										<div class="form-group">
											<label class="col-sm-2 control-label"> Client <span class="required">*</span>
											</label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-user"></i>
													</span>
												<select 
												name="client" 
												id="selectClient" 
												class="form-control" 
												required>
													<option disabled selected> Select Client</option>
													@foreach($clients as $client)
														<option value="{{$client->id}}"> 
															{{$client->name }} 
														</option>
													@endforeach
												</select>
												<label class="error" for="selectClient"></label>
												</div>
												@if($errors->has('client'))
													<span class="text-danger"> {{$errors->first('client')}}</span>
												@endif
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label"> Folder <span class="required">*</span>
											</label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-user"></i>
													</span>
												<select 
												id="selectContract" 
												name="folder" 
												class="form-control" 
												required>
													<option disabled selected> Select Folder</option>
													@foreach($folders as $folder)
														@if ($folder->id == 1)
															@continue
														@endif
														<option value="{{$folder->id}}"> {{$folder->name}}</option>
													@endforeach
												</select>
												<label class="error" for="selectContract"></label>
												</div>
												@if($errors->has('folder'))
													<span class="text-danger"> {{$errors->first('contract')}}</span>
												@endif
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label"> Name
											</label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-user"></i>
													</span>
												<input 
												id="fileName" 
												name="name" 
												class="form-control"
												placeholder="File of File" 
												type="text">
												<label class="error" for="fileName"></label>
												</div>
												@if($errors->has('name'))
													<span class="text-danger"> {{$errors->first('name')}}</span>
												@endif
											</div>
										</div>										
										<div class="form-group">
											<label class="col-sm-2 control-label"> File <span class="required">*</span>
											</label>
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-user"></i>
													</span>
												<input 
												id="file" 
												name="file" 
												class="form-control"
												type="file"
												required>
												<label class="error" for="file"></label>
												</div>
												@if($errors->has('file'))
													<span class="text-danger"> {{$errors->first('file')}}</span>
												@endif
											</div>
										</div>
									</div>
									<footer class="panel-footer">
										<div class="row">
											<div class="col-sm-8 col-sm-offset-2">
												<button class="btn btn-success btn-block">Upload</button>
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

@endsection
