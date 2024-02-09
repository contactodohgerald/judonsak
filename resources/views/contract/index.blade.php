@extends('layouts.admin')
@section('css')
    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css') }}"/>

    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/magnific-popup.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/datepicker3.css') }}"/>

    <!-- Specific Page Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css') }}"/>

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme.css') }}"/>

    <!-- Skin CSS -->
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/skins/default.css') }}"/>

    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme-custom.css') }}">

    <!-- Head Libs -->
    <script src="{{ asset('assets/vendor/modernizr/modernizr.js') }}"></script>
@endsection
@section('body')
    <!-- start: page -->
    <section class="panel">
        <div class="panel-heading">
            <header>
                <div class="panel-actions">
                    <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                    {{-- <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a> --}}
                </div>

                <h2 class="panel-title">All Contracts</h2>
            </header>
        </div>
        <div class="panel-body">
            <table class="table table-bordered table-striped mb-none" id="datatable-default">
                <thead>
                <tr>
                    <th width="4%">S/N</th>
                    <th width="30%">Name</th>
                    <th width="25%">Client</th>
                    <th width="8%">Status</th>
                    <th width="13%">Amount</th>
                    <th width="15%">Created</th>
                    <th width="5%">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($contracts as $contract)
                    <tr class="gradeA">
                        <td>
                        </td>
                        <td>
                            <a href="{{ route('client.contract.show', ['client' => $contract->client['slug'], 'contract' => $contract->slug]) }}"
                               data-toggle="tooltip" data-placement="top" title="Contract Details">
                                {{ $contract->name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('client.show', ['client' => $contract->client['slug']]) }}"
                               data-toggle="tooltip" data-placement="top" title="Client Details">
                                {{ $contract->client['name'] }}
                            </a>
                        </td>
                        <td>
                            {{ $contract->status->name }}
                        </td>
                        <td>
                            {{ $contract->currency->name . ' ' . number_format($contract->amount) }}
                        </td>
                        <td>
                            {{ date('d-m-Y', strtotime($contract->created_at)) ?? 'Not Available' }}
                        </td>
                        <td>
                            <a href="{{ route('client.contract.edit', ['client' => $contract->client['slug'], 'contract' => $contract->slug]) }}"
                               class="on-default edit-row text-success" data-toggle="tooltip" data-placement="top"
                               title="Edit contract">
                                <i class="fa fa-pencil"></i>
                            </a> &nbsp;
                            <a href="#" onclick="event.preventDefault();
                                    if(confirm('Are you sure you want to PERMANENTLY delete this Contract')){
                                    document.getElementById('delete-contract-form-{{ $loop->iteration }}').submit();
                                    }" class="on-default remove-row text-danger" data-toggle="tooltip"
                               data-placement="top"
                               title="Delete contract">
                                <i class="fa fa-trash-o"></i>
                            </a>
                            <form id="delete-contract-form-{{ $loop->iteration }}"
                                  action="{{ route('client.contract.destroy', ['client' => $contract->client['slug'], 'contract' => $contract->slug]) }}"
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
    <!-- Vendor -->
    <script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/vendor/magnific-popup/magnific-popup.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>

    <!-- Specific Page Vendor -->
    <script src="{{ asset('assets/vendor/select2/select2.js') }}"></script>

    <!-- Theme Base, Components and Settings -->
    <script src="{{ asset('assets/javascripts/theme.js') }}"></script>

    <!-- Theme Custom -->
    <script src="{{ asset('assets/javascripts/theme.custom.js') }}"></script>

    <!-- Theme Initialization Files -->
    <script src="{{ asset('assets/javascripts/theme.init.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var t = $('#datatable-default').DataTable({
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                "order": [
                    [1, 'asc']
                ],
                "pageLength": 100
            });

            t.on('order.dt search.dt', function () {
                t.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });

    </script>



@endsection
