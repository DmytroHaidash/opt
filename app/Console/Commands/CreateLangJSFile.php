<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class CreateLangJSFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:js';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates an js file with translations';

    protected $translations;

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
     * @return mixed
     */
    public function handle()
    {
        foreach (config('translatable.locales') as $locale) {
            $location = resource_path('lang/' . $locale);
            $translates = array_map(function ($item) use ($location) {
                return $location . '/' . $item . '.php';
            }, config('translatable.i18n'));

            $this->translations[$locale] = collect(File::allFiles($location))
                ->filter(function ($path) use ($translates) {
                    return in_array($path, $translates);
                })->flatMap(function ($file) use ($locale) {
                    $translation = $file->getBasename('.php');

                    return [
                        $translation => trans($translation, [], $locale),
                    ];
                })->toArray();
        }

        $file = ';window.i18n = ' . json_encode($this->translations, JSON_UNESCAPED_UNICODE) . ';';

        file_put_contents(public_path('js/i18n.js'), $file);
    }
}
