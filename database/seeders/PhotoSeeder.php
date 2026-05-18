<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Photo;
use App\Models\User;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        Photo::create([
            'title' => 'Atardecer en Bariloche',
            'description' => 'Fotografía panorámica del lago durante el atardecer.',
            'price' => 15000.00,
            'file_path' => 'https://picsum.photos/1200/800?random=1',
            'preview_path' => 'https://picsum.photos/800/600?random=1',
            'user_id' => $user->id,
        ]);

        Photo::create([
            'title' => 'Bosque Patagónico',
            'description' => 'Sendero rodeado de árboles nativos en otoño.',
            'price' => 18000.00,
            'file_path' => 'https://picsum.photos/1200/800?random=2',
            'preview_path' => 'https://picsum.photos/800/600?random=2',
            'user_id' => $user->id,
        ]);

        Photo::create([
            'title' => 'Montañas Nevadas',
            'description' => 'Cordillera cubierta de nieve durante invierno.',
            'price' => 22000.00,
            'file_path' => 'https://picsum.photos/1200/800?random=3',
            'preview_path' => 'https://picsum.photos/800/600?random=3',
            'user_id' => $user->id,
        ]);
    }
}