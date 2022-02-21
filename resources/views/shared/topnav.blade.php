<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>

                @impersonating
                <a type="button" href="{{ route('impersonate.leave') }}"> <i class="fa-solid fa-ghost"></i> Salir del
                    modo fantasma</a>

                @endImpersonating

                @if (!session('impersonated_by'))
                    <a type="button" onclick="$('#logout_form').submit()">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                @endif


            </li>
        </ul>

    </nav>
</div>
