<?php

use App\FileType;
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
        FileType::create([
            'id' => 1,
            'name' => 'Général',
            'no_of_files' => 1,
            'labels' => 'Document1',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'id' => 2,
            'name' => 'CPS',
            'no_of_files' => 1,
            'labels' => 'CPS',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'id' => 3,
            'name' => 'RC',
            'no_of_files' => 1,
            'labels' => 'RC',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'id' => 4,
            'name' => 'Acte d\'engagement',
            'no_of_files' => 1,
            'labels' => 'Acte d\'engagement',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'id' => 5,
            'name' => 'Bordereau des prix',
            'no_of_files' => 1,
            'labels' => 'Bordereau des prix',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'id' => 6,
            'name' => 'Déclaration sur l\'honneur',
            'no_of_files' => 1,
            'labels' => 'Déclaration sur l\'honneur',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'id' => 7,
            'name' => 'Dossier administratif',
            'no_of_files' => 1,
            'labels' => 'Dossier administratif',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'id' => 8,
            'name' => 'Offre financière',
            'no_of_files' => 1,
            'labels' => 'Offre financière',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'id' => 9,
            'name' => 'Dossier technique',
            'no_of_files' => 1,
            'labels' => 'Dossier technique',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'id' => 10,
            'name' => 'Décision de la commission d\'ouverture de plis',
            'no_of_files' => 1,
            'labels' => 'Décision de la commission d\'ouverture de plis',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'id' => 11,
            'name' => 'Journal/Avis (AR/FR)',
            'no_of_files' => 1,
            'labels' => 'Journal/Avis (AR/FR)',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'id' => 12,
            'name' => 'Estimation administrative',
            'no_of_files' => 1,
            'labels' => 'Estimation administrative',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'id' => 13,
            'name' => 'Caution provisoire',
            'no_of_files' => 1,
            'labels' => 'Caution provisoire',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
    }
}
