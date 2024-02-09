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
    <div class="col-md-12">
        <section class="panel-featured panel-featured-success">
            <header class="panel-heading">
                <div class="panel-actions">
                    <!-- <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a> -->
                </div>

                <h1 class="panel-title text-center"> <span class="text-primary"> Client : </span>{{ $client->name }}</h1>
                <br>
                <div class="row">
                    <div class="col-sm-4">
                        <p class="panel-subtitle"> Address : {{ $client->address ?? 'Not Available' }}</p>
                        <p class="panel-subtitle">
                            Industry : {{ $client->industry ?? 'Not Available' }}
                        </p>
                        <p class="panel-subtitle">
                            NOB : {{ $client->nature_of_business ?? 'Not Available' }}
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <p class="panel-subtitle">
                            Phone : {{ $client->phone_num ?? 'Not Available' }}
                        </p>
                        <p class="panel-subtitle">
                            Email : {{ $client->email ?? 'Not Available' }}
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <p class="panel-subtitle">
                            State : {{ $client->state->name ?? 'Not Available' }}
                        </p>
                        <p class="panel-subtitle">
                            TIN : {{ $client->tin ?? 'Not Available' }}
                        </p>
                    </div>
                </div>
            </header>
            <div class="panel-body">
                <br>
                <!-- begining of widget -->
                <div class="col-md-12 col-lg-12 col-xl-4">
                    <div class="row">
                        <div class="col-md-6 col-xl-12">
                            <section class="panel">
                                <div class="panel-body bg-primary">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon">
                                                <i class="fa fa-life-ring"></i>
                                            </div>
                                        </div>
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title">Client's Account</h4>
                                                <div class="info">
                                                    <strong class="amount">&#8358;0.00</strong>
                                                </div>
                                            </div>
                                            <div class="summary-footer">
                                                <a class="text-uppercase">(view details)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-6 col-xl-12">
                            <section class="panel">
                                <div class="panel-body bg-secondary">
                                    <div class="widget-summary">
                                        <div class="widget-summary-col widget-summary-col-icon">
                                            <div class="summary-icon">
                                                <i class="fa fa-life-ring"></i>
                                            </div>
                                        </div>
                                        <div class="widget-summary-col">
                                            <div class="summary">
                                                <h4 class="title">Revenue</h4>
                                                <div class="info">
                                                    <strong class="amount">&#8358;0.00</strong>
                                                </div>
                                            </div>
                                            <div class="summary-footer">
                                                <a class="text-uppercase">(view details)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <!-- end of widget -->
                    <br>
                </div>
            </div>
        </section>
        <div>
            <section class="panel-featured panel-featured-info">
                <div>
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="{{ route('client.contract.create', ['client' => $client->slug]) }}"
                                data-toggle="tooltip" data-placement="top" title="Add New Contract"
                                class="btn btn-info btn-xs"> <i class="fa fa-plus"></i></a>
                        </div>
                        <h2 class="panel-title">Contract</h2>
                    </header>
                    <div class="panel-body">
                        <br>
                        {{-- Contract table --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-none" id="datatable-default">
                                <thead>
                                    <tr>
                                        <th width="15%">Name</th>
                                        <th width="15%">Amount</th>
                                        <th width="25%">Services</th>
                                        <th width="10%">Intructions</th>
                                        <th width="10%">Status</th>
                                        <th width="12%">Date</th>
                                        <th width="13%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($client->descContracts as $contract)
                                        <tr class="gradeA">
                                            <td>
                                                <a href="{{ route('contract.instruction.index', ['contract' => $contract->slug ?? 'Not Available']) }}"
                                                    class="on-default view-row text-info" data-toggle="tooltip"
                                                    data-placement="top" title="Contract Details"> {{ $contract->name }}
                                                </a>
                                            </td>
                                            <td>{{ $contract->currency['name'] ?? 'Not Available' }}
                                                {{ number_format($contract->amount) ?? 'Not Available' }}</td>
                                            <td>
                                                <table>
                                                    @foreach ($contract->services as $service)
                                                        <tr>
                                                            {{ $service->name ?? 'Not Available' }}
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>
                                                {{ $contract->instructions->count() > 0 ? ($contract->instructions->count() > 1 ? $contract->instructions->count() . ' Instructions' : $contract->instructions->count() . ' Instruction') : '-- Nill-- ' }}
                                            </td>
                                            <td>{{ $contract->status['name'] ?? 'Not Available' }}</td>
                                            <td>{{ $contract->created_at->format('Y-m-d') ?? 'Not Available' }}</td>
                                            <td>
                                                <a href="{{ route('contract.instruction.create', ['contract' => $contract->slug ?? 'Not Available']) }}"
                                                    class="on-default view-row text-info" data-toggle="tooltip"
                                                    data-placement="top" title="Add Instructions">
                                                    <i class="fa fa-plus"></i>
                                                </a> &nbsp;
                                                <a href="{{ route('client.contract.edit', ['client' => $client->slug, 'contract' => $contract->slug]) }}"
                                                    class="on-default edit-row text-success" data-toggle="tooltip"
                                                    data-placement="top" title="Edit Contract">
                                                    <i class="fa fa-pencil"></i>
                                                </a> &nbsp;
                                                <a href="{{ route('client.destroy', ['client' => $client->slug]) }}"
                                                    onclick="event.preventDefault();
                                                         document.getElementById('delete-form{{ $loop->iteration }}').submit();"
                                                    class="on-default remove-row text-danger" data-toggle="tooltip"
                                                    data-placement="top" title="Delete Contract">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                                <form id="delete-form{{ $loop->iteration }}"
                                                    action="{{ route('client.contract.destroy', ['client' => $client->slug, 'contract' => $contract->slug]) }}"
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
                        <!-- end of instruction table -->

                    </div>
                </div>
                <div>
                    <header class="panel-heading">
                        <div class="panel-actions">
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Contacts"> <i
                                    class="fa fa-user"></i></a>
                        </div>
                        <h2 class="panel-title">Contacts</h2>
                    </header>
                    <div class="panel-body">
                        <br>
                        {{-- Contacts table --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-none" id="datatable-default">
                                <thead>
                                    <tr>
                                        <th width="25%">Name</th>
                                        <th width="20%">Phone</th>
                                        <th width="20%">Designation</th>
                                        <th width="15%">Birthday</th>
                                        <th width="15%">Anniversary</th>
                                        <th width="10%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($client->contacts as $contact)
                                        <tr class="gradeA">
                                            <td>{{ $contact->name ?? 'Nill' }}</td>
                                            <td>{{ $contact->phone_num ?? 'Nill' }}</td>
                                            <td>{{ $contact->designation ?? 'Nill' }}</td>
                                            <td>{{ $contact->birthday ?? 'Nill' }}</td>
                                            <td>{{ $contact->anniversary ?? 'Nill' }}</td>
                                            <td>
                                                <a href="{{ route('client.destroy', ['client' => $client->slug]) }}"
                                                    onclick="event.preventDefault();
     document.getElementById('delete-form').submit();"
                                                    class="on-default remove-row text-danger" data-toggle="tooltip"
                                                    data-placement="top" title="Delete Contract">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                                <form id="delete-form"
                                                    action="{{ route('contact.destroy', ['client' => $client->slug, 'contact' => $contact->id]) }}"
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
                        <!-- end of instruction table -->

                    </div>

                </div>
        </div><br><br><br>
        </section>


    </div>
    <!-- end: page -->

@endsection

@section('js')
    <!-- Vendor -->
    <script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/magnific-popup/magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>

    <!-- Specific Page Vendor -->
    <script src="{{ asset('assets/vendor/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js') }}">
    </script>
    <script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js') }}"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="{{ asset('assets/javascripts/theme.js') }}"></script>

    <!-- Theme Custom -->
    <script src="{{ asset('assets/javascripts/theme.custom.js') }}"></script>

    <!-- Theme Initialization Files -->
    <script src="{{ asset('assets/javascripts/theme.init.js') }}"></script>


    <!-- Examples -->
    <script src="{{ asset('assets/javascripts/tables/examples.datatables.default.js') }}"></script>
    <script src="{{ asset('assets/javascripts/tables/examples.datatables.row.with.details.js') }}"></script>
    <script src="{{ asset('assets/javascripts/tables/examples.datatables.tabletools.js') }}"></script>

@endsection
