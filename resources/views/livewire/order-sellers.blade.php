<ul class="sub-nav collapse" id="utilities-order" data-bs-parent="#sidebar-menu">
    <li class="nav-item">
        <a class="nav-link " href="{{ route('ordersSeller', 0) }}">
            <i class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                    <g>
                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                    </g>
                </svg>
            </i>
            <i class="sidenav-mini-icon"> U </i>
            <span class="item-name">{{ __('dashboard.newOrders') }} <span
                    class="rcorners ml-1">{{ $NewCount }}</span></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="{{ route('ordersSeller', 1) }}">
            <i class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                    <g>
                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                    </g>
                </svg>
            </i>
            <i class="sidenav-mini-icon"> A </i>
            <span class="item-name">{{ __('dashboard.AccepetedOrders') }} <span
                    class="rcorners ml-1">{{ $acceptedCount }}</span> </span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="{{ route('ordersSeller', 2) }}">
            <i class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                    <g>
                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                    </g>
                </svg>
            </i>
            <i class="sidenav-mini-icon"> U </i>
            <span class="item-name">{{ __('dashboard.rejecetdOrders') }} <span
                    class="rcorners ml-1">{{ $rejectedCount }}</span></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="{{ route('ordersSeller', 3) }}">
            <i class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                    <g>
                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                    </g>
                </svg>
            </i>
            <i class="sidenav-mini-icon"> U </i>
            <span class="item-name">{{ __('dashboard.cancelOrders') }} <span
                    class="rcorners ml-1">{{ $cancelOrders }}</span></span>
        </a>
    </li>
</ul>
