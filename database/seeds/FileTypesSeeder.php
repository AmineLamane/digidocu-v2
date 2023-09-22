<?php

use Illuminate\Database\Seeder;

class FileTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\FileType::create([
            'name' => 'Général',
            'no_of_files' => 1,
            'labels' => 'doc1',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 8
        ]);
    }
}
