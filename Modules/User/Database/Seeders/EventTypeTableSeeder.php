<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Schedule\ScheduleEventType;

class EventTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (__('event_types') as $slug => $type) {
            $eventType = ScheduleEventType::whereSlug($slug)->firstOrCreate(['slug' => $slug]);
            foreach (config('locales') as $locale) {
                $eventType->translateOrNew($locale)->title = trans('event_types', [], $locale)[$slug];
            }
            $eventType->save();
        }
    }
}
