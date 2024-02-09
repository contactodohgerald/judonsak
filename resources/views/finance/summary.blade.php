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
    <section class="panel-featured panel-featured-success">
        <header class="panel-heading">
            <div class="panel-actions">
                <!-- <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a> -->
            </div>

            <h1 class="panel-title text-center">
                <span class="text-primary">
                    Financial Summary For March
                    {{-- {{ 'Financial Summary For ' . \Carbon::now()->addmonth()->englishMonth }} --}}
                </span>
            </h1><br>
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="panel-body">
                        <div class="table table-responsive">
                            <table class="table table-bordered table-striped mb-none">
                                <thead>
                                    <tr>
                                        <th width="40%"></th>
                                        <th width="30%">NGN</th>
                                        <th width="30%">USD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong>{{ 'Revenue Projections' }}</strong>
                                        </td>
                                        <td class="bg-primary">
                                            {{ number_format($paymentsNGN) }}
                                        </td>
                                        <td class="bg-primary">
                                            {{ number_format($paymentsUSD) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>{{ 'Current Receivables' }}</strong>
                                        </td>
                                        <td class="bg-primary">
                                            {{ number_format($recievables->where('currency_id', '=', 1)->sum('amount_paid')) }}
                                        </td>
                                        <td class="bg-primary">
                                            {{ number_format($recievables->where('currency_id', '=', 2)->sum('amount_paid')) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>{{ 'Expenditures' }}</strong>
                                        </td>
                                        <td class="bg-info">{{ number_format($expenditures) }}</td>
                                        <td class="bg-info">Nill</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>{{ 'Summary' }}</strong>
                                        </td>
                                        <td class="{{ $bool ? 'bg-success' : 'bg-danger' }}">
                                            {{ number_format($paymentsNGN + $recievables->where('currency_id', '=', 1)->sum('amount_paid') - $expenditures) }}
                                        </td>
                                        <td class="success">
                                            {{ number_format($recievables->where('currency_id', '=', 2)->sum('amount_paid')) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </section>
    <br>


    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
            </div>

            <h2 class="panel-title">{{ 'Projections Details' }}</h2>
        </header>
        <div class="panel-body">
            <table class="table table-bordered table-striped mb-none" id="datatable-revenue">
                <thead>
                    <tr>
                        <th width="5%">S/N</th>
                        <th width="20%">Client</th>
                        <th width="30%">Description</th>
                        <th width="10%">Status</th>
                        <th width="20%">Amount</th>
                        <th width="15%">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>
                            </td>

                            <td>
                                {{ $payment->contract->client->name }}
                            </td>
                            <td>
                                {{ $payment->contract->name }}
                            </td>
                            <td>
                                <span class="label label-info">
                                    Revenue
                                </span>
                            </td>
                            <td>
                                {{ $payment->contract->currency->name . ' ' . number_format(($payment->percent / 100) * $payment->contract->amount) }}
                            </td>
                            <td>
                                {{ $payment->due_date }}
                            </td>
                        </tr>
                    @endforeach
                    @foreach ($recievables as $recievable)
                        <tr>
                            <td>
                            </td>

                            <td>
                                {{ $recievable->feenote->client->name }}
                            </td>
                            <td>
                                {{ $recievable->feenote->subject }}
                            </td>
                            <td>
                                <span class="label label-warning">
                                    Recievables
                                </span>
                            </td>
                            <td>
                                {{ $recievable->currency->name . ' ' . number_format($recievable->amount_paid, 2) }}
                            </td>
                            <td>
                                {{ $recievable->balance_date }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

@section('js')
    <!-- Examples -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>


    <!-- Specific Page Vendor -->
    <script type="text/javascript">
        $(document).ready(function() {
            let revenueTable = document.getElementById('datatable-revenue');
            revenueTable = $('#datatable-revenue').DataTable({
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                "order": [
                    [1, 'asc']
                ],
                "pageLength": 50
            });

            revenueTable.on('order.dt search.dt', function() {
                revenueTable.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });

    </script>


@endsection
