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
        Schema::create('fotos', function (Blueprint $table) {
            $table->id();
            $table->timestamp("fecha_subida")->useCurrent(); 
            $table->string("titulo");
            $table->text("descripcion")->nullable();
            $table->string("tipo");
            // 8 y 2 son la cantidad de caracteres que puede tener el entero y el decimal respectivamente
            $table->decimal("precio", 8, 2);
            $table->string("archivo");
            $table->string("preview");
            $table->unsignedBigInteger("usuario_id"); //clave foranea para relacionar con usuarios
            //relacion entre tablas, indicando que el campo usuario_id hace referencia al campo id de la tabla usuarios, y que si se borra un usuario, se borren sus fotos
            $table->foreign("usuario_id")->references("id")->on("usuarios")->onDelete("cascade"); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fotos');
    }
};
