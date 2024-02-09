{{-- @extends('layouts.admin') --}}
@extends("layouts.".\Auth::user()->person->department->slug )
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
    <!-- start: page -->
    <section class="panel">
        {{-- <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
            </div>

            <h2 class="panel-title">Total Point</h2>
        </header>
        <div class="panel-body">
            <table class="table table-bordered table-striped mb-none" id="datatable-default">
                <thead>
                    <tr>
                        <th width="5%">S/N</th>
                        <th width="20%">Total Partner Point</th>
                        <th width="20%">Total Line Manager Point</th>
                        <th width="20%">Total HR Point</th>
                        <th width="25%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                        <td>
                            {{ 1 }}
                        </td>
                        {{-- Total Partner Point --}}
        {{-- <td>
                            <a href="#">
                                {{ $totalPartnerPoints }}
                            </a>
                        </td> --}}

        {{-- Total Line Manager Point --}}
        {{-- <td>
                            <a href="#">
                                {{ $totalLMPoints }}
                            </a>
                        </td> --}}

        {{-- Total HR Point --}}
        {{-- <td>
                            <a href="#">
                                {{ $totalHrPoint }}
                            </a>
                        </td> --}}


        {{-- Total Point --}}
        {{-- <td>
                            <a href="#">
                                {{ $totalPoint }}
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div> --}}
        <h2 class="panel-title" style="margin:10px">Total Point Details</h2>

        <div class="col-md-4">
            <section class="panel panel-featured-left panel-featured-primary">
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-primary">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 style="color: black; font-size: 1.5rem;" class="title">Total Partner Points</h4>
                                <div class="info">
                                    <strong class="amount">{{ $totalPartnerPoints }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-md-4">
            <section class="panel panel-featured-left panel-featured-primary">
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-primary">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 style="color: black; font-size: 1.5rem;" class="title">Total Line Manager Points</h4>
                                <div class="info">
                                    <strong class="amount">{{ $totalLMPoints }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-md-4">
            <section class="panel panel-featured-left panel-featured-primary">
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-primary">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 style="color: black; font-size: 1.5rem;" class="title"> Total HR Points</h4>
                                <div class="info">
                                    <strong class="amount">{{ $totalHrPoint }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-md-4">
            <section class="panel panel-featured-left panel-featured-primary">
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-primary">
                                <i class="fa fa-check"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 style="color: black; font-size: 1.5rem;" class="title"> Total Points</h4>
                                <div class="info">
                                    <strong class="amount">{{ $totalPoint }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
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
    <script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js') }}"></script>
    <script type="text/javascript">
        $(document).on("click", "#clickModal", function() {
            var assignedTo = $(this).attr('data-assignedTo');
            var personTitle = $(this).attr('data-personTitle');
            var peoplelug = $(this).attr('data-id');
            $("#myModalpersonTitle").html(personTitle);
            $(".modal-body #inputAssignedTo").val(assignedTo);
            $(".modal-body #inputperson").val(peoplelug);
            $('#myModal').modal('show');
        });

    </script>
@endsection
