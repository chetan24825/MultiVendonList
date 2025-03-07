

<!-- ========== Left Sidebar Start ========== -->
<div class="sidebar-left">

    <div data-simplebar class="h-100">

        <!--- Sidebar-menu -->
        <div id="sidebar-menu">

            <div class="card-body pt-0">
                <div class="row align-items-end">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4">
                        <div class="avatar-md mb-1">
                            <img src="{{ auth()->user()->avatar ? uploaded_asset(auth()->user()->avatar) : asset('panel/images/users/avatar-1.png') }}"
                                class="img-fluid avatar-circle bg-light p-2 border-2 border-primary ml-20">
                        </div>
                    </div>
                    <div class="col-sm-4">
                    </div>
                </div>
            </div>
            <ul class="left-menu list-unstyled" id="side-menu">

                <li>
                    <a href="{{ route('user.profile') }}">
                        <i class="fa fa-shapes"></i>
                        <span>Profile</span>
                    </a>

                </li>
                <li>
                    <a href="{{ route('user.order') }}">
                        <i class="fa fa-palette"></i>
                        <span> My Orders</span>
                    </a>

                </li>

                <li>
                    <a href="{{ route('user.visitingcards') }}">
                        <i class="fa fa-heart"></i>
                        <span>My Favourites</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('logout') }}" class="">
                        <i class="fas fa-desktop"></i>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
