<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sections = [
            ["section_code" => "D", "section_name" => 'Connecteur'],
            ["section_code" => "R", "section_name" => 'Relais'],
            ["section_code" => "C", "section_name" => 'Compteur'],

        ];
        foreach ($sections as $section) {
            Section::create($section);
        }
    }
}
