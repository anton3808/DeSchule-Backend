<template>
    <div ref="domWrapper" v-if="dom" v-html="dom"></div>
</template>

<script>
import LessonElementDataType from "./LessonElementDataType";

export default {
    name: "TextInsert",
    mixins: [LessonElementDataType],
    computed: {
        cardNode() {
            return this.$refs.domWrapper.querySelector('.bg-white')
        },
        quillInput() {
            return this.$refs.domWrapper.querySelector('input[name="data[text]"]')
        }
    },
    mounted() {
        const {selected_words} = this.data
        if (selected_words) {
            const keys = Object.keys(selected_words)
            for (let i = 0; i < keys.length; i++) {
                this.cardNode.appendChild(this.createSelectNode(keys[i].replace('#', ''), Number(selected_words[keys[i]])))
            }
        }

        if (this.quillInput) {
            this.quillInput.addEventListener('change', event => {
                const value = event.target.value
                const regexp = /(#\d+)/g
                const ids = value.match(regexp) || []
                if (ids.length) {
                    this.removeUnusedNodes(ids)
                    for (let i = 0; i < ids.length; i++) {
                        this.processSelectNode(ids[i].replace('#', ''))
                    }
                } else {
                    this.cardNode.querySelectorAll(`select[id^=data-word-select]`).forEach(select => {
                        select.parentNode.parentNode.remove()
                    })
                }
            })
        }
    },
    methods: {
        removeUnusedNodes(ids) {
            const selects = this.cardNode.querySelectorAll(`select[id^=data-word-select]`)
            for (let s = 0; s < selects.length; s++) {
                for (let i = 0; i < ids.length; i++) {
                    const id = '#' + selects[s].getAttribute('id').replace('data-word-select-', '')
                    if (!ids.includes(id)) {
                        selects[s].parentNode.parentNode.remove()
                    }
                }
            }
        },
        processSelectNode(id) {
            if (!this.cardNode.querySelector(`select#data-word-select-${id}`)) {
                this.cardNode.appendChild(this.createSelectNode(id))
            }
        },
        createSelectNode(id, value = null) {
            const formGroupDiv = document.createElement('div')
            formGroupDiv.setAttribute('class', 'form-group')

            const label = document.createElement('label')
            label.setAttribute('class', 'form-label')
            label.innerHTML = `#${id}`
            formGroupDiv.appendChild(label)

            const selectWrapperDiv = document.createElement('div')
            selectWrapperDiv.setAttribute('data-controller', 'select')

            const select = document.createElement('select')
            select.setAttribute('class', 'form-control')
            select.setAttribute('required', 'required')
            select.setAttribute('id', `data-word-select-${id}`)
            select.setAttribute('name', `data[words][#${id}]`)

            const option = document.createElement('option')
            select.appendChild(option)
            if (this.data.words) {
                for (let i = 0; i < this.data.words.length; i++) {
                    const option = document.createElement('option')
                    option.setAttribute('value', this.data.words[i].id)
                    option.innerHTML = this.data.words[i].word
                    if (value && this.data.words[i].id === value) {
                        option.setAttribute('selected', 'selected')
                    }
                    select.appendChild(option)
                }
            }

            selectWrapperDiv.appendChild(select)
            formGroupDiv.appendChild(selectWrapperDiv)

            return formGroupDiv
        }
    }
}
</script>

<style lang="scss">
span.select2-container, input.select2-search__field {
    max-width: 100% !important;
}
</style>
