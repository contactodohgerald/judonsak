{{-- @extends('layouts.admin') --}}
@extends("layouts.".\Auth::user()->person->department->slug )

@section('css')
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assetsvendor/bootstrap/css/bootstrap.csss') }}" />
    <link rel="stylesheet" href="{{ asset('assetsvendor/font-awesome/css/font-awesome.csss') }}" />
    <link rel="stylesheet" href="{{ asset('assetsvendor/magnific-popup/magnific-popup.csss') }}" />
    <link rel="stylesheet" href="{{ asset('assetsvendor/bootstrap-datepicker/css/datepicker3.csss') }}" />

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assetsvendor/select2/select2.csss') }}" />
    <link rel="stylesheet" href="{{ asset('assetsvendor/jquery-datatables-bs3/assets/css/datatables.csss') }}" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assetsstylesheets/theme.csss') }}" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{ asset('assetsstylesheets/skins/default.csss') }}" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assetsstylesheets/theme-custom.csss') }}">

    <!-- Head Libs -->
    <script src="{{ asset('assetsvendor/modernizr/modernizr.js') }}"></script>
@endsection


@section('body')
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" style="margin: 120px auto; role=" document>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"> Add New Note </h4>
                </div>
                <form class="form-horizontal 
              form-bordered" method="post" action="{{ route('task.create.note') }}">
                    <div class="modal-body">
                        @csrf()
                        <input type="hidden" value="" name="task" id="inputslug" class="form-control">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Note</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="body" value={{ old('body') }}></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class=" col-md-12">
                            <button type="submit" class="btn btn-success btn-block">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- start: page -->
    <div class="col-md-12">
        <section class="panel-featured panel-featured-success">
            <header class="panel-heading">
                <div class="panel-actions">
                    <!-- <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a> -->
                </div>

                <h1 class="panel-title text-center"><span class="text-primary"> Task : </span> {{ $task->name }}</h1><br>
                <div class="row">
                    <div class="col-sm-6">
                        <p class="panel-subtitle"> Assigned To :
                            <strong>
                                <tr>
                                    <td>
                                        <a href="{{ route('profile.show', ['profile' => $task->executor->slug]) }}"
                                            data-toggle="tooltip" data-placement="top" title="View Proile Details">
                                            {{ $task->executor->first_name }} {{ $task->executor->last_name }}
                                        </a>
                                    </td>
                                </tr>
                            </strong>
                        </p>
                        <p class="panel-subtitle">
                            Status : {{ $task->status->name }}
                        </p>
                        <p class="panel-subtitle">
                            Deadline : {{ $task->deadline }}
                        </p>
                        <p class="panel-subtitle">
                            Description : {{ $task->description }}
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <p class="panel-subtitle">
                            Client :
                            <a
                                href="{{ route('client.show', ['client' => $task->instruction->contract->client->slug ?? 'No Instruction Set']) }}">
                                {{ $task->instruction->contract->client->name }}
                            </a>
                        </p>
                        <p class="panel-subtitle">
                            Contract :
                            <a href="{{ route('client.contract.show', ['client' => $task->instruction->contract->client->slug, 'contract' => $task->instruction->contract->slug]) }}"
                                data-toggle="tooltip" data-placement="top" title="Contract Details">
                                {{ $task->instruction->contract->name }}
                            </a>
                        </p>
                        <p class="panel-subtitle">
                            Instruction :
                            <a href="
                   {{ route('instruction.task.index', ['instruction' => $task->instruction->slug]) }}">
                                {{ $task->instruction->name }}
                            </a>
                        </p>
                    </div>
                </div>
            </header>
        </section>
        <div>
            <section class="panel-featured panel-featured-info">
                <div>
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a id="clickModal" data-target="#myModal" data-id="{{ $task->slug }}" data-toggle="tooltip"
                                data-placement="top" title="Add New Note" class="btn btn-info btn-xs">
                                <i class="fa fa-plus"></i></a>
                        </div>
                        <h2 class="panel-title">Notes</h2>
                    </header>
                    <div class="panel-body">
                        <br>
                        {{-- Contract table --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-none" id="datatable-default">
                                <thead>
                                    <tr>
                                        <th width="25%">Name</th>
                                        <th width="55%">Details</th>
                                        <th width="20%">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($task->notes as $note)
                                        <tr class="gradeA">
                                            <td>
                                                <a href="{{ route('profile.show', ['profile' => $note->person->slug]) }}"
                                                    class="on-default view-row text-info" data-toggle="tooltip"
                                                    data-placement="top" title="View Profile Details">
                                                    {{ $note->person->first_name . ' ' . $note->person->last_name }}
                                                </a>
                                            </td>
                                            <td>{{ $note->body }}</td>
                                            <td>{{ $note->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- end of instruction table -->
                    </div>
                </div>
                <div>
                </div>
        </div><br><br><br>
        </section>


    </div>
    <!-- end: page -->

@endsection

@section('js')
    <!-- Vendor -->
    <script src="{{ asset('assetsvendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assetsvendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
    <script src="{{ asset('assetsvendor/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assetsvendor/nanoscroller/nanoscroller.js') }}"></script>
    <script src="{{ asset('assetsvendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assetsvendor/magnific-popup/magnific-popup.js') }}"></script>
    <script src="{{ asset('assetsvendor/jquery-placeholder/jquery.placeholder.js') }}"></script>

    <!-- Specific Page Vendor -->
    <script src="{{ asset('assetsvendor/select2/select2.js') }}"></script>
    <script src="{{ asset('assetsvendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assetsvendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js') }}">
    </script>
    <script src="{{ asset('assetsvendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="{{ asset('assetsjavascripts/theme.js') }}"></script>

    <!-- Theme Custom -->
    <script src="{{ asset('assetsjavascripts/theme.custom.js') }}"></script>

    <!-- Theme Initialization Files -->
    <script src="{{ asset('assetsjavascripts/theme.init.js') }}"></script>


    <!-- Examples -->
    <script src="{{ asset('assetsjavascripts/tables/examples.datatables.default.js') }}"></script>
    <script src="{{ asset('assetsjavascripts/tables/examples.datatables.row.with.details.js') }}"></script>
    <script src="{{ asset('assetsjavascripts/tables/examples.datatables.tabletools.js') }}"></script>
    <script type="text/javascript">
        $(document).on("click", "#clickModal", function() {
            var taskSlug = $(this).attr('data-id');
            $(".modal-body #inputslug").val(taskSlug);
            $('#myModal').modal('show');
        });

    </script>


@endsection
