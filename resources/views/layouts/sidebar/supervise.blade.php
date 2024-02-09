<li class="nav-parent">
    <a>
        <i class="fa fa-tasks" aria-hidden="true"></i>
        <span>Supervised Task</span>
    </a>

    <ul class="nav nav-children">
        <li>
            <a href="{{ route('supervisor.task', ['query' => 'awaiting-review']) }}">
                Awaiting Review
            </a>
        </li>
        <li>
            <a href="{{ route('supervisor.task', ['query' => 'pending']) }}">
                Pending
            </a>
        </li>
        <li>
            <a href="{{ route('supervisor.task', ['query' => 'ongoing']) }}">
                Ongoing
            </a>
        </li>
        <li>
            <a href="{{ route('supervisor.task', ['query' => 'completed']) }}">
                Completed
            </a>
        </li>
        <li>
            <a href="{{ route('supervisor.task', ['query' => 'overdue']) }}">
                Overdue
            </a>
        </li>
    </ul>
</li>
