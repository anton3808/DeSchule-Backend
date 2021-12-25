<?php

namespace Modules\Study\Rules\UserAnswer;

use Illuminate\Contracts\Validation\Rule;
use Modules\Study\Entities\LessonElement;
use Modules\Study\Entities\LessonElementType;

class UserAnswerDataRule implements Rule
{
    /**
     * @var LessonElement $lessonElement
     */
    private $lessonElement;

    /**
     * @var string $message
     */
    private $message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $lessonElementID)
    {
        $this->lessonElement = LessonElement::whereId($lessonElementID)->with(['elementType'])->first();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (!$this->lessonElement->exists) {
            return false;
        }

        $types = LessonElementType::$typeSlugs;
        $count = 0;
        switch ($this->lessonElement->elementType->slug) {
            case $types[0]: // read and translate
                return true;

            case $types[1]: // read and insert
                $count = count($this->lessonElement->data['words']);
                break;

            case $types[2]: // read and answer
                $count = count($this->lessonElement->data['questions']);
                break;

            case $types[3]: // translate words
                $count = count($this->lessonElement->data['words']);
                break;

            case $types[4]: // watch video and answer
                $count = count($this->lessonElement->data['questions']);
                break;

            default:
                $this->message = __('validation.required', ['attribute' => 'data']);
                return false;
        }

        $this->message = __("validation.user_answer.types." . $this->lessonElement->elementType->slug, ['count' => $count]);
        return is_array($value) && count($value) === $count;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }
}
