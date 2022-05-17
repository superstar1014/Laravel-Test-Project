<?php

namespace App\Http\Controllers\Shopper;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shopper\ShopperCreateRequest;
use App\Http\Requests\Shopper\ShopperStoreRequest;
use App\Models\Shopper\Shopper;
use App\Services\Shopper\ShopperService;

/**
 * Class ShopperController
 * @package App\Http\Controllers\Shopper
 */
class ShopperController extends Controller
{
    /**
     * @var ShopperService
     */
    protected $shopper;

    /**
     * StoreController constructor.
     * @param ShopperService $shopper
     */
    public function __construct(ShopperService $shopper)
    {
        $this->shopper = $shopper;
    }
    
    /**
     * @param ShopperCreateRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(ShopperCreateRequest $request)
    {
        return view('shopper.create');
    }

    /**
     * @param StoreStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ShopperStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        print_r($request->email);exit;
        $this->shopper->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email
        ]);

        return redirect()->route('store.index');
    }
}
