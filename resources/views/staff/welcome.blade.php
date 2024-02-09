@extends('layouts.admin')

@section('body')
    <!-- start: page -->
    <div class="row sec-body">
        <div class="col-md-4">
            <section class="panel panel-featured-left panel-featured-primary">
                <div class="panel-body">
                    <div class="widget-summary">
                        <div class="widget-summary-col widget-summary-col-icon">
                            <div class="summary-icon bg-primary">
                                <i class="fa fa-life-ring"></i>
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
                                <a class="text-muted text-uppercase">(view all)</a>
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
                                <i class="fa fa-usd"></i>
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
                                <a class="text-muted text-uppercase">(withdraw)</a>
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
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Task</h4>
                                <div class="info">
                                    <strong class="amount">{{ $task }}</strong>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a class="text-muted text-uppercase">(statement)</a>
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
                                <i class="fa fa-usd"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Documents</h4>
                                <div class="info">
                                    <strong class="amount">$ 14,890.30</strong>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a class="text-muted text-uppercase">(withdraw)</a>
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
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Revenues</h4>
                                <div class="info">
                                    <strong class="amount">3765</strong>
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
                                <i class="fa fa-usd"></i>
                            </div>
                        </div>
                        <div class="widget-summary-col">
                            <div class="summary">
                                <h4 class="title">Client Account</h4>
                                <div class="info">
                                    <strong class="amount">$ 14,890.30</strong>
                                </div>
                            </div>
                            <div class="summary-footer">
                                <a class="text-muted text-uppercase">(withdraw)</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-lg-6">
            <section class="panel panel-transparent">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                    </div>

                    <h2 class="panel-title">Latest Tasks</h2>
                </header>
                <div class="panel-body">
                    <section class="panel panel-group">
                        <header class="panel-heading bg-primary">

                            <div class="widget-profile-info">
                                <div class="profile-picture">
                                    <img src="{{ asset('assets/images/!logged-user.jpg') }}">
                                </div>
                                <div class="profile-info">
                                    <h4 class="name text-weight-semibold">John Doe</h4>
                                    <h5 class="role">Administrator</h5>
                                    <div class="profile-footer">
                                        <a href="#">(edit profile)</a>
                                    </div>
                                </div>
                            </div>

                        </header>
                        <div id="accordion">
                            <div class="panel panel-accordion panel-accordion-first">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                            href="#collapse1One">
                                            <i class="fa fa-check"></i> Tasks
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse1One" class="accordion-body collapse in">
                                    <div class="panel-body">
                                        <ul class="widget-todo-list">
                                            <li>
                                                <div class="checkbox-custom checkbox-default">
                                                    <input type="checkbox" checked="" id="todoListItem1" class="todo-check">
                                                    <label class="todo-label" for="todoListItem1"><span>Lorem ipsum dolor
                                                            sit amet</span></label>
                                                </div>
                                                <div class="todo-actions">
                                                    <a class="todo-remove" href="#">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox-custom checkbox-default">
                                                    <input type="checkbox" id="todoListItem2" class="todo-check">
                                                    <label class="todo-label" for="todoListItem2"><span>Lorem ipsum dolor
                                                            sit amet</span></label>
                                                </div>
                                                <div class="todo-actions">
                                                    <a class="todo-remove" href="#">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox-custom checkbox-default">
                                                    <input type="checkbox" id="todoListItem3" class="todo-check">
                                                    <label class="todo-label" for="todoListItem3"><span>Lorem ipsum dolor
                                                            sit amet</span></label>
                                                </div>
                                                <div class="todo-actions">
                                                    <a class="todo-remove" href="#">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox-custom checkbox-default">
                                                    <input type="checkbox" id="todoListItem4" class="todo-check">
                                                    <label class="todo-label" for="todoListItem4"><span>Lorem ipsum dolor
                                                            sit amet</span></label>
                                                </div>
                                                <div class="todo-actions">
                                                    <a class="todo-remove" href="#">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox-custom checkbox-default">
                                                    <input type="checkbox" id="todoListItem5" class="todo-check">
                                                    <label class="todo-label" for="todoListItem5"><span>Lorem ipsum dolor
                                                            sit amet</span></label>
                                                </div>
                                                <div class="todo-actions">
                                                    <a class="todo-remove" href="#">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="checkbox-custom checkbox-default">
                                                    <input type="checkbox" id="todoListItem6" class="todo-check">
                                                    <label class="todo-label" for="todoListItem6"><span>Lorem ipsum dolor
                                                            sit amet</span></label>
                                                </div>
                                                <div class="todo-actions">
                                                    <a class="todo-remove" href="#">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                        <hr class="solid mt-sm mb-lg">
                                        <form method="get" class="form-horizontal form-bordered">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <div class="input-group mb-md">
                                                        <input type="text" class="form-control">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-primary"
                                                                tabindex="-1">Add</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
        <div class="col-xl-3 col-lg-6">
            <section class="panel panel-transparent">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                    </div>

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
                            <div class="h4 text-weight-bold mb-none">100</div>
                            <p class="text-xs text-muted mb-none">Total Task</p>
                        </div>
                    </section>
                    <section class="panel">
                        <div class="panel-body">
                            <div class="circular-bar circular-bar-xs m-none mt-xs mr-md pull-right">
                                <div class="circular-bar-chart" data-percent="80"
                                    data-plugin-options='{ "barColor": "#2baab1", "delay": 300, "size": 50, "lineWidth": 4 }'>
                                    <strong>Average</strong>
                                    <label><span class="percent">80</span>%</label>
                                </div>
                            </div>
                            <div class="h4 text-weight-bold mb-none">80</div>
                            <p class="text-xs text-muted mb-none">Completed Task</p>
                        </div>
                    </section>
                    <section class="panel">
                        <div class="panel-body">
                            <div class="circular-bar circular-bar-xs m-none mt-xs mr-md pull-right">
                                <div class="circular-bar-chart" data-percent="20"
                                    data-plugin-options='{ "barColor": "#2baab1", "delay": 300, "size": 50, "lineWidth": 4 }'>
                                    <strong>Average</strong>
                                    <label><span class="percent">20</span>%</label>
                                </div>
                            </div>
                            <div class="h4 text-weight-bold mb-none">20</div>
                            <p class="text-xs text-muted mb-none">Pending Tasks</p>
                        </div>
                    </section>
                </div>
            </section>
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        {{-- <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a> --}}
                    </div>

                    <h2 class="panel-title">
                        <span class="label label-primary label-sm text-weight-normal va-middle mr-sm">198</span>
                        <span class="va-middle">Staffs</span>
                    </h2>
                </header>
                <div class="panel-body">
                    <div class="content">
                        <ul class="simple-user-list">
                            <li>
                                <figure class="image rounded">
                                    <img src="{{ asset('assets/images/!sample-user.jpg') }}" alt="Joseph Doe Junior"
                                        class="img-circle">
                                </figure>
                                <span class="title">Joseph Doe Junior</span>
                                <span class="message truncate">Lorem ipsum dolor sit.</span>
                            </li>
                            <li>
                                <figure class="image rounded">
                                    <img src="{{ asset('assets/images/!sample-user.jpg') }}" alt="Joseph Junior"
                                        class="img-circle">
                                </figure>
                                <span class="title">Joseph Junior</span>
                                <span class="message truncate">Lorem ipsum dolor sit.</span>
                            </li>
                            <li>
                                <figure class="image rounded">
                                    <img src="{{ asset('assets/images/!sample-user.jpg') }}" alt="Joe Junior"
                                        class="img-circle">
                                </figure>
                                <span class="title">Joe Junior</span>
                                <span class="message truncate">Lorem ipsum dolor sit.</span>
                            </li>
                        </ul>
                        <hr class="dotted short">
                        <div class="text-right">
                            <a class="text-uppercase text-muted" href="#">(View All)</a>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="input-group input-search">
                        <input type="text" class="form-control" name="q" id="q" placeholder="Search...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-xl-3 col-lg-6">
            <section class="panel">
                <header class="panel-heading panel-heading-transparent">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                    </div>

                    <h2 class="panel-title">Special Days</h2>
                </header>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-none">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td><span class="label label-warning">23-8-2018</span></td>
                                    <td>
                                        <a class="label label-success">Email</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane Doe</td>
                                    <td><span class="label label-warning">23-8-2018</span></td>
                                    <td>
                                        <a class="label label-success">Email</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Serah Doe</td>
                                    <td><span class="label label-warning">23-8-2018</span></td>
                                    <td>
                                        <a class="label label-success">Email</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>David Doe</td>
                                    <td><span class="label label-warning">23-8-2018</span></td>
                                    <td>
                                        <a class="label label-success">Email</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Pablo Doe</td>
                                    <td><span class="label label-warning">23-8-2018</span></td>
                                    <td>
                                        <a class="label label-success">Email</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>John Doe</td>
                                    <td><span class="label label-warning">23-8-2018</span></td>
                                    <td>
                                        <a class="label label-success">Email</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Jane Doe</td>
                                    <td><span class="label label-warning">23-8-2018</span></td>
                                    <td>
                                        <a class="label label-success">Email</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-xl-3 col-lg-6">
            <section class="panel">
                <header class="panel-heading panel-heading-transparent">
                    <div class="panel-actions">
                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                    </div>

                    <h2 class="panel-title">Projects Stats</h2>
                </header>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-none">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Project</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Porto - Responsive HTML5 Template</td>
                                    <td><span class="label label-success">Success</span></td>
                                    <td>
                                        <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                            <div class="progress-bar progress-bar-primary" role="progressbar"
                                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 100%;">
                                                100%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Porto - Responsive Drupal 7 Theme</td>
                                    <td><span class="label label-success">Success</span></td>
                                    <td>
                                        <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                            <div class="progress-bar progress-bar-primary" role="progressbar"
                                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 100%;">
                                                100%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Tucson - Responsive HTML5 Template</td>
                                    <td><span class="label label-warning">Warning</span></td>
                                    <td>
                                        <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                            <div class="progress-bar progress-bar-primary" role="progressbar"
                                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 60%;">
                                                60%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Tucson - Responsive Business WordPress Theme</td>
                                    <td><span class="label label-success">Success</span></td>
                                    <td>
                                        <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                            <div class="progress-bar progress-bar-primary" role="progressbar"
                                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 90%;">
                                                90%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Porto - Responsive Admin HTML5 Template</td>
                                    <td><span class="label label-warning">Warning</span></td>
                                    <td>
                                        <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                            <div class="progress-bar progress-bar-primary" role="progressbar"
                                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 45%;">
                                                45%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Porto - Responsive HTML5 Template</td>
                                    <td><span class="label label-danger">Danger</span></td>
                                    <td>
                                        <div class="progress progress-sm progress-half-rounded m-none mt-xs light">
                                            <div class="progress-bar progress-bar-primary" role="progressbar"
                                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 40%;">
                                                40%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Porto - Responsive Drupal 7 Theme</td>
                                    <td><span class="label label-success">Success</span></td>
                                    <td>
                                        <div class="progress progress-sm progress-half-rounded mt-xs light">
                                            <div class="progress-bar progress-bar-primary" role="progressbar"
                                                aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                style="width: 95%;">
                                                95%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

    </div>
    <!-- end: page -->

@endsection
