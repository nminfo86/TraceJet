<?php

namespace Database\Seeders;

use App\Models\Printer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PrinterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Printer::create(["name" => "label generator", "port" => 9100, "protocol" => "ESC", "ip_address" => "192.168.100.2", "label_size" => "20x80"]);
    }
}
