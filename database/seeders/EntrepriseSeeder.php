<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entreprise;

class EntrepriseSeeder extends Seeder
{
    public function run(): void
    {
        Entreprise::create([
            'nom' => 'Coride',
            'ville' => 'Casablanca',
            'adresse' => 'Centre-ville',
            'telephone' => '0522000001',
            'email' => 'contact@coride.ma',
        ]);

        Entreprise::create([
            'nom' => 'TechMove',
            'ville' => 'Rabat',
            'adresse' => 'Agdal',
            'telephone' => '0537000002',
            'email' => 'contact@techmove.ma',
        ]);

        Entreprise::create([
            'nom' => 'SmartRide',
            'ville' => 'Marrakech',
            'adresse' => 'Guéliz',
            'telephone' => '0524000003',
            'email' => 'contact@smartride.ma',
        ]);

        Entreprise::create([
            'nom' => 'GreenWay',
            'ville' => 'Fès',
            'adresse' => 'Centre',
            'telephone' => '0535000004',
            'email' => 'contact@greenway.ma',
        ]);

        Entreprise::create([
            'nom' => 'EcoTransport',
            'ville' => 'Tanger',
            'adresse' => 'Malabata',
            'telephone' => '0539000005',
            'email' => 'contact@ecotransport.ma',
        ]);
    }
}
