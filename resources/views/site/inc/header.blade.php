<style>


select.top-select {
    background: transparent;
    border: none;
    color: #fff;
    font-size: 0.9rem;
    margin-left: -5px;
}

select.top-select option {
    color: black; /* Optional: Change color of dropdown options */
    background-color: white; /* Optional: Background for dropdown options */
}
</style>
<header>
    <div class="top-bar">
        <div class="container">
            <div class="row align-items-center">
              @if (!(Route::is('store.detail') || Route::is('product.detail')))
                <div class="col-sm-7 t-bar">
                    <div class="top-location">
                        <i class="las la-map-marker text-white"></i>
                        @php
                        $states = \App\Models\Location\State::orderBy('name','asc')->where('country_id',101)->get();
                        @endphp
                        <select id="state-select" class="top-select">
                            <option value="">Select State</option>
                            @foreach($states as $state)
                            <option value="{{$state->id}}" {{$state->id == 14 ? 'selected' : ''}}>{{$state->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="top-location">
                        <i class="las la-map-marker text-white"></i>
                        <select id="city-select" class="top-select">
                            <option value="">Select District</option>
                        </select>
                    </div>
                    <div class="top-location">
                        <i class="las la-map-marker text-white"></i>
                        <select id="block-select" class="top-select">
                            <option value="">Select city</option>
                        </select>
                    </div>
                </div>
               
                  <div class="col-sm-5">
                    <ul class="top-act">
                        @if (get_setting('facebook_link'))
                            <li><a href="{{ get_setting('facebook_link') }}"><i class="lab la-facebook-f"
                                        aria-hidden="true"></i></a></li>
                        @endif
                        @if (get_setting('instagram_link'))
                            <li><a href="{{ get_setting('instagram_link') }}"><i class="lab la-instagram"
                                        aria-hidden="true"></i></a></li>
                        @endif
                        @if (get_setting('youtube_link'))
                            <li><a href="{{ get_setting('youtube_link') }}"><i class="lab la-youtube"
                                        aria-hidden="true"></i></a></li>
                        @endif
                        @if (get_setting('linkedin_link'))
                            <li><a href="{{ get_setting('linkedin_link') }}"><i class="lab la-linkedin"
                                        aria-hidden="true"></i></a></li>
                        @endif
                        @if (get_setting('twitter_link'))
                            <li><a href="{{ get_setting('twitter_link') }}"><i class="lab la-twitter"
                                        aria-hidden="true"></i></a></li>
                        @endif

                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
    @if (!(Route::is('store.detail') || Route::is('product.detail')))
      <div class="main-menu">
        <nav class="navbar navbar-expand-lg navbar-light bg-transparent">
            <div class="container">
                <a href="{{ route('site.index') }}" class="brand-link">
                    @if (get_setting('web_logo'))
                        <img loading="lazy" title="Logo" role="img" alt="Company Logo" style="height: 45px;"
                            src="{{ uploaded_asset(get_setting('web_logo')) }}" class="img-fluid">
                    @else
                        {{ get_setting('company_name') }}
                    @endif

                </a>


                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('site.index') ? 'active' : '' }}"
                                aria-current="page" href="{{ route('site.index') }}">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('products') ? 'active' : '' }}"
                                href="{{ route('products') }}">Products</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('coupens') ? 'active' : '' }}"
                                href="{{ route('coupens') }}">Coupons</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('stores') ? 'active' : '' }}"
                                href="{{ route('stores') }}">Shops</a>
                        </li>
                        
                        @foreach (App\Models\Inc\CustomPages::where('status', 1)->orderBy('priority', 'asc')->whereIn('Show_in', [1, 2])->get() as $cus_pages)
                            <li class="nav-item"><a href="{{ route('custom.pages', $cus_pages->slug) }}"
                                    class="nav-link {{ Route::is('custom.pages') ? 'active' : '' }} ">{{ $cus_pages->page_name }}</a>
                            </li>
                        @endforeach


                    </ul>


                    @if (Auth::guard('admin')->check() ||
                            Auth::guard('web')->check() ||
                            Auth::guard('agent')->check() ||
                            Auth::guard('advertiser')->check())
                        <div class="dropdown">
                            <button class="btn dropdown-toggle " type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                @if (Auth::guard('admin')->check())
                                    <li><a class="dropdown-item" target="_blank"
                                            href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                                @endif

                                @if (Auth::guard('web')->check())
                                    <li><a class="dropdown-item" target="_blank"
                                            href="{{ route('user.dashboard') }}">User Dashboard</a></li>
                                @endif

                                @if (Auth::guard('agent')->check())
                                    <li><a class="dropdown-item" target="_blank"
                                            href="{{ route('agent.dashboard') }}">Agent Dashboard</a></li>
                                @endif

                                @if (Auth::guard('advertiser')->check())
                                    <li><a class="dropdown-item" target="_blank"
                                            href="{{ route('advertiser.dashboard') }}">Advertiser Dashboard</a>
                                    </li>
                                @endif

                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>

                            </ul>
                        </div>
                    @endif





                    <ul class="header-right">
                        @guest('web')
                            <li><a wire:navigate href="{{ route('login') }}" class="login-btn">User Login</a></li>
                            <li><a wire:navigate href="{{ route('register') }}" class="register-btn">Register<i
                                        class="las la-arrow-right"></i></a>
                            </li>
                        @endguest

                    </ul>


                </div>
            </div>
        </nav>
    </div>
    @endif
</header>
