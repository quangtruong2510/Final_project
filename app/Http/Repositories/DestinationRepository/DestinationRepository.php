<?php

namespace App\Http\Repositories\DestinationRepository;

use App\Http\Repositories\DestinationRepository\DestinationRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Destination;

class DestinationRepository implements DestinationRepositoryInterface
{   
    public function validate($input){
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $validator =  Validator()->make($input,
        [   
            'longtitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'name_location' => 'required|string|max:255',
            'note'  => 'string|max:255',
            'category_id' => 'required|numeric',
            'number_contact' =>'numeric|digits:10',
            'location'  => 'required|string|max:255',
            'image_url'  => 'string|regex:'.$regex,
        ]);
        $errors =[];
        $errors = $validator->errors();
        return [$errors,$input];
    }

    public function createDestination($data)
    {   
        return  Destination::create(array_merge($data,
            [
                'is_favourite' => false,
                'user_id' => JWTAuth::user()->id
            ]
        ));
    }

    public function findDestinationById($id)
    {
        return Destination::where([
                ['user_id','=',JWTAuth::user()->id],
                ['id','=',$id]
            ])->first();
    }

    public function updateDestination($id,$destination)
    {   
        return Destination::where('id', $id)->update($destination);
    }

    public function deleteDestinationById($id){
        return Destination::where('id', $id)->delete();
    }

    public function getListFavouriteDestinations(){
        return Destination::where([   
                ['user_id','=',JWTAuth::user()->id],
                ['is_favourite','=',true]
            ])->get();
    }

    public function updateStatusFavouriteDestinations($id,$value){
        return Destination::where([
            ['user_id','=',JWTAuth::user()->id],
            ['id','=',$id]
        ])->update($value);
    }

    public function getListDestinations(){
        return Destination::where('user_id', JWTAuth::user()->id)->get();
    }


}