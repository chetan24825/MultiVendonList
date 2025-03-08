<div class="sidebar-left">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="left-menu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('advertiser.dashboard') }}" class="">
                        <i class="fas fa-desktop"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('advertiser.profile') }}" class="">
                        <i class=" fas fa-user"></i>
                        <span>Profile </span>

                        @if (!auth()->user()->name)
                            <span class="text-danger">*</span>
                        @endif
                    </a>
                </li>



                <li>
                    <a href="{{ route('logout') }}" class="">
                        <i class="fas fa-arrow-left"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
