<div id="sidebar-wrapper">
    <ul class="sidebar-nav">
        <li class="sidebar-brand">
                <b>PUPC</b>
        </li>
        <li>
            <a class="{{ Request::is('dashboard') ? 'active' : ''}}" href="{{ route('user.index') }}">
                <i class="fas fa-home icon"></i>
                Dashboard
            </a>
        </li>
        @if ($LoggedUserInfo['role'] == 'Admin')
        <li>
            <a class="{{ Request::is('users') ? 'active' : ''}}" href="{{ route('user.userslist') }}">
                <i class="fas fa-users icon"></i>
                Users
            </a>
        </li>
        <li>
            <a class="{{ Request::is('roles') ? 'active' : ''}}" href="{{ route('role.roleslist') }}">
                <i class="fas fa-users icon"></i>
                Roles
            </a>
        </li>
        @endif
        <li>
            <a class="{{ Request::is('uploadfile') ? 'active' : ''}}" href="{{ route('file.upload') }}">
                <i class="fas fa-file icon"></i>
                Files
            </a>
        </li>
    </ul>
</div>