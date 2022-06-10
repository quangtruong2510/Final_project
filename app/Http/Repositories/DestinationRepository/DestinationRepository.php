<?php

namespace App\Http\Repositories\DestinationRepository;

use App\Http\Repositories\DestinationRepository\DestinationRepositoryInterface;

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
            'location'  => 'required',
            'image_url'  => 'string|regex:'.$regex,
        ]);
        $errors =[];
        $errors = $validator->errors();
        return [$errors,$input];
    }

    public function createDestination($data)
    {   
        $user = Destination::create(array_merge($data,
        [
            'is_favourite' => false,
            // 'user_id' => auth()
        ]
    ));
    //     $newUser = [
    //         'name' => request()->get('name'),
    //         'email' => request()->get('email'),
    //         'password' => bcrypt(request()->get('password'))
    //     ];
    //     $user = User::create( $newUser);
    //     return response()->json(
    //         [
    //             'message' => ' successfully registered',
    //             'user' => $user
    //         ]
    //     );
    }

    public function findDestinationById($user_id)
    {
        return User::where('id', $user_id)->first();
    }

    public function updateDestination($user_id, $new_password)
    {   
        return User::where('id', $user_id)->update(
        ['password' => bcrypt($new_password)]
        );
    }

    public function deleteDestinationById($id){

    }

}