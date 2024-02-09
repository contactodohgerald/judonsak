{{--@extends('layouts.admin')--}}
@extends("layouts.".\Auth::user()->person->department->slug )
@section('css')
	<!-- Vendor CSS -->
	<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap/css/bootstrap.css')}}" />

	<link rel="stylesheet" href="{{asset('assets/vendor/font-awesome/css/font-awesome.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/vendor/magnific-popup/magnific-popup.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/vendor/bootstrap-datepicker/css/datepicker3.css')}}" />

	<!-- Specific Page Vendor CSS -->
	<link rel="stylesheet" href="{{asset('assets/vendor/select2/select2.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />

	<!-- Theme CSS -->
	<link rel="stylesheet" href="{{asset('assets/stylesheets/theme.css')}}" />

	<!-- Skin CSS -->
	<link rel="stylesheet" href="{{asset('assets/stylesheets/skins/default.css')}}" />

	<!-- Theme Custom CSS -->
	<link rel="stylesheet" href="{{asset('assets/stylesheets/theme-custom.css')}}">

	<!-- Head Libs -->
	<script src="{{asset('assets/vendor/modernizr/modernizr.js')}}"></script>
@endsection
@section('body')
	<!-- start: page -->
		<section class="panel-featured panel-featured-success">
			<header class="panel-heading">
				<div class="panel-actions">
					<!-- <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a> -->
				</div>

				<h1 class="panel-title text-center"><span class="text-primary"> CashBook </span></h1><br>
				@if($cashbooks->count() > 0)
				<div class="row">
					<div class="col-sm-12">
						<div class="panel-body">
							<div class="table table-responsive">
								<h4 style="text-align: center; font-weight: 2px; font-style: italic;">Summary</h4>
								<table class="table table-bordered table-striped mb-none">
									<thead>
										<tr>
											<th width="20%"></th>
											<th width="40%">NGN</th>
											<th width="40%">USD</th>
										</tr>
									</thead>
									<tbody>
											<tr>
												<td>
													{{'Corporate'}}
												</td>
												<td>
													{{number_format($corporateNGN, 2)}}
												</td>
												<td>
													{{number_format($corporateUSD,2)}}
												</td>
											</tr>
											<tr>
												<td>
													{{'Client'}}
												</td>
												<td>
													{{number_format($clientNGN,2)}}
												</td>
												<td>
													{{number_format($clientUSD,2)}}
												</td>
											</tr>
											<tr>
												<td>
													<strong>{{'Balance'}}</strong>
												</td>
												<td>
													<strong>{{number_format(($corporateNGN + $clientNGN),2)}}</strong>
												</td>
												<td>
													<strong>{{number_format(($corporateUSD + $clientUSD),2)}}</strong>
												</td>
											</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					{{--<div class="col-sm-6">
						<div class="panel-body">
							<div class="table table-responsive">
								<h4 style="text-align: center; font-weight: 2px; font-style: italic;">{{date('M Y', strtotime('-1 months')).' Summary'}}</h4>
								<table class="table table-bordered table-striped mb-none">
									<thead>
										<tr>
											<th width="20%"></th>
											<th width="40%">NGN</th>
											<th width="40%">USD</th>
										</tr>
									</thead>		
									<tbody>
											<tr>
												<td>
													{{'Corporate'}}
												</td>
												<td>
													{{number_format($lastCorporateNGN, 2)}}
												</td>
												<td>
													{{number_format($lastCorporateUSD,2)}}
												</td>
											</tr>
											<tr>
												<td>
													{{'Client'}}
												</td>
												<td>
													{{number_format($lastClientNGN,2)}}
												</td>
												<td>
													{{number_format($lastClientUSD,2)}}
												</td>
											</tr>
											<tr>
												<td>
													<strong>{{'Balance'}}</strong>
												</td>
												<td>
													<strong>{{number_format(($lastCorporateNGN + $lastClientNGN),2)}}</strong>
												</td>
												<td>
													<strong>{{number_format(($lastCorporateUSD + $lastClientUSD),2)}}</strong>
												</td>
											</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>--}}
				</div>
				@endif
			</header>
		</section>
		<br>
{{--debit--}}
	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
				{{-- <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a> --}}
			</div>

			<h2 class="panel-title">{{'Debits For '. date('M Y')}}</h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered table-striped mb-none" id="datatable-default">
				<thead>
					<tr>
						<th width="3%" rowspan="2">S/N</th>
						<th width="10%" rowspan="2">Bank</th>
						<th width="15%" rowspan="2">Client</th>
						<th width="17%" rowspan="2">Description</th>
						<th width="20%" colspan="2">Corporate Account</th>
						<th width="20%" colspan="2">Client Account</th>
						<th width="15%" rowspan="2">Date</th>
					</tr>
					<tr>
						<td width="50">NGN</td>
						<td width="50">USD</td>
						<td width="50">NGN</td>
						<td width="50">USD</td>
					</tr>
				</thead>		
				<tbody>
					@foreach($debits as $debit)
					<tr>
						<td>
							{{$loop->iteration}}
						</td>

					<td>
						<a href="{{route('bank.create')}}">
							{{$debit->bank['name']}}
						</a>
					</td>
					<td>
						<a 
							href="
								{{route('client.show',[
									'client'=>$debit->client['slug']
								])}}">
							{{$debit->client['name'] ?? 'Others'}}
						</a>
					</td>
					<td>
						{{$debit->description}}
					</td>
					{{--NGN Corporate--}}
					<td style="text-align:right">
						{{($debit->currency_id == 1 && $debit->category_id == 1) ? number_format($debit->amount, 2) : '' }}
					</td>
					{{--USD Corporate--}}
					<td style="text-align:right">
						{{($debit->currency_id == 2 && $debit->category_id == 1) ? number_format($debit->amount, 2) : '' }}
					</td>
					{{--NGN Client--}}
					<td style="text-align:right">
						{{($debit->currency_id == 1 && $debit->category_id == 2) ? number_format($debit->amount, 2) : ''}}
					</td>
					{{--USD Client--}}
					<td style="text-align:right">
						{{($debit->currency_id == 2 && $debit->category_id == 2) ? number_format($debit->amount, 2) : ''}}
					</td>
					<td>
						{{$debit->date}}
					</td>
				</tr>
				@endforeach
			</tbody>
	        <tfoot>
	            <tr>
	                <th colspan="4" style="text-align:right">Total:</th>
	                <th style="text-align:right"></th>
	                <th style="text-align:right"></th>
	                <th style="text-align:right"></th>
	                <th style="text-align:right"></th>
	                <th style="text-align:right"></th>
	            </tr>
	        </tfoot>			
		</table>
	</div>
