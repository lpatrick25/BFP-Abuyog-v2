<li class="nav-item static-item">
    <a class="nav-link static-item disabled" href="#" tabindex="-1">
        <span class="default-icon">Home</span>
        <span class="mini-icon">-</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link @yield('admin-dashboard')" aria-current="page" href="{{ route('admin.dashboard') }}">
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
    <a class="nav-link @yield('admin-gis')" aria-current="page" href="{{ route('admin.mapping') }}">
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
        <span class="default-icon">Users</span>
        <span class="mini-icon">-</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link @yield('admin-client')" aria-current="page" href="{{ route('client.list') }}">
        <i class="icon">
            <!-- Bootstrap Icon: people (for Clients) -->
            <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg" class="icon-20">
                <path
                    d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 13h10s.5-1-1.022-1H7zm.978-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m0-1a2 2 0 1 1 0-4 2 2 0 0 1 0 4m6.5 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
            </svg>
        </i>
        <span class="item-name">Clients</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link @yield('admin-marshall')" aria-current="page" href="{{ route('marshall.list') }}">
        <i class="icon">
            <!-- Bootstrap Icon: shield (for Marshalls) -->
            <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg" class="icon-20">
                <path
                    d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.025.31-.043.645-.043 1.01 0 7.09 4.261 9.64 8.374 11.934.2.12.45.12.65 0 4.113-2.294 8.374-4.844 8.374-11.934 0-.365-.018-.7-.043-1.01a.48.48 0 0 0-.328-.39 61 61 0 0 0-2.837-.856C12.984.026 10.12-.286 8 1.77 5.88-.286 3.016.026 1.662 1.59zm.776 1.07c1.07-.322 2.83-.322 4.224 0l.224.067c.645.194 1.686.506 2.55.774.258.08.497.155.703.22-.215 2.22-.645 5.906-4.477 8.445-3.832-2.54-4.262-6.225-4.477-8.445.206-.065.445-.14.703-.22.864-.268 1.905-.58 2.55-.774z" />
            </svg>
        </i>
        <span class="item-name">Marshalls</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link @yield('admin-inspector')" aria-current="page" href="{{ route('inspector.list') }}">
        <i class="icon">
            <!-- Bootstrap Icon: search (for Inspector) -->
            <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg" class="icon-20">
                <path
                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-1.442.148a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11z" />
            </svg>
        </i>
        <span class="item-name">Inspector</span>
    </a>
</li>
<li class="nav-item static-item">
    <a class="nav-link static-item disabled" href="#" tabindex="-1">
        <span class="default-icon">Management</span>
        <span class="mini-icon">-</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link @yield('admin-user')" aria-current="page" href="{{ route('user.list') }}">
        <i class="icon">
            <!-- Bootstrap Icon: person-gear (for User Management) -->
            <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg" class="icon-20">
                <path
                    d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256q.3-.428.548-.832l3.44 3.44a1.5 1.5 0 0 0 2.122-2.122l-3.44-3.44a6.6 6.6 0 0 0 .832-.548V13c1 0 1-1 1-1v-2h1v-1h-1V7c0-1-1-1-1-1v2.256a6.6 6.6 0 0 0-.548.832l-3.44-3.44a1.5 1.5 0 0 0-2.122 2.122l3.44 3.44q-.428.3-.832.548H3c-1 0-1 1-1 1zm6-3a4.87 4.87 0 0 1 1.426.22l.177-.946a.75.75 0 0 1 .865-.594l.866.173a4.9 4.9 0 0 1 .883.883l.173.866a.75.75 0 0 1-.594.865l-.946.177A4.87 4.87 0 0 1 8 13a4.87 4.87 0 0 1-1.426-.22l-.177.946a.75.75 0 0 1-.865.594l-.866-.173a4.9 4.9 0 0 1-.883-.883l-.173-.866a.75.75 0 0 1 .594-.865l.946-.177A4.87 4.87 0 0 1 8 10" />
            </svg>
        </i>
        <span class="item-name">User Management</span>
    </a>
</li>
