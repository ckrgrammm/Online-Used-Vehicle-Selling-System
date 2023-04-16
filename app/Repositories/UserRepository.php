<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{

    public function allUser()
    {
        return User::where('deleted', 0)->get();
    }

    public function storeUser($data)
    {
        return User::create($data);
    }

    public function findUser($id)
    {
        return User::find($id);
    }

    public function findUserByEmail($email)
    {
        return User::where(['email'=>$email])->first();
    }

    public function search($query)
    {
        return Product::select('make', 'model')
        ->where('make', 'LIKE', '%'.$query.'%')
        ->orWhere('model', 'LIKE', '%'.$query.'%')
        ->distinct()
        ->get();
    }

    public function updateUser($data, $id)
    {
        $user = User::where('id', $id)->first();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->gender = $data['gender'];
        $user->address = $data['address'];
        if($data['image'] != ''){
            $user->image = $data['image'];
        }
        $user->phoneNum = $data['phoneNum'];
        $user->save();
    }

    public function edit_password($data, $id)
    {
        $user = User::find($id);
        $user->password = Hash::make($data['password']);
        $user->save();
    }

    public function password_reset($data)
    {
        $user = User::where('email', $data['email'])->first();
        $user->password = Hash::make($data['password']);
        $user->save();
    }

    public function destroyUser($id)
    {
        $user = User::find($id);
        $user->deleted = 1;
        $user->save();
    }
}
