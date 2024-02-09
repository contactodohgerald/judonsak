{{-- @extends('layouts.admin') --}}
@extends("layouts.".\Auth::user()->person->department->slug)
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
        <div class="modal-dialog" style="margin: 120px auto;" role="document">
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
                                    @if (\Auth::user()->person->id == \Auth::user()->person->department->person_id || \Auth::user()->person->level_id > 2)
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
                <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
            </div>

            <h2 class="panel-title">Completed Tasks</h2>
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
                        <th with="15%">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($tasks as $key => $task)
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
                                <a
                                    href="
                                                                                                                                                                                                                            {{ route('instruction.task.index', ['instruction' => $task->instruction->slug]) }}">
                                    {{ $task->instruction->name ?? 'No Instruction Set' }}
                                </a>
                            </td>
                            <td>
                                <a
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

                                @if (Auth::user()->person->level_id > 2)
                                    <!-- Button to Open the Modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#assign_point{{ $key }}">
                                        {{ Auth::user()->person->level_id > 3 ? 'Award Partner Point' : 'Award LM Point' }}
                                    </button>

                                    <!-- The Modal -->
                                    <div class="modal" id="assign_point{{ $key }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">
                                                        {{ Auth::user()->person->level_id > 3 ? 'Award Partner Point' : 'Award Line Manager Point' }}
                                                        to {{ $task->executor->first_name }}
                                                        {{ $task->executor->last_name }}
                                                    </h4>
                                                    {{-- <h4 class="modal-title">Award Partner Point to {{ $task->executor->first_name }}
                                                    {{ $task->executor->last_name }}
                                                </h4> --}}
                                                    <button type="button" class="close"
                                                        data-dismiss="modal">&times;</button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <form
                                                        action="{{ Auth::user()->person->level_id >= 4 ? route('partnerPoint') : route('linemanagerPoint') }}"
                                                        method='POST'>
                                                        @csrf

                                                        {{-- Task Id --}}
                                                        <div class="mb-3">
                                                            <label for="task" class="form-label">Task:
                                                                {{ $task->name }}</label>
                                                            <input type="hidden" class="form-control" name="taskId"
                                                                id="{{ $task->id }}" value="{{ $task->id }}"
                                                                hidden>
                                                        </div>

                                                        @if (Auth::user()->person->level_id > 3)
                                                            {{-- Partner Point --}}
                                                            {{-- Point --}}
                                                            <div class="mb-3">
                                                                <label for="point" class="form-lable"> Partner Point</label>
                                                                <input type="number" class="form-control numinput"
                                                                    name="point" id="" min="-5" max="5">
                                                            </div>

                                                            {{-- Point description --}}
                                                            <div class="mb-3">
                                                                <label for="description" class="form-lable"> Description
                                                                </label>
                                                                <input type="text" class="form-control" name="description"
                                                                    id='description'>
                                                            </div>

                                                            {{-- Task name --}}
                                                            <div class="mb-3">
                                                                <input type="hidden" class="form-control" name="taskName"
                                                                    value="{{ $task->name }}" hidden>
                                                            </div>

                                                            {{-- Task Instruction Name --}}
                                                            <div class="mb-3">
                                                                <input type="hidden" class="form-control"
                                                                    name="instructionName"
                                                                    value="{{ $task->instruction->name }}" hidden>
                                                            </div>

                                                            {{-- executorId --}}
                                                            <div class="mb-3">
                                                                {{-- <label for="point" class="point">Point</label> --}}
                                                                <input type="hidden" class="form-control" name="executorId"
                                                                    value="{{ $task->executor->id }}" hidden>
                                                            </div>

                                                            {{-- departmentId --}}
                                                            <div class="mb-3">
                                                                {{-- <label for="point" class="point">Point</label> --}}
                                                                <input type="hidden" class="form-control"
                                                                    name="departmentId"
                                                                    value="{{ $task->executor->department_id }}" hidden>
                                                            </div>

                                                            <div class="mb-3">
                                                                <button style="margin-top: 5px" type="submit"
                                                                    class="btn btn-primary">Submit</button>
                                                            </div>

                                                        @else {{-- Line Manager Point --}}
                                                            {{-- Point --}}
                                                            <div class="mb-3">
                                                                <label for="point" class="form-lable">Line Manager
                                                                    Point</label>
                                                                <input type="number" class="form-control numinput"
                                                                    name="point" id="point" min="-3" max="3">
                                                            </div>

                                                            {{-- executorId --}}
                                                            <div class="mb-3">
                                                                {{-- <label for="point" class="point">Point</label> --}}
                                                                <input type="hidden" class="form-control" name="executorId"
                                                                    value="{{ $task->executor->id }}">
                                                            </div>

                                                            <div class="mb-3">
                                                                <button style="margin-top: 5px" type="submit"
                                                                    class="btn btn-primary">Submit</button>
                                                            </div>
                                                        @endif
                                                    </form>
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Close</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!--End Of The Modal -->
                                @endif
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
        $('.numinput').on('input', function() {
            this.value = this.value.replace(/(?!^-)[^0-9.]/g, "").replace(/(\..*)\./g, '$1');
        });

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
