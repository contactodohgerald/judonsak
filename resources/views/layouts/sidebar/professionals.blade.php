                <!-- start: sidebar -->
                <aside id="sidebar-left" class="sidebar-left">

                    <div class="sidebar-header">
                        <div class="sidebar-title" style="text-indent: 15px;">
                            Menu
                        </div>
                        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed"
                            data-target="html" data-fire-event="sidebar-left-toggle">
                            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                        </div>
                    </div>

                    <div class="nano">
                        <div class="nano-content">
                            <nav id="menu" class="nav-main" role="navigation">
                                <ul class="nav nav-main">
                                    <li class="nav-active">
                                        <a href="{{ route('dashboard') }}">
                                            <i class="fa fa-home" aria-hidden="true"></i>
                                            <span>Dashboard</span>
                                        </a>
                                    </li>
                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-copy" aria-hidden="true"></i>
                                            <span>Clients</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            @if (Auth::user()->person->level_id > 2)
                                                <li class="nav-parent">
                                                    <a>
                                                        <i class="fa fa-copy" aria-hidden="true"></i>
                                                        <span>Clients</span>
                                                    </a>
                                                    <ul class="nav nav-children">
                                                        <li>
                                                            <a href="{{ route('client.create') }}">
                                                                New Client
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('client.index') }}">
                                                                View All
                                                            </a>
                                                        </li>
                                                        {{-- <!-- <li>
                                                        <a href="{{route('client.manager')}}">
                                                            Client Manager
                                                        </a>
                                                    </li> --> --}}
                                                    </ul>
                                                </li>
                                                <li class="nav-parent">
                                                    <a>
                                                        <i class="fa fa-tasks" aria-hidden="true"></i>
                                                        <span>Contracts</span>
                                                    </a>
                                                    <ul class="nav nav-children">
                                                        <li>
                                                            <a href="{{ route('contract.create') }}">
                                                                New Contract
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('contract.index') }}">
                                                                List All
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            @else
                                                <li>
                                                    <a href="{{ route('client.index') }}">
                                                        View All
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </li>

                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-tasks" aria-hidden="true"></i>
                                            <span>Instructions</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            @if (\Auth::user()->person->id == \Auth::user()->person->department->person_id)
                                                <li>
                                                    <a href="{{ route('instruction.create') }}">
                                                        New Instruction
                                                    </a>
                                                </li>
                                                <li>
                                                    <a
                                                        href="{{ route('instruction.param', ['query' => 'awaiting-review']) }}">
                                                        Awaiting Review
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="{{ route('instruction.param', ['query' => 'manager']) }}">
                                                    Instructions Manager
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('instruction.param', ['query' => 'pending']) }}">
                                                    Pending
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('instruction.param', ['query' => 'ongoing']) }}">
                                                    Ongoing
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('instruction.param', ['query' => 'completed']) }}">
                                                    Completed
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('instruction.param', ['query' => 'inactive']) }}">
                                                    Inactive
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('instruction.index') }}">
                                                    All
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-tasks" aria-hidden="true"></i>
                                            <span>Tasks</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            {{-- Supervised Task --}}
                                            @if (Auth::user()->person->level_id > 1)
                                                @include("layouts.sidebar.supervise")
                                            @endif
                                            {{-- End of Supervised Task --}}

                                            @if (\Auth::user()->person->id == \Auth::user()->person->department->person_id)
                                                <li>
                                                    <a
                                                        href="{{ route('task.param', ['query' => 'awaiting-review']) }}">
                                                        Awaiting Review
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <a href="{{ route('task.param', ['query' => 'task-manager']) }}">
                                                    Task Manager
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('task.create') }}">
                                                    New
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('task.param', ['query' => 'pending']) }}">
                                                    Pending
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('task.param', ['query' => 'ongoing']) }}">
                                                    Ongoing
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('task.param', ['query' => 'completed']) }}">
                                                    Completed
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('task.param', ['query' => 'overdue']) }}">
                                                    Overdue
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('task.index') }}">
                                                    All
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-book" aria-hidden="true"></i>
                                            <span>Documents</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="{{ route('document.index') }}">
                                                    New Document
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('document.index') }}">
                                                    List All
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>

                            <hr class="separator" />

                            <div class="sidebar-widget widget-tasks">
                                <div class="widget-header">
                                    <h6>Settings</h6>
                                    <div class="widget-toggle">+</div>
                                </div>
                                <div class="widget-content">
                                    <ul class="list-unstyled m-none">
                                        <li><a
                                                href="{{ route('profile.show', ['profile' => \Auth::user()->person->slug]) }}">Profile</a>
                                        </li>
                                        <li><a href="{{ route('change.password') }}">Change Password</a></li>
                                        <li>
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                <i class="fa fa-power-off"></i> {{ __('Logout') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                </aside>
                <!-- end: sidebar -->
