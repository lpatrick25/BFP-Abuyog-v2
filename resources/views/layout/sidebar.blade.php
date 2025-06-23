<aside class="sidebar sidebar-default sidebar-white sidebar-base sidebar-color sidebar-hover navs-pill">
    <div class="sidebar-header d-flex align-items-center justify-content-start">

        <a href="#" class="navbar-brand">
            <!--Logo start-->
            <!--logo End-->

            <!--Logo start-->
            <div class="logo-main">
                <div class="logo-normal">
                    <img src="{{ asset('img/bfp.webp') }}" alt="BFP Abuyog" class="icon-30" width="28">
                </div>
                <div class="logo-mini">
                    <img src="{{ asset('img/bfp.webp') }}" alt="BFP Abuyog" class="icon-30" width="28">
                </div>
            </div>
            <!--logo End-->
            <h4 class="logo-title">BFP - Abuyog</h4>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </i>
            </div>
        </a>
    </div>
    <div class="sidebar-body pt-0 data-scrollbar">
        <div class="sidebar-list">
            <!-- Sidebar Menu Start -->
            <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                <li class="nav-item" id="back-btn" style="display: none;">
                    <a class="nav-link active" href="javascript:void(0);" onclick="goBack()">
                        <i class="icon">
                            <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.92 2H16.09C19.62 2 22 4.271 22 7.66V16.33C22 19.72 19.62 22 16.09 22H7.92C4.38 22 2 19.72 2 16.33V7.66C2 4.271 4.38 2 7.92 2ZM9.73 12.75H16.08C16.5 12.75 16.83 12.41 16.83 12C16.83 11.58 16.5 11.25 16.08 11.25H9.73L12.21 8.78C12.35 8.64 12.43 8.44 12.43 8.25C12.43 8.061 12.35 7.87 12.21 7.72C11.92 7.43 11.44 7.43 11.15 7.72L7.38 11.47C7.1 11.75 7.1 12.25 7.38 12.53L11.15 16.28C11.44 16.57 11.92 16.57 12.21 16.28C12.5 15.98 12.5 15.51 12.21 15.21L9.73 12.75Z"
                                    fill="currentColor"></path>
                            </svg>
                        </i>
                        <span class="item-name">Go Back</span>
                    </a>
                </li>
                @if (auth()->user()->role === 'Admin')
                    @include('sidebar.admin')
                @endif
                @if (auth()->user()->role === 'Client')
                    @include('sidebar.client')
                @endif
                @if (auth()->user()->role === 'Marshall')
                    @include('sidebar.marshall')
                @endif
                @if (auth()->user()->role === 'Inspector')
                    @include('sidebar.inspector')
                @endif
            </ul>
        </div>
        <div class="sidebar-footer"></div>
    </div>
</aside>
