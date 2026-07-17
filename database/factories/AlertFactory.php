<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class AlertFactory extends Factory
{

    public function definition(): array
    {
        return [

            'title' => fake()
                ->sentence(5),

            'message' => fake()
                ->paragraph(),

            'alert_type' => fake()
                ->randomElement([
                    'delay',
                    'diversion',
                    'service_stop',
                    'crowded',
                    'emergency',
                    'info',
                ]),

            'priority' => fake()
                ->randomElement([
                    'low',
                    'medium',
                    'high',
                    'critical',
                ]),

            'is_published' => fake()
                ->boolean(80),

            'published_at' => now(),

            'expired_at' => fake()
                ->optional()
                ->dateTimeBetween(
                    'now',
                    '+7 days'
                ),

        ];
    }
}
