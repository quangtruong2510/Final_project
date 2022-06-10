<?php

namespace App\Http\Repositories\UserRepository;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function create($data)
    { 
        $validator =  Validator()->make($data,
        [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $newUser = [
            'name' => request()->get('name'),
            'email' => request()->get('email'),
            'password' => bcrypt(request()->get('password'))
        ];
        $user = User::create( $newUser);
        return response()->json(
            [
                'message' => ' successfully registered',
                'user' => $user
            ]
        );
    }

    public function findById($user_id)
    {
        return User::where('id', $user_id)->first();
    }

    public function changePassword($user_id, $new_password)
    {   
        return User::where('id', $user_id)->update(
        ['password' => bcrypt($new_password)]
        );
    }
}