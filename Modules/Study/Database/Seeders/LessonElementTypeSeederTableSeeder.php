<?php

namespace Modules\Study\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Study\Entities\LessonElementType;

class LessonElementTypeSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (LessonElementType::$typeSlugs as $typeSlug) {
            $lessonElementType = LessonElementType::whereSlug($typeSlug)->first();

            if (!$lessonElementType) {
                $lessonElementType = new LessonElementType();
            }

            $lessonElementType->slug = $typeSlug;

            foreach (config('locales') as $locale) {
                $lessonElementType->translateOrNew($locale)->title = trans("orchid.models.lesson_element_types.slugs.$typeSlug.title");
                $lessonElementType->translateOrNew($locale)->description = trans("orchid.models.lesson_element_types.slugs.$typeSlug.description");
            }

            $lessonElementType->save();
        }
    }
}
