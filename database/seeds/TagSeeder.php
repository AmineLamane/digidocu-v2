<?php

use App\Tag;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tag = Tag::create([
            'name' => 'Division support et finance (DSF)',
            'color' => '#0011ff',
            'created_by' => 1,
            'custom_fields' => ["Code" =>"E000"],
        ]);
        $parent_id = $tag->id;
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service financier (SF)',
            'color' => '#0011ff',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "ED00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service logistique (SL)',
            'color' => '#0011ff',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "EC00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service gestion des ressources humaines (SGRH)',
            'color' => '#0011ff',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "EB00"],
        ]);
        
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Division protection sociale des agriculteurs (DPSA)',
            'color' => '#d980f9',
            'created_by' => 1,
            'custom_fields' => ["Code" => "H000"],
        ]);

        $parent_id = $tag->id;
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service des études de la programmation et de suivi Errachidia (DPSA/SEPS)',
            'color' => '#d980f9',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "HA00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service de protection sociale (DPSA/SPS)',
            'color' => '#d980f9',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "HB00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service des systèmes d\'information (SSI)',
            'color' => '#d980f9',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "HC00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Direction provinciale de l\'agriculture de Midelt (DPA)',
            'color' => '#c2c2c2',
            'created_by' => 1,
            'custom_fields' => ["Code" => "F000"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Division partenariat &  appui au développement (DPAD)',
            'color' => '#00bfff',
            'created_by' => 1,
            'custom_fields' => ["Code" => "D000"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $parent_id = $tag->id;

        $tag = Tag::create([
            'name' => 'Service  aides & incitations (SAI)',
            'color' => '#00bfff',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "DA00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service  relation avec chambres agricoles & opa  (SRCAOPA)',
            'color' => '#00bfff',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "DB00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service développement espace agricole et zones montagneuses (SDEZM)',
            'color' => '#00bfff',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "DC00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service  enseignement technique, formation professionnelle, rd  (SETFPRD)',
            'color' => '#00bfff',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "DD00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Division irrigation & aménagement espace agricole (DIAEA)',
            'color' => '#e0ec36',
            'created_by' => 1,
            'custom_fields' => ["Code" => "C000"],
        ]);
        
        $parent_id = $tag->id;
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service ressources hydro-agricoles (SRHA)',
            'color' => '#e0ec36',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "CA00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service aménagements (SA)',
            'color' => '#e0ec36',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "CB00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service promotion & régulation ppp irrigation (SPRPPPI)',
            'color' => '#e0ec36',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "CC00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Division développement filières agricoles (DDFA)',
            'color' => '#bf70ff',
            'created_by' => 1,
            'custom_fields' => ["Code" => "B000"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $parent_id = $tag->id;

        $tag = Tag::create([
            'name' => 'Service filières à haute valeur ajoutée (SFAHVA)',
            'color' => '#bf70ff',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "BA00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service filières production végetale (SPV)',
            'color' => '#bf70ff',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "BB00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service filières production animale (SPA)',
            'color' => '#bf70ff',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "BC00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service produits de terroir (SPT)',
            'color' => '#bf70ff',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "BD00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Direction',
            'color' => '#0aff01',
            'created_by' => 1,
            'custom_fields' => ["Code" => "A000"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $parent_id = $tag->id;

        $tag = Tag::create([
            'name' => 'Secrétariat et bureau d\'ordre',
            'color' => '#00ff00',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "AA00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service coordination avec l\'ada (scada)',
            'color' => '#00ff00',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "AB00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service contrôle de gestion (SCG)',
            'color' => '#00ff00',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "AC00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Service communication & promotion  (SCP)',
            'color' => '#00ff00',
            'created_by' => 1,
            'parent_id' => $parent_id,
            'custom_fields' => ["Code" => "AD00"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Antenne des statistiques ouarzazate (AS)',
            'color' => '#f26363',
            'created_by' => 1,
            'custom_fields' => ["Code" => "I000"],
        ]);
        
        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        $tag = Tag::create([
            'name' => 'Centre de qualification agricole kelaa megouna (CQA)',
            'color' => '#e58f3e',
            'created_by' => 1,
            'custom_fields' => ["Code" => "J000"],
        ]);

        foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
            Permission::create(['name' => $perm_key . $tag->id]);
        }

        // $tag = Tag::create([
        //     'name' => 'Marché',
        //     'color' => '#0084ff',
        //     'created_by' => 1,
        // ]);

        // foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
        //     Permission::create(['name' => $perm_key . $tag->id]);
        // }

        // $tag = Tag::create([
        //     'name' => 'Appel d\'offre',
        //     'color' => '#ff0000',
        //     'created_by' => 1,
        // ]);

        // foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
        //     Permission::create(['name' => $perm_key . $tag->id]);
        // }

        // $tag = Tag::create([
        //     'name' => 'Bon de commande',
        //     'color' => '#c123fb',
        //     'created_by' => 1,
        // ]);

        // foreach (config('constants.TAG_LEVEL_PERMISSIONS') as $perm_key => $perm) {
        //     Permission::create(['name' => $perm_key . $tag->id]);
        // }
    }
}
