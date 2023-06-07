<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->integer('product_price');
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_name');
            $table->string('supplier_address');
        });

        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id');
            $table->string('warehouse_address');
            
            //Foreign keys - relations
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });

        Schema::create('assoc_table', function (Blueprint $table) {
            $table->id();
            $table->integer("product_id");
            $table->integer('warehouse_id');
            $table->integer('supplier_id');
            $table->integer('product_count');

            //Foreign keys - relations
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
