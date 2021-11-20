<template>
    <div ref="domWrapper">
        <slot></slot>
    </div>
</template>

<script>

import {createSelectNode} from '../../../helpers';

export default {
    name: 'TextInsert',
    props: {
        vHtml: {
            type: String,
            default: null
        },
        selectedWords: {
            type: Array|Object,
            default: () => []
        },
        words: {
            type: Array,
            default: () => []
        }
    },
    computed: {
        cardNode() {
            return this.$refs.domWrapper.querySelector('.bg-white')
        },
        quillInput() {
            return this.$refs.domWrapper.querySelector('input[name="data[text]"]')
        }
    },
    mounted() {
        if (this.selectedWords) {
            const keys = Object.keys(this.selectedWords)
            for (let i = 0; i < keys.length; i++) {
                const id = keys[i].replace('#', '')
                const value = Number(this.selectedWords[keys[i]])
                this.cardNode.appendChild(createSelectNode(id, this.words, 'id', 'word', value))
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
                this.cardNode.appendChild(createSelectNode(id, this.words, 'id', 'word'))
            }
        }
    }
}
</script>

<style lang="scss">
span.select2-container, input.select2-search__field {
    max-width: 100% !important;
}
</style>
