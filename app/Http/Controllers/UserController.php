<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('can:manage-users,App\User');
    }

    public function index(){
        return User::all();
    }

    public function store(UserRequest $request){
        $user=new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return response()->json(['message' => "Successfully added user."], 200);
    }

    public function show($userId){
        return User::findOrFail($userId);
    }

    public function update(UserRequest $request, $userId){
        $user=User::findOrFail($userId);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password){
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return response()->json(['message' => "Successfully updated user."], 200);
    }

    public function destroy($userId){
        $user=User::findOrFail($userId);
        $user->delete();

        return response()->json(['message' => "Successfully deleted user."], 200);
    }
}
