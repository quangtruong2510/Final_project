<?php

namespace App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\CategoryRepository\CategoryRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Category;
use App\Models\Destination;


class CategoryRepository implements CategoryRepositoryInterface
{   
    
    public function createCategory($Category){
        return  Category::create(array_merge($Category,
            [
                'user_id' => JWTAuth::user()->id,
                'quantity' => 0,
            ]
        ));
    }

    public function deleteCategoryById($id){

        $result = Category::where('id', $id)->delete();
        if( $result){
            Destination::where([ ['user_id','=',JWTAuth::user()->id],
            ['category_id','=',$id]])->delete();
        }
    }
  
    public function getListCategory(){
        $categories = Category::where([   
            ['user_id','=',JWTAuth::user()->id],
        ])->get();
        return $categories;
    }
   
}