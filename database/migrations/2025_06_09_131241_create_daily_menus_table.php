<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_menus', function (Blueprint $table) {
            $table->id();
            $table->enum('day', ['luni', 'marti', 'miercuri', 'joi', 'vineri']);
            $table->decimal('price', 8, 2);
            $table->text('item_1');
            $table->text('item_2');
            $table->text('item_3');
            $table->timestamps();
        });
        $days = ['luni', 'marti', 'miercuri', 'joi', 'vineri'];

        foreach ($days as $day) {
            DB::table('daily_menus')->insert([
                'day' => $day,
                'price' => 30.00,
                'item_1' => '',
                'item_2' => '',
                'item_3' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_menus');
    }
};
