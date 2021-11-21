<template>
    <div v-if="template">
        <div v-if="!template.component" v-html="template"></div>
        <div v-else id="lesson-element-data">
            <div v-html="template.vHtml"></div>
            <component :is="template.component" v-bind="template.attributes"/>
        </div>
    </div>
</template>

<script>
import TextInsert from "./components/TextInsert";
import TextMultiply from "./components/TextMultiply";

export default {
    name: 'Data',
    props: ['template'],
    components: {TextInsert, TextMultiply}
}
</script>
