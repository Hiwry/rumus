<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandingImage;

class LandingImagesSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            // Banner Section
            [
                'key' => 'hero_banner',
                'title' => 'Banner Principal (Modelo)',
                'path' => 'images/rumus_hero_model.png',
                'section' => 'banner'
            ],

            // Categories Section
            [
                'key' => 'category_sublimacao',
                'title' => 'Categoria - Sublimação',
                'path' => 'images/sublimacao_mockup.png',
                'section' => 'categories'
            ],
            [
                'key' => 'category_serigrafia',
                'title' => 'Categoria - Serigrafia',
                'path' => 'images/serigrafia_mockup.png',
                'section' => 'categories'
            ],
            [
                'key' => 'category_dtf',
                'title' => 'Categoria - DTF',
                'path' => 'images/dtf_mockup.png',
                'section' => 'categories'
            ],
            [
                'key' => 'category_ecobag',
                'title' => 'Categoria - Ecobag',
                'path' => 'images/ecobag_mockup.png',
                'section' => 'categories'
            ],

            // Highlights/Services Section
            [
                'key' => 'highlight_empresariais',
                'title' => 'Destaque - Camisas Empresariais',
                'path' => 'images/camisas_empresariais.png',
                'section' => 'highlights'
            ],
            [
                'key' => 'highlight_uniformes',
                'title' => 'Destaque - Uniformes',
                'path' => 'images/uniformes.png',
                'section' => 'highlights'
            ],
            [
                'key' => 'highlight_interclasse',
                'title' => 'Destaque - Interclasse',
                'path' => 'images/interclasse.png',
                'section' => 'highlights'
            ],
            [
                'key' => 'highlight_abadas',
                'title' => 'Destaque - Abadás',
                'path' => 'images/abadas.png',
                'section' => 'highlights'
            ],
            [
                'key' => 'highlight_exclusivas',
                'title' => 'Destaque - Camisas Exclusivas',
                'path' => 'images/camisas_exclusivas.png',
                'section' => 'highlights'
            ],

            // Gallery / Portfolio / Instagram Section
            [
                'key' => 'portfolio_1',
                'title' => 'Galeria - DTF',
                'path' => 'images/dtf_mockup.png',
                'section' => 'portfolio'
            ],
            [
                'key' => 'portfolio_2',
                'title' => 'Galeria - Serigrafia',
                'path' => 'images/serigrafia_mockup.png',
                'section' => 'portfolio'
            ],
            [
                'key' => 'portfolio_3',
                'title' => 'Galeria - Sublimação',
                'path' => 'images/sublimacao_mockup.png',
                'section' => 'portfolio'
            ],
            [
                'key' => 'portfolio_4',
                'title' => 'Galeria - Exclusivas',
                'path' => 'images/camisas_exclusivas.png',
                'section' => 'portfolio'
            ],
            [
                'key' => 'portfolio_5',
                'title' => 'Galeria - Uniformes',
                'path' => 'images/uniformes.png',
                'section' => 'portfolio'
            ],
            [
                'key' => 'portfolio_6',
                'title' => 'Galeria - Ecobag',
                'path' => 'images/ecobag_mockup.png',
                'section' => 'portfolio'
            ],
            [
                'key' => 'portfolio_7',
                'title' => 'Galeria - Interclasse',
                'path' => 'images/interclasse.png',
                'section' => 'portfolio'
            ],
            [
                'key' => 'portfolio_8',
                'title' => 'Galeria - Abadás',
                'path' => 'images/abadas.png',
                'section' => 'portfolio'
            ],
        ];

        foreach ($images as $img) {
            LandingImage::updateOrCreate(['key' => $img['key']], $img);
        }
    }
}
