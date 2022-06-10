<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestinationtRequest extends FormRequest
{
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
    {    $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        return [
            'longtitude' => 'double|required|',
            'latitube' => 'double|required|',
            'name_location' => 'string|required|max:255',
            'note'  => 'string|max:255',
            'category_id' => 'int,required',
            'number_contact' =>'numeric|digits:10',
            'location'  => 'string|max:255',
            'image_url'  => 'string|regex:'.$regex,
        ];
    }
    // public function messages(){
    //     return [
    //         'longtitude.requ' =
    //     ]
    // }
}
