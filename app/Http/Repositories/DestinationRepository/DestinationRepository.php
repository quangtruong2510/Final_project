<?php

namespace App\Http\Repositories\DestinationRepository;

use App\Http\Repositories\DestinationRepository\DestinationRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Destination;
use App\Models\Category;

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
        $destination =  Destination::create(array_merge($data,
            [
                'is_favourite' => false,
                'user_id' => JWTAuth::user()->id
            ]
        ));
        $category = Category::find($destination->category_id);
        dd($category->quantity);
        $category->quantity += 1  ;
        $category->save();

        return $destination;
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

    public function getDestinationByCategoryId($id)
    {    
        return Destination::where([   
            ['user_id','=',JWTAuth::user()->id],
            ['category_id','=',$id]])->get();
    }


    public function deleteDestinationById($id)
    {    
        $destination_check = Destination::find($id);
        $destination =  Destination::where([   
            ['user_id','=',JWTAuth::user()->id],
            ['id','=',$id]])->delete();
        if($destination){
            $category = Category::find($destination_check->category_id);
            $category->quantity -= 1  ;
            $category->save();
        }
        return $destination;
       
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