<?php

namespace App\Http\Controllers\Store\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Store\Location\LocationCreateRequest;
use App\Http\Requests\Store\Location\LocationQueueRequest;
use App\Http\Requests\Store\Location\LocationStoreRequest;
use App\Http\Requests\Store\Location\ShopperStoreRequest;
use App\Http\Requests\Store\Location\CheckoutRequest;
use App\Models\Store\Location\Location;
use App\Services\Store\Location\LocationService;
use App\Services\Shopper\ShopperService;
use App\Services\Shopper\StatusService;
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
     * @var StatusService
     */
    protected $status;

    /**
     * LocationController constructor.
     * @param LocationService $location
     * @param ShopperService $shopper
     * @param StatusService $status
     */
    public function __construct(LocationService $location, ShopperService $shopper, StatusService $status)
    {
        $this->location = $location;
        $this->shopper = $shopper;
        $this->status = $status;
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

    /**
     * @param ShopperStoreRequest $request
     * @param string $storeUuid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function shopperSave(ShopperStoreRequest $request, string $storeUuid): \Illuminate\Http\RedirectResponse
    {
        $params = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'location_id' => $request->location_id,
            'check_in' => Carbon::now()
        ];

        $location = $this->location->show(
            [
                'uuid' => $request->locationUuid
            ]
        );

        $active_status = $this->status->show(
            [
                'name' => 'Active'
            ]
        );

        $pending_status = $this->status->show(
            [
                'name' => 'Pending'
            ]
        );

        $shopper_count = $this->shopper->count(
            [
                'location_id' => $request->location_id,
                'status_id' => $active_status['id']
            ]
        );

        if ($location['shopper_limit'] > $shopper_count) {
            $params['status_id'] = $active_status['id'];
        } else {
            $params['status_id'] = $pending_status['id'];
        }

        $this->shopper->create($params);

        return redirect()->route('store.location.queue', ['storeUuid' => $storeUuid, 'locationUuid' => $request->locationUuid]);
    }

    /**
     * @param CheckoutRequest $request
     * @param string $storeUuid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkout(CheckoutRequest $request, string $storeUuid): \Illuminate\Http\RedirectResponse
    {
        $completed_status = $this->status->show(
            [
                'name' => 'Completed'
            ]
        );

        $active_status = $this->status->show(
            [
                'name' => 'Active'
            ]
        );

        $pending_status = $this->status->show(
            [
                'name' => 'Pending'
            ]
        );

        $params = [
            'status_id' => $completed_status['id'],
            'check_out' => Carbon::now()
        ];

        $this->shopper->update($request->shopper_id, $params);

        $location = $this->location->show(
            [
                'uuid' => $request->locationUuid
            ]
        );

        $shopper_count = $this->shopper->count(
            [
                'location_id' => $request->location_id,
                'status_id' => $active_status['id']
            ]
        );

        if ($location['shopper_limit'] > $shopper_count) {
            $next_shopper = $this->shopper->show(
                [
                    'location_id' => $request->location_id,
                    'status_id' => $pending_status['id']
                ],
                [

                ],
                [
                    'check_in' => 'ASC'
                ]
            );

            $this->shopper->update($next_shopper['id'], ['status_id' => $active_status['id']]);
        } 

        return redirect()->route('store.location.queue', ['storeUuid' => $storeUuid, 'locationUuid' => $request->locationUuid]);
        
    }

    /**
     * @param Request $request
     * @param string $storeUuid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateLimit(Request $request, string $storeUuid): \Illuminate\Http\JsonResponse
    {
        $this->location->update((int)$request->location_id, ['shopper_limit' => $request->limit]);
        return response()->json(['status' => 'success']);

    }
}