</section>
{{--credit--}}
	<section class="panel">
		<header class="panel-heading">
			<div class="panel-actions">
				<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
				{{-- <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a> --}}
			</div>

			<h2 class="panel-title">{{'Credits For '. date('M Y')}}</h2>
		</header>
		<div class="panel-body">
			<table class="table table-bordered table-striped mb-none" id="datatable-credit">
				<thead>
					<tr>
						<th width="3%" rowspan="2">S/N</th>
						<th width="10%" rowspan="2">Bank</th>
						<th width="15%" rowspan="2">Beneficiary</th>
						<th width="17%" rowspan="2">Description</th>
						<th width="20%" colspan="2">Corporate Account</th>
						<th width="20%" colspan="2">Client Account</th>
						<th width="15%" rowspan="2">Date</th>
					</tr>
					<tr>
						<td width="50">NGN</td>
						<td width="50">USD</td>
						<td width="50">NGN</td>
						<td width="50">USD</td>
					</tr>
				</thead>		
				<tbody>
					@foreach($credits as $credit)
					<tr>
						<td>
							{{$loop->iteration}}
						</td>

					<td>
						<a href="{{route('bank.create')}}">
							{{$credit->bank['name']}}
						</a>
					</td>
					<td>
						<a 
							href="
								{{route('client.show',[
									'client'=>$credit->client['slug']
								])}}">
							{{$credit->client['name'] ?? 'Others'}}
						</a>
					</td>
					<td>
						{{$credit->description}}
					</td>
					{{--NGN Corporate--}}
					<td style="text-align:right">
						{{($credit->currency_id == 1 && $credit->category_id == 1) ? number_format($credit->amount, 2) : "" }}
					</td>
					{{--USD Corporate--}}
					<td style="text-align:right">
						{{($credit->currency_id == 2 && $credit->category_id == 1) ? number_format($credit->amount, 2) : ""}}
					</td>
					{{--NGN Client--}}
					<td style="text-align:right">
						{{($credit->currency_id == 1 && $credit->category_id == 2) ? number_format($credit->amount, 2) : "" }}
					</td>
					{{--USD Client--}}
					<td style="text-align:right">
						{{($credit->currency_id == 2 && $credit->category_id == 2) ? number_format($credit->amount, 2) : "" }}
					</td>
					<td>
						{{$credit->date}}
					</td>
				</tr>
				@endforeach
			</tbody>
	        <tfoot>
	            <tr>
	                <th colspan="4" style="text-align:right">Total:</th>
	                <th style="text-align:right"></th>
	                <th style="text-align:right"></th>
	                <th style="text-align:right"></th>
	                <th style="text-align:right"></th>
	                <th style="text-align:right"></th>
	            </tr>
	        </tfoot>
		</table>
	</div>
</section>

@endsection

@section('js')

