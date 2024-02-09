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
                                            <i class="fa fa-briefcase" aria-hidden="true"></i>
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
                                            @endif

                                            <li class="nav-parent">
                                                <a>
                                                    <i class="fa fa-tasks" aria-hidden="true"></i>
                                                    <span>Instruction</span>
                                                </a>
                                                <ul class="nav nav-children">
                                                    <li>
                                                        <a href="{{ route('instruction.create') }}">
                                                            New Instruction
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="{{ route('instruction.param', ['query' => 'manager']) }}">
                                                            Instructions Manager
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="{{ route('instruction.param', ['query' => 'pending']) }}">
                                                            Pending
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="{{ route('instruction.param', ['query' => 'ongoing']) }}">
                                                            Ongoing
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="{{ route('instruction.param', ['query' => 'completed']) }}">
                                                            Completed
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="{{ route('instruction.param', ['query' => 'inactive']) }}">
                                                            Inactive
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="{{ route('instruction.index') }}">
                                                            List All
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
                                                    <li>
                                                        <a href="{{ route('task.create') }}">
                                                            New Task
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="{{ route('task.param', ['query' => 'task-manager']) }}">
                                                            Task Manager
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('task.index') }}">
                                                            Ongoing
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('task.index') }}">
                                                            List All
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('task.index') }}">
                                                            Overdue
                                                        </a>
                                                    </li>
                                                </ul>
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

                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                            <span>Finances</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li class="nav-parent">
                                                <a>
                                                    Client Account
                                                </a>
                                                <ul class="nav nav-children">
                                                    <li>
                                                        <a href="ui-elements-typography.html">
                                                            New Account
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="ui-elements-typography.html">
                                                            View All
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="nav-parent">
                                                <a>
                                                    Revenue
                                                </a>
                                                <ul class="nav nav-children">
                                                    <li>
                                                        <a href="ui-elements-typography.html">
                                                            New Account
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="ui-elements-typography.html">
                                                            View All
                                                        </a>
                                                    </li>
                                                </ul>

                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-parent">
                                        <a>
                                            <i class="fa fa-asterisk" aria-hidden="true"></i>
                                            <span>Special Days</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a href="extra-changelog.html">
                                                    Calendar
                                                </a>
                                            </li>
                                            {{-- <li>
                                                <a href="extra-ajax-made-easy.html">
                                                     Anniversaries
                                                </a>
                                            </li> --}}
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
