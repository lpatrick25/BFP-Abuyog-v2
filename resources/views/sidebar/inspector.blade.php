<li class="nav-item static-item">
    <a class="nav-link static-item disabled" href="#" tabindex="-1">
        <span class="default-icon">Home</span>
        <span class="mini-icon">-</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link @yield('inspector-dashboard')" aria-current="page" href="{{ route('inspector.dashboard') }}">
        <i class="icon">
            <!-- Bootstrap Icon: house (for Dashboard) -->
            <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg" class="icon-20">
                <path
                    d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
            </svg>
        </i>
        <span class="item-name">Dashboard</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link @yield('inspector-gis')" aria-current="page" href="{{ route('inspector.mapping') }}">
        <i class="icon">
            <!-- Bootstrap Icon: geo-alt (for GIS) -->
            <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg" class="icon-20">
                <path
                    d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>
        </i>
        <span class="item-name">GIS</span>
    </a>
</li>
<li class="nav-item static-item">
    <a class="nav-link static-item disabled" href="#" tabindex="-1">
        <span class="default-icon">Schedule</span>
        <span class="mini-icon">-</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link @yield('inspector-schedule')" aria-current="page" href="{{ route('schedule.inspection') }}">
        <i class="icon">
            <!-- Bootstrap Icon: calendar-check (for For Inspection) -->
            <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg" class="icon-20">
                <path
                    d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                <path
                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
            </svg>
        </i>
        <span class="item-name">For Inspection</span>
    </a>
    <a class="nav-link @yield('inspector-inspected')" aria-current="page" href="{{ route('schedule.inspected') }}">
        <i class="icon">
            <!-- Bootstrap Icon: calendar-check (for For Inspection) -->
            <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg" class="icon-20">
                <path
                    d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                <path
                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
            </svg>
        </i>
        <span class="item-name">Inspected</span>
    </a>
</li>
