<?php

namespace App\Http\Controllers;

use App\Models\WarehousesAssocModel;
use App\Models\WarehousesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Type\Integer;

class WarehousesController extends Controller
{
    function getAllWarehouses(){
        return WarehousesModel::all();
    }

    function getWaregousesById($id){
        return WarehousesModel::find($id);
    }

    function addWarehouse(Request $req){
        $postObject = $req->json()->all();

        //Input validation
        $inputRules = array(
            "supplier_id" => "required",
            "warehouse_address" => "required"
        );

        $validator = Validator::make($postObject, $inputRules);

        if($validator->fails()){
            return $validator->errors();
        }

        $database = new WarehousesModel();

        $database->supplier_id = $postObject["supplier_id"];
        $database->warehouse_address = $postObject["warehouse_address"];

        $result = $database->save();

        if(!$result){
            return [
                "result" => "There was an error", 
                "status" => "500"
            ];
        }

        return [
            "result" => "Success", 
            "status" => "001",
            "id" => $database->id
        ];
    }

    function removeWarehouse($id){
        $database = WarehousesModel::find($id);

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

    function addProductToWarehouse($id, Request $req){
        $postObject = $req->json()->all();

        //Input validation
        $inputRules = array(
            "product_id" => "required",
            "warehouse_id" => "required",
            "supplier_id" => "required",
            "product_count" => "required"
        );

        $validator = Validator::make($postObject, $inputRules);

        if($validator->fails()){
            return $validator->errors();
        }

        $database = new WarehousesAssocModel();

        $database->product_id = $postObject["product_id"];
        $database->warehouse_id = $postObject["warehouse_id"];
        $database->supplier_id = $postObject["supplier_id"];
        $database->product_count = $postObject["product_count"];

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

    function getWarehouseProducts($id){
        $user = WarehousesAssocModel::where('warehouse_id', "=", $id)->get();
        return $user;
    }
}
