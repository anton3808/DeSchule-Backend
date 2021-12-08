<?php

namespace Modules\Study\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Entities\User;

class UserAnswers extends Model
{
    protected $fillable = ['user_id', 'lesson_id', 'lesson_element_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class, 'id', 'lesson_id');
    }

    public function lessonElement(): BelongsTo
    {
        return $this->belongsTo(LessonElement::class, 'id', 'lesson_element_id');
    }

    protected $casts = [
        'data' => 'array'
    ];
}
