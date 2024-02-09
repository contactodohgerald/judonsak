{{-- @extends('layouts.admin') --}}
@extends("layouts.".\Auth::user()->person->department->slug )

@section('css')
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />

    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
    <link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/select2/select2.css" />
    <link rel="stylesheet" href="assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="assets/stylesheets/theme.css" />

    <!-- Skin CSS -->
    <link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

    <!-- Head Libs -->
    <script src="assets/vendor/modernizr/modernizr.js"></script>
@endsection


@section('body')
    <section class="panel-featured panel-featured-success">
        <header class="panel-heading">
            <div class="panel-actions">
                <!-- <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a> -->
            </div>

            <h1 class="panel-title text-center"><span class="text-primary"> Contract : </span>{{ $contract->name }}</h1><br>
            <div class="row">
                <div class="col-sm-6">
                    <p class="panel-subtitle"> Client :
                        <strong>
                            {{ $contract->client['name'] }}
                        </strong>
                    </p>
                    <p class="panel-subtitle">
                        Amount : {{ $contract->currency->name . number_format($contract->amount) }}
                    </p>
                    <p class="panel-subtitle">
                        <a href="{{ route('contract.instruction.create', ['contract' => $contract->slug]) }}"
                            class="btn btn-success btn-xs">
                            <i class="fa fa-plus"></i> Add Instructions
                        </a>
                    </p>
                </div>
                <div class="col-sm-6">
                    <p class="panel-subtitle">
                        Starts : {{ $contract->start_date }}
                    </p>
                    <p class="panel-subtitle">
                        Status : {{ $contract->status->name }}
                    </p>
                    <p class="panel-subtitle">
                        <a href="{{ route('client.contract.edit', ['client' => $contract->client->slug, 'contract' => $contract->slug]) }}"
                            class="btn btn-success btn-xs">
                            <i class="fa fa-edit"></i> Edit Contract
                        </a>
                    </p>
                </div>
            </div>
        </header>
    </section>

    <!-- start: page -->
    <section class="panel-featured panel-featured-info">
        <div class="panel-body">
            @foreach ($contract->services as $service)
                <header class="panel-heading">
                    <h2 class="panel-title">Service : {{ $service->name }}</h2>
                </header>
                <div class="panel-body">
                    <table class="table table-bordered table-striped mb-none" id="datatable-default">
                        <thead>
                            <tr>
                                <th width="20%">Instruction</th>
                                <th width="15%">Managers</th>
                                <th width="7%">Tasks</th>
                                <th width="33%">Remarks</th>
                                <th width="12%">Status</th>
                                <th width="13%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contract->instructions as $instruct)
                                {{-- perfect solution is nested eager loads --}}
                                @if ($instruct->service_id == $service->id)
                                    <tr class="gradeA">
                                        <td>
                                            <a href="{{ route('instruction.task.index', ['instruction' => $instruct->slug]) }}"
                                                class="on-default view-row text-info" data-toggle="tooltip"
                                                data-placement="top" title="View instruction">
                                                {{ $instruct->name }}
                                            </a>
                                        </td>
                                        <td>
                                            <table>
                                                @foreach ($instruct->people as $person)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('profile.show', ['profile' => $person->slug]) }}"
                                                                class="on-default view-row text-info" data-toggle="tooltip"
                                                                data-placement="top" title="View Profile">
                                                                {{ $person->first_name }} {{ $person->last_name }}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </table>
                                        </td>
                                        <td>
                                            <a href="{{ route('instruction.task.index', ['instruction' => $instruct->slug]) }}"
                                                class="on-default view-row text-info" data-toggle="tooltip"
                                                data-placement="top" title="View instruction">
                                                {{ $instruct->tasks->count() ? ($instruct->tasks->count() > 1 ? $instruct->tasks->count() . ' Tasks' : $instruct->tasks->count() . ' Task') : '-- Nill --' }}
                                            </a>
                                        </td>
                                        @if (null !== $instruct->remark)
                                            <td>
                                                {{ $instruct->remark }}
                                            </td>
                                        @else
                                            <td> No Remarks Yet</td>
                                        @endif
                                        <td>{{ $instruct->status->name }}</td>
                                        <td>
                                            <a href="{{ route('instruction.task.create', ['instruction' => $instruct->slug]) }}"
                                                class="on-default view-row text-info" data-toggle="tooltip"
                                                data-placement="top" title="Add Task">
                                                <i class="fa fa-plus"></i>
                                            </a> &nbsp;

                                            <a href="{{ route('contract.instruction.edit', ['contract' => $contract->slug, 'instruction' => $instruct->slug]) }}"
                                                class="on-default edit-row text-success" data-toggle="tooltip"
                                                data-placement="top" title="Edit Instruction">
                                                <i class="fa fa-pencil"></i>
                                            </a> &nbsp;

                                            <a href="{{ route('contract.instruction.destroy', ['contract' => $contract->slug, 'instruction' => $instruct->slug]) }}"
                                                onclick="event.preventDefault();
                                         document.getElementById('delete-form-{{ $instruct->id }}').submit();"
                                                class="on-default remove-row text-danger" data-toggle="tooltip"
                                                data-placement="top" title="Delete instruction">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                            <form id="delete-form-{{ $instruct->id }}"
                                                action="{{ route('contract.instruction.destroy', ['contract' => $contract->slug, 'instruction' => $instruct->slug]) }}"
                                                method="POST" style="display: none;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
    </section>

@endsection

@section('js')
    <!-- Vendor -->
    <script src="assets/vendor/jquery/jquery.js"></script>
    <script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
    <script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
    <script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
    <script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>

    <!-- Specific Page Vendor -->
    <script src="assets/vendor/select2/select2.js"></script>
    <script src="assets/vendor/jquery-datatables/media/js/jquery.dataTables.js"></script>
    <script src="assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js"></script>
    <script src="assets/vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="assets/javascripts/theme.js"></script>

    <!-- Theme Custom -->
    <script src="assets/javascripts/theme.custom.js"></script>

    <!-- Theme Initialization Files -->
    <script src="assets/javascripts/theme.init.js"></script>


    <!-- Examples -->
    <script src="assets/javascripts/tables/examples.datatables.default.js"></script>
    <script src="assets/javascripts/tables/examples.datatables.row.with.details.js"></script>
    <script src="assets/javascripts/tables/examples.datatables.tabletools.js"></script>

@endsection
