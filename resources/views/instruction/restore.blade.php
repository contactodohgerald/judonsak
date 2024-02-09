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

            <h2 class="panel-title">Latest Instructions</h2>
        </header>
        <div class="panel-body">
            <table class="table table-bordered table-striped mb-none" id="datatable-default">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="20%">Client</th>
                        <th width="25%">Instruction</th>
                        <th width="15%">Managers</th>
                        <th width="15%">Tasks</th>
                        <th width="12%">Status</th>
                        <th width="3%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($instructions as $instruction)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <a href="{{ route('client.show', ['client' => $instruction->contract->client->slug]) }}">
                                    {{ $instruction->contract->client->name }}
                            </td>
                            </a>
                            <td>
                                {{ $instruction->name }}
                            </td>
                            <td>
                                <table>
                                    <tbody>
                                        @foreach ($instruction->people as $person)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('profile.show', ['profile' => $person->slug]) }}">
                                                        {{ $person->first_name }} {{ $person->last_name }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                @if ($instruction->tasks->count() < 2)
                                    {{ $instruction->tasks->count() . ' Task' }}
                                @else
                                    {{ $instruction->tasks->count() . ' Tasks' }}
                                @endif
                            </td>
                            <td>{{ $instruction->status->name }}</td>
                            <td>
                                <a href="#" onclick="event.preventDefault();
                       if(confirm('Are you sure you want to Restore this Instruction')){
                                                 document.getElementById('restore-form-{{ $loop->iteration }}').submit();
                       }" class="on-default 
                       remove-row text-danger" data-toggle="tooltip" data-placement="top" title="Restore instruction">
                                    <i class="fa fa-undo"></i>
                                </a>
                                <form id="restore-form-{{ $loop->iteration }}"
                                    action="{{ route('instruction.restoreDeleted', [
    'instruction' => $instruction->slug,
]) }}"
                                    method="POST" style="display: none;">
                                    <input type="hidden" name="_method" value="PUT">
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
    <script type="text/javascript">
        $(document).on("click", "#clickModal", function() {
            var taskTitle = $(this).attr('data-taskTitle');
            var taskSlug = $(this).attr('data-id');
            $("#myModalTaskTitle").html(taskTitle);
            $(".modal-body #inputTask").val(taskSlug);
            $('#myModal').modal('show');
        });

        $(document).on("click", "#clickTaskModal", function() {
            var instructionSlug = $(this).attr('data-id');
            $(".modal-body #inputInstruction").val(instructionSlug);
            $('#myTaskModal').modal('show');
        });

    </script>


@endsection
