{{-- @extends('layouts.admin') --}}
@extends("layouts.".Auth::user()->person->department->slug )
@section('css')
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/datepicker3.css') }}" />

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css') }}" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme.css') }}" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/skins/default.css') }}" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme-custom.css') }}">

    <!-- Head Libs -->
    <script src="{{ asset('assets/vendor/modernizr/modernizr.js') }}"></script>
@endsection

@section('body')
    @if ($profile->level_id < 4)

        @if (Auth::user()->person->level_id > 3 || Auth::user()->person->department_id === 8) <button type="button"
        class="btn btn-primary" data-toggle="modal"
        data-target="#hr_point{{ $profile->id }}">
        Award HR Point
        </button>

        <!-- The Modal: HR Point -->
        <div class="modal" id="hr_point{{ $profile->id }}">
        <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Award HR Point to
        {{ $profile->slug }}
        </h4>
        <button type="button" class="close"
        data-dismiss="modal">&times;
        </button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
        <form action="{{ route('storehr') }}" method='POST'>
        @csrf

        {{-- HR Point --}}
        <div class="mb-3">
        <label for="point" class="form-lable"> HR Point</label>
        <input type="number" class="form-control numinput"
        name="hrPoint" id="" min="-2" max="2">
        </div>

        <div class="mb-3">
        <label for="description" class="form-lable">Remark</label>
        <input type="text" class="form-control"
        name="description" id="description">
        </div>

        <input type="text" class="form-control" name="personId"
        value='{{ $profile->id }}'
        style='display: none;'>

        <div class="mb-3">
        <button style="margin-top: 5px" type="submit" class="btn
        btn-primary">Submit
        </button>
        </div>
        </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-danger"
        data-dismiss="modal">Close
        </button>
        </div>

        </div>
        </div>
        </div>
        <!--End Of The Modal: HR Point--> @endif

        <!-- start: page -->
        <section role="main">
            <div class="container scroll" style="display: flex; overflow-x: scroll; overflow-y: hidden;">
                {{-- Total Executed Task --}}
                <div class="row sec-body">
                    <div style="margin: 30px">
                        <a style="text-decoration: none;" href="{{ route('totalTask', ['profile' => $profile->id]) }}">
                            <section class="panel panel-featured-left panel-featured-primary">
                                <div class="panel-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-primary">
                                                <i class="fa fa-tasks"></i>
                                            </div>
                                            <div class="widget-summary-col">
                                                <div class="summary d-flex">
                                                    <h4 class="title text-center">Total Tasks</h4>
                                                    <div class="info">
                                                        <strong class="amount">{{ $totalTask }}</strong>
                                                    </div>
                                                </div>
                                                <div class="summary-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </section>
                        </a>
                    </div>
                </div>

                {{-- Partner Point --}}
                <div class="row sec-body">
                    {{-- <div class="col-md-4"> --}}
                    <div style="margin: 30px">
                        <a style="text-decoration: none;"
                            href="{{ route('partnerPointDetails', ['profile' => $profile->id]) }}">
                            <section class="panel panel-featured-left panel-featured-primary">
                                <div class="panel-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-primary">
                                                <i class="fa fa-check"></i>
                                            </div>
                                            <div class="widget-summary-col">
                                                <div class="summary">
                                                    <h5 style="color: black; font-size: 1.5rem;" class="title">Partner
                                                        Points</h5>
                                                    <div class="info">
                                                        <strong class="amount text-center">{{ $partnerPoint }}</strong>
                                                    </div>
                                                </div>
                                                <div class="summary-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </section>
                        </a>
                    </div>
                </div>

                {{-- Line Manager Point --}}
                <div class="row sec-body">
                    <div style="margin: 30px">
                        <a style="text-decoration: none;"
                            href="{{ route('linemanagerPointDetails', ['profile' => $profile->id]) }}">
                            <section class="panel panel-featured-left panel-featured-primary">
                                <div class="panel-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-primary">
                                                <i class="fa fa-check"></i>
                                            </div>
                                            <div class="widget-summary-col">
                                                <div class="summary">
                                                    <h4 class="title">LM Points</h4>
                                                    <div class="info">
                                                        <strong class="amount">{{ $lineManagerPoint }}</strong>
                                                    </div>
                                                </div>
                                                <div class="summary-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </section>
                        </a>
                    </div>
                </div>

                {{-- HR Point --}}
                <div class="row sec-body">
                    <div style="margin: 30px">
                        <a style="text-decoration: none;" href="{{ route('hrPoint', ['profile' => $profile->id]) }}">
                            <section class="panel panel-featured-left panel-featured-primary">
                                <div class="panel-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-primary">
                                                <i class="fa fa-check"></i>
                                            </div>
                                            <div class="widget-summary-col">
                                                <div class="summary">
                                                    <h4 class="title">HR Points</h4>
                                                    <div class="info">
                                                        <strong class="amount">{{ $hrPoint }}</strong>
                                                    </div>
                                                </div>
                                                <div class="summary-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </section>
                        </a>
                    </div>
                </div>

                {{-- Total Point --}}
                <div class="row sec-body">
                    <div style="margin: 30px">
                        <a style="text-decoration: none;" href="{{ route('totalPoint', ['profile' => $profile->id]) }}">
                            <section class="panel panel-featured-left panel-featured-primary">
                                <div class="panel-body">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon bg-primary">
                                                <i class="fa fa-check"></i>
                                            </div>
                                            <div class="widget-summary-col">
                                                <div class="summary">
                                                    <h4 class="title">Total Points</h4>
                                                    <div class="info">
                                                        <strong class="amount">{{ $totalPoint }}</strong>
                                                    </div>
                                                </div>
                                                <div class="summary-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </section>
                        </a>
                    </div>
                </div>
            </div>
            {{-- end --}}
    @endif


    <div class="row">
        <div class="col-md-4 col-lg-3">

            <section class="panel">
                <div class="panel-body">
                    <div class="thumb-info mb-md">
                        @if ($user->profile_image)
                            <img src="{{ asset('../images/') }}/{{ $user->profile_image }}"
                                class="rounded img-responsive" alt="John Doe">
                        @else
                            <img src="{{ asset('assets/images/!logged-user.jpg') }}" class="rounded img-responsive"
                                alt="John Doe">
                        @endif
                        <div class="thumb-info-title">
                            <span class="thumb-info-inner">{{ $profile->first_name . ' ' . $profile->last_name }}</span>
                            <span class="thumb-info-type">
                                @if ($profile->id == $profile->department->person_id)
                                    HOD, {{ $profile->department->name }}
                                @else
                                    {{ $profile->department->name }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <h6 class="text-muted text-center">About</h6>
                    <p>Email: {{ $profile->user->email ?? 'Not Available' }}</p>
                    <p>Phone : {{ $profile->phone_num ?? 'Not Available' }}</p>
                    <p>Staff ID : {{ $profile->user->person->staff_id ?? 'Not Available' }}</p>
                    <p>Birthday : {{ $profile->birth_day ?? 'Not Available' }}</p>
                    <p>Address : {{ $profile->address ?? 'Not Available' }}</p>
                    {{-- <p>
                                        <a href="{{ ('route')('conversation.start', ['person' => $profile->slug]) }}"
                                            class="btn btn-primary btn-block">
                                            Message
                                        </a>
                                    </p> --}}
                    <hr class="dotted short">

                    <div class="social-icons-list">
                        <a rel="tooltip" data-placement="bottom" target="_blank" href="http://www.facebook.com"
                            data-original-title="Facebook"><i class="fa fa-facebook"></i><span>Facebook</span></a>
                        <a rel="tooltip" data-placement="bottom" href="http://www.twitter.com"
                            data-original-title="Twitter"><i class="fa fa-twitter"></i><span>Twitter</span></a>
                        <a rel="tooltip" data-placement="bottom" href="http://www.linkedin.com"
                            data-original-title="Linkedin"><i class="fa fa-linkedin"></i><span>Linkedin</span></a>
                    </div>
                </div>
            </section>


            <section class="panel">
                <header class="panel-heading">
                    <h5 class="panel-title">
                        <span
                            class="label label-primary label-sm text-weight-normal va-middle mr-sm">{{ $department->people->count() }}</span>
                        <span class="va-middle">Department</span>
                    </h5>
                </header>
                <div class="panel-body">
                    <div class="content">
                        <ul class="simple-user-list">
                            @foreach ($department->people as $peeps)
                                @unless($peeps->id == $profile->id)
                                    <li>
                                        <figure class="image rounded">
                                            <img src="{{ asset('assets/images/!sample-user.jpg') }}"
                                                alt="{{ $peeps->first_name . ' ' . $peeps->last_name }}" class="img-circle">
                                        </figure>
                                        <span class="title">
                                            <a href="{{ route('profile.show', ['profile' => $peeps->slug]) }}">
                                                {{ $peeps->first_name . ' ' . $peeps->last_name }}
                                            </a>
                                        </span>
                                    </li>
                                @endunless
                            @endforeach
                        </ul>{{-- <hr class="dotted short">
										<div class="text-right">
											<a class="text-uppercase text-muted" href="#">(View All)</a>
										</div> --}}
                    </div>
                </div>
                <div class="panel-footer">
                </div>
            </section>

        </div>
        <div class="col-md-8 col-lg-6">

            {{-- Overview --}}
            <div class="tabs">
                <ul class="nav nav-tabs tabs-primary">
                    <li class="active">
                        <a href="#overview" data-toggle="tab">Overview</a>
                    </li>
                    @if (Auth::user()->person->level_id > 3 || Auth::user()->person->department_id === 8)
                        <li>
                            <a href="#edit" data-toggle="tab">Edit</a>
                        </li>
                    @endif
                </ul>
                <div class="tab-content">
                    <div id="overview" class="tab-pane active">
                        <h5 class="mb-xlg">Latest Activities</h5>

                        <div class="timeline timeline-simple mt-xlg mb-md">
                            <div class="tm-body">
                                <ol class="tm-items">
                                    @if ($logs->count() > 0)
                                        @foreach ($logs as $log)
                                            <li>
                                                <div class="tm-box">
                                                    <p class="text-muted mb-none">{{ $log->created_at }}.</p>
                                                    <p>
                                                        {!! $log->description !!} <span
                                                            class="text-info">#{{ appLogAction($log->action_type) }}</span>
                                                    </p>
                                                </div>
                                                @if ($loop->last)
                                                    <p class="text-info text-right">
                                                        <a href="{{ route('log.person', $log->person->slug) }}"><i>View
                                                                all</i></a>
                                                    </p>
                                                @endif
                                            </li>
                                        @endforeach
                                    @else
                                        <li>
                                            <div class="tm-box">
                                                <p>
                                                    {{ 'No Activities Yet.' }} <span class="text-info">#Fresh</span>
                                                </p>
                                            </div>
                                        </li>
                                    @endif
                                </ol>
                            </div>
                        </div>
                    </div>
                    {{-- Profile Update --}}
                    @if (Auth::user()->person->level_id > 3 || Auth::user()->person->department_id === 8)
                        <div id="edit" class="tab-pane">
                            <form class="form-horizontal" action="{{ route('update', ['profile' => $profile->id]) }}"
                                method="POST">
                                @csrf
                                <h4 class="mb-xlg">Personal Information</h4>
                                <fieldset>
                                    {{-- {{-- First Name --}}
                                    {{-- <div class="form-group">
                                                <label class="col-md-3 control-label" for="first_name">First
                                                    Name</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="first_name"
                                                           name="first_name"
                                                           value="{{ $profile->first_name }}">
                                                </div>
                                            </div> --}}

                                    {{-- {{-- Last Name --}}
                                    {{-- <div class="form-group">
                                                <label class="col-md-3 control-label" for="last_name">Last
                                                    Name</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="last_name"
                                                           name="last_name"
                                                           value=" {{ $profile->last_name }} ">
                                                </div>
                                            </div> --}}

                                    {{-- Address --}}
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="address">Address</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="address" name="address"
                                                value=" {{ $profile->address }} ">
                                        </div>
                                    </div>

                                    {{-- Staff_Id --}}
                                    {{-- <div class="form-group">
                                                <label class="col-md-3 control-label" for="staff_id">Staff Id</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control" id="staff_id"
                                                           name="staff_id"
                                                           value=" {{ $profile->staff_id }} ">
                                                </div>
                                            </div> --}}

                                    {{-- Phone Number --}}
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="phone_number">Phone</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                                value=" {{ $profile->phone_num }} ">
                                        </div>
                                    </div>

                                    {{-- Birthday --}}
                                    <div class="form-group">
                                        <label class="col-md-3 control-label" for="birth_day">Birthday</label>
                                        <div class="col-md-8">
                                            <input type="date" class="form-control" id="birth_day" name="birth_day"
                                                value=" {{ $profile->birth_day }} ">
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-md-9 col-md-offset-3">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <button type="reset" class="btn btn-default">Reset</button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    @endif
                </div>
            </div>

        </div>
        <div class="col-md-12 col-lg-3">

            <h4 class="mb-md">Current Stats</h4>
            <div class="panel-group" id="accordion">
                <div class="panel panel-accordion">
                    <div class="panel-heading ">
                        <h4 class="panel-title ">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                href="#collapse1One">
                                {{ $clients->count() . ' Clients' }}
                            </a>
                        </h4>
                    </div>
                    <div id="collapse1One" class="accordion-body collapse">
                        <div class="panel-body">
                            <table class="table table-bordered table-striped mb-none" id="datatable-default">
                                <tbody>
                                    @foreach ($clients as $client)
                                        <tr>
                                            <td>
                                                <a href="{{ route('client.show', ['client' => $client->slug]) }}">
                                                    {{ $client->name }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-accordion">
                    <div class="panel-heading ">
                        <h4 class="panel-title ">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                href="#collapse1Two">
                                {{ $instructions->count() . ' Instructions' }}
                            </a>
                        </h4>
                    </div>
                    <div id="collapse1Two" class="accordion-body collapse">
                        <div class="panel-body">
                            <table class="table table-bordered table-striped mb-none" id="datatable-default">
                                <tbody>
                                    @foreach ($instructions as $instruction)
                                        <tr>
                                            <td>
                                                <a
                                                    href="{{ route('instruction.task.index', ['instruction' => $instruction->slug]) }}">
                                                    {{ $instruction->name }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-accordion">
                    <div class="panel-heading ">
                        <h4 class="panel-title ">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                href="#collapse1Three">
                                {{ $tasks->count() . ' Tasks' }}
                            </a>
                        </h4>
                    </div>
                    <div id="collapse1Three" class="accordion-body collapse in">
                        <div class="panel-body">
                            <table class="table table-bordered table-striped mb-none" id="datatable-default">
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr>
                                            <td>
                                                <a
                                                    href="{{ route('instruction.task.show', ['instruction' => $task->instruction->slug, 'task' => $task->slug]) }}">
                                                    {{ $task->name }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end: page -->
    </section>
@endsection


@section('js')
    <!-- Specific Page Vendor -->
    <script src="{{ asset('assets/vendor/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js') }}">
    </script>
    <script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>

    <!-- Examples -->
    <script src="{{ asset('assets/javascripts/tables/examples.datatables.default.js') }}"></script>
    <script src="{{ asset('assets/javascripts/tables/examples.datatables.row.with.details.js') }}"></script>
    <script src="{{ asset('assets/javascripts/tables/examples.datatables.tabletools.js') }}"></script>


    <!-- Specific Page Vendor -->
    <script type="text/javascript">
        $('.numinput').on('input', function() {
            this.value = this.value.replace(/(?!^-)[^0-9.]/g, "").replace(/(\..*)\./g, '$1');
        });

    </script>
@endsection
