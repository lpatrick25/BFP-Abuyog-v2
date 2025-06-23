<li class=" Editable
<li class="nav-item static-item">
    <a class="nav-link static-item disabled" href="#" tabindex="-1">
        <span class="default-icon">Home</span>
        <span class="mini-icon">-</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link @yield('client-dashboard')" aria-current="page" href="{{ route('client.dashboard') }}">
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
    <a class="nav-link @yield('client-gis')" aria-current="page" href="{{ route('client.mapping') }}">
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
        <span class="default-icon">Establishment</span>
        <span class="mini-icon">-</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link @yield('client-establishment')" aria-current="page" href="{{ route('establishment.list') }}">
        <i class="icon">
            <!-- Bootstrap Icon: building (for Establishment List) -->
            <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg" class="icon-20">
                <path
                    d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V11a.5.5 0 0 1 .5-.5H4V9H1.5a.5.5 0 0 1-.5-.5V4a.5.5 0 0 1 .5-.5H5V3H1.5a.5.5 0 0 1-.5-.5V.5a.5.5 0 0 1 .5-.5h13.263zM6 4h4v1H6V4zm0 3h4v1H6V7zm0 3h4v1H6v-1zm6-7H2v1h10V3zm0 3H2v1h10V6zm0 3H2v1h10V9z" />
            </svg>
        </i>
        <span class="item-name">List</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link @yield('client-application')" aria-current="page" href="{{ route('application.list') }}">
        <i class="icon">
            <!-- Bootstrap Icon: clipboard (for Application) -->
            <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg" class="icon-20">
                <path
                    d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v-1a.5.5 0 0 1 .5-.5h1A.5.5 0 0 1 15 1v12.5a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V3.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1zm2.5 0a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1z" />
            </svg>
        </i>
        <span class="item-name">Application</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link @yield('client-schedule')" aria-current="page" href="{{ route('client.schedule') }}">
        <i class="icon">
            <!-- Bootstrap Icon: calendar (for Schedule) -->
            <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg" class="icon-20">
                <path
                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
            </svg>
        </i>
        <span class="item-name">Schedule</span>
    </a>
</li>
<li class="nav-item static-item">
    <a class="nav-link static-item disabled" href="#" tabindex="-1">
        <span class="default-icon">Management</span>
        <span class="mini-icon">-</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link @yield('client-fsic')" aria-current="page" href="{{ route('client.fsic') }}">
        <i class="icon">
            <!-- Bootstrap Icon: file-earmark-text (for FSIC) -->
            <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg" class="icon-20">
                <path
                    d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z" />
                <path
                    d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v3.5a.5.5 0 0 0 .5.5h3V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z" />
            </svg>
        </i>
        <span class="item-name">FSIC</span>
    </a>
</li>
