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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre_cliente");
            $table->string("email_cliente");
            $table->string("direccion_cliente")->nullable();
            $table->string("telefono_cliente");
            $table->decimal("total", 8, 2);
            $table->enum('status', ['pendiente','pagado','enviado','recibido'])->default('pendiente');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
