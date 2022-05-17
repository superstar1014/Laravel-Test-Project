<?php

namespace App\Http\Controllers\Store\Location;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\Location\LocationCreateRequest;
use App\Http\Requests\Store\Location\LocationQueueRequest;
use App\Http\Requests\Store\Location\LocationStoreRequest;
use App\Http\Requests\Shopper\ShopperStoreRequest;
use App\Models\Store\Location\Location;
use App\Models\Store\Shopper\Shopper;
use App\Services\Store\Location\LocationService;
use App\Services\Shopper\ShopperService;
use Carbon\Carbon;

/**
 * Class LocationController
 * @package App\Http\Controllers\Store
 */
class LocationController extends Controller
{
    /**
     * @var LocationService
     */
    protected $location;

    /**
     * @var ShopperService
     */
    protected $shopper;

    /**
     * LocationController constructor.
     * @param LocationService $location
     * @param ShopperService $shopper
     */
    public function __construct(LocationService $location, ShopperService $shopper)
    {
        $this->location = $location;
        $this->shopper = $shopper;
    }

    /**
     * @param Location $location
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function public(Location $location)
    {
        return view('stores.location.public')
            ->with('location', $location);
    }

    /**
     * @param LocationCreateRequest $request
     * @param string $storeUuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(LocationCreateRequest $request, string $storeUuid)
    {
        return view('stores.location.create')
            ->with('store', $storeUuid);
    }

    /**
     * @param LocationStoreRequest $request
     * @param string $storeUuid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LocationStoreRequest $request, string $storeUuid): \Illuminate\Http\RedirectResponse
    {
        $this->location->create([
            'location_name' => $request->location_name,
            'shopper_limit' => $request->shopper_limit,
            'store_id' => $storeUuid
        ]);

        return redirect()->route('store.store', ['store' => $storeUuid]);
    }

    /**
     * @param ShopperStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function shopperCreate(ShopperStoreRequest $request, string $storeUuid): \Illuminate\Http\RedirectResponse
    {
        $locationUuid = $request->locationUuid;

        $location = $this->location->show(
            [
                'uuid' => $locationUuid
            ],
            [
                'Shoppers',
                'Shoppers.Status'
            ]
        );

        $params = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'location_id' => $request->location_id,
        ];
        $this->shopper->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'location_id' => $request->location_id,
            'status_id' => 3,
            'check_in' => Carbon::now()
        ]);

        return redirect()->route('store.store', ['store' => $storeUuid]);
    }

    /**
     * @param LocationQueueRequest $request
     * @param string $storeUuid
     * @param string $locationUuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function queue(LocationQueueRequest $request, string $storeUuid, string $locationUuid)
    {
        $location = $this->location->show(
            [
                'uuid' => $locationUuid
            ],
            [
                'Shoppers',
                'Shoppers.Status'
            ]
        );

        $shoppers = null;

        if( isset($location['shoppers']) && count($location['shoppers']) >= 1 ){
            $shoppers = $this->location->getShoppers($location['shoppers']);
        }

        return view('stores.location.queue')
            ->with('location', $location)
            ->with('store', $storeUuid)
            ->with('shoppers', $shoppers);
    }
}
