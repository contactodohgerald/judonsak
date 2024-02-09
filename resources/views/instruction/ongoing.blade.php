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

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" style="margin: 120px auto;" role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-bordered" id="instruction-status-form" method="post"
                        action="{{ route('instruction.update.status') }}">
                        @csrf()
                        <input type="hidden" name="instruction" id="inputTask" required>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">New Status</label>
                            <div class="col-md-6">
                                <select class="form-control" name="status" id="inputDefault" required>
                                    <option selected> Select New Status</option>
                                    <option value="4"> Pending</option>
                                    <option value="5"> Ongoing</option>
                                    <option value="7"> Completed</option>
                                    <option value="6"> Overdue</option>
                                    <option value="21"> KIV</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class=" col-md-10 offset-md-1">
                                <button type="submit" class="btn btn-success" style="width: 45%">Update</button>
                                <button type="button" class="btn btn-default" style="width: 45%"
                                    data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Modal -->
    <div class="modal fade" id="myTaskModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" style="margin: 120px auto; role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="/admin/modal/save/task" method="POST" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="instruction" id="inputInstruction">
                        <section class="panel">
                            <header class="panel-heading">
                                <h2 class="panel-title">{{ 'Create Task' }}</h2>
                            </header>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Task <span class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-book"></i>
                                            </span>
                                            <input type="text" name="task" class="form-control"
                                                placeholder="eg.: Pay Client Tax" value="" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"> Assign
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-user"></i>
                                            </span>
                                            <select id="people" name="people[]" class="form-control populate" value=""
                                                multiple data-plugin-selectTwo required>
                                                <option disabled selected> Assign to Professional</option>
                                                @foreach ($people as $person)
                                                    <option value="{{ $person->id }}">
                                                        {{ $person->first_name }} {{ $person->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Description <span
                                            class="required">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-suitcase"></i>
                                            </span>
                                            <textarea name="description" rows="5" class="form-control"
                                                placeholder="Add more Description to Task" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Deadline
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                            <input type="text" data-plugin-datepicker name="deadline" class="form-control"
                                                placeholder="Deadline" value="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <footer class="panel-footer">
                                <div class="row">
                                    <div class="col-sm-8 col-sm-offset-2">
                                        <button class="btn btn-success btn-block">Submit</button>
                                    </div>
                                </div>
                            </footer>
                        </section>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- start: page -->
    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                {{-- <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a> --}}
            </div>

            <h2 class="panel-title">Ongoing Instructions</h2>
        </header>
        <div class="panel-body">
            <table class="table table-bordered table-striped mb-none" id="datatable-default">
                <thead>
                    <tr>
                        <th width="5%">S/N</th>
                        <th width="15%">Client</th>
                        <th width="25%">Instruction</th>
                        <th width="15%">Managers</th>
                        <th width="10%">Tasks</th>
                        <th width="14%">Status</th>
                        <th width="16%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($instructions as $instruction)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <a
                                    href="
                                                            {{ route('client.show', [
    'client' => $instruction->contract->client->slug,
]) }}">
                                    {{ $instruction->contract->client->name }}
                                </a>
                            </td>

                            {{-- @if ($loop->iteration > 1)
					@php
						$temp = $instruction->contract->client->count();
						$tempClient = $instruction->contract->client;
					@endphp
						
						@if ($instruction->contract->client->name != $instructions[$loop->iteration - 2]->contract->client->name)
							<td>
								<a href="{{route('client.show',['client'=>$instruction->contract->client->slug])}}">
									{{$instruction->contract->client->name. $instruction->contract->client->id}}
									@php
										$temp = $instruction->contract->client;
									@endphp
								</a>
							</td>							
						@else
						<td>
							{{ $tempClient->instructions()->where('instructions.id','=',$instruction->id)->count() }}
							{{ $tempClient->name }}
							and temp
							{{($temp != null) ? $temp: 0}}
							
						</td>
						@endif
					@else
					<td>
						<a 
							href="
								{{route('client.show',[
									'client'=>$instruction->contract->client->slug
								])}}">
							{{$instruction->contract->client->name. $instruction->contract->client->id}}
						</a>

					</td>							
					@endif --}}

                            <td>
                                <a href="{{ route('instruction.task.index', ['instruction' => $instruction->slug]) }}">
                                    {{ $instruction->name }}
                                </a>
                            </td>
                            <td>
                                <table>
                                    <tbody>
                                        @foreach ($instruction->people as $person)
                                            <tr>
                                                <td>
                                                    @if ($loop->last)
                                                        <a
                                                            href="{{ route('profile.show', ['profile' => $person->slug]) }}">
                                                            {{ $person->first_name }} {{ $person->last_name }}
                                                        </a>
                                                    @else
                                                        <a
                                                            href="{{ route('profile.show', ['profile' => $person->slug]) }}">
                                                            {{ $person->first_name }} {{ $person->last_name }},
                                                        </a>

                                                    @endif
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
                            <td id="instruction-status-name-{{ $instruction->id }}">{{ $instruction->status->name }}
                            </td>
                            <td>

                                <a style="cursor: pointer;" id="clickModal" class="on-default view-row text-info"
                                    data-target="#myModal" data-id="{{ $instruction->slug }}"
                                    data-taskTitle="{{ $instruction->name }}" data-toggle="tooltip" data-placement="top"
                                    title="Update Instruction Status">
                                    <i class="fa fa-check" data-placement="top" data-toggle="tooltip"></i>
                                </a> &nbsp;

                                <a id="clickTaskModal" class="on-default view-row text-info" data-target="#myTaskModal"
                                    data-id="{{ $instruction->id }}" data-toggle="tooltip" data-placement="top"
                                    title="Add Task">
                                    <i class="fa fa-plus"></i>
                                </a> &nbsp;

                                <a href="{{ route('contract.instruction.edit', [
    'contract' => $instruction->contract->slug,
    'instruction' => $instruction->slug,
]) }}"
                                    class="on-default edit-row text-success" data-toggle="tooltip" data-placement="top"
                                    title="Edit Instruction">
                                    <i class="fa fa-pencil"></i>
                                </a> &nbsp;

                                <a href="#" onclick="event.preventDefault();
                                                           if(confirm('Are you sure you want to PERMANENTLY delete this Instruction')){
                                                                                     document.getElementById('delete-instruction-form-{{ $loop->iteration }}').submit();
                                                           }" class="on-default 
                                                           remove-row text-danger" data-toggle="tooltip"
                                    data-placement="top" title="Delete instruction">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                                <form id="delete-instruction-form-{{ $loop->iteration }}"
                                    action="{{ route('contract.instruction.destroy', [
    'contract' => $instruction->contract->slug,
    'instruction' => $instruction->slug,
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
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
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

            t.on('order.dt search.dt', function() {
                t.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });

    </script>


    <script type="text/javascript">
        $(document).on("click", "#clickModal", function() {
            var instructionSlug = $(this).attr('data-id');
            $(".modal-body #inputInstruction").val(instructionSlug);
            $('#myModal').modal('show');
        });

        $(document).on("click", "#clickTaskModal", function() {
            var taskSlug = $(this).attr('data-id');
            $(".modal-body #inputInstruction").val(taskSlug);
            $('#myTaskModal').modal('show');
        });

        $('#instruction-status-form').submit(function(e) {
            e.preventDefault();
            values = {
                "_token": "{{ csrf_token() }}",
                'status': $('#inputDefault').val(),
                'instruction': $('#inputInstruction').val()
            };
            $.ajax({
                url: "/instruction/manager/update/api",
                type: "put",
                data: values,
                success: function(response) {
                    if (response.status == 'success') {
                        if (response.message == 'Completed') {
                            return location.reload();
                        }
                        $('#instruction-status-name-' + response.id).html(response.message)
                        $('#myModal').modal('toggle');
                        toastr["success"]("Status Updated Successfully", "Success");
                    }
                    console.log(response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr["error"]("Error Updating Status", "Error");
                    console.log(textStatus, errorThrown);
                }


            });
        })

    </script>


@endsection
