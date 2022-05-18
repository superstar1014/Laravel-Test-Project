<?php

namespace App\Http\Requests\Store\Location;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ShopperStoreRequest
 * @package App\Http\Requests\Store\Location
 */
class ShopperStoreRequest extends FormRequest
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
            'first_name' => 'required|string|max:120|min:2',
            'last_name'  => 'required|string|max:120|min:2',
            'email'      => 'required|max:60|min:6|email',
        ];
    }
}
