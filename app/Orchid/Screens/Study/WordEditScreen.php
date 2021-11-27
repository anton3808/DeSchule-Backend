<?php

namespace App\Orchid\Screens\Study;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Study\Entities\Dictionary\Word;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout as LayoutFacade;
use Orchid\Support\Facades\Toast;

class WordEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'WordEditScreen';

    /**
     * @var bool
     */
    public bool $exists = false;

    private ?Word $word;

    /**
     * Permissions for this screen
     *
     * @var array|string
     */
    public $permission = [
        'study.dictionary'
    ];

    /**
     * Query data.
     *
     * @param Word $word
     * @return array
     */
    public function query(Word $word): array
    {
        $this->exists = $word->exists;

        if ($this->exists) {
            $this->word = $word;
            $this->name = __('orchid.pages.word.update');
        } else {
            $this->name = __('orchid.pages.word.create');
        }

        return $word->getAttributes();
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make(__('orchid.links.create'))
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),
            Button::make(__('orchid.links.update'))
                ->icon('save')
                ->method('createOrUpdate')
                ->canSee($this->exists),
            Button::make(__('orchid.links.delete'))
                ->icon('trash')
                ->method('remove')
                ->canSee($this->exists)
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]|string[]
     */
    public function layout(): array
    {
        $translations = [];
        foreach (config('locales') as $locale) {
            $input = Input::make("word_translation.$locale")
                ->title(__('orchid.models.word.word_translation') . " ($locale)")
                ->required()
                ->placeholder(__('orchid.models.word.word_translation'))
                ->class('form-control mw-100');
            if ($this->exists) {
                $input->value($this->word->getTranslation($locale)->word_translation);
            }
            array_push($translations, $input);

            $input = TextArea::make("word_description_translation.$locale")
                ->title(__('orchid.models.word.word_description_translation') . " ($locale)")
                ->required()
                ->placeholder(__('orchid.models.word.word_description_translation'))
                ->class('form-control mw-100');
            if ($this->exists) {
                $input->value($this->word->getTranslation($locale)->word_description_translation);
            }
            array_push($translations, $input);
        }
        return [
            LayoutFacade::rows(array_merge(
                [
                    Input::make('word')
                        ->required()
                        ->title(__('orchid.models.word.word'))
                        ->placeholder(__('orchid.models.word.word'))
                        ->class('form-control mw-100'),
                    TextArea::make('description')
                        ->required()
                        ->title(__('orchid.models.word.description'))
                        ->placeholder(__('orchid.models.word.description'))
                        ->class('form-control mw-100'),
                ], $translations, [
                    Cropper::make('image')
                        ->title(__('orchid.models.word.image'))
                        ->placeholder(__('orchid.models.word.image'))
                        ->storage('study'),
                ]
            ))
        ];
    }

    public function createOrUpdate(Word $word, Request $request): RedirectResponse
    {
        $request->validate([
            'word'                           => ['required', 'string'],
            'description'                    => ['required', 'string'],
            'word_translation.*'             => 'string',
            'word_description_translation.*' => 'string',
        ]);

        foreach (config('locales') as $locale) {
            $word->translateOrNew($locale)->word_translation = $request->get('word_translation')[$locale];
            $word->translateOrNew($locale)->word_description_translation = $request->get('word_description_translation')[$locale];
        }

        $word->fill($request->except(['word_translation', 'word_description_translation']));

        $word->save();

        Toast::info(__('orchid.toasts.actions.saved'));

        return redirect()->route('platform.study.dictionary.words.edit', ['word' => $word->id]);
    }

    /**
     * @param Word $word
     * @return RedirectResponse
     */
    public function remove(Word $word): RedirectResponse
    {
        $word->delete();

        Alert::info(__('orchid.toasts.actions.deleted'));

        return redirect()->route('platform.study.dictionary.words.index');
    }
}
