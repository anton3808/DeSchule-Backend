<template>
    <div ref="domWrapper">
        <slot></slot>
        <div class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column">

            <div class="d-flex flex-row mb-2 justify-content-end align-items-center">
                <button
                    type="button"
                    @click="pushQuestion"
                    data-controller="button"
                    class="btn btn-success"
                    :data-turbo="true">
                    {{ actionsTranslations.add_question }}
                </button>
            </div>

            <div class="form-group pb-2" :class="{'border-bottom': index !== questions.length - 1}"
                 v-for="(question, index) in questions">
                <label :for="`data-question-${index}-question`" class="form-label">{{ translations.question }}
                    #{{ index + 1 }}<sup class="text-danger">*</sup></label>
                <div data-controller="input" data-input-mask class="d-flex flex-row justify-content-evenly align-items-center">
                    <input :name="`data[questions][${index}][question]`" :title="translations.question"
                           required="required" :placeholder="translations.question"
                           :value="question.question"
                           @change="e => questions[index].question = e.target.value"
                           :id="`data-question-${index}-question`"
                           class="form-control mw-100">

                    <button
                        type="button"
                        @click="() => removeQuestion(index)"
                        data-controller="button"
                        class="btn btn-danger ms-2 text-center"
                        style="min-width: 150px;"
                        :data-turbo="true">
                        {{ actionsTranslations.remove_question }}
                    </button>
                </div>

                <div class="my-1" v-for="(answer, answerIndex) in question.answers">
                    <label :for="`data-question-${index}-question-answer-${answerIndex}`"
                           class="form-label">{{ translations.answer }} #{{ answerIndex + 1 }}<sup
                        class="text-danger">*</sup></label>
                    <div data-controller="input" data-input-mask class="d-flex flex-row justify-content-evenly align-items-center">
                        <input :name="`data[questions][${index}][answers][${answerIndex}]`" :title="translations.answer"
                               required="required" :placeholder="translations.answer"
                               :value="answer"
                               @change="e => questions[index].answers[answerIndex] = e.target.value"
                               :id="`data-question-${index}-question-answer-${answerIndex}`"
                               class="form-control mw-100">
                        <button
                            type="button"
                            @click="() => removeQuestionAnswer(index, answerIndex)"
                            data-controller="button"
                            class="btn btn-danger ms-2 text-center"
                            style="min-width: 150px;"
                            :data-turbo="true">
                            {{ actionsTranslations.remove_answer }}
                        </button>
                    </div>
                </div>

                <div class="d-flex flex-row my-2 justify-content-end align-items-center">
                    <button
                        type="button"
                        @click="() => addAnswer(index)"
                        data-controller="button"
                        class="btn btn-success me-2"
                        :data-turbo="true">
                        {{ actionsTranslations.add_answer }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'TextMultiply',
    props: {
        translations: {
            type: Object,
            default: () => ({})
        },
        actionsTranslations: {
            type: Object,
            default: () => ({})
        },
        dataQuestions: {
            type: Array,
            default: null
        }
    },
    data: () => ({
        questions: []
    }),
    mounted() {
        if (this.dataQuestions) {
            this.questions = this.dataQuestions
        }
    },
    methods: {
        pushQuestion() {
            this.questions.push({
                question: '',
                answers: ['']
            })
        },
        addAnswer(index) {
            this.questions[index].answers.push('')
        },
        removeQuestion(index) {
            this.questions.splice(index, 1)
        },
        removeQuestionAnswer(qIndex, aIndex) {
            this.questions[qIndex].answers.splice(aIndex, 1)
        }
    }
}
</script>
