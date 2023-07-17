<ul class="sub-nav collapse" id="utilities-market" data-bs-parent="#sidebar-menu">
    <li class="nav-item">
        <a class="nav-link " href="{{ route('ads', [9, 0]) }}">
            <i class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                    <g>
                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                    </g>
                </svg>
            </i>
            <i class="sidenav-mini-icon"> U </i>
            <span class="item-name">الاعلانات الجديدة <span
                    class="rcorners ml-1">{{ $NewCount }}</span></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="{{ route('ads', [9, 1]) }}">
            <i class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                    <g>
                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                    </g>
                </svg>
            </i>
            <i class="sidenav-mini-icon"> A </i>
            <span class="item-name">الاعلانات المقبولة <span
                    class="rcorners ml-1">{{ $acceptedCount }}</span> </span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="{{ route('ads', [9, 2]) }}">
            <i class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                    <g>
                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                    </g>
                </svg>
            </i>
            <i class="sidenav-mini-icon"> U </i>
            <span class="item-name">الاعلانات المرفوضة <span
                    class="rcorners ml-1">{{ $rejectedCount }}</span></span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="{{ route('market_type') }}">
            <i class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
                    <g>
                        <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                    </g>
                </svg>
            </i>
            <i class="sidenav-mini-icon"> U </i>
            <span class="item-name">انواع التسوق</span>
        </a>
    </li>
</ul>
