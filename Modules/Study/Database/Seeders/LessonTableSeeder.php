<?php

namespace Modules\Study\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Study\Entities\Lesson;
use Modules\Study\Entities\LessonElement;
use Modules\Study\Entities\LessonElementType;
use Modules\Study\Entities\Level;

class LessonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('APP_ENV') === 'local') {
            $levelCodes = ['A', 'B', 'C', 'D'];

            foreach ($levelCodes as $index => $code) {
                $level = Level::whereCode($code)->orWhere('priority', $index + 1)->firstOrNew([
                    'priority' => $index + 1,
                    'code'     => "$code" . ($index + 1)
                ]);
                foreach (config('locales') as $locale) {
                    $level->translateOrNew($locale)->title = "$code" . ($index + 1);
                }
                $level->save();

                foreach (LessonElementType::all() as $letIndex => $type) {
                    $lesson = new Lesson([
                        'order'    => $letIndex + 1,
                        'level_id' => $level->id
                    ]);

                    foreach (config('locales') as $locale) {
                        $lesson->translateOrNew($locale)->title = $level->code . ' lesson #' . ($letIndex + 1);
                    }

                    $lesson->save();

                    $lessonElement = new LessonElement([
                        'element_type_id' => $type->id,
                        'data'            => []
                    ]);
                    foreach (config('locales') as $locale) {
                        $lessonElement->translateOrNew($locale)->title = $type->translate($locale)->title;
                        $lessonElement->translateOrNew($locale)->description = $type->translate($locale)->description;
                    }
                    $lessonElement->save();

                    $lesson->elements()->attach($lessonElement->id);
                }
            }
        }
    }
}
