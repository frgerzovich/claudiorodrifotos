<?php

namespace App\Http\Controllers;

class HolaMundo extends Controller
{
    public function index()
    {
        $saludo = "Hola Mundo";
        return view('welcome', compact('saludo')); // Retorna la vista 'welcome' con la variable 'saludo'
    }
}
