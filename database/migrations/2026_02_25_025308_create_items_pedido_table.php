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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('photo_id')
                  ->constrained()
                  ->nullOnDelete(); // si borran la foto, el item queda con photo_id = null

            $table->integer('quantity');
            $table->decimal('unit_price', 8, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};