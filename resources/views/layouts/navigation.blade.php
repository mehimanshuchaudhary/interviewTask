<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">CIM</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Menu
            </li>

            @can('access_management')
                <li class="sidebar-item {{ request()->routeIs('access.index') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('access.index') }}">
                        <i class="align-middle" data-feather="lock"></i>
                        <span class="align-middle">Access Control</span>
                    </a>
                </li>
            @endcan

            @can('view_users')
                <li class="sidebar-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('users.index') }}">
                        <i class="align-middle" data-feather="users"></i>
                        <span class="align-middle">User Management</span>
                    </a>
                </li>
            @endcan

            @can('view_product')
                <li class="sidebar-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <a class="sidebar-link" href="{{ route('products.index') }}">
                        <i class="align-middle" data-feather="shopping-bag"></i>
                        <span class="align-middle">Product Management</span>
                    </a>
                </li>
            @endcan

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
