<?php

namespace App\Http\Requests\Store\Location;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ShopperStoreRequest
 * @package App\Http\Requests\Store\Location
 */
class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email'      => 'required|max:60|min:6|email',
        ];
    }
}
