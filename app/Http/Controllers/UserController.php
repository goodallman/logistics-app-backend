<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    function addUser(Request $req){
        $usersCount = User::get()->count();

        if($usersCount > 0){
            return [
                "loggedIn" => false,
                "status" => "Error, initial registration already done"
            ];
        }

        $postObject = $req->json()->all();

        //Input validation
        $inputRules = array(
            "username" => "required",
            "email" => "required",
            "password" => "required"
        );

        $validator = Validator::make($postObject, $inputRules);

        if($validator->fails()){
            return $validator->errors();
        }

        //Database
        $userDB = new User();

        if(User::where('email', '=', $postObject["email"])->count() > 0){
            return [
                "result" => "User already exists", 
                "status" => "409"
            ];
        }

        $userDB->name = $postObject["username"];
        $userDB->email = $postObject["email"];
        $userDB->password = Hash::make($postObject["password"]);

        $result = $userDB->save();

        if(!$result){
            return [
                "result" => "There was an error", 
                "status" => "500"
            ];
        }

        return [
            "result" => "Success", 
            "status" => "001"
        ];
    }

    function authUser(Request $req){
        $postObject = $req->json()->all();
        $user = User::where('email', "=", $postObject['email'])->first();

        if($user == null || !Hash::check($postObject['password'], $user->password)){
            return [
                "result" => "User doesn't exists or wrong password", 
                "status" => "400"
            ];
        }

        $token = $user->createToken('logistic_app_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'status' => "001"
        ];
    }

    function checkLogin(){
        //Check if any users exists
        $usersCount = User::all()->count();

        if($usersCount == 0){
            return [
                "loggedIn" => false,
                "status" => "No user in database"
            ];
        }

        $authCheck = auth("sanctum")->check();

        return [
            "loggedIn" => $authCheck
        ];
    }
}
