{{-- @extends('layouts.admin') --}}
@extends("layouts.".\Auth::user()->person->department->slug )
@section('css')
    {{-- Vendor CSS --}}
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
                <a href="{{ route('bestEmployee') }}">
                    <button class="btn btn-primary">Best Employee of the Month</button>
                </a>
                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                {{-- <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a> --}}
            </div>

            <h2 class="panel-title">Staff</h2>
        </header>

        <div class="panel-body">
            <table class="table table-bordered table-striped mb-none" id="datatable-default">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="20%">Name</th>
                        <th width="25%">Email</th>
                        <th width="25%">Department</th>
                        <th width="20%">Designation</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($people as $person)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                <a href="{{ route('profile.show', ['[profile]' => $person->slug]) }}">
                                    {{ $person->first_name . ' ' . $person->last_name ?? 'No Name Set' }}
                                </a>
                            </td>
                            <td>
                                <a href="mailto:{{ $person->user->email }}">
                                    {{ $person->user->email }}
                                </a>
                            </td>
                            <td>
                                {{ $person->department->name ?? 'Does not belong to a department' }}
                            </td>
                            <td>
                                {{ $person->level->name ?? 'Level had not been set' }}
                            </td>
                            <td>
                                <a href="#" onclick="event.preventDefault();
                                   if(confirm('Are you sure you want to PERMANENTLY delete this Staff')){
                                                             document.getElementById('delete-form').submit();
                                   }" style="cursor: pointer; font-size: 20px" class="on-default view-row text-info"
                                    data-toggle="tooltip" data-placement="top" title="Delete Staff">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                                <form id="delete-form"
                                    action="{{ route('profile.destroy', [
    'profile' => $person->slug,
]) }}"
                                    method="POST" style="display: none;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    @csrf
                                </form>

                            </td>
                        </tr>
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
