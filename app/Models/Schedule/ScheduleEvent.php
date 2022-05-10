<?php

namespace App\Models\Schedule;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Screen\AsSource;
use Modules\Study\Entities\Lesson;

class ScheduleEvent extends Model
{
    use AsSource;

    protected $table = 'schedule_events';

    protected $fillable = ['event_type_id', 'user_id', 'title', 'description', 'link_id', 'date'];

    public function type()
    {
        return $this->belongsTo(ScheduleEventType::class, 'event_type_id', 'id');
    }

    public function link(): HasOne
    {
        switch ($this->eventType->slug) {
            case 'lesson':
                return $this->hasOne(Lesson::class, 'id', 'link_id');
            default:
                return $this->hasOne(null, 'id', 'link_id');
        }
    }
}
