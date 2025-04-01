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
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="fa fa-th-list"></i>
                        <span>Leads
                            @if (App\Models\Inc\MessageLead::where('advertiser_id', Auth::id())->where('payment_status', 0)->count() > 0)
                                <span class="right badge badge-danger">
                                    {{ App\Models\Inc\MessageLead::where('advertiser_id', Auth::id())->where('payment_status', 0)->count() }}</span>
                            @endif
                        </span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('advertiser.leads.general') }}">
                                <i class="mdi mdi-checkbox-blank-circle align-middle"></i>General Leads</a>
                        </li>

                        <li><a href="{{ route('advertiser.leads.message') }}">
                                <i class="mdi mdi-checkbox-blank-circle align-middle"></i>Message Leads</a>
                        </li>

                    </ul>

                </li>


                <li>
                    <a href="javascript: void(0);" class="has-arrow ">
                        <i class="fas fa-wallet"></i>
                        <span>My Wallet</span>
                    </a>

                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('advertiser.wallet') }}">
                                <i class="mdi mdi-checkbox-blank-circle align-middle"></i>Wallet</a>
                        </li>

                        <li><a href="{{ route('advertiser.withdraw') }}">
                                <i class="mdi mdi-checkbox-blank-circle align-middle"></i>Withdraw</a>
                        </li>

                    </ul>

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
