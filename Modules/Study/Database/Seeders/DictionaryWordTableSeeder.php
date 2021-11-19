<?php

namespace Modules\Study\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Study\Entities\Dictionary\Word;

class DictionaryWordTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (__('dictionary.words') as $key => $word) {
            $word = Word::whereWord($key)->firstOrNew();
            $word->word = $key;
            $word->description = __("dictionary.words.$key.description");
            foreach (config('locales') as $locale) {
                $word->getTranslationOrNew($locale)->word_translation = __("dictionary.words.$key.translation", [], $locale);
                $word->getTranslationOrNew($locale)->word_description_translation = __("dictionary.words.$key.description_translation", [], $locale);
            }
            $word->save();
        }
        if(env('APP_DEBUG')) {
            for ($i = 0; $i < 100; $i++) {
                $key = \Str::random(5);
                $word = Word::whereWord($key)->firstOrNew();
                $word->word = $key;
                $word->description = "$key-description";
                foreach (config('locales') as $locale) {
                    $word->getTranslationOrNew($locale)->word_translation = __("$key-translation-$locale", [], $locale);
                    $word->getTranslationOrNew($locale)->word_description_translation = __("$key-description_translation-$locale", [], $locale);
                }
                $word->save();
            }
        }
    }
}
