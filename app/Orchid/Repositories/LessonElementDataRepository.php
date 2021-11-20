<?php

namespace App\Orchid\Repositories;

use Modules\Study\Entities\Dictionary\Word;
use Modules\Study\Transformers\Dictionary\Word\WordResource;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Throwable;
use Orchid\Screen\Repository;

class LessonElementDataRepository
{
    public static function ReadAndTranslateLayout(?array $data = []): array
    {
        $videoLayout = [];
        if (array_key_exists('video', $data)) {
            array_push($videoLayout, Link::make(__('orchid.models.lesson_element_types.previously_video'))->href($data['video']));
        }
        array_push($videoLayout,
            Input::make('data.video')
                ->type('file')
                ->title(__('orchid.models.lesson_element_types.video'))
                ->set('accept', 'video/*')
                ->class('form-control mw-100')
        );
        return [
            Quill::make("data.text")
                ->toolbar(['text', 'color', 'quote', 'header', 'list', 'format'])
                ->set('rows', 10)
                ->value(array_key_exists('text', $data) ? $data['text'] : '')
                ->title(__('orchid.models.lesson_element_types.text'))
                ->required()
                ->class('form-control mw-100'),
            Group::make([
                Cropper::make('data.image')
                    ->value(array_key_exists('image', $data) ? $data['image'] : null)
                    ->title(__('orchid.models.lesson_element_types.image'))
                    ->placeholder(__('orchid.models.lesson_element_types.image'))
                    ->storage('study'),
            ]),
            Group::make($videoLayout)->alignCenter()
        ];
    }

    /**
     * @throws Throwable
     */
    public static function ReadAndInsertLayout(?array $data = null): array
    {
        return [
            'component'  => 'text-insert',
            'attributes' => [
                'words'         => WordResource::collection(Word::all()),
                'selectedWords' => array_key_exists('words', $data) ? $data['words'] : null
            ],
            'vHtml'      => view('orchid.layouts.base-layout', [
                'layouts' => self::RenderFieldsetLayout([
                    Quill::make('data.text')
                        ->toolbar(['text', 'color', 'quote', 'header', 'list', 'format'])
                        ->set('rows', 10)
                        ->value(array_key_exists('text', $data) ? $data['text'] : '')
                        ->title(__('orchid.models.lesson_element_types.text'))
                        ->required()
                        ->class('form-control mw-100'),
                ])
            ])->render()
        ];
    }

    /**
     * @throws Throwable
     */
    public static function ReadAndAnswerLayout(?array $data = []): array
    {
        return [
            'component'  => 'text-multiply',
            'attributes' => [
                'translations'        => [
                    'question' => __('orchid.models.lesson_element_types.question'),
                    'answer'   => __('orchid.models.lesson_element_types.answer'),
                ],
                'actionsTranslations' => [
                    'add_question'    => __('orchid.actions.add_item', ['item' => mb_strtolower(__('orchid.models.lesson_element_types.question'))]),
                    'remove_question' => __('orchid.actions.remove_item', ['item' => mb_strtolower(__('orchid.models.lesson_element_types.question'))]),
                    'add_answer'      => __('orchid.actions.add_item', ['item' => mb_strtolower(__('orchid.models.lesson_element_types.answer'))]),
                    'remove_answer'   => __('orchid.actions.remove_item', ['item' => mb_strtolower(__('orchid.models.lesson_element_types.answer'))]),
                ],
                'dataQuestions'       => array_key_exists('questions', $data) ? $data['questions'] : null
            ],
            'vHtml'      => view('orchid.layouts.base-layout', [
                'layouts' => self::RenderFieldsetLayout([
                    Quill::make('data.text')
                        ->toolbar(['text', 'color', 'quote', 'header', 'list', 'format'])
                        ->set('rows', 10)
                        ->value(array_key_exists('text', $data) ? $data['text'] : '')
                        ->title(__('orchid.models.lesson_element_types.text'))
                        ->required()
                        ->class('form-control mw-100'),
                ])
            ])->render()
        ];
    }

    /**
     * @throws Throwable
     */
    private static function RenderFieldsetLayout($elements = []): string
    {
        return view('orchid.layouts.base-layout', [
            'layouts' => LayoutFacade::rows($elements)->build(new Repository())
        ])->render();
    }
}
