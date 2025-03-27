<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Illuminate\Http\Request;
use App\Models\Location\Location;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {

        return array_merge(parent::share($request), [
            'meta' => [
                'title' => get_setting('meta_title'),
                'description' => get_setting('meta_description'),
                'keywords' => get_setting('meta_keywords'),
                'author' => config('app.name'),
                'favicon' => get_setting('favicon') ? uploaded_asset(get_setting('favicon')) : null,
                'logo' => get_setting('web_logo') ? uploaded_asset(get_setting('web_logo')) : null,
                'url' => url()->current(),

            ],

            'locations' => Location::all(),


        ]);
    }
}
