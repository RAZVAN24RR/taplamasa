<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $product){
            $product->increments('id');
            $product->string('name');
            $product->integer('price');
            $product->boolean('busy');
            $product->timestamps();
            $product->integer('locationId');
            $product->text('description')->nullable();
            $product->integer('typeId');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
