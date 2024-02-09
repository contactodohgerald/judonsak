@extends('layouts.bizdev')

@section('body')
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
                                    <strong class="amount">{{ $client }}</strong>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a class="text-muted text-uppercase" href="{{ route('client.index') }}">(view all)</a>
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
                                    <strong class="amount">{{ $instruction }}</strong>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a class="text-muted text-uppercase" href="{{ route('instruction.index') }}">(view
                                    latest)</a>
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
                                    <strong class="amount">{{ $all_task }}</strong>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a class="text-muted text-uppercase" href="{{ route('task.index') }} ">(view latest)</a>
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
                                <i class="fa fa-folder-o"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Desks</h4>
                                <div class="info">
                                    <strong class="amount">{{ $service }}</strong>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a class="text-muted text-uppercase">(services)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="panel panel-featured-left panel-featured-quartenary">
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-quartenary">
                                <i class="fa fa-usd"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Revenues</h4>
                                <div class="info">
                                    <strong class="amount">{{ '0' }}</strong>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a class="text-muted text-uppercase">(report)</a>
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
                                <i class="fa fa-money"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Client Account</h4>
                                <div class="info">
                                    <strong class="amount">{{ '0' }}</strong>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a class="text-muted text-uppercase">(summary)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-5 col-lg-5">
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                    </div>

                    <h2 class="panel-title">
                        <span
                            {{-- class="label label-primary label-sm text-weight-normal va-middle mr-sm">{{ $people->count() }}</span> --}}
                        <span class="va-middle">Staffs</span>
                    </h2>
                </header>
                <div class="panel-body">
                    <div class="content">
                        <ul class="simple-user-list">
                            @foreach ($people as $person)
                                <li>
                                    <figure class="image rounded">
                                        <img src="{{ asset('assets/images/!sample-user.jpg') }}" alt="Joseph Doe Junior"
                                            class="img-circle">
                                    </figure>
                                    <span class="title">
                                        <a href="{{ route('profile.show', ['profile' => $person->slug]) }}">
                                            {{ $person->first_name . ' ' . $person->last_name }}
                                        </a>
                                    </span>
                                    <span class="message truncate">{{ $person->department->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <hr class="dotted short">
                    </div>
                </div>
                <div class="panel-footer">
                </div>
            </section>
        </div>
        {{-- <div class="col-xl-7 col-lg-7">
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                    </div>

                    <h2 class="panel-title">
                        <span
                            class="label label-primary label-sm text-weight-normal va-middle mr-sm">{{ $people->count() }}</span>
                        <span class="va-middle">Upcoming Special Days</span>
                    </h2>
                </header>
                <div class="panel-body">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="h4 text-weight-bold mb-none">
                                Peter Oni Just made a note on this Task.
                            </div>
                            <p class="text-xs text-muted mb-none">Task Log</p>
                        </div>
                    </section>
                    <section class="panel">
                        <div class="panel-body">
                            <div class="h4 text-weight-bold mb-none">
                                Peter Oni Just made a note on this Task.
                            </div>
                            <p class="text-xs text-muted mb-none">Task Log</p>
                        </div>
                    </section>
                    <section class="panel">
                        <div class="panel-body">
                            <div class="h4 text-weight-bold mb-none">
                                Peter Oni Just made a note on this Task.
                            </div>
                            <p class="text-xs text-muted mb-none">Task Log</p>
                        </div>
                    </section>
                    <section class="panel">
                        <div class="panel-body">
                            <div class="h4 text-weight-bold mb-none">
                                Peter Oni Just made a note on this Task.
                            </div>
                            <p class="text-xs text-muted mb-none">Task Log</p>
                        </div>
                    </section>
                    <section class="panel">
                        <div class="panel-body">
                            <div class="h4 text-weight-bold mb-none">
                                Peter Oni Just made a note on this Task.
                            </div>
                            <p class="text-xs text-muted mb-none">Task Log</p>
                        </div>
                    </section>
                    <section class="panel">
                        <div class="panel-body">
                            <div class="h4 text-weight-bold mb-none">
                                Peter Oni Just made a note on this Task.
                            </div>
                            <p class="text-xs text-muted mb-none">Task Log</p>
                        </div>
                    </section>
                    <section class="panel">
                        <div class="panel-body">
                            <div class="h4 text-weight-bold mb-none">
                                Peter Oni Just made a note on this Task.
                            </div>
                            <p class="text-xs text-muted mb-none">Task Log</p>
                        </div>
                    </section>
                </div>
            </section>
        </div> --}}

    </div>
    <!-- end: page -->

@endsection
