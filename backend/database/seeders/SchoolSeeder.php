<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        School::firstOrCreate(
            ['slug' => 'sunrise-academy'],
            [
                'name' => 'Sunrise Academy',
                'currency' => 'ETB',
                'vat_rate' => 15.00,
                'service_charge_rate' => 10.00,
                'phone' => '+251911234567',
                'email' => 'info@sunrise.et',
                'address' => 'Addis Ababa, Bole',
                'is_active' => true,
            ]
        );

        $this->command->info('✅ School created or already exists!');
    }
}
