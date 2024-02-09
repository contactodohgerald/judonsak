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
	<style type="text/css">
		.document-link :hover .panel-heading-icon{ 
			color: #cee !important;
		}
		.document-link :hover .panel-body{ 
			color: #5db146 !important;
		}

	</style>
@endsection
@section('body')
	<!-- start: page -->
	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
				<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
			</div>

			<h2 class="panel-title">Documents</h2>
		</header>
		<div class="panel-body">
			<div class="row" id="app-vue">
				@if($clients->count() > 0)
					@foreach($clients as $client)
					<div class="col-md-4" v-for= "client in clients">
			<a href="{{route('document.client', ['client' => $client->slug])}}" class="document-link" style="text-decoration: none">
						<section class="panel">
							<header class="panel-heading bg-success">
								<div class="panel-heading-icon">
									<i class="fa fa-folder"></i>
								</div>
								<div class="text-center">
									<i>{{$client->documents->count().' documents'}}</i>
								</div>
							</header>
							<div class="panel-body text-center" style="border: 1px solid #cee">
								<h4 class="text-weight-semibold mt-sm text-center" style="min-height: 70px;">{{$client->name}}</h4>
							</div>
						</section>
					</a>
					</div>
					@endforeach
				@else
					<div class="col-md-12" v-for= "client in clients">
						<section class="panel">
							<header class="panel-heading bg-success">
								<div class="panel-heading-icon">
									<i class="fa fa-folder"></i>
								</div>
								<div class="text-center">
									<i>{{' Nill'}}</i>
								</div>
							</header>
							<div class="panel-body text-center" style="border: 1px solid #cee">
								<h4 class="text-weight-semibold mt-sm text-center" style="min-height: 70px;">{{'No Documents'}}</h4>
							</div>
						</section>
					</a>
					</div>				
				@endif
			</div>
		</div>
	</section>
@endsection

@section('js')
		<!-- Specific Page Vendor -->
{{--		<script src="{{asset('assets/vendor/pnotify/pnotify.custom.js')}}"></script>
<!-- 		<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.map"></script>
		<script type="text/javascript">
			var url = "{{ route('document.list') }}";
			var app = new Vue({
			  el: '#app-vue',
			  data: {
			    clients: null
			  },
			  mounted(){
			  	axios
			  		.get(url)
				    .then( response => ( this.clients = response.data.clients ) )
			  }
			})
		</script> -->--}}
@endsection
