<?php

namespace App\Http\Requests;

use Illuminate\Database\Migrations\CreateLinksTable;
use Illuminate\Foundation\Http\FormRequest;

class StoreLinkRequest extends FormRequest
{

    /**
     * if you change this value don't forget change it in your database table and CreateLinksTable migration
     * @var max url length 
     */
    const MAX_URL_LENGTH = 2048;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'link' => 'required|min:1|max:'.self::MAX_URL_LENGTH,
            'short' => 'unique:links',
        ];
    }
}
