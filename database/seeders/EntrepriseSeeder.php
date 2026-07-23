<?php

namespace Database\Seeders;

use App\Models\Entreprise;
use Illuminate\Database\Seeder;

class EntrepriseSeeder extends Seeder
{
    /**
     * Les 5 entreprises partenaires clientes de MobiliTech (cf. cahier des charges).
     */
    public function run(): void
    {
        $entreprises = [
            [
                'nom' => 'MobiliTech',
                'ville' => 'Casablanca',
                'adresse' => 'Twin Center, Boulevard Zerktouni',
                'telephone' => '0522000001',
                'email' => 'contact@mobilitech.ma',
            ],
            [
                'nom' => 'NextBuild',
                'ville' => 'Rabat',
                'adresse' => 'Avenue Annakhil, Hay Riad',
                'telephone' => '0537000002',
                'email' => 'contact@nextbuild.ma',
            ],
            [
                'nom' => 'Atlas Digital',
                'ville' => 'Marrakech',
                'adresse' => 'Route de l\'Aéroport, Guéliz',
                'telephone' => '0524000003',
                'email' => 'contact@atlasdigital.ma',
            ],
            [
                'nom' => 'GreenLogix',
                'ville' => 'Tanger',
                'adresse' => 'Zone Franche, Tanger Free Zone',
                'telephone' => '0539000004',
                'email' => 'contact@greenlogix.ma',
            ],
            [
                'nom' => 'Kandia Solutions',
                'ville' => 'Fès',
                'adresse' => 'Route de Sefrou, Zone Industrielle',
                'telephone' => '0535000005',
                'email' => 'contact@kandiasolutions.ma',
            ],
        ];

        foreach ($entreprises as $entreprise) {
            Entreprise::updateOrCreate(
                ['nom' => $entreprise['nom']],
                $entreprise
            );
        }
    }
}
