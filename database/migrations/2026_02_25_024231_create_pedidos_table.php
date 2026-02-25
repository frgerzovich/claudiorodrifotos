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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("buyer_name");
            $table->string("buyer_email");
            $table->string("buyer_address")->nullable();
            $table->string("buyer_phone");
            $table->decimal("total", 8, 2);
            $table->enum('status', ['pending','paid','shipped','received'])->default('pending');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
