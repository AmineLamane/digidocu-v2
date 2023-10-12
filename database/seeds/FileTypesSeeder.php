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
            'name' => 'Général',
            'no_of_files' => 1,
            'labels' => 'Document1',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'name' => 'CPS',
            'no_of_files' => 1,
            'labels' => 'CPS',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'name' => 'RC',
            'no_of_files' => 1,
            'labels' => 'RC',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'name' => 'Acte d\'engagement',
            'no_of_files' => 1,
            'labels' => 'Acte d\'engagement',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'name' => 'Bordereau des prix',
            'no_of_files' => 1,
            'labels' => 'Bordereau des prix',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'name' => 'Déclaration sur l\'honneur',
            'no_of_files' => 1,
            'labels' => 'Déclaration sur l\'honneur',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'name' => 'Dossier administratif',
            'no_of_files' => 1,
            'labels' => 'Dossier administratif',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'name' => 'Offre financière',
            'no_of_files' => 1,
            'labels' => 'Offre financière',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'name' => 'Dossier technique',
            'no_of_files' => 1,
            'labels' => 'Dossier technique',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'name' => 'Décision de la commission d\'ouverture de plis',
            'no_of_files' => 1,
            'labels' => 'Décision de la commission d\'ouverture de plis',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'name' => 'Journal/Avis (AR/FR)',
            'no_of_files' => 1,
            'labels' => 'Journal/Avis (AR/FR)',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'name' => 'Estimation administrative',
            'no_of_files' => 1,
            'labels' => 'Estimation administrative',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'name' => 'Caution provisoire',
            'no_of_files' => 1,
            'labels' => 'Caution provisoire',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);

        FileType::create([
            'name' => 'Avis',
            'no_of_files' => 1,
            'labels' => 'Avis',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);

        FileType::create([
            'name' => 'PV',
            'no_of_files' => 1,
            'labels' => 'PV',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);

        FileType::create([
            'name' => 'Décision',
            'no_of_files' => 1,
            'labels' => 'Décision',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);

        FileType::create([
            'name' => 'Fax Complément',
            'no_of_files' => 1,
            'labels' => 'Fax Complément',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);

        FileType::create([
            'name' => 'Attestion main levée',
            'no_of_files' => 1,
            'labels' => 'Attestion main levée',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);

        FileType::create([
            'name' => 'Décompte de paiement',
            'no_of_files' => 1,
            'labels' => 'Décompte de paiement',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
        
        FileType::create([
            'name' => 'Ordre de seuils',
            'no_of_files' => 1,
            'labels' => 'Ordre de seuils',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);

        FileType::create([
            'name' => 'Assurances',
            'no_of_files' => 1,
            'labels' => 'Assurances',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);

        FileType::create([
            'name' => 'Engagement dépenses',
            'no_of_files' => 1,
            'labels' => 'Engagement dépenses',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);

        FileType::create([
            'name' => 'Rapport de présentation',
            'no_of_files' => 1,
            'labels' => 'Rapport de présentation',
            'file_validations' => 'mimes:jpeg,bmp,png,jpg,pdf',
            'file_maxsize' => 20,
        ]);
    }
}
