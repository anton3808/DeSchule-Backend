<?php


namespace Modules\Study\Services;

use Illuminate\Support\Facades\DB;
use Modules\Study\Entities\LessonElement;

class UserAnswersProcessingService
{
    /**
     * @throws \Exception
     */
    public function processAnswers(LessonElement $lessonElement, array $answers): array
    {
        $method = ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $lessonElement->elementType->slug))));
        if (method_exists(self::class, $method)) {
            return $this->$method($lessonElement->data, $answers);
        }
        throw new \Exception('There is no supported processing answers method.');
    }

    /**
     * @throws \Exception
     */
    private function TranslateWords(array $data, array $answers): array
    {
        $validator = [];
        $words = $data['words'];
        $models = DB::table('word_translations')->whereIn('word_id', array_values($words))->where('locale', app()->getLocale())->get(['word_id', 'word_translation']);
        foreach ($words as $index => $wordID) {
            $translation = $models->where('word_id', (int)$wordID)->first();
            if (!$translation) {
                throw new \Exception('No associated word translation has been found.');
            }
            // is provided word in lowercase same as word translation in lowercase in current locale
            array_push($validator, ['index' => $index, 'result' => strtolower($answers[$index]) === strtolower($translation->word_translation)]);
        }
        return $validator;
    }

    private function WatchVideoAndAnswer(array $data, array $answers): array
    {
        $questions = $data['questions'];
        $validator = [];
        foreach ($questions as $index => $question) {
            // is provided answer in array of available question answers
            array_push($validator, ['index' => $index, 'result' => in_array($answers[$index], $question['answers'])]);
        }
        return $validator;
    }

    private function ReadAndAnswer(array $data, array $answers): array
    {
        $questions = $data['questions'];
        $validator = [];
        foreach ($questions as $index => $question) {
            // is provided answer in array of available question answers
            array_push($validator, ['index' => $index, 'result' => in_array($answers[$index], $question['answers'])]);
        }
        return $validator;
    }

    private function ReadAndTranslate(array $questions, array $answers): array
    {
        return [];
    }

    /**
     * @throws \Exception
     */
    private function ReadAndInsert(array $data, array $answers): array
    {
        $words = $data['words'];
        $validator = [];
        $models = DB::table('word_translations')->whereIn('word_id', array_values($words))->where('locale', app()->getLocale())->get(['word_id', 'word_translation']);
        foreach ($words as $index => $wordID) {
            $translation = $models->where('word_id', (int)$wordID)->first();
            if (!$translation) {
                throw new \Exception('No associated word translation has been found.');
            }
            $i = (int)str_replace('#', '', $index) - 1;
            // is provided word in lowercase same as word translation in lowercase in current locale
            array_push($validator, ['index' => $i, 'result' => strtolower($answers[$i]) === strtolower($translation->word_translation)]);
        }
        return $validator;
    }
}
