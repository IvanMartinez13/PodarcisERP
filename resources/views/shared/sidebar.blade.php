<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{ auth()->user()->name }}</span>
                        <span class="text-muted text-xs block">menu <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" type="button" onclick="$('#logout_form').submit()">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    ODS
                </div>
            </li>

            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge-high"></i> <span
                        class="nav-label">{{ __('modules.dashboard') }}</span></a>
            </li>

            @can('super-admin')
                <li class="{{ request()->is('customers*') ? 'active' : '' }}">
                    <a href="{{ route('customers.index') }}"><i class="fa-solid fa-user-tie"></i> <span
                            class="nav-label">{{ __('modules.customers') }}</span></a>
                </li>

                <li class="{{ request()->is('modules*') ? 'active' : '' }}">
                    <a href="{{ route('modules.index') }}"><i class="fa-solid fa-puzzle-piece"></i> <span
                            class="nav-label">{{ __('modules.modules') }}</span></a>
                </li>
            @endcan
        </ul>

    </div>
</nav>
