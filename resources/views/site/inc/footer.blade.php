{{-- @include('site.partial.call-action') --}}
@if (!(Route::is('store.detail') || Route::is('product.detail')))
    <div class="container">
        <footer>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-evenly">
                    <a class="nav-link text-dark" href="#">Office Login</a>
                    <a class="nav-link text-dark" href="#">Business Login</a>
                    <a class="nav-link text-dark" href="#">List Your Business </a>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <div class="footer-end">

                    <p class="copyright">
                        {!! get_setting('copy_right') !!}
                    <div class="footer-social">
                        {{-- @foreach (App\Models\Inc\CustomPages::where('status', 1)->orderBy('priority', 'asc')->whereIn('Show_in', [0, 2])->get() as $cus_pages)
                            <a href="{{ route('custom.pages', $cus_pages->slug) }}"
                                class="">{{ $cus_pages->page_name }}</a>
                        @endforeach --}}
                    </div>
                </div>
                </p>
            </div>
        </footer>
    </div>
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('site/assets/js/bootstrap.js') }}"></script>

@livewireScripts
@stack('site-scripts')
