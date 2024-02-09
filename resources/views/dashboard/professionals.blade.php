@extends('layouts.professionals')

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
                                    @if (\Auth::user()->person->id == \Auth::user()->person->department->person_id)
                                        <option value="4"> Pending</option>
                                        <option value="5"> Ongoing</option>
                                        <option value="7"> Completed</option>
                                        <option value="6"> Overdue</option>
                                    @endif
                                    <option value="21"> KIV</option>
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
    <!-- end of modal -->

    <!-- start: page -->
    <div class="row sec-body">
        <div class="col-md-4">
            <section class="panel panel-featured-left panel-featured-primary">
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-primary">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title"> Clients</h4>
                                <div class="info">
                                    <strong class="amount">{{ $clientCount }}</strong>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a class="text-muted text-uppercase">(total)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="panel panel-featured-left panel-featured-secondary">
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-secondary">
                                <i class="fa fa-edit"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Instructions</h4>
                                <div class="info">
                                    <strong class="amount">{{ $instructionCount }}</strong>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a href="{{ route('instruction.param', ['query' => 'ongoing']) }}"
                                    class="text-muted text-uppercase">
                                    (total)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="panel panel-featured-left panel-featured-tertiary">
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-tertiary">
                                <i class="fa fa-tasks"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Task</h4>
                                <div class="info">
                                    <strong class="amount">{{ $all_task->count() }}</strong>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a href="{{ route('task.index') }}" class="text-muted text-uppercase">(total)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-8">
            <section class="panel panel-transparent">
                <header class="panel-heading">
                    {{-- <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div> --}}

                    <h2 class="panel-title">Latest Tasks</h2>
                </header>
                <div class="panel-body">
                    <section class="panel panel-group">
                        <div id="accordion">
                            <div class="panel panel-accordion panel-accordion-first">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="#" class="accordion-toggle">
                                            <i class="fa fa-eye"></i> Pending/Ongoing/KIV
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse1One" class="accordion-body collapse in">
                                    <div class="panel-body">
                                        <table class="table table-bordered table-striped mb-none" id="datatable-default">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Client</th>
                                                    <th width="30%">Instruction</th>
                                                    <th width="30%">Task</th>
                                                    <th width="15%">Status</th>
                                                    <th width="15%"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($all_task->count() > 0)
                                                    @foreach ($all_task as $task)
                                                        <tr>
                                                            <td>
                                                                <a
                                                                    href="{{ route('client.show', ['client' => $task->instruction->contract->client->slug]) }}">
                                                                    {{ $task->instruction->contract->client->name ?? 'No Name Set' }}
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a
                                                                    href="{{ route('instruction.task.index', ['instruction' => $task->instruction->slug]) }}">
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
                                                                {{ $task->status->name ?? 'No Status Set' }}
                                                            </td>
                                                            <td>
                                                                <a style="cursor: pointer;" id="clickModal"
                                                                    class="on-default view-row text-info"
                                                                    data-toggle="tooltip" data-placement="top" title="
                                                                                                        Change Task Status"
                                                                    data-target="#myModal" data-id="{{ $task->slug }}"
                                                                    data-taskTitle="{{ $task->name }}"
                                                                    title="Update Task Status">
                                                                    <i class="fa fa-check" data-placement="top"
                                                                        data-toggle="tooltip"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5">
                                                            {{ 'No Pending Task' }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-accordion">
                                <div id="collapse1Two" class="accordion-body collapse">
                                    <div class="panel-body">
                                        <ul class="simple-user-list mb-xlg">
                                            <li>
                                                <figure class="image rounded">
                                                    <img src="{{ asset('assets/images/!sample-user.jpg') }}"
                                                        alt="Joseph Doe Junior" class="img-circle">
                                                </figure>
                                                <span class="title">Joseph Doe Junior</span>
                                                <span class="message">Lorem ipsum dolor sit.</span>
                                            </li>
                                            <li>
                                                <figure class="image rounded">
                                                    <img src="{{ asset('assets/images/!sample-user.jpg') }}"
                                                        alt="Joseph Junior" class="img-circle">
                                                </figure>
                                                <span class="title">Joseph Junior</span>
                                                <span class="message">Lorem ipsum dolor sit.</span>
                                            </li>
                                            <li>
                                                <figure class="image rounded">
                                                    <img src="{{ asset('assets/images/!sample-user.jpg') }}"
                                                        alt="Joe Junior" class="img-circle">
                                                </figure>
                                                <span class="title">Joe Junior</span>
                                                <span class="message">Lorem ipsum dolor sit.</span>
                                            </li>
                                            <li>
                                                <figure class="image rounded">
                                                    <img src="{{ asset('assets/images/!sample-user.jpg') }}"
                                                        alt="Joseph Doe Junior" class="img-circle">
                                                </figure>
                                                <span class="title">Joseph Doe Junior</span>
                                                <span class="message">Lorem ipsum dolor sit.</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </section>
        </div>
        <div class="col-xl-4 col-lg-4">
            <section class="panel panel-transparent">
                <header class="panel-heading">
                    {{-- <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div> --}}

                    <h2 class="panel-title">This Month Stats</h2>
                </header>
                <div class="panel-body">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="circular-bar circular-bar-xs m-none mt-xs mr-md pull-right">
                                <div class="circular-bar-chart" data-percent="100"
                                    data-plugin-options='{ "barColor": "#2baab1", "delay": 300, "size": 50, "lineWidth": 4 }'>
                                    <strong>Average</strong>
                                    <label><span class="percent">100</span>%</label>
                                </div>
                            </div>
                            <div class="h4 text-weight-bold mb-none">{{ $total_task }}</div>
                            <p class="text-xs text-muted mb-none">Total Task</p>
                        </div>
                    </section>
                    <section class="panel">
                        <div class="panel-body">
                            <div class="circular-bar circular-bar-xs m-none mt-xs mr-md pull-right">
                                <div class="circular-bar-chart" data-percent="{{ $completed_percent }}"
                                    data-plugin-options='{ "barColor": "#2baab1", "delay": 300, "size": 50, "lineWidth": 4 }'>
                                    <strong>Average</strong>
                                    <label><span class="percent">{{ $completed_percent }}</span>%</label>
                                </div>
                            </div>
                            <div class="h4 text-weight-bold mb-none">{{ $completed_task }}</div>
                            <p class="text-xs text-muted mb-none">Completed Task</p>
                        </div>
                    </section>
                    <section class="panel">
                        <div class="panel-body">
                            <div class="circular-bar circular-bar-xs m-none mt-xs mr-md pull-right">
                                <div class="circular-bar-chart" data-percent="{{ $ongoing_percent }}"
                                    data-plugin-options='{ "barColor": "#2baab1", "delay": 300, "size": 50, "lineWidth": 4 }'>
                                    <strong>Average</strong>
                                    <label><span class="percent">{{ $ongoing_percent }}</span>%</label>
                                </div>
                            </div>
                            <div class="h4 text-weight-bold mb-none">{{ $ongoing_task }}</div>
                            <p class="text-xs text-muted mb-none">Ongoing Tasks</p>
                        </div>
                    </section>
                    <section class="panel">
                        <div class="panel-body">
                            <div class="circular-bar circular-bar-xs m-none mt-xs mr-md pull-right">
                                <div class="circular-bar-chart" data-percent="{{ $pending_percent }}"
                                    data-plugin-options='{ "barColor": "#2baab1", "delay": 300, "size": 50, "lineWidth": 4 }'>
                                    <strong>Average</strong>
                                    <label><span class="percent">{{ $pending_percent }}</span>%</label>
                                </div>
                            </div>
                            <div class="h4 text-weight-bold mb-none">{{ $pending_task }}</div>
                            <p class="text-xs text-muted mb-none">Pending Tasks</p>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </div>
    <!-- end: page -->

@endsection
@section('js')
    <!-- Specific Page Vendor -->
    <script type="text/javascript">
        $(document).on("click", "#clickModal", function() {
            var taskTitle = $(this).attr('data-taskTitle');
            var taskSlug = $(this).attr('data-id');
            $("#myModalTaskTitle").html(taskTitle);
            $(".modal-body #inputTask").val(taskSlug);
            $('#myModal').modal('show');
        });

    </script>
@endsection
