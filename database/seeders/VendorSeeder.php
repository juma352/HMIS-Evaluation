<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Vendor::create(['name' => 'Intellisoft']);
        \App\Models\Vendor::create(['name' => 'SmartLink']);
        \App\Models\Vendor::create(['name' => 'EwareMD']);
        \App\Models\Vendor::create(['name' => 'Helium']);
        \App\Models\Vendor::create(['name' => 'ITDase']);
        \App\Models\Vendor::create(['name' => 'Medbook']);
        \App\Models\Vendor::create(['name' => 'Medinous']);
        \App\Models\Vendor::create(['name' => 'Jetbase']);
        \App\Models\Vendor::create(['name' => 'Sanitas']);
    }
}
