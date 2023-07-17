<ul class="sub-nav collapse" id="sidebar-contact" data-bs-parent="#sidebar-menu">
    <li class="nav-item">
        <a class="nav-link " href="{{ route('user') }}">
            <i class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                    <g>
                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                    </g>
                </svg>
            </i>
            <i class="sidenav-mini-icon"> U </i>
            <span class="item-name">{{ __('dashboard.userMessages') }} <span
                    class="rcorners ml-1">{{ $userMessages }}</span></span>
        </a>
    </li>
</ul>
