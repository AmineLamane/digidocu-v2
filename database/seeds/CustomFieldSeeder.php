<?php

use App\CustomField;
use Illuminate\Database\Seeder;

class CustomFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomField::create([
            'model_type' => 'tags',
            'name' => 'Code',
            'validation' => null,
            'suggestions' => ["A000","AA00","AB00","AC00","AD00","B000","BA00","BC00","BD00","C000","CA00","CB00","CC00","D000","DA00","DB00","DC00","DD00","E000","EB00","EC00","ED00","F000","G000","H000","HA00","HB00","HC00","I000","J000"]
        ]);
    }
}
