<?php

namespace Database\Seeders;

use App\Models\Of;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payload = [
            "caliber_id" => 1,
            "of_number" => "001",
            "of_name" => "nameof1",
            "status" => "new",
            "quantity" => 4,
            "new_quantity" => 4
        ];
        Of::create($payload);
    }
}
