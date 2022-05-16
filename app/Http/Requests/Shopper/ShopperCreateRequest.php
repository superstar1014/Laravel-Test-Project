<?php

namespace App\Http\Requests\Shopper;

use App\Models\Shopper\Shopper;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreCreateRequest
 * @package App\Http\Requests\Shopper
 */
class ShopperCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize(): bool
    // {
    //     if ($this->user()->cannot('create', Shopper::class)) {
    //         print_r("expression");exit;
    //         return false;
    //     }

    //     return true;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
