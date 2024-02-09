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
        <div class="modal-dialog" style="margin: 120px auto; role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalTaskTitle"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-bordered" method="post" action="{{ route('task.update.status') }}">
                        @csrf()
                        <input type="hidden" name="task" id="inputTask" required>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Status</label>
                            <div class="col-md-6">
                                <select class="form-control" name="status" id="inputDefault" required>
                                    <option selected> Select New Status</option>
                                    @if (Auth::user()->person->id == Auth::user()->person->department->person_id || Auth::user()->person->level_id > 2)
                                        <option value="4"> Pending</option>
                                        <option value="5"> Ongoing</option>
                                        <option value="7"> Completed</option>
                                        <option value="6"> Overdue</option>
                                    @endif
                                    <option value="22"> Awaiting Review</option>
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

    <!-- start: page -->
    <section class="panel">
        <header class="panel-heading">
            <div class="panel-actions">
                <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                {{-- <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a> --}}
            </div>

            <h2 class="panel-title">All Tasks</h2>
        </header>
        <div class="panel-body">
            <table class="table table-bordered table-striped mb-none" id="datatable-default">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="10%">Client</th>
                        <th width="10%">Instruction</th>
                        <th width="10%">Task</th>
                        <th width="10%">Remark</th>
                        <th width="5%">Assigned</th>
                        <th width="15%">Initiated</th>
                        <th width="15%">Deadline</th>
                        <th width="15%">Status</th>
                        <th width="15%"></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>
                            </td>
                            <td>
                                <a
                                    href="{{ route('client.show', ['client' => $task->instruction->contract->client->slug ?? 'No Instruction Set']) }}">
                                    {{ $task->instruction->contract->client->name ?? 'No Name Set' }}
                                </a>
                            </td>
                            <td>
                                <a {{-- href=" {{ route('instruction.task.index', ['instruction' => $task->instruction->slug]) }}"> --}}
                                    href=" {{ route('instruction.task.index', ['instruction' => $task->instruction->slug]) }}">
                                    {{ $task->instruction->name ?? 'No Instruction Set' }}
                                </a>
                            </td>
                            <td>
                                <a {{-- href="{{ route('instruction.task.show', ['instruction' => $task->instruction->slug, 'task' => $task->slug]) }}"> --}}
                                    href="{{ route('instruction.task.show', ['instruction' => $task->instruction->slug, 'task' => $task->slug]) }}">
                                    {{ $task->name ?? 'No Task Name' }}
                                </a>
                            </td>
                            <td>
                                {{ $task->description ?? 'No Task Description' }}
                            </td>
                            <td>
                                <a href="{{ route('profile.show', ['profile' => $task->executor->slug]) }}">
                                    {{ $task->executor->first_name }} {{ $task->executor->last_name }}
                                </a>
                            </td>
                            <td>
                                {{ $task->created_at->format('Y-m-d') }}
                            </td>
                            <td>
                                {{ $task->deadline ?? 'Non-set' }}
                            </td>
                            <td>
                                @if ($task->deadline < date('Y-m-d') && !empty($task->deadline) && $task->status_id != 7)
                                    <span class="label label-danger">
                                        {{ 'Overdue' }}
                                    @else
                                        <span class="label label-primary">
                                            {{ $task->status->name ?? 'No Status Set' }}
                                        </span>
                                @endif
                            </td>
                            <td>
                                <a style="cursor: pointer; font-size: 20px" id="clickModal"
                                    class="on-default view-row text-info" data-target="#myModal"
                                    data-id="{{ $task->slug }}" data-taskTitle="{{ $task->name }}"
                                    data-toggle="tooltip" data-placement="top" title="Update Task Status">
                                    <i class="fa fa-check" data-placement="top" data-toggle="tooltip"></i>
                                </a> &nbsp;
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

        $(document).on("click", "#clickModal", function() {
            var assignedTo = $(this).attr('data-assignedTo');
            var taskTitle = $(this).attr('data-taskTitle');
            var taskSlug = $(this).attr('data-id');
            $("#myModalTaskTitle").html(taskTitle);
            $(".modal-body #inputAssignedTo").val(assignedTo);
            $(".modal-body #inputTask").val(taskSlug);
            $('#myModal').modal('show');
        });

    </script>
@endsection
