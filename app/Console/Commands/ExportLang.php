<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ExportLang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export Language full.json to laravel way locale files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Loading Translations from " . resource_path("lang/full.json"));
        $translations = json_decode(\Illuminate\Support\Facades\File::get(resource_path("lang/full.json")));
        $this->info("Preparing data for further processing");
        $english = [];
        $bengali = [];
        foreach ($translations as $key => $def) {
            $english[$key] = $def->en;
            $bengali[$key] = $def->bn;
        }
        $this->info("Exporting English Translations to " . resource_path("lang/en.json"));
        $this->info("\nExporting Bengali Translations to " . resource_path("lang/bn.json"));
        File::put(resource_path("lang/en.json"), json_encode($english, JSON_PRETTY_PRINT));
        File::put(resource_path("lang/bn.json"), json_encode($bengali, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        $this->info("Exporting Languages is successfully completed");
        return 0;
    }
}
