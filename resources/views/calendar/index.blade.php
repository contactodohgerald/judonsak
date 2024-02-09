{{--@extends('layouts.admin')--}}
@extends("layouts.".\Auth::user()->person->department->slug )
@section('css')
	<!-- Vendor CSS -->
<!-- 	<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.css')}}" />

	<link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/vendor/magnific-popup/magnific-popup.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-datepicker/css/datepicker3.css')}}" />

 -->
	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="{{asset('assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/vendor/fullcalendar/fullcalendar.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/vendor/fullcalendar/fullcalendar.print.css')}}" media="print" />

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
					<section class="panel">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<div id="calendar"></div>
								</div>
							</div>
						</div>
					</section>

					<!-- end: page -->
@endsection

@section('js')

		<!-- Specific Page Vendor -->
		<script src="{{asset('assets/vendor/fullcalendar/lib/moment.min.js')}}"></script>
		<script src="{{asset('assets/vendor/fullcalendar/fullcalendar.js')}}"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="{{asset('assets/javascripts/theme.js')}}"></script>
		
		<!-- Theme Custom -->
		<script src="{{asset('assets/javascripts/theme.custom.js')}}"></script>
		
		<!-- Theme Initialization Files -->
		<script src="{{asset('assets/javascripts/theme.init.js')}}"></script>

<script>

  $(document).ready(function() {

  	var getDates = {!! json_encode($calendars) !!};
  	var month    = "{{ date('m')}}"
  	var eventDays = []
  	var specialDays = getDates.map((item, index) => {
  		eventDays.push(
  			{
  				title : item.contact.name + '\'s ' + item.name.toUpperCase(),
  				start : item.date
  			}
  		)
  	});
  	console.log(eventDays, );


    $('#calendar').fullCalendar({
      defaultDate: '2019-'+month+'-12',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      editable: false,
      eventLimit: true, // allow "more" link when too many events
      events: eventDays
    });

  });

</script>



@endsection