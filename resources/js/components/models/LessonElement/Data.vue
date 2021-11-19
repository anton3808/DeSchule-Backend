<template>
    <div v-if="template">
        <component v-if="template.component" :is="template.component" :data="template.data" :dom="template.dom"/>
        <div v-else v-html="template"></div>
    </div>
</template>

<script>
import TextInsert from "./TextInsert";

export default {
    name: "Data",
    components: {TextInsert},
    data: () => ({
        selectedType: null,
        template: null
    }),
    watch: {
        selectedType() {
            this.getTemplateView(this.selectedType)
        }
    },
    props: {
        typeSelectId: {
            type: String,
            required: true,
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
    mounted() {
        // костыль от дубликации select элементов
        if (document.getElementById(this.typeSelectId).nextSibling) {
            document.getElementById(this.typeSelectId).nextSibling.remove()
        }

        this.selectedType = Number(document.getElementById(this.typeSelectId).value)
        document.getElementById(this.typeSelectId).onchange = e => {
            this.selectedType = Number(e.target.value)
        }
    },
    methods: {
        getTemplateView(type) {
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
