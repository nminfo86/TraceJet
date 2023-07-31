<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = ['name' => 'UFMEEG', 'address' => 'Route Batna', 'email' => 'ufmeeg@enamc.dz', 'phone' => '0773142654', 'fax' => '036480012'];
        Setting::create($company);
    }
}
