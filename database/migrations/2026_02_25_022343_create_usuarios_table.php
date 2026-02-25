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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->string("email", 191)->unique();
            $table->string("contraseña");
            $table->text("descripcion")->nullable(); //nullable para permitir que sea opcional, ya que sino son requeridos por defecto!! 
            $table->string("rol");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
