<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\WarehousesAssocModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    /**
     * Get all products from products table
     */
    function getAllProducts(){
        return ProductModel::all();
    }

    /**
     * Add product to the database
     */
    function addProduct(Request $req){
        $postObject = $req->json()->all();

        //Input validation
        $inputRules = array(
            "product_name" => "required",
            "product_price" => "required"
        );

        $validator = Validator::make($postObject, $inputRules);

        if($validator->fails()){
            return $validator->errors();
        }

        //Database
        $productDB = new ProductModel();

        $productDB->product_name = $postObject["product_name"];
        $productDB->product_price = $postObject["product_price"];

        $result = $productDB->save();

        if(!$result){
            return [
                "result" => "There was an error", 
                "status" => "500"
            ];
        }

        return [
            "result" => "Success", 
            "status" => "001",
            "id" => $productDB->id,
        ];
    }

    /**
     * Update product information (not implemented)
     */
    function updateProduct($id, Request $req){
        $putObject = $req->json()->all();

        //Input validation
        $inputRules = array(
            "product_name" => "required",
            "product_price" => "required"
        );

        $validator = Validator::make($putObject, $inputRules);

        if($validator->fails()){
            return $validator->errors();
        }

        //Database
        $productDB = ProductModel::find($id);

        $productDB->product_name = $putObject["product_name"];
        $productDB->product_price = $putObject["product_price"];

        $result = $productDB->save();

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

    /**
     * Get specific product information by ID (not implemented)
     */
    function getProductById($id){
        return ProductModel::find($id);
    }

    /**
     * Delete specific product
     */
    function deleteProduct($id){
        $productDB = ProductModel::find($id);

        $result = $productDB->delete();

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

    /**
     * Add warehouse association from API route using Request object
     */
    function catalogAddApi(Request $req){
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

        //Database
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
            "status" => "001",
        ];
    }

    /**
     * Delete warehouse association from database
     */
    function catalogDeleteAssoc($id){
        $database = WarehousesAssocModel::find($id);

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

    /**
     * Add warehouse association using specific data - Example: Optional warehouse association on product add (not implemented)
     */
    function catalogAdd($productId, $warehouseId, $supplierId){
        $database = new WarehousesAssocModel();

        $database->product_id = $productId;
        $database->warehouse_id = $warehouseId;
        $database->supplier_id = $supplierId;
        $database->product_count = 0;

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
        ];
    }

    /**
     * Get all warehouses associations
     */
    function catalogGet(){
        return WarehousesAssocModel::all();
    }
}
