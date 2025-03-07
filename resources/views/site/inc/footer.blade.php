@include('site.partial.call-action')
@if (!(Route::is('store.detail') || Route::is('product.detail')))
    <div class="container">
        <footer>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-evenly">
                    <a class="nav-link text-dark" href="{{ route('agent.login') }}">Office Login</a>
                    <a class="nav-link text-dark" href="{{ route('advertiser.login') }}">Business Login</a>
                    <a class="nav-link text-dark" href="{{ route('advertiser.register') }}">List Your Business </a>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <div class="footer-end">

                    <p class="copyright">
                        {!! get_setting('copy_right') !!}
                    <div class="footer-social">
                        @foreach (App\Models\Inc\CustomPages::where('status', 1)->orderBy('priority', 'asc')->whereIn('Show_in', [0, 2])->get() as $cus_pages)
                            <a href="{{ route('custom.pages', $cus_pages->slug) }}"
                                class="">{{ $cus_pages->page_name }}</a>
                        @endforeach
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
<script>
   $(document).ready(function() {
    // Trigger city filter on state change
    $('#state-select').change(function() {
        var state = $(this).val();

        // Fetch cities based on selected state
        $.ajax({
            url: '{{ route('products.getCitiesByState') }}',
            method: 'GET',
            data: {
                state: state
            },
            success: function(data) {
                var citySelect = $('#city-select');
                citySelect.empty();
                citySelect.append('<option value="">Select District</option>');
                $.each(data, function(index, city) {
                    citySelect.append('<option value="' + city.id + '">' + city.name + '</option>');
                });

                // Clear block select when state changes
                $('#block-select').empty().append('<option value="">Select City</option>');
            }
        });
    }).change();

    // Trigger block filter on city change
    $('#city-select').change(function() {
        var city = $(this).val();

        // Fetch blocks based on selected city
        $.ajax({
            url: '{{ route('products.getBlocksByCity') }}',
            method: 'GET',
            data: {
                city: city
            },
            success: function(data) {
                var blockSelect = $('#block-select');
                blockSelect.empty();
                blockSelect.append('<option value="">Select City</option>');
                $.each(data, function(index, block) {
                    blockSelect.append('<option value="' + block.id + '">' + block.name + '</option>');
                });
            }
        });
    });

    // Trigger product filter on any dropdown change
    $('#state-select, #city-select, #block-select').change(function() {
        var state = $('#state-select').val();
        var city = $('#city-select').val();
        var block = $('#block-select').val();

        $.ajax({
            url: '{{ route('products.filter') }}',
            method: 'GET',
            data: {
                state: state,
                city: city,
                block: block
            },
            success: function(data) {
                $('#product-list').html(data);
            }
        });
    });
});

</script>
@livewireScripts
@stack('site-scripts')
