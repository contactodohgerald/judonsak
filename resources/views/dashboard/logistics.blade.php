@extends('layouts.professionals')

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
                    <form class="form-horizontal form-bordered" method="post"
                        action="{{ route('checklist.update.status') }}">
                        @csrf()
                        <input type="hidden" name="checklist" id="inputTask" required>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="inputDefault">Status</label>
                            <div class="col-md-6">
                                <select class="form-control" name="status" id="inputDefault" required>
                                    <option selected>Select New Status</option>
                                    @if (Auth::user()->person->id == Auth::user()->person->department->person_id)
                                        <option value="4"> Pending</option>
                                        <option value="5"> Ongoing</option>
                                        <option value="7"> Completed</option>
                                        <option value="6"> Overdue</option>
                                    @endif
                                    <option value="21">KIV</option>
                                    <option value="22">Awaiting Review</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class=" col-md-10 offset-md-1">
                                <button type="submit" class="btn btn-success" style="width: 45%">Update</button>
                                <button type="button" class="btn btn-default" style="width: 45%" data-dismiss="modal">Close
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal -->

    {{-- Olamide added this session --}}
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <!-- start: page -->
    <div class="row sec-body">
        <div class="col-md-4 col-lg-6">
            <section class="panel panel-featured-left panel-featured-primary">

                {{-- Projects --}}
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-primary">
                                <i class="fa fa-life-ring"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Projects</h4>
                                <div class="info">
                                    <strong class="amount">{{ $projectCount }}</strong>
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
                            <div class="h4 text-weight-bold mb-none">{{ $total_checklist }}</div>
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
                            <div class="h4 text-weight-bold mb-none">{{ $completed_checklist }}</div>
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
                            <div class="h4 text-weight-bold mb-none">{{ $ongoing_checklist }}</div>
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
                            <div class="h4 text-weight-bold mb-none">{{ $pending_checklist }}</div>
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
            var checklistTitle = $(this).attr('data-checklistTitle');
            var checklistSlug = $(this).attr('data-id');
            $("#myModalTaskTitle").html(checklistTitle);
            $(".modal-body #inputTask").val(checklistSlug);
            $('#myModal').modal('show');
        });

    </script>
@endsection
