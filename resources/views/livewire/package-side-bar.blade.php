<ul class="sub-nav collapse" id="utilities-package" data-bs-parent="#sidebar-menu">
    <li class="nav-item">
        <a class="nav-link " href="{{ route('packages', 0) }}">
            <i class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                    <g>
                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                    </g>
                </svg>
            </i>
            <i class="sidenav-mini-icon"> U </i>
            <span class="item-name">{{ __('dashboard.newpackages') }} <span
                    class="rcorners ml-1">{{ $NewCount }}</span></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="{{ route('packages', 1) }}">
            <i class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                    <g>
                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                    </g>
                </svg>
            </i>
            <i class="sidenav-mini-icon"> A </i>
            <span class="item-name">{{ __('dashboard.Accepetedpackages') }} <span
                    class="rcorners ml-1">{{ $acceptedCount }}</span> </span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="{{ route('packages', 2) }}">
            <i class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                    <g>
                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                    </g>
                </svg>
            </i>
            <i class="sidenav-mini-icon"> U </i>
            <span class="item-name">{{ __('dashboard.rejecetdpackages') }} <span
                    class="rcorners ml-1">{{ $rejectedCount }}</span></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="{{ route('packages', 3) }}">
            <i class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                    <g>
                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                    </g>
                </svg>
            </i>
            <i class="sidenav-mini-icon"> U </i>
            <span class="item-name">{{ __('dashboard.cancelPackages') }} <span
                    class="rcorners ml-1">{{ $cancelPackages }}</span></span>
        </a>
    </li>
</ul>
