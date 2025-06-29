<nav class="iq-sidebar-menu">
    <ul id="iq-sidebar-toggle" class="side-menu">
        <li class=" sidebar-layout @yield('dashboard')">
            <a href="{{ route('adminDashboard') }}" class="svg-icon">
                <i class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </i>
                <span class="ml-2">Dashboard</span>
                <p class="mb-0 w-10 badge badge-pill badge-primary">6</p>
            </a>
        </li>
        <li class="px-3 pt-3 pb-2">
            <span class="text-uppercase small font-weight-bold">Pages</span>
        </li>
        <li class="sidebar-layout @yield(section: 'committee')">
            <a href="{{ route('committee') }}" class="svg-icon">
                <i class="">
                    <svg class="svg-icon" id="iq-user-1-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </i><span class="ml-2">Committee</span>
            </a>
        </li>
        <li class="sidebar-layout @yield(section: 'chapter')">
            <a href="{{ route('chapter') }}" class="svg-icon">
                <i class="">
                    <svg class="svg-icon" id="iq-user-1-1" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </i><span class="ml-2">Chapter</span>
            </a>
        </li>
    </ul>
</nav>
