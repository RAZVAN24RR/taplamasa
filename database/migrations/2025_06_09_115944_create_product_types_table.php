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
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->timestamps();
        });

        $productTypes = [
            'PIZZA',
            'FRUCTE DE MARE',
            'PASTE',
            'Specialitatea Casei',
            'Micul Dejun',
            'Garnituri',
            'Specialitati de porc',
            'Specialități de pește',
            'Specialități de vită',
            'Specialități de pasăre',
            'Platouri',
            'Ciorbe',
            'Preparate bufet',
            'Salate',
            'Deserturi',
            'Băuturi răcoritoare',
            'Bere',
            'Bere fără alcool',
            'Apă',
            'Cafea',
            'Energizant',
            'Vinuri',
            'Șampanie',
            'Cognac',
            'Vodka',
            'Whisky',
            'Gin'
        ];

        foreach ($productTypes as $type) {
            DB::table('product_types')->insert([
                'type' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_types');
    }
};
