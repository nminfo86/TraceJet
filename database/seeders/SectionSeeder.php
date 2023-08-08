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
            // ["section_code" => "S02", "section_name" => 'MEI'],
            // ["section_code" => "S03", "section_name" => 'SNS'],

        ];
        foreach ($sections as $section) {
            Section::create($section);
        }
    }
}
