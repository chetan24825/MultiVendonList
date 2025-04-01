<div class="sidebar-left">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="left-menu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="">
                        <i class="fas fa-desktop"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="fa fa-th-list"></i>
                        <span>Companies </span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.companies') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                List of Companies</a></li>

                        <li><a href="{{ route('admin.companies.import') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i>
                                Import Companies</a></li>

                    </ul>

                </li>

                <li>
                    <a href="{{ route('admin.individual') }}">
                        <i class="fa fa-th-list"></i>
                        <span>Individuals </span>
                    </a>

                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="fa fa-user-cog"></i>
                        <span>Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.users') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i>List of Users</a></li>

                    </ul>
                </li>

                <li>
                    <a href="{{ route('admin.technology') }}" class="">
                        <i class="fa fa-th-list"></i>
                        <span>Technology </span>
                    </a>

                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="fa fa-th-list"></i>
                        <span>Leads </span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.leads') }}">
                                <i class="mdi mdi-checkbox-blank-circle align-middle"></i>General Leads</a>
                        </li>

                        <li><a href="{{ route('admin.leads.message') }}">
                                <i class="mdi mdi-checkbox-blank-circle align-middle"></i>Message Leads</a>
                        </li>

                    </ul>

                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="fa fa-th-list"></i>
                        <span>Announcements </span>
                    </a>

                </li>


                <li>
                    <a href="{{ route('admin.payment') }}">
                        <i class="fa fa-th-list"></i>
                        <span>Payments
                            @if (App\Models\Payment\Wallet::where('status',0)->count() > 0)
                            <span class="right badge badge-danger">{{App\Models\Payment\Wallet::where('status',0)->count()}}</span></span>
                            @endif

                    </a>

                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="fa fa-th-list"></i>
                        <span>Send Whatapp </span>
                    </a>

                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="fa fa-th-list"></i>
                        <span>Send Email </span>
                    </a>

                </li>



                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="fa fa-th-list"></i>
                        <span>Pages</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">

                        <li><a href="#"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>Custom Pages
                            </a></li>

                        <li><a href="#"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>Custom MetaPages
                                List </a>
                        </li>

                        <li><a href="#"><i class="mdi mdi-checkbox-blank-circle align-middle"></i>Page Listing
                                Content</a>
                        </li>
                    </ul>
                </li> --}}



                <li>
                    <a href="{{ url('admin/uploaded-files') }}" class="">
                        <i class="far fa-image"></i>
                        <span>Uploads</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="">
                        <i class="far fa-image"></i>
                        <span>Comments
                            <span class="right badge badge-danger">0 </span>
                    </a>
                </li>


                <li>
                    <a href="#" class="">
                        <i class="far fa-image"></i>
                        <span>States </span>
                    </a>
                </li>


                <li
                    class="{{ Route::is('admin.custom-page') || Route::is('admin.custom-page-edit') ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);"
                        class="has-arrow {{ Route::is('admin.custom-page') || Route::is('admin.custom-page-edit') ? 'mm-active' : '' }}">
                        <i class="fa fa-cog"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('admin.settings') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle"></i> General
                            </a></li>
                        <li
                            class="{{ Route::is('admin.custom-page') || Route::is('admin.custom-page-edit') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.custom-page-all') }}"><i
                                    class="mdi mdi-checkbox-blank-circle align-middle {{ Route::is('admin.custom-page') || Route::is('admin.custom-page-edit') ? 'active' : '' }} "></i>
                                Custom Pages
                            </a>
                        </li>



                    </ul>
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
