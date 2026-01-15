<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">CIM</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Menu
            </li>

            <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="home"></i>
                    <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item {{ request()->routeIs('admin.centers.*') ? 'active' : '' }}">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="briefcase"></i>
                    <span class="align-middle">Center Management</span>
                </a>
            </li>

            {{-- 
            <li class="sidebar-header">
                Tools & Components
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="ui-buttons.html">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Buttons</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="ui-forms.html">
                    <i class="align-middle" data-feather="check-square"></i> <span
                        class="align-middle">Forms</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="ui-cards.html">
                    <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Cards</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="ui-typography.html">
                    <i class="align-middle" data-feather="align-left"></i> <span
                        class="align-middle">Typography</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="icons-feather.html">
                    <i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Icons</span>
                </a>
            </li> --}}
        </ul>
    </div>
</nav>
