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
        Schema::create('items_pedido', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("pedido_id"); 
            $table->foreign("pedido_id")->references("id")->on("pedidos")->onDelete("cascade");
            $table->unsignedBigInteger("foto_id");
            $table->foreign("foto_id")->references("id")->on("fotos")->onDelete("cascade");
            $table->integer("cantidad");
            $table->decimal("precio_unitario", 8, 2); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items_pedido');
    }
};
