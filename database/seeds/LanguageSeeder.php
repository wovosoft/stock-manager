<?php

use App\Models\LanguageDefinition;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $translations = json_decode(\Illuminate\Support\Facades\File::get(resource_path("lang/full.json")));

        $english = new \App\Models\Language();
        $english->name = "English";
        $english->description = "English Lanuage";
        $english->saveOrFail();

        $bengali = new \App\Models\Language();
        $bengali->name = "Bengali";
        $bengali->description = "Bengali Lanuage";
        $bengali->saveOrFail();
        $en = [];
        $bn = [];
        foreach ($translations as $key => $value) {
            $en[] = [
                "language_id" => $english->id,
                "key" => $key,
                "value" => $value->en,
                "is_system" => true
            ];
            $bn[] = [
                "language_id" => $bengali->id,
                "key" => $key,
                "value" => $value->bn,
                "is_system" => true
            ];
//            $en_def = new \App\Models\LanguageDefinition();
//            $en_def->language_id = $english->id;
//            $en_def->key = $key;
//            $en_def->value = $value->en;
//            $en_def->is_system = true;
//            $en_def->saveOrFail();
//

//            $bd_def = new \App\Models\LanguageDefinition();
//            $bd_def->language_id = $bengali->id;
//            $bd_def->key = $key;
//            $bd_def->value = $value->bn;
//            $bd_def->is_system = true;
//            $bd_def->saveOrFail();
        }
        LanguageDefinition::query()->insert($en);
        LanguageDefinition::query()->insert($bn);
    }
}
