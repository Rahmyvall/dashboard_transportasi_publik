<?php

namespace Database\Seeders;

use App\Models\TransportMode;
use Illuminate\Database\Seeder;

class TransportModeSeeder extends Seeder
{
    public function run(): void
    {
        $transportModes = [
            [
                'mode_code' => 'ROAD',
                'mode_name' => 'Transportasi Darat',
                'description' => 'Moda transportasi melalui jalur darat.',
            ],
            [
                'mode_code' => 'RAIL',
                'mode_name' => 'Transportasi Kereta Api',
                'description' => 'Moda transportasi menggunakan kereta api.',
            ],
            [
                'mode_code' => 'SEA',
                'mode_name' => 'Transportasi Laut',
                'description' => 'Moda transportasi melalui jalur laut.',
            ],
            [
                'mode_code' => 'AIR',
                'mode_name' => 'Transportasi Udara',
                'description' => 'Moda transportasi melalui jalur udara.',
            ],
            [
                'mode_code' => 'RIVER',
                'mode_name' => 'Transportasi Sungai',
                'description' => 'Moda transportasi melalui sungai atau perairan darat.',
            ],
        ];

        foreach ($transportModes as $transportMode) {
            TransportMode::updateOrCreate(
                [
                    'mode_code' => $transportMode['mode_code'],
                ],
                $transportMode
            );
        }
    }
}
