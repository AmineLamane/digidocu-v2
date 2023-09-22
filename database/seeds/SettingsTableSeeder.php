<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Setting::create(['name'=>'system_title','value'=>'Archive DRA-DT']);
        \App\Setting::create(['name'=>'system_logo','value'=>'logo.png']);

        \App\Setting::create(['name'=>'tags_label_singular','value'=>'service']);
        \App\Setting::create(['name'=>'tags_label_plural','value'=>'services']);

        \App\Setting::create(['name'=>'document_label_singular','value'=>'dossir']);
        \App\Setting::create(['name'=>'document_label_plural','value'=>'dossiers']);

        \App\Setting::create(['name'=>'file_label_singular','value'=>'document']);
        \App\Setting::create(['name'=>'file_label_plural','value'=>'documents']);

        \App\Setting::create(['name'=>'default_file_validations','value'=>'mimes:jpeg,bmp,png,jpg']);
        \App\Setting::create(['name'=>'default_file_maxsize','value'=>'8']);

        \App\Setting::create(['name'=>'image_files_resize','value'=>'300,500,700']);

        \App\Setting::create(['name'=>'show_missing_files_errors','value'=>'false']);
    }
}
