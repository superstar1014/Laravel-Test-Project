<?php

namespace App\Http\Requests\Shopper;

use App\Models\Shopper\Shopper;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreStoreRequest
 * @package App\Http\Requests\Shopper
 */
class ShopperStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     if ($this->user()->cannot('create', Shopper::class)) {
    //         return false;
    //     }

    //     return true;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:120|min:2',
            'last_name'  => 'required|string|max:120|min:2',
            'email'      => 'required|max:60|min:6|email',
        ];
    }
}
