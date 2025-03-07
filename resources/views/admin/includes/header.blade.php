<!-- Start topbar -->
<header id="page-topbar">
    <div class="navbar-header">

        <!-- Logo -->

        <!-- Start Navbar-Brand -->
        <div class="navbar-logo-box">
            <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="{{ asset('panel/images/logo-dark.png') }}" alt="logo-sm-dark" height="20">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('panel/images/logo-dark.png') }}" alt="logo-dark" height="18">
                </span>
            </a>

            <a href="#" class="logo logo-light">
                <span class="logo-sm">
                    <img src="{{ asset('panel/images/logo-sm.png') }}" alt="logo-sm-light" height="20">
                </span>
                <span class="logo-lg">
                    <img src="{{ asset('panel/images/logo-light.png') }}" alt="logo-light" height="18">
                </span>
            </a>

            <button type="button" class="btn btn-sm top-icon sidebar-btn" id="sidebar-btn">
                <i class="mdi mdi-menu-open align-middle fs-19"></i>
            </button>
        </div>
        <!-- End navbar brand -->

        <!-- Start menu -->
        <div class="d-flex justify-content-between menu-sm px-3 ms-auto">
            <div class="d-flex align-items-center gap-2">

            </div>

            <div class="d-flex align-items-center gap-2">
                <!--Start App Search-->
                <form class="app-search d-none d-lg-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="fab fa-sistrix fs-17 align-middle"></span>
                    </div>
                </form>

                <div class="dropdown d-inline-block">

                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn btn-sm top-icon p-0" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded avatar-2xs p-0"
                            src="{{ auth()->user()->avatar ? uploaded_asset(auth()->user()->avatar) : asset('panel/images/users/avatar-1.png') }}"
                            alt="Header Avatar">
                    </button>
                    <div
                        class="dropdown-menu dropdown-menu-wide dropdown-menu-end dropdown-menu-animated overflow-hidden py-0">
                        <div class="card border-0">
                            <div class="card-header bg-primary rounded-0">
                                <div class="rich-list-item w-100 p-0">
                                    <div class="rich-list-prepend">
                                        <div class="avatar avatar-label-light avatar-circle">
                                            <div class="avatar-display"><i class="fa fa-user-alt"></i></div>
                                        </div>
                                    </div>
                                    <div class="rich-list-content">
                                        <h3 class="rich-list-title text-white">{{ auth()->user()->name }}</h3>
                                        <span class="rich-list-subtitle text-white">{{ auth()->user()->gmail }}</span>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body p-0">

                            </div>
                            <div class="card-footer card-footer-bordered rounded-0">
                                <form action="" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-label-danger">Sign out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Profile -->
            </div>
        </div>
        <!-- End menu -->
    </div>
</header>
<!-- End topbar -->
