<template>
    <div ref="lessonElementWrapper">
        <slot></slot>

        <lesson-element-data :template="template"/>
    </div>
</template>

<script>
import LessonElementData from './Data'

export default {
    name: "Edit",
    components: {LessonElementData},
    props: {
        typeSelectId: {
            type: String,
            required: true
        },
        url: {
            type: String,
            required: true
        },
        id: {
            type: String | Number,
            default: null
        }
    },
    data: () => ({
        selectedType: null,
        template: null
    }),
    watch: {
        selectedType() {
            this.getTemplateView(this.selectedType)
        }
    },
    mounted() {
        // костыль от дубликации select элементов
        if (document.getElementById(this.typeSelectId).nextSibling) {
            document.getElementById(this.typeSelectId).nextSibling.remove()
        }

        this.selectedType = document.getElementById(this.typeSelectId).value

        document.getElementById(this.typeSelectId).onchange =e => {
            const type = e.target.value
            if (this.typeSelectId !== type) {
                this.selectedType = type
            }
        }
    },
    methods: {
        getTemplateView(type) {
            this.template = null

            let url = `${this.url}?type=${type}`
            if (this.id && Number(this.id)) {
                url = `${url}&id=${this.id}`
            }

            window.axios.get(url).then(({data}) => {
                this.template = data
            })
        }
    }
}
</script>
