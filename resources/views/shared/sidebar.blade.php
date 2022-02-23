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

                        @impersonating


                        <li>
                            <a class="dropdown-item" type="button" href="{{ route('impersonate.leave') }}">
                                Salir del modo fantasma
                            </a>
                        </li>

                        @endImpersonating

                        @if (!session('impersonated_by'))
                            <li>
                                <a class="dropdown-item" type="button" onclick="$('#logout_form').submit()">Logout</a>
                            </li>
                        @endif
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

            @hasrole('super-admin')
                <li class="{{ request()->is('customers*') ? 'active' : '' }}">
                    <a href="{{ route('customers.index') }}"><i class="fa-solid fa-user-tie"></i> <span
                            class="nav-label">{{ __('modules.customers') }}</span></a>
                </li>

                <li class="{{ request()->is('modules*') ? 'active' : '' }}">
                    <a href="{{ route('modules.index') }}"><i class="fa-solid fa-puzzle-piece"></i> <span
                            class="nav-label">{{ __('modules.modules') }}</span></a>
                </li>
            @endhasrole

            @hasrole('customer-manager')
                <li class="{{ request()->is('branches*') ? 'active' : '' }}">
                    <a href="{{ route('branches.index') }}">

                        <i class="fa-solid fa-building"></i>
                        <span class="nav-label">{{ __('modules.branches') }}</span>
                    </a>
                </li>


                <li class="{{ request()->is('departaments*') ? 'active' : '' }}">
                    <a href="{{ route('departaments.index') }}">

                        <i class="fa-solid fa-diagram-predecessor"></i>
                        <span class="nav-label">{{ __('modules.departaments') }}</span>
                    </a>
                </li>


                <li class="{{ request()->is('users*') ? 'active' : '' }}">
                    <a href="{{ route('users.index') }}">
                        <i class="fa fa-users" aria-hidden="true"></i>
                        <span class="nav-label">{{ __('modules.users') }}</span>
                    </a>
                </li>
            @endhasrole
        </ul>

    </div>
</nav>
