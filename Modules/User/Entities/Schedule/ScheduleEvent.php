<?php

namespace Modules\User\Entities\Schedule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Study\Entities\Lesson;
use Modules\Study\Transformers\Lesson\LessonResource;
use Modules\User\Entities\User;

class ScheduleEvent extends Model
{
    protected $fillable = ['event_type_id', 'user_id', 'title', 'description', 'link_id', 'date'];

    public function eventType(): BelongsTo
    {
        return $this->belongsTo(ScheduleEventType::class, 'event_type_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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

    public function getLinkResourceAttribute(): ?JsonResource
    {
        switch ($this->eventType->slug) {
            case 'lesson':
                return LessonResource::make($this->link);
            default:
                return null;
        }
    }

    protected $casts = [
        'date' => 'datetime'
    ];
}
