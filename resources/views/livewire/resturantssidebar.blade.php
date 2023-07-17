<ul class="sub-nav collapse" id="utilities-Ads" data-bs-parent="#sidebar-menu">
    <li class="nav-item">
        <a class="nav-link " href="{{ route('ads', [3, 0]) }}">
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
        <a class="nav-link " href="{{ route('ads', [3, 1]) }}">
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
        <a class="nav-link " href="{{ route('ads', [3, 2]) }}">
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
        <a class="nav-link" href="{{ route('accompanying') }}">
            <i class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    fill="currentColor" class="bi bi-hdd-rack-fill" viewBox="0 0 16 16">
                    <path
                        d="M2 2a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h1v2H2a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-1a2 2 0 0 0-2-2h-1V7h1a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2zm.5 3a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm2 0a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm-2 7a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm2 0a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zM12 7v2H4V7h8z" />
                </svg>
            </i>
            <span class="item-name">المرافق</span>
        </a>
    </li>
</ul>
