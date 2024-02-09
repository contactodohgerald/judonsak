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
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
            </div>

            <h2 class="panel-title">Partner Point Details</h2>
        </header>
        <div class="panel-body">
            <table class="table table-bordered table-striped mb-none" id="datatable-default">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="20%">Partner Point</th>
                        <th width="20%">Instruction / Work</th>
                        <th width="20%">Tasks</th>
                        <th width="20%">Remark</th>
                        <th width="25%">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($points as $point)
                        @if ($point->partners_point !== null)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    <a href="#">
                                        {{ $point->partners_point }}
                                    </a>

                                </td>
                                <td>
                                    <a href="#">
                                        {{ $point->instruction_name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                        {{ $point->task_name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                        {{ $point->description }}
                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                        {{ $point->created_at }}
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
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
