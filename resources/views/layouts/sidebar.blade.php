<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                @if (session('rol')->id == 1)
                    <li class="menu-title" key="t-menu">@lang('General')</li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-home-circle"></i>
                            <span key="t-dashboards">Administracion</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="usuario-lista" key="t-default">@lang('Usuarios')</a></li>
                            <li><a href="" key="t-default">@lang('Roles')</a></li>
                        </ul>
                    </li>
                @endif

                <li class="menu-title" key="t-pages">@lang('Registros')</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-user-circle"></i>
                        <span key="t-authentication">@lang('Instituciones')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="auth-login" key="t-login">@lang('Agregar')</a></li>
                        <li><a href="auth-login-2" key="t-login-2">@lang('Lista')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-file"></i>
                        <span key="t-utility">@lang('Docentes')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="pages-starter" key="t-starter-page">@lang('Agregar')</a></li>
                        <li><a href="pages-maintenance" key="t-maintenance">@lang('Lista')</a></li>
                    </ul>
                </li>

                <li class="menu-title" key="t-components">@lang('Operaciones')</li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-share-alt"></i>
                        <span key="t-multi-level">@lang('Ciclo escolar')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="javascript: void(0);" key="t-level-1-1">@lang('Agregar')</a></li>
                        <li><a href="javascript: void(0);" key="t-level-1-1">@lang('Lista')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-share-alt"></i>
                        <span key="t-multi-level">@lang('Ciclo escolar')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li><a href="javascript: void(0);" key="t-level-1-1">@lang('Pagos')</a></li>
                        <li><a href="javascript: void(0);" key="t-level-1-1">@lang('Planillas')</a></li>
                    </ul>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