<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">

	$(document).ready(function() {
	    var t = $('#datatable-default').DataTable( {
	        "footerCallback": function ( row, data, start, end, display ) {
	            var api = this.api(), data;
	 
	            // Remove the formatting to get integer data for summation
	            var intVal = function ( i ) {
	                return typeof i === 'string' ?
	                    i.replace(/[\,]/g, '')*1 :
	                    typeof i === 'number' ?
	                        i : 0;
	            };
	 
	            // Total over all pages
	            total = api
	                .column( 4 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );

	            totalUSDCorperate = api
	                .column( 5 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 

	            pageTotalNGNClient = api
	                .column( 6 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 

	            pageTotalUSDClient = api
	                .column( 7 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	 
	            // Total over this page
	            pageTotal = api
	                .column( 4, { page: 'current'} )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	            // Total over this page
	            pageTotalUSDCorperate = api
	                .column( 5, { page: 'current'} )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	            // Total over this page
	            pageTotalNGNClient = api
	                .column( 6, { page: 'current'} )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	            // Total over this page
	            pageTotalUSDClient = api
	                .column( 7, { page: 'current'} )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );

	            // Update footer
	            $( api.column( 4 ).footer() ).html(
	                pageTotal.toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2})
	            );

	            $( api.column( 5 ).footer() ).html(
	                pageTotalUSDCorperate.toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2})
	            );

	            $( api.column( 6 ).footer() ).html(
	                pageTotalNGNClient.toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2})
	            );

	            $( api.column( 7 ).footer() ).html(
	                pageTotalUSDClient.toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2})
	            );
	        },
	        "columnDefs": [ {
	            "searchable": false,
	            "orderable": false,
	            "targets": 0
	        } ],
	        "order": [[ 8, 'asc' ]],
		    "pageLength":100,
	    } );
	 
	    t.on( 'order.dt search.dt', function () {
	        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
	            cell.innerHTML = i+1;
	        } );
	    } ).draw();
	    var creditTable = $('#datatable-credit').DataTable( {
	        "footerCallback": function ( row, data, start, end, display ) {
	            var api = this.api(), data;
	 
	            // Remove the formatting to get integer data for summation
	            var intVal = function ( i ) {
	                return typeof i === 'string' ?
	                    i.replace(/[\,]/g, '')*1 :
	                    typeof i === 'number' ?
	                        i : 0;
	            };
	 
	            // Total over all pages
	            total = api
	                .column( 4 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );

	            totalUSDCorperate = api
	                .column( 5 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 

	            pageTotalNGNClient = api
	                .column( 6 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 

	            pageTotalUSDClient = api
	                .column( 7 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	 
	            // Total over this page
	            pageTotal = api
	                .column( 4, { page: 'current'} )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	            // Total over this page
	            pageTotalUSDCorperate = api
	                .column( 5, { page: 'current'} )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	            // Total over this page
	            pageTotalNGNClient = api
	                .column( 6, { page: 'current'} )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	            // Total over this page
	            pageTotalUSDClient = api
	                .column( 7, { page: 'current'} )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );

	            // Update footer
	            $( api.column( 4 ).footer() ).html(
	                pageTotal.toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2})
	            );

	            $( api.column( 5 ).footer() ).html(
	                pageTotalUSDCorperate.toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2})
	            );

	            $( api.column( 6 ).footer() ).html(
	                pageTotalNGNClient.toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2})
	            );

	            $( api.column( 7 ).footer() ).html(
	                pageTotalUSDClient.toLocaleString('us', {minimumFractionDigits: 2, maximumFractionDigits: 2})
	            );
	        },	        
	        "columnDefs": [ {
	            "searchable": false,
	            "orderable": false,
	            "targets": 0
	        } ],
	        "order": [[ 1, 'asc' ]],
		    "pageLength":100
	    } );
	 
	    creditTable.on( 'order.dt search.dt', function () {
	        creditTable.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
	            cell.innerHTML = i+1;
	        } );
	    } ).draw();

	    $('#example').DataTable( {
	        "footerCallback": function ( row, data, start, end, display ) {
	            var api = this.api(), data;
	 
	            // Remove the formatting to get integer data for summation
	            var intVal = function ( i ) {
	                return typeof i === 'string' ?
	                    i.replace(/[\$,]/g, '')*1 :
	                    typeof i === 'number' ?
	                        i : 0;
	            };
	 
	            // Total over all pages
	            total = api
	                .column( 4 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	            // Total over this page
	            pageTotal = api
	                .column( 4, { page: 'current'} )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	            // Update footer
	            $( api.column( 4 ).footer() ).html(
	                '$'+pageTotal +' ( $'+ total +' total)'
	            );
	        }
	    } );
	} );

	$(document).on("click", "#clickTaskModal", function () {
	     var taskTitle = $(this).attr('data-taskTitle');
	     var taskSlug = $(this).attr('data-id');
	     $("#myModalTaskTitle").html( taskTitle );
	     $(".modal-body #inputTask").val(taskSlug);
	     $('#myTaskModal').modal('show');
	});

	$('#cashbook-status-form').submit(function(e){
		e.preventDefault();
		values = {
			"_token": "{{ csrf_token() }}",
			'status': $('#inputDefault').val(),
			'cashbook': $('#inputcashbook').val()
		};
		$.ajax({
			url: "/cashbook/manager/update/api",
			type: "put",
			data: values ,
			success: function (response) {
				if (response.status == 'success') {
					if (response.message == 'Completed') {
						return location.reload();
					}
					$('#cashbook-status-name-'+response.id).html(response.message)
					$('#myModal').modal('toggle');
		             toastr["success"]("Status Updated Successfully", "Success");
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
	             toastr["error"]("Error Updating Status", "Error");
				console.log(textStatus, errorThrown);
			}


		});				
	})
</script>


@endsection
