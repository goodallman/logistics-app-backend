<?php

namespace App\Http\Controllers;

use App\Models\SuppliersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    function getAllSuppliers(){
        return SuppliersModel::all();
    }

    function getSupplierById($id){
        return SuppliersModel::find($id);
    }

    function addSupplier(Request $req){
        $postObject = $req->json()->all();

        //Input validation
        $inputRules = array(
            "supplier_name" => "required",
            "supplier_address" => "required"
        );

        $validator = Validator::make($postObject, $inputRules);

        if($validator->fails()){
            return $validator->errors();
        }

        $database = new SuppliersModel();

        $database->supplier_name = $postObject["supplier_name"];
        $database->supplier_address = $postObject["supplier_address"];

        $result = $database->save();

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

    function removeSupplier($id){
        $database = SuppliersModel::find($id);

        $result = $database->delete();

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
}
