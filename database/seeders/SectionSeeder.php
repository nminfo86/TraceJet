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
            ["section_code" => "S01", "section_name" => 'Contacteur'],
            ["section_code" => "S02", "section_name" => 'Discontacteur'],
            ["section_code" => "S03", "section_name" => 'Relais'],

        ];
        foreach ($sections as $section) {
            Section::create($section);
        }
    }
}
